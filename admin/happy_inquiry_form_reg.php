<?
	$t_start = array_sum(explode(' ', microtime()));

	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");
	if ( !admin_secure("카테고리관리") ) {
			error("접속권한이 없습니다.");
			exit;
	}

	$max	= $_POST['maxCount'];
	$gubun	= $_POST['gubun'];


	$WHERE = " gubun = '".$gubun."' ";


	#기존 gubun etc1으로 등록된 DB 삭제
	query("delete from $happy_inquiry_form WHERE $WHERE ");

	for ( $i=0 ; $i<$max ; $i++ )
	{
		$field_name			= $_POST['field_name_'.$i];
		$field_title		= $_POST['field_title_'.$i];
		$field_use			= $_POST['field_use_'.$i];
		$field_sureInput	= $_POST['field_sureInput_'.$i];
		$field_type			= $_POST['field_type_'.$i];
		$field_template		= $_POST['field_template_'.$i];
		$field_option		= $_POST['field_option_'.$i];
		$field_style		= $_POST['field_style_'.$i];
		$field_group		= $_POST['field_group_'.$i];
		$field_sort			= $_POST['field_sort_'.$i];

		#이름,연락처,이메일은 고정으로 필수입력 처리 hong
		if ( $field_name == 'user_name' || $field_name == 'user_phone' || $field_name == 'user_email' )
		{
			$field_sureInput	= 'y';
		}

		$Sql	= "
					INSERT INTO
							$happy_inquiry_form
					SET
							gubun				= '$gubun',
							field_name			= '$field_name',
							field_title			= '$field_title',
							field_use			= '$field_use',
							field_sureInput		= '$field_sureInput',
							field_type			= '$field_type',
							field_template		= '$field_template',
							field_option		= '$field_option',
							field_style			= '$field_style',
							field_group			= '$field_group',
							field_sort			= '$field_sort',
							regdate				= now()
				";

		#echo $Sql."<br><br>";
		query($Sql);
	}
	#exit;

	gomsg("수정되었습니다.","happy_inquiry_form.php?gubun=".urlencode($gubun));


	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<br><center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";

	if ( $demo_lock=='1' )
	{
		print $쿼리시간;
	}
?>