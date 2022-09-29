<SCRIPT language="javascript">
<!-- // Hide script from older browsers
  function openSum() {
    summary = "";
    sentencearray = "";
    for(i=0;i<{NROFSENTENCES};i++) {
      if(document.all) {
        // MS Internet Explorer 4 & 5
        if(document.all["S"+i].checked) {
          sentencearray = sentencearray + "1";
          summary = summary + document.all["S"+i].value + "<BR>";
        } else {
          sentencearray = sentencearray + "0";
        }
      } else if(document.getElementById) {
        // Netscape 6 (or for that matter MSIE5)
        if(document.getElementById("S"+i).checked) {
          sentencearray = sentencearray + "1";
          summary = summary + document.getElementById("S"+i).value + "<BR>";
        } else {
          sentencearray = sentencearray + "0";
        }
      } else if(document.forms) {
        //Netscape 4
        if(document.forms[0].elements[i].checked) {
          sentencearray = sentencearray + "1";
          summary = summary + document.forms[0].elements[i].value + "<BR>";
        } else {
          sentencearray = sentencearray + "0";
        }
      }
    }
    window.open("showsum.php?fileid={FILEID}&filewords={NROFWORDS}&filesents={NROFCHOOSABLESENTENCES}&sumarray=" + sentencearray + "&sum=" + summary,"","scrollbars=yes, width=600, height=400");
  }
  function restyle(id_name,class_name) {
    if(document.getElementById) {
      document.getElementById(id_name).className=class_name;
    }
  }
//-->
</SCRIPT>
