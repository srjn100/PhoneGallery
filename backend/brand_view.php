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

$data=[];
$data1=[];
$conn=mysqli_connect("localhost","root","","phonegallery");
if($conn) {
    $asql = "SELECT * FROM users 
WHERE userID = '$id'";
    $ares = mysqli_query($conn, $asql);
    if (mysqli_num_rows($ares) == 1) {
        $data = mysqli_fetch_assoc($ares);
    } else
        echo "error " . mysqli_error($conn);
$bsql="SELECT brandID,brandName,brandImagePath,insertDate,userName
       FROM brands as b
       INNER JOIN users AS u
       ON b.userID=u.userID
       GROUP BY brandID
       ORDER BY brandName";
    if($bres=mysqli_query($conn,$bsql)){
        if(mysqli_num_rows($bres)>0){
            $data1=mysqli_fetch_all($bres);

        }
    }
    else{
        echo "<script>alert(\"".mysqli_error($conn)."\")</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en" style="font-size: 13px;font-family: Roboto, Arial, sans-serif;">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Brand View</title>
    <link rel="stylesheet" type="text/css" href="../library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="../library/css/frame.css">
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
            <div class="h1"><h1>BRAND LIST</h1></div>
            <div class="table">

                <table>
                    <thead>
                    <th>ID</th>
                    <th>BRAND NAME</th>
                    <th>BRAND IMAGE</th>
                    <th>INSERT DATE</th>
                    <th>INSERTED BY</th>
                    <th>ACTION</th>
                    </thead>
                    <?php
                    $color=0;
                    $style="style=\"background:#F2F2F2\"";

                    foreach ($data1 as $r){
                        $i=0;
                        if($color==0) {
                            echo "<tbody $style>";
                            $color++;
                        }
                        else {
                            echo "<tbody>";
                            $color--;
                        }
                        foreach ($r as $c){
                            if($i==2){
                                $s=substr($c, 3);
                                echo "<td><img src='$s' alt='$r[1]'></td>";
                            }
                            else{
                                echo "<td>".$c."</td>";
                            }
                            $i++;
                        }
                        echo "<td>
                                    <a href='deleteNedit/edit_brand.php?brandName=$r[1]&brandID=$r[0]'><span class='action' onclick=\"return confirm('Are u sure to Edit $r[1]');\">EDIT</span></a>
                                    <a href='deleteNedit/delete.php?delItem=brand&delID=$r[0]&delName=$r[1]'>
                                    <span class='action' onclick=\"return confirm('Are u sure to Delete $r[1] and its phones');\">DELETE</span>
                                    </a>
                                </td>";
                        echo "</tbody>";
                    }
                    ?>
                </table>
            </div>
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
                    <a href="#" class="sub-menu-item">
                        <i class="fas fa-eye fa-1x active"></i>
                        <span class="active">VIEW</span>
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
</body>
</html>