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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tblplacescomments (PlaceId, WebLanguageId, ComentDate, Name, Email, Coment, Points, IP) VALUES (%s, %s, %s, %s, %s, %s, %s,%s)",
                       GetSQLValueString($_GET['place'], "int"),
					   GetSQLValueString($_SESSION['MM_WebLanguageId'], "int"),
					   GetSQLValueString(date("Y-m-d"), "date"),
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Coment'], "text"),
                       GetSQLValueString($_POST['Rate'], "numeric"),
					   GetSQLValueString($_SERVER['REMOTE_ADDR'], "text"));

  mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
  $Result1 = mysql_query($insertSQL, $ChoosingGuidesConnection) or die(mysql_error());

  $insertGoTo = "PlacesDetails.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  @header(sprintf("Location: %s", $insertGoTo));
}

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
	$WebLanguage_Places = $_SESSION['MM_WebLanguageId'];
	}
$place_Places = "-1";
if (isset($_GET['place'])) {
  $place_Places = $_GET['place'];
}
mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_Places = sprintf("SELECT
tblplacesdet.PlaceDetId,
tblplacesdet.PlaceId,
tblplacesdet.WebLanguageId,
tblplacesdet.PlaceName,
tblplacesdet.PlaceDesc,
tblplacesdet.PlaceAddress,
(select round(avg(Points),2) from tblplacescomments where PlaceId=tblplacesdet.PlaceId and Points!=0) as avgPoints,
(select count(*) from tblplacescomments where PlaceId=tblplacesdet.PlaceId and Points!=0) as countPoints,
tblplaces.x,
tblplaces.y
FROM
tblplacesdet
INNER JOIN tblplaces ON tblplacesdet.PlaceId = tblplaces.PlaceId WHERE WebLanguageId = %s AND tblplacesdet.PlaceId=%s", GetSQLValueString($WebLanguage_Places, "int"),GetSQLValueString($place_Places, "int"));
$query_limit_Places = sprintf("%s LIMIT %d, %d", $query_Places, $startRow_Places, $maxRows_Places);
$Places = mysql_query($query_limit_Places, $ChoosingGuidesConnection) or die(mysql_error());
$row_Places = mysql_fetch_assoc($Places);

$query_clickcounter = sprintf("UPDATE tblplacesdet SET ClickCounter=ClickCounter+1 WHERE PlaceId=%s",GetSQLValueString($place_Places, "int"));
	$clickcounter = mysql_query($query_clickcounter, $ChoosingGuidesConnection) or die(mysql_error());


if (isset($_GET['totalRows_Places'])) {
  $totalRows_Places = $_GET['totalRows_Places'];
} else {
  $all_Places = mysql_query($query_Places);
  $totalRows_Places = mysql_num_rows($all_Places);
}
$totalPages_Places = ceil($totalRows_Places/$maxRows_Places)-1;

if (isset($_GET['pageNum_PlacePictures'])) {
  $pageNum_PlacePictures = $_GET['pageNum_PlacePictures'];
}

$place_PlacePictures = "-1";
if (isset($_GET['place'])) {
  $place_PlacePictures = $_GET['place'];
}
mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_PlacePictures = sprintf("SELECT tblplacespictures.PlacePictId, tblplacespictures.PlaceId, tblplacespictures.PictureName, tblplacespictures.PicturePath FROM tblplacespictures WHERE tblplacespictures.PlaceId=%s", GetSQLValueString($place_PlacePictures, "int"));
$PlacePictures = mysql_query($query_PlacePictures, $ChoosingGuidesConnection) or die(mysql_error());
$row_PlacePictures = mysql_fetch_assoc($PlacePictures);

$placedet_Coments = "-1";
if (isset($_GET['place'])) {
  $placedet_Coments = $_GET['place'];
}
mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_Coments = sprintf("SELECT tblplacescomments.PlaceComentId, tblplacescomments.PlaceId, ComentDate, tblplacescomments.Name, tblplacescomments.Email, tblplacescomments.Coment, tblplacescomments.Points FROM tblplacescomments WHERE tblplacescomments.PlaceId=%s", GetSQLValueString($placedet_Coments, "int"));
$Coments = mysql_query($query_Coments, $ChoosingGuidesConnection) or die(mysql_error());
$row_Coments = mysql_fetch_assoc($Coments);
$totalRows_Coments = mysql_num_rows($Coments);


?>
<script type='text/javascript' 
src='https://ajax.googleapis.com/ajax/libs/prototype/1/prototype.js'></script>
<script type='text/javascript' 
src='https://ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'></script>
<script type='text/javascript' src='/js/starbox.js'></script>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/GlobalTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head><link rel="Shortcut Icon" href="images/cg.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Choosing Guides</title>
<link href="SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<!-- InstanceEndEditable -->
<link href="CSS/twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 7]>
<style>
.content { margin-right: -1px; } /* this 1px negative margin can be placed on any of the columns in this layout with the same corrective effect. */
ul.nav a { zoom: 1; }  /* the zoom property gives IE the hasLayout trigger it needs to correct extra whiltespace between the links */
</style>
<![endif]-->
<!-- InstanceBeginEditable name="head" -->
<script src="SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>

<!-- BeginOAWidget_Shared_2187524 -->
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<!-- EndOAWidget_Shared_2187524 -->
<script type="text/javascript">


function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
<script type="text/xml">
<!--
<oa:widgets>
  <oa:widget wid="2187524" binding="#mapCanvas" />
</oa:widgets>
-->
</script>

<!-- InstanceEndEditable -->
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
</head>
<body bgcolor="#D2D2FF">
<div class="container">
  <div class="header">
  <div class="logo">
  <a href="Index.php"><img src="images/LogoChoosingGuides.gif" alt="Logo" name="logo" width="300" height="100" class="logo" id="logo" style="background-color: #8090AB; display:block;" /></a> 
    <!-- end .header -->
    </div>
    <div class="weblanguage">
    <?php 
//if (is_file("Includes/SelectLanguage.php"))
//{
include ("Includes/SelectLanguage.php");
/*}
else
{
	include ("../Includes/SelectLanguage.php");
	}*/
?>

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
  <div class="placeMainImage">
  <img src="<?php echo $row_PlacePictures['PicturePath']; ?>" alt="" name="mainimage" width="754" height="400" id="mainimage" />
  </div>
  
<div class="placeDetailsImage">
 <?php do { ?>
 <div class="imageBorder">
 
          <img src="<?php echo $row_PlacePictures['PicturePath']; ?>" alt="<?php echo $row_PlacePictures['PictureName']; ?>" name="<?php echo $row_PlacePictures['PlacePictId']; ?>" width="96" height="76" id="<?php echo $row_PlacePictures['PlacePictId']; ?>" onMouseOver="MM_swapImage('mainimage','','<?php echo $row_PlacePictures['PicturePath']; ?>',1)" />
          <div class="tooltipContent" id="<?php echo "tooltext".$row_PlacePictures['PlacePictId']; ?>"><?php echo $row_PlacePictures['PictureName']; ?>
          </div>
        </div>

<?php if (isset($row_PlacePictures['PlacePictId'])){?>
          <script type="text/javascript">
var <?php echo "tool".$row_PlacePictures['PlacePictId']; ?> = new Spry.Widget.Tooltip("<?php echo "tooltext".$row_PlacePictures['PlacePictId']; ?>", "<?php echo "#".$row_PlacePictures['PlacePictId']; ?>");
</script>
<?php }?>
          <?php } while ($row_PlacePictures = mysql_fetch_assoc($PlacePictures)); ?>
</div>
<div class="placeDetailsDesc">
<div class="Valoration">
 <div class="stars">
 <?php echo '('.$row_Places['countPoints'].' Votes)  '. $row_Places['avgPoints']?>
<img src="images/Stars.png" width="100" height="20" alt="Stars"  style="background-image:url(images/StarsBack.png); background-position:<?php echo 100+$row_Places['avgPoints']*20 ?>px 0px; margin-left:10px; vertical-align:central"/>
</div>
 <h4><?php echo $row_Places['PlaceName']; ?> </h4>
</div>
      <?php echo $row_Places['PlaceDesc'].' '.$row_Places['PlaceAddress']; ?>    </div>
    <?php if ($row_Places['x']){?>
    <div class="placeDetailsDesc" id="mapCanvas" style="min-width:300px; min-height:300px"></div>
    <?php }?>
   <?php if ($totalRows_Coments!=0){?>
    <h4>Comments </h4>
    <?php do { ?>
    <div class="placeDetailsCom">
     
     <div class="Valoration">
      <div class="starsSmall">
 <?php 
 if ($row_Coments['Points']!=0){
 echo $row_Coments['Points']?>
<img src="images/StarsSmall.png" width="80" height="16" alt="StarsSmall"  style="background-image:url(images/StarsBackSmall.png); background-position:<?php echo 80+$row_Coments['Points']*16 ?>px 0px; margin-left:10px; vertical-align:central"/>
<?php }?>
</div>

 <h4><?php echo $row_Coments['Name'].'   ('.$row_Coments['ComentDate'].')'; ?></h4>
</div>
        
<?php echo $row_Coments['Coment']; ?>
    </div>
    <?php } while ($row_Coments = mysql_fetch_assoc($Coments)); }?>
    
     <div class="placeDetailsComAdd">
       <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
         <table align="left">
           <tr valign="baseline">
             <td nowrap="nowrap" align="right">Name:</td>
             <td><span id="sprytextfield1">
               <input type="text" name="Name" value="" size="32" />
             <span class="textfieldRequiredMsg">A value is required.</span></span></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right">Email:</td>
             <td><span id="sprytextfield2">
             <input type="text" name="Email" value="" size="32" />
             <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right" valign="top">Comment:</td>
             <td><span id="sprytextarea1">
             <textarea name="Coment" cols="50" rows="5"></textarea>
             <span id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg">Exceeded maximum number of characters.</span><span class="textareaMinCharsMsg">Minimum number of characters not met.</span></span></td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right">Valoration:</td>
             <td><label for="valoration"></label>
               <?php include("Stars.php"); ?>
             </td>
           </tr>
           <tr valign="baseline">
             <td nowrap="nowrap" align="right">&nbsp;</td>
             <td><input type="submit" value="Add Coment" /></td>
           </tr>
         </table>
         <input type="hidden" name="PlaceDetId" value="<?php echo $row_Places['PlaceDetId']; ?>" />
         <input type="hidden" name="PlaceDetId" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
         <input type="hidden" name="MM_insert" value="form1" />
       </form>
       <p>&nbsp;</p>
     </div>
    
    
    
    
    
    <script type="text/javascript">
// BeginOAWidget_Instance_2187524: #mapCanvas

	  // initialize the google Maps 	
	
     function initializeGoogleMap() {
		// set latitude and longitude to center the map around
		var latlng = new google.maps.LatLng(<?php echo $row_Places['x']; ?>,<?php echo $row_Places['y']; ?>);
		
		// set up the default options
		var myOptions = {
		  zoom: 15,
		  center: latlng,
		  navigationControl: true,
		  navigationControlOptions: 
		  	{style: google.maps.NavigationControlStyle.DEFAULT,
			 position: google.maps.ControlPosition.TOP_LEFT },
		  mapTypeControl: true,
		  mapTypeControlOptions: 
		  	{style: google.maps.MapTypeControlStyle.DEFAULT,
			 position: google.maps.ControlPosition.TOP_RIGHT },

		  scaleControl: true,
		   scaleControlOptions: {
        		position: google.maps.ControlPosition.BOTTOM_LEFT
    	  }, 
		  mapTypeId: google.maps.MapTypeId.ROADMAP,
		  draggable: true,
		  disableDoubleClickZoom: false,
		  keyboardShortcuts: true
		};
		var map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);
		if (false) {
			var trafficLayer = new google.maps.TrafficLayer();
			trafficLayer.setMap(map);
		}
		if (false) {
			var bikeLayer = new google.maps.BicyclingLayer();
			bikeLayer.setMap(map);
		}
		
			addMarker(map,<?php echo $row_Places['x']; ?>,<?php echo $row_Places['y']; ?>,"We are here");
		
	  }

	  window.onload = initializeGoogleMap();

	 // Add a marker to the map at specified latitude and longitude with tooltip
	 function addMarker(map,lat,long,titleText) {
	  	var markerLatlng = new google.maps.LatLng(lat,long);
	 	var marker = new google.maps.Marker({
      		position: markerLatlng, 
      		map: map, 
      		title:"Esto es una prueba",
			icon: ""});   
	 }

	
// EndOAWidget_Instance_2187524
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {maxChars:500, counterId:"countsprytextarea1", counterType:"chars_remaining", minChars:10, isRequired:false});
    </script>
    
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
mysql_free_result($Coments);

mysql_free_result($Places);

mysql_free_result($PlacePictures);
?>
