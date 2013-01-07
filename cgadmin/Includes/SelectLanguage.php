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

mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_WebLanguage = "SELECT tblweblanguage.WebLanguageId, tblweblanguage.WebLanguageCode, tblweblanguage.WebLanguageName FROM tblweblanguage ORDER BY tblweblanguage.WebLanguageName";
$WebLanguage = mysql_query($query_WebLanguage, $ChoosingGuidesConnection) or die(mysql_error());
$row_WebLanguage = mysql_fetch_assoc($WebLanguage);
$totalRows_WebLanguage = mysql_num_rows($WebLanguage);

if (isset($_POST['weblanguage']))
{
$LanguageSelect=$_POST['weblanguage'];
}
else
{
	$LanguageSelect=$_SESSION['MM_WebLanguageId'];
	}
?>

<script language="javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="javascript">

$(document).ready(function(){
   $("#weblanguage").change(function () {
           $("#weblanguage option:selected").each(function () {
            weblanguageid=$(this).val();
            $.post("Includes/setweblanguage.php", { weblanguageid: weblanguageid }, function(data){
           // $("#state").html(data);
		   alert("gfdutrfyfef");
            });            
        });
		
   })
    
});
		
</script>

<form action="" method="post" name="form1" onsubmit="<?php $_SESSION['MM_WebLanguageId']=$LanguageSelect; ?>">
  <label for="weblanguage"></label>
  <table width="200" align="right">
    <tr>
      <td width="170" align="right">Language:</td>
      <td><select name="weblanguage" id="weblanguage" onchange="this.form.submit()">
        <?php
do {  
?>
        <option value="<?php echo $row_WebLanguage['WebLanguageId']?>"<?php if (!(strcmp($row_WebLanguage['WebLanguageId'], $_SESSION['MM_WebLanguageId']))) {echo "selected=\"selected\"";} ?>><?php echo $row_WebLanguage['WebLanguageName']?></option>
        <?php
} while ($row_WebLanguage = mysql_fetch_assoc($WebLanguage));
  $rows = mysql_num_rows($WebLanguage);
  if($rows > 0) {
      mysql_data_seek($WebLanguage, 0);
	  $row_WebLanguage = mysql_fetch_assoc($WebLanguage);
  }
?>
      </select></td>
    </tr>
  </table>
</form>



<?php
mysql_free_result($WebLanguage);
?>
