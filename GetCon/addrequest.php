<?php
session_start();
$username=$_SESSION["USERNAME"];
$name=$_COOKIE["searcheditem"];
$conn = mysqli_connect("localhost", "root", "", "getcon");
$sql="insert into invites(fromname,toname) VALUES('$username','$name')";
if($conn->query($sql)){
    header("location:searchedname.php");
}