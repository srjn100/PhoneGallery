<?php
if(isset($_POST['submit'])){
	$err=[];
	if(isset($_POST['imageName'])&&!empty($_POST['imageName'])){
		$imageName=$_POST['imageName'];
	}
	else{
		$err['imageName']="enter imageName";
	}
	$dir="";
		$file=$dir.basename($_FILES['imagePath']['name']);
		$fileType=strtolower(pathinfo($file,PATHINFO_EXTENSION));
		$upok=1;
		if(isset($_POST['imagePath'])){
		
		if(file_exists($file)){
			echo "<br>sorry the file already exists";
			$upok=0;
		}
		if($fileType!="jpg"&&$fileType!="png"&&$fileType!="jpeg"&&$fileType!="gif"){
		echo " sorry only jpg, jpeg , png, gif files are allowed";
		$upok=0;
		}
		if($upok==0)
			echo "<br>sorry the file was not uploaded";
		}
		else{
			if(move_uploaded_file($_FILES['imagePath']['tmp_name'],$file)){
			echo "<br>the file ".basename($_FILES['imagePath']['name'])." has been uploaded";
		}
		else{
			echo "<br>sorry there was an error in uploading the file";
		}	
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>img</title>
</head>
<body>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
	<table frame='border'>
		<tr>
			<th>imagename</th>
			<td>
				<input type="text" name="imageName">
				<?php if(isset($err['imageName']))echo $err['imageName']?> 
			</td>
		</tr>
		<tr>
			<th>phone</th>
			<td>
				<select name="phoneID">
					<option value="none">select phone</tion>
					<option value="s9">s9</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>upload image</th>
			<td>
				<input type="file" name="imagePath">
			</td>
		</tr>
		
		
		<tr>
			<th colspan=2>
				<input type="submit" name="submit">
			</th>
		</tr>
	</table>
</form>
</body>
</html>