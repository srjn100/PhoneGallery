<?php
$err=[];
if(isset($_POST['submit'])){
	
	if(isset($_POST['phoneName'])&&!empty($_POST['phoneName'])){
		$phoneName=$_POST['phoneName'];
	}
	else{
		$err['phoneName']="enter phone name";
	}
	if(isset($_POST['releaseDate'])&&!empty($_POST['releaseDate'])){
		$releaseDate=$_POST['releaseDate'];
	}
	else{
		$err['releaseDate']="enter releaseDate";
	}
	


}
?>

<!DOCTYPE html>
<html>
<head>
	<title>phoneid</title>
</head>
<body>
	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
	<table frame="border">
		<th colspan="2">PhoneId</th>
		<tr>
			<th>phoneName</th>
			<td><input type="text" name="phoneName"><?php if(isset($err['phoneName']))echo $err['phoneName']?></td>
		</tr>
		
		
		<tr>
			<th>releaseDate</th>
			<td><input type="text" name="releaseDate"><?php if(isset($err['releaseDate']))echo $err['releaseDate']?></td>
		</tr>
		
		<tr>
			<th>brand</th>
			<td><select name="brand">
				<option value="none">select brand</option>
				<option value="apple">apple</option>
			</td>
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