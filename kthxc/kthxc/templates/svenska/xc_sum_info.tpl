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
V�lkommen till KTH extraktkorpus. KTH extraktkorpus �r en korpus best�ende av meningar utvalda ur texter av testpersoner (t.ex. du) och inlagda som statistik i en databas. Denna statistik �r t�nkt att anv�ndas f�r att utv�rdera v�r automatiska textsammanfattare <A href="http://swesum.nada.kth.se/">SweSum</A>.<BR />
Tanken �r att se om <A href="http://swesum.nada.kth.se/">SweSum</A>, som ocks� v�ljer ut meningar ur en text f�r att bygga upp en sammanfattning av denna text, kan f�s att v�lja ut de meningar som flest personer har valt ut. F�r att �stadkomma detta beh�ver vi god statistik och hj�lp med urval fr�n m�nga personer. Sammanfatta g�rna s� m�nga texter du kan/vill/orkar men samanfatta helst varje text endast en g�ng. Du f�r g�rna �ven tipsa kollegor, v�nner och bekanta om extraktinsamlingen. Testpersonerna b�r dock ha god l�sf�rst�else f�r det svenska spr�ket.<BR />
Observera att ingen inl�mnad data kan knytas till dig personligen.<BR />
</TD></TR>
</TABLE>
<BR />

Din uppgift �r att 'bocka f�r' de meningar som du tycker borde lyftas ut f�r att utg�ra ett r�ttvisande extrakt av texten, dvs en sammanfattning.<BR />
F�r varje text f�r du veta hur m�nga valbara meningar som finns i denna text, t.ex:
<TABLE><TR><TD bgcolor=#FFFFCC>
Totalt antal valbara meningar i denna text: <B>{NROFCHOOSABLESENTENCES}</B><BR />
</TD></TR></TABLE>
<BR />
Du f�r �ven en riktlinje p� ungef�r hur m�nga meningar du maximalt b�r v�lja ut fr�n den aktuella texten:
<TABLE><TR><TD bgcolor=#FFFFCC>
Du b�r inte v�lja mer �n <B>{MAXNROFCHOOSABLESENTENCES}</B> meningar - m�let b�r vara att skapa en sammanfattning p� <B>20-30%</B> av originaltexten som �terspeglar det mest <I>centrala</I> och <I>viktiga</I> i originaltexten.<BR />
</TD></TR></TABLE>
<BR />
Det angivna antalet meningar �r som sagt endast en riktlinje. Ditt m�l b�r vara att skapa en sammanfattning p� 20-30% av originaltexten och som omfattar s� mycket som m�jligt av de fakta kring det centrala temat i nyhetstexten.<BR />
<BR />
N�r du bockar f�r en mening s� kommer den att markeras med <B STYLE="color:#000000;background:#ffff00">gul �verstrykningsf�rg</B> (fungerar ej i �ldre browsers). Detta f�r att du l�ttare skall kunna f� en �verblick �ver vilka meningar du valt, hur m�nga meningar du valt samt f�rdelningen av dessa �ver stycken.<BR />
<BR />
N�r du v�ljer <INPUT type="button" value="Visa sammanfattning" STYLE="background-color: #99CC66" /> f�r du en exakt angivelse (i procent ber�knat p� antal ord) p� hur l�ng din sammanfattning �r.<BR />
Om du efter att ha l�st igenom din sammanfattning k�nner att den k�nns sammanh�ngande, komplett och lagom l�ng s� kan du godk�nna denna om den ligger inom intervallet 5-60% av originaltextens l�ngd. Efter att du har skickad in din sammanfattning s� f�r du �ven veta lite om hur ditt urval av meningar svarade mot de urval som gjorts hitintills f�r den aktuella texten. Se inte detta som en uppmaning att lyckas b�ttre n�sta g�ng utan mer som lite kuriosa och skojigt gr�dde p� moset.<BR />
<BR />
Ifall en text presenteras som du vet att du redan har sammanfattat, eller om du k�nner att du av n�gon anledning inte kan sammanfatta en viss text, s� kan du alltid v�lja en ny text genom att klicka <INPUT type="button" value="Ny text" STYLE="background-color: #FF9999" />.<BR />
<BR />
Om ni �r flera personer som delar rum/dator och som vill bidra med extrakt till korpusen s� titta inte p� n�r n�gon annan g�r sina urval eftersom detta troligen i h�g grad p�verkar hur ditt urval d� kommer att se ut.<BR />
<BR />
Har du fr�gor g�llande extraktinsamlingen eller <A href="http://swesum.nada.kth.se">SweSum</A>? E-posta g�rna <A href="mailto:xmartin@nada.kth.se">Martin Hassel</A>.<BR />
Vill du l�sa mer om <A href="http://www.nada.kth.se/~hercules/textsammanfattning.html">Automatisk Textsammanfattning</A>?<BR />
<BR />
<BR />

<CENTER><INPUT type="button" value="St�ng" onclick="window.close();" /></CENTER><BR />

<BR />
<BR />
<I>Not. Tyv�rr verkar det finnas vissa inkompatibilitetsproblem med Netscapes webbl�sare, speciellt f�r Mac och Unix/Linux. Kom g�rna med tips!</I>

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
