<!-- xc_sum_collect.tpl template -->
<HTML>
<HEAD>
<TITLE>KTHxc: {FILEID}</TITLE>
<LINK rel="stylesheet" type="text/css" href="templates/svenska/style.css" />
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<META HTTP-EQUIV="expires" CONTENT="Wed, 01 Jan 1997 00:00:01 GMT">
<META HTTP-EQUIV="pragma" CONTENT="no-cache">
{JSCODE}
</HEAD>

<BODY>

<CENTER><H3>KTH extraktkorpus</H3></CENTER>
<TABLE><TR><TD bgcolor=#FFFFCC>
Din uppgift �r att 'bocka f�r' de meningar som du tycker borde lyftas ut f�r att utg�ra ett r�ttvisande extrakt av texten, dvs en sammanfattning.<BR />
Totalt antal valbara meningar i denna text �r <I>{NROFCHOOSABLESENTENCES}</I> och av dessa b�r du inte v�lja mer �n <I>{MAXNROFCHOOSABLESENTENCES}</I> - m�let b�r vara att skapa en r�ttvisande sammanfattning p� <I>20-30%</I> av originaltexten (detta �r dock bara en riktlinje, ingen regel) som �terspeglar det mest <I>centrala</I> och <I>viktiga</I> i originaltexten.<BR />
<A href="http://www.nada.kth.se/iplab/hlt/kthxc/index.php?fileid={FILEID}&mode=info" target="new"><U>Mer information och utf�rliga instruktioner</U> [L�s minst en g�ng!]</A>
</TD></TR></TABLE>
{FILECHANGEWARNING}

<TABLE align="center"><TR>
<TD><B>Denna texts ID �r: {FILEID}</B></TD><TD>
<A href="http://www.nada.kth.se/iplab/hlt/kthxc/index.php?fileid={FILEID}&mode=meta" target="new">
<IMG src="images/questionmark.gif" alt="Information om texten" border=0 valign="top" /></A>
</TD></TR></TABLE>

<FORM>

{TEXTTABLE}

<INPUT type="button" value="Visa sammanfattning" onClick="openSum()" STYLE="background-color: #99CC66" />
<INPUT type="button" value="Ny text" onClick="if(confirm('Vill du verkligen ha en ny text?')) { window.location.reload(); }" STYLE="background-color: #FF9999" />
<BR />

</FORM>

<BR />
<I>P�minnelse: </I>Totalt antal valbara meningar i denna text: <B>{NROFCHOOSABLESENTENCES}</B><BR />
Du b�r inte v�lja mer �n <B>{MAXNROFCHOOSABLESENTENCES}</B> meningar - m�let b�r vara att skapa en sammanfattning p� <B>20-30%</B> av originaltexten som �terspeglar det mest <I>centrala</I> och <I>viktiga</I> i originaltexten.<BR />

<BR />
Har du fr�gor g�llande extraktinsamlingen eller <A href="http://swesum.nada.kth.se">SweSum</A>? E-posta g�rna <A href="mailto:xmartin@nada.kth.se">Martin Hassel</A>.
<BR />
Observera att ingen inl�mnad data kan knytas till dig personligen.
<BR />

<BR />
<I>Not. Tyv�rr verkar det finnas vissa inkompatibilitetsproblem med Netscapes webbl�sare, speciellt f�r Mac och Unix/Linux. Kom g�rna med tips!</I>

</BODY>
</HTML>

<!-- Non-optional template markers *** Do NOT remove these! *** -->
<!-- FILECHANGEWARNING is a warning about the fact that the current file has been changed -->
<!-- FILEID is the unique identifier for the current file chosen from the corpus -->
<!-- JSCODE is a block of JavaScript code separated from the template for clartity -->
<!-- TEXTTABLE is the table of choices generated from the text randomly chosen from the corpus -->

<!-- Optional template markers, use these as you feel neccessary
<!-- METAINFO may contain meta data for the current file chosen from the corpus -->
<!-- NROFCHOOSABLESENTENCES is the number of sentences (text elements) in the text -->
<!-- MAXNROFCHOOSABLESENTENCES is roughly 60% of NROFCHOOSABLESENTENCES -->
<!-- OPTNROFCHOOSABLESENTENCES is roughly 30% of NROFCHOOSABLESENTENCES -->
