function expand() {
    var bar=document.getElementsByClassName("sideB")[0];
    var link=document.getElementsByClassName("link")
    bar.style.width="12rem";
    for(var i=0;i<link.length;i++)
    link[i].style.display="inline-block";
}
function collapse(){
    var bar=document.getElementsByClassName("sideB")[0];
    var link=document.getElementsByClassName("link");
    var slink=document.getElementsByClassName("slink");
    bar.style.width="3rem";
    for(var i=0;i<link.length;i++)
        link[i].style.display="none";
    for(var i=0;i<slink.length;i++)
        slink[i].style.display="none";
}
function toggle(ind) {
    var slink=document.getElementsByClassName("slink")[ind];

    if(slink.style.display=="none")
        slink.style.display="block";
    else
        slink.style.display="none";

}
