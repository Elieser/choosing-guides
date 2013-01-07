<?php require_once('../Connections/ChoosingGuidesConnection.php'); ?>
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

$state_locations = "-1";
if (isset($_SESSION['MM_StateId'])) {
  $state_locations = $_SESSION['MM_StateId'];
}
$weblanguage_locations = "-1";
if (isset($_SESSION['MM_WebLanguageId'])) {
  $weblanguage_locations = $_SESSION['MM_WebLanguageId'];
}
if (isset($_POST["nlocation"]) and $_POST["nlocation"]!=0){
$_SESSION['MM_LocationId']=$_POST["nlocation"];
}

mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_locations = sprintf("SELECT tbllocations.LocationId, tbllocations.StateId, tbllocations.CountryId, tbllocations.WebLanguageId, tbllocations.LocationName FROM tbllocations WHERE tbllocations.WebLanguageId=%s AND tbllocations.StateId=%s", GetSQLValueString($weblanguage_locations, "int"),GetSQLValueString($state_locations, "int"));
$locations = mysql_query($query_locations, $ChoosingGuidesConnection) or die(mysql_error());
$row_locations = mysql_fetch_assoc($locations);
$totalRows_locations = mysql_num_rows($locations);

$options='<option value="0">Choose a Location...</option>';
do {
	if (!(strcmp($row_locations['LocationId'], $_SESSION['MM_LocationId']))) {$Activo="selected=\"selected\"";} else {$Activo="";}
    $options=$options. '<option value="'.$row_locations['LocationId'].'"'.$Activo.'>'.$row_locations['LocationName'].'</option>';
	} while ($row_locations = mysql_fetch_assoc($locations));

echo $options;    

mysql_free_result($locations);
?>
