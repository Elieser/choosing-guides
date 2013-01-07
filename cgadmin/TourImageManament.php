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
	
  
  ?>
   <script>
   
   //opener.document.addpicture.submit();
   opener.document.form3.tourpicture.value="<?php echo "images/".$nombre_archivo; ?>";
	self.close();
	opener.focus();
	</script>
    
 <?php   
}
	
else{
	?>

<form action="TourImageManament.php" name"UploadImages" method="post" enctype="multipart/form-data" id="form1">
    <p>
      <input name="picturepath" type="file" />
    </p>
    <p>
      <input type="submit" name="button" id="button" value="Upload Image" />
      <input type="hidden" name="enviado" value="form1" /> 
    </p>
</form>

  <?php }?>
</body>
</html>