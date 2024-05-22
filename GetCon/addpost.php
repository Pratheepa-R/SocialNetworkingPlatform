<?php
session_start();
if(isset($_POST["addpost"])){
    if(($_FILES["postfile"]["error"] == UPLOAD_ERR_OK)){
        $filename=$_FILES["postfile"]["name"];
        $a=explode(".",$filename);
        $username=$_SESSION["USERNAME"];
        $filepath="posts/".$username.".".$a[0].".".$a[1];
        if(move_uploaded_file($_FILES['postfile']['tmp_name'],$filepath)){
            $conn = mysqli_connect("localhost","root","","getcon");
            $caption=$_POST["caption"];
            $date=date('Y-m-d');
            $sql = $conn->prepare("INSERT INTO posts(username,image,caption,date,time) VALUES (?, ?, ?, ?, current_time())");
            $sql->bind_param("ssss", $username, $filepath, $caption, $date);
            if ($sql->execute()) {
			    header("location:yourposts.php");
			    exit();
		    }
        }
    }
    else{
        $conn = mysqli_connect("localhost","root","","getcon");
        $caption=$_POST["caption"];
        $date=date('Y-m-d');
        $username=$_SESSION["USERNAME"];
        $filepath="";
        if(strlen($caption)>0){
            $sql = $conn->prepare("INSERT INTO posts(username,image,caption,date,time) VALUES (?, ?, ?, ?, current_time())");
            $sql->bind_param("ssss", $username, $filepath, $caption, $date);
            if ($sql->execute()) {
                header("location:yourposts.php");
			    exit();
		    }
        }
        else{
            header("location:yourposts.php");
        }
    }
}
?>