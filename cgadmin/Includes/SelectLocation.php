<?php 
if (is_file("Connections/ChoosingGuidesConnection.php"))
{
require_once('Connections/ChoosingGuidesConnection.php');
}
else
{
	require_once('../Connections/ChoosingGuidesConnection.php');
	}
?>

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

$WebLanguage_Countries = "-1";
if (isset($_SESSION['MM_WebLanguageId'])) {
  $WebLanguage_Countries = $_SESSION['MM_WebLanguageId'];
}
mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_Countries = sprintf("SELECT tblcountries.CountryId, tblcountries.WebLanguageId, tblcountries.CountryName FROM tblcountries WHERE tblcountries.WebLanguageId=%s", GetSQLValueString($WebLanguage_Countries, "int"));
$Countries = mysql_query($query_Countries, $ChoosingGuidesConnection) or die(mysql_error());
$row_Countries = mysql_fetch_assoc($Countries);
$totalRows_Countries = mysql_num_rows($Countries);


if (!isset($_SESSION['MM_CountryId'])){
	$_SESSION['MM_CountryId']=0;
}
if (!isset($_SESSION['MM_StateId'])){
	$_SESSION['MM_StateId']=0;
}
if (!isset($_SESSION['MM_LocationId'])){
	$_SESSION['MM_LocationId']=0;
}

?>


<script language="javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="javascript">

function LoadState() {
	ncountry=document.getElementById("country").value;
            $.post("Includes/states.php", { ncountry: ncountry }, function(data){
            $("#state").html(data);
            });
			}

function LoadLocation() {

nstate=document.getElementById("state").value;
            $.post("Includes/locations.php", { nstate: nstate }, function(data){
            $("#location").html(data);
            });
			}
			
function reLoadLocation() {

nlocation=document.getElementById("location").value;
            $.post("Includes/rlocations.php", { nlocation: nlocation }, function(data){
            $("#location").html(data);
            });}
			
$(document).ready(function(){
   $("#country").change(function () {
           $("#country option:selected").each(function () {
            ncountry=$(this).val();
            $.post("Includes/states.php", { ncountry: ncountry }, function(data){
            $("#state").html(data);
            });            
        });
		
   })
    $("#state").change(function () {
           $("#state option:selected").each(function () {
            nstate=$(this).val();
			//alert(nstate);
            $.post("Includes/locations.php", { nstate: nstate }, function(data){
            $("#location").html(data);
			//alert(data);
            });            
        });
   })
   
   $("#location").change(function () {
           $("#location option:selected").each(function () {
            nlocation=$(this).val();
	//		alert(nstate);
            $.post("Includes/rlocations.php", { nlocation: nlocation });            
        });
   })
   
});

$(document).ready( LoadState );
//$(document).ready( LoadLocation );
$(document).ready( reLoadLocation );
</script>

<table>
  <tr>
    <td width="100" align="right">Country:</td>
    <td><select name="country" id="country">
      <option value="0">Choose a Country...</option>
      <?php
	  
	 
do {  
?>
      <option value="<?php echo $row_Countries['CountryId']?>"<?php if (!(strcmp($row_Countries['CountryId'], $_SESSION['MM_CountryId']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Countries['CountryName']?></option>
      <?php
} while ($row_Countries = mysql_fetch_assoc($Countries));
  $rows = mysql_num_rows($Countries);
  if($rows > 0) {
      mysql_data_seek($Countries, 0);
	  $row_Countries = mysql_fetch_assoc($Countries);
  }
?>
    </select></td>
  </tr>
  <tr>
    <td width="100" align="right">State:</td>
    <td><select name="state" id="state">
      <option value="0">Choose an State...</option>
    </select>
  </tr>
  <tr>
    <td width="100" align="right">Location:</td> 
    <td><select name="location" id="location" >
      <option value="0">Choose a Location...</option>
    </select></td>
  </tr>
</table>
<?php
mysql_free_result($Countries);

?>
