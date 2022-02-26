<!DOCTYPE html>
<html>
<head>
	<title>Second page </title>
    <link rel="stylesheet" type="text/css" href="library/fontAwesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="library/bootstrap-4.3.1-dist/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="designe.css">
	

</head>
<body>
	<div class="head">
		<div class="first">
        <nav class="navbar navbar-expand-sm bg-light " >

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
		
			
		<div class="third" >
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
				<div class="thirdSFirst">
					
						<p align="center">Mobile Types</p>
				</div>
				<div class="thirdSSecnd">

                    <?php
                    $index=0;
                    for($a=0;$a<25;$a++){


                            if($index%5==0){
                                echo "</ul><ul class=\"list-group list-group-horizontal\">";
                            }

                            echo"<a href=\"#\"><li class=\"list-group-item border-0\">
                        <div class=\"brand-img\">
                        <img src=\"2.jpeg\" alt=\"2\">
                        </div>
                        <div class=\"brand-name\">
                        <span>phone name</span>
                        </div>
                        </li></a>";
                            $index++;}
                    ?>



				
			</div>
		</div>
		<div class="last"> <h1>&copy; phone gallery.com</h1>
		</div>
	</div>
	

</body>
</html>
