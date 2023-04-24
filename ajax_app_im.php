<?
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start = array_sum(explode(' ', microtime()));
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$Sql		= "SELECT * FROM $com_guin_per_tb WHERE com_id='$happy_member_login_value' AND cNumber='$_GET[cNumber]' AND pNumber='$_GET[pNumber]' ";
	$Rec		= query($Sql);
	$CGP_DATA	= happy_mysql_fetch_assoc($Rec);
	
	if($CGP_DATA['com_id'] != $happy_member_login_value)
	{
		echo "error";
		exit;
	}
	else
	{
		$Sql	= "UPDATE $com_guin_per_tb SET app_im = '$_GET[update_value]' WHERE com_id='$happy_member_login_value' AND cNumber='$_GET[cNumber]' AND pNumber='$_GET[pNumber]' ";
		query($Sql);

		if($_GET['update_value'] == 'Y')
		{
			$update_value_change	= "N";
			$app_im_alt				= "★";
		}
		else
		{
			$update_value_change	= "Y";
			$app_im_alt				= "☆";
		}

		if($_COOKIE['happy_mobile'] == "on")
		{
			$app_im_img				= "mobile_img/app_im_{$update_value_change}.gif";
			
		}
		else
		{
			$app_im_img				= "img/app_im_{$update_value_change}.gif";
		}

		$return_img					= "<img src='$app_im_img' alt='$app_im_alt' onClick=\"happy_app_im_change('$_GET[userType]','$update_value_change','$_GET[cNumber]','$_GET[pNumber]');\">";
	}

	echo "ok___cut___$return_img";
	exit;
?>