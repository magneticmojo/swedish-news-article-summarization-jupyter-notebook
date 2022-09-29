<?php
  # The code below handles display of text files for collection of selection statistics
  # both for randomly chosen and specificly chosen files
  # 2004-01-31 Added cosmetic support for heading tags (<H*>...</H*>)
  # 2003-12-02 Added better handling of file change and more and better comments :-)

  # Class for template management
  require("./classes/class.FastTemplate.php");

  # function for database management
  require_once("./common/connect2db.inc");
  require_once("./common/filefunctions.inc");
  require_once("./common/iphostfunctions.inc");
  $db = connect2db();

  # These sets the path to default to svenska->test if nothing else is given
  if(!$HTTP_GET_VARS["language"]) { $HTTP_GET_VARS["language"]="svenska"; }
  if(!$HTTP_GET_VARS["texttype"]) { $HTTP_GET_VARS["texttype"]="test"; }

  # The argument to the constructor is the path to where the templates are stored
  if (file_exists("templates/".$HTTP_GET_VARS["language"]."/")) {
    $tpl = new FastTemplate("templates/".$HTTP_GET_VARS["language"]."/");
  } else {
    $tpl = new FastTemplate("templates/svenska/");
  }

  # Define templates
  $tpl->define(array(kthxc=>"xc_sum_collect.tpl",
                     kthxc_meta=>"xc_sum_meta.tpl",
                     kthxc_changed=>"xc_admin_sum_changed.tpl",
                     kthxc_info=>"xc_sum_info.tpl"));

  # This separates the JavaScript code from the template making it less cluttery
  if($handle = fopen("./snippets/jscode.inc", "r")) {
    $jscode = fread($handle, filesize("./snippets/jscode.inc"));
    $tpl->assign(JSCODE, $jscode);
    fclose($handle);
  }

  $path = "corpus"; # This is where the texts should reside in a separate folder
                    # for each language and texttype

  if($HTTP_GET_VARS["fileid"]) {
    $fileid = $HTTP_GET_VARS["fileid"];
    list($sentences,$extracts,$sumstatsarray,$baseline1array,$baseline2array,$baseline3array,
         $nrofsums,$shortest,$longest,$totsumlen,$metainfo,$filechanged) = read_specific_file($path,$fileid);
  } else {
    list($languages,$texttypes,$textfiles) = read_corpusstructure($path);
    list($fileid,$sentences,$extracts,$metainfo) = select_random_file($path,$HTTP_GET_VARS["language"],$HTTP_GET_VARS["texttype"],$textfiles);
  }

  $totalnrofwords = 0;
  foreach($sentences as $sentence) {
    $totalnrofwords += count(preg_split("/\s/",$sentence));
  }

  # Generate the text table with checkboxes for the user
  $texttable = "";
  $sentence_total = $sentence_choosable = 0;
  foreach($sentences as $sentence) {
    if($sentence == "") {
      $texttable .= "<BR id=\"S".$sentence_total."\" \>\n";
    } else {
      if(preg_match("/^(<H.*?>)(.*)(<\/H.*?>)$/i",$sentence,$matches)) {
        $texttable .= "$matches[1]<INPUT type=\"checkbox\" id=\"S".$sentence_total."\" onClick=\"if(this.checked) {restyle('SP".$sentence_total."','marked')} else {restyle('SP".$sentence_total."','normal')}\" value=\"".htmlentities(urlencode($sentence))."\">&nbsp;<SPAN id=\"SP".$sentence_total."\" class=\"normal\" />$matches[2]$matches[3]</SPAN><BR>\n";
      } else {
        $texttable .= "<INPUT type=\"checkbox\" id=\"S".$sentence_total."\" onClick=\"if(this.checked) {restyle('SP".$sentence_total."','marked')} else {restyle('SP".$sentence_total."','normal')}\" value=\"".htmlentities(urlencode($sentence))."\">&nbsp;<SPAN id=\"SP".$sentence_total."\" class=\"normal\" />$sentence</SPAN><BR>\n";
      }
      $sentence_choosable++;
    }
    $sentence_total++;
  }

  $tpl->assign(FILEID, $fileid);
  $tpl->assign(NROFWORDS, $totalnrofwords);
  $tpl->assign(NROFSENTENCES, $sentence_total);
  $tpl->assign(NROFCHOOSABLESENTENCES, $sentence_choosable);
  $tpl->assign(MAXNROFCHOOSABLESENTENCES, round($sentence_choosable * 0.6));
  $tpl->assign(OPTNROFCHOOSABLESENTENCES, round($sentence_choosable * 0.3));

  if($filechanged) { $tpl->parse(FILECHANGEWARNING, kthxc_changed); }

  if($HTTP_GET_VARS["mode"] == "meta") {
    $result = pg_query($db,"SELECT * FROM xc_userstats WHERE host='".getHostByAddr(userIP())."'");
//    if($result == false) {
      $user = pg_fetch_array($result,0);
      $tpl->assign(USERTXTSUM, preg_match_all("/".$user["id"]."_/",$extracts,$foo));
      $tpl->assign(USERTOTSUMS, $user["totsums"]);
//    } else {
//      $tpl->assign(USERTXTSUM, "0");
//      $tpl->assign(USERTOTSUMS, "0");
//    }
    $tpl->assign(METAINFO, preg_replace("/\|/","<BR>",preg_replace("/(http.*?)\|/i","<A href='$1'>$1</A>|",$metainfo)));
    $tpl->parse(METAINFO, kthxc_meta);
  } elseif($HTTP_GET_VARS["mode"] == "info") {
    $tpl->parse(FILEID, kthxc_info);
  } else {
    $tpl->assign(TEXTTABLE, $texttable);
    $tpl->parse(TEXTTABLE, kthxc);
  }

  $tpl->Fastprint();

?>
