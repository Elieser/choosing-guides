<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
if (!isset($_SESSION)) {
  session_start();
}

$hostname_ChoosingGuidesConnectionLocal = "localhost";
$hostname_ChoosingGuidesConnection = "db440267796.db.1and1.com";
$database_ChoosingGuidesConnection = "db440267796";
$username_ChoosingGuidesConnection = "dbo440267796";
$password_ChoosingGuidesConnection = "david-25";
@$ChoosingGuidesConnection = mysql_pconnect($hostname_ChoosingGuidesConnectionLocal, $username_ChoosingGuidesConnection, $password_ChoosingGuidesConnection) or trigger_error(mysql_error(),E_USER_ERROR); 
#$ChoosingGuidesConnection = mysql_pconnect($hostname_ChoosingGuidesConnection, $username_ChoosingGuidesConnection, $password_ChoosingGuidesConnection) or trigger_error(mysql_error(),E_USER_ERROR); 

if (!isset($_SESSION['MM_WebLanguageId']) || $_SESSION['MM_WebLanguageId']==0 )
	{
	//	global $database_ChoosinGuidesConection, $ChoosinGuidesConection;
		mysql_select_db($database_ChoosingGuidesConnection, $ChoosingGuidesConnection);
		$query_GetWebLanguage = sprintf("SELECT tblweblanguage.WebLanguageId FROM tblweblanguage WHERE tblweblanguage.esDefaultLanguage = 1");
		$queryWebLanguage = mysql_query($query_GetWebLanguage, $ChoosingGuidesConnection) or die(mysql_error());
		$row_queryWebLanguage = mysql_fetch_assoc($queryWebLanguage);
		$totalRows_queryWebLanguage = mysql_num_rows($queryWebLanguage);
		$_SESSION['MM_WebLanguageId']=$row_queryWebLanguage['WebLanguageId'];
		
		mysql_free_result($queryWebLanguage);
	}

?>