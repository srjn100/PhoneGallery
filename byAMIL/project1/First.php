<?php
$conn;$res;$brand;
if($conn=mysqli_connect("localhost","root","","phonegallery")){
    $bsql="SELECT * FROM brands";
    if($res=mysqli_query($conn,$bsql)){
        $brand=mysqli_fetch_all($res);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>First page </title>
	<link rel="stylesheet" type="text/css" href="library/fontAwesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="library/bootstrap-4.3.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="designe.css">

</head>
<body>
	<div class="head">
		<div class="first">
		 <nav class="navbar navbar-expand-sm bg-light  fa-border" >

            <span class="fa fa-pull-left ">
                <i class="fa fa-facebook fa-border fa-2x"> </i>
                <i class="fa fa-youtube fa-border fa-2x"> </i>
                <i class="fa fa-google fa-border fa-2x"> </i>
                <a href="First.php" class="fa fa-home  fa-border fa-2x"></a></span>
                 <form  class=" fa-pull-right ">
                <i class="fa fa-user  fa-pull-right fa-border fa-2x "></i>
                <button class="fa-pull-right fa-border ">Search <i class="fa fa-border fa-search"></i></button>
               <biv class="fa fa-border search"> <input type="text" id="search"  name="search" ><div></form>

        </nav>
        </div>
		<div class="second">
			<h1>PHONE GALLERY</h1>
           
		</div>


			
		<div class="third">
			<div class="thirdF">
				
				<div class="thirdFirst">
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item"><a href="second.php">First item<</a></li>
                        <li class="list-group-item">Second item</li>
                        <li class="list-group-item">Third item</li>
                    </ul>
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item"><a href="second.php">First item<</a></li>
                        <li class="list-group-item">Second item</li>
                        <li class="list-group-item">Third item</li>
                    </ul>
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item"><a href="second.php">First item<</a></li>
                        <li class="list-group-item">Second item</li>
                        <li class="list-group-item">Third item</li>
                    </ul>
				</div>

				<div class="thirdSecond">
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item"><a href="second.php">First item<</a></li>
                        <li class="list-group-item">Second item</li>
                        <li class="list-group-item">Third item</li>
                    </ul>
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item"><a href="second.php">First item<</a></li>
                        <li class="list-group-item">Second item</li>
                        <li class="list-group-item">Third item</li>
                    </ul>
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item"><a href="second.php">First item<</a></li>
                        <li class="list-group-item">Second item</li>
                        <li class="list-group-item">Third item</li>
                    </ul>
				</div>
			
			</div>

			<div class="thirdS">
                <ul class="list-group list-group-horizontal">
                <?php
                $index=0;

                    foreach ($brand as $row){
                        if($index%5==0){
                            echo "</ul><ul class=\"list-group list-group-horizontal\">";
                        }

                        echo"<a href=\"second.php?bid=".$row[0]."\"><li class=\"list-group-item border-0\">
                        <div class=\"brand-img\">
                        <img src=\"".$row[2]."\" alt=\"".$row[1]."\">
                        </div>
                        <div class=\"brand-name\">
                        <span>".$row[1]."</span>
                        </div>
                        </li></a>";
                   $index++;}
                ?>

				
			</div>
		</div>
		<div class="lastone">
		 &copy; phone gallery.com
		</div>
	</div>

</body>
</html>