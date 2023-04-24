<? /* Created by SkyTemplate v1.1.0 on 2023/04/10 15:52:24 */
function SkyTpl_Func_1749660983 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<TITLE> <?=$_data['sitename']?></TITLE>

<!-- 스타일시트 파일 링크처리 -->
<link rel="stylesheet" type="text/css" href="css/style_common.css">
<link rel="stylesheet" type="text/css" href="css/body_style.css">

<!-- 자바스크립트 파일 링크처리 -->
<script language="JavaScript" src="../js/happy_main.js" type="text/javascript"></script>
<script language="JavaScript" src="../js/flash.js" type="text/javascript"></script>
<script language="JavaScript" src="../js/coupon.js" type="text/javascript"></script>
<script language="javascript" src="../js/mEmbed.js"></script>
<script language="javascript" src="../js/default.js"></script>

<SCRIPT type="text/javascript">
<!--
function select_info(number)
{
	var input		= opener.document.getElementById("select_info_number");

	if ( input != undefined )
	{
		input.value		= number;
		self.close();
	}
	else
	{
		alert("창을 다시 열어주세요.");
		opener.location.reload();
		self.close();
	}
}
//-->
</SCRIPT>

<style type="text/css">
	.select_st_inquiry select{ border:1px solid #E7E7E7; height:30px; padding:5px;}
	.contents a { text-decoration: none; color:#797979;}
</style>

</head>

<body>

<table width="100%" cellpadding="0" cellspacing="0" class="contents">
<tr>
	<td style="padding:10px;">
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td height="35px" style="background:#f8f8f8; border-top:1px solid #e4e4e4;">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<!-- 타이틀 -->
					<td width="17px" ><div class="sub_contents_category_title"><img src="../img/layer_tit_icon.gif" border="0" alt="문의 상담 업체지정" title="문의 상담 업체지정"></div></td>
					<td style="font:bold 13px 돋움;color:#5d5d5d; padding:3px 0 0 5px">상담문의 채용정보지정</td>
					<td style="padding:3px 5px 0 0; font-size:11px;" align="right"><font color='#555555'>* 고유번호나 <b>채용명, 사진, 고유번호</b>을 클릭하시면 자동입력됩니다</font></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<!-- 문의내역 검색부분 -->
				<form name="search_form" action="happy_inquiry_select_info.php" method="get">
				<input type="hidden" name="number" value="<?=$_data['_GET']['number']?>">
				<table border="0" cellpadding="0" cellspacing="0" style="width:100%; border-top:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4;  height:50px; ">
				<tr>
					<td align="center">
						<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td class="select_st_inquiry"><?=$_data['검색필드선택']?></td>
							<td style="padding-left:3px;"><input type="text" name="search_keyword" value="<?=$_data['_GET']['search_keyword']?>" style="height:26px; line-height:26px; padding-left:3px; width:130px; border:1px solid #dddddd;'"></td>
							<td style="padding-left:3px;"><input type="image" src="../img/btn_ad_search.gif" alt="검색하기" title="검색하기" border="0" align="absmiddle"></td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
				</form>
			</td>
		</tr>
		<tr>
			<td><?=$_data['업체정보선택출력']?></td>
		</tr>
		<tr>
			<!-- 페이징 -->
			<td align="center" style="padding:20px 0px; color:#797979;"><?=$_data['페이징출력']?></td>
		</tr>
		</table>
	</td>
</tr>
</table>

</body>

</html>

<? }
?>