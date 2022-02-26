<?php
session_start();
if(isset($_SESSION['userID']))
    unset($_SESSION['userID']);
if(isset($_SESSION['userID1']))
    unset($_SESSION['userID1']);
$userName = $password = $eru = $erp = "";
if (isset($_POST['login'])) {

    if (!empty($_POST['userName']))
        $userName = $_POST['userName'];
    else
        $eru = "please enter valid username";
    if (!empty($_POST['password']))
        $password = md5($_POST['password']);
    else
        $erp = "please enter valid password";
    if ($eru == "" && $erp == "") {
        include "dbCreation/connect.php";
        $sqlup = "SELECT * FROM users
                    WHERE userName='$userName'
                    AND password='$password'";
        if ($res = mysqli_query($conn, $sqlup)) {
            if (mysqli_num_rows($res) == 1) {
                $data = mysqli_fetch_assoc($res);

                if ($data['isAdmin'] == true) {
                    $_SESSION['userID'] = $data['userID'];
                    header("location:backend/dashboard.php?id=" . $data['userID']);
                } else {
                    $_SESSION['userID1'] = $data['userID'];
                    header("location:byAMIL/project/First.php?id=" . $data['userID']);
                }
            } else {
                $eru = "please enter valid username";
                $erp = "please enter valid password";
            }
        } else
            echo "error " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="library/css/index.css">
    <link rel="stylesheet" type="text/css" href="library/fontawesome-free-5.9.0-web/css/all.css">
    <script src="library/js/index.js"></script>
</head>
<body class="bg" onload="load1();">
<div class="bg">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="login-form">
            <h1 class="login-h1">
                <span class="login-heading">Login Form</span>
            </h1>
            <div class="login-input" onclick="legend();">
                <fieldset class="input-frame">
                    <legend class="l">Enter Username</legend>
                    <div class="input">
                        <input type="text" name="userName" placeholder="User Name">
                    </div>
                </fieldset>
            </div>
            <div class="error"><span class="er">
                <?php echo $eru; ?>
            </span></div>
            <div class="input" onclick="legend()">
                <fieldset class="input-frame">
                    <legend class="l">Enter Password</legend>
                    <div class="input-left">
                        <input type="password" name="password" placeholder="Password">
                    </div>
                    <div class="input-right">
                        <span><i class="fas fa-eye-slash" onclick="pass();"></i></span>
                    </div>
                </fieldset>
            </div>
            <div class="error"><span class="er">
                <?php echo $erp; ?>
            </span></div>
            <div class="input-d">
                <div class="noacc">
                    <a href="index1.php"><span>Don't have an account?<br>Sign Up</span></a>
                </div>
                <div class="login-submit">
                    <input type="submit" name="login" value="Log In">
                </div>
            </div>
        </div>
    </form>
</div>
</div>
</body>
</html>