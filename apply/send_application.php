<?php
require_once("applylib.php");

$mysql = null;
try
{
	verifyCaptcha();
	$mysql = connectToMySQL();
	postApplicationToMySQL($mysql);
	emailApplicationResults($mysql);
}
catch(Exception $e)
{
	echo "Unable to send application form: " . $e->getMessage();
}
if($mysql !== null)
{
	$mysql->close();
}

/* echo "POST data:<br /><pre>\n";
print_r($_POST);

echo "</pre><br />SERVER data:<br /><pre>\n";
print_r($_SERVER);
echo "</pre>"; */

$url = preg_replace("/(\\w+\.php)$/", "thankyou.php", $_SERVER["PHP_SELF"]);
header("Location: $url");
?>