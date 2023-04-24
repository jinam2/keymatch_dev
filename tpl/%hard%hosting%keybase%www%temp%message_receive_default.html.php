<? /* Created by SkyTemplate v1.1.0 on 2023/03/09 13:42:44 */
function SkyTpl_Func_14175804 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<TITLE>쪽지보기</TITLE>
<meta name="description" content="<?=$_data['site_name']?>">
<meta name="Generator" content="EditPlus">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">
</HEAD>

<script language="javascript" src="js/message.js"></script>

<!-- 파비콘 지정-->
<link rel="shortcut icon" href="favicon.ico" />
<!-- 스타일시트 파일 링크처리 -->
<link rel="stylesheet" type="text/css" href="css/common.css">
<link rel="stylesheet" type="text/css" href="css/style.css">

<!-- 통계트래킹 -->
<?=$_data['google_login_track']?>


<BODY style="background:#616471; ">

<script>
	function mesdel(strURL) {
		var msg = "삭제하시겠습니까?";
		if (confirm(msg)){
			window.location.href= strURL;

		}
	}
</script>
<div style="background:#616471; padding:15px;">
<form name="msglist" action="happy_message.php" method="post">
<input type="hidden" name="del_mode">
<input type="hidden" name="check_msg_list">
<input type="hidden" name="mode" value="receivelist">
<input type="hidden" name="adminMode" value="<?=$_data['_GET']['adminMode']?>">

<div style="margin-bottom:10px;">
	<table cellpadding="0" cellspacing="0" style="width:100%;">
	<tr>
		<td><a href='?mode=receivelist&adminMode=<?=$_data['_GET']['adminMode']?>'><img src="img/message/btn_message_tab01_on.gif"></a><a href='?mode=receivelist2&adminMode=<?=$_data['_GET']['adminMode']?>'><img src="img/message/btn_message_tab02_off.gif"></a><a href='?mode=senderlist&adminMode=<?=$_data['_GET']['adminMode']?>'><img src="img/message/btn_message_tab03_off.gif"></a><a href='?mode=send&adminMode=<?=$_data['_GET']['adminMode']?>'><img src="img/message/btn_message_tab04_off.gif"></a></td>
		<td align="right"><img src="img/message/btn_message_close.gif" onClick='self.close();' style="cursor:pointer;"></td>
	</tr>
	</table>
</div>
<div style="margin-bottom:10px; border:1px solid #424656; background:#565965; padding:10px;">
	<table cellpadding="0" cellspacing="0" style="width:100%;">
	<tr>
		<td><b style="color:#ffffff;" class="smfont2"><?=$_data['사용자이름']?></b><font style="color:#c7c9d3;" class="smfont">님 환영합니다.</font></td>
		<td align="right"><span class="smfont2" style="color:#FFFFFF; padding-right:20px;">미확인 <b><?=$_data['읽지않은쪽지수']?></b>건</span><span class="smfont2" style="color:#d5d7e1; padding-right:20px;">보낸쪽지 <?=$_data['보낸쪽지수']?>건</span><span class="smfont2" style="color:#d5d7e1;">받은쪽지 <?=$_data['받은쪽지수']?>건</span></td>
	</tr>
	</table>
</div>
<!--내용-->
<div>
	<table cellpadding="0" cellspacing="0" style="width:100%; height:380px;">
	<tr>
		<td style="width:5px; height:5px; background:url(img/message/img_table_message_r_A01.gif) no-repeat;"></td>
		<td style="background:url(img/message/img_table_message_r_A02.gif) repeat-x"></td>
		<td style="width:5px; height:5px; background:url(img/message/img_table_message_r_A03.gif) no-repeat;"></td>
	</tr>
	<tr>
		<td style="background:url(img/message/img_table_message_r_A08.gif) repeat-y"></td>
		<td style="background:#FFFFFF; padding:10px;" valign="top">

			<div style="margin-bottom:10px; padding-left:5px;"><?=$_data['쪽지리스트버튼']?></div>
			<div>
				<table cellpadding="0" cellspacing="0" style="width:100%; background:url(img/message/img_table_message_b_A02.gif) repeat-x;">
				<tr>
					<td style="width:5px; height:33px; background:url(img/message/img_table_message_b_A01.gif);"></td>
					<td class="smfont" style="text-align:center;">내용</td>
					<td class="smfont" style="width:120px; text-align:center;">보낸사람</td>
					<td class="smfont" style="width:120px; text-align:center;">받은시간</td>
					<td class="smfont" style="width:50px; text-align:center;">삭제</td>
					<td style="width:5px; height:33px; background:url(img/message/img_table_message_b_A03.gif);"></td>
				</tr>
				</table>
			</div>
			<div style="margin-bottom:20px;"><?=$_data['내용']?></div>
			<div style="width:100%;">
				<table cellspacing="0" style="width:100%;">
				<tr>
					<td align="center"><?=$_data['페이징']?></td>
				</tr>
				</table>
			</div>
		</td>
		<td style="background:url(img/message/img_table_message_r_A04.gif) repeat-y"></td>
	</tr>
	<tr>
		<td style="width:5px; height:5px; background:url(img/message/img_table_message_r_A07.gif) no-repeat;"></td>
		<td style="background:url(img/message/img_table_message_r_A06.gif) repeat-x"></td>
		<td style="width:5px; height:5px; background:url(img/message/img_table_message_r_A05.gif) no-repeat;"></td>
	</tr>
	</table>
</div>
</div>
</form>
<!--내용 끝-->

</BODY>
</HTML>

<? }
?>