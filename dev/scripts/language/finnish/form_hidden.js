﻿function loadTxt()
{
    var txtLang = document.getElementsByName("txtLang");
    txtLang[0].innerHTML = "Nimi";
    txtLang[1].innerHTML = "Arvo";

    document.getElementById("btnCancel").value = "Peruuta";
    document.getElementById("btnInsert").value = "Liit\u00E4";
    document.getElementById("btnApply").value = "K\u00E4yt\u00E4";
    document.getElementById("btnOk").value = " OK ";
}
function writeTitle()
{
    document.write("<title>" + "Piilotettu kentt\u00E4" + "</title>")
}
