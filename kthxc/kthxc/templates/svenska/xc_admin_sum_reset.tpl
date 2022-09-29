<!-- xc_admin_sum_show.tpl template (v. 2003-12-04) -->
<HTML>
<HEAD>
<TITLE>KTHxc: Nollställning av statistik {FILEID}</TITLE>
<LINK rel="stylesheet" type="text/css" href="templates/svenska/style.css" />
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<META HTTP-EQUIV="expires" CONTENT="Wed, 01 Jan 1997 00:00:01 GMT">
<META HTTP-EQUIV="pragma" CONTENT="no-cache">
</HEAD>

<BODY>

<CENTER><H3>KTH extraktkorpus</H3></CENTER>
<TABLE><TR><TD bgcolor=#FFFFCC>
Nedan visas tre stycken selektionsmenyer. Den första för <I>språk</I> tillgängliga i korpusen, den andra för <I>texttyper</I> tillgängliga för ett valt språk och den tredje för <I>texter</I> tillgängliga för en viss texttyp (för ett visst språk). Du kan använda dessa för att orientera dig korpusen och välja ut specifika filer som du vill titta på.<BR>
</TD></TR></TABLE>
<BR />

<FORM ACTION="resetstats.php?language={LANGUAGE}&texttype={TEXTTYPE}" METHOD="POST">

{NAVBAR}

<BR />

{LINKLIST}

<BR />
<INPUT type="button" value="Ta bort statistik ur databasen för ovan markerade rader" onclick="form.submit();" />

</FORM>

&nbsp;<INPUT type="button" value="Skapa tomma rader i denna kategori för de som saknas" onclick="location.href='resetstats.php?mode=fill&language={LANGUAGE}&texttype={TEXTTYPE}';" />
<BR />
<BR />
<BR />

<A href="showsumstats.php">Tillbaka till korpusindex</A><BR />
<A href="index.php?language={LANGUAGE}&texttype={TEXTTYPE}">Tillbaka till extraktinsamling för aktuellt språk ({LANGUAGE} {TEXTTYPE})</A><BR />

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
