<?
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start			= array_sum(explode(' ', microtime()));
	$TPL				= new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$mode				= $_POST['mode'] == '' ? $_GET['mode'] : $_POST['mode'];
	$Template			= '';

	$go_url				= $_POST['referer'] == '' ? "company.php" : $_POST['referer'];
	$go_url				= ( preg_match("/happy_member_login\.php/",$go_url) ) ? "company.php" : $go_url;

	if ( $happy_member_login_value == "" )
	{
		gomsg("로그인 후 이용하세요.","happy_member_login.php?returnUrl=".urlencode($_SERVER['REQUEST_URI']));
		exit;
	}

	if ( $mode == 'mod' || $mode == 'mod_reg' || $mode == 'del' )
	{
		$number				= ( $_POST['number'] != '' ) ? $_POST['number'] : $_GET['number'];
		$number				= preg_replace('/\D/', '', $number);

		$Sql				= "SELECT user_id FROM $job_company WHERE number = '$number' ";
		$Data				= happy_mysql_fetch_assoc(query($Sql));

		if ( $Data['user_id'] != $happy_member_login_value )
		{
			error("권한이 없습니다.");
			exit;
		}
	}

	if ( $mode == 'add_reg' || $mode == 'mod_reg' ) //등록,수정 처리
	{
		$establish_year		= preg_replace('/\D/', '', $_POST['establish_year']);
		$establish_month	= preg_replace('/\D/', '', $_POST['establish_month']);
		$sales_money		= $_POST['sales_money'];
		$worker_count		= preg_replace('/\D/', '', $_POST['worker_count']);
		$company_shape		= $_POST['company_shape'];
		$homepage			= $_POST['homepage'];
		$take_person		= $_POST['take_person'];
		$company_name		= $_POST['company_name'];
		$phone				= $_POST['phone'];
		$email				= $_POST['email'];
		$fax				= $_POST['fax'];

		$present_name		= $_POST['present_name'];
		$company_type		= $_POST['company_type'];
		$company_content	= $_POST['company_content'];

		$SetSql				= "
								establish_year	= '$establish_year',
								establish_month	= '$establish_month',
								sales_money		= '$sales_money',
								worker_count	= '$worker_count',
								company_shape	= '$company_shape',
								homepage		= '$homepage',
								take_person		= '$take_person',
								company_name	= '$company_name',
								phone			= '$phone',
								email			= '$email',
								fax				= '$fax',
								present_name	= '$present_name',
								company_type	= '$company_type',
								company_content	= '$company_content'
		";

		if ( $mode == 'add_reg' )
		{
			$Sql				= "
									INSERT INTO
											$job_company
									SET
											$SetSql ,

											user_id			= '$happy_member_login_value',
											reg_date		= NOW()
			";
			//echo nl2br($Sql);exit;
			query($Sql);
			gomsg("등록이 완료되었습니다.", $go_url);
		}
		else
		{
			$number				= preg_replace('/\D/', '', $_POST['number']);

			$Sql				= "
									UPDATE
											$job_company
									SET
											$SetSql
									WHERE
											number			= '$number'
			";
			//echo nl2br($Sql);exit;
			query($Sql);
			gomsg("수정이 완료되었습니다.", $go_url);
		}

		exit;
	}
	else if ( $mode == 'add' || $mode == 'mod' ) //등록,수정 페이지
	{
		$Template			= 'company.html';
		if( $_COOKIE[happy_mobile] == 'on' )
		{
			$Template			= 'company_add.html';
		}
		$submit_str			= '등록하기';
		$form_mode			= 'add_reg';

		if ( $mode == 'mod' )
		{
			$submit_str			= "수정하기";
			$form_mode			= 'mod_reg';

			$number				= $_GET['number'];

			$Sql				= "
									SELECT
											*
									FROM
											$job_company
									WHERE
											number = '$number'
			";
			$Data				= happy_mysql_fetch_assoc(query($Sql));
		}
	}
	else if ( $mode == 'del' )
	{
		$Sql				= "
								DELETE FROM
										$job_company
								WHERE
										number			= '$number'
		";
		query($Sql);

		//채용정보 수정
		$Sql				= "
								UPDATE
										$guin_tb
								SET
										company_number	= 0
								WHERE
										company_number	= '$number'
		";
		query($Sql);

		$Sql				= "
								UPDATE
										$com_guin_per_tb
								SET
										company_number	= 0
								WHERE
										company_number	= '$number'
		";
		query($Sql);

		gomsg("삭제되었습니다.", $go_url);
		exit;
	}
	else if ( $mode == 'document_list' )
	{
		$Template			= 'company_document_list.html';
	}
	else //리스트
	{
		$Template			= 'company_list.html';
	}

	#echo $skin_folder."/".$Template;
	$TPL->define("회사등록알맹이", $skin_folder."/".$Template);
	$content			= $TPL->fetch("회사등록알맹이");
	$내용				= $content;

	$Member				= happy_member_information($happy_member_login_value);
	$member_group		= $Member['group'];
	$Sql				= "SELECT * FROM $happy_member_group WHERE number = '$member_group'";
	$Group				= happy_mysql_fetch_array(query($Sql));
	$Template_Default	= $Group['mypage_default'] == '' ? $happy_member_mypage_default_file : $Group['mypage_default'];
	$Template_Default	= $Template_Default == '' ? $happy_member_mypage_default_file : $Template_Default;

	//echo "$happy_member_skin_folder/$Template_Default";
	$TPL->define("회사등록껍데기", "$happy_member_skin_folder/$Template_Default");
	$content			= $TPL->fetch("회사등록껍데기");


	echo $content;


	$exec_time			= array_sum(explode(' ', microtime())) - $t_start;
	$exec_time			= round ($exec_time, 2);
	$쿼리시간			= "<br><center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";

	if ( $demo_lock=='1' )
	{
		print $쿼리시간;
	}
?>