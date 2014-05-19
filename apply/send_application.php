<?php
require_once("../../config.php");
require_once("applylib.php");

$mysqli = null;
try
{
	verifyCaptcha();
	$mysqli = Pointer::getMySqli();
	postApplicationToMySQL($mysqli);
	emailApplicationResults($mysqli);
}
catch(Exception $e)
{
	echo "Unable to send application form: " . $e->getMessage();
}

$url = preg_replace("/(\\w+\.php)$/", "thankyou.php", $_SERVER["PHP_SELF"]);
header("Location: $url");
?>
