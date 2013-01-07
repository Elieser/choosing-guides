<?php require_once('Connections/ChoosingGuidesConnection.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><link rel="Shortcut Icon" href="images/cg.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Choosing Guides</title>
<!-- TemplateEndEditable -->
<link href="../CSS/twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 7]>
<style>
.content { margin-right: -1px; } /* this 1px negative margin can be placed on any of the columns in this layout with the same corrective effect. */
ul.nav a { zoom: 1; }  /* the zoom property gives IE the hasLayout trigger it needs to correct extra whiltespace between the links */
</style>
<![endif]-->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
</head>
<body bgcolor="#D2D2FF">
<div class="container">
  <div class="header">
  <div class="logo">
  <a href="../Index.php"><img src="../images/LogoChoosingGuides.gif" alt="Logo" name="logo" width="300" height="100" class="logo" id="logo" style="background-color: #8090AB; display:block;" /></a> 
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
      <li><a href="../Tours.php">Tours</a></li>
      <li><a href="../Places.php">Interesting Places</a></li>
    </ul>
  </div> 
  <div class="content"><!-- TemplateBeginEditable name="Body" -->Body<!-- TemplateEndEditable --><!-- end .content --></div>
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
</html>