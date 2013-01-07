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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE tbltours SET CountryId=%s, StateId=%s, LocationId=%s, TourPrice=%s, TourPicture=%s, TourPictureName=%s WHERE TourId=%s",
                       GetSQLValueString($_POST['country'], "int"),
					   GetSQLValueString($_POST['state'], "int"),
					   GetSQLValueString($_POST['location'], "int"),
					   GetSQLValueString($_POST['TourPrice'], "double"),
					   GetSQLValueString($_POST['tourpicture'], "text"),
					   GetSQLValueString($_POST['tourpicturename'], "text"),
                       GetSQLValueString($_POST['TourId'], "int"));

  mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
  $Result1 = mysql_query($updateSQL, $ChoosingGuidesConnection) or die(mysql_error());

  $updateGoTo = "ToursAdminDetails.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$tour_Tours = "-1";
if (isset($_GET['tour'])) {
  $tour_Tours = $_GET['tour'];
}
mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_Tours = sprintf("SELECT tbltours.TourId, tbltours.CountryId, tbltours.StateId, tbltours.LocationId, tbltours.TourPrice, tbltours.TourPicture, tbltours.TourPictureName  FROM tbltours WHERE tbltours.TourId=%s", GetSQLValueString($tour_Tours, "int"));
$Tours = mysql_query($query_Tours, $ChoosingGuidesConnection) or die(mysql_error());
$row_Tours = mysql_fetch_assoc($Tours);
$totalRows_Tours = mysql_num_rows($Tours);

$_SESSION['MM_CountryId']=$row_Tours['CountryId'];
$_SESSION['MM_StateId']=$row_Tours['StateId'];
$_SESSION['MM_LocationId']=$row_Tours['LocationId'];

?>

<script>
  function subirimagen()
  {
	  self.name = 'opener'
	  remote=open('TourImageManament.php', 'remote', 'width=400,height=150, location=no,scrollbars=yes,menubars=no,toolbars=no,rezisable=yes,fullscreen=no,status=yes');
	  remote.focus();
	  }
  
  </script>


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
<table>
  <tr>
    <td width="63">&nbsp;</td>
    <td><?php include("../Includes/SelectLocation.php"); ?></td>
  </tr>
</table>
<table align="left">
    <tr valign="baseline">
      <td width="170" align="right" nowrap="nowrap">Price:</td>
      <td><input type="text" name="TourPrice" value="<?php echo htmlentities($row_Tours['TourPrice'], ENT_COMPAT, 'iso-8859-1'); ?>" size="50" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Picture:</td>
      <td><label for="tourpicture"></label>
        <input name="tourpicture" type="text" id="tourpicture" value="<?php echo htmlentities($row_Tours['TourPicture'], ENT_COMPAT, 'iso-8859-1'); ?>" size="50" /> <input type="button" name="brows" id="brows" value="..." onclick="javascript:subirimagen();"/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Picture Name:</td>
      <td><label for="tourpicturename"></label>
        <input name="tourpicturename" type="text" id="tourpicturename" value="<?php echo htmlentities($row_Tours['TourPictureName'], ENT_COMPAT, 'iso-8859-1'); ?>" size="50" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form2" />
  <input type="hidden" name="TourId" value="<?php echo $row_Tours['TourId']; ?>" />
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
mysql_free_result($Tours);
?>
