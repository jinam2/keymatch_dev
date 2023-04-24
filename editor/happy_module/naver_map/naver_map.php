<?PHP
header("Content-type: text/html; charset=utf-8");
require_once('../secure_config.php') ;												//보안설정
require_once('../config.php') ;																	//에디터 모듈 통합설정

SWITCH( $naver_map_default_mapMode )
{
	CASE "0":
				$MAP_MODE_CHECKED_0		= "checked";
				break;
	CASE "1":
				$MAP_MODE_CHECKED_1		= "checked";
				break;
	CASE "2":
				$MAP_MODE_CHECKED_2		= "checked";
				break;
	default:
				$MAP_MODE_CHECKED_0		= "checked";
				break;
}
$MAP_MODE_CHECKED		= ($naver_map_default_mapMode == 0);

//마커이미지 만들기
$happymap_mark_list			= "<table border=0 cellspacing=0 cellpadding=0><tr>";
foreach( $naver_map_mark_img_array as $key => $value )
{
	$happymap_mark_list			.= "<td width=30 align=center><img src='${relative_path}${value}' border='0' onClick='addMark(this.src);'></a></td>";
}
$happymap_mark_list			.= "</tr></table>";

/*		검색값을 랜덤하게 하나 정해주자.		*/
$naver_search				= $naver_map_default_search_arr[rand(0,sizeof($naver_map_default_search_arr)-1)];

//에디터이름
$editor_name_map = $_GET['editor_name'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<!-- 해피CGI 솔루션외 사용을 금합니다. -->
<html>
<head>
<title>Naver Map</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta content="noindex, nofollow" name="robots">

<script>
	var editor_name = '<?=$editor_name_map?>';
	var naver_key = '<?=$naver_key?>';
	var naver_secret_key = '<?=$naver_secret_key?>';
</script>
<script type="text/javascript" src="dialogue.js"></script>
<!-- 엔터키 눌렀을때 서브밋 되는 현상 -->
<script type="text/javascript" src="../../../js/jquery.js"></script>
<script>
$(function() {
	$("input:text").keydown(function(evt) {
		if (evt.keyCode == 13)
		{
			//alert(evt.target.id);
			if ( evt.target.id == "naver_search2" )
			{
				if ( evt.target.value != "" )
				{
					naver_data_loading2();
				}
				return false;
			}
			else if ( evt.target.id == "naver_search" )
			{
				if ( evt.target.value != "" )
				{
					naver_data_loading();
				}
				return false;
			}
			else
			{
				return false;
			}
		}
	});
});
</script>
<!-- 엔터키 눌렀을때 서브밋 되는 현상 -->
<link rel="stylesheet" type="text/css" href="css/style_naver_map.css">
<link rel="stylesheet" type="text/css" href="../../css/common.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">
<style type="text/css">
/* NHN Web Standard 1Team JJS 120106 */
/* Common */
body,p,h1,h2,h3,h4,h5,h6,ul,ol,li,dl,dt,dd,table,th,td,form,fieldset,legend,input,textarea,button,select{margin:0;padding:0}
body,input,textarea,select,button,table{font-family:'맑은 고딕',Dotum,Helvetica,sans-serif;font-size:12px}
img,fieldset{border:0}
ul,ol{list-style:none}
em,address{font-style:normal}
a{text-decoration:none}
a:hover,a:active,a:focus{text-decoration:underline}

/* Contents */
.blind{visibility:hidden;position:absolute;line-height:0}
#pop_wrap{width:445px; border:1px solid #dbdbdb; height:460px;}
#pop_header{padding:10px; background:#f4f4f4}
.pop_container{padding:11px 20px 0}
#pop_footer{margin:3px 2px 0;padding:3px 0 1px; text-align:center}
h1{color:#333;font-size:14px;letter-spacing:-1px}
.btn_area{word-spacing:2px}
.pop_container .drag_area{overflow:hidden;overflow-y:auto;position:relative;width:341px;height:129px;margin-top:4px;border:1px solid #eceff2}
.pop_container .drag_area .bg{display:block;position:absolute;top:0;left:0;width:341px;height:129px;background:#fdfdfd url(http://cgimall.co.kr/happy_board/wys3/img/photoQuickPopup/bg_drag_image.png) 0 0 no-repeat}
.pop_container .nobg{background:none}
.pop_container .bar{color:#e0e0e0}
.pop_container .lst_type li{overflow:hidden;position:relative;padding:7px 0 6px 8px;border-bottom:1px solid #f4f4f4;vertical-align:top}
.pop_container :root .lst_type li{padding:6px 0 5px 8px}
.pop_container .lst_type li span{float:left;color:#222}
.pop_container .lst_type li em{float:right;margin-top:1px;padding-right:22px;color:#a1a1a1;font-size:11px}
.pop_container .lst_type li a{position:absolute;top:6px;right:5px}
.pop_container .dsc{margin-top:6px;color:#666;line-height:18px}
.pop_container .dsc_v1{margin-top:12px}
.pop_container .dsc em{color:#13b72a}
.pop_container2{padding:10px 0 0 10px}
.pop_container2 .dsc{margin-top:6px;color:#666;line-height:18px}
.pop_container2 .dsc strong{color:#13b72a}
.upload{margin:0 4px 0 0; _margin:0; padding:6px 0 4px 6px; border:1px solid #d7d7d7; height:24px; color:#a1a1a1; font-size:12px; length:300px; width:360px;}
:root  .upload{padding:6px 0 2px 6px;}

.tap_st_over {border:1px solid #c9c9c9; border-bottom:1px solid #f9f9f9;  background:#f9f9f9; color:#3b3b3b; font:bold 12px '맑은 고딕'; cursor:pointer; width:120px; height:29px;}
.tap_st_out {border:1px solid #c9c9c9;background:#efefef; color:#898989; font:12px '맑은 고딕'; cursor:pointer; width:120px; height:29px;}


/* 스킨관계없이 기본 */
.input_style input[type=text] { border:1px solid #bdbdc0; background:#f3f3f3; padding-left:5px; height:28px; line-height:27px; margin:2px 0; }
.input_style input[type=password] { border:1px solid #bdbdc0; background:#f3f3f3; padding-left:5px; height:28px; line-height:27px; margin:2px 0; }
.input_style input[type=file] { border:1px solid #bdbdc0; background:#f3f3f3; padding-left:5px; height:30px; line-height:29px; margin:2px 0; }
.input_style select { padding:5px; border:1px solid #bdbdc0; height:30px; line-height:24px; }
.input_style textarea { border:1px solid #bdbdc0; background:#f3f3f3; padding:5px; height:200px; }
.input_style input[type=checkbox]
.input_style input[type=radio] { vertical-align:middle; margin:-2px 0 1px;  cursor:pointer; }
.font_50 { font-size:50px; }
/* 스킨관계없이 기본 */

</style>
</head>



	<body>

		<form name='navermap_search_form' target='mapSearchFrame' style='display:none' action='naversearch.php' onSubmit="return false">
			<input type='hidden' name='naver_key' value=''>
			<input type='hidden' name='naver_secret_key' value=''>
			<input type='hidden' name='keyword' value=''>
		</form>

		<form name='navermap_search_form2' target='mapSearchFrame' style='display:none' action='naversearch2.php' onSubmit="return false">
			<input type='hidden' name='naver_key' value=''>
			<input type='hidden' name='naver_secret_key' value=''>
			<input type='hidden' name='keyword' value=''>
		</form>
		<form name='navermap_form' onSubmit="return false">

		<div style="overflow-y:scroll; height:710px;">
		<table cellspacing="0" cellpadding="0" style="height:60px; background:#555555; width:100%;">
		<tr>
			<td style="color:#fff; padding-left:20px; font-size:14px;"><strong>네이버 지도삽입</strong></td>
			<td></td>
		</tr>
		</table>

		<table cellspacing="0" cellpadding="0" style="width:100%; background:#fbfbfb; border-bottom:1px solid #eaeaea;">
		<tr>
			<td style="color:#999; padding:20px; line-height:17px;">
				- 마크아이콘 선택후 메세지를 입력하면 지도위에 마크표시가 가능하며, 삭제는 마크클릭후 가능합니다.<br>
				- 네이버API 지도는 가로,세로사이즈를 가변성있는 100%소스를 지원하지 않습니다.
			</td>
		</tr>
		</table>

		<div align="center" style="margin-top:20px;">
		<table cellspacing='0' cellpadding='0' style='width:100%;' class='table_com input_style'>
		<tr>
			<th style="border-right:1px solid #eaeaea; width:100px; padding-left:10px; ">주소로검색</th>
			<td>
					<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="padding:0;"><input type='text' name='naver_search2' id='naver_search2' value='' size=30></td>
						<td  style="padding:0;"><input type='image' src='images/btn_search.gif' onClick="naver_data_loading2()"></td>
					</tr>
					</table>
			</td>
			<th style="width:100px; border-right:1px solid #eaeaea; border-left:1px solid #eaeaea; padding-left:10px; ">가로사이즈</th>
			<td><input type='text' name='naver_width' id='naver_width' value='' size=4 style="color:#3A9812; font-family:tahoma; font-size:12px; font-weight:bold; " onKeyUp="navermap_resize()" onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;'> px</td>
		</tr>
		<tr>
			<th style="border-right:1px solid #eaeaea; padding-left:10px; ">상호로검색</th>
			<td>
				<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding:0;"><input type='text' name='naver_search' id='naver_search' value='' size=30></td>
					<td style="padding:0;"><input type='image' src='images/btn_search01.gif' onClick="naver_data_loading()"></td>
				</tr>
				</table>
			</td>
			<th style="width:100px; border-right:1px solid #eaeaea; border-left:1px solid #eaeaea; padding-left:10px; ">세로사이즈</th>
			<td style="width:150px;"><input type='text' name='naver_height' id='naver_height' value='' size=4 style="color:#3A9812; font-family:tahoma; font-size:12px; font-weight:bold; " onKeyUp="navermap_resize()" onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;'> px</td>
		</tr>
		<tr>
			<th style="border-right:1px solid #eaeaea; padding-left:10px; ">마크메세지</th>
			<td><input type='text' name='markMessage' value='' size=30></td>
			<th style="width:90px; border-right:1px solid #eaeaea; border-left:1px solid #eaeaea; padding-left:10px; ">저장옵션</th>
			<td style="font-family:돋움;"><input type="checkbox" name="save_Zoom" value="1" style='width:14px; height:14px; vertical-align:middle;' id="save_Zoom_id" checked> <label for="save_Zoom_id" style="cursor:hand">줌버튼</label>
				<div style="margin-top:5px;"><input type="checkbox" name="save_Wheel" value="1" style='width:14px; height:14px; vertical-align:middle;' id="save_Wheel_id" checked> <label for="save_Wheel_id" style="cursor:hand">휠기능</label></div></td>
		</tr>
		<tr>
			<th style="border-right:1px solid #eaeaea; padding-left:10px; ">마크아이콘</th>
			<td colspan="3">
				<table border="0" cellspacing="1" cellpadding="0">
				<tr>
					<td><script type="text/javascript">naver_map_mark_loading();</script></td>
					<td style='padding-right:5px;'><a href='#markReset' onClick="removeMarkAll()"><img src="images/btn_reset.gif" border="0" alt="재설정"></a></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<th style="border-right:1px solid #eaeaea; padding-left:10px; ">줌 설정</th>
			<td colspan="3">
				<table border="0" cellspacing="0" cellpadding="0" style="border:1px solid #bdbdc0;">
				<tr>
					<td style="font-size:11px; font-family:돋움; background:#fafafa; border-right:1px solid #bdbdc0; height:30px; line-height:30px;"><a href='#onClickZoom' onClick='mapObj.setLevel(parseInt(mapObj.getLevel())-1);navermap_zoom_now();' style="color:#666666; text-decoration:none;">- 축소</a></td>
					<td><div id='zoomLayer1' title="1"></div></td>
					<td><div id='zoomLayer2' title="2"></div></td>
					<td><div id='zoomLayer3' title="3"></div></td>
					<td><div id='zoomLayer4' title="4"></div></td>
					<td><div id='zoomLayer5' title="5"></div></td>
					<td><div id='zoomLayer6' title="6"></div></td>
					<td><div id='zoomLayer7' title="7"></div></td>
					<td><div id='zoomLayer8' title="8"></div></td>
					<td><div id='zoomLayer9' title="9"></div></td>
					<td><div id='zoomLayer10' title="10"></div></td>
					<td><div id='zoomLayer11' title="11"></div></td>
					<td><div id='zoomLayer12' title="12"></div></td>
					<td><div id='zoomLayer13' title="13"></div></td>
					<td><div id='zoomLayer14' title="14"></div></td>
					<td style="font-size:11px; font-family:돋움; background:#fafafa; border-left:1px solid #bdbdc0;  line-height:30px;"><a href='#onClickZoom' onClick='mapObj.setLevel(parseInt(mapObj.getLevel())+1);navermap_zoom_now();'style="color:#666666; text-decoration:none;">+ 확대</a></td>
				</tr>
				</table>

				</form>
			</td>
		</tr>
		<tr>

			<td align="center" valign="middle" style="padding-bottom:10px;" colspan="4">

				<table height="100%" border="1" cellspacing="3" cellpadding="0" bgcolor="#3A9812">
				<tr bgcolor="white">
					<td align='top'>
						<div align='top' id='mapSearch' width='180' height='410'><iframe id='mapSearchFrame' name='mapSearchFrame' src="naversearch.php" width='180' height='410' frameborder='0'></iframe></div>
					</td>
					<td>
						<script type="text/javascript">naver_map_loading();</script>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		</div>

		<table cellspacing="0" cellpadding="0" style="width:100%; margin-top:10px; margin-bottom:10px;">
		<tr>
			<td align="center" style="border-top:1px solid #eaeaea; padding-top:10px;">
				<table cellspacing="0" cellpadding="0">
				<tr>
					<td><img src="../../img/btn_save.gif" onClick="Ok();" title="지도 추가" alt="지도 추가" style='cursor:pointer;'></td>
					<td style="padding-left:5px;"><img src="http://cgimall.co.kr/happy_board/wys3/img/photoQuickPopup/btn_cancel.png" width="48" height="28" alt="취소" id="btn_cancel" onClick="parent.editor_layer_close()"  style="cursor:pointer;"></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>

		</div>

	</body>
</html>