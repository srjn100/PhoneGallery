<?php
session_start();
if(isset($_SESSION['userID']))
    $id=$_SESSION['userID'];
else
    header("location:../../index.php");
$conn=mysqli_connect("localhost","root","","phonegallery");
$err=$delItem=$delID=$delName='';
if(isset($_GET['delItem'])&&isset($_GET['delID'])&&isset($_GET['delName'])){
    $delItem=$_GET['delItem'];
    $delID=$_GET['delID'];
    $delName=$_GET['delName'];
    //echo "<a href='../../files/brands/$delName'>../../files/brands/$delName</a><br>";
    //echo "<a href='../$delName'>../$delName</a><br>";
    echo "delete $delItem $delID <br>";
    if(isset($_POST['submit'])){
        $res=mysqli_query($conn,"SELECT password FROM users WHERE userID='$id'");
        $dt=mysqli_fetch_row($res);
        //print_r($dt);
        if(isset($_POST['password'])&&md5($_POST['password'])==$dt[0]){
            if($delItem=='brand'){
                if(mysqli_query($conn,"DELETE FROM brands WHERE brandID='$delID'")){
                    removeDirectory("../../files/brands/$delName");
                    header("location:../brand_view.php");
                }
                else
                    echo "error ".mysqli_error($conn);
            }
            if($delItem=='phone'){
                if(mysqli_query($conn,"DELETE FROM phones WHERE phoneID='$delID'")){
                    removeDirectory("../../files/brands/$delName");
                    header("location:../phone_view.php");
                }
                else
                    echo "error ".mysqli_error($conn);
            }if($delItem=='image'){

                unlink("../$delName");
                if(mysqli_query($conn,"DELETE FROM images WHERE imageID='$delID'")){
                    header("location:../image_view.php");
                }
                else
                    echo "error ".mysqli_error($conn);
            }
        }
        else
            $err="invalid password";
    }
}
function removeDirectory($path) {
    $files = glob($path . '/*');
    foreach ($files as $file) {
        is_dir($file) ? removeDirectory($file) : unlink($file);
    }
    rmdir($path);
    return;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete</title>
</head>
<body style="text-align: center">
<form action="<?php echo $_SERVER['PHP_SELF']."?delItem=$delItem&delID=$delID&delName=$delName";?>" method="POST">
    enter password:
    <input type="password" name="password"><br>
    <input type="submit" name="submit"><br>
    <span><?php echo $err?></span>
</form>
</body>
</html>
