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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Places = 10;
$pageNum_Places = 0;
if (isset($_GET['pageNum_Places'])) {
  $pageNum_Places = $_GET['pageNum_Places'];
}
$startRow_Places = $pageNum_Places * $maxRows_Places;





$maxRows_Places = 10;
$pageNum_Places = 0;

if (isset($_GET['pageNum_Places'])) {
  $pageNum_Places = $_GET['pageNum_Places'];
}
$startRow_Places = $pageNum_Places * $maxRows_Places;


$WebLanguage_Places = "-1";
if (isset($_POST['weblanguage'])) {
  $WebLanguage_Places = $_POST['weblanguage'];
}
else
{
	if (isset($_SESSION['MM_WebLanguageId'])){
	$WebLanguage_Places = $_SESSION['MM_WebLanguageId'];
	}
	}
	
$country_Places = "";
if (isset($_POST['country']) && $_POST['country']!='0') {
  $country_Places = 'AND tblplaces.CountryId='.$_POST['country'];
}
else
{
	if (isset($_SESSION['MM_CountryId']) && $_SESSION['MM_CountryId']!='0'){
	$country_Places = ' AND tblplaces.CountryId='.$_SESSION['MM_CountryId'];
	}
	}


$state_Places = "";
if (isset($_POST['state']) && $_POST['state']!='0') {
  $state_Places = ' AND tblplaces.StateId='.$_POST['state'];
}
else
{
	if (isset($_SESSION['MM_StateId']) && $_SESSION['MM_StateId']!='0'){
	$state_Places = ' AND tblplaces.StateId='.$_SESSION['MM_StateId'];
	}
	}

$location_Places = "";
if (isset($_POST['location']) && $_POST['location']!='0') {
  $location_Places = ' AND tblplaces.LocationId='.$_POST['location'];
}
else
{
	if (isset($_SESSION['MM_LocationId']) && $_SESSION['MM_LocationId']!='0'){
	$location_Places = ' AND tblplaces.LocationId='.$_SESSION['MM_LocationId'];
	}
	}
	
$word_Places = "";
if (isset($_POST['wordfilter'])) {
  $word_Places = $_POST['wordfilter'];
}

$sorted_Places = "PlaceId DESC";

mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_Places = sprintf("SELECT tblplaces.PlaceId, tblplacesdet.WebLanguageId, tblplaces.CountryId, tblplaces.StateId, tblplaces.LocationId, tblplacesdet.PlaceName, CONVERT(tblplacesdet.PlaceDesc, char(290)) AS PlaceDesc, tblplacespictures.PictureName, tblplacespictures.PicturePath FROM tblplaces LEFT OUTER JOIN tblplacespictures ON tblplaces.PlaceId = tblplacespictures.PlaceId LEFT OUTER JOIN tblplacesdet ON tblplaces.PlaceId = tblplacesdet.PlaceId WHERE WebLanguageId = %s %s %s %s AND (tblplacesdet.PlaceName like %s or tblplacesdet.PlaceDesc like %s) GROUP BY tblplaces.PlaceId ORDER BY %s", GetSQLValueString($WebLanguage_Places, "int"),$country_Places,$state_Places,$location_Places,GetSQLValueString("%" . $word_Places . "%", "text"),GetSQLValueString("%" . $word_Places . "%", "text"),$sorted_Places);

$query_limit_Places = sprintf("%s LIMIT %d, %d", $query_Places, $startRow_Places, $maxRows_Places);
$Places = mysql_query($query_limit_Places, $ChoosingGuidesConnection) or die(mysql_error());
$row_Places = mysql_fetch_assoc($Places);


if (isset($_GET['totalRows_Places'])) {
  $totalRows_Places = $_GET['totalRows_Places'];
} else {
  $all_Places = mysql_query($query_Places);
  $totalRows_Places = mysql_num_rows($all_Places);
}
$totalPages_Places = ceil($totalRows_Places/$maxRows_Places)-1;

$queryString_Places = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Places") == false && 
        stristr($param, "totalRows_Places") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Places = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Places = sprintf("&totalRows_Places=%d%s", $totalRows_Places, $queryString_Places);
?>
<script type="text/javascript">
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
  </script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="../Templates/AdminTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head><link rel="Shortcut Icon" href="../images/cg.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Choosing Guides Admin</title>
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
       <?php 
	include ("Includes/filter.php");
	
	?>

    <table border="0" align="right">
      <tr>
       <td>Found <?php echo $totalRows_Places?>  Results</td>
        <td width="360">     
        <td><input name="new" type="button" id="new" onClick="MM_goToURL('parent','PlacesAdminAdd.php');return document.MM_returnValue" value="New Place" /></td>
        <td></td>
        <td></td>
        <td><?php if ($pageNum_Places > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_Places=%d%s", $currentPage, 0, $queryString_Places); ?>"><img src="../images/First.gif" /></a>
        <?php } else {?><img src="../images/First_disable.gif" /> <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_Places > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_Places=%d%s", $currentPage, max(0, $pageNum_Places - 1), $queryString_Places); ?>"><img src="../images/Previous.gif" /></a>
        <?php } else {?><img src="../images/Previous_disable.gif" /> <?php } // Show if not first page ?></td>
        <td><?php echo $pageNum_Places+1 ?> of <?php echo $totalPages_Places+1 ?></td>
        <td><?php if ($pageNum_Places < $totalPages_Places) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_Places=%d%s", $currentPage, min($totalPages_Places, $pageNum_Places + 1), $queryString_Places); ?>"><img src="../images/Next.gif" /></a>
            <?php } else {?><img src="../images/Next_disable.gif" /> <?php }// Show if not last page ?></td>
        <td><?php if ($pageNum_Places < $totalPages_Places) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_Places=%d%s", $currentPage, $totalPages_Places, $queryString_Places); ?>"><img src="../images/Last.gif" /></a>
            <?php } else {?><img src="../images/Last_disable.gif" /> <?php }// Show if not last page ?></td>
      </tr>
    </table>
    
    <?php 
	if (mysql_num_rows($Places)==0)
	{
	echo "No Results were found ...";	
		
	}
		else
		{
	
	do { ?>
      <div class="placesList">    <div class="placeImage"> <a href="PlacesAdminDetails.php?place=<?php echo $row_Places['PlaceId']; ?>"><img src="<?php echo "../".$row_Places['PicturePath']; ?>" width="196" height="156" alt="<?php echo $row_Places['PictureName']; ?>" /></a> </div>
        <div class="placeDesc"> 
        <div class="EditDelete">
        
          <input name="Delete" type="button" onClick="MM_goToURL('parent','PlacesAdminDel.php?place=<?php echo $row_Places['PlaceId']; ?>');return document.MM_returnValue" value="Delete" />
          
</div>

          <h4><a href="PlacesAdminDetails.php?place=<?php echo $row_Places['PlaceId']; ?>"><?php echo $row_Places['PlaceName']; ?></a></h4>
          <p class="placeDesc"><?php echo $row_Places['PlaceDesc']; ?> ...</p>
        </div>
      </div>
      <?php } while ($row_Places = mysql_fetch_assoc($Places)); ?>
    
    <p>
    <table border="0" align="right">
      <tr>
        <td><input name="new" type="button" id="new" onClick="MM_goToURL('parent','PlacesAdminAdd.php');return document.MM_returnValue" value="New Place" /></td>
        <td></td>
        <td></td>
        <td><?php if ($pageNum_Places > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_Places=%d%s", $currentPage, 0, $queryString_Places); ?>"><img src="../images/First.gif" /></a>
        <?php } else {?><img src="../images/First_disable.gif" /> <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_Places > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_Places=%d%s", $currentPage, max(0, $pageNum_Places - 1), $queryString_Places); ?>"><img src="../images/Previous.gif" /></a>
        <?php } else {?><img src="../images/Previous_disable.gif" /> <?php } // Show if not first page ?></td>
        <td><?php echo $pageNum_Places+1 ?> of <?php echo $totalPages_Places+1 ?></td>
        <td><?php if ($pageNum_Places < $totalPages_Places) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_Places=%d%s", $currentPage, min($totalPages_Places, $pageNum_Places + 1), $queryString_Places); ?>"><img src="../images/Next.gif" /></a>
            <?php } else {?><img src="../images/Next_disable.gif" /> <?php }// Show if not last page ?></td>
        <td><?php if ($pageNum_Places < $totalPages_Places) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_Places=%d%s", $currentPage, $totalPages_Places, $queryString_Places); ?>"><img src="../images/Last.gif" /></a>
            <?php } else {?><img src="../images/Last_disable.gif" /> <?php }// Show if not last page ?></td>
      </tr>
    </table>
    </p>
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
		}
mysql_free_result($Places);
?>
