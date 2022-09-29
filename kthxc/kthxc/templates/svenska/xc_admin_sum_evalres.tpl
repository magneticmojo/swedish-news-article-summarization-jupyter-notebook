<!-- xc_admin_sum_evalres.tpl template -->
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
<CENTER><H4>{FILEID}</H4></CENTER>
<TABLE><TR><TD bgcolor=#FFFFCC>
<BR>
</TD></TR></TABLE>
<BR />

Överlapp på meningsnivå: {SENTENCEOVERLAP}%<BR />
Booleskt överlapp på ordnivå: {BOOLWORDOVERLAP}%<BR />
Frekvensviktat överlapp på ordnivå: {FREQWORDOVERLAP}%<BR />
Booleskt överlapp på trunkerad ordnivå: {BOOLTWORDOVERLAP}%<BR />
Frekvensviktat överlapp på trunkerad ordnivå: {FREQTWORDOVERLAP}%<BR />

<BR />

<U>Extraktionsenheter (t.ex. meningar) i idealsammanfattningen som <B>inte</B> förekommer i systemsammanfattningen:</U><BR />
{IDEALNOTINSUM}

<BR />
<BR />

<U>Extraktionsenheter (t.ex. meningar) i systemsammanfattningen som <B>inte</B> förekommer i idealsammanfattningen:</U><BR />
{SUMNOTINIDEAL}

<BR />
<BR />

<U>Idealsammanfattningen:</U><BR />
{IDEALSUMMARY}

<BR />
<BR />

<U>Systemsammanfattningen:</U><BR />
{SYSTEMSUMMARY}

<BR />
<BR />

<INPUT type="button" value="Stäng" onclick="window.close();" STYLE="background-color: #99CC66" /><BR />

</BODY>
</HTML>

<!-- Non-optional template markers *** Do NOT remove these! *** -->
<!-- IDEALSUM is the ideal summary, or Gold Standard, at the given compression rate -->
<!-- FILEID is the unique identifier for the current file chosen from the corpus -->
<!-- SUMMARYDEGREE is roughly how much of the text made it into the user summary -->

<!-- Optional template markers, use these as you feel neccessary -->
