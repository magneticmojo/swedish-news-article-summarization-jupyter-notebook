KTH eXtract Corpus (KTHxc)
---------------------------

* Corpus format
The documents in the text part of the corpus should adhere to standard HTML, with the exception that in the <BODY> of the document only one extractable segment (word, phrase, sentence, paragraph, or whatever segment size is chosen) should be represented on each line of text, ie a newline character (not a <BR> tag) should separate each extractable segment.
Worth noting is that when collection of statistics have begun, no changes in the text should be done. This to ensure that all informants submitting selection statistics to the corpus database have seen the same text. To promote this a checksum is taken of the text as it is entered into the corpus, and if this checksum changes the text is omitted from random selection and in all other cases a warning that the text has been changed is displayed.


* Administrator of statistics collection for respective language->texttype
Danska->Nyhedstekster: Hercules Dalianis <hercules@nada.kth.se>
Svenska->Nyhetstexter: Martin Hassel <xmartin@nada.kth.se>


This README.txt will hopefully be updated as need for it arises :)
