<?php
session_start();
$filename=$_FILES["file"]["name"];
$a=explode(".",$filename);
$username=$_SESSION["USERNAME"];
$filepath="profiles/".$username.".".$a[1];
if(move_uploaded_file($_FILES['file']['tmp_name'],$filepath)){
    $conn = mysqli_connect("localhost","root","","getcon");
    $sql="update users set image='$filepath' where username='".$username."'";
    $conn->query($sql);
    header("location:home.php");
}
?>