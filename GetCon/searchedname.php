<html>
<head>
<title>Welcome</title>
    <script src="jquery.min.js"></script>
<script>
	$(document).ready(function(){
            $('#search').on('input', function(){
                var query = $(this).val();
				if(query.length>=1){
                    $.ajax({
                        url: 'search.php',
                        method: 'POST',
                        data: {query: query},
                        success: function(data){
                            $("#results").html(data);
                        }
                    });
				}
				else {
                    $('#results').html('');
                }
        	});
			$("#profilepic").click(function(){
				$("#profileoptions").hide();
				$("#pictureoptions").slideToggle();
			});
			$("#yourname").click(function(){
				$("#pictureoptions").hide();
				$("#profileoptions").slideToggle();
			});
			$("#viewpic").magnificPopup({type:'image'});
    });
</script>
<style>
body{
margin:0;
padding:0;
}
input[type="text"]{
	border-radius: 20px;
	width:650px;
	height:50px;
	position: absolute;
	left:100px;
	top: 17px;
	padding: 30px;
	font-size: 20px;
}
#results{
	border:2px solid black;
	position:absolute;
	width:650px;
	left:100px;
	top:120px;
	background-color: white;
	z-index: 2;
}
#pictureoptions,#profileoptions{
	display:none;
	border:2px solid black;
	position:absolute;
    top:100px;
	left:1000px;
	padding:20px;
	width:150px;
	background-color: white;
    z-index: 2;
}
#pictureoptions p,#profileoptions p{
	font-size:20px;
}
#pictureoptions p:hover,#profileoptions p:hover{
	background-color: yellow;
	width:160px;
	cursor:pointer;
}
#pictureoptions a,#profileoptions a{
	text-decoration: none;
	color:black;
}
input[type="file"]{
	display: none;
}
#profilepic:hover{
	cursor:pointer;
}
#yourname:hover{
	cursor:pointer;
}
</style>
</head>
<body>
<div style="background-color:yellow; height:100px; width:1280px; position:sticky; top:0; z-index: 2;">
<?php
session_start();
if (!isset($_SESSION["USERNAME"])){
    header("location:login.html");
    exit();
}
$conn = mysqli_connect("localhost","root","","getcon");
$username = $_SESSION["USERNAME"];
$sql="SELECT * from users where binary username='".$username."'";
$result=$conn->query($sql);
while($row=mysqli_fetch_assoc($result)){
	$name=$row["username"];
	$image=$row["image"];
}
?>
<form autocomplete="off">
<input type="text" id="search">
</form>
<div id="results"></div>
<img src='<?php echo $image; ?>' height="70" width="70" style="position:absolute; left:1000px; top:15px;" id="profilepic">
<p style="font-size:30px; position:absolute; left:1100px; top:5px; font-weight: bold; color:black;" id="yourname"><?php echo $name; ?></p>
<div id="pictureoptions">
	<a href='<?php echo $image; ?>' id="viewpic"><p>VIEW PICTURE</p></a>
	<p id="editpic">EDIT PICTURE</p>
<form method="post" autocomplete="off" enctype="multipart/form-data" id="fileform" action="editprofilepic.php">
	<input type="file" id="fileinput" name="file">
</form>
</div>
<div id="profileoptions">
	<a href="home.php"><p>HOME</p></a>
	<a href="yourposts.php"><p>YOUR PROFILE</p></a>
	<a href="invites.php"><p>INVITES</p></a>
	<a href="connections.php"><p>CONNECTIONS</p></a>
	<a href="logout.php"><p>LOGOUT</p></a>
</div>
</div>
<?php
$name=$_COOKIE["searcheditem"];
$sql="select * from connections where binary firstname='".$username."' and binary secondname='".$name."'";
$result=$conn->query($sql);
if ($result->num_rows==0) {
    $sql="select * from users where username='".$name."'";
    $result=$conn->query($sql);
    while($row=$result->fetch_assoc()) {
        ?>
        <img src="<?php echo $row["image"]; ?>" style="width:200px; height:200px; position:relative; left:550px; top:50px;">
        <p style="font-size:30px; position:relative; left:590px; top:30px;"><?php echo $row["username"]; ?></p>
        <?php
    }
        $sql1="select * from invites where fromname='".$username."' and toname='".$name."'";
        $sql2="select * from invites where fromname='".$name."' and toname='".$username."'";
        $res1=$conn->query($sql1);
        $res2=$conn->query($sql2);
        if( $res1->num_rows== 0 and $res2->num_rows== 0) {
            ?>
            <form method="post" action="addrequest.php">
            <input type="submit" id="connect" value="CONNECT">
            </form>
        <?php
        } else {
            ?>
            <button>PENDING</button>
        <?php
        }
}
else{
    $sql="select * from users where username='".$name."'";
    $result=$conn->query($sql);
    while($row=$result->fetch_assoc()) {
        ?>
        <img src="<?php echo $row["image"]; ?>" style="width:100px; height:100px; position:relative; left:30px; top:40px;">
        <p style="font-size:30px; position:relative; left:150px; top:-50px;"><?php echo $row["username"]; ?></p>
    <?php
    }
    ?>
    <?php
    $sql="select * from posts where username='".$name."' order by date desc,time desc";
    $result=$conn->query($sql);
    if($result->num_rows== 0) {
        ?>
        <p style="font-size:30px; position: relative; left:600px; top:80px;">No posts..</p>
    <?php
    } else {
    while($row=$result->fetch_assoc()) {
        ?>
            <div class="posts">
                <p id="date"><?php echo date("jS F Y",strtotime($row["date"])); ?></p>
                <p id="time"><?php echo $row["time"]; ?></p>
                <?php 
                $imagepath=$row["image"];
                if(strlen($imagepath)> 0){
                    ?>
                <img src="<?php echo $row["image"]; ?>">
                <?php
                }
                ?>
                <p id="caption"><?php echo $row["caption"]; ?></p>
            </div></br></br></br>
        <?php
    }
}
}
?>
<style>
    button,input[type="submit"]{
    background-color:yellow;
    position:relative;
    top:50px;
    left:500px;
    height:50px;
    width:300px;
    font-size:30px;
    border-radius:20px;
    font-weight:bold;
}
#connect{
    color:white;
}
button{
    color:black;
}
#connect:hover{
    color:black;
    cursor:pointer;
}
.posts{
        border:2px solid black;
        width: 660px;
        position:relative;
        left:292px;
        top:10px;
        padding-left: 20px;
        border-radius: 20px;
        padding-right: 20px;
        padding-bottom: 50px;
        min-height: 200px;
        overflow-x: hidden;
        overflow-y: hidden;
    }
        .posts img{
            height:300px;
            width:660px;
            position:relative;
            top:20px;
        }
        .posts #date{
            position:relative;
            left:5px;
            top:25px;
        }
        .posts #time{
            position:relative;
            left:600px;
            top:-10px;
        }
        .posts #caption{
            position:relative;
            top:40px;
            text-align:justify;
        }
</style>
<script>
	document.getElementById("editpic").addEventListener("click",function(){
		document.getElementById("fileinput").click();
	});
	document.getElementById("fileinput").addEventListener("change",function(){
		document.getElementById("fileform").submit();
	});
</script>
</body>
</html>
