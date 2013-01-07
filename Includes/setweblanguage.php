<?php
if (isset($_POST["weblanguageid"]) and $_POST["weblanguageid"]!=0){
$_SESSION['MM_WebLanguageId']=$_POST["weblanguageid"];
}
echo $_SESSION['MM_WebLanguageId'];
?>
