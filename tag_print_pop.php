<?php
	$t_start = array_sum(explode(' ', microtime()));

	/*****************************************************************/
	// 솔루션마다 다를 수 있음 //
	/*****************************************************************/
	include ("./inc/config.php");
	include ("./inc/function.php");
	$template_tag_view	= '0';
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");

	if ( !admin_secure("슈퍼관리자") && $_SERVER['REMOTE_ADDR'] != "115.93.87.162" )
	{
		msgclose("접속권한이 없습니다.   ");
		exit;
	}
	$tag	= $_POST['out_put'];
	if ($tag == '' )
	{
		$tag	= $_GET['out_put'];
	}
	if ($tag == "")
	{
		msgclose('잘못된 경로입니다.');
	}
	//conf_read();

	//알맹이파일
	$inTemplate		= "temp/tagview.html";

	//껍데기파일
	$outTemplate	= $skin_folder."/default_test_print_pop.html";

	/*****************************************************************/

	$div_form	= make_preview();

	setlocale (LC_TIME, "ko_KR.UTF-8");

	$오늘날짜 = strftime("%Y년 %b %d일(%a)");
	$메인주소 = $main_url;


	$TPL->define("알맹이", $inTemplate);
	$contents = &$TPL->fetch();

	$내용	= $div_form.$contents;

	$TPL->define("껍데기", $outTemplate);
	$TPL->assign("껍데기");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "Query Time : $exec_time sec";


	$쿼리시간 =  "<center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";
	//print $쿼리시간;

	$TPL->tprint();


function make_preview()
{
	global $tag,$out_put;
	global $inTemplate;

	$out_put = str_replace('<?',"&lt;?",$out_put);

$div_form	=  <<<END

<form method='post' action='tag_print_pop.php' name='tag_popup' >
<table cellspacing="0" cellpadding="0">
<tr>
	<td><textarea style='width:814px; height:50px; padding:10px; border:none; background:#303030; color:#ffffff; overflow:hidden; line-height:18px;' id='out_put' name='out_put'>$tag</textarea></td>
	<td><input type='image' src='print_tag_pop_img/btn_test_print_preview.jpg' value='미리보기' ></td>
</tr>
</table>
</form>

<div style='width:32px; margin:20px auto;'><img src='print_tag_pop_img/icon_print_tag_pop_arrow.png' alt='미리보기' title='미리보기'></div>

<div style="width:964px; font-family:'굴림',Gulim,'돋움',Dotum,'맑은 고딕',tahoma,NanumGothic,Helvetica,'Apple SD Gothic Neo',Sans-serif; background:#f8f8f8; border:1px solid #d2d2d2; padding:18px 0; text-align:center; color:#4f4e4e; font-size:12px; letter-spacing:-1px;">추출태그를 변경하시고 <strong style="color:#0980dc;">“미리보기”</strong> 를 클릭하시면 변경된 태그내용에 따른 디자인이 아래 내용에 미리보기로 출력됩니다.</div>

END;

$tag_write = <<<END
<div style='width:924px; height:480px; overflow-x:auto; overflow-y:auto; border:1px solid #e1e1e1; border-top:none; background:#ffffff; padding:20px;'>
$tag_comment
$out_put
</div>
END;

	$file=@fopen("$inTemplate","w") or Error("$inTemplate 파일을 열 수 없습니다..\\n \\n디렉토리의 퍼미션을 707로 주십시오");
	@fwrite($file,"$tag_write\n") or Error("$inTemplate 수정 실패 \\n \\n파일의 퍼미션을 707로 주십시오");
	@fclose($file);

return $div_form;
}
?>