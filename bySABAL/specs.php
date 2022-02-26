<?php
$phone='';
$value=[];
if(isset($_POST['submit'])){
if(isset($_POST["phoneID[0]"])){
echo "please select the phone";
}
else{
	$phone=$_POST["phoneID[1]"];
}
if(empty($_POST['launch'])){
	echo "please give info about launch";
}


if(empty($_POST['body'])){
	echo "please give info about launch";
}
if(empty($_POST['display'])){
	echo "please give info about launch";
}
if(empty($_POST['platform'])){
	echo "please give info about launch";
}
if(empty($_POST['memory'])){
	echo "please give info about launch";
}
if(empty($_POST['camera'])){
	echo "please give info about launch";
}
if(empty($_POST['sound'])){
	echo "please give info about launch";
}
if(empty($_POST['communication'])){
	echo "please give info about launch";
}
if(empty($_POST['sensors'])){
	echo "please give info about launch";
}
if(empty($_POST['battery'])){
	echo "please give info about launch";
}
if(empty($_POST['misc'])){
	echo "please give info about launch";
}


}

?>
<!DOCTYPE html>
<html>
<head>
	<title>specs</title>
</head>
<body>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
	<table frame="border">
	
	<tr>
		<th>phone</th>
		<td>
			<select name="phoneID[]" >
				<option value="none">select phone</option>
				<option value="s9">s9</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>launch</th>
		<td>
			<textarea  name="launch"></textarea>
		</td>	
		<th>body</th>
		<td>
			<textarea  name="body"></textarea>
		</td>
	</tr>
	<tr>
		<th>display</th>
		<td>
			<textarea  name="display"></textarea>
		</td>
		<th>platform</th>
		<td>
			<textarea  name="platform"></textarea>
		</td>
	</tr>
	<tr>
		<th>memory</th>
		<td>
			<textarea  name="memory"></textarea>
		</td>	
		<th>camera</th>
		<td>
			<textarea  name="camera"></textarea>
		</td>
	</tr>
	<tr>
		<th>sound</th>
		<td>
			<textarea  name="sound"></textarea>
		</td>
		<th>communication</th>
		<td>
			<textarea  name="communication"></textarea>
		</td>
	</tr>
	<tr>
		<th>sensor</th>
		<td>
			<textarea  name="sensors"></textarea>
		</td>
		<th>battery</th>
		<td>
			<textarea  name="battery"></textarea>
		</td>
	</tr>
	<tr>
		<th>miscellenous</th>
		<td>
			<textarea  name="misc"></textarea>
		</td>
		
	</tr>
	
	<tr>
		<th colspan=4>
			<input type="submit" name="submit" id="submit">
		</th>
	</tr>
	</table>
</form>
</body>
</html>