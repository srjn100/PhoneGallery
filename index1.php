<?php
$firstName=$lastName=$userName=$email=$password="";
$e=[];
if(isset($_POST['signup'])){
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

    if(count($e)==0){
        include "dbCreation/connect.php";
        $csql="SELECT * FROM users
                WHERE userName='$userName' ";
        $isql="INSERT INTO users
                (firstName,lastName,userName,email,password)
                VALUES
                ('$firstName','$lastName','$userName','$email','$password')";
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
            if(mysqli_query($conn,$isql))
                header("location:index.php");
            else{
                ?>
                <script>
                    alert("<?php echo 'error '.mysqli_error($conn)?>");
                </script>
<?php
            }
        }
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="library/css/index1.css">
    <link rel="stylesheet" type="text/css" href="library/fontawesome-free-5.9.0-web/css/all.css">

</head>
<body class="bg" onload="load1();">
<div class="bg">
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    <div class="signup-form">
        <h1 class="signup-h1">
            <span class="signup-heading">Signup Form</span>
        </h1>
        <div class="signup-row">
            <div class="signup-col-l">
                <fieldset class="input-frame">
                    <legend class="l">Enter First Name</legend>
                <input type="text" name="firstName" placeholder="First Name">
                    </fieldset>
                <div class="error"><span class="er">
                        <?php if(isset($e['firstName']))echo $e['firstName'];?>
                    </span></div>
            </div>
            <div class="signup-col-r">
                <fieldset class="input-frame">
                    <legend class="l">Enter Last Name</legend>
                <input type="text" name="lastName" placeholder="Last Name">
                    </fieldset>
                <div class="error"><span class="er">
                        <?php if(isset($e['lastName']))echo $e['lastName'];?>
                    </span></div>
            </div>
        </div>
        <div class="signup-row">
            <div class="signup-col-l">
                <fieldset class="input-frame">
                    <legend class="l">Enter Username</legend>
                <input type="text" name="userName" placeholder="Username">
                    </fieldset>
                <div class="error"><span class="er">
                        <?php if(isset($e['userName']))echo $e['userName'];?>
                    </span></div>
            </div>
            <div class="signup-col-r">
                <fieldset class="input-frame">
                    <legend class="l">Enter Email</legend>
                <input type="text" name="email" placeholder="Email">
                    </fieldset>
                <div class="error"><span class="er">
                        <?php if(isset($e['email']))echo $e['email'];?>
                    </span></div>
            </div>
        </div>
        <div class="signup-row">
            <div class="signup-col-l">
                <fieldset class="input-frame">
                    <legend class="l">Enter Password</legend>
                <input type="password" name="password" placeholder="Password">
                    </fieldset>
                <div class="error"><span class="er">
                        <?php if(isset($e['password']))echo $e['password'];?>
                    </span></div>
            </div>
            <div class="signup-col-r">
                <fieldset class="input-frame">
                    <legend class="l">Confirm Password</legend>
                <input type="password" name="cpassword" placeholder="Confirm Password">
                    </fieldset>
                <div class="error"><span class="er">
                        <?php if(isset($e['cpassword']))echo $e['cpassword'];?>
                    </span></div>
            </div>
        </div>
    <div class="signup-row">
        <div class="yesacc">
            <a href="index.php"><span>Already have an account?<br>Login</span></a>
        </div>
        <div class="signup-submit">
            <input type="submit" name="signup" value="Signup">
        </div>
    </div>
    </div>
    </form>
</div>
</body>
</html>
