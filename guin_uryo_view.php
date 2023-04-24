<?
	include ("./inc/Template.php");
	$TPL = new Template;

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	$number	= $_GET["number"];

	//print_r2($_SERVER);
	
	if ( happy_member_login_check == "" || $number == "" )
	{
		error("잘못된 경로로 접근하셨습니다.");
		exit;
	}
	
	$Data["guzic_view2"] = happy_member_option_get($happy_member_option_type,$member_id,'guzic_view2');

	if ( $Data["guzic_view2"] < 1 )
	{
		error("볼수있는 채용정보의 수를 초과하였습니다.");
		exit;
	}

	$guzic_view2 = $Data["guzic_view2"] - 1;
	happy_member_option_set($happy_member_option_type,$member_id,'guzic_view2',$guzic_view2,'int(11)');

	$Sql	= "INSERT INTO $job_per_guin_view_tb SET per_id='$user_id', guin_number='$number' ";
	query($Sql);

	go($_SERVER['HTTP_REFERER']);
	exit;

?>