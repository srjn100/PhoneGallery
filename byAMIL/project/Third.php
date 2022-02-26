<?php
session_start();
if (isset($_SESSION['userID1']))
    $id = $_SESSION['userID1'];
else
    header("location:../../index.php");
$bid = $_GET['bid'];
$iid = $_GET['iid'];
$spec = [];
$img = [];
$ratebar[] = 0;
$tot = 0;
$av[0]=0;
if ($conn = mysqli_connect("localhost", "root", "", "phonegallery")) {
    $sql1 = "SELECT * from  phones where phoneID='$iid'";
    if ($ress = mysqli_query($conn, $sql1)) {
        $phones = mysqli_fetch_row($ress);
        mysqli_query($conn, "UPDATE phones SET viewCount=viewCount+1 WHERE phoneID='$iid';");
    }
    $imgsql = "SELECT * FROM images
              WHERE phoneID=$iid";
    if ($imgres = mysqli_query($conn, $imgsql))
        $img = mysqli_fetch_all($imgres);


    $sqli = "SELECT *
from specifications
WHERE phoneID=$iid
";
    if ($ress = mysqli_query($conn, $sqli)) {
        $specifications = mysqli_fetch_all($ress);
    }
    $rate = '';
    $text = '';
    if (isset($_POST['submit'])) {
        if (isset($_POST['Rate'])) {
            $rate = $_POST['Rate'];
        }
        if (isset($_POST['text']) and !empty($_POST['text'])) {
            $text = $_POST['text'];
        }
        $crres = mysqli_query($conn, "SELECT rnrID from  ratesnreviews WHERE userID='$id'
                AND phoneID='$iid'");
        $sql1 = '';
        if (mysqli_num_rows($crres) > 0) {
            $rnrID = mysqli_fetch_row($crres)[0];
            $sql1 = "UPDATE ratesnreviews SET rating='$rate',review='$text' 
                    WHERE rnrID='$rnrID'";
        } else {
            $sql1 = "INSERT INTO ratesnreviews
                      (rating, review, userID, phoneID)
                      values($rate, '$text', '$id', '$iid')";
        }

        if (mysqli_query($conn, $sql1)) {
            echo " <script>alert(\"rate n review inserted\");</script>";
            //echo "inserted";

        } else {
            echo "<script>alert(\"rate n review not inserted\n" .
                mysqli_error($conn) . "\");</script>";
        }
    }

    $sqli = "SELECT userName,rating,review from  ratesnreviews as r
              INNER JOIN users as u ON r.userID=u.userID
              WHERE phoneID='$iid' GROUP BY rnrID ORDER BY userName";
    if ($ress = mysqli_query($conn, $sqli)) {
        $ratesnreviews = mysqli_fetch_all($ress);
    }

    $sql1 = "SELECT * from  phones
WHERE isActive=1 AND brandID='$bid'
order by releaseDate desc
limit 9";

    if ($ress = mysqli_query($conn, $sql1)) {
        $recent = mysqli_fetch_all($ress);
    }


    $sql2 = "SELECT p.phoneID,phoneName,brandID,avg(rating) as ar,thumbnail
            from phones as p
            inner join ratesnreviews as r
            on p.phoneID=r.phoneID
            WHERE isActive=1 AND brandID='$bid'            
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
    $avgres = mysqli_query($conn, "SELECT AVG(rating) AS a FROM ratesnreviews WHERE phoneID='$iid'");
    $avg = mysqli_fetch_row($avgres);

    for ($i = 1; $i <= 5; $i++) {
        $avres = mysqli_query($conn, "SELECT COUNT(rating) AS c FROM ratesnreviews WHERE phoneID='$iid' AND rating='$i'");

        $av[$i] = mysqli_fetch_row($avres)[0];
        $tot += $av[$i];
    }
    //print_r($av);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>third page </title>

    <link rel="stylesheet" type="text/css" href="library/fontawesome-free-5.10.0-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="library/fontAwesome/css/font-awesome.min.css">
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
                <h4 class="d-flex justify-content-start pl-5">
                    <?php echo strtoupper($phones[1] . " -- " . $phones[2]) ?>
                </h4>
            </div>
            <div class="thirdSSecond">
                <?php
                include "slider.php";
                ?>

            </div>
            <div class="thirdSThird">
                <table class="table-striped table">
                    <?php
                    foreach ($specifications as $key) { ?>
                        <tr>
                            <th> LAUNCH:</th>
                            <td><?php echo $key[1]; ?> </td>
                        </tr>
                        <tr>
                            <th>BODY:</th>
                            <td> <?php echo $key[2]; ?></td>
                        </tr>
                        <tr>
                            <th>DISPLAY:</th>
                            <td>  <?php echo $key[3]; ?></td>
                        </tr>
                        <tr>
                            <th>PLATFORM:</th>
                            <td>  <?php echo $key[4]; ?></td>
                        </tr>
                        <tr>
                            <th>MEMORY:</th>
                            <td> <?php echo $key[5]; ?></td>
                        </tr>
                        <tr>
                            <th>CAMERA:</th>
                            <td><?php echo $key[6]; ?></td>

                        </tr>
                        <tr>
                            <th>SOUND:</th>
                            <td> <?php echo $key[7]; ?></td>
                        </tr>
                        <tr>
                            <th>COMMUNICATION:</th>
                            <td> <?php echo $key[8]; ?></td>
                        </tr>
                        <tr>
                            <th>SENSORS:</th>
                            <td> <?php echo $key[9]; ?> </td>
                        </tr>
                        <tr>
                            <th>BATTERY:</th>
                            <td> <?php echo $key[10]; ?> </td>
                        </tr>
                        <tr>
                            <th>MISC:</th>
                            <td> <?php echo $key[11]; ?> </td>
                        </tr>


                    <?php } ?>
                </table>
            </div>


            <div class="thirdSFourth">
                <div class="rnr">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?iid=$iid&bid=$bid" ?>">
                        <h3>Rate and Review </h3>
                        <div class="rating">
                            <input type="radio" name="Rate" id="star5" value="5">
                            <label for="star5"></label>
                            <input type="radio" name="Rate" id="star4" value="4">
                            <label for="star4"></label>
                            <input type="radio" name="Rate" id="star3" value="3">
                            <label for="star3"></label>
                            <input type="radio" name="Rate" id="star2" value="2">
                            <label for="star2"></label>
                            <input type="radio" name="Rate" id="star1" value="1">
                            <label for="star1"></label>
                        </div>
                        <div class="review">
                            <textarea type="text" name="text" rows="5" cols="35"></textarea>
                        </div>
                        <div class="rnr-submit">
                            <input type="submit" name="submit" value="Submit">
                        </div>
                    </form>
                </div>
                <div class="avg">
                    <h3>Average Rating</h3>
                    <h3>
                        <?php if($avg[0]!=0) echo substr($avg[0], 0, 3);
                        else echo "no rates & reviews";?>
                        <div style="width: 193px;height: 35px;color:#FFD700;display: inline-block;vertical-align: bottom;">
                            <div style="overflow: hidden;letter-spacing:0px;height: 35px;width: <?php echo $avg[0] / 5 * 100 ?>%;">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </h3>
                    <div>
                        <?php
                        for ($i = 1;$i <= 5;$i++) {
                            echo "<div style='width: 40px;display: inline-block;vertical-align: top;'>$i
                                    <i class='fas fa-star' style='color: #FFD700'></i></div>"
                            ?>

                            <div class="bar-out" >
                            <div class="bar-in" style="width:<?php echo ($av[$i]/$tot*100)."%\" >$av[$i]"; ?>

                            </div>
                            </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="r-table">

        <?php
        foreach ($ratesnreviews as $key) { ?>
            <table>
                <tr>
                    <th colspan="2" align="form-inline"><?php echo strtoupper($key[0]); ?></th>
                </tr>
                <tr>
                    <td>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            if ($key[1] >= $i)
                                echo "<i class='fas fa-star font-weight-light'></i>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $key[2]; ?></td>
                </tr>
            </table>

        <?php } ?>

    </div>
</div>
</div>
<div class="last">&copy; phone gallery.com</div>
</div>


</body>

</html>
