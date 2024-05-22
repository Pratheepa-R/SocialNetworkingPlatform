<?php
session_start();
$username=$_SESSION["USERNAME"];
$name=$_COOKIE["fromname"];
$conn = mysqli_connect("localhost", "root", "", "getcon");
$sql="delete from invites where binary fromname='".$name."' and binary toname='".$username."'";
$conn->query($sql);
$sql1="insert into connections(firstname,secondname) VALUES('$username','$name')";
$sql2="insert into connections(firstname,secondname) VALUES('$name','$username')";
if($conn->query($sql1) and $conn->query($sql2)){
    header("location:invites.php");
}
?>