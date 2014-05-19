<?php
require_once("applylib.php");
try
{
	$formatting = stealWordPressFormatting();
}
catch(Exception $e)
{
	echo "Unable to reformat page: " . $e->getMessage() . "<br />";
	exit;
}
echo $formatting[0];
?>
<h1>Thank You!</h1>
<p>Thank you for applying to Deep Dive Coders. We will be in touch shortly.</p>
<?php echo $formatting[1]; ?>