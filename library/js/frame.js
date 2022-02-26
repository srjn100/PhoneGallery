function expand(ob){
    var id=ob.id;
    var citem=document.getElementsByClassName("sub-menu");
    var item=document.getElementById(id+"-menu");
    if(item.style.display=="block")
        item.style.display="none";
    else {
        item.style.display = "block"
        for (var i = 0; i < citem.length; i++)
            if (citem[i].style.display == "block")
                citem[i].style.display = "none";
        item.style.display = "block"
    }
}

