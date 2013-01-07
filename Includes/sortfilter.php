<?php if (is_file("Connections/ChoosingGuidesConnection.php"))
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

$language_Sort = "-1";
if (isset($_POST['weblanguage'])) {
  $language_Sort = $_POST['weblanguage'];
}
else
{
	 $language_Sort = $_SESSION['MM_WebLanguageId'];
	}

mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_Sort = sprintf("SELECT tblsorts.SortId, tblsorts.WebLanguageId, tblsorts.SortDesc, tblsorts.SortExpresion  FROM tblsorts WHERE tblsorts.WebLanguageId=%s", GetSQLValueString($language_Sort, "int"));
$Sort = mysql_query($query_Sort, $ChoosingGuidesConnection) or die(mysql_error());
$row_Sort = mysql_fetch_assoc($Sort);
$totalRows_Sort = mysql_num_rows($Sort);

if (isset($_POST['queryorder']))
{
$SortSelect=$_POST['queryorder'];
}
else
{
	if (isset($_SESSION['MM_SortId']))
{
	$SortSelect=$_SESSION['MM_SortId'];
}
else
{
	$SortSelect=0;
	}
}

if (isset($_POST['wordfilter']))
{
$SortWord=$_POST['wordfilter'];
}
else
{
	if (isset($_SESSION['MM_Word']))
{
	$SortWord=$_SESSION['MM_Word'];
}
else
{
	$SortWord="";
	}
}

?>
<form id="form1" name="form1" method="post" action="" onsubmit="<?php $_SESSION['MM_SortId']=$SortSelect; 
$_SESSION['MM_Word']=$SortWord;?>">
<table align="right">
  <tr>
    <td width="150" align="right">Find Words:</td>
    <td><label for="wordfilter"></label>
    <input name="wordfilter" type="text" id="wordfilter" value="<?php echo $SortWord; ?>"></td>
  </tr>
  <tr>
    <td align="right">Sorted by:</td>
    <td><select name="queryorder" id="queryorder" >
      <?php
do {  
?>
      <option value="<?php echo $row_Sort['SortId']?>"<?php if (!(strcmp($row_Sort['SortId'], $_SESSION['MM_SortId']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Sort['SortDesc']?></option>
      <?php
} while ($row_Sort = mysql_fetch_assoc($Sort));
  $rows = mysql_num_rows($Sort);
  if($rows > 0) {
      mysql_data_seek($Sort, 0);
	  $row_Sort = mysql_fetch_assoc($Sort);
  }
?>
    </select></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>
      <input name="filter" type="submit" id="filter" onclick="this.form.submit()" value="Find"/>
    </td>
  </tr>
</table>
</form>      
    <label for="queryorder"></label>
<?php
mysql_free_result($Sort);
?>
