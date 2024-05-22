<html>
<head>
<title>User Signup</title>
</head>
<body>
<style>
.loginbox {
    width: 420px;
    height: 570px;
    background: #fff;
    color: #000;
    top: 50%;
    left: 51%;
    border-radius: 7%;
    border: 2px solid black;
    position: absolute;
    transform: translate(-50%,-50%);
    box-sizing: border-box;
    padding: 70px 30px;
}
.user
{
    width:100px;
    height:100px;
    border-radius: 50%;
    position: absolute;
    top: -30px;
    left: calc(50% - 50px)
}
.loginbox h1{
    margin: 0;
    padding: 0 0 20px;
    text-align: center;
    font-size: 22px;
    font-weight:bold;
}}
.loginbox p
{
    margin: 0;
    padding: 0;
    font-weight: bold;
}
.loginbox input
{
    width: 100%;
    margin-bottom: 20px;
    
}
.loginbox input[type="text"], input[type="password"]
{
    border: none;
    border-bottom: 2px solid #000;
    background: transparent;
    outline: none;
    height: 50px;
    color: #000;
    font-size: 16px;
}
    .loginbox input[type="Submit"] {
        border: none;
        outline: none;
        height: 40px;
        background-color:yellow;
        color: #fff;
        font-size: 18px;
        border-radius: 20px;
        font-weight:bold;
    }
        .loginbox input[type="Submit"]:hover {
            cursor: pointer;
            color: #000;
        }
#nameerror{
color:red;
}
</style>
<div style="background-color:yellow; height:200px; width:1280px;">
<div class="loginbox">
<img src ="user.jpg" class="user">
<h1> JOIN US </h1>
<form method="POST" autocomplete="off">
      <p>USERNAME</p>
      <input type="text" name="username" placeholder="Enter Username" required>
	<span id="nameerror"></span>
      <p>CREATE PASSWORD</p>
     	<input type="password" name="pass" id="pass" placeholder="Enter Password" required>
	<p>CONFIRM PASSWORD</p>
     	<input type="password" id="repass" placeholder="Re-Enter Password" required>
      <input type="Submit" name="signup" value ="SIGN UP" onclick="check()">
</form>
</div>
</div>
<img src="getcon1.jpg">
<img src="getcon2.png" style="position:absolute; left:900px;">
</body>
<script>
function check(){
	password=document.getElementById("pass").value;
	repassword=document.getElementById("repass").value;
	if(password!=repassword){
		document.getElementById('pass').value = "";
		document.getElementById('repass').value = "";
		window.alert("Passwords Don't Match");
	}	
}
</script>
<?php
if(isset($_POST['signup'])){
        $username=$_POST['username'];
        $password=$_POST['pass'];
	$conn = mysqli_connect("localhost","root","","getcon");
	$sql="select * from users where username='".$username."'";
	$result=$conn->query($sql);
	if($result->num_rows==0){
		$alphabet=strtoupper($username[0]);
		$image = imagecreate(400, 400);
		$bg_color = imagecolorallocate($image, 255, 255, 255);
		$text_color = imagecolorallocate($image, 255, 255, 0);
		imagefilledrectangle($image, 0, 0, 400, 400, $bg_color);
		$font="arial.ttf";
        imagettftext($image,300,0,50,350,$text_color,$font,$alphabet);
		$imagepath="profiles/".$alphabet.".png";
		imagepng($image,$imagepath);
        $sql = "INSERT INTO users(username,password,image) VALUES ('$username','$password','$imagepath')";
		if($conn->query($sql)==true){
			header("location:login.html");
			exit();
		}
	}
	else{
		?>
		<script>
        		document.getElementById("nameerror").innerHTML="Username already exists";
		</script>
		<?php
	}
}
?>
</html>
