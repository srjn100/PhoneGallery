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
$conn;
if($conn=mysqli_connect("localhost","root","","phonegallery"))
    $asql="SELECT * FROM users 
WHERE userID = '$id'";
else
    die("cannot connect to server");
$ares=mysqli_query($conn,$asql);
$data=[];
if(mysqli_num_rows($ares)==1){
    $data=mysqli_fetch_assoc($ares);
}

else
    echo "error ".mysqli_error($conn);


?>
<?php
$firstName=$lastName=$userName=$email=$password="";
$e=[];
if(isset($_POST['edit'])){
    $name_reg="/^([a-zA-Z]{3,})$/";
    if(!preg_match($name_reg,$_POST['firstName']))
        $e['firstName']="invalid first name";
    else
        $firstName=$_POST['firstName'];

    if(!preg_match($name_reg,$_POST['lastName']))
        $e['lastName']="invalid last name";
    else
        $lastName=$_POST['lastName'];

    if(strlen($_POST['userName'])<6)
        $e['userName']="invalid user name";
    else
        $userName=$_POST['userName'];

    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
        $e['email']="invalid email";
    else
        $email=$_POST['email'];

    if(strlen($_POST['password'])<6)
        $e['password']="minimum 6 letters";
    else{
        if($_POST['cpassword']!=$_POST['password'])
            $e['cpassword']="doesn't match with password";
        else
            $password=md5($_POST['password']);
    }
    if(!($_FILES['userImage']['name'])) {
        $e['userImage']="file not selected";
    }


    if(count($e)==0){
        //include "../dbCreation/connect.php";
        $csql="SELECT * FROM users
                WHERE userName='$userName' OR email='$email' ";

        if($res=mysqli_query($conn,$csql)){
            if(mysqli_num_rows($res)==1){
                $d=mysqli_fetch_assoc($res);

                    if($userName==$d['userName'])
                        $e['userName']="username already exists";
                    if($email==$d['email'])
                        $e['email']="email already exists";
            }
        }
        if(count($e)==0){
            $imgDir="../files/userImg/$userName";
            if(!file_exists($imgDir))
                mkdir($imgDir);
            $file=basename($_FILES['userImage']['name']);
            $fileType=strtolower(pathinfo($file,PATHINFO_EXTENSION));
            $newFile=$imgDir."/".time().".$fileType";
            $fileDBpath=$newFile;
            if($fileType!="jpg"&&$fileType!="png"&&$fileType!="jpeg"&&$fileType!="gif"&&$fileType!="svg"){
                $e['brandImagePath']="only jpg,jpeg,png,gif,svg allowed";
            }
            elseif(move_uploaded_file($_FILES['userImage']['tmp_name'],$newFile)){
                $isql="INSERT INTO users
                (firstName,lastName,userName,email,password,isAdmin,userImagePath)
                VALUES
                ('$firstName','$lastName','$userName','$email','$password',1,'$fileDBpath')";

            if(mysqli_query($conn,$isql)){
                echo"
                <script>
                    alert(\"Admin added successfully\");
                </script>";
            }
            else{
                echo "
                <script>
                    alert(\"error".mysqli_error($conn)."\");
                </script>";

            }
            }
            else{
                echo "<script> alert(\"please try again\")</script>";
            }
        }
    }

}
?>
<!DOCTYPE html>
<html lang="en" style="font-size: 13px;font-family: Roboto, Arial, sans-serif;">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Insert Admin</title>
    <link rel="stylesheet" type="text/css" href="../library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="../library/css/frame.css">
    <link rel="stylesheet" href="../library/css/edit_form.css">
    <script src="../library/js/frame.js"></script>
    <script src="../library/js/edit_form.js"></script>
</head>
<body onload="load1();">
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
            <a href="#" class="menu-item inactive" id="brand" onclick="expand(this);">
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
            <a href="#" class="menu-item active" id="admin" onclick="expand(this);">
                <i class="fas fa-user-astronaut fa-2x"></i>
                <span>ADMINS</span>
            </a>
            <a href="users_view.php?id=<?php echo $id?>" class="menu-item">
                <i class="fas fa-user-alt fa-2x"></i>
                <span>USERS</span>
            </a>
        </div>
        <div class="content">
            <form action="<?php echo $_SERVER['PHP_SELF']."?id=$id";?>" method="POST" enctype="multipart/form-data">
                <div class="edit-form">
                    <h1 class="edit-h1">
                        <span class="edit-heading">Admin Registration Form</span>
                    </h1>
                    <div class="edit-row">
                        <div class="edit-col-l">
                            <fieldset class="input-frame">
                                <legend class="l">Enter First Name</legend>
                                <input type="text" name="firstName" placeholder="First Name">
                            </fieldset>
                            <div class="error"><span class="er">
                        <?php if(isset($e['firstName']))echo $e['firstName'];?>
                    </span></div>
                        </div>
                        <div class="edit-col-r">
                            <fieldset class="input-frame">
                                <legend class="l">Enter Last Name</legend>
                                <input type="text" name="lastName" placeholder="Last Name">
                            </fieldset>
                            <div class="error"><span class="er">
                        <?php if(isset($e['lastName']))echo $e['lastName'];?>
                    </span></div>
                        </div>
                    </div>
                    <div class="edit-row">
                        <div class="edit-col-l">
                            <fieldset class="input-frame">
                                <legend class="l">Enter Username</legend>
                                <input type="text" name="userName" placeholder="Username">
                            </fieldset>
                            <div class="error"><span class="er">
                        <?php if(isset($e['userName']))echo $e['userName'];?>
                    </span></div>
                        </div>
                        <div class="edit-col-r">
                            <fieldset class="input-frame">
                                <legend class="l">Enter Email</legend>
                                <input type="text" name="email" placeholder="Email">
                            </fieldset>
                            <div class="error"><span class="er">
                        <?php if(isset($e['email']))echo $e['email'];?>
                    </span></div>
                        </div>
                    </div>
                    <div class="edit-row">
                        <div class="edit-col-l">
                            <fieldset class="input-frame">
                                <legend class="l">Enter Password</legend>
                                <input type="password" name="password" placeholder="Password">
                            </fieldset>
                            <div class="error"><span class="er">
                        <?php if(isset($e['password']))echo $e['password'];?>
                    </span></div>
                        </div>
                        <div class="edit-col-r">
                            <fieldset class="input-frame">
                                <legend class="l">Confirm Password</legend>
                                <input type="password" name="cpassword" placeholder="Confirm Password">
                            </fieldset>
                            <div class="error"><span class="er">
                        <?php if(isset($e['cpassword']))echo $e['cpassword'];?>
                    </span></div>
                        </div>
                    </div>

                    <div class="edit-row">

                        <div class="filediv">
                                <div class="input upin" >
                                    <input type="file" name="userImage" id="upload-button" hidden="hidden">
                                    <button type="button" id="up-button">Upload your Photo</button>
                                </div>
                            <div class="error"><span class="er">
                        <?php if(isset($e['userImage']))echo $e['userImage'];?>
                    </span></div>

                        </div>
                        <div class="edit-submit">
                            <input type="submit" name="edit" value="Register">
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
                        <a href="edit_self.php?id=<?php echo $id;?>" class="self-link">Edit</a>
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
                    <a href="#" class="sub-menu-item">
                        <span class="active"><i class="fas fa-arrow-down fa-1x active"></i></span>
                        <span class="active">INSERT</span>
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