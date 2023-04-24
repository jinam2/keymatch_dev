<?
	include ("./inc/Template.php");
	$TPL = new Template;

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	$number	= $_GET["number"];

	if ( happy_member_login_check() == "" || $number == "" )
	{
		error("잘못된 경로로 접근하셨습니다.");
		exit;
	}



	$Sql	= "SELECT count(*) FROM $job_com_doc_view_tb WHERE com_id='$user_id' AND doc_number='$number' ";
	$Tmp	= happy_mysql_fetch_array(query($Sql));

	if ( $Tmp[0] != 0 )
	{
		error("이미 보실수 있는 이력서 입니다.");
		exit;
	}
	
	//회수별 이력서 보기 회수
	$Data["guin_docview2"] = happy_member_option_get($happy_member_option_type,$user_id,"guin_docview2");

	if ( $Data["guin_docview2"] < 1 )
	{
		error("볼수있는 이력서의 수를 초과하였습니다.");
		exit;
	}

	//회수별 이력서 보기 회수 차감
	happy_member_option_set($happy_member_option_type,$user_id,"guin_docview2",($Data["guin_docview2"]-1),"int(11)");

	$Sql	= "INSERT INTO $job_com_doc_view_tb SET com_id='$user_id', doc_number='$number' ";
	query($Sql);

	#echo "<script>history.go(-1);</script>";
	$method	= explode("?", $_SERVER["REQUEST_URI"]);

	go("document_view.php?$method[1]");
	exit;
?>