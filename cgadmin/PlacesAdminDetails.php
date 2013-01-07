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

$maxRows_Places = 10;
$pageNum_Places = 0;
if (isset($_GET['pageNum_Places'])) {
  $pageNum_Places = $_GET['pageNum_Places'];
}
$startRow_Places = $pageNum_Places * $maxRows_Places;


$place_Places = "-1";
if (isset($_GET['place'])) {
  $place_Places = $_GET['place'];
}
mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
$query_Places = sprintf("SELECT
tblplacesdet.PlaceId,
tblplacesdet.WebLanguageId,
tblplacesdet.PlaceName,
tblplacesdet.PlaceDesc,
tblplacesdet.PlaceAddress,
tblweblanguage.WebLanguageCode,
tblweblanguage.WebLanguageName,
tblplacesdet.ClickCounter
FROM
tblplacesdet
INNER JOIN tblweblanguage ON tblplacesdet.WebLanguageId = tblweblanguage.WebLanguageId
WHERE tblplacesdet.PlaceId=%s", GetSQLValueString($place_Places, "int"));
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
function subirimagen()
  {
	  self.name = 'opener'
	  remote=open('ImageManament.php?place=<?php echo $place_PlacePictures?>', 'remote', 'width=400,height=150, location=no,scrollbars=yes,menubars=no,toolbars=no,rezisable=yes,fullscreen=no,status=yes');
	  remote.focus();
	  }
  


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
  <img src="<?php echo "../".$row_PlacePictures['PicturePath']; ?>" alt="" name="mainimage" width="754" height="400" id="mainimage" />
  </div>
  
<div class="placeDetailsImage">
 <?php do { ?>
 <div class="imageBorder">
 <div class="deletePicture"> <a href="PlacesAdminDelPic.php?picture=<?php echo $row_PlacePictures['PlacePictId'] ?>&amp;place=<?php echo $place_Places; ?>"><img src="../images/Delete.png" alt="delete" width="16" height="16" id="sprytrigger1" /></a>
 </div>
  
          <img src="<?php echo "../".$row_PlacePictures['PicturePath']; ?>" alt="<?php echo $row_PlacePictures['PictureName']; ?>" name="<?php echo $row_PlacePictures['PlacePictId']; ?>" width="96" height="76" id="<?php echo $row_PlacePictures['PlacePictId']; ?>" onmouseover="MM_swapImage('mainimage','','<?php echo "../".$row_PlacePictures['PicturePath']; ?>',1)" />
         
        <div class="tooltipContent" id="<?php echo "tooltext".$row_PlacePictures['PlacePictId']; ?>"><?php echo $row_PlacePictures['PictureName']; ?></div> </div>

<?php if (isset($row_PlacePictures['PlacePictId'])){?>
          <script type="text/javascript">
var <?php echo "tool".$row_PlacePictures['PlacePictId']; ?> = new Spry.Widget.Tooltip("<?php echo "tooltext".$row_PlacePictures['PlacePictId']; ?>", "<?php echo "#".$row_PlacePictures['PlacePictId']; ?>");
</script>
<?php }?>
          <?php } while ($row_PlacePictures = mysql_fetch_assoc($PlacePictures)); ?>
</div>
<div class="tooltipContent" id="sprytooltip1">Delete Picture</div>
<form action="" method="post" name="addpicture">
  <input name="uploadpicture" type="submit" value="Add Pictures"  onclick="javascript:subirimagen();"/>
  <input name="AddDetails" type="button" onclick="MM_goToURL('parent','PlacesAdminAddDet.php?place=<?php echo $place_Places ?>');return document.MM_returnValue" value="Add Others Languages" />
  <input name="Edit" type="button" onclick="MM_goToURL('parent','PlacesAdminEdit.php?place=<?php echo $place_Places;?>');return document.MM_returnValue" value="General Data Edit" />
</form>

<?php do { ?>
<div class="placeDetailsDesc">
<div class="EditDelete">
<input name="Edit" type="button" onclick="MM_goToURL('parent','PlacesAdminEditDet.php?place=<?php echo $place_Places ?>&amp;language=<?php echo $row_Places['WebLanguageId']; ?>');return document.MM_returnValue" value="Edit" />
<input name="Delete" type="button" onclick="MM_goToURL('parent','PlacesAdminDelDet.php?place=<?php echo $place_Places ?>&amp;language=<?php echo $row_Places['WebLanguageId']; ?>');return document.MM_returnValue" value="Delete" /></div>


      <h4><?php echo $row_Places['PlaceName']."  (".$row_Places['WebLanguageName'].")"."  (".$row_Places['ClickCounter'].")"; ?> </h4>
      <hr size="1" noshade="noshade" />
      <p><?php echo $row_Places['PlaceDesc']; ?> <?php echo $row_Places['PlaceAddress']; ?></p>
    </div>
    
   
     <?php } while ($row_Places = mysql_fetch_assoc($Places)); ?>
  
   <div class="mapa">
     
   </div>
  
  
   <script type="text/javascript">
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#sprytrigger1");
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
mysql_free_result($Places);

mysql_free_result($PlacePictures);
?>
