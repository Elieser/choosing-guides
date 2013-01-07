<?php require_once('Connections/ChoosingGuidesConnection.php'); ?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subir Imagen</title>
</head>

<body>
 
<?php
 if ((isset($_POST["enviado"])) && ($_POST["enviado"] == "form1")) {
	$nombre_archivo=$_FILES['picturepath']['name'];
	move_uploaded_file($_FILES['picturepath']['tmp_name'],"../images/".$nombre_archivo);
	
mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);	
$insertSQL = sprintf("INSERT INTO tblplacespictures (PlaceId, PictureName, PicturePath) VALUES (%s, %s, %s)",
                       GetSQLValueString($_GET['place'], "int"),
                       GetSQLValueString($_POST['picturename'], "text"),
                       GetSQLValueString("images/".$nombre_archivo, "text"));

  $Result1 = mysql_query($insertSQL, $ChoosingGuidesConnection) or die(mysql_error());
  
  ?>
   <script>
   
   opener.document.addpicture.submit();
	self.close();
	opener.document.focus();
	</script>
    
 <?php   
}
	
else{
	?>

<form action="PlaceImageManament.php?place=<?php echo $_GET['place']?>" name"UploadImages" method="post" enctype="multipart/form-data" id="form1">
    <p>
      <input name="picturepath" type="file" />
    </p>
    <p>
      <input name="picturename" type="text" id="picturename" value="Picture Name" />
      <input type="submit" name="button" id="button" value="Upload Image" />
      <input type="hidden" name="enviado" value="form1" /> 
    </p>
</form>

  <?php }?>
</body>
</html>