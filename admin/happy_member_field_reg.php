<?
	$t_start = array_sum(explode(' ', microtime()));

	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");
	include ("../inc/Template.php");
	$TPL = new Template;

	if ( !admin_secure("회원관리") )
	{
		error("접속권한이 없습니다.");
		exit;
	}
	$max	= $_POST['maxCount'];

	$member_group	= $_POST['member_group'];
	#기존 gubun etc1으로 등록된 DB 삭제
	query("delete from $happy_member_field WHERE member_group='$member_group' ");


	for ( $i=0 ; $i<$max ; $i++ )
	{
		$field_name			= $_POST['field_name_'.$i];
		$field_title		= $_POST['field_title_'.$i];
		$field_use			= $_POST['field_use_'.$i];
		$field_use_admin	= $_POST['field_use_admin_'.$i];
		$field_modify		= $_POST['field_modify_'.$i];
		$field_view			= $_POST['field_view_'.$i];
		$field_sureInput	= $_POST['field_sureInput_'.$i];
		$field_type			= $_POST['field_type_'.$i];
		$field_template		= $_POST['field_template_'.$i];
		$field_option		= $_POST['field_option_'.$i];
		$field_style		= $_POST['field_style_'.$i];
		$field_group		= $_POST['field_group_'.$i];
		$field_sort			= $_POST['field_sort_'.$i];
		$admin_list_print	= $_POST['admin_list_print_'.$i];
		/* 2012-11-05 관리자 리스트 소팅 woo */
		$admin_list_sort	= $_POST['admin_list_sort_'.$i];

		/*
			2012-11-05 관리자 리스트 소팅 woo

			admin_list_sort		= '$admin_list_sort', 추가
		*/

		$Sql	= "
					INSERT INTO
							$happy_member_field
					SET
							member_group		= '$member_group',
							field_name			= '$field_name',
							field_title			= '$field_title',
							field_use			= '$field_use',
							field_use_admin		= '$field_use_admin',
							field_modify		= '$field_modify',
							field_view			= '$field_view',
							field_sureInput		= '$field_sureInput',
							field_type			= '$field_type',
							field_template		= '$field_template',
							field_option		= '$field_option',
							field_style			= '$field_style',
							field_group			= '$field_group',
							field_sort			= '$field_sort',
							admin_list_print	= '$admin_list_print',
							admin_list_sort		= '$admin_list_sort',
							regdate				= now()
				";

		#echo $Sql."<br><br>";
		query($Sql);
	}
	#exit;

	gomsg("수정되었습니다.","happy_member_field.php?group_number=$member_group");
	exit;


?>