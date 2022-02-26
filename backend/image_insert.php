<?php
session_start();
//unset($_SESSION['brandID']);
//unset($_SESSION['sop']);

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
if(isset($_POST['submit'])){
    if($_POST['brandID']=='-1'){
        $err['brandID']="brand not selected";
    }
    else{
        $brandID=$_POST['brandID'];
        header("location:image_insert_1.php?id=$id&bid=$brandID");
    }
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
                    <div class="image-input" >
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
                    <div class="error" >
                    <span class="er">
                    <?php if(isset($err['brandID']))echo $err['brandID'];?>
                    </span>
                    </div>
                        <div class="image-submit">
                            <input type="submit" name="submit" value="Insert">
                        </div>

                    </div>
                    <div class="error">
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
                        <a href="../logout.php" onclick="return confirm('Are u sure to logout');" class="self-link">
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