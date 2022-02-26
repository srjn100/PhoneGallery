<?php
$rate='';
$text= '';
if(isset($_POST['submit'])){
    if(isset($_POST['text'])and !empty($_POST['text'])){
        $text=$_POST['text'];
        
    }
    else{
        echo "error";
    }
    if(isset($_POST['Rate'])){
       $rate= $_POST['Rate'];
       
    }
   

    if($conn=mysqli_connect("localhost","root","","phonegallery")){

$sql="INSERT into  ratesnreviews (rating,review,userID,phoneID)
values($rate,'$text',2, 18)";

if(mysqli_query($conn,$sql)){
    echo " inserted";


}
}
}

?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
     <div class="rating">

                      <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                        <h3>Rate us </h3>
                        <input type="radio" name="Rate" value="1">
                        <input type="radio" name="Rate" value="2">
                        <input type="radio" name="Rate" value="3">
                        <input type="radio" name="Rate" value="4">
                        <input type="radio" name="Rate" value="5">
                        <h3>Review us</h3>
                       <textarea type="text" name="text"></textarea>
                       <br>
                       <input type="submit" name="submit" value="send">
                    

                        </form>









                    </div>


</body>
</html>
  