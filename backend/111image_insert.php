<?php

session_start();
//unset($_SESSION['brandID']);
//unset($_SESSION['sop']);
if(!isset($_SESSION['sop'])||!isset($_SESSION['brandID'])) {
    $_SESSION['sop'] = "";
    $_SESSION['brandID']='-1';
}
print_r($_SESSION);
/*
$id;
if(isset($_SESSION['uinput']))
$id=$_SESSION['uinput'];//$_GET['id']
else
    header("location:../index.php");
*/
$id=$_GET['id'];
$bd;$pd=[];$err=[];$bid;
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


?>
<?php
$brandName=$brandID=$phoneName=$phoneID='';
global $pd;
//print_r($pd);
//print_r($_SESSION['sop']);
//if($_SESSION['sop']=="")
  //  unset($_SESSION['brandID']);
if(isset($_POST['submit'])){

    if($_POST['brandID']!='-1'){
        $brandID=$_SESSION['brandID']=$_POST['brandID'];
    }
    elseif($_POST['brandID']=='-1'&&$_SESSION['sop']==""){
        $err['brandID']="brand not selected";
    }
    else{
        $brandID=$_SESSION['brandID'];
        //echo " $brandID ";
        global $pd;
        global $conn;
        $sql = "SELECT phoneID,phoneName FROM phones
        WHERE brandID='$brandID' 
        ORDER BY phoneName";

        if ($pres = mysqli_query($conn,$sql)) {
            if (mysqli_num_rows($pres) > 0) {
                $pd=mysqli_fetch_all($pres);
                foreach ($pd as $r) {
                    $_SESSION['sop'].="<option value=\"$r[0]\" id='brandOP'>$r[1]</option>";
                }
            }
            else{
                $err['brandID']="no phones available for thie brand";
            }
        }
        if($_POST['phoneID']=='-1'){
            $err['phoneID']="phone not selected";
        }
        else{
            $phoneID=$_POST['phoneID'];
            $_SESSION['phoneID']=$phoneID;
        }
        if(!($_FILES['phoneImage']['name'])) {
            $err['phoneImage']="file not selected";
        }
    }
    if(count($err)==0){
        $brandID=$_SESSION['brandID'];
        $phoneID=$_SESSION['phoneID'];
        $upsql="SELECT brandName FROM brands where brandID='$brandID' ";
        $upsql1="SELECT phoneName FROM phones where phoneID='$phoneID' ";
        //echo $upsql."<br>".$upsql1;
        $bres=mysqli_query($conn,$upsql);
        $bres1=mysqli_query($conn,$upsql1);
        if($bres&&$bres1){
            if(mysqli_num_rows($bres)==1&&mysqli_num_rows($bres1)==1){
                $brandName=mysqli_fetch_assoc($bres)['brandName'];
                $phoneName=mysqli_fetch_assoc($bres1)['phoneName'];
                $imgDir="../files/brands/$brandName/$phoneID";
                if(!file_exists($imgDir))
                    mkdir($imgDir);
                else{
                    $file=basename($_FILES['phoneImage']['name']);
                    $fileType=strtolower(pathinfo($file,PATHINFO_EXTENSION));
                    $newFile=$imgDir."/".time().$phoneID.".".$fileType;
                    $fileDBpath="../".$newFile;
                    if($fileType!="jpg"&&$fileType!="png"&&$fileType!="jpeg"&&$fileType!="gif"&&$fileType!="svg"){
                        $err['phoneImage']="only jpg,jpeg,png,gif,svg allowed";
                    }
                    elseif(move_uploaded_file($_FILES['phoneImage']['tmp_name'],$newFile)){
                        $upsql1="INSERT INTO images(imageName,imagePath,phoneID,userID)
                                 VALUES ('$phoneName','$fileDBpath','$phoneID','$id')";
                        if(mysqli_query($conn,$upsql1)) {
                            unset($_SESSION['sop']);
                            $_SESSION['brandID']='-1';
                            echo "<script> alert(\"the file was uploaded\");</script>";
                            header("location:image_insert.php?id=$id");

                        }
                        else{
                            $err['phoneImage']=mysqli_error($conn);
                            echo "<script> alert(\"".mysqli_error($conn)."\")</script>";
                        }
                    }
                    else{
                        echo "<script> alert(\"file not uploaded try again\")</script>";
                    }
                }
            }

        }
        else{
            echo mysqli_error($conn);
        }
    }
    else{
    print_r($err);
    }
    //if(!isset($err['phoneImage']));
    //$_SESSION['sop']="";
    //session_destroy();

}
?>
<!DOCTYPE html>
<html lang="en" style="font-size: 13px;font-family: Roboto, Arial, sans-serif;">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Insert Phone Image</title>
    <link rel="stylesheet" type="text/css" href="../library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="../library/css/frame.css">
    <link rel="stylesheet" href="../library/css/imageForm.css">
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
            <a href="#" class="menu-item" id="brand" onclick="expand(this);">
                <i class="fas fa-bold fa-2x"></i>
                <span>BRANDS</span>
            </a>
            <a href="#" class="menu-item" id="phone" onclick="expand(this);">
                <i class="fas fa-mobile fa-2x"></i>
                <span>PHONES</span>
            </a>
            <a href="#" class="menu-item active" id="image" onclick="expand(this);">
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
                <div class="image-form">
                    <div class="image-head"><h1 class="image-h1">
                            <span class="image-heading">Image Insert Form</span>
                        </h1></div>
                    <div class="image-input" <?php if($_SESSION['sop']!="") echo "hidden='hidden'";?>>
                        <fieldset class="input-frame" >
                            <legend class="l" >Select Brand</legend>
                            <select class="input"  name="brandID" id="brandID">
                                <option value="-1">Select brand</option>
                                <?php
                                foreach($bd as $r){
                                    echo"<option value=\"$r[0]\" id='brandOP'>                                  
                                    $r[1]</option>";
                                }
                                ?>
                            </select>
                        </fieldset>
                    </div>
                    <div class="error" <?php if($_SESSION['sop']!="") echo "hidden='hidden'";?>>
                    <span class="er">
                    <?php if(isset($err['brandID']))echo $err['brandID'];?>
                    </span>
                    </div>
                    <div class="image-input" <?php if($_SESSION['sop']=="") echo "hidden='hidden'";?>>
                        <fieldset class="input-frame" >
                            <legend class="l" >Select Phone</legend>
                            <select class="input" name="phoneID" id="phoneID">
                                <option value="-1">Select phone</option>
                                <?php if(isset($_SESSION['sop']))echo $_SESSION['sop'];?>
                            </select>
                        </fieldset>
                    </div>
                    <div class="error" <?php if($_SESSION['sop']=="") echo "hidden='hidden'";?>>
                        <span class="er">
                        <?php if(isset($err['phoneID']))echo $err['phoneID'];?>
                        </span>
                    </div>
                    <div class="image-input">
                        <div class="input upin" <?php if($_SESSION['sop']=="") echo "hidden='hidden'";?>>
                            <input type="file" name="phoneImage" id="upload-button" hidden="hidden">
                            <button type="button" id="up-button">Choose a file</button>
                        </div>
                        <div class="image-submit">
                            <input type="submit" name="submit" value="Insert">
                        </div>

                    </div>
                    <div class="error" <?php if($_SESSION['sop']=="") echo "hidden='hidden'";?>>
                        <span class="er">
                            <?php if(isset($err['phoneImage']))echo $err['phoneImage'];?>
                        </span>
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
                        <a href="../index.php" onclick="?>" class="self-link">
                            Logout</a>
                    </div>
                </div>
                <div class="sub-menu" id="brand-menu">
                    <a href="brand_insert.php?id=<?php echo $id;?>" class="sub-menu-item inactive">
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
                    <a href="#" class="sub-menu-item">
                        <i class="fas fa-arrow-down fa-1x active"></i>
                        <span class="active">INSERT</span>
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