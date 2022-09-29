<?php

# Change these to suit your needs
$dumpbase = "/afs/nada.kth.se/home/iplab/xmartin/Public/kthxc/landes/";
$path = "corpus"; # This is where the texts should reside in a separate folder
                  # for each language and texttype


# function for database management
require("./common/connect2db.inc");
require("./common/filefunctions.inc");

$language = $_GET['language'];
$texttype = $_GET['texttype'];

list($languages,$texttypes,$textfiles) = read_corpusstructure($path);
if($texttype && $texttype != "dummy") {
  asort($textfiles[$language][$texttype]);

  # This section recreates all submitted extracts/summaries for the current text
  foreach($textfiles[$language][$texttype] as $foo=>$textfile) {
    list($sentences,$extracts,$sumstatsarray,$baseline1array,$baseline2array,$baseline3array,
         $nrofsums,$shortest,$longest,$totsumlen,$metainfo,$filechanged) = read_specific_file($path,$language."->".$texttype."->".$textfile);
    echo "$textfile";
    $xnr = 0;

    $shifted = false;
    if($sentences[0] == "") {
      if($texttype == "nyhetstexter") {
        array_shift($sentences);
      }
      $shifted = true;
    }
    #foreach($sumstatsarray as $value) { print ($value?$value:0).","; } print "<br>\n";

    $extracts_array = preg_split("/\|/",$extracts);
    foreach($extracts_array as $extract) {
      $all_sums .= "<BR><I>Sammanfattning nr: " . ++$xnr . "</I> ($userid)<BR>";
      echo ".";

      # Open file to dump extract to
      $handle = fopen($dumpbase.$language."_".$texttype."_".$textfile.".".$xnr."_".$userid.".sum", "w");
      list($userid,$extract) = preg_split("/\_/",$extract);
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
          $othersum .= $sentence."\n";
        }
        $sentence_number++;
      }
      fwrite($handle, $othersum."\n");
      fclose($handle);
    }
    echo "done<br />\n";
  }
}

echo "All done!<br />\n";
exit;

?>
