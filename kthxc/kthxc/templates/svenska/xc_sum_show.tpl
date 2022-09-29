<!-- xc_sum_show.tpl template -->
<HTML>
<HEAD>
<TITLE>Sammanfattning: {FILEID}</TITLE>
<LINK rel="stylesheet" type="text/css" href="templates/svenska/style.css" />
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<META HTTP-EQUIV="expires" CONTENT="Wed, 01 Jan 1997 00:00:01 GMT">
<META HTTP-EQUIV="pragma" CONTENT="no-cache">
</HEAD>

<BODY>

<CENTER><H3>Din sammanfattning av {FILEID}</H3></CENTER>

<HR />
<FORM>

{SUMMARY}

<BR />
<HR />

<TABLE bgcolor=#FFFFCC><TD>
Du har valt {NROFCHOSENSENTENCES} av {NROFCHOOSABLESENTENCES} meningar. Dessa motsvarar ca {SUMMARYDEGREE}% av originaltexten. Om du valt mindre �n 5% eller mer �n 60% av texten s� kan du inte godk�nna sammanfattningen, en bra riktlinje �r 20-30% �ven om detta inte passar alla texter.<BR />
�r du n�jd med denna sammanfattning?
</TD></TABLE>
<BR />
<INPUT type="button" value="Godk�nn sammanfattning" onclick="window.location='showsum.php?fileid={FILEID}&sumarray={SUMARRAY}&sumlen={SUMMARYDEGREE}&mode=save'"{VISIBILITY} STYLE="background-color: #99CC66" />
<INPUT type="button" value="G� tillbaka" onclick="window.close();" STYLE="background-color: #FF9999" /><BR />
</FORM>

</BODY>
</HTML>

<!-- Non-optional template markers *** Do NOT remove these! *** -->
<!-- FILEID is the unique identifier for the current file chosen from the corpus -->
<!-- SUMMARY is the summary generated from sentences chosen by the user -->
<!-- SUMARRAY is an array representing sentences chosen (and not chosen) by the user -->
<!-- VISIBILITY is is the state of the button for adding the summary to the database -->

<!-- Optional template markers, use these as you feel neccessary -->
<!-- FILEID is the unique identifier for the current file chosen from the corpus -->
<!-- NROFCHOSENSENTENCES is the number of sentences the user picked -->
<!-- NROFCHOOSABLESENTENCES is the number of sentences there where to choose from -->
<!-- SUMMARYDEGREE is roughly how much of the text made it into the user summary -->
