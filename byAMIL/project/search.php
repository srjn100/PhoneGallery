<?php
session_start();
if (isset($_SESSION['userID1']))
    $id = $_SESSION['userID1'];
else
    header("location:../../index.php");
$search = '';
if (isset($_POST['submit'])) {
    $search = 'hello ';
    if (isset($_POST['search']) && !empty($_POST['search'])) {
        $search = $_POST['search'];
    } else {
        echo "<script>alert(\"Please enter search item\");</script>";
    }
} else {
    echo "<script>alert(\"Please enter search item\");</script>";
}

$conn;
$res;
$brand;
if ($conn = mysqli_connect("localhost", "root", "", "phonegallery")) {
    $sql1 = "SELECT * from  phones WHERE isActive='1' AND phoneName LIKE '%$search%'";
    if ($ress = mysqli_query($conn, $sql1)) {
        $phones = mysqli_fetch_all($ress);
    }
    $sql1 = "SELECT * from  phones
              WHERE isActive=1
              order by releaseDate desc
              limit 9";

    if ($ress = mysqli_query($conn, $sql1)) {
        $recent = mysqli_fetch_all($ress);
    }


    $sql2 = "SELECT p.phoneID,phoneName,brandID,avg(rating) as ar,thumbnail
            from phones as p
            inner join ratesnreviews as r
            on p.phoneID=r.phoneID
            WHERE isActive=1            
            group by p.phoneID
            order by ar desc
            limit 9";
    if ($ress = mysqli_query($conn, $sql2)) {
        $toprated = mysqli_fetch_all($ress);

    }


    $asql = "SELECT * FROM users 
WHERE userID = '$id'";
    $ares = mysqli_query($conn, $asql);
    $data = [];
    if (mysqli_num_rows($ares) == 1) {
        $data = mysqli_fetch_assoc($ares);
    } else
        echo "error " . mysqli_error($conn);

}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Search page </title>
    <link rel="stylesheet" type="text/css" href="library/fontAwesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="library/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="designe.css">
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
            <a href="<?php echo "edit.php?id=$id" ?>" class="self-link">Edit</a> &nbsp;
            <a href="../../index.php" onclick="return confirm('Are u sure to logout');" class="self-link">
                Logout</a>
        </div>
    </div>
</div>
<div class="head">
    <div class="first">
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
        <div class="thirdF">
            <div class="thirdFirst">
                <h5 class="d-flex justify-content-center">POPULAR PHONES</h5>
                <?php
                $index = 0;
                echo "<ul class=\"list-group list-group-horizontal\">";

                foreach ($toprated as $row) {

                    if ($index % 3 == 0)
                        echo "</ul><ul class=\"list-group list-group-horizontal justify-content-around\">";
                    echo " <a href=\"Third.php?bid=$row[2]&iid=$row[0]\">
                            <li class=\"list-group-item border-0 py-0 pt-2 small\">
                            <img class='side-img' src='$row[4]' alt='$row[1]'>
                            <br><span>$row[1]</span>
                            </li></a>
                            ";
                    $index++;

                }
                echo "</ul>";

                ?>
            </div>
            <div class="thirdSecond">
                <h5 class="d-flex justify-content-center">RECENT PHONES</h5>
                <?php
                $index = 0;
                echo "<ul class=\"list-group list-group-horizontal\">";
                foreach ($recent as $row) {

                    if ($index % 3 == 0)
                        echo "</ul><ul class=\"list-group list-group-horizontal justify-content-around\">";
                    echo " <a href=\"Third.php?bid=$row[7]&iid=$row[0]\">
                                <li class=\"list-group-item border-0 py-0 pt-2 small\">
                                <img class='side-img' src='$row[9]' alt='$row[1]'>
                                <br><span>$row[1]</span>
                                </li></a>";
                    $index++;
                }
                echo "</ul>";
                ?>
            </div>
        </div>
        <div class="thirdS">
            <div class="thirdSFirst">
                <h4 class="d-flex justify-content-center">Search Results for <?php echo "\"$search\"" ?></h4>
            </div>
            <div class="thirdSSecnd">
                <ul class="list-group list-group-horizontal">
                    <?php
                    if (count($phones) == 0)
                        echo "<h6 style='margin: 20px auto;'>----sorry no phones available----</h6>";
                    $index = 0;
                    //for ($i=0;$i<8;$i++){
                    foreach ($phones as $row) {
                        if ($index % 7 == 0) {
                            echo "</ul><ul class=\"list-group list-group-horizontal\">";
                        }

                        echo "<a href=\"Third.php?bid=$row[7]&iid=$row[0]\"><li class=\"list-group-item border-0\">
                        <div class=\"phone-img\">
                        <img src=\"" . $row[9] . "\" alt=\"" . $row[1] . "\">
                        </div>
                        <div class=\"Phone-name\">
                        <span>" . $row[1] . "</span>
                        </div>
                        </li></a>";
                        $index++;
                    }//}
                    ?>

                </ul>

            </div>


        </div>
    </div>
    <div class="last"> &copy; phone gallery.com
    </div>
</div>


</body>
</html>
