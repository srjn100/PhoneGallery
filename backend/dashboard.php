<?php
session_start();
/*
$id;
if(isset($_SESSION['uinput']))
$id=$_SESSION['uinput'];//$_GET['id']
else
    header("location:../index.php");
*/
if (isset($_SESSION['userID']))
    $id = $_SESSION['userID'];
else
    header("location:../index.php");
//$id=$_GET['id'];
$conn = mysqli_connect("localhost", "root", "", "phonegallery");
if ($conn)
    $asql = "SELECT * FROM users 
WHERE userID = '$id'";
$ares = mysqli_query($conn, $asql);
$data = [];
if (mysqli_num_rows($ares) == 1) {
    $data = mysqli_fetch_assoc($ares);
} else
    echo "error " . mysqli_error($conn);

$bsql = "SELECT brandName,brandImagePath,SUM(viewCount) AS v FROM brands AS b
          INNER JOIN phones as p ON b.brandID=p.brandID
          GROUP BY b.brandID ORDER BY v DESC LIMIT 1";
$bres = mysqli_query($conn, $bsql);
$brand = mysqli_fetch_row($bres);

$vsql = "SELECT phoneName,thumbnail,viewCount FROM phones ORDER BY viewCount DESC LIMIT 1";
$vres = mysqli_query($conn, $vsql);
$view = mysqli_fetch_row($vres);

$rsql = "SELECT p.phoneName,thumbnail,AVG(rating) as ar FROM phones AS p 
          INNER JOIN ratesnreviews AS r ON p.phoneID=r.phoneID 
          GROUP BY p.phoneID ORDER BY ar DESC LIMIT 1";
$rres = mysqli_query($conn, $rsql);
$rate = mysqli_fetch_row($rres);

$cpsql="SELECT COUNT(phoneID) as c FROM phones WHERE isActive=1";
$cpres = mysqli_query($conn, $cpsql);
$cphone = mysqli_fetch_row($cpres);

$cusql="SELECT COUNT(userID) as c FROM users WHERE isAdmin=0";
$cures = mysqli_query($conn, $cusql);
$cuser = mysqli_fetch_row($cures);

$casql="SELECT COUNT(userID) as c FROM users WHERE isAdmin=1";
$cares = mysqli_query($conn, $casql);
$cadmin = mysqli_fetch_row($cares);

?>
<!DOCTYPE html>
<html lang="en" style="font-size: 13px;font-family: Roboto, Arial, sans-serif;">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="../library/css/frame.css">
    <link rel="stylesheet" href="../library/css/dash.css">
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

            <a href="#" class="menu-item active">
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
            <a href="#" class="menu-item" id="admin" onclick="expand(this);">
                <i class="fas fa-user-astronaut fa-2x"></i>
                <span>ADMINS</span>
            </a>
            <a href="users_view.php?id=<?php echo $id ?>" class="menu-item">
                <i class="fas fa-user-alt fa-2x"></i>
                <span>USERS</span>
            </a>
        </div>
        <div class="content">
            <div class="dash-content">
                <div class="dash-row">
                    <div class="dash-col">
                        <h3>MOST POPULAR BRAND</h3>
                        <img src="<?php echo substr($brand[1], 3) . "\" alt=\"$brand[0]" ?>">
                        <h3><?php echo strtoupper($brand[0]) ?></h3>
                        <h3><?php echo $brand[2] ?> VIEWS</h3>
                    </div>
                    <div class="dash-col">
                        <h3>MOST POPULAR PHONE</h3>
                        <img src="<?php echo substr($rate[1], 3) . "\" alt=\"$rate[0]" ?>">
                        <h3><?php echo strtoupper($rate[0]) ?></h3>
                        <h3><?php echo substr($rate[2], 0,3) ?> STARS</h3>
                    </div>
                    <div class="dash-col">
                        <h3>MOST VIEWED PHONE</h3>
                        <img src="<?php echo substr($view[1], 3) . "\" alt=\"$view[0]" ?>">
                        <h3><?php echo strtoupper($view[0]) ?></h3>
                        <h3><?php echo $view[2] ?> VIEWS</h3>
                    </div>

                </div>
                <div class="dash-row">
                    <div class="dash-col">
                        <h1>ACTIVE PHONES</h1>
                        <h2><?php echo $cphone[0] ?></h2>
                    </div>
                    <div class="dash-col">
                        <h1>TOTAL USERS</h1>
                        <h2><?php echo $cuser[0] ?></h2>
                    </div>
                    <div class="dash-col">
                        <h1>TOTAL ADMINS</h1>
                        <h2><?php echo $cadmin[0] ?></h2>
                    </div>
                </div>

            </div>
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
                        <a href="<?php echo "edit_self.php?id=$id" ?>" class="self-link">Edit</a>
                        &nbsp;
                        <a href="../logout.php" onclick="return confirm('Are u sure to logout');" class="self-link">
                            Logout</a>
                    </div>
                </div>
                <div class="sub-menu" id="brand-menu">
                    <a href="brand_insert.php?id=<?php echo $id; ?>" class="sub-menu-item inactive">
                        <i class="fas fa-arrow-down fa-1x"></i>
                        <span>INSERT</span>
                    </a>
                    <a href="brand_view.php?id=<?php echo $id; ?>" class="sub-menu-item">
                        <i class="fas fa-eye fa-1x"></i>
                        <span>VIEW</span>
                    </a>
                </div>
                <div class="sub-menu" id="phone-menu">
                    <a href="phone_insert.php?id=<?php echo $id; ?>" class="sub-menu-item inactive">
                        <i class="fas fa-arrow-down fa-1x"></i>
                        <span>INSERT</span>
                    </a>
                    <a href="phone_view.php?id=<?php echo $id; ?>" class="sub-menu-item">
                        <i class="fas fa-eye fa-1x"></i>
                        <span>VIEW</span>
                    </a>
                </div>
                <div class="sub-menu" id="image-menu">
                    <a href="image_insert.php?id=<?php echo $id; ?>" class="sub-menu-item inactive">
                        <i class="fas fa-arrow-down fa-1x"></i>
                        <span>INSERT</span>
                    </a>
                    <a href="image_view.php?id=<?php echo $id; ?>" class="sub-menu-item">
                        <i class="fas fa-eye fa-1x"></i>
                        <span>VIEW</span>
                    </a>
                </div>
                <div class="sub-menu" id="admin-menu">
                    <a href="admins_insert.php?id=<?php echo $id; ?>" class="sub-menu-item inactive">
                        <i class="fas fa-arrow-down fa-1x"></i>
                        <span>INSERT</span>
                    </a>
                    <a href="admins_view.php?id=<?php echo $id ?>" class="sub-menu-item">
                        <i class="fas fa-eye fa-1x"></i>
                        <span>VIEW</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</body>
</html>