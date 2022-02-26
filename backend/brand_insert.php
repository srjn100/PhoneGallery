<?php
session_start();
/*
$id;
if(isset($_SESSION['uinput']))
$id=$_SESSION['uinput'];//$_GET['id']
else
    header("location:../index.php");
*/
if(isset($_SESSION['userID']))
    $id=$_SESSION['userID'];
else
    header("location:../index.php");
//$id=$_GET['id'];

$conn=mysqli_connect("localhost","root","","phonegallery");
if($conn)
    $asql="SELECT * FROM users 
WHERE userID = '$id'";
$ares=mysqli_query($conn,$asql);
$data=[];
if(mysqli_num_rows($ares)==1){
    $data=mysqli_fetch_assoc($ares);
}
else
    echo "error ".mysqli_error($conn);


?>
<?php
$brandName='';
$err=[];
if(isset($_POST['submit'])){
    $err=[];
    if(isset($_POST['brandName'])&&!empty($_POST['brandName'])){
        $brandName=strtolower($_POST['brandName']);
    }
    else{
        $err['brandName']="enter brand name";
    }
    if(!($_FILES['brandImagePath']['name'])) {
        $err['brandImagePath']="file not selected";
    }
    if(count($err)==0){
        $upsql="SELECT * FROM brands where brandName='$brandName' ";
        if($res=mysqli_query($conn,$upsql)){
            if(mysqli_num_rows($res)>0)
                $err['brandImagePath']="brand already exists";
            else{
                $imgDir="../files/brands/$brandName";
                if(!file_exists($imgDir))
                    mkdir($imgDir);
                else{
                    $file=basename($_FILES['brandImagePath']['name']);
                    $fileType=strtolower(pathinfo($file,PATHINFO_EXTENSION));
                    $newFile=$imgDir."/"."$brandName.".$fileType;
                    $fileDBpath="../".$imgDir."/"."$brandName.".$fileType;
                    if($fileType!="jpg"&&$fileType!="png"&&$fileType!="jpeg"&&$fileType!="gif"&&$fileType!="svg"){
                        $err['brandImagePath']="only jpg,jpeg,png,gif,svg allowed";
                    }
                    elseif(move_uploaded_file($_FILES['brandImagePath']['tmp_name'],$newFile)){
                        $upsql1="INSERT INTO brands(brandName,brandImagePath,userID)
                                 VALUES ('$brandName','$fileDBpath','$id')";
                        if(mysqli_query($conn,$upsql1)) {
                            echo "<script> alert(\"the file was uploaded\");</script>";
                            header("location:brand_view.php?id=$id");
                        }
                        else
                        echo "<script> alert(\"".mysqli_error($conn)."\")</script>";
                    }
                    else{
                        echo "<script> alert(\"please try again\")</script>";
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" style="font-size: 13px;font-family: Roboto, Arial, sans-serif;">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Insert Brand</title>
    <link rel="stylesheet" type="text/css" href="../library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="../library/css/frame.css">
    <link rel="stylesheet" href="../library/css/brandForm.css">
    <script src="../library/js/frame.js"></script>
</head>
<body>
<div class="container">
    <div class="top-nav">
        <div class="tdiv">PHONE GALLERY</div>
        <div class="uwrap">
            <div class="udiv" id="self" onclick="expand(this);">
                <div class="udivl"><?php
                    echo $data['userName'];
                    ?></div>
                <div class="udivr">
                    <i class="fas fa-user-astronaut fa-2x"></i>
                </div>
            </div>
        </div>

    </div>
    <div class="body">
        <div class="side-nav">

            <a href="dashboard.php?id=<?php echo $id;?>" class="menu-item">
                <i class="fas fa-tachometer-alt fa-2x"></i>
                <span>DASHBOARD</span>
            </a>
            <a href="#" class="menu-item active" id="brand" onclick="expand(this);">
                <i class="fas fa-bold fa-2x"></i>
                <span>BRANDS</span>
            </a>
            <a href="#" class="menu-item" id="phone" onclick="expand(this);">
                <i class="fas fa-mobile fa-2x"></i>
                <span>PHONES</span>
            </a>
            <a href="#" class="menu-item" id="image" onclick="expand(this);">
                <i class="fas fa-images fa-2x"></i>
                <span>IMAGES</span>
            </a>
            <a href="#" class="menu-item" id="admin" onclick="expand(this);">
                <i class="fas fa-user-astronaut fa-2x"></i>
                <span>ADMINS</span>
            </a>
            <a href="users_view.php?id=<?php echo $id?>" class="menu-item">
                <i class="fas fa-user-alt fa-2x"></i>
                <span>USERS</span>
            </a>
        </div>
        <div class="content">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']."?id=$id"?>" enctype="multipart/form-data">
                <div class="brand-form">
                    <div class="brand-head"><h1 class="login-h1">
                        <span class="login-heading">Brand Insert Form</span>
                    </h1></div>
                    <div class="brand-input">
                        <fieldset class="input-frame" >
                            <legend class="l" >Enter Brand Name</legend>
                            <div class="input" >
                                <input type="text" name="brandName" placeholder="Brand Name">
                            </div>
                        </fieldset>
                    </div>
                    <div class="error"><span class="er">
                <?php if(isset($err['brandName']))echo $err['brandName'];?>
                </span></div>
                    <div class="brand-input">
                            <div class="input upin" >
                                <input type="file" name="brandImagePath" id="upload-button" hidden="hidden">
                                <button type="button" id="up-button">Choose a file</button>
                            </div>
                    </div>
                    <div class="error"><span class="er">
                <?php if(isset($err['brandImagePath']))echo $err['brandImagePath'];?>
            </span></div>
                    <div class="input-d">
                        <div class="brand-submit">
                            <input type="submit" name="submit" value="Insert">
                        </div>
                    </div>
                </div>

            </form>
            <div class="self" id="self-menu">
                <div class="self-top">
                    <div class="self-photo">
                        <div class="self-img-contain">
                            <img class="self-img" src="<?php echo $data['userImagePath']?>" alt="userImage">
                        </div>
                    </div>
                    <div class="self-info">
                        <div class="self-name">
                            <?php
                            echo strtoupper($data['firstName']." ".$data['lastName']);
                            echo "</div><div class='self-email'>";
                            echo $data['email'];
                            echo "</div>";
                            ?>
                        </div>

                    </div>
                    <div class="self-bottom">
                        <a href="<?php echo "edit_self.php?id=$id"?>" class="self-link">Edit</a>
                        &nbsp;
                        <a href="../logout.php" onclick="return confirm('Are u sure to logout');" class="self-link">
                            Logout</a>
                    </div>
                </div>
                <div class="sub-menu" id="brand-menu">
                    <a href="#" class="sub-menu-item inactive">
                        <i class="fas fa-arrow-down fa-1x active"></i>
                        <span class="active">INSERT</span>
                    </a>
                    <a href="brand_view.php?id=<?php echo $id;?>" class="sub-menu-item">
                        <i class="fas fa-eye fa-1x"></i>
                        <span>VIEW</span>
                    </a>
                </div>
                <div class="sub-menu" id="phone-menu">
                    <a href="phone_insert.php?id=<?php echo $id;?>" class="sub-menu-item inactive">
                        <i class="fas fa-arrow-down fa-1x"></i>
                        <span>INSERT</span>
                    </a>
                    <a href="phone_view.php?id=<?php echo $id;?>" class="sub-menu-item">
                        <i class="fas fa-eye fa-1x"></i>
                        <span>VIEW</span>
                    </a>
                </div>
                <div class="sub-menu" id="image-menu">
                    <a href="image_insert.php?id=<?php echo $id;?>" class="sub-menu-item inactive">
                        <i class="fas fa-arrow-down fa-1x"></i>
                        <span>INSERT</span>
                    </a>
                    <a href="image_view.php?id=<?php echo $id;?>" class="sub-menu-item">
                        <i class="fas fa-eye fa-1x"></i>
                        <span>VIEW</span>
                    </a>
                </div>
                <div class="sub-menu" id="admin-menu">
                    <a href="admins_insert.php?id=<?php echo $id;?>" class="sub-menu-item inactive">
                        <i class="fas fa-arrow-down fa-1x"></i>
                        <span>INSERT</span>
                    </a>
                    <a href="admins_view.php?id=<?php echo $id?>" class="sub-menu-item">
                        <i class="fas fa-eye fa-1x"></i>
                        <span>VIEW</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <script>
        const fileBtn=document.getElementById("upload-button");
        const upBtn=document.getElementById("up-button");
        upBtn.addEventListener("click",function () {
            fileBtn.click();
        });
        fileBtn.addEventListener("change",function () {
            if(fileBtn.value)
                upBtn.innerHTML=fileBtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
            else
                upBtn.innerHTML="Choose a file";

        });
    </script>
</body>
</html>