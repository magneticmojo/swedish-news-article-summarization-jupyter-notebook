<!-- xc_admin_sum_eval.tpl template -->
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
<BR>
</TD></TR></TABLE>
<BR />

<FORM onSubmit="showsumstats.php" method="post">
<INPUT type="hidden" name="evalsum" value="{FILEID}" />
<INPUT type="hidden" name="cutoff" value="{SUMMARYDEGREE}" />
<INPUT type="hidden" name="eval" value="go!" />
{IDEALSUM}

<BR />

<TEXTAREA name="summary" rows='15' cols='60'>
Klistra in den systemsammanfattning som skall jämföras med idealsammanfattningen ovan här.
Om idealsammanfattningen ovan presenteras en mening per rad så se till att den inklistrade sammanfattningen också har en mening per rad (motsvarande om idealsammanfattningen presenteras med ett stycke eller en sats per rad).
</TEXTAREA>

<BR />
<INPUT type="submit" value="Jämför!" />

</FORM>

<BR />
<INPUT type="button" value="Stäng" onclick="window.close();" STYLE="background-color: #99CC66" /><BR />

</BODY>
</HTML>

<!-- Non-optional template markers *** Do NOT remove these! *** -->
<!-- IDEALSUM is the ideal summary, or Gold Standard, at the given compression rate -->
<!-- FILEID is the unique identifier for the current file chosen from the corpus -->
<!-- SUMMARYDEGREE is roughly how much of the text made it into the user summary -->

<!-- Optional template markers, use these as you feel neccessary -->
