<?
	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");


	$추천인포인트			= $HAPPY_CONFIG['recommend_point'];
	$추천가입포인트			= $HAPPY_CONFIG['recommend_join_point'];

	$메인페이지링크			= "$main_url/?$recommend_get_id=$mem_id";
	$회원가입페이지링크		= "$main_url/happy_member.php?mode=joinus&$recommend_get_id=$mem_id";

	if ( preg_match("/Chrome/i",$_SERVER['HTTP_USER_AGENT']) )		//Edge, Chrome 모두 여기에 걸림.
	{
		$메인스크립트코드			= "alert('사용중인 브라우저는 클립보드를 사용할 수 없는 브라우저 입니다.\\n수동으로 주소를 복사하시기 바랍니다.')";
		$회원가입스크립트코드		= "alert('사용중인 브라우저는 클립보드를 사용할 수 없는 브라우저 입니다.\\n수동으로 주소를 복사하시기 바랍니다.')";
	}
	else
	{
		$메인스크립트코드			= "recommend_copy('main')";
		$회원가입스크립트코드		= "recommend_copy('join')";
	}

	if( !(is_file("$skin_folder/recommend_link.html")) ) {
		print "추천인 링크 페이지 $skin_folder/recommend_link.html 파일이 존재하지 않습니다. <br>";
		return;
	}
	$TPL->define("추천인링크", "$happy_member_skin_folder/recommend_link.html");
	$content = &$TPL->fetch();

	echo $content;

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec</font></center>";

	if ( $demo_lock=='1' || $aaa_debug  )
	{
		print $쿼리시간;
	}
	exit;
?>