<?

	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");

	$value		= $_POST['value'];

	print_r($_POST);

	if($value == '') exit;

	if(strpos($value, 'upload/tmp') !== false && is_file($value))
	{
		unlink($value);
		unlink(str_replace("_thumb", "", $value));
	}
?>