<?php
if (isset($_POST["nlocation"]) and $_POST["nlocation"]!=0){
$_SESSION['MM_LocationId']=$_POST["nlocation"];
}
echo "";
?>
