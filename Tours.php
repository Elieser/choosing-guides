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

$maxRows_Tours = 10;
$pageNum_Tours = 0;
if (isset($_GET['pageNum_Tours'])) {
  $pageNum_Tours = $_GET['pageNum_Tours'];
}
$startRow_Tours = $pageNum_Tours * $maxRows_Tours;





$maxRows_Tours = 10;
$pageNum_Tours = 0;

if (isset($_GET['pageNum_Tours'])) {
  $pageNum_Tours = $_GET['pageNum_Tours'];
}
$startRow_Tours = $pageNum_Tours * $maxRows_Tours;


$WebLanguage_Tours = "-1";
if (isset($_POST['weblanguage'])) {
  $WebLanguage_Tours = $_POST['weblanguage'];
}
else
{
	if (isset($_SESSION['MM_WebLanguageId'])){
	$WebLanguage_Tours = $_SESSION['MM_WebLanguageId'];
	}
	}
	
$country_Tours = "";
if (isset($_POST['country']) && $_POST['country']!='0') {
  $country_Tours = 'AND tblTours.CountryId='.$_POST['country'];
}
else
{
	if (isset($_SESSION['MM_CountryId']) && $_SESSION['MM_CountryId']!='0'){
	$country_Tours = ' AND tblTours.CountryId='.$_SESSION['MM_CountryId'];
	}
	}


$state_Tours = "";
if (isset($_POST['state']) && $_POST['state']!='0') {
  $state_Tours = ' AND tblTours.StateId='.$_POST['state'];
}
else
{
	if (isset($_SESSION['MM_StateId']) && $_SESSION['MM_StateId']!='0'){
	$state_Tours = ' AND tblTours.StateId='.$_SESSION['MM_StateId'];
	}
	}

$location_Tours = "";
if (isset($_POST['location']) && $_POST['location']!='0') {
  $location_Tours = ' AND tblTours.LocationId='.$_POST['location'];
}
else
{
	if (isset($_SESSION['MM_LocationId']) && $_SESSION['MM_LocationId']!='0'){
	$location_Tours = ' AND tblTours.LocationId='.$_SESSION['MM_LocationId'];
	}
	}
	
$word_Tours = "";
if (isset($_POST['wordfilter'])) {
  $word_Tours = $_POST['wordfilter'];
}

$sorted_Tours = "Rand()";
$SortId=0;
if (isset($_POST['queryorder'])){
	$SortId=$_POST['queryorder'];
}
else
{
	if (isset($_SESSION['MM_SortId'])) {
		$SortId=$_SESSION['MM_SortId'];
	}
	}

	switch ($SortId){ 
	case 0: $sorted_Tours = "Rand()";
	break;
	case 1: $sorted_Tours = "ClickCounter DESC";
	break;
	case 2: $sorted_Tours = "TourPrice";
	break;
	case 3: $sorted_Tours = "(select count(*) from tbltourcomments where TourId=tbltour.TourId) DESC";
	break;
	case 4: $sorted_Tours = "(select round(avg(Points),2) from tbltourcomments where TourId=tbltour.TourId) DESC";
	break;
	}


mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_Tours = sprintf("SELECT tblTours.TourId, tblToursdet.WebLanguageId, tblTours.CountryId, tblTours.StateId, tblTours.LocationId, tblTours.TourPrice, tblTours.TourPicture, tblTours.TourPictureName, tblToursdet.TourName, CONVERT(tblToursdet.TourDesc, char(290)) AS TourDesc FROM tblTours LEFT OUTER JOIN tblToursdet ON tblTours.TourId = tblToursdet.TourId WHERE WebLanguageId = %s %s %s %s AND (tblToursdet.TourName like %s or tblToursdet.TourDesc like %s) GROUP BY tblTours.TourId ORDER BY %s", GetSQLValueString($WebLanguage_Tours, "int"),$country_Tours,$state_Tours,$location_Tours,GetSQLValueString("%" . $word_Tours . "%", "text"),GetSQLValueString("%" . $word_Tours . "%", "text"),$sorted_Tours);

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

$queryString_Tours = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Tours") == false && 
        stristr($param, "totalRows_Tours") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Tours = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Tours = sprintf("&totalRows_Tours=%d%s", $totalRows_Tours, $queryString_Tours);
?>
<script type="text/javascript">
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
  </script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="Templates/GlobalTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head><link rel="Shortcut Icon" href="images/cg.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Choosing Guides</title>
<!-- InstanceEndEditable -->
<link href="CSS/twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="Spry-UI-1.7/css/SpryImageSlideShow.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 7]>
<style>
.content { margin-right: -1px; } /* this 1px negative margin can be placed on any of the columns in this layout with the same corrective effect. */
ul.nav a { zoom: 1; }  /* the zoom property gives IE the hasLayout trigger it needs to correct extra whiltespace between the links */
</style>
<![endif]-->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="Spry-UI-1.7/includes/SpryDOMUtils.js" type="text/javascript"></script>
<script src="Spry-UI-1.7/includes/SpryDOMEffects.js" type="text/javascript"></script>
<script src="Spry-UI-1.7/includes/SpryWidget.js" type="text/javascript"></script>
<script src="Spry-UI-1.7/includes/SpryPanelSet.js" type="text/javascript"></script>
<script src="Spry-UI-1.7/includes/SpryFadingPanels.js" type="text/javascript"></script>
<script src="Spry-UI-1.7/includes/SpryImageLoader.js" type="text/javascript"></script>
<script src="Spry-UI-1.7/includes/SpryImageSlideShow.js" type="text/javascript"></script>
<script src="Spry-UI-1.7/includes/plugins/ImageSlideShow/SpryPanAndZoomPlugin.js" type="text/javascript"></script>
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
  <a href="Index.php"><img src="images/LogoChoosingGuides.gif" alt="Insert Logo Here" name="Insert_logo" width="300" height="100" class="logo" id="Insert_logo" style="background-color: #8090AB; display:block;" /></a> 
    <!-- end .header -->
    </div>
    <ul id="ImageSlideShow">
  <li><img src="images/camp-nou.jpg" alt="" width="250" height="98" /></li>
  <li><img src="images/diagonal.jpg" alt="" width="250" height="96" /></li>
  <li><img src="images/gardens-royal-palace-pedralbes.jpg" alt="" width="250" height="96" /></li>
  <li><img src="images/pedralbes-monastery.jpg" alt="" width="250" height="96" /></li>
  <li><img src="images/pla&ccedil;a-catalunya.jpg" alt="" width="250" height="96" /></li>
</ul>
    <div class="weblanguage">
    <?php 

	include ("Includes/SelectLanguage.php");
	
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
      <li><a href="#">Guides</a></li>
      <li><a href="#">Travel Agencies</a></li>
      <li><a href="Tours.php">Tours</a></li>
      <li><a href="Places.php">Interesting Places</a></li>
    </ul>
  </div> 
  <div class="content"><!-- InstanceBeginEditable name="Body" -->
       <?php 
	include ("Includes/filter.php");
	
	?>

    <table border="0" align="right">
      <tr>
       <td align="left"><?php if (mysql_num_rows($Tours)!=0){?>
    Found <?php echo $totalRows_Tours?>  Results<?php }?></td>
        <td width="200">     
        <td width="72">&nbsp;</td>
        <td width="0"></td>
        <td width="0"></td>
        <td><?php if ($pageNum_Tours > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_Tours=%d%s", $currentPage, 0, $queryString_Tours); ?>"><img src="images/First.gif" /></a>
        <?php } else {?><img src="images/First_disable.gif" /> <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_Tours > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_Tours=%d%s", $currentPage, max(0, $pageNum_Tours - 1), $queryString_Tours); ?>"><img src="images/Previous.gif" /></a>
        <?php } else {?><img src="images/Previous_disable.gif" /> <?php } // Show if not first page ?></td>
        <td><?php echo $pageNum_Tours+1 ?> of <?php echo $totalPages_Tours+1 ?></td>
        <td><?php if ($pageNum_Tours < $totalPages_Tours) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_Tours=%d%s", $currentPage, min($totalPages_Tours, $pageNum_Tours + 1), $queryString_Tours); ?>"><img src="images/Next.gif" /></a>
            <?php } else {?><img src="images/Next_disable.gif" /> <?php }// Show if not last page ?></td>
        <td><?php if ($pageNum_Tours < $totalPages_Tours) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_Tours=%d%s", $currentPage, $totalPages_Tours, $queryString_Tours); ?>"><img src="images/Last.gif" /></a>
            <?php } else {?><img src="images/Last_disable.gif" /> <?php }// Show if not last page ?></td>
      </tr>
    </table>
    
    <?php 
	if (mysql_num_rows($Tours)==0)
	{
	echo "No Results were found ...";	
		
	}
		else
		{
	
	do { ?>
      <div class="placesList">    <div class="placeImage"> <a href="ToursDetails.php?tour=<?php echo $row_Tours['TourId']; ?>"><img src="<?php echo $row_Tours['TourPicture']; ?>" width="196" height="156" alt="<?php echo $row_Tours['TourPictureName']; ?>" /></a> </div>
        <div class="PlaceDesc"> 
        <div class="EditDelete">
        Price: <?php echo $row_Tours['TourPrice']; ?>
          
          
</div>

          <h4><a href="ToursDetails.php?tour=<?php echo $row_Tours['TourId']; ?>"><?php echo $row_Tours['TourName']; ?></a></h4>
          <p class="placeDesc"><?php echo $row_Tours['TourDesc']; ?> ...</p>
        </div>
      </div>
      <?php } while ($row_Tours = mysql_fetch_assoc($Tours)); ?>
    
    <p>
    <table border="0" align="right">
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td><?php if ($pageNum_Tours > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_Tours=%d%s", $currentPage, 0, $queryString_Tours); ?>"><img src="images/First.gif" /></a>
        <?php } else {?><img src="images/First_disable.gif" /> <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_Tours > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_Tours=%d%s", $currentPage, max(0, $pageNum_Tours - 1), $queryString_Tours); ?>"><img src="images/Previous.gif" /></a>
        <?php } else {?><img src="images/Previous_disable.gif" /> <?php } // Show if not first page ?></td>
        <td><?php echo $pageNum_Tours+1 ?> of <?php echo $totalPages_Tours+1 ?></td>
        <td><?php if ($pageNum_Tours < $totalPages_Tours) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_Tours=%d%s", $currentPage, min($totalPages_Tours, $pageNum_Tours + 1), $queryString_Tours); ?>"><img src="images/Next.gif" /></a>
            <?php } else {?><img src="images/Next_disable.gif" /> <?php }// Show if not last page ?></td>
        <td><?php if ($pageNum_Tours < $totalPages_Tours) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_Tours=%d%s", $currentPage, $totalPages_Tours, $queryString_Tours); ?>"><img src="images/Last.gif" /></a>
            <?php } else {?><img src="images/Last_disable.gif" /> <?php }// Show if not last page ?></td>
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
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
<!-- InstanceEnd --></html>
<?php
		}
mysql_free_result($Tours);
?>
