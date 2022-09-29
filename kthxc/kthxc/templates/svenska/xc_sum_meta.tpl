<!-- xc_sum_meta.tpl template -->
<HTML>
<HEAD>
<TITLE>KTHxc: Copyright - {FILEID}</TITLE>
<LINK rel="stylesheet" type="text/css" href="templates/svenska/style.css" />
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<META HTTP-EQUIV="expires" CONTENT="Wed, 01 Jan 1997 00:00:01 GMT">
<META HTTP-EQUIV="pragma" CONTENT="no-cache">
</HEAD>

<BODY>

<CENTER><H3>KTH extraktkorpus</H3></CENTER>
<BR />

<TABLE align="center">
<TR><TD bgcolor=#FFFFAA>
<B>Denna texts ID är:<BR />
{FILEID}</B><BR />
{METAINFO}
</TD></TR>
<TR><TD bgcolor=#FFFFCC>
<I>{USERTXTSUM}</I> gång(er) har denna text sammanfattats på den här datorn.<BR />
Totalt har det sammanfattats <I>{USERTOTSUMS}</I> text(er) på den här datorn.
</TD></TR>
</TABLE>

<BR />
<CENTER>Har du frågor gällande extraktinsamlingen eller <A href="http://swesum.nada.kth.se">SweSum</A>?<BR />
E-posta gärna <A href="mailto:xmartin@nada.kth.se">Martin Hassel</A>.</CENTER>
<BR />
<BR />

<CENTER><INPUT type="button" value="Stäng" onclick="window.close();" /></CENTER><BR />

</FORM>
</BODY>
</HTML>

<!-- Non-optional template markers *** Do NOT remove these! *** -->
<!-- JSCODE is a block of JavaScript code separated from the template for clartity -->
<!-- TEXTTABLE is the table of choices generated from the text randomly chosen from the corpus -->

<!-- Optional template markers, use these as you feel neccessary
<!-- FILEID is the unique identifier for the current file chosen from the corpus -->
<!-- METAINFO may contain meta data for the current file chosen from the corpus -->
<!-- NROFCHOOSABLESENTENCES is the number of sentences (text elements) in the text -->
<!-- MAXNROFCHOOSABLESENTENCES is roughly 60% of NROFCHOOSABLESENTENCES -->
<!-- OPTNROFCHOOSABLESENTENCES is roughly 30% of NROFCHOOSABLESENTENCES -->
