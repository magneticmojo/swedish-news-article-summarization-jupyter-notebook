<!-- xc_admin_sum_show.tpl template -->
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
Nedan idealsammanfattningen ("model summary") i ett textf�lt. Denna text kan du kopiera f�r att anv�nda f�r utv�rdering med utv�rderingsverktyget <A href="http://www.isi.edu/~cyl/SEE/">SEE (Summary Evaluation Environment)</A> av Chin-Yew Lin. Under textf�ltet finns �ven en l�nk till samma text.<BR>
</TD></TR></TABLE>
<BR />

{TEXTAREA}<BR />
<A href="showsumstats.php?viewsee={FILEID}&cutoff={SUMMARYDEGREE}&mode=link">L�nk till SEE-filen i textf�ltet ovan</A><BR />

<BR />
<INPUT type="button" value="St�ng" onclick="window.close();" STYLE="background-color: #99CC66" /><BR />

</BODY>
</HTML>

<!-- Non-optional template markers *** Do NOT remove these! *** -->
<!-- TEXTTABLE is the table of choices generated from the text randomly chosen from the corpus -->

<!-- Optional template markers, use these as you feel neccessary
<!-- FILEID is the unique identifier for the current file chosen from the corpus -->
<!-- SUMMARYDEGREE is roughly how much of the text made it into the user summary -->
