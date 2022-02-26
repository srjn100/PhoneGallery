<?php
$errore=$errorun=$errorp=$errorfn=$errorln=$errorup="";

if(isset($_POST['submit'])){
if(empty($_POST['email'])){
		$errore="Email should not be empty";
		}
else{
	$Email=$_POST['email'];
}

if(empty($_POST['uName'])){
	$errorun="UserName should not be empty";

}
else{
	$UserName=$_POST['uName'];
}

if(empty($_POST['password']) and strlen($_POST['password'])<=6 ){
	$errorp="Passord should not be empty and less than 6 characters";
}
else{

	$Password=$_POST['password'];
	
}

if(empty($_POST['fName']) and strlen($_POST['fName'])<=3){
	$errorfn="FirstName should not be empty and should be of 3 characters";
}
else{
$FirstName=$_POST['fName'];
}
if(empty($_POST['lName']) and strlen($_POST['lName'])<=3){
	$errorln="LastName should not be empty and should be of 3 characters";
}
else{
	$LastName=$_POST['lName'];

}
        $dir="uploads/";
		$file=$dir.basename($_FILES['upload']['name']);
		$fileType=strtolower(pathinfo($file,PATHINFO_EXTENSION));
		$upok=1;
		if(isset($_POST['upload'])){
		
		if(file_exists($file)){
			$errorup= "<br>sorry the file already exists";
			$upok=0;
		}
		if($fileType!="jpg"&&$fileType!="png"&&$fileType!="jpeg"&&$fileType!="gif"){
		$errorup= " sorry only jpg, jpeg , png, gif files are allowed";
		$upok=0;
		}
		if($upok==0){
			echo "<br>sorry the file was not uploaded";
		}
		

		else{
			if(move_uploaded_file($_FILES['upload']['tmp_name'],$file)){
			echo "<br>the file ".basename($_FILES['upload']['name'])." has been uploaded";
		}
		else{
			echo "<br>sorry there was an error in uploading the file";
		}
		}
			}
			else{
				$erroeup="file not selected";

			}
	}


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.error{
			color:red;
		}
	</style>
</head>
<body>
	<table  > 
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data"> 
		
		<tr>
			<td>email </td>
			<td><input type="email" name="email" id="eml"><br>
			<span class="error"><?php echo $errore;?></span></td>
		</tr>
		<tr>
			<td> userName</td>
			<td><input type="text" name="uName" id="nm"><br>
			<span class="error"><?php echo $errorun;?></span></td>
		</tr>
		<tr>
			<td>password </td>
			<td><input type="password" name="password" id="psw"><br>
			<span class="error"><?php echo $errorp;?></span></td>
		</tr>
		<tr>
			<td> firstName</td>
			<td><input type="text" name="fName" id="fnm"><br>
			<span class="error"><?php echo $errorfn;?></span></td>
		</tr>
		<tr>
			<td> lastName</td>
			<td><input type="text" name="lName" id="lnm"><br>
			<span class="error"><?php echo $errorln;?></span></td>
		</tr>
		
		<tr>
			<td>userImagePath </td>
			<td><input type="file" name="upload" id="upd"><br>
				<span class="error"><?php echo $errorup;?></span></td>
			
		</tr>
		<tr >
			<td colspan="2" align="center"><input type="submit" name="submit" id="sub"></td>

		</tr>
		</form>
	</table>
		

</body>
</html>
								