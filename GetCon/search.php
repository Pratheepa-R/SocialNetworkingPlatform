<html>
    <?php
session_start();
$username=$_SESSION["USERNAME"];
$conn = mysqli_connect("localhost", "root", "", "getcon");
if(isset($_POST['query'])){
    $query = $_POST['query'];
    $sql = "SELECT * FROM users WHERE username LIKE '%$query%' and username not in ('$username')";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            echo '<div class="result">';
            echo '<img src="' . $row["image"] . '" style="width:40px; height:40px;">';
            echo '<p onclick="searchname(this)" style="position:relative; top:-50px; left:50px; margin-bottom:-20px; font-size:20px;">' . $row["username"] . '</p>';
            echo '</div>';
        }
    } else {
        echo '<div class="noresult">';
        echo '<label>No Results Found</label>';
        echo '</div>';
    }
}
mysqli_close($conn);
?>
<style>
p:hover{
    background-color:yellow;
    width:600px;
    cursor: pointer;
}
label{
    font-size:20px;
}
.noresult{
    padding-top:20px;
    padding-left: 20px;
    padding-bottom: 20px;
}
</style>
<script>
function searchname(element){
    var x=element.textContent;
    document.cookie="searcheditem="+x;
    window.location.href="searchedname.php";
}
</script>
</html>