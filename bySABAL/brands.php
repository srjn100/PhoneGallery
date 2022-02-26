 <?php
$brandName='';
$err=[];
if(file_exists("phone1"))
    echo "dir exists";
else{
if(mkdir("phone1"))
    echo "dir created";
}
if(isset($_POST['submit'])){
	$err=[];
	if(isset($_POST['brandName'])&&!empty($_POST['brandName'])){
		$brandName=$_POST['brandName'];
	}
	else{
		$err['brandName']="enter brand name";
	}
	$dir="";
		$file=$dir.basename($_FILES['brandImagePath']['name']);
		$fileType=strtolower(pathinfo($file,PATHINFO_EXTENSION));
    $imgDir="../files/$brandName";
    if(!file_exists("$imgDir"))
        mkdir($imgDir);
		$newFileName=$imgDir."/".$brandName.".".$fileType;
		$upok=1;
		if(isset($_POST['brandImagePath'])){
		
		if(file_exists($file)){
			echo "<br>sorry the file already exists";
			$upok=0;
		}
		if($fileType!="jpg"&&$fileType!="png"&&$fileType!="jpeg"&&$fileType!="gif"&&$fileType!="svg"){
		echo " sorry only jpg, jpeg , png, gif files are allowed";
		$upok=0;
		}
		if($upok==0)
			echo "<br>sorry the file was not uploaded";
		}
		else{

			if(move_uploaded_file($_FILES['brandImagePath']['tmp_name'],$newFileName)){
			echo "<br>the file ".basename($_FILES['brandImagePath']['name'])." has been uploaded";
		}
		else{
			echo "<br>sorry there was an error in uploading the file";
		}	
}
if(isset($_POST['date']))
    echo $_POST['date'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>brands</title>
</head>
<body>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
<table frame="border">
		<th colspan="2">BRANDS</th>
		<tr>
			<th>BrandName</th>
			<td><input type="text" name="brandName"></td>
			<span><?php if(isset($err['brandName']))echo $err['brandName']?></span>
		</tr>
		<tr>
			<th>Brand Image</th>
			<td><input type="file" name="brandImagePath"></td>
		</tr>
    <tr>
        <th>Date</th>
        <td><input type="date" name="date"></td>
    </tr>
    <tr>
        <select >
    </tr>
		<tr>
			<th colspan=2>
				<input type="submit" name="submit" value="submit">
			</th>
		</tr>

</table>
</form>
</body>
</html>