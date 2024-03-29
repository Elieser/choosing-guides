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
$tour_Tours = "-1";
if (isset($_GET['tour'])) {
  $tour_Tours = $_GET['tour'];
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO tbltoursplaces (TourId, PlaceId) VALUES (%s, %s)",
                       GetSQLValueString($tour_Tours, "int"),
                       GetSQLValueString($_POST['PlaceId'], "int"));

  mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
  $Result1 = mysql_query($insertSQL, $ChoosingGuidesConnection) or die(mysql_error());

  $insertGoTo = "ToursAdminDetails.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_ToursMain = "SELECT tbltours.TourId, tbltours.CountryId, tbltours.StateId, tbltours.LocationId, tbltours.TourPrice, tbltours.TourPicture, tbltours.TourPictureName FROM tbltours WHERE tbltours.TourId=$tour_Tours";
$ToursMain = mysql_query($query_ToursMain, $ChoosingGuidesConnection) or die(mysql_error());
$row_ToursMain = mysql_fetch_assoc($ToursMain);
$totalRows_ToursMain = mysql_num_rows($ToursMain);

$weblanguage_TourPlaces = "-1";
if (isset($_SESSION['MM_WebLanguageId'])) {
  $weblanguage_TourPlaces = $_SESSION['MM_WebLanguageId'];
}
$tour_TourPlaces = "-1";
if (isset($_GET['tour'])) {
  $tour_TourPlaces = $_GET['tour'];
}
mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_TourPlaces = sprintf("SELECT tblplaces.PlaceId, CONVERT(tblplacesdet.PlaceDesc, char(290)) AS PlaceDesc, tblplacesdet.PlaceName, tblplacesdet.WebLanguageId, tblplacespictures.PicturePath, tblplacespictures.PictureName FROM tblplaces INNER JOIN tblplacesdet ON tblplaces.PlaceId = tblplacesdet.PlaceId LEFT OUTER JOIN tblplacespictures ON tblplaces.PlaceId = tblplacespictures.PlaceId INNER JOIN tbltoursplaces ON tblplaces.PlaceId = tbltoursplaces.PlaceId WHERE tblplacesdet.WebLanguageId=%s AND tbltoursplaces.TourId=%s GROUP BY tblplaces.PlaceId ORDER BY tbltoursplaces.TourPlaceId", GetSQLValueString($weblanguage_TourPlaces, "int"),GetSQLValueString($tour_TourPlaces, "int"));
$TourPlaces = mysql_query($query_TourPlaces, $ChoosingGuidesConnection) or die(mysql_error());
$row_TourPlaces = mysql_fetch_assoc($TourPlaces);
$totalRows_TourPlaces = mysql_num_rows($TourPlaces);


mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_SelectPlaces = sprintf("SELECT tblplaces.PlaceId, tblplacesdet.PlaceDesc, tblplacesdet.PlaceName, tblplacesdet.WebLanguageId, tbltours.TourId FROM tblplaces INNER JOIN tblplacesdet ON tblplaces.PlaceId = tblplacesdet.PlaceId INNER JOIN tbltours ON tblplaces.CountryId = tbltours.CountryId AND tblplaces.StateId = tbltours.StateId AND tblplaces.LocationId = tbltours.LocationId WHERE tbltours.TourId = %s AND tblplacesdet.WebLanguageId = %s and  tblplaces.PlaceId not in (select PlaceId from tbltoursplaces where tbltoursplaces.TourId=tbltours.TourId)", GetSQLValueString($tour_TourPlaces, "int"),GetSQLValueString($weblanguage_TourPlaces, "int"));
$SelectPlaces = mysql_query($query_SelectPlaces, $ChoosingGuidesConnection) or die(mysql_error());
$row_SelectPlaces = mysql_fetch_assoc($SelectPlaces);
$totalRows_SelectPlaces = mysql_num_rows($SelectPlaces);

$maxRows_Tours = 10;
$pageNum_Tours = 0;
if (isset($_GET['pageNum_Tours'])) {
  $pageNum_Tours = $_GET['pageNum_Tours'];
}
$startRow_Tours = $pageNum_Tours * $maxRows_Tours;


mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_Tours = sprintf("SELECT
tbltoursdet.TourId,
tbltoursdet.WebLanguageId,
tbltoursdet.TourName,
tbltoursdet.TourDesc,
tblweblanguage.WebLanguageCode,
tblweblanguage.WebLanguageName,
tbltoursdet.ClickCounter
FROM
tbltoursdet
INNER JOIN tblweblanguage ON tbltoursdet.WebLanguageId = tblweblanguage.WebLanguageId
WHERE tbltoursdet.TourId=%s", GetSQLValueString($tour_Tours, "int"));
$query_limit_Tours = sprintf("%s LIMIT %d, %d", $query_Tours, $startRow_Tours, $maxRows_Tours);
$Tours = mysql_query($query_limit_Tours, $ChoosingGuidesConnection) or die(mysql_error());
$row_Tours = mysql_fetch_assoc($Tours);

if (isset($_GET['totalRows_Tours'])) {
  $totalRows_Tours = $_GET['totalRows_Tours'];
} else {
  $all_Tours = mysql_query($query_Tours);
  $totalRows_Tours = mysql_num_rows($all_Tours);
}
$totalPages_Tours = ceil($totalRows_Tours/$maxRows_Tours)-1;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="../Templates/AdminTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head><link rel="Shortcut Icon" href="../images/cg.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Choosing Guides Admin</title>
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
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
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<script type="text/javascript">

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>
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
  <div class="placeMainImage">
  <img src="<?php echo "../".$row_ToursMain['TourPicture']; ?>" alt="" name="mainimage" width="754" height="400" id="mainimage" />
  </div>
<form action="" method="post" name="addpicture">
  <input name="AddDetails" type="button" onclick="MM_goToURL('parent','ToursAdminAddDet.php?tour=<?php echo $tour_Tours ?>');return document.MM_returnValue" value="Add Others Languages" />
  <input name="Edit" type="button" onclick="MM_goToURL('parent','ToursAdminEdit.php?tour=<?php echo $tour_Tours;?>');return document.MM_returnValue" value="General Data Edit" />
</form>

<?php do { ?>
<div class="placeDetailsDesc">
<div class="EditDelete">
<input name="Edit" type="button" onclick="MM_goToURL('parent','ToursAdminEditDet.php?tour=<?php echo $tour_Tours ?>&amp;language=<?php echo $row_Tours['WebLanguageId']; ?>');return document.MM_returnValue" value="Edit" />
<input name="Delete" type="button" onclick="MM_goToURL('parent','ToursAdminDelDet.php?tour=<?php echo $tour_Tours ?>&amp;language=<?php echo $row_Tours['WebLanguageId']; ?>');return document.MM_returnValue" value="Delete" /></div>


      <h4><?php echo $row_Tours['TourName']."  (".$row_Tours['WebLanguageName'].")"."  (".$row_Tours['ClickCounter'].")"; ?> </h4>
      <hr size="1" noshade="noshade" />
      <p><?php echo $row_Tours['TourDesc']; ?></p>
    </div>
    
   
     <?php } while ($row_Tours = mysql_fetch_assoc($Tours)); 
  if ($totalRows_TourPlaces!=0){
  	do { ?>
    <div class="placesList">    <div class="placeImage"> <a href="PlacesAdminDetails.php?place=<?php echo $row_TourPlaces['PlaceId']; ?>"><img src="<?php echo "../".$row_TourPlaces['PicturePath']; ?>" width="196" height="156" alt="<?php echo $row_TourPlaces['PictureName']; ?>" /></a> </div>
        <div class="placeDesc"> 
        <div class="EditDelete">
        
          <input name="Delete" type="button" onClick="MM_goToURL('parent','TourPlaceDel.php?tour=<?php echo $tour_TourPlaces; ?> & place=<?php echo $row_TourPlaces['PlaceId']; ?>');return document.MM_returnValue" value="Delete" />
          
</div>

          <h4><a href="PlacesAdminDetails.php?place=<?php echo $row_TourPlaces['PlaceId']; ?>"><?php echo $row_TourPlaces['PlaceName']; ?></a></h4>
          <p class="placeDesc"><?php echo $row_TourPlaces['PlaceDesc']; ?> ...</p>
        </div>
      </div>
      <?php } while ($row_TourPlaces = mysql_fetch_assoc($TourPlaces)); }?>

<?php  $selPlace=-1;
  if (isset($_POST['selectplaces'])){
	  $selPlace=$_POST['selectplaces'];
  }?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table align="left">
    <tr valign="baseline">
      <td width="50" align="right" nowrap="nowrap">Place:</td>
      <td><select name="PlaceId">
        <?php 
do {  
?>
        <option value="<?php echo $row_SelectPlaces['PlaceId']?>" ><?php echo $row_SelectPlaces['PlaceName']?></option>
        <?php
} while ($row_SelectPlaces = mysql_fetch_assoc($SelectPlaces));
?>
      </select>
        <input type="submit" value="Add Place" /></td>
    </tr>
    <tr> </tr>
    </table>
  <input type="hidden" name="TourId" value="" />
  <input type="hidden" name="MM_insert" value="form2" />
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

mysql_free_result($ToursMain);

mysql_free_result($TourPlaces);

mysql_free_result($SelectPlaces);
?>
