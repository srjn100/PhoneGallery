function select(obj) {
    var val=obj[obj.selectedIndex].value;
    var phoneID=document.getElementById("phoneID");

    var op="<?php echo select("+val+")?>";
    alert(op);
    phoneID.innerHTML+="<"+"?php echo select("+val+")?>";
}
<script>
/*function select(obj) {
    var val=obj[obj.selectedIndex].value;
    var phoneID=document.getElementById("phoneID");
    var phone=new Array(<?php //echo $cPhone;?>);
    for(var i=0;i<phone.length;i++){
        var phone[i]=new Array(3);
    }
    for(var i=0;i<phone.length;i++){

        phone[i][0]=<?php// echo "$pd[<script>document.writeln(i);</script>][2]";?>;
        phone[i][1]=<?php// echo $pd[?>i<?php//][0];?>;
        phone[i][2]=<?php// echo $pd[?>i<?php//][1];?>;
    }

    alert(op);
    phoneID.innerHTML+="<"+"?php echo select("+val+")?>";
}*/
</script>