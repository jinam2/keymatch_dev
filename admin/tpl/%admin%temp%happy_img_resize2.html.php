<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 09:58:57 */
function SkyTpl_Func_2985326507 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script type="text/javascript" src="../js/ajax.js"></script>

<p class="main_title"><?=$_data['now_location_subtitle']?></p>

<div class='help_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<span class='help'>도움말</span>
	<p>
	<b>ㆍ</b>업로드된 이미지들 중 파일용량이 큰 이미지를 체크하고, 이미지 파일의 가로/세로 사이즈를 조절하기 위한 설정입니다.<br>
	<b>ㆍ</b>현재 이미지가 1000px 이고, 리사이즈를 1100px 으로 하시는 경우 이미지 사이즈는 변경되지 않습니다.<br>
	<b>ㆍ</b>업로드된 이미지 중 큰 이미지를 줄이기 위한 용도로 제작되었습니다.<br>
	<b>ㆍ</b>이미지의 가로사이즈를 <?=$_data['min_width']?>px 이하로는 리사이즈 하실수 없습니다.<br>
	<b>ㆍ</b>파일이 과도하게 많으면 느릴수 있습니다.<br>
	<b>ㆍ</b>수많은 이용자들이 업로드 해둔 이미지파일 자료가 손실될 수 있습니다.<br>
	<b>ㆍ</b><font color="red">주의) 이미지의 사이즈를 조절 하기전에 현재 상태를 백업해놓으시기를 권장합니다</font><br>
	</p>
</div>

<form name="regiform" action="happy_img_resize.php?step=2" method="post" style="margin:0px;">
<div id="list_style" style="margin-bottom:40px;">
	<table cellspacing="0" cellpadding="0" class="bg_style b_border">
	<tr>
		<th style='width:70px;'><input type="checkbox" name="allbox" onclick="CheckALL()" ></th>
		<th>이미지 파일경로</th>
		<th style='width:80px;'>사이즈</th>
		<th style='width:130px;'>파일수정일</th>
		<th style='width:100px;'>관리툴</th>
	</tr>
	<?=$_data['file_list']?>

	</table>
</div>

<p class="main_title">이미지 리사이징 설정</p>

<div class='help_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<span class='help'>도움말</span>
	<p>
	파일사이즈(용량)를 설정하시고 <span style="color:#ff4e4e;">체크하기 버튼</span>을 클릭하시면 이미지가 검색되어 리스트로 출력이됩니다.<br>
	출력된 이미지 리스트중 수정할 이미지를 선택하신후 가로사이즈를 설정하신후<span style="color:#ff4e4e;">이미지리사이즈하기</span> 버튼을 클릭하면 사이즈가 리사이징 됩니다.<br>
	</p>
</div>


<div id="box_style">
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<table cellspacing="1" cellpadding="0" class="bg_style box_height">
	<tr>
		<th>파일사이즈</th>
		<td><input type="text" name="check_size" id="check_size" value="<?=$_data['check_size']?>" style="margin:0px; width:100px;"><span style="color:#797979;"> Kb 이상인 파일을 검사합니다.</span>
		<div class="item_txt" style="margin-top:5px;"> <b style="color:#139bd3;">파일사이즈</b>를 설정하고 하단 <b style="color:#139bd3;">체크하기</b> 버튼을 클릭하시면 이미지가 검색이 됩니다.</div></td>
	</tr>
	<tr>
		<th>가로사이즈</th>
		<td><input type="text" name="width_size" id="width_size" value="800" style="margin:0px; width:100px;"><span style="color:#797979;"> px (세로사이즈는 원본이미지의 비율에 맞게 자동 조절됩니다.)</span>
		<div class="item_txt" style="margin-top:5px;"> <b style="color:#139bd3;">검색이 된 이미지 중에</b> 원하는 이미지를 <b style="color:#139bd3;">선택</b>하신후에 원하시는 <b style="color:#139bd3;">사이즈를 설정</b>하고 <b style="color:#139bd3;">이미지리사이즈하기</b> 버튼을 클릭하시면 해당 이미지의 크기가 수정됩니다.</div></td>
	</tr>
	</table>
</div>

<div align="center" style="padding:0 0 20px 0;"><input type='submit' value="이미지 체크하기" class='btn_big'> <input type='button' value='이미지 리사이즈'  onclick="confirm_resize_ajax()" class='btn_big_gray'></div>


</form>







<script>
function confirm_resize()
{
	checkcnt = 0;
	for (var i=0;i<document.regiform.elements.length;i++)
	{
		var e = document.regiform.elements[i];
		if ( e.type == 'checkbox' && e.name != 'allbox' && e.checked == true )
		{
			checkcnt++;
		}
	}
	if ( checkcnt == 0 )
	{
		alert("이미지를 선택하세요");
		return;
	}

	msg = "선택한 이미지의 가로/세로 사이즈를 변경하시겠습니까?";
	if ( confirm(msg) )
	{
		document.regiform.action = 'happy_img_resize.php?step=3';
		document.regiform.submit();
	}
}
function CheckALL()
{
	for (var i=0;i<document.regiform.elements.length;i++)
	{
		var e = document.regiform.elements[i];
		if (e.type == 'checkbox' && e.name != 'allbox')
			e.checked = document.regiform.allbox.checked;
	}
}
</script>













<script type="text/javascript">
<!--
	// AJAX 이미지 사이즈 변환 - x2chi
	var keyArray	= new Array(); // 체크 키 리스트
	var width_size	= 800; // 가로사이즈
	var keyNo		= 0; // 키넘버
	function confirm_resize_ajax ()
	{
		var j = 0;
		for (var i=0;i<document.regiform.elements.length;i++)
		{
			var e = document.regiform.elements[i];
			if (e.type == 'checkbox' && e.name != 'allbox' && e.checked == true)
			{
				keyArray[j++] = e.id;
			}
		}

		if( keyArray.length > 0 )
		{
			width_size = document.getElementById("width_size").value;

			imgConvertAjax();
		}
		else
		{
			alert("이미지를 선택하세요");
		}

	}

	// 아작스로 이미지 사이즈 변환 처리
	function imgConvertAjax()
	{
		// 로딩 이미지
		keyNo		= keyArray[0].split('_');
		keyNo		= keyNo[1];
		document.getElementById('msg_'+keyNo).innerHTML = "<br /><img src='../img/ajax_loading.gif'>";

		// AJAX 호출
		var filePath = document.getElementById(keyArray[0]).value;
		happyStartRequest( 'happy_img_resize_ajax.php?file=' + filePath + '&width_size=' + width_size, 'imgConvertReturn' );
	}

	// 아작스 처리 결과
	function imgConvertReturn( feed )
	{
		var feedList = feed.split('__cut__');
		/**********
		/* 결과리턴 : feedList
		/* [0]=> 결과내용 (OK 면 성공 / 실패면 실패사유)
		/* [1]=> 파일경로
		/* [2]=> 원본파일 용량
		/* [3]=> 원본파일 사이즈
		/* [4]=> 변경파일 용량
		/* [5]=> 변경파일 사이즈
		**********/

		// 완료 메세지
		var resultMsg	= "";
		if ( feedList[0] == "OK" )
		{
			resultMsg	= "<font color='blue'>성공 : " + feedList[3] + " (" + feedList[2] + ") -> " + feedList[5] + " (" + feedList[4] + ")</font>";

			// 성공한 이미지는 체크해제
			document.getElementById(keyArray[0]).checked = false;
		}
		else
		{
			resultMsg	= "<font color='red'>실패 (" + feedList[0] + ")</font>";
		}
		document.getElementById('msg_'+keyNo).innerHTML = "<br />" + resultMsg;

		keyArray.shift(); // 처리된 키 제거

		if( keyArray.length > 0 )
		{
			imgConvertAjax();
		}
		else
		{
			setTimeout(
				function () {
					alert("작업완료");
					//document.regiform.submit();
				}
				, 300
			);
		}

	}

//-->
</script>
<? }
?>