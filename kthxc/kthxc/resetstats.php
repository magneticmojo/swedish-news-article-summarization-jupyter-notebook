<?php
  # Code below resets sentence selection statistics to database,
  # 2006-01-20 Ad-hoc bug fix for filenames with spaces and dots ...
  # 2003-12-05 Added the possibility to 'touch' all files in a category
  # 2003-12-04 Initiated :-)

  # function for database management
  require("./common/connect2db.inc");
  require("./common/filefunctions.inc");
  $db = connect2db();

  # Delete selected rows from the database
  while(list($key,) = each($HTTP_POST_VARS)) {
    $resetid = preg_replace("/resetid_(.*)_htm/","\\1.htm",$key);
    if(preg_match("/resetid_/i",$key)) {
      # delete the appropriate row in data base
      $result = pg_query($db,"DELETE FROM xc_textstats WHERE fileid='".$resetid."'");
      # if there are spaces in the filename, NOTE: both variants will be deleted!!!
      $resetid = preg_replace("/_(\d*)_(\d*)_/"," \\1.\\2 ",$resetid);
      $resetid = preg_replace("/_/"," ",$resetid);
      $result = pg_query($db,"DELETE FROM xc_textstats WHERE fileid='".$resetid."'");
      if(!$result) { printf("Fel vid anrop av databasen, kontakta ansvarig för sidan!"); exit; }
      print "<B>All statistics for <I>$resetid</I> has been deleted from the statistics database, the actual file is however unaltered in the text part of the corpus</B><BR>";
    }
  }

  # This sets the path to default to 'dummy' whatever is given, no touching Swedish or Danish stats at this time ;-)
  $HTTP_GET_VARS["language"] = "svenska";
  $HTTP_GET_VARS["texttype"] = "lexkoh";

  # Class for template management
  require("./classes/class.FastTemplate.php");
  # The argument to the constructor is the path to where the templates are stored
  if (file_exists("templates/".$HTTP_GET_VARS["language"]."/")) {
    $tpl = new FastTemplate("templates/".$HTTP_GET_VARS["language"]."/");
  } else {
    $tpl = new FastTemplate("templates/svenska/");
  }
  # Define templates
  $tpl->define(array(linklist_head=>"xc_admin_sum_linklist_head.tpl",
                     linklist_row=>"xc_admin_sum_linklist_row.tpl",
                     linklist_foot=>"xc_admin_sum_linklist_foot.tpl",
                     kthxc_admin_sum_index=>"xc_admin_sum_reset.tpl"));

  $path = "corpus"; # This is where the texts should reside in a separate folder
                    # for each language and texttype

  if($HTTP_GET_VARS["mode"] == "fill") { touch_files($path,$HTTP_GET_VARS["language"],$HTTP_GET_VARS["texttype"]); }

  # This section generates the navigation bar, the standard way of navigation
  $tpl = generate_navbar($tpl,$path,$HTTP_GET_VARS["language"],$HTTP_GET_VARS["texttype"],TRUE);

  # This section, optionally, generates a list of links for easier navigation
  $tpl = generate_linklist($tpl,$path,$HTTP_GET_VARS["language"],$HTTP_GET_VARS["texttype"],TRUE);

  $tpl->assign(LANGUAGE, $HTTP_GET_VARS["language"]);
  $tpl->assign(TEXTTYPE, $HTTP_GET_VARS["texttype"]);
  $tpl->parse(LINKLIST, kthxc_admin_sum_index);
  $tpl->Fastprint();
?>
