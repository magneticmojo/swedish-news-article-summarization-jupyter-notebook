<!-- xc_admin_sum_show.tpl template (v. 2003-12-13) -->
<HTML>
<HEAD>
<TITLE>KTHxc: {MODE} - {FILEID}</TITLE>
<LINK rel="stylesheet" type="text/css" href="common/style.css" />
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<META HTTP-EQUIV="expires" CONTENT="Wed, 01 Jan 1997 00:00:01 GMT">
<META HTTP-EQUIV="pragma" CONTENT="no-cache">
</HEAD>

<BODY>

<CENTER><H3>KTH extraktkorpus</H3></CENTER>
<TABLE><TR><TD bgcolor=#FFFFCC>
Nedan visas {SUMMARYDEGREE}% av originaltexten. Denna sammanfattning representerar det b�sta extraktet i enlighet med majoritetsbeslut baserat p� {NROFSUMMARIES} extrakt. V�rdet inom hakparenteser f�re varje mening representerar antalet g�nger denna mening blivit utvald till ett extrakt.<BR>
</TD></TR></TABLE>
{FILECHANGEWARNING}
<BR />

<TABLE align="center"><TR>
<TD><B>Denna texts ID �r: {FILEID}</B></TD><TD>
<A href="http://www.nada.kth.se/iplab/hlt/kthxc/index.php?fileid={FILEID}&mode=meta" target="new">
<IMG src="images/questionmark.gif" alt="Information om texten" border=0 valign="top" /></A>
</TD></TR></TABLE>

<B>{MODE}:</B><BR />
{TEXTTABLE}

<BR />
<FORM onSubmit="location.href='showsumstats.php?{BASELINE}cutoff='+this.sumsize.value+'&fileid={FILEID}';return false">
Visa sammanfattning p� <INPUT name="sumsize" type="number" size="3" value="{SUMMARYDEGREE}" /> procent ({SUMNROFWORDS} ord av {TOTALNROFWORDS}).<BR />
Sammanfattningen ovan �r baserad p� {NROFSUMMARIES} extrakt.<BR />
Kortaste extraktet representerat ovan �r {SHORTESTSUMMARY}%, l�ngsta �r {LONGESTSUMMARY}% och medell�ngden �r {MEANSUMMARY}%.<BR />
T�ckningen f�r <A href="showsumstats.php?fileid={FILEID}&cutoff={SUMMARYDEGREE}">Ideal sammanfattning (majoritetsval)</A> �r {VOTERECALL}% och precisionen f�r densamma �r {VOTEPRECISION}%.<BR />
T�ckningen f�r <A href="showsumstats.php?baseline=1&fileid={FILEID}&cutoff={SUMMARYDEGREE}">Baseline_1 (slumpvis distribution)</A> �r {BASELINE1RECALL}% och precisionen f�r densamma �r {BASELINE1PRECISION}%.<BR />
T�ckningen f�r <A href="showsumstats.php?baseline=2&fileid={FILEID}&cutoff={SUMMARYDEGREE}">Baseline_2 (inledande meningar, text)</A> �r {BASELINE2RECALL}% och precisionen f�r densamma �r {BASELINE2PRECISION}%.<BR />
T�ckningen f�r <A href="showsumstats.php?baseline=3&fileid={FILEID}&cutoff={SUMMARYDEGREE}">Baseline_3 (inledande meningar, stycke)</A> �r {BASELINE3RECALL}% och precisionen f�r densamma �r {BASELINE3PRECISION}%.<BR />
</FORM>
<A href="showsumstats.php?evalsum={FILEID}&cutoff={SUMMARYDEGREE}" target="_new">J�mf�r extern sammanfattning med idealsammanfattningen ovan</A><BR />
<A href="showsumstats.php?viewsums={FILEID}&cutoff={SUMMARYDEGREE}" target="_new">Visa alla sammanfattningar f�r den h�r texten</A><BR />
<A href="showsumstats.php?{BASELINE}viewsee={FILEID}&cutoff={SUMMARYDEGREE}" target="_new">Visa sammanfattning i SEE-format</A><BR />
<A href="showsumstats.php?viewfile={FILEID}" target="_new">Visa originaltext</A><BR />
<BR />

<A href="showsumstats.php">Tillbaka till korpusindex</A><BR />
<A href="index.php?language={LANGUAGE}&texttype={TEXTTYPE}">Tillbaka till extraktinsamling f�r aktuellt spr�k ({LANGUAGE} {TEXTTYPE})</A><BR />

</BODY>
</HTML>

<!-- Non-optional template markers *** Do NOT remove these! *** -->
<!-- FILECHANGEWARNING is a warning about the fact that the current file has been changed -->
<!-- FILEID is the unique identifier for the current file chosen from the corpus -->
<!-- TEXTTABLE is the table of choices generated from the text randomly chosen from the corpus -->
<!-- SUMMARYDEGREE is roughly how much of the text made it into the user summary -->

<!-- Optional template markers, use these as you feel neccessary
<!-- BASELINE is one of the available baselines -->
<!-- BASELINE1RECALL is the percentage of all votes covered by the baseline1 summary -->
<!-- BASELINE1PRECISION is the agreement amongst the extracts represented in the baseline1 summary -->
<!-- BASELINE2RECALL is the percentage of all votes covered by the baseline2 summary -->
<!-- BASELINE2PRECISION is the agreement amongst the extracts represented in the baseline2 summary -->
<!-- BASELINE3RECALL is the percentage of all votes covered by the baseline3 summary -->
<!-- BASELINE3PRECISION is the agreement amongst the extracts represented in the baseline3 summary -->
<!-- LANGUAGE is the current chosen language (i.e. svenska, danska, english etc.) -->
<!-- LONGESTSUMMMARY is the mean length of the longest summaries represented in the statistics -->
<!-- MEANSUMMMARY is the mean length of the summaries represented in the statistics -->
<!-- MODE is either majority vote or one of the baselines -->
<!-- NROFSUMMARIES is the number of represented in the statistics for the current text -->
<!-- SHORTESTSUMMMARY is the mean length of the shortest summaries represented in the statistics -->
<!-- TEXTTYPE is the current chosen texttype (i.e. news articles, conferens papers etc.) -->
<!-- VOTERECALL is the percentage of all votes covered by the majority vote summary -->
<!-- VOTEPRECISION is the agreement amongst the extracts represented in the majority vote summary -->
<!-- SUMNROFWORDS is the number of words contained in the current Majority Vote summary -->
<!-- TOTALNROFWORDS is the total number of words in the source text (original text) -->
