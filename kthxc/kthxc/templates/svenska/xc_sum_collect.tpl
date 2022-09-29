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
Din uppgift är att 'bocka för' de meningar som du tycker borde lyftas ut för att utgöra ett rättvisande extrakt av texten, dvs en sammanfattning.<BR />
Totalt antal valbara meningar i denna text är <I>{NROFCHOOSABLESENTENCES}</I> och av dessa bör du inte välja mer än <I>{MAXNROFCHOOSABLESENTENCES}</I> - målet bör vara att skapa en rättvisande sammanfattning på <I>20-30%</I> av originaltexten (detta är dock bara en riktlinje, ingen regel) som återspeglar det mest <I>centrala</I> och <I>viktiga</I> i originaltexten.<BR />
<A href="http://www.nada.kth.se/iplab/hlt/kthxc/index.php?fileid={FILEID}&mode=info" target="new"><U>Mer information och utförliga instruktioner</U> [Läs minst en gång!]</A>
</TD></TR></TABLE>
{FILECHANGEWARNING}

<TABLE align="center"><TR>
<TD><B>Denna texts ID är: {FILEID}</B></TD><TD>
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
<I>Påminnelse: </I>Totalt antal valbara meningar i denna text: <B>{NROFCHOOSABLESENTENCES}</B><BR />
Du bör inte välja mer än <B>{MAXNROFCHOOSABLESENTENCES}</B> meningar - målet bör vara att skapa en sammanfattning på <B>20-30%</B> av originaltexten som återspeglar det mest <I>centrala</I> och <I>viktiga</I> i originaltexten.<BR />

<BR />
Har du frågor gällande extraktinsamlingen eller <A href="http://swesum.nada.kth.se">SweSum</A>? E-posta gärna <A href="mailto:xmartin@nada.kth.se">Martin Hassel</A>.
<BR />
Observera att ingen inlämnad data kan knytas till dig personligen.
<BR />

<BR />
<I>Not. Tyvärr verkar det finnas vissa inkompatibilitetsproblem med Netscapes webbläsare, speciellt för Mac och Unix/Linux. Kom gärna med tips!</I>

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
