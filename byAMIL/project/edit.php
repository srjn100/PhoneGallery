<?php
session_start();
if (isset($_SESSION['userID1']))
    $id = $_SESSION['userID1'];
else
    header("location:../../index.php");
$conn;
$res;
$brand;
if ($conn = mysqli_connect("localhost", "root", "", "phonegallery")) {

    $asql = "SELECT * FROM users WHERE userID = '$id'";
    $ares = mysqli_query($conn, $asql);
    $data = [];
    if (mysqli_num_rows($ares) == 1) {
        $data = mysqli_fetch_assoc($ares);
    } else
        echo "error " . mysqli_error($conn);

}
?>
<?php
$firstName = $lastName = $userName = $email = $password = "";
$e = [];
if (isset($_POST['edit'])) {
    $name_reg = "/^([a-zA-Z]{3,})$/";
    if (!preg_match($name_reg, $_POST['firstName']))
        $e['firstName'] = "invalid first name";
    else
        $firstName = $_POST['firstName'];

    if (!preg_match($name_reg, $_POST['lastName']))
        $e['lastName'] = "invalid last name";
    else
        $lastName = $_POST['lastName'];

    if (strlen($_POST['userName']) < 6)
        $e['userName'] = "invalid user name";
    else
        $userName = $_POST['userName'];

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $e['email'] = "invalid email";
    else
        $email = $_POST['email'];

    if (strlen($_POST['password']) < 6)
        $e['password'] = "minimum 6 letters";
    else {
        if ($_POST['cpassword'] != $_POST['password'])
            $e['cpassword'] = "doesn't match with password";
        else
            $password = md5($_POST['password']);
    }
    if (!($_FILES['userImage']['name'])) {
        $e['userImage'] = "file not selected";
    }

    if (count($e) == 0) {

        $csql = "SELECT * FROM users
WHERE userName='$userName' OR email='$email' ";

        if ($res = mysqli_query($conn, $csql)) {
            if (mysqli_num_rows($res) == 1) {
                $d = mysqli_fetch_assoc($res);
                if ($d['userName'] != $data['userName'])
                    if ($userName == $d['userName'])
                        $e['userName'] = "username already exists";
                if ($d['email'] != $data['email'])
                    if ($email == $d['email'])
                        $e['email'] = "email already exists";
            }
        }
        if (count($e) == 0) {
            $imgDir = "../../files/userImg/$userName";
            if (!file_exists($imgDir))
                mkdir($imgDir);
            $file = basename($_FILES['userImage']['name']);
            $fileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $newFile = $imgDir . "/$id" . time() . ".$fileType";
            $fileDBpath = $newFile;
            if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif" && $fileType != "svg") {
                $e['brandImagePath'] = "only jpg,jpeg,png,gif,svg allowed";
            } elseif (move_uploaded_file($_FILES['userImage']['tmp_name'], $newFile)) {
                $isql = "UPDATE users
                          SET firstName='$firstName' ,lastName='$lastName',
                          userName='$userName' ,email='$email',
                          password='$password' ,userImagePath='$fileDBpath'
                          WHERE userID='$id'";
                if (mysqli_query($conn, $isql)) {
                    echo "
                            <script>
                                alert(\"Info Edited successfully\");
                            </script>";
                    header("location:first.php?id=$id");
                } else {
                    echo "<script>alert(\"error" . mysqli_error($conn) . "\");</script>";
                }
            } else {
                echo "<script> alert(\"please try again\")</script>";
            }
        }
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User Info</title>
    <link rel="stylesheet" type="text/css" href="library/fontAwesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="library/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="designe.css">
    <link rel="stylesheet" type="text/css" href="edit_form.css">
    <script src="js/frame.js"></script>
</head>
<body>
<div class="self" id="self-menu">
    <div class="self-top">
        <div class="self-photo">
            <div class="self-img-contain">
                <img class="self-img" src="<?php echo $data['userImagePath'] ?>" alt="userImage">
            </div>
        </div>
        <div class="self-info">
            <div class="self-name">
                <?php
                echo strtoupper($data['firstName'] . " " . $data['lastName']);
                echo "</div><div class='self-email'>";
                echo $data['email'];
                echo "</div>";
                ?>
            </div>

        </div>
        <div class="self-bottom">
            <a href="<?php echo "edit.php?id=$id" ?>" class="self-link">Edit</a>            &nbsp;
            <a href="../../index.php" onclick="return confirm('Are u sure to logout');" class="self-link">
                Logout</a>
        </div>
    </div>
</div>
<div class="head">

    <div class="first bg-dark text-white">
        <nav class="navbar navbar-expand-sm">

            <div class="fa">
                <i class="fa fa-facebook fa-border fa-2x"> </i>
                <i class="fa fa-youtube fa-border fa-2x"> </i>
                <i class="fa fa-google fa-border fa-2x"> </i>
                <a href="First.php"><i class="fa fa-home  fa-border fa-2x"></i></a></div>
            <div class="fa fa-pull-right ml-auto">
                <form class="form-inline" action="search.php" method="POST">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search" name="search">
                    <label for="submitS">
                        <button class="btn btn-success fa-pull-right" name="submit">Search</button>
                    </label>
                    <input type="submit" name="submit" id="submitS" hidden="hidden">
                    <i class="fa fa-user fa-pull-right  fa-border fa-2x udiv" id="self" onclick="expand(this);"></i>
                </form>
            </div>

    </div>
    <div class="second">
        <h1>PHONE GALLERY</h1>

    </div>
    <div class="third">
        <form action="<?php echo $_SERVER['PHP_SELF'] . "?id=$id"; ?>" method="POST" enctype="multipart/form-data">
            <div class="edit-form">
                <h1 class="edit-h1">
                    <span class="edit-heading">Edit Info Form</span>
                </h1>
                <div class="edit-row">
                    <div class="edit-col-l">
                        <fieldset class="input-frame">
                            <legend class="l">Enter First Name</legend>
                            <input type="text" name="firstName" placeholder="First Name"
                                   value="<?php echo $data['firstName']; ?>">
                        </fieldset>
                        <div class="error"><span class="er">
                        <?php if (isset($e['firstName'])) echo $e['firstName']; ?>
                    </span></div>
                    </div>
                    <div class="edit-col-r">
                        <fieldset class="input-frame">
                            <legend class="l">Enter Last Name</legend>
                            <input type="text" name="lastName" placeholder="Last Name"
                                   value="<?php echo $data['lastName']; ?>">
                        </fieldset>
                        <div class="error"><span class="er">
                        <?php if (isset($e['lastName'])) echo $e['lastName']; ?>
                    </span></div>
                    </div>
                </div>
                <div class="edit-row">
                    <div class="edit-col-l">
                        <fieldset class="input-frame">
                            <legend class="l">Enter Username</legend>
                            <input type="text" name="userName" placeholder="Username"
                                   value="<?php echo $data['userName']; ?>">
                        </fieldset>
                        <div class="error"><span class="er">
                        <?php if (isset($e['userName'])) echo $e['userName']; ?>
                    </span></div>
                    </div>
                    <div class="edit-col-r">
                        <fieldset class="input-frame">
                            <legend class="l">Enter Email</legend>
                            <input type="text" name="email" placeholder="Email"
                                   value="<?php echo $data['email']; ?>">
                        </fieldset>
                        <div class="error"><span class="er">
                        <?php if (isset($e['email'])) echo $e['email']; ?>
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
                        <?php if (isset($e['password'])) echo $e['password']; ?>
                    </span></div>
                    </div>
                    <div class="edit-col-r">
                        <fieldset class="input-frame">
                            <legend class="l">Confirm Password</legend>
                            <input type="password" name="cpassword" placeholder="Confirm Password">
                        </fieldset>
                        <div class="error"><span class="er">
                        <?php if (isset($e['cpassword'])) echo $e['cpassword']; ?>
                    </span></div>
                    </div>
                </div>
                <div class="edit-row">
                    <div class="filediv">
                        <div class="input upin">
                            <input type="file" name="userImage" id="upload-button" hidden="hidden">
                            <button type="button" id="up-button">Upload your Photo</button>
                        </div>
                        <div class="error"><span class="er">
                        <?php if (isset($e['userImage'])) echo $e['userImage']; ?>
                    </span></div>

                    </div>
                    <div class="edit-submit">
                        <input type="submit" name="edit" value="Edit">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="lastone bg-dark text-white">
        &copy; phone gallery.com
    </div>
</div>
<script>
    const fileBtn = document.getElementById("upload-button");
    const upBtn = document.getElementById("up-button");
    upBtn.addEventListener("click", function () {
        fileBtn.click();
    });
    fileBtn.addEventListener("change", function () {
        if (fileBtn.value)
            upBtn.innerHTML = fileBtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
        else
            upBtn.innerHTML = "Choose a file";

    });
</script>
</body>
</html>