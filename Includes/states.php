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

$country_states = "-1";
if (isset($_POST["ncountry"])and $_POST["ncountry"]!=0 ) {
  $country_states = $_POST["ncountry"];
  $_SESSION['MM_CountryId']=$country_states;
  
}
else {
	$country_states=$_SESSION['MM_CountryId'];
}
$weblanguage_states = "-1";
if (isset($_SESSION['MM_WebLanguageId'])) {
  $weblanguage_states = $_SESSION['MM_WebLanguageId'];
}


mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_states = sprintf("SELECT tblstates.StateId, tblstates.CountryId, tblstates.WebLanguageId, tblstates.StateName FROM tblstates WHERE tblstates.CountryId=%s AND tblstates.WebLanguageId=%s", GetSQLValueString($country_states, "int"),GetSQLValueString($weblanguage_states, "int"));
$states = mysql_query($query_states, $ChoosingGuidesConnection) or die(mysql_error());
$row_states = mysql_fetch_assoc($states);
$totalRows_states = mysql_num_rows($states);

$options='<option value="0">Choose an State...</option>';
do {
	if (!(strcmp($row_states['StateId'], $_SESSION['MM_StateId']))) {$Activo="selected=\"selected\"";} else {$Activo="";}
	
    $options=$options. '<option value="'.$row_states['StateId'].'"'.$Activo.'>'.$row_states['StateName'].'</option>';
	} while ($row_states = mysql_fetch_assoc($states));

echo $options;    

mysql_free_result($states);

?>
