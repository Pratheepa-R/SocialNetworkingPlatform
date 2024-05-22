<?php 
if(isset($_POST['login'])){
        session_start();
	$conn = mysqli_connect("localhost","root","","getcon");
	$username = $_POST['username'];
	$password = $_POST['pass'];
	$sql="SELECT * from users where binary username='".$username."' and binary password='".$password."'";
	$result=$conn->query($sql);
	if($result->num_rows==0){
	?>
		<script>alert("Invalid Credentials");
		window.location.replace("login.html");
		</script>
	<?php
	}
	else{
		$_SESSION["USERNAME"]=$username;
		header("location:home.php");
                exit();
       }
}
?>