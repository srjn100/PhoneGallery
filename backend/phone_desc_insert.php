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

$pid=$_GET['pid'];
$launch=$body=$display=$platform=$memory=$camera=$sound=$communication=$sensors=$battery=$misc="";
$err=[];
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
$drs=mysqli_query($conn,"SELECT * FROM specifications WHERE phoneID='$pid'");
$ddt=[];
if(mysqli_num_rows($drs)==1)
    $ddt=mysqli_fetch_row($drs);

$pdata=[];
$psql="SELECT phoneName FROM phones 
        WHERE phoneID = '$pid'";
$pres=mysqli_query($conn,$psql);
if(mysqli_num_rows($pres)==1)
    $pdata=mysqli_fetch_assoc($pres);


if(isset($_POST['submit'])){
    if(isset($_POST['launch'])&&strlen($_POST['launch'])>5){
        $launch=$_POST['launch'];
    }
    else{
        $err['launch']="minimum 6 characters required";
    }
    if(isset($_POST['body'])&&strlen($_POST['body'])>5){
        $body=$_POST['body'];
    }
    else{
        $err['body']="minimum 6 characters required";
    }
    if(isset($_POST['display'])&&strlen($_POST['display'])>5){
        $display=$_POST['display'];
    }
    else{
        $err['display']="minimum 6 characters required";
    }
    if(isset($_POST['platform'])&&strlen($_POST['platform'])>5){
        $platform=$_POST['platform'];
    }
    else{
        $err['platform']="minimum 6 characters required";
    }
    if(isset($_POST['memory'])&&strlen($_POST['memory'])>5){
        $memory=$_POST['memory'];
    }
    else{
        $err['memory']="minimum 6 characters required";
    }
    if(isset($_POST['camera'])&&strlen($_POST['camera'])>5){
        $camera=$_POST['camera'];
    }
    else{
        $err['camera']="minimum 6 characters required";
    }
    if(isset($_POST['sound'])&&strlen($_POST['sound'])>5){
        $sound=$_POST['sound'];
    }
    else{
        $err['sound']="minimum 6 characters required";
    }
    if(isset($_POST['communication'])&&strlen($_POST['communication'])>5){
        $communication=$_POST['communication'];
    }
    else{
        $err['communication']="minimum 6 characters required";
    }
    if(isset($_POST['sensors'])&&strlen($_POST['sensors'])>5){
        $sensors=$_POST['sensors'];
    }
    else{
        $err['sensors']="minimum 6 characters required";
    }
    if(isset($_POST['battery'])&&strlen($_POST['battery'])>5){
        $battery=$_POST['battery'];
    }
    else{
        $err['battery']="minimum 6 characters required";
    }
    if(isset($_POST['misc'])&&strlen($_POST['misc'])>5){
        $misc=$_POST['misc'];
    }
    else{
        $err['misc']="minimum 6 characters required";
    }
    if(count($err)==0){
        $insql;
        if(count($ddt)==0)
            $insql="INSERT INTO specifications
                   (launch,body,display,platform,memory,camera,sound,communication,sensors,battery,misc,userID,phoneID)
                   values
                   ('$launch','$body','$display','$platform','$memory','$camera','$sound','$communication','$sensors','$battery','$misc','$id','$pid')";
        else
            $insql="UPDATE specifications SET launch='$launch',body='$body',display='$display',
                    platform='$platform',memory='$memory',camera='$camera',sound='$sound',communication='$communication',
                    sensors='$sensors',battery='$battery',misc='$misc',userID='$id'
                    WHERE phoneID='$pid'";
        //echo $insql;
        if(mysqli_query($conn,$insql)){
            $usql="UPDATE phones SET isActive='1' WHERE phoneID='$pid'";
            mysqli_query($conn,$usql);
            header("location:phone_view.php?id=$id&s=1");
        }
        else{
            echo "<script>alert(\"".mysqli_error($conn)."\");</script>";
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en" style="font-size: 13px;font-family: Roboto, Arial, sans-serif;">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Phone Description</title>
    <link rel="stylesheet" type="text/css" href="../library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="../library/css/frame.css">
    <link rel="stylesheet" href="../library/css/descform.css">
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

            <a href="#" class="menu-item">
                <i class="fas fa-tachometer-alt fa-2x"></i>
                <span>DASHBOARD</span>
            </a>
            <a href="#" class="menu-item inactive" id="brand" onclick="expand(this);">
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
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']."?id=$id&pid=$pid"?>" enctype="multipart/form-data">
                <div class="desc-form">
                    <div class="desc-head"><h1 class="login-h1">
                            <span class="login-heading"><?php echo ucfirst($pdata['phoneName']) ?> Description Form</span>
                        </h1>
                    </div>
                    <div class="desc-input-row">
                        <div class="row-left">
                            <div class="col-left">
                                <div class="desc-input">
                                    <fieldset class="input-frame" >
                            <legend class="l" >Launch</legend>
                            <div class="input" >
                                <textarea name="launch" id="" cols="27.5" rows="7">
                                    <?php if(isset($ddt[1]))echo$ddt[1];?>
                                </textarea>
                            </div>
                        </fieldset>
                                </div>
                                <div class="error">
                                    <span class="er">
                                        <?php if(isset($err['launch']))echo $err['launch'];?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-right">
                                <div class="desc-input">
                                    <fieldset class="input-frame" >
                            <legend class="l" >Body</legend>
                            <div class="input" >
                                <textarea name="body" id="" cols="27.5" rows="7">
                                    <?php if(isset($ddt[2]))echo$ddt[2];?>
                                </textarea>
                            </div>
                        </fieldset>
                                </div>
                                <div class="error">
                                    <span class="er">
                                        <?php if(isset($err['body']))echo $err['body'];?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row-right">
                            <div class="col-left">
                                <div class="desc-input">
                                    <fieldset class="input-frame" >
                            <legend class="l" >Display</legend>
                            <div class="input" >
                                <textarea name="display" id="" cols="27.5" rows="7">
                                    <?php if(isset($ddt[3]))echo$ddt[3];?>
                                </textarea>
                            </div>
                        </fieldset>
                                </div>
                                <div class="error">
                                    <span class="er">
                                        <?php if(isset($err['display']))echo $err['display'];?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-right">
                                <div class="desc-input">
                                    <fieldset class="input-frame" >
                            <legend class="l" >Platform</legend>
                            <div class="input" >
                                <textarea name="platform" id="" cols="27.5" rows="7">
                                    <?php if(isset($ddt[4]))echo$ddt[4];?>
                                </textarea>
                            </div>
                        </fieldset>
                                </div>
                                <div class="error">
                                    <span class="er">
                                        <?php if(isset($err['platform']))echo $err['platform'];?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="desc-input-row">
                        <div class="row-left">
                            <div class="col-left">
                                <div class="desc-input">
                                    <fieldset class="input-frame" >
                            <legend class="l" >Memory</legend>
                            <div class="input" >
                                <textarea name="memory" id="" cols="27.5" rows="7">
                                    <?php if(isset($ddt[5]))echo$ddt[5];?>
                                </textarea>
                            </div>
                        </fieldset>
                                </div>
                                <div class="error">
                                    <span class="er">
                                        <?php if(isset($err['memory']))echo $err['memory'];?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-right">
                                <div class="desc-input">
                                    <fieldset class="input-frame" >
                            <legend class="l" >Camera</legend>
                            <div class="input" >
                                <textarea name="camera" id="" cols="27.5" rows="7">
                                    <?php if(isset($ddt[6]))echo$ddt[6];?>
                                </textarea>
                            </div>
                        </fieldset>
                                </div>
                                <div class="error">
                                    <span class="er">
                                        <?php if(isset($err['camera']))echo $err['camera'];?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row-right">
                            <div class="col-left">
                                <div class="desc-input">
                                    <fieldset class="input-frame" >
                            <legend class="l" >Sound</legend>
                            <div class="input" >
                                <textarea name="sound" id="" cols="27.5" rows="7">
                                    <?php if(isset($ddt[7]))echo$ddt[7];?>
                                </textarea>
                            </div>
                        </fieldset>
                                </div>
                                <div class="error">
                                    <span class="er">
                                        <?php if(isset($err['sound']))echo $err['sound'];?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-right">
                                <div class="desc-input">
                                    <fieldset class="input-frame" >
                            <legend class="l" >Communication</legend>
                            <div class="input" >
                                <textarea name="communication" id="" cols="27.5" rows="7">
                                    <?php if(isset($ddt[8]))echo$ddt[8];?>
                                </textarea>
                            </div>
                        </fieldset>
                                </div>
                                <div class="error">
                                    <span class="er">
                                        <?php if(isset($err['communication']))echo $err['communication'];?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="desc-input-row">
                        <div class="row-left">
                            <div class="col-left">
                                <div class="desc-input">
                                    <fieldset class="input-frame" >
                            <legend class="l" >Sensors</legend>
                            <div class="input" >
                                <textarea name="sensors" id="" cols="27.5" rows="7">
                                    <?php if(isset($ddt[9]))echo$ddt[9];?>
                                </textarea>
                            </div>
                        </fieldset>
                                </div>
                                <div class="error">
                                    <span class="er">
                                        <?php if(isset($err['sensors']))echo $err['sensors'];?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-right">
                                <div class="desc-input">
                                    <fieldset class="input-frame" >
                            <legend class="l" >Battery</legend>
                            <div class="input" >
                                <textarea name="battery" id="" cols="27.5" rows="7">
                                    <?php if(isset($ddt[10]))echo$ddt[10];?>
                                </textarea>
                            </div>
                        </fieldset>
                                </div>
                                <div class="error">
                                    <span class="er">
                                        <?php if(isset($err['battery']))echo $err['battery'];?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row-right">
                            <div class="col-left">
                                <div class="desc-input">
                                    <fieldset class="input-frame" >
                            <legend class="l" >Miscalleneous</legend>
                            <div class="input" >
                                <textarea name="misc" id="" cols="27.5" rows="7">
                                    <?php if(isset($ddt[11]))echo$ddt[11];?>
                                </textarea>
                            </div>
                        </fieldset>
                                </div>
                                <div class="error">
                                    <span class="er">
                                        <?php if(isset($err['misc']))echo $err['misc'];?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="desc-submit-row">
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
                    <a href="phone_insert.php?id=<?php echo $id;?>" class="sub-menu-item inactive">
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
</body>
</html>