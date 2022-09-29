<?php
  # 2004-01-31 Added cosmetic support for heading tags (<H*>...</H*>)
  # 2004-01-20 Fixxxed a HUGE bug that didn't aligin the sentences with their resp. stats ^^;
  # 2004-01-20 Also fixed a minor bug in link to stats collection and some code cleanup
  # 2003-12-02 Added better handling of file change and more and better comments :-)

  # function for database management
  require("./common/connect2db.inc");
  require("./common/filefunctions.inc");

  # These sets the path to default to svenska if nothing else is given
  if(!$HTTP_GET_VARS["language"]) { $HTTP_GET_VARS["language"] = "svenska"; }

  # Class for template management
  require("./classes/class.FastTemplate.php");
  # The argument to the constructor is the path to where the templates are stored
  if (file_exists("templates/".$HTTP_GET_VARS["language"]."/")) {
    $tpl = new FastTemplate("templates/".$HTTP_GET_VARS["language"]."/");
  } else {
    $tpl = new FastTemplate("templates/svenska/");
  }

  # Define templates
  $tpl->define(array(kthxc_admin_sum_show=>"xc_admin_sum_show.tpl",
                     kthxc_admin_file_show=>"xc_admin_file_show.tpl",
                     kthxc_admin_see_show=>"xc_admin_see_show.tpl",
                     linklist_head=>"xc_admin_sum_linklist_head.tpl",
                     linklist_row=>"xc_admin_sum_linklist_row.tpl",
                     linklist_foot=>"xc_admin_sum_linklist_foot.tpl",
                     kthxc_admin_sum_changed=>"xc_admin_sum_changed.tpl",
                     kthxc_admin_sum_eval=>"xc_admin_sum_eval.tpl",
                     kthxc_admin_sum_evalres=>"xc_admin_sum_evalres.tpl",
                     kthxc_admin_sum_index=>"xc_admin_sum_index.tpl"));

  $path = "corpus"; # This is where the texts should reside in a separate folder
                    # for each language and texttype

  # This section generates the ideal summary, given FileID and summary size (optional)
  if($HTTP_GET_VARS["fileid"]) {
    if(!$HTTP_GET_VARS["cutoff"]) { $HTTP_GET_VARS["cutoff"]="100"; }
    list($sentences,$extracts,$sumstatsarray,$baseline1array,$baseline2array,$baseline3array,
         $nrofsums,$shortest,$longest,$totsumlen,$metainfo,$filechanged) = read_specific_file($path,$HTTP_GET_VARS["fileid"]);

    #foreach($sumstatsarray as $value) { print ($value?$value:0).","; } print "<br>\n";
    if($sentences[0] == "") {
      array_shift($sentences);
      $fileidarr = preg_split("/->/",$HTTP_GET_VARS["fileid"]);
      if($fileidarr[1] != "nyhetstexter") {
        array_shift($sumstatsarray);
        array_shift($baseline1array);
        array_shift($baseline2array);
        array_shift($baseline3array);
      }
    }

    if($filechanged) { $tpl->parse(FILECHANGEWARNING, kthxc_admin_sum_changed); }

    if($HTTP_GET_VARS["baseline"] == "1") {
      $statsarray = $baseline1array;
      $tpl->assign(BASELINE, "baseline=1&");
      $tpl->assign(MODE, "Baseline_1");
    }
    else if($HTTP_GET_VARS["baseline"] == "2") {
      $statsarray = $baseline2array;
      $tpl->assign(BASELINE, "baseline=2&");
      $tpl->assign(MODE, "Baseline_2");
    }
    else if($HTTP_GET_VARS["baseline"] == "3") {
      $statsarray = $baseline3array;
      $tpl->assign(BASELINE, "baseline=3&");
      $tpl->assign(MODE, "Baseline_3");
    }
    else {
      $statsarray = $sumstatsarray;
      $tpl->assign(MODE, "Ideal");
    }

    # Calculate total number of words & votes
    #$totvotes = $totalnrofwords = 0;
    while(list($key,$sentence) = each($sentences)) {
      $totalnrofwords += count(preg_split("/\s/",$sentence));
      $totvotes += $statsarray[$key];
    }

    $sumnrofwords = 0;
    $cutoff = ($HTTP_GET_VARS["cutoff"]/100) * $totalnrofwords;
    arsort($statsarray,SORT_NUMERIC);
    reset($statsarray);
    while((list($key,$val) = each($statsarray)) && $sumnrofwords <= $cutoff+1) {
      $sentnrofwords = count(preg_split("/\s/",$sentences[$key]));
      $sumnrofwords += $sentnrofwords;
      $summarray[$key] = $val;
    }
    if($HTTP_GET_VARS["cutoff"] != 100) {
      unset($summarray[$key]);
      $sumnrofwords -= $sentnrofwords;
    }
    $tpl->assign(SUMNROFWORDS, $sumnrofwords);
    $tpl->assign(TOTALNROFWORDS, $totalnrofwords);

    $texttable = "";
    ksort($summarray);
    foreach($summarray as $key=>$val) {
      $sentence = $sentences[$key];
      if($sentence == "") {
        $texttable .= "<BR>\n";
        $dif++;
      } else {
        if(preg_match("/^(<H.*?>)(.*)(<\/H.*?>)$/i",$sentence,$matches)) {
          $lead = "<B>".($key)."</B>[";
          $lead .= $statsarray[$key] ? $statsarray[$key] : 0;
          $texttable .= "$matches[1]$lead]&nbsp;$matches[2]$matches[3]\n";
        } else {
          $texttable .= "<B>".($key)."</B>[";
          $texttable .= $statsarray[$key] ? $statsarray[$key] : 0;
          $texttable .= "]&nbsp;$sentence<BR>\n";
        }
        $baseline1votes += $baseline1array[$key];
        $baseline2votes += $baseline2array[$key];
        $baseline3votes += $baseline3array[$key];
        $votescovered += $sumstatsarray[$key];
        $nrofsentences++;
      }
    }
#    print "Total number of votes: $totvotes<BR>";
#    print "Total number of votes covered: $votescovered;<BR>";
#    print "Total number of votes B1: $baseline1votes;<BR>";
#    print "Total number of votes B2: $baseline2votes;<BR>";
#    print "Total number of votes B3: $baseline3votes;<BR>";
#    print "Total number of sentences: $nrofsentences<BR>";

    $fileidarr = preg_split("/->/",$HTTP_GET_VARS["fileid"]);
    $language = $fileidarr[0];
    $texttype = $fileidarr[1];
    $textfile = $fileidarr[2];
    $tpl->assign(FILEPATH, $path."/".$language."/".$texttype."/".$textfile);

    if($nrofsums) { $tpl->assign(MEANSUMMARY, round($totsumlen/$nrofsums)); }
    else { $tpl->assign(MEANSUMMARY, 0); }

    $tpl->assign(SHORTESTSUMMARY, $shortest);
    $tpl->assign(LONGESTSUMMARY, $longest);
    $tpl->assign(NROFSUMMARIES, $nrofsums);
    $tpl->assign(FILEID, $HTTP_GET_VARS["fileid"]);
    $tpl->assign(SUMMARYDEGREE, round(($sumnrofwords/$totalnrofwords)*100));
    if($nrofsums) {
      $tpl->assign(BASELINE1PRECISION, round(($baseline1votes/($nrofsentences*$nrofsums))*100));
      $tpl->assign(BASELINE2PRECISION, round(($baseline2votes/($nrofsentences*$nrofsums))*100));
      $tpl->assign(BASELINE3PRECISION, round(($baseline3votes/($nrofsentences*$nrofsums))*100));
      $tpl->assign(VOTEPRECISION, round(($votescovered/($nrofsentences*$nrofsums))*100));
    } else {
      $tpl->assign(BASELINE1PRECISION, 0);
      $tpl->assign(BASELINE2PRECISION, 0);
      $tpl->assign(BASELINE3PRECISION, 0);
      $tpl->assign(VOTEPRECISION, 0);
    }
    if($totvotes) {
      $tpl->assign(BASELINE1RECALL, round(($baseline1votes/$totvotes)*100));
      $tpl->assign(BASELINE2RECALL, round(($baseline2votes/$totvotes)*100));
      $tpl->assign(BASELINE3RECALL, round(($baseline3votes/$totvotes)*100));
      $tpl->assign(VOTERECALL, round(($votescovered/$totvotes)*100));
    } else {
      $tpl->assign(BASELINE1RECALL, 0);
      $tpl->assign(BASELINE2RECALL, 0);
      $tpl->assign(BASELINE3RECALL, 0);
      $tpl->assign(VOTERECALL, 0);
    }
    $tpl->assign(LANGUAGE, $language);
    $tpl->assign(TEXTTYPE, $texttype);
    $tpl->assign(TEXTTABLE, $texttable);
    $tpl->parse(TEXTTABLE, kthxc_admin_sum_show);

  # This section recreates all submitted extracts/summaries for the current text
  } else if($HTTP_GET_VARS["viewsums"]) {
    if(!$HTTP_GET_VARS["cutoff"]) { $HTTP_GET_VARS["cutoff"]="100"; }
    $cutoff = $HTTP_GET_VARS["cutoff"];
    list($sentences,$extracts,$sumstatsarray,$baseline1array,$baseline2array,$baseline3array,
         $nrofsums,$shortest,$longest,$totsumlen,$metainfo,$filechanged) = read_specific_file($path,$HTTP_GET_VARS["viewsums"]);

    $shifted = false;
    if($sentences[0] == "") {
      $fileidarr = preg_split("/->/",$HTTP_GET_VARS["viewsums"]);
      if($fileidarr[1] == "nyhetstexter") {
        array_shift($sentences);
      }
      $shifted = true;
    }
    #foreach($sumstatsarray as $value) { print ($value?$value:0).","; } print "<br>\n";

    $extracts_array = preg_split("/\|/",$extracts);
    foreach($extracts_array as $extract) {
      list($userid,$extract) = preg_split("/\_/",$extract);
      $all_sums .= "<BR><I>Sammanfattning nr: " . ++$xnr . "</I> ($userid)<BR>";

      $extract_array  = preg_split("//",$extract);
      if($shifted) {
        array_shift($extract_array);
      }
      #foreach($extract_array as $value) { print ($value?$value:0).","; } print "<br>\n";
      $othersum = "";
      $all_sums .= "$extract<br>\n";
      $sentence_number = 0;
      foreach($sentences as $sentence) {
        if($extract_array[$sentence_number]) {
          $all_sums .= $sentence."<br>\n";
          $othersum .= $sentence."<br>\n";
        }
        $sentence_number++;
      }

      list($sentenceoverlap,$boolwordoverlap,$freqwordoverlap,
           $booltwordoverlap,$freqtwordoverlap) = compare_sums($sentences,$sumstatsarray,$othersum,$cutoff);
      $all_sums .= "Sentence overlap: $sentenceoverlap<br>\n";
      $all_sums .= "Bool voc overlap: $boolwordoverlap<br>\n";
      $all_sums .= "Freq voc overlap: $freqwordoverlap<br>\n";
      if($sentenceoverlap > $highest_so) {
        $highest_so = $sentenceoverlap;
        $sentenceoverlap_sum = "<BR><I>Sammanfattning nr: " . $xnr . "</I> ($userid)<BR>$othersum";
      }
      if($boolwordoverlap > $highest_bwo) {
        $highest_bwo = $boolwordoverlap;
        $boolwordoverlap_sum = "<BR><I>Sammanfattning nr: " . $xnr . "</I> ($userid)<BR>$othersum";
      }
      if($freqwordoverlap > $highest_fwo) {
        $highest_fwo = $freqwordoverlap;
        $freqwordoverlap_sum = "<BR><I>Sammanfattning nr: " . $xnr . "</I> ($userid)<BR>$othersum";
      }
    }
    echo "$sentenceoverlap_sum";
    echo "<br><I>Sentence overlap: $highest_so% compared to an ideal summary of $cutoff% of original text</I><br>\n";
    echo "<br><hr>$boolwordoverlap_sum";
    echo "<br><I>Boolean vocabulary overlap: $highest_bwo% compared to an ideal summary of $cutoff% of original text</I><br>\n";
    echo "<br><hr>$freqwordoverlap_sum";
    echo "<br><I>Frequency weighted vocabulary overlap: $highest_fwo% compared to an ideal summary of $cutoff% of original text</I><br>\n";
    echo "<br><hr><hr>$all_sums<br>\n";
    exit;

  # This section generates the ideal summary and the evaluation form
  } else if($HTTP_GET_VARS["evalsum"]) {
    if(!$HTTP_GET_VARS["cutoff"]) { $HTTP_GET_VARS["cutoff"]="100"; }
    list($sentences,$extracts,$sumstatsarray,$baseline1array,$baseline2array,$baseline3array,
         $nrofsums,$shortest,$longest,$totsumlen) = read_specific_file($path,$HTTP_GET_VARS["evalsum"]);

    #foreach($sumstatsarray as $value) { print "$value"; } print "<br>\n";
    if($sentences[0] == "") {
      array_shift($sentences);
      $fileidarr = preg_split("/->/",$HTTP_GET_VARS["evalsum"]);
      if($fileidarr[1] != "nyhetstexter") {
        array_shift($sumstatsarray);
        array_shift($baseline1array);
        array_shift($baseline2array);
        array_shift($baseline3array);
      }
    }

    if($HTTP_GET_VARS["baseline"] == "1") {
      $statsarray = $baseline1array;
    }
    else if($HTTP_GET_VARS["baseline"] == "2") {
      $statsarray = $baseline2array;
    }
    else if($HTTP_GET_VARS["baseline"] == "3") {
      $statsarray = $baseline3array;
    }
    else {
      $statsarray = $sumstatsarray;
    }

    $fileidarr = preg_split("/->/",$HTTP_GET_VARS["evalsum"]);
    $language = $fileidarr[0];
    $texttype = $fileidarr[1];
    $textfile = $fileidarr[2];
    #preg_match("/(.*?)\./",$textfile,$matches);

    $totalnrofwords = 0;
    foreach($sentences as $sentence) {
      $totalnrofwords += count(preg_split("/\s/",$sentence));
    }

    $sumnrofwords = 0;
    $cutoff = ($HTTP_GET_VARS["cutoff"]/100) * $totalnrofwords;
    arsort($statsarray,SORT_NUMERIC);
    reset($statsarray);
    while((list($key,$val) = each($statsarray)) && $sumnrofwords <= $cutoff+1) {
      $sentnrofwords = count(preg_split("/\s/",$sentences[$key]));
      $sumnrofwords += $sentnrofwords;
      $summarray[$key] = $val;
    }
    if($HTTP_GET_VARS["cutoff"] != 100) {
      unset($summarray[$key]);
      $sumnrofwords -= $sentnrofwords;
    }

    ksort($summarray);
    foreach($summarray as $key=>$foo) {
      $sentence = $sentences[$key];
      if($sentence) {
        $idx++;
        $idealsum .= "$sentence<br>\n";
        # Collect words for vocabulary match
        $sentence = preg_replace(array("/<.*?>/","/\\\/"),"",$sentence);
        $vocabarr = preg_split("/[^a-zA-ZÂ‰ˆ≈ƒ÷0-9]/",$sentence);
        foreach($vocabarr as $value) {
          $idealvoc[$value]++;
          $idealvoct[substr($value,0,5)]++;
        }
        # Collect normalized sentence for sentence match
        $sentencen = preg_replace("/\W/","",$sentence);
        $idealarr[$sentencen] = $sentence;
      }
    }

    if($_POST["summary"]) {
      $summarr = preg_split("/\n/",$_POST["summary"]);
      foreach($summarr as $value) {
        $systemsum .= "$value<br>\n";
        # Collect words for vocabulary match
        $valuet = preg_replace(array("/<.*?>/","/\\\/"),"",$value);
        $vocabarr = preg_split("/[^a-zA-ZÂ‰ˆ≈ƒ÷0-9]/",$valuet);
        foreach($vocabarr as $word) {
          $gsumvoc[$word]++;
          $gsumvoct[substr($word,0,5)]++;
        }
        # Calculate normalized sentence overlap
        $sentence = preg_replace("/\W/","",$valuet);
        if($sentence) {
          $sidx++;
          if($idealarr[$sentence]) {
            $sent_overlap++;
            unset($idealarr[$sentence]);
          } else {
            $sumnotinideal .= "$value<BR />\n";
          }
        }
      }
      $overlap = ($sent_overlap / (($idx+$sidx)/2)) * 100;
      $tpl->assign(SENTENCEOVERLAP, $overlap);

      # Calculate vocabulary overlap
      foreach($gsumvoc as $word=>$freq) {
        if($idealvoc[$word]) {
          $binw_overlap++;
        }
        if($idealvoc[$word] < $gsumvoc[$word]) {
          $frqw_overlap += ($idealvoc[$word]/$gsumvoc[$word]);
        } else {
          $frqw_overlap += ($gsumvoc[$word]/$idealvoc[$word]);
        }
      }
      $overlap = ($binw_overlap / ((count($gsumvoc)+count($idealvoc))/2)) * 100;
      $tpl->assign(BOOLWORDOVERLAP, $overlap);
      $overlap = ($frqw_overlap / ((count($gsumvoc)+count($idealvoc))/2)) * 100;
      $tpl->assign(FREQWORDOVERLAP, $overlap);

      # Calculate trunkated vocabulary overlap
      foreach($gsumvoct as $word=>$freq) {
        if($idealvoct[$word]) {
          $binwt_overlap++;
        }
        if($idealvoct[$word] < $gsumvoct[$word]) {
          $frqwt_overlap += ($idealvoct[$word]/$gsumvoct[$word]);
        } else {
          $frqwt_overlap += ($gsumvoct[$word]/$idealvoct[$word]);
        }
      }
      $overlap = ($binwt_overlap / ((count($gsumvoct)+count($idealvoct))/2)) * 100;
      $tpl->assign(BOOLTWORDOVERLAP, $overlap);
      $overlap = ($frqwt_overlap / ((count($gsumvoct)+count($idealvoct))/2)) * 100;
      $tpl->assign(FREQTWORDOVERLAP, $overlap);

      foreach($idealarr as $key=>$value) {
        $idealnotinsum .= "$value<BR />\n";
      }

      $tpl->assign(FILEID, $HTTP_GET_VARS["evalsum"]);
      $tpl->assign(IDEALNOTINSUM, $idealnotinsum);
      $tpl->assign(SUMNOTINIDEAL, $sumnotinideal);
      $tpl->assign(IDEALSUMMARY, $idealsum);
      $tpl->assign(SYSTEMSUMMARY, $systemsum);
      $tpl->parse(SYSTEMSUMMARY, kthxc_admin_sum_evalres);
    } else {
      $textarea = "<TABLE border=1>\n<TD>\n$idealsum</TD>\n</TABLE>\n";
      $tpl->assign(SUMMARYDEGREE, $HTTP_GET_VARS["cutoff"]);
      $tpl->assign(FILEID, $HTTP_GET_VARS["evalsum"]);
      $tpl->assign(IDEALSUM, $textarea);
      $tpl->parse(IDEALSUM, kthxc_admin_sum_eval);
    }

  # This section generates the two representations of the original text (textarea and link)
  } else if($HTTP_GET_VARS["viewfile"]) {
    $fileidarr = preg_split("/->/",$HTTP_GET_VARS["viewfile"]);
    $language = $fileidarr[0];
    $texttype = $fileidarr[1];
    $textfile = $fileidarr[2];
    if($handle = fopen($path."/".$language."/".$texttype."/".$textfile, "r")) {
      $contents = fread($handle, filesize($path."/".$language."/".$texttype."/".$textfile));
      fclose($handle);
    }

    if($HTTP_GET_VARS["mode"] == "link") { echo $contents; exit; }

    $textarea = "<TEXTAREA rows='30' cols='60'>$contents</TEXTAREA>";
    $tpl->assign(FILEID, $HTTP_GET_VARS["viewfile"]);
    $tpl->assign(TEXTAREA, $textarea);
    $tpl->parse(TEXTAREA, kthxc_admin_file_show);

  # This section generates the SEE formatted version of the ideal summary
  } else if($HTTP_GET_VARS["viewsee"]) {
    if(!$HTTP_GET_VARS["cutoff"]) { $HTTP_GET_VARS["cutoff"]="100"; }
    list($sentences,$extracts,$sumstatsarray,$baseline1array,$baseline2array,$baseline3array,
         $nrofsums,$shortest,$longest,$totsumlen) = read_specific_file($path,$HTTP_GET_VARS["viewsee"]);

    #foreach($sumstatsarray as $value) { print "$value"; } print "<br>\n";
    if($sentences[0] == "") {
      array_shift($sentences);
      $fileidarr = preg_split("/->/",$HTTP_GET_VARS["fileid"]);
      if($fileidarr[1] != "nyhetstexter") {
        array_shift($sumstatsarray);
        array_shift($baseline1array);
        array_shift($baseline2array);
        array_shift($baseline3array);
      }
    }

    if($HTTP_GET_VARS["baseline"] == "1") {
      $statsarray = $baseline1array;
    }
    else if($HTTP_GET_VARS["baseline"] == "2") {
      $statsarray = $baseline2array;
    }
    else if($HTTP_GET_VARS["baseline"] == "3") {
      $statsarray = $baseline3array;
    }
    else {
      $statsarray = $sumstatsarray;
    }

    $fileidarr = preg_split("/->/",$HTTP_GET_VARS["viewsee"]);
    $language = $fileidarr[0];
    $texttype = $fileidarr[1];
    $textfile = $fileidarr[2];
    preg_match("/(.*?)\./",$textfile,$matches);

    $totalnrofwords = 0;
    foreach($sentences as $sentence) {
      $totalnrofwords += count(preg_split("/\s/",$sentence));
    }

    $sumnrofwords = 0;
    $cutoff = ($HTTP_GET_VARS["cutoff"]/100) * $totalnrofwords;
    arsort($statsarray,SORT_NUMERIC);
    reset($statsarray);
    while((list($key,$val) = each($statsarray)) && $sumnrofwords <= $cutoff+1) {
      $sentnrofwords = count(preg_split("/\s/",$sentences[$key]));
      $sumnrofwords += $sentnrofwords;
      $summarray[$key] = $val;
    }
    if($HTTP_GET_VARS["cutoff"] != 100) {
      unset($summarray[$key]);
      $sumnrofwords -= $sentnrofwords;
    }

    $seefile = "<html>\n<head>\n<title>".$HTTP_GET_VARS["viewsee"]." : ".$HTTP_GET_VARS["cutoff"]."%</title>\n</head>\n<body>\n";
    ksort($summarray);
    foreach($summarray as $key=>$val) {
      $sentence = $sentences[$key];
      if($sentence) {
        $seefile .= "<a name=\"$matches[0]".($key)."\">[$matches[0]".($key)."]</a> <a href=\"#$matches[0]".($key)."\" id=$matches[0]".($key).">$sentence</a>\n";
      }
    }
    $seefile .= "</body>\n</html>\n";

    if($HTTP_GET_VARS["mode"] == "link") { echo $seefile; exit; }

    $textarea = "<TEXTAREA rows='30' cols='60'>$seefile</TEXTAREA>";
    $tpl->assign(SUMMARYDEGREE, $HTTP_GET_VARS["cutoff"]);
    $tpl->assign(FILEID, $HTTP_GET_VARS["viewsee"]);
    $tpl->assign(TEXTAREA, $textarea);
    $tpl->parse(TEXTAREA, kthxc_admin_see_show);

  # This section generates the navigation bar, the standard way of navigation
  } else {
    $tpl = generate_navbar($tpl,$path,$HTTP_GET_VARS["language"],$HTTP_GET_VARS["texttype"],FALSE);
    # This section, optionally, generates a list of links for easier navigation
    if($HTTP_GET_VARS["mode"] == "indexlinklist") {
      $tpl = generate_linklist($tpl,$path,$HTTP_GET_VARS["language"],$HTTP_GET_VARS["texttype"],FALSE);
    }
    $tpl->assign(LANGUAGE, $HTTP_GET_VARS["language"]);
    $tpl->assign(TEXTTYPE, $HTTP_GET_VARS["texttype"]);
    $tpl->parse(LINKLIST, kthxc_admin_sum_index);
  }

  $tpl->Fastprint();


  # This function generates the ideal summary and compares it to the supplied one
  function compare_sums($sentences,$statsarray,$othersum,$cutoff) {
    $totalnrofwords = 0;
    foreach($sentences as $sentence) {
      $totalnrofwords += count(preg_split("/\s/",$sentence));
    }

    $sumnrofwords = 0;
    $cutoff = ($cutoff/100) * $totalnrofwords;
    arsort($statsarray,SORT_NUMERIC);
    reset($statsarray);
    while((list($key,$val) = each($statsarray)) && $sumnrofwords <= $cutoff+1) {
      $sentnrofwords = count(preg_split("/\s/",$sentences[$key]));
      $sumnrofwords += $sentnrofwords;
      $summarray[$key] = $val;
    }
    if($HTTP_GET_VARS["cutoff"] != 100) {
      unset($summarray[$key]);
      $sumnrofwords -= $sentnrofwords;
    }

    ksort($summarray);
    foreach($summarray as $key=>$foo) {
      $sentence = $sentences[$key];
      if($sentence) {
        $idx++;
        # Collect words for vocabulary match
        $sentence = preg_replace(array("/<.*?>/","/\\\/"),"",$sentence);
        $vocabarr = preg_split("/[^a-zA-ZÂ‰ˆ≈ƒ÷0-9]/",$sentence);
        foreach($vocabarr as $value) {
          $idealvoc[$value]++;
          $idealvoct[substr($value,0,5)]++;
        }
        # Collect normalized sentence for sentence match
        $sentencen = preg_replace("/\W/","",$sentence);
        $idealarr[$sentencen] = $sentence;
      }
    }

    $summarr = preg_split("/\n/",$othersum);
    foreach($summarr as $value) {
      $systemsum .= "$value<br>\n";
      # Collect words for vocabulary match
      $valuet = preg_replace(array("/<.*?>/","/\\\/"),"",$value);
      $vocabarr = preg_split("/[^a-zA-ZÂ‰ˆ≈ƒ÷0-9]/",$valuet);
      foreach($vocabarr as $word) {
        $gsumvoc[$word]++;
        $gsumvoct[substr($word,0,5)]++;
      }
      # Calculate normalized sentence overlap
      $sentence = preg_replace("/\W/","",$valuet);
      if($sentence) {
        $sidx++;
        if($idealarr[$sentence]) {
          $sent_overlap++;
          unset($idealarr[$sentence]);
        } else {
          $sumnotinideal .= "$value<BR />\n";
        }
      }
    }
    $sentenceoverlap = ($sent_overlap / (($idx+$sidx)/2)) * 100;

    # Calculate vocabulary overlap
    foreach($gsumvoc as $word=>$freq) {
      if($idealvoc[$word]) {
        $binw_overlap++;
      }
      if($idealvoc[$word] < $gsumvoc[$word]) {
        $frqw_overlap += ($idealvoc[$word]/$gsumvoc[$word]);
      } else {
        $frqw_overlap += ($gsumvoc[$word]/$idealvoc[$word]);
      }
    }
    $boolwordoverlap = ($binw_overlap / ((count($gsumvoc)+count($idealvoc))/2)) * 100;
    $freqwordoverlap = ($frqw_overlap / ((count($gsumvoc)+count($idealvoc))/2)) * 100;

    # Calculate trunkated vocabulary overlap
    foreach($gsumvoct as $word=>$freq) {
      if($idealvoct[$word]) {
        $binwt_overlap++;
      }
      if($idealvoct[$word] < $gsumvoct[$word]) {
        $frqwt_overlap += ($idealvoct[$word]/$gsumvoct[$word]);
      } else {
        $frqwt_overlap += ($gsumvoct[$word]/$idealvoct[$word]);
      }
    }
    $booltwordoverlap = ($binwt_overlap / ((count($gsumvoct)+count($idealvoct))/2)) * 100;
    $freqtwordoverlap = ($frqwt_overlap / ((count($gsumvoct)+count($idealvoct))/2)) * 100;

    foreach($idealarr as $key=>$value) {
      $idealnotinsum .= "$value<BR />\n";
    }

    return array ($sentenceoverlap,$boolwordoverlap,$freqwordoverlap,$booltwordoverlap,$freqtwordoverlap);
  }
?>
