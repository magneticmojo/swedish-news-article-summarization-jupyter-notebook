<!-- xc_sum_info.tpl template -->
<HTML>
<HEAD>
<TITLE>KTHxc: Info - {FILEID}</TITLE>
<LINK rel="stylesheet" type="text/css" href="templates/svenska/style.css" />
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<META HTTP-EQUIV="expires" CONTENT="Wed, 01 Jan 1997 00:00:01 GMT">
<META HTTP-EQUIV="pragma" CONTENT="no-cache">
</HEAD>

<BODY>

<CENTER><H3>KTH extraktkorpus</H3></CENTER>
<BR />

<TABLE>
<TR><TD bgcolor=#FFFFAA>
Välkommen till KTH extraktkorpus. KTH extraktkorpus är en korpus bestående av meningar utvalda ur texter av testpersoner (t.ex. du) och inlagda som statistik i en databas. Denna statistik är tänkt att användas för att utvärdera vår automatiska textsammanfattare <A href="http://swesum.nada.kth.se/">SweSum</A>.<BR />
Tanken är att se om <A href="http://swesum.nada.kth.se/">SweSum</A>, som också väljer ut meningar ur en text för att bygga upp en sammanfattning av denna text, kan fås att välja ut de meningar som flest personer har valt ut. För att åstadkomma detta behöver vi god statistik och hjälp med urval från många personer. Sammanfatta gärna så många texter du kan/vill/orkar men samanfatta helst varje text endast en gång. Du får gärna även tipsa kollegor, vänner och bekanta om extraktinsamlingen. Testpersonerna bör dock ha god läsförståelse för det svenska språket.<BR />
Observera att ingen inlämnad data kan knytas till dig personligen.<BR />
</TD></TR>
</TABLE>
<BR />

Din uppgift är att 'bocka för' de meningar som du tycker borde lyftas ut för att utgöra ett rättvisande extrakt av texten, dvs en sammanfattning.<BR />
För varje text får du veta hur många valbara meningar som finns i denna text, t.ex:
<TABLE><TR><TD bgcolor=#FFFFCC>
Totalt antal valbara meningar i denna text: <B>{NROFCHOOSABLESENTENCES}</B><BR />
</TD></TR></TABLE>
<BR />
Du får även en riktlinje på ungefär hur många meningar du maximalt bör välja ut från den aktuella texten:
<TABLE><TR><TD bgcolor=#FFFFCC>
Du bör inte välja mer än <B>{MAXNROFCHOOSABLESENTENCES}</B> meningar - målet bör vara att skapa en sammanfattning på <B>20-30%</B> av originaltexten som återspeglar det mest <I>centrala</I> och <I>viktiga</I> i originaltexten.<BR />
</TD></TR></TABLE>
<BR />
Det angivna antalet meningar är som sagt endast en riktlinje. Ditt mål bör vara att skapa en sammanfattning på 20-30% av originaltexten och som omfattar så mycket som möjligt av de fakta kring det centrala temat i nyhetstexten.<BR />
<BR />
När du bockar för en mening så kommer den att markeras med <B STYLE="color:#000000;background:#ffff00">gul överstrykningsfärg</B> (fungerar ej i äldre browsers). Detta för att du lättare skall kunna få en överblick över vilka meningar du valt, hur många meningar du valt samt fördelningen av dessa över stycken.<BR />
<BR />
När du väljer <INPUT type="button" value="Visa sammanfattning" STYLE="background-color: #99CC66" /> får du en exakt angivelse (i procent beräknat på antal ord) på hur lång din sammanfattning är.<BR />
Om du efter att ha läst igenom din sammanfattning känner att den känns sammanhängande, komplett och lagom lång så kan du godkänna denna om den ligger inom intervallet 5-60% av originaltextens längd. Efter att du har skickad in din sammanfattning så får du även veta lite om hur ditt urval av meningar svarade mot de urval som gjorts hitintills för den aktuella texten. Se inte detta som en uppmaning att lyckas bättre nästa gång utan mer som lite kuriosa och skojigt grädde på moset.<BR />
<BR />
Ifall en text presenteras som du vet att du redan har sammanfattat, eller om du känner att du av någon anledning inte kan sammanfatta en viss text, så kan du alltid välja en ny text genom att klicka <INPUT type="button" value="Ny text" STYLE="background-color: #FF9999" />.<BR />
<BR />
Om ni är flera personer som delar rum/dator och som vill bidra med extrakt till korpusen så titta inte på när någon annan gör sina urval eftersom detta troligen i hög grad påverkar hur ditt urval då kommer att se ut.<BR />
<BR />
Har du frågor gällande extraktinsamlingen eller <A href="http://swesum.nada.kth.se">SweSum</A>? E-posta gärna <A href="mailto:xmartin@nada.kth.se">Martin Hassel</A>.<BR />
Vill du läsa mer om <A href="http://www.nada.kth.se/~hercules/textsammanfattning.html">Automatisk Textsammanfattning</A>?<BR />
<BR />
<BR />

<CENTER><INPUT type="button" value="Stäng" onclick="window.close();" /></CENTER><BR />

<BR />
<BR />
<I>Not. Tyvärr verkar det finnas vissa inkompatibilitetsproblem med Netscapes webbläsare, speciellt för Mac och Unix/Linux. Kom gärna med tips!</I>

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
