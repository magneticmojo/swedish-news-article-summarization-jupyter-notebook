<?php
  function connect2db() {
    # Include file below defines $dbname, $dbuser and $dbpass
    include '.htdbpass.inc';
    # Connect to database server
    $db = @pg_connect("host=$host dbname=$dbname user=$dbuser password=$dbpass");
    if(!$db) {
      print "<CENTER><H3><B>Kunde ej ansluta till användardatabasen, var god försök senare.</B></H3>";
      print "[<A HREF='javascript:history.go(-1)'><B>Tillbaka</B></A>]|";
      print "[<A HREF='javascript:history.go(0)'><B>Försök igen</B></A>]<BR></CENTER>";
      exit;
    }
    return $db;
  }

  # Be veeeery careful with this =)
  function drop_and_recreate_tables() {
    $db = connect2db();
    $query = "DROP TABLE xc_textstats, xc_corpus, xc_userstats; DROP SEQUENCE user_id_seq;";
    pg_query($db,$query);
    $query = 'CREATE SEQUENCE "user_id_seq" increment 1 maxvalue 2147483647 minvalue 1 cache 1;';
    pg_query($db,$query);
    $query = "CREATE TABLE xc_userstats (id int4 DEFAULT nextval('user_id_seq'::text) NOT NULL, host text, totsums int2, UNIQUE (host));";
    pg_query($db,$query);
    $query = "CREATE TABLE xc_corpus (fileid text, title text, metadata text, body text, UNIQUE (fileid));";
    pg_query($db,$query);
    $query = "CREATE TABLE xc_textstats (fileid text, extracts text, sentstats text, baseline1 text, baseline2 text, baseline3 text, shortsum int2, longsum int2, totslen int4, totsums int2, crc32 int4, changed BOOL, abstract BOOL, UNIQUE (fileid));";
    pg_query($db,$query);
  }
?>
