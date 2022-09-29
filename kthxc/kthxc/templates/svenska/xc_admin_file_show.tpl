<!-- xc_admin_file_show.tpl template -->
<HTML>
<HEAD>
<TITLE>KTHxc: {FILEID}</TITLE>
<LINK rel="stylesheet" type="text/css" href="templates/svenska/style.css" />
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<META HTTP-EQUIV="expires" CONTENT="Wed, 01 Jan 1997 00:00:01 GMT">
<META HTTP-EQUIV="pragma" CONTENT="no-cache">
</HEAD>

<BODY>

<CENTER><H3>KTH extraktkorpus</H3></CENTER>
<TABLE><TR><TD bgcolor=#FFFFCC>
Nedan visas originaltexten i ett textfält. Denna text kan du kopiera för att sammanfatta med en automatisk textsammanfattare, t.ex. <A href="http://swesum.nada.kth.se/">SweSum</A>, för jämförelse med extraktet (och/eller eventuellt abstrakt) representerat i korpusen. Under textfältet finns även en länk till samma text.<BR>
</TD></TR></TABLE>
<BR />

{TEXTAREA}<BR />
<A href="showsumstats.php?viewfile={FILEID}&mode=link">Länk till originaltexten i textfältet ovan</A><BR />

<BR />
<INPUT type="button" value="Stäng" onclick="window.close();" STYLE="background-color: #99CC66" /><BR />

</BODY>
</HTML>

<!-- Non-optional template markers *** Do NOT remove these! *** -->
<!-- TEXTTABLE is the table of choices generated from the text randomly chosen from the corpus -->

<!-- Optional template markers, use these as you feel neccessary
<!-- FILEID is the unique identifier for the current file chosen from the corpus -->
<!-- SUMMARYDEGREE is roughly how much of the text made it into the user summary -->
