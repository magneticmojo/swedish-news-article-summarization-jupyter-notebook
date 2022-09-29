<?php
  # 2003-12-05 Code cleanup, less comments??? :-)

  # function for database management
  require_once("./common/connect2db.inc");
  $db = connect2db();

  # Generate the text table with all users and the number of summaries they've done
  $texttable = "";
  $result = pg_query($db,"SELECT * FROM xc_userstats ORDER BY id");
  if(!$result) { printf("Fel vid anrop av databasen, kontakta ansvarig för sidan!"); exit; }
  $numrows = pg_num_rows($result);
  printf("<TABLE border=1>\n");
  printf("<TR><TD>User ID</TD><TD>Host eller IP</TD><TD>Antal sammanfattningar</TD></TR>\n");
  if($numrows) {
    do {
      $myrow = pg_fetch_array($result);
      echo "<TR><TD>" . $myrow['id'] . "</TD><TD>" . $myrow['host'] . "</TD><TD>" . $myrow['totsums'] . "</TD></TR>";
      $totsums += $myrow['totsums'];
      $row++;
    } while($row<$numrows);
  }
  echo "<TR><TD colspan=2 align='right'>Total:</TD><TD>$totsums</TD></TR>";
  printf("</TABLE></FORM>\n");
?>
