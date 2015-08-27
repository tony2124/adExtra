<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

/**
 * Website
 */

$ip = "192.168.0.101";

$ZP["webURL"] 	    = "http://$ip/adExtra";
//$ZP["webURL"] 	    = "http://itsaextraescolares.com/loginAdministrador/adExtra";
$ZP["webName"] 	    = "Aministrador Extraescolares";
$ZP["webTheme"]     = "default";
$ZP["webSituation"] = "Active";
$ZP["webMessage"]   = "";
$ZP["benchMark"]    = FALSE;

/**
 * Server
 */
$ZP["production"] = FALSE;
$ZP["domain"] 	  = FALSE;
$ZP["modRewrite"] = TRUE;
$ZP["autoRender"] = TRUE;

/**
 * Applications
 */

$ZP["defaultApplication"] = "admin";

/**
 * Languages
 */
$ZP["webLanguage"] = "Spanish";
$ZP["translation"] = "normal";

/**
 * Constants
 */
define("_sh", "/");
define("ruta_imagen", "http://$ip/adExtra/www/lib/images");
define("_rs", "http://$ip/extra");
define("_spath",$_SERVER['DOCUMENT_ROOT']."/extra");
/*define("_rs", "http://itsaextraescolares.com/");
define("_spath",$_SERVER['DOCUMENT_ROOT']."/");*/
define("_corePath", "zan");
define("_index", "index.php");
define("_secretKey", "_eh{Ll&}`<6Y\mg1Qw(;;|C3N9/7*HTpd7SK8t/[}R[vW2)vsPgBLRP2u(C|4]%m_");

/**
 * Cache
 */
define("_cacheStatus", FALSE);
define("_cacheDriver", "File");
define("_cacheHost", "localhost"); 
define("_cachePort", "11211");
define("_cacheDir", "www/lib/cache");
define("_cacheTime", 3600);
define("_cacheExt", ".cache");

/**
 * E-Mail
 */
define("_gUser", "youremail@gmail.com");
define("_gPwd", "USER PASSWORD");
define("_gSSL", "ssl://smtp.gmail.com");
define("_gPort", 465);

/**
 * Images:
 */
define("_library", "library");
define("_image", "image");
define("_images", "images");
define("_maxWidth", 720);
define("_maxHeight", 380);
define("_minSmall", 60);
define("_maxSmall", 90);
define("_minMini", 90);
define("_maxMini", 90);
define("_minMedium", 220);
define("_maxMedium", 320);
define("_minOriginal", 560);
define("_maxOriginal", 800);
define("_fileSize", 10485760);

if(!$ZP["modRewrite"]) {
	$ZP["webBase"] = $ZP["webURL"] . _sh . _index;
} else {
	$ZP["webBase"] = $ZP["webURL"];
}