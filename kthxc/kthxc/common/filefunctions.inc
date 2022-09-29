<?php
# 2003-12-05 Added touch_files() for easy DB managment
# 2003-12-05 Added more robustness (handling of division by zero in several places)
# 2003-12-04 Fixed counting of total number of summaries when not all files have summaries yet
# 2003-12-02 Added better handling of file change and more and better comments :-)

require_once("./common/connect2db.inc");
require_once("./common/iphostfunctions.inc");

### File functions ########################################################
function generate_linklist($tpl,$path,$current_language,$current_texttype,$reset) {
  $db = connect2db();
  list($languages,$texttypes,$textfiles) = read_corpusstructure($path);
  # Level 3. Text files level (one file for each text available for respective texttype)
  if($current_language && $current_texttype != "dummy") {
    asort($textfiles[$current_language][$current_texttype]);
    foreach($textfiles[$current_language][$current_texttype] as $foo=>$textfile) {
      $tpl->assign(FILECALL,"showsumstats.php?fileid=".$current_language."->".$current_texttype."->".$textfile);
      $tpl->assign(FILENAME,$textfile);
      $result = pg_query($db,"SELECT * FROM xc_textstats WHERE fileid='".$current_language."->".$current_texttype."->".$textfile."'");
      if(!$result) { printf("Fel vid anrop av databasen, kontakta ansvarig för sidan!"); exit; }
      if(pg_num_rows($result) > 0) {
        $queryresult = pg_fetch_array($result,0);
        if($queryresult['totsums']) { $meansumlength = round($queryresult['totslen']/$queryresult['totsums']); }
        else { $meansumlength=0; }
        if($queryresult['abstract'] != "f") {
          $abstract = "*";
          $totabstracts++;
        } else { $abstract = ""; }
        if($queryresult['changed'] != "f")  {
          $changed = "*";
          $totchanged++;
        } else { $changed = ""; }
        $tpl->assign(TOTSUMS, $queryresult['totsums']);
        $tpl->assign(SHORTSUM, $queryresult['shortsum']);
        $tpl->assign(LONGSUM, $queryresult['longsum']);
        $tpl->assign(MEANSUMLENGTH, $meansumlength);
        list($precision_f,$recall) = calculate_overlap(101,$path,$current_language."->".$current_texttype."->".$textfile);
        $tpl->assign(PRECISION_F,$precision_f);
        list($precision,$recall) = calculate_overlap($meansumlength,$path,$current_language."->".$current_texttype."->".$textfile);
        $tpl->assign(PRECISION_ML,$precision);
        $tpl->assign(ABSTRACT, $abstract);
        $tpl->assign(CHANGED, $changed);
        if($reset) { $tpl->assign(ADDFIELD, "<INPUT type=\"checkbox\" name=\"resetid_".$current_language."->".$current_texttype."->".$textfile."\">\n"); }
        $tpl->parse(LLCONTENTS, ".linklist_row");
        $totsums  += $queryresult['totsums'];
        $totshort += $queryresult['shortsum'];
        $totlong  += $queryresult['longsum'];
        $totmean  += $meansumlength;
        $totprecision  += $precision;
        $totrecall  += $recall;
        $entries++;
      }
    }
    $tpl->assign(TOTSUMS,$totsums);
    if($entries) {
      $tpl->assign(SHORTSUM,round($totshort/$entries));
      $tpl->assign(LONGSUM,round($totlong/$entries));
      $tpl->assign(MEANSUMLENGTH,round($totmean/$entries));
    } else {
      $tpl->assign(SHORTSUM,"");
      $tpl->assign(LONGSUM,"");
      $tpl->assign(MEANSUMLENGTH,"");
    }
    if($entries > 0) {
      $tpl->assign(PRECISION_ML,round($totprecision/$entries));
      $tpl->assign(RECALL_ML,round($totrecall/$entries));
    }
    $tpl->assign(ABSTRACT,$totabstract);
    $tpl->assign(CHANGED,$totchanged);
    $tpl->parse(LLCONTENTS, ".linklist_foot");
  }
  $visibility = ' STYLE="visibility:hidden;"';
  $tpl->parse(LINKLIST, linklist_head);
  $tpl->assign(NAVBAR_VISIBILITY, $visibility);
  return $tpl;
}

function generate_navbar($tpl,$path,$current_language,$current_texttype,$reset) {
  $db = connect2db();
  list($languages,$texttypes,$textfiles) = read_corpusstructure($path);

  # Level 1. Language level (one directory for each language available in the corpus)
  if($reset)
    { $navbar .= "<SELECT name='languages' onChange=\"location.href='resetstats.php?language='+(languages.options[languages.selectedIndex].value);return false\">\n"; }
  else
    { $navbar .= "<SELECT name='languages' onChange=\"location.href='showsumstats.php?language='+(languages.options[languages.selectedIndex].value);return false\">\n"; }
  asort($languages);
  foreach($languages as $foo=>$language) {
    $navbar .= "  <OPTION value='$language'";
    if($current_language == $language) { $navbar .= " selected"; }
    $navbar .= ">$language </OPTION>\n";
  }
  $navbar .= "</SELECT>\n";

  # Level 2. Text type level (one directory for each texttype available for respective language)
  if($reset)
    { $navbar .= "<SELECT name='texttypes' onChange=\"location.href='resetstats.php?mode=indexlinklist&language='+(languages.options[languages.selectedIndex].value)+'&texttype='+(texttypes.options[texttypes.selectedIndex].value);return false\">\n"; }
  else
    { $navbar .= "<SELECT name='texttypes' onChange=\"location.href='showsumstats.php?language='+(languages.options[languages.selectedIndex].value)+'&texttype='+(texttypes.options[texttypes.selectedIndex].value);return false\">\n"; }
  if($current_language && $current_language != "dummy" && $texttypes[$current_language]) {
    $navbar .= "  <OPTION value='dummy'>------</OPTION>\n";
    asort($texttypes[$current_language]);
    foreach($texttypes[$current_language] as $foo=>$texttype) {
      $navbar .= "  <OPTION value='$texttype'";
      if($current_texttype == $texttype) { $navbar .= " selected"; }
      $navbar .= ">$texttype </OPTION>\n";
    }
  } else {
    $navbar .= "  <OPTION value='dummy' selected>------</OPTION>\n";
  }
  $navbar .= "</SELECT>\n";

  # Level 3. Text files level (one file for each text available for respective texttype)
  if(!$reset) {
    $navbar .= "<SELECT name='textfiles'>\n";
    if($current_texttype && $current_texttype != "dummy" && $textfiles[$current_language][$current_texttype]) {
      asort($textfiles[$current_language][$current_texttype]);
      foreach($textfiles[$current_language][$current_texttype] as $foo=>$textfile) {
        $navbar .= "  <OPTION value='$textfile'";
        if($HTTP_GET_VARS["file"] == $textfile) { $navbar .= " selected"; }
        $navbar .= ">$textfile ";
        $result = pg_query($db,"SELECT * FROM xc_textstats WHERE fileid='".$current_language."->".$current_texttype."->".$textfile."'");
        if(!$result) { printf("Fel vid anrop av databasen, kontakta ansvarig för sidan!"); exit; }
        if(pg_num_rows($result) > 0) {
          $queryresult = pg_fetch_array($result,0);
          $navbar .= "(".$queryresult['totsums'].")";
        }
        $navbar .= "</OPTION>\n";
      }
    } else {
      $navbar .= "  <OPTION value='' selected>------</OPTION>\n";
      $visibility = ' STYLE="visibility:hidden;"';
    }
    $navbar .= "</SELECT>\n";
  }

  $navbar .= "<BR>\n";

  $tpl->assign(NAVBAR_VISIBILITY, $visibility);
  $tpl->assign(NAVBAR, $navbar);
  return $tpl;
}

# Reads the corpus structure starting from $path and returns available
# languages, texttypes and actual text filenames
function read_corpusstructure($path) {
  $languages = array(); # Array holding available languages for the corpus
  $texttypes = array(); # Available texttypes for each language
  $textfiles = array(); # Available texts for each language->texttype
  # Level 1. Language level (one directory for each language available in the corpus)
  if($dir = @opendir($path)) {
    while(($file = readdir($dir)) !== false) {
      if(is_dir($path."/".$file) && $file != "." && $file != "..") {
        $languages[] = $file;
      }
    }
    # Level 2. Text type level (one directory for each texttype available for respective language)
    foreach($languages as $foo=>$lang) {
      if($dir = @opendir($path."/".$lang)) {
        while(($file = readdir($dir)) !== false) {
          if(is_dir($path."/".$lang."/".$file) && $file != "." && $file != "..") {
            $texttypes[$lang][] = $file;
          }
        }
      }
    }
    # Level 3. Text files level (one file for each text available for respective texttype)
    foreach($languages as $foo=>$lang) {
      foreach($texttypes[$lang] as $foo=>$txttype) {
        if($dir = @opendir($path."/".$lang."/".$txttype)) {
          while(($file = readdir($dir)) !== false) {
            if(is_file($path."/".$lang."/".$txttype."/".$file)) {
              $textfiles[$lang][$txttype][] = $file;
            }
          }
        }
      }
    }
  }
  closedir($dir);
  return array ($languages,$texttypes,$textfiles);
}

function read_specific_file($path,$fileid) {
  $fileidarr = preg_split("/->/",$fileid);
  $language = $fileidarr[0];
  $texttype = $fileidarr[1];
  $textfile = $fileidarr[2];
  if($handle = fopen($path."/".$language."/".$texttype."/".$textfile, "r")) {
    $contents = fread($handle, filesize($path."/".$language."/".$texttype."/".$textfile));
    $filecrc = crc32($contents);
    fclose($handle);
    preg_match("/<body>(.*?)<\/body>/si",$contents,$matches);
    $textbody = $matches[1];

    # PHP sometimes seem to some problems identifying \n depending on how the text was saved???
    $sentences = explode("\n",$textbody);
    if(count($sentences)<2) { $sentences[0].="<BR><BR><B>ERROR! Could not find any <I>\\n</I> (newlines) in the text, could there be some problem with how the file was saved???</B><BR>"; }

    preg_match("/<META HTTP-EQUIV=\"textinfo\" CONTENT=\"(.*?)\"/si",$contents,$matches);
    $metainfo = $matches[1];
  }

  $db = connect2db();
  $result = pg_query($db,"SELECT * FROM xc_textstats WHERE fileid='".$fileid."'");
  if(!$result) { printf("Fel vid anrop av databasen, kontakta ansvarig för sidan!"); exit; }
  if(pg_num_rows($result) > 0) {
    $queryresult = pg_fetch_array($result,0);

    $sumstatsarray = preg_split("/S.*?=/",$queryresult["sentstats"]);
    $baseline1array = preg_split("/S.*?=/",$queryresult["baseline1"]);
    $baseline2array = preg_split("/S.*?=/",$queryresult["baseline2"]);
    $baseline3array = preg_split("/S.*?=/",$queryresult["baseline3"]);
    $extracts = $queryresult["extracts"];
    $shortest_sumlength = $queryresult['shortsum'];
    $longest_sumlength = $queryresult['longsum'];
    $total_sumlength = $queryresult['totslen'];
    $nrofsummaries = $queryresult['totsums'];

  # Creates new row in database table for the current file (only happens if a row does not yet exist)
  } else {
    $sentstats = "";
    for($i=0;$i<$sentence_total;$i++)
      { $sentstats .= "S".$i."=0"; }
    $baseline1 = "";
    for($i=0;$i<$sentence_total;$i++)
      { $baseline1 .= "S".$i."=0"; }
    $baseline2 = "";
    for($i=0;$i<$sentence_total;$i++)
      { $baseline2 .= "S".$i."=0"; }
    $baseline3 = "";
    for($i=0;$i<$sentence_total;$i++)
      { $baseline3 .= "S".$i."=0"; }
    # Inserts an entry for the given file, only possible if one does not already exist
    $result = pg_query($db,"INSERT INTO xc_textstats (fileid, sentstats, baseline1, baseline2, baseline3, shortsum, longsum, totslen, totsums, crc32, changed, abstract) VALUES ('".$fileid."', '".$sentstats."', '".$baseline1."', '".$baseline2."', '".$baseline3."', '0', '0', '0', '0', '".$filecrc."', FALSE, FALSE);");
    $shortest_sumlength = $longest_sumlength = $total_sumlength = $nrofsummaries = 0;
    $sumstatsarray = preg_split("/S.*?=/",$sentstats);
    $baseline1array = preg_split("/S.*?=/",$baseline1);
    $baseline2array = preg_split("/S.*?=/",$baseline2);
    $baseline3array = preg_split("/S.*?=/",$baseline3);
    $extracts = "";
  }
  array_shift($baseline1array);
  array_shift($baseline2array);
  array_shift($baseline3array);
  array_shift($sumstatsarray);

  return array ($sentences,$extracts,$sumstatsarray,$baseline1array,$baseline2array,$baseline3array,
                $nrofsummaries,$shortest_sumlength,$longest_sumlength,$total_sumlength,$metainfo,($filecrc!=$queryresult['crc32']));
}

# Selects a random file to display for collection of sentence selection statistics
# If a chosen file has been changed, the function recurses until it has found a valid file
function select_random_file($path,$language,$texttype,$textfiles) {
  return select_random_file_recurse($path,$language,$texttype,$textfiles,0);
}
function select_random_file_recurse($path,$lang,$txttype,$textfiles,$choicenr) {
  srand((float)microtime() * 10000000);
  $rand_key = array_rand($textfiles[$lang][$txttype]);

  $txtfile = $textfiles[$lang][$txttype][$rand_key];
  $fileid = $lang."->".$txttype."->".$txtfile;

  # Reads randomly chosen file
  if($handle = fopen($path."/".$lang."/".$txttype."/".$txtfile, "r")) {
    $contents = fread($handle, filesize($path."/".$lang."/".$txttype."/".$txtfile));
    $filecrc = crc32($contents);
    fclose($handle);
    preg_match("/<body>(.*?)<\/body>/si",$contents,$matches);
    $textbody = $matches[1];

    # PHP sometimes seem to some problems identifying \n depending on how the text was saved???
    $sentences = explode("\n",$textbody);
    if(count($sentences)<2) { $sentences[0].="<BR><BR><B>ERROR! Could not find any <I>\\n</I> (newlines) in the text, could there be some problem with how the file was saved???</B><BR>"; }

    $sentence_total = count($sentences);
  } else { echo "ERROR - File not found: ".$path."/".$lang."/".$txttype."/".$txtfile; exit; }

  # Checks if the randomly chosen file has been changed
  $db = connect2db();
  $result = pg_query($db,"SELECT * FROM xc_textstats WHERE fileid='".$fileid."'");
  if(!$result) { printf("Fel vid anrop av databasen, kontakta ansvarig för sidan!"); exit; }
  if(pg_num_rows($result) > 0) {
    $queryresult = pg_fetch_array($result,0);
    $extracts = $queryresult["extracts"];

    # If the file chosen seems to have changed it is no longer valid, choose a new one
    if($filecrc != $queryresult['crc32']) {
      $result = pg_query($db,"UPDATE xc_textstats SET changed=TRUE WHERE fileid='$fileid'");
      if($choicenr > 10)
        { echo "Too many faulty or changed files in the corpus, please contact the administrator of this corpus (or Martin Hassel <xmartin@nada.kth.se>)."; exit; }
      list($fileid,$sentences,$metainfo) = select_random_file_recurse($path,$lang,$txttype,$textfiles,++$choicenr);
    } else {
      $result = pg_query($db,"UPDATE xc_textstats SET changed=FALSE WHERE fileid='$fileid'");
    }

  # Creates new row in database table for the current file (only happens if a row does not yet exist)
  } else {
    $sentstats = "";
    for($i=0;$i<$sentence_total;$i++)
      { $sentstats .= "S".$i."=0"; }
    $baseline1 = "";
    for($i=0;$i<$sentence_total;$i++)
      { $baseline1 .= "S".$i."=0"; }
    $baseline2 = "";
    for($i=0;$i<$sentence_total;$i++)
      { $baseline2 .= "S".$i."=0"; }
    $baseline3 = "";
    for($i=0;$i<$sentence_total;$i++)
      { $baseline3 .= "S".$i."=0"; }

    # Inserts an entry for the given file, only possible if one does not already exist
    $result = pg_query($db,"INSERT INTO xc_textstats (fileid, sentstats, baseline1, baseline2, baseline3, shortsum, longsum, totslen, totsums, crc32, changed, abstract) VALUES ('".$fileid."', '".$sentstats."', '".$baseline1."', '".$baseline2."', '".$baseline3."', '0', '0', '0', '0', '".$filecrc."', FALSE, FALSE);");
    if(!$result) { printf("Fel vid anrop av databasen, kontakta ansvarig för sidan!"); exit; }
    $extracts = "";
  }
  return array ($fileid,$sentences,$extracts,$metainfo);
}


# Creates rows in DB for all files in a given category that does not yet have a row in the DB
function touch_files($path,$current_language,$current_texttype) {
  list($languages,$texttypes,$textfiles) = read_corpusstructure($path);
  $db = connect2db();

  # Check that there actually are files in the category asked for (if any)
  if(count($textfiles[$current_language][$current_texttype])) {
    asort($textfiles[$current_language][$current_texttype]);
    foreach($textfiles[$current_language][$current_texttype] as $foo=>$textfile) {

      # Check if file already is represented in DB
      $fileid = $current_language."->".$current_texttype."->".$textfile;
      $result = pg_query($db,"SELECT * FROM xc_textstats WHERE fileid='".$fileid."'");
      if(!$result) { printf("Fel vid anrop av databasen, kontakta ansvarig för sidan!"); exit; }

      # Creates new row in database table for the current file (only happens if a row does not yet exist)
      if(pg_num_rows($result)==0) {

        # Get CRC and nr of sentences from actual file in corpus
        if($handle = fopen($path."/".$current_language."/".$current_texttype."/".$textfile, "r")) {
          $contents = fread($handle, filesize($path."/".$current_language."/".$current_texttype."/".$textfile));
          $filecrc = crc32($contents);
          fclose($handle);
          preg_match("/<body>(.*?)<\/body>/si",$contents,$matches);
          $textbody = $matches[1];

          # PHP sometimes seem to some problems identifying \n depending on how the text was saved???
          $sentences = explode("\n",$textbody);
          if(count($sentences)<2) { echo "<BR><BR><B>ERROR! Could not find any <I>\\n</I> (newlines) in <i>$fileid</i>, could there be some problem with how the file was saved???</B><BR>"; }

          $sentence_total = count($sentences);
        } else { echo "ERROR - File not found: ".$path."/".$lang."/".$txttype."/".$txtfile; exit; }

        $sentstats = "";
        for($i=0;$i<$sentence_total;$i++)
          { $sentstats .= "S".$i."=0"; }
        $baseline1 = "";
        for($i=0;$i<$sentence_total;$i++)
          { $baseline1 .= "S".$i."=0"; }
        $baseline2 = "";
        for($i=0;$i<$sentence_total;$i++)
          { $baseline2 .= "S".$i."=0"; }
        $baseline3 = "";
        for($i=0;$i<$sentence_total;$i++)
          { $baseline3 .= "S".$i."=0"; }

        # Inserts an entry for the given file, only possible if one does not already exist
        $result = pg_query($db,"INSERT INTO xc_textstats (fileid, sentstats, baseline1, baseline2, baseline3, shortsum, longsum, totslen, totsums, crc32, changed, abstract) VALUES ('".$fileid."', '".$sentstats."', '".$baseline1."', '".$baseline2."', '".$baseline3."', '0', '0', '0', '0', '".$filecrc."', FALSE, FALSE);");
        if(!$result) { printf("Fel vid anrop av databasen, kontakta ansvarig för sidan!"); exit; }
      }
    }
  }
}

function calculate_overlap($meansummarylength,$path,$fileid) {
  list($sentences,$extracts,$sumstatsarray,$baseline1array,$baseline2array,$baseline3array,
       $nrofsums,$shortest,$longest,$totsumlen,$metainfo,$filechanged) = read_specific_file($path,$fileid);

  #foreach($sumstatsarray as $value) { print "$value"; } print "<br>\n";
  if($sentences[0] == "") { # Ad-hoc bug-fix ^^;
    array_shift($sentences);
    $fileidarr = preg_split("/->/",$fileid);
    if($fileidarr[1] != "nyhetstexter") {
      array_shift($sumstatsarray);
    }
  }
  $statsarray = $sumstatsarray;

  # Calculate total number of words & votes
  while(list($key,$sentence) = each($sentences)) {
    $totalnrofwords += count(preg_split("/\s/",$sentence));
    $totvotes += $statsarray[$key];
  }

  # Generate summary, sorted by number of votes and again resorted
  $cutoff = ($meansummarylength/100) * $totalnrofwords;
  arsort($statsarray,SORT_NUMERIC);
  reset($statsarray);
  while((list($key,$val) = each($statsarray)) && $sumnrofwords < $cutoff && $val>0) {
    $sumnrofwords += count(preg_split("/\s/",$sentences[$key]));
    $summarray[$key] = $val;
  }

  if($summarray != NULL) {
    ksort($summarray);

    # Calculate votes & sentences covered
    foreach($summarray as $key=>$val) {
      $sentence = $sentences[$key];
      if($sentence == "") {
        $dif++;
      } else {
        $votescovered += $sumstatsarray[$key];
        $nrofsentences++;
      }
    }
    $precision = round(($votescovered/($nrofsentences*$nrofsums))*100);
    $recall = round(($votescovered/$totvotes)*100);
    $precision_m = round(($votescovered/($nrofsentences*$nrofsums))*100) * ($meansummarylength/100);
    $recall_m = round(($votescovered/$totvotes)*100) * ($meansummarylength/100);
  }

  return array ($precision,$recall);
}

?>
