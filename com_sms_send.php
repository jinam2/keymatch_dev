<?

	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");



	$status			= $_POST["status"];
	$extra_input1	= $_POST["extra_input1"];
	#기업:빈값 / 개인:per
	$extra_input2	= $_POST["extra_input2"];
	$extra_input3	= $_POST["extra_input3"];



	$log_file = "sms_".date("Y_m").".log";
	write_log("./data/$log_file", $_POST);



	if ( $status == "success" && $extra_input1 != "" )
	{
		
		if ( $extra_input2 == "" )
		{
			//기업회원이 개인회원에게 SMS보냈을때 포인트 차감
			$Data["guin_smspoint"] = happy_member_option_get($happy_member_option_type,$extra_input1,'guin_smspoint');

			if ( $Data["guin_smspoint"] > 0 )
			{
				$guin_smspoint = $Data["guin_smspoint"] - 1;
				happy_member_option_set($happy_member_option_type,$extra_input1,'guin_smspoint',$guin_smspoint,'int(11)');
			}
		}
		else if ( $extra_input2 == "per" )
		{
			//개인회원이 개인회원 또는 기업회원에게 SMS보냈을때 포인트 차감
			$Data["guzic_smspoint"] = happy_member_option_get($happy_member_option_type,$extra_input1,'guzic_smspoint');

			if ( $Data["guzic_smspoint"] > 0 )
			{
				$guzic_smspoint = $Data["guzic_smspoint"] - 1;
				happy_member_option_set($happy_member_option_type,$extra_input1,'guzic_smspoint',$guzic_smspoint,'int(11)');
			}
		}
	}
?>