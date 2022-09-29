<!-- xc_admin_sum_show.tpl template (v. 2003-12-13) -->
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
Nedan visas tre stycken selektionsmenyer. Den f�rsta f�r <I>spr�k</I> tillg�ngliga i korpusen, den andra f�r <I>texttyper</I> tillg�ngliga f�r ett valt spr�k och den tredje f�r <I>texter</I> tillg�ngliga f�r en viss texttyp (f�r ett visst spr�k). Du kan anv�nda dessa f�r att orientera dig korpusen och v�lja ut specifika filer som du vill titta p�.<BR>
</TD></TR></TABLE>
<BR />

<FORM onSubmit="location.href='showsumstats.php?cutoff='+sumsize.value+'&fileid='+(languages.options[languages.selectedIndex].value)+'->'+(texttypes.options[texttypes.selectedIndex].value)+'->'+(textfiles.options[textfiles.selectedIndex].value);return false">

{NAVBAR}

<BR />

{LINKLIST}

<P {NAVBAR_VISIBILITY}>
Visa ideal sammanfattning p� <INPUT name="sumsize" type="number" size="3" value="{SUMMARYDEGREE}" /> procent.<BR />
<A href="showsumstats.php?mode=indexlinklist&language={LANGUAGE}&texttype={TEXTTYPE}">

Visa textindex som l�nklista

</A>
<BR />
</P>

</FORM>

<A href="showsumstats.php">Tillbaka till korpusindex</A><BR />
<A href="index.php?language={LANGUAGE}&texttype={TEXTTYPE}">Tillbaka till extraktinsamling f�r aktuellt spr�k ({LANGUAGE} {TEXTTYPE})</A><BR />

</BODY>
</HTML>

<!-- Non-optional template markers *** Do NOT remove these! *** -->
<!-- NAVBAR is a Navigation Bar for navigating the corpus with -->

<!-- Optional template markers, use these as you feel neccessary
<!-- FILEID is the unique identifier for the current file chosen from the corpus -->
<!-- LANGUAGE is the current chosen language (i.e. svenska, danska, english etc.) -->
<!-- LINKLIST is a overview table for navigating the corpus with, rather than the NavBar-->
<!-- NAVBAR_VISIBILITY is for switching visibility for parts of the NavBar ON and OFF -->
<!-- SUMMARYDEGREE is roughly how much of the text made it into the user summary -->
<!-- TEXTTYPE is the current chosen text type (i.e. news articles, conferens papers etc.) -->
