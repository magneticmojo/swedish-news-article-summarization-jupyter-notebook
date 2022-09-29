<?php
  # Code below saves sentence selection statistics to database,
  # generates baselines (also saved to database) and
  # handles display/confirmation of user summary/extract
  # 2003-12-02 More and better comments to the code :-)

  # function for database management
  require_once("./common/connect2db.inc");
  require_once("./common/filefunctions.inc");
  require_once("./common/iphostfunctions.inc");
  $db = connect2db();

  # These sets the language to default to 'svenska'
  if(!$HTTP_GET_VARS["language"]) { $HTTP_GET_VARS["language"]="svenska"; }

  # Class for template management
  require("./classes/class.FastTemplate.php");
  # The argument to the constructor is the path to where the templates are stored
  if (file_exists("templates/".$HTTP_GET_VARS["language"]."/")) {
    $tpl = new FastTemplate("templates/".$HTTP_GET_VARS["language"]."/");
  } else {
    $tpl = new FastTemplate("templates/svenska/");
  }

  # Define templates
  $tpl->define(array(kthxc_sum_show=>"xc_sum_show.tpl",
                     kthxc_sum_saved=>"xc_sum_saved.tpl"));

  # Save user created summary/extract after user confirmation
  if($HTTP_GET_VARS["mode"] == "save") {

    $result = pg_query($db,"SELECT * FROM xc_textstats WHERE fileid='".$HTTP_GET_VARS["fileid"]."'");
    if(!$result) { printf("Fel vid anrop av databasen, kontakta ansvarig för sidan!"); exit; }
    if(pg_num_rows($result) > 0) {
      $queryresult = pg_fetch_array($result,0);

      $db = connect2db();
      $host = getHostByAddr(userip());
      $result = pg_query($db,"SELECT * FROM xc_userstats WHERE host='".$host."'");
      if(pg_num_rows($result) > 0) {
        $result = pg_query($db,"UPDATE xc_userstats SET totsums=totsums+1 WHERE host='".$host."'");
      } else {
        # Inserts an entry for the given host, only possible if one does not already exist
        $result = pg_query($db,"INSERT INTO xc_userstats (host, totsums) VALUES ('".$host."', '1');");
      }
      $result = pg_query($db,"SELECT * FROM xc_userstats WHERE host='".$host."'");
      $user = pg_fetch_array($result,0);

      # Add extract to the end of the list of extracts, separate with |
      if($queryresult["extracts"]) {
        $newextract = $queryresult["extracts"] . "|" . $user["id"] . "_" . $HTTP_GET_VARS["sumarray"];
      } else {
        $newextract = $user["id"] . "_" . $HTTP_GET_VARS["sumarray"];
      }

      $sumarray = preg_split("//",$HTTP_GET_VARS["sumarray"]);
      $sumstatsarray = preg_split("/S.*?=/",$queryresult["sentstats"]);
      $baseline1array = preg_split("/S.*?=/",$queryresult["baseline1"]);
      $baseline2array = preg_split("/S.*?=/",$queryresult["baseline2"]);
      $baseline3array = preg_split("/S.*?=/",$queryresult["baseline3"]);
      array_shift($baseline1array);
      array_shift($baseline2array);
      array_shift($baseline3array);
      array_shift($sumstatsarray);
      array_shift($sumarray);
      array_pop($sumarray);

      # Create/update extract statistics
      $totaloverlap = 0;
      $partialoverlap = 0;
      for($s=0 ; $s < count($sumarray) ; $s++) {
        if($sumarray[$s]) {
          $newsentstats .= "S" . $s . "=" . ($sumstatsarray[$s]+1);
          if($sumstatsarray[$s]) {
            if($queryresult["totsums"] == $sumstatsarray[$s]) { $totaloverlap++; }
            else { $partialoverlap++; }
          }
        } else {
          $newsentstats .= "S" . $s . "=".$sumstatsarray[$s];
        }
      }

      list($sentences,$extracts,$sumstatsarray,$baseline1array,$baseline2array,$baseline3array,
           $nrofsums,$shortest,$longest,$totsumlen) = read_specific_file("corpus",$HTTP_GET_VARS["fileid"]);

      # Create baseline_1 based on random distribution, does not choose empty lines (a human wouldn't ^^)
      srand((float)microtime() * 10000000);
      $basearray = array_pad(array(),count($sumarray),0);
      while(preg_match_all("/1/",$newbaseline,$foo) < preg_match_all("/1/",$HTTP_GET_VARS["sumarray"],$foo)) {
        $randomsentence = array_rand($basearray);
        if($sentences[$randomsentence]) { $basearray[$randomsentence] = 1; }
        $newbaseline = join("",$basearray);
      }
      for($s=0 ; $s < count($basearray) ; $s++) {
        if($basearray[$s]) {
          $newbaseline1 .= "S" . $s . "=" . ($baseline1array[$s]+1);
        } else {
          $newbaseline1 .= "S" . $s . "=" . $baseline1array[$s];
        }
      }

      # Create baseline_2 based on leading sentences (text), does not choose empty lines (a human wouldn't ^^)
      for($s=$e=0 ; $s < count($basearray) ; $s++) {
        if($e < preg_match_all("/1/",$HTTP_GET_VARS["sumarray"],$foo) && $sentences[$s]) {
          $newbaseline2 .= "S" . $s . "=" . ($baseline2array[$s]+1);
          $e++;
        } else {
          $newbaseline2 .= "S" . $s . "=" . $baseline2array[$s];
        }
      }

      # Create baseline_3 based on leading sentences (paragraphs), does not choose empty lines (a human wouldn't ^^)
      $offset = $e = 0;
      $basearray = array_pad(array(),count($sumarray),0);
      while($e < preg_match_all("/1/",$HTTP_GET_VARS["sumarray"],$foo)) {
        if($sentences[$offset] && $e < preg_match_all("/1/",$HTTP_GET_VARS["sumarray"],$foo) && !$basearray[$offset]) {
          $basearray[$offset] = 1;
          $e++;
        }
        $offset++;
        for($s=0 ; $s < count($basearray) ; $s++) {
          if($e < preg_match_all("/1/",$HTTP_GET_VARS["sumarray"],$foo) && $sentences[$s]=="") {
            if(($s+$offset) < count($basearray) && !$basearray[($s+$offset)]) {
              $basearray[($s+$offset)] = 1;
              $e++;
            }
          }
        }
      }
      for($s=0 ; $s < count($basearray) ; $s++) {
        if($basearray[$s]) {
          $newbaseline3 .= "S" . $s . "=" . ($baseline3array[$s]+1);
        } else {
          $newbaseline3 .= "S" . $s . "=" . $baseline3array[$s];
        }
      }

    }

    $longest = $shortest = $summarydegree = $HTTP_GET_VARS["sumlen"];
    if($queryresult["longsum"]  > $summarydegree) { $longest  = $queryresult["longsum"]; }
    if($queryresult["shortsum"] && $queryresult["shortsum"] < $summarydegree) { $shortest = $queryresult["shortsum"]; }

    $result = pg_query($db,"UPDATE xc_textstats SET baseline1='".$newbaseline1."', baseline2='".$newbaseline2."', baseline3='".$newbaseline3."', extracts='".$newextract."', sentstats='".$newsentstats."', shortsum='".$shortest."', longsum='".$longest."', totslen=totslen+'".$summarydegree."', totsums=totsums+1 WHERE fileid='".$HTTP_GET_VARS["fileid"]."'");
    if(!$result) { printf("Fel vid anrop av databasen, kontakta ansvarig för sidan!"); exit; }

    $tpl->assign(USERTXTSUM, preg_match_all("/".$user["id"]."_/",$HTTP_GET_VARS["extracts"],$foo)+1);
    $tpl->assign(USERTOTSUMS, $user["totsums"]);
    $tpl->assign(TOTALOVERLAP, $totaloverlap);
    $tpl->assign(PARTIALOVERLAP, $partialoverlap);
    $tpl->assign(NOOVERLAP, preg_match_all("/1/",$HTTP_GET_VARS["sumarray"],$foo) - $totaloverlap - $partialoverlap);
    $tpl->assign(TOTALVOTES, preg_match_all("/1/",$HTTP_GET_VARS["sumarray"],$foo));
    $tpl->assign(TOTALSUMS, $queryresult["totsums"]);
    $tpl->parse(SUMMARY, kthxc_sum_saved);

  # Show user created summary/extract to user for confirmation
  } else {
    $nrofchosensentences = preg_match_all("/1/",$HTTP_GET_VARS["sumarray"],$matches);
    $summarydegree = round((count(preg_split("/\s/",$HTTP_GET_VARS["sum"]))/$HTTP_GET_VARS["filewords"])*100);

    # The upper and lower limits of an extract given as percentage of the whole text
    if($summarydegree > 60 || $summarydegree < 5)
      { $visibility = ' STYLE="visibility:hidden;"'; }

    $tpl->assign(VISIBILITY, $visibility);
    $tpl->assign(NROFCHOOSABLESENTENCES, $HTTP_GET_VARS["filesents"]);
    $tpl->assign(NROFCHOSENSENTENCES, $nrofchosensentences);
    $tpl->assign(SUMMARYDEGREE, $summarydegree);
    $tpl->assign(SUMARRAY, $HTTP_GET_VARS["sumarray"]);
    $tpl->assign(FILEID, $HTTP_GET_VARS["fileid"]);
    $tpl->assign(SUMMARY, $HTTP_GET_VARS["sum"]);
    $tpl->parse(SUMMARY, kthxc_sum_show);
  }
  $tpl->Fastprint();

?>
