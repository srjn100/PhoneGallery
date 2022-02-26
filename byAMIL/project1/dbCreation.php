<?php
$conn=mysqli_connect('localhost','root','')
or trigger_error(mysqli_error($conn));
if(!$conn){
    echo mysqli_error($conn)."<br>";
}
else{
    printf("\n connnection successful \n");
    $sql1="CREATE DATABASE phoneGallery";
    if(mysqli_query($conn,$sql1))
        echo "database successfully created <br>";
    else
        echo "error in database creation";
    mysqli_close($conn);
    $conn=mysqli_connect('localhost','root','','phoneGallery')
    or trigger_error(mysqli_error($conn));
    if(!$conn)
        echo mysqli_error($conn)."<br>";

    else
        printf("\n connnection successful \n");
    }
$sql[]="CREATE TABLE USERS(
userID INT PRIMARY KEY AUTO_INCREMENT,
email VARBINARY(50) NOT NULL UNIQUE,
userName VARBINARY(30) NOT NULL UNIQUE,
password VARBINARY(30) NOT NULL,
firstName VARCHAR(20) NOT NULL,
lastName VARCHAR(20) NOT NULL,
regDate TIMESTAMP NOT NULL,
userImagePath VARBINARY(50),
isAdmin BOOLEAN NOT NULL)";

$sql[]="CREATE TABLE BRANDS(
brandID INT PRIMARY KEY AUTO_INCREMENT,
brandName VARCHAR(20) NOT NULL UNIQUE,
brandImagePath VARBINARY(50),
insertDate TIMESTAMP NOT NULL,
userID INT NOT NULL,
FOREIGN KEY(userID) REFERENCES USERS(userID))";

$sql[]="CREATE TABLE PHONES(
phoneID INT PRIMARY KEY AUTO_INCREMENT,
phoneName VARCHAR(20) NOT NULL,
phoneModel VARCHAR(20) NOT NULL,
insertDate TIMESTAMP NOT NULL,
releaseDate DATE,
viewCount BIGINT,
userID INT NOT NULL,
FOREIGN KEY(userID) REFERENCES USERS(userID),
brandID INT NOT NULL,
FOREIGN KEY(brandID) REFERENCES BRANDS(brandID))";

$sql[]="CREATE TABLE SPECIFICATIONS(
specID INT PRIMARY KEY AUTO_INCREMENT,
launch VARBINARY(1000) NOT NULL,
body VARBINARY(1000) NOT NULL,
display VARBINARY(1000) NOT NULL,
platform VARBINARY(1000) NOT NULL,
memory VARBINARY(1000) NOT NULL,
camera VARBINARY(1000) NOT NULL,
sound VARBINARY(1000) NOT NULL,
communication VARBINARY(1000) NOT NULL,
sensors VARBINARY(1000) NOT NULL,
battery VARBINARY(1000) NOT NULL,
misc VARBINARY(1000) NOT NULL,
userID INT NOT NULL,
FOREIGN KEY(userID) REFERENCES USERS(userID),
phoneID INT NOT NULL,
FOREIGN KEY(phoneID) REFERENCES PHONES(phoneID))";

$sql[]="CREATE TABLE IMAGES(
imageID INT PRIMARY KEY AUTO_INCREMENT,
imageName VARCHAR(30) NOT NULL,
imagePath VARCHAR(50) NOT NULL,
phoneID INT NOT NULL,
FOREIGN KEY(phoneID) REFERENCES PHONES(phoneID),
userID INT NOT NULL,
FOREIGN KEY(userID) REFERENCES USERS(userID))";

$sql[]="CREATE TABLE RATESnREVIEWS(
rnrID INT PRIMARY KEY AUTO_INCREMENT,
rating INT NOT NULL,
review VARBINARY(1000) NOT NULL,
userID INT NOT NULL,
FOREIGN KEY(userID) REFERENCES USERS(userID),
phoneID INT NOT NULL,
FOREIGN KEY(phoneID) REFERENCES PHONES(phoneID))";

foreach($sql as $exe){
	if(mysqli_query($conn,$exe))
		echo "<br>TABLE INSERTED ";
	else
		echo "<br>error ".mysqli_error($conn);
}

mysqli_close($conn);
?>