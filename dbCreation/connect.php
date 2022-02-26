<?php
/*$conn=mysqli_connect('localhost','root','')
or trigger_error(mysqli_error($conn));
if(!$conn){
    echo mysqli_error($conn)."<br>";
}
else{
    printf("\n connnection successful \n");
    $sql1="CREATE DATABASE phoneGallery";
    if(mysqli_query($conn,$sql1))
        echo "database successfully created <br>";
    else
        echo "error in database creation";
    mysqli_close($conn);*/
    $conn=mysqli_connect('localhost','root','','phoneGallery')
    or trigger_error(mysqli_error($conn));
    if(!$conn)
        echo mysqli_error($conn)."<br>";

    else
        printf("\n connnection successful \n");
   // }
?>