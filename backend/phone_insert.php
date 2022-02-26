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

$bd;
$conn=mysqli_connect("localhost","root","","phonegallery");
if($conn)
    $asql="SELECT * FROM users 
WHERE userID = '$id'";
$ares=mysqli_query($conn,$asql);
$data=[];
if(mysqli_num_rows($ares)==1){
    $data=mysqli_fetch_assoc($ares);
    $bsql="SELECT brandID,brandName FROM brands
            ORDER BY brandName";
    $bres;
    if($bres=mysqli_query($conn,$bsql)){
        if(mysqli_num_rows($bres)>0)
            $bd=mysqli_fetch_all($bres);
    }else{
        echo "<script> alert(\"no brands available inserted\")</script>";
    }
}
else
    echo "error ".mysqli_error($conn);

$phoneName=$phoneModel=$releaseDate=$brandID='';
$err=[];
if(isset($_POST['submit'])) {
    $err = [];
    if (isset($_POST['phoneName']) && !empty($_POST['phoneName'])) {
        $phoneName = strtolower($_POST['phoneName']);
        $csql="SELECT phoneID FROM phones where phoneName='$phoneName' ";
        $cres=mysqli_query($conn,$csql);
        if(mysqli_num_rows($cres)>0){
            $err['phoneImage']="phone already exists";
        }
    } else {
        $err['phoneName'] = "enter phone name";
    }
    if (isset($_POST['phoneModel']) && !empty($_POST['phoneModel'])) {
        $phoneModel = strtolower($_POST['phoneModel']);
    } else {
        $err['phoneModel'] = "enter phone Model";
    }
    if(!empty($_POST['brandID'])&&$_POST['brandID']!='-1'){
        $brandID=$_POST['brandID'];
    }  else{
        $err['brandID'] = "select a brand";
    }
    if(isset($_POST['releaseDate'])){
        $releaseDate=$_POST['releaseDate'];
    }
    if(!($_FILES['phoneImage']['name'])) {
        $err['phoneImage']="file not selected";
    }
if(count($err)==0){
    $upsql="SELECT brandName FROM brands where brandID='$brandID' ";
    $bres=mysqli_query($conn,$upsql);
    $brandName=mysqli_fetch_assoc($bres)['brandName'];
    $imgDir="../files/brands/$brandName/$phoneName";
    if(!file_exists($imgDir))
        mkdir($imgDir);
    else{
        $file=basename($_FILES['phoneImage']['name']);
        $fileType=strtolower(pathinfo($file,PATHINFO_EXTENSION));
        $newFile=$imgDir."/t".time().".".$fileType;
        $fileDBpath="../".$newFile;
        if($fileType!="jpg"&&$fileType!="png"&&$fileType!="jpeg"&&$fileType!="gif"&&$fileType!="svg"){
            $err['phoneImage']="only jpg,jpeg,png,gif,svg allowed";
        }
        elseif(move_uploaded_file($_FILES['phoneImage']['tmp_name'],$newFile)){
            $psql="INSERT INTO phones(phoneName,phoneModel,releaseDate,viewCount,userID,brandID,thumbnail)
                VALUES('$phoneName','$phoneModel','$releaseDate','0','$id','$brandID','$fileDBpath') ";
            if(mysqli_query($conn,$psql)){
                echo "<script> alert(\"phone inserted\")</script>";
                header("location:phone_view.php?id=$id");
            }
            else{
                echo "<script> alert(\"".mysqli_error($conn)."\")</script>";
            }           
        }
        else{
            echo "<script> alert(\"file not uploaded try again\")</script>";
        }
    }
}


}


?>
<!DOCTYPE html>
<html lang="en" style="font-size: 13px;font-family: Roboto, Arial, sans-serif;">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Phone Form</title>
    <link rel="stylesheet" type="text/css" href="../library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="../library/css/frame.css">
    <link rel="stylesheet" href="../library/css/phoneForm.css">
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
            <a href="#" class="menu-item " id="brand" onclick="expand(this);">
                <i class="fas fa-bold fa-2x"></i>
                <span>BRANDS</span>
            </a>
            <a href="#" class="menu-item active" id="phone" onclick="expand(this);">
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
            <div class="phone-form">
                <div class="phone-head">
                    <h1 class="phone-h1">
                        <span class="login-heading">Phone Insert Form</span>
                    </h1>
                </div>
                <div class="phone-input">
                    <fieldset class="input-frame" >
                        <legend class="l" >Enter Phone Name</legend>
                        <div class="input" >
                            <input type="text" name="phoneName" placeholder="Phone Name">
                        </div>
                    </fieldset>
                </div>
                <div class="error">
                    <span class="er">
                <?php if(isset($err['phoneName']))echo $err['phoneName'];?>
                </span>
                </div>
                <div class="phone-input">
                    <fieldset class="input-frame" >
                        <legend class="l" >Enter Phone Model</legend>
                        <div class="input" >
                            <input type="text" name="phoneModel" placeholder="Phone Model">
                        </div>
                    </fieldset>
                </div>
                <div class="error">
                    <span class="er">
                <?php if(isset($err['phoneModel']))echo $err['phoneModel'];?>
                </span>
                </div>
                <div class="phone-input">
                    <fieldset class="input-frame" >
                        <legend class="l" >Select Release Date</legend>
                        <div class="input" >
                            <input type="date" name="releaseDate">
                        </div>
                    </fieldset>
                </div>
                <div class="error">
                    <span class="er">
                <?php if(isset($err['releaseDate']))echo $err['releaseDate'];?>
                </span>
                </div>
                <div class="phone-input">
                    <fieldset class="input-frame" >
                        <legend class="l" >Select Brand</legend>
                        <select class="input"  name="brandID">
                            <option value="-1">Select brand</option>
                            <?php
                                foreach($bd as $r){
                                    echo"<option value=\"$r[0]\">$r[1]</option>";
                                }
                            ?>

                            </select>
                    </fieldset>
                </div>
                <div class="error">
                    <span class="er">
                <?php if(isset($err['brandID']))echo $err['brandID'];?>
                </span>
                </div>
                <div class="input-d">
                        <div class="input upin" >
                            <input type="file" name="phoneImage" id="upload-button" hidden="hidden">
                            <button type="button" id="up-button">Choose a file</button>
                        </div>
                    <div class="phone-submit">
                        <input type="submit" name="submit" value="Insert">
                    </div>
                </div>
                <div class="error"><span class="er">
                <?php if(isset($err['phoneImage']))echo $err['phoneImage'];?>
            </span></div>
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
                    <a href="brand_insert.php?id=<?php echo $id;?>" class="sub-menu-item inactive">
                        <i class="fas fa-arrow-down fa-1x"></i>
                        <span>INSERT</span>
                    </a>
                    <a href="brand_view.php?id=<?php echo $id;?>" class="sub-menu-item">
                        <i class="fas fa-eye fa-1x"></i>
                        <span>VIEW</span>
                    </a>
                </div>
                <div class="sub-menu" id="phone-menu">
                    <a href="#" class="sub-menu-item inactive">
                        <i class="fas fa-arrow-down fa-1x active"></i>
                        <span class="active">INSERT</span>
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