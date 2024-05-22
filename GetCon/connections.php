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
	z-index:2;
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
<style>
table,td{
  border:2px solid black;
}
td{
   padding:15px;
   font-size:20px;
}
td:nth-child(1){
   width:450px;
}
</style>
	<?php
	$sql="SELECT * from connections where firstname='".$username."'";
	$result=$conn->query($sql);
  if ($result->num_rows == 0) {
    ?>
    <p style="font-size:20px; position:relative; left:550px; top:50px;">You have no Connections..</p>
    <?php
  }
  else {
    ?>
    <table style="width:80%; position:relative; left:130px; top:50px;">
    <?php
	  while($row=mysqli_fetch_assoc($result)){
        $sql="select * from users where username='".$row["secondname"]."'";
        $res=$conn->query($sql);
        while($row2=mysqli_fetch_assoc($res)){
	  ?>
	  <tr><td><img src='<?php echo $row2['image']; ?>' style="height:70px; width:70px; position:relative; left:30px;">
	  <?php
	    }
      ?>
        <span style="position:relative; left:80px; top:-20px; font-size: 30px;"><?php echo $row['secondname']; ?></span>
    </td></tr>
    <?php
      }
      ?>
    </table>
    <?php
}
?>
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