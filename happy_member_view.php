<?
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start = array_sum(explode(' ', microtime()));
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$mode		= $_GET["mode"];
	$몰주소		= $main_url;







	$Templet	= "$happy_member_skin_folder/happy_member_view.html";


	$MemberData	= happy_member_information($view_user_id);
	$user_group	= $MemberData['group'];
	$Sql		= "SELECT * FROM $happy_member_group WHERE number='$user_group' ";
	$GROUP		= happy_mysql_fetch_array(query($Sql));





#######################################################################################################################

	$TPL->define("회원정보보기", $Templet);
	$내용	= &$TPL->fetch('회원정보보기');


	#회원정보 입력폼 문구내용
	echo "
	<style type='text/css'>
		label.guide_txt{display:none;}
	</style>
	";


	if( !(is_file("$happy_member_skin_folder/default_blank_pop.html")) ) {
		$content = "껍데기 $happy_member_skin_folder/default_blank_pop.html 파일이 존재하지 않습니다. <br>";
		return;
	}
	$TPL->define("빈껍데기", "$happy_member_skin_folder/default_blank_pop.html");
	$content = &$TPL->fetch("빈껍데기");



	echo $content;


?>