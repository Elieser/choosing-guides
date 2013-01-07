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

$language_Language = "-1";
if (isset($_GET['language'])) {
  $language_Language = $_GET['language'];
}
mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_Language = sprintf("SELECT tblweblanguage.WebLanguageId, tblweblanguage.WebLanguageCode, tblweblanguage.WebLanguageName FROM tblweblanguage WHERE tblweblanguage.WebLanguageId =%s", GetSQLValueString($language_Language, "int"));
$Language = mysql_query($query_Language, $ChoosingGuidesConnection) or die(mysql_error());
$row_Language = mysql_fetch_assoc($Language);
$totalRows_Language = mysql_num_rows($Language);

$weblanguage_PlaceLocation = "-1";
if (isset($_SESSION['MM_WebLanguageId'])) {
  $weblanguage_PlaceLocation = $_SESSION['MM_WebLanguageId'];
}
$place_PlaceLocation = "-1";
if (isset($_GET['place'])) {
  $place_PlaceLocation = $_GET['place'];
}
mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_PlaceLocation = sprintf("SELECT tblcountries.CountryName, tblstates.StateName, tbllocations.LocationName, tblplaces.PlaceId, tblcountries.WebLanguageId FROM tblplaces INNER JOIN tblcountries ON tblplaces.CountryId = tblcountries.CountryId INNER JOIN tblstates ON tblplaces.StateId = tblstates.StateId AND tblcountries.WebLanguageId = tblstates.WebLanguageId INNER JOIN tbllocations ON tblplaces.LocationId = tbllocations.LocationId AND tblcountries.WebLanguageId = tbllocations.WebLanguageId WHERE tblplaces.PlaceId = %s AND tblcountries.WebLanguageId = %s", GetSQLValueString($place_PlaceLocation, "int"),GetSQLValueString($weblanguage_PlaceLocation, "int"));
$PlaceLocation = mysql_query($query_PlaceLocation, $ChoosingGuidesConnection) or die(mysql_error());
$row_PlaceLocation = mysql_fetch_assoc($PlaceLocation);
$totalRows_PlaceLocation = mysql_num_rows($PlaceLocation);

$place_PlaceLangDet = "-1";
if (isset($_GET['place'])) {
  $place_PlaceLangDet = $_GET['place'];
}
$language_PlaceLangDet = "-1";
if (isset($_GET['language'])) {
  $language_PlaceLangDet = $_GET['language'];
}
mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_PlaceLangDet = sprintf("SELECT tblplacesdet.PlaceDetId, tblplacesdet.PlaceId, tblplacesdet.WebLanguageId, tblplacesdet.PlaceName, tblplacesdet.PlaceDesc, tblplacesdet.PlaceAddress FROM tblplacesdet WHERE tblplacesdet.PlaceId=%s AND tblplacesdet.WebLanguageId=%s", GetSQLValueString($place_PlaceLangDet, "int"),GetSQLValueString($language_PlaceLangDet, "int"));
$PlaceLangDet = mysql_query($query_PlaceLangDet, $ChoosingGuidesConnection) or die(mysql_error());
$row_PlaceLangDet = mysql_fetch_assoc($PlaceLangDet);
$totalRows_PlaceLangDet = mysql_num_rows($PlaceLangDet);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
  $updateSQL = sprintf("UPDATE tblplacesdet SET PlaceName=%s, PlaceDesc=%s, PlaceAddress=%s WHERE PlaceDetId=%s",
                       GetSQLValueString($_POST['PlaceName'], "text"),
                       GetSQLValueString($_POST['PlaceDesc'], "text"),
					   GetSQLValueString($_POST['PlaceAddress'], "text"),
                       GetSQLValueString($_POST['PlaceDetId'], "int"));

  mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
  $Result1 = mysql_query($updateSQL, $ChoosingGuidesConnection) or die(mysql_error());

  $updateGoTo = "PlacesAdminDetails.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  @header(sprintf("Location: %s", $updateGoTo));
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="../Templates/AdminTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head><link rel="Shortcut Icon" href="../images/cg.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Choosing Guides</title>
<!-- InstanceEndEditable -->
<link href="../CSS/twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../Spry-UI-1.7/css/SpryImageSlideShow.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 7]>
<style>
.content { margin-right: -1px; } /* this 1px negative margin can be placed on any of the columns in this layout with the same corrective effect. */
ul.nav a { zoom: 1; }  /* the zoom property gives IE the hasLayout trigger it needs to correct extra whiltespace between the links */
</style>
<![endif]-->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="../Spry-UI-1.7/includes/SpryDOMUtils.js" type="text/javascript"></script>
<script src="../Spry-UI-1.7/includes/SpryDOMEffects.js" type="text/javascript"></script>
<script src="../Spry-UI-1.7/includes/SpryWidget.js" type="text/javascript"></script>
<script src="../Spry-UI-1.7/includes/SpryPanelSet.js" type="text/javascript"></script>
<script src="../Spry-UI-1.7/includes/SpryFadingPanels.js" type="text/javascript"></script>
<script src="../Spry-UI-1.7/includes/SpryImageLoader.js" type="text/javascript"></script>
<script src="../Spry-UI-1.7/includes/SpryImageSlideShow.js" type="text/javascript"></script>
<script src="../Spry-UI-1.7/includes/plugins/ImageSlideShow/SpryPanAndZoomPlugin.js" type="text/javascript"></script>
<style type="text/css">
/* BeginOAWidget_Instance_2141542: #ImageSlideShow */

#ImageSlideShow.ImageSlideShow {
	width: 250px;
	height: 98px;
	border: solid 1px #000000;
}

#ImageSlideShow .ISSClip {
	background-color: #000000;
}
    
/* EndOAWidget_Instance_2141542 */
</style>
<script type="text/xml">
<!--
<oa:widgets>
  <oa:widget wid="2141542" binding="#ImageSlideShow" />
</oa:widgets>
-->
</script>
</head>
<body bgcolor="#D2D2FF">
<div class="container">
  <div class="header">
  <div class="logo">
  <a href="../IndexAdmin.php"><img src="../images/LogoChoosingGuides.gif" alt="Insert Logo Here" name="Insert_logo" width="300" height="100" class="logo" id="Insert_logo" style="background-color: #8090AB; display:block;" /></a> 
    <!-- end .header -->
    </div>
    <ul id="ImageSlideShow">
  <li><img src="../images/camp-nou.jpg" alt="" width="250" height="98" /></li>
  <li><img src="../images/diagonal.jpg" alt="" width="250" height="96" /></li>
  <li><img src="../images/gardens-royal-palace-pedralbes.jpg" alt="" width="250" height="96" /></li>
  <li><img src="../images/pedralbes-monastery.jpg" alt="" width="250" height="96" /></li>
  <li><img src="../images/pla&ccedil;a-catalunya.jpg" alt="" width="250" height="96" /></li>
</ul>
    <div class="weblanguage">
    <?php 

	include ("../Includes/SelectLanguage.php");
	
?>

<script type="text/javascript">
// BeginOAWidget_Instance_2141542: #ImageSlideShow

var ImageSlideShow = new Spry.Widget.ImageSlideShow("#ImageSlideShow", {
	widgetID: "ImageSlideShow",
	injectionType: "replace",
	autoPlay: true,
	displayInterval: 4000,
	transitionDuration: 2000,
	componentOrder: ["view"],
	plugIns: [  ]
});
// EndOAWidget_Instance_2141542
</script>
    </div>
  </div>
  <div class="menu">
    <ul id="MenuBar1" class="MenuBarHorizontal">
      <li><a href="#">Guides Admin</a></li>
      <li><a href="#">Travel Agencies Admin</a></li>
      <li><a href="ToursAdmin.php">Tours Admin</a></li>
      <li><a href="PlacesAdmin.php">Interesting Places Admin</a></li>
    </ul>
  </div> 
  <div class="content"><!-- InstanceBeginEditable name="Body" -->
  <form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
    <table align="left">
      <tr valign="baseline">
        <td align="right" nowrap="nowrap">Country:</td>
        <td><strong><?php echo $row_PlaceLocation['CountryName']; ?></strong></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap="nowrap">State:</td>
        <td><strong><?php echo $row_PlaceLocation['StateName']; ?></strong></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap="nowrap">Location:</td>
        <td><strong><?php echo $row_PlaceLocation['LocationName']; ?></strong></td>
      </tr>
      <tr valign="baseline">
        <td width="170" align="right" nowrap="nowrap">Language:</td>
        <td><strong><?php echo $row_Language['WebLanguageName']; ?></strong></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Place Name:</td>
        <td><input type="text" name="PlaceName" value="<?php echo htmlentities($row_PlaceLangDet['PlaceName'], ENT_COMPAT, 'iso-8859-1'); ?>" size="50" /></td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="top" nowrap="nowrap">Place Description:</td>
        <td><textarea name="PlaceDesc" cols="50" rows="7"><?php echo htmlentities($row_PlaceLangDet['PlaceDesc'], ENT_COMPAT, 'iso-8859-1'); ?></textarea></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td><input type="text" name="PlaceAddress" value="<?php echo htmlentities($row_PlaceLangDet['PlaceAddress'], ENT_COMPAT, 'iso-8859-1'); ?>" size="50" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td><input type="submit" value="Update" /></td>
      </tr>
</table>
    <input type="hidden" name="MM_update" value="form3" />
    <input type="hidden" name="PlaceDetId" value="<?php echo $row_PlaceLangDet['PlaceDetId']; ?>" />
  </form>
<p>&nbsp;</p>
  <!-- InstanceEndEditable --><!-- end .content --></div>
  <div class="sidebar1">
    <p>Barra Lateral aaa</p>
  </div>
  <div class="footer">
    <p>&nbsp;</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"../SpryAssets/SpryMenuBarDownHover.gif", imgRight:"../SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($Language);

mysql_free_result($PlaceLocation);

mysql_free_result($PlaceLangDet);
?>
