function legend(){
    var inp=document.getElementsByTagName("input");
    var er=document.getElementsByClassName("er");
    var item1=document.getElementsByClassName("l");
    var item2=document.getElementsByClassName("input-frame");
    for(var i=0;i<2;i++){
        item1[i].style.display="inline";
        item2[i].style.borderColor="#287AE6";
        item2[i].style.color="#287AE6";
        inp[i].style.padding="5px 14px 12px";
        inp[i].setAttribute("placeholder","");
        if(er[i].innerText!=""){
            item2[i].style.borderColor="#FF0000";
            item2[i].style.color="#FF0000";
        }
    }
}
function load1() {
    var inp=document.getElementsByTagName("input");
    var er=document.getElementsByClassName("er");
    var item1=document.getElementsByClassName("l");
    var item2=document.getElementsByClassName("input-frame");
    for(var i=0;i<2;i++){
        if(er[i].innerText!=""){
            item1[i].style.display="inline";
            inp[i].style.padding="5px 14px 12px";
            inp[i].setAttribute("placeholder","");
            item2[i].style.borderColor="#FF0000";
            item2[i].style.color="#FF0000";
        }
    }
}
function pass() {
    var icn=document.getElementsByTagName("i")[0];
    var item=document.getElementsByName("password")[0];
    if(item.getAttribute("type")=="text") {
        item.setAttribute("type", "password");
        icn.setAttribute("class","fas fa-eye-slash");
    }
    else {
        item.setAttribute("type", "text");
        icn.setAttribute("class","fas fa-eye");
    }
}

