<?php
include ("../inc/config.php");
include ("../inc/Template.php");
$TPL = new Template;

include ("../inc/function.php");
include ("../inc/lib.php");

//$_GET
//$_POST
//$_COOKIE

if ( !admin_secure("직종설정") ) {
		error("접속권한이 없습니다.");
		exit;
}


#############		2010-09-29 기능추가로 DB에 1개의 필드 추가		############################################
#	job_type 테이블에 use_adult 필드가 추가 되었습니다.
#	alter table job_type add use_adult int(1) not null;
#	사용용도는 카테고리의 성인인증 사용여부 입니다.
#	체크 버튼 체크할 경우 값은 1 이며 카테고리 접근시.. 성인인증 체크 여부에 따라서 보여지고 안보여지게 됩니다.
################################################################################################################


//2차 직종 순서저장 - 2022-06-08 hong
if ( $_GET['action'] == "type_sort_reg" )
{
	if ( $_GET['sub_numbers'] == '' )
	{
		echo "순서 저장 오류";
		exit;
	}

	$sub_numbers	= explode(",",$_GET['sub_numbers']);

	foreach ( $sub_numbers as $key => $val )
	{
		$number			= preg_replace("/\D/", "", $val);
		$sort_number	= $key + 1;

		$Sql			= "UPDATE $type_sub_tb SET sort_number = '$sort_number' WHERE number = '$number' ";
		query($Sql);
	}

	echo "ok";
	exit;
}
if ( $_GET['action'] == "type_sub_sort_reg" )
{
	if ( $_GET['sub_numbers'] == '' )
	{
		echo "순서 저장 오류";
		exit;
	}

	$sub_numbers	= explode(",",$_GET['sub_numbers']);

	foreach ( $sub_numbers as $key => $val )
	{
		$number			= preg_replace("/\D/", "", $val);
		$sort_number	= $key + 1;

		$Sql			= "UPDATE $type_sub_sub_tb SET sort_number = '$sort_number' WHERE number = '$number' ";
		query($Sql);
	}

	echo "ok";
	exit;
}


################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################

js_make_type();
if ($action == "") {
	main();
}
elseif ($action == "company_mod") {
	company_mod($number_company);
}
elseif ($action == "company_add") {
	company_add();
}
elseif ($action == "company_add_reg") {
	company_add_reg();
}
elseif ($action == "company_mod_reg") {
	company_mod_reg($number_company,$title_company,$category);
}

elseif ($action == "company_del_reg") {
	company_del_reg();
}
else if($action == "update_adult")
{
	company_all_adult();
	main();
}
else if($action == "update_adult_no")
{
	company_all_adult_No();
	main();
}


elseif ($action == "type_add_reg") {
	type_add_reg();
}
elseif ($action == "type_mod_reg") {
	type_mod_reg();
}
elseif ($action == "type_del_reg") {
	type_del_reg();
}
elseif ($action == "type_sub_add_reg") {
	// 카테고리 추가
	type_sub_add_reg();
}
elseif ($action == "type_sub_mod_reg") {
	// 카테고리 추가
	type_sub_mod_reg();
}
elseif ($action == "type_sub_del_reg") {
	// 카테고리 추가
	type_sub_del_reg();
}



else {
	main();
}


###############################################################################

function main() {
global $type_sub_tb,$type_tb, $now_location_subtitle;
global $HAPPY_CONFIG;


#car_company 테이블을 읽어오면서 car_type을 정리를 해주자.
$sql = "select * from $type_tb order by sort_number asc";
$result = query($sql);
while(list($number_si,$si_si,$sort_number_si,$use_adult) = mysql_fetch_row($result)) {

	#받은 값으로 다시 쿼리를 주고
	$sql2 = "select * from $type_sub_tb where type = '$number_si' order by sort_number asc, number asc";
//echo $sql2 . '<br />';
	$result2 = query($sql2);
	$select_option = "";
	$i = "";

	$adult_check = "";
	if($use_adult == "1")
		$adult_check = "<img src='img/adult.gif' border='0' alt='19세'style='vertical-align:middle;'>성인전용";
	else
		$adult_check = "성인인증 사용안함";

	$inquiry_form = "";
	if ( $HAPPY_CONFIG['inquiry_form_each_conf'] == "y" )
	{
		$inquiry_form = '<br><a href="happy_inquiry_form.php?gubun='.$number_si.'"><img src="img/btn_reg_inquiry_form.gif" border="0" alt="문의하기 폼관리" style="margin-top:10px;"></a>';
	}

print <<<END
<script>
function select$number_si() {
		var car_type_number_val	= 0;
        for( i=0 ; i < document.theForm_$number_si.car_type_number.length ; i++){
                if(theForm_$number_si.car_type_number.options[i].selected){
                var ani = theForm_$number_si.car_type_number.options[i].value;
        var ani1 = theForm_$number_si.car_type_number.options[i].text;
                }else{
                }
        }
        theForm_$number_si.ania.value = ani1;
		$("#car_type_number_val_$number_si").val(ani);

		var form_data = {
			type : "get_3sub",
			product_number : "{{DETAIL.number}}",
			num : ani
		};

		$.ajax({
			url: "type_setting_ajax.php",
			type: "GET",
			data: form_data,
			success: function(response) {
				//console.log(response);
				//console.log(num);
				if( response != '' )
				{
					var return_str    = response.split('____CUT____');
					if( return_str[0] == 'error' )
					{
						alert(return_str[1]);
						return false;
					}
					else
					{
						$("#car_type_number_sub_$number_si").html(return_str[1]);
					}
				}
			},
			complete: function() {
			},
			error: function(){}
		});
}

function CheckForm$number_si()
{
	if (theForm_$number_si.ania.value.length < 2	)
	{
		 alert("카테고리명을 입력하세요.");
		 theForm_$number_si.ania.focus();
		 return (false);
	}
	document.theForm_$number_si.submit();
}

// 3차
function select_sub$number_si() {
	for( i=0 ; i < document.theForm_sub_$number_si.car_type_number_sub.length ; i++)
	{
		if(theForm_sub_$number_si.car_type_number_sub.options[i].selected)
		{
			var ani = theForm_sub_$number_si.car_type_number_sub.options[i].value;
			var ani1 = theForm_sub_$number_si.car_type_number_sub.options[i].text;
		}
		else
		{
		}
	}
	theForm_sub_$number_si.ania_sub.value = ani1;
}

function CheckForm_sub$number_si()
{
	var sub_val = $('#car_type_number{$number_si}').val();
	console.log(sub_val);
	if (theForm_sub_$number_si.ania_sub.value.length < 2	)
	{
		alert("카테고리명을 입력하세요.");
		theForm_sub_$number_si.ania_sub.focus();
		return (false);
	}
	document.theForm_sub_$number_si.submit();
}
</script>

END;

	while(list($number_gu,$si_gu,$gu_gu) = mysql_fetch_row($result2)) {
		$select_option .= "<option value='$number_gu'>$gu_gu</option>";
		$i ++;

	}


	$meme_temp .= "
		<tr>
			<td style='text-align:center;'>$sort_number_si 번째</td>
			<td style='text-align:center;'>
			<strong>$si_si</strong>
			<p style='margin:15px 0 13px 0;'><a href=type_setting.php?action=company_mod&number_company=$number_si class='btn_small_red'>수정</a> <a href=\"javascript:bbsdel('type_setting.php?action=company_del_reg&number_company=$number_si');\" class='btn_small_dark'>삭제</a></p>
			$adult_check
			$inquiry_form
			</td>
			<td>
				<p class='short'>텍스트박스에 카테고리명을 입력하면 등록되며, 등록된 이름을 선택후 수정이나 삭제를 할 수 있습니다.</p>
				<form name=theForm_$number_si method=post style='margin:0;'>
				<input type=hidden name=number_si value='$number_si'>
				<div style='border:1px solid #ddd; border-right:none;'>
					<table cellpadding='0' cellspacing='0' border='0' style='width:100%;border-collapse:collapse;'>
						<colgroup>
							<col width='*'>
							<col width='160px'>
						</colgroup>
						<tbody>
							<tr>
								<td style='padding:15px 25px; border:none;'>
									<select name='car_type_number' id='car_type_number{$number_si}' size=5 onchange=\"javascript:select$number_si();\" style='width:100%; height:100px; padding:5px;'>$select_option</select>
								</td>
								<td style='border:none; padding:0;'>
									<table cellpadding='0' cellspacing='0' border='0' style='width:100%; border-collapse:collapse;'>
									<tr>
										<td style='border:1px solid #ddd;  border-top:none; text-align:center'><a href='#1' onClick=\"selectsort(document.theForm_$number_si.car_type_number,'top')\" style='display:block;'><img src='../img/btn_move_top.jpg' alt='맨위로' title='맨위로' border='0'></a></td>
									</tr>
									<tr>
										<td style='border:1px solid #ddd; text-align:center'><a href='#1' onClick=\"selectsort(document.theForm_$number_si.car_type_number,'up')\" style='display:block;'><img src='../img/btn_move_up.jpg'alt='위로' title='위로' border='0'></a></td>
									</tr>
									<tr>
										<td style='border:1px solid #ddd; text-align:center'><a href='#1' onClick=\"selectsort(document.theForm_$number_si.car_type_number,'down')\" style='display:block;'><img src='../img/btn_move_down.jpg'  alt='아래로' title='아래로' border='0'></a></td>
									</tr>
									<tr>
										<td style='border:1px solid #ddd; border-bottom:none; text-align:center'><a href='#1' onClick=\"selectsort(document.theForm_$number_si.car_type_number,'bottom')\" style='display:block;'><img src='../img/btn_move_bottom.jpg' alt='맨아래로' title='맨아래로' border='0'></a></td>
									</tr>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div style='border:1px solid #ddd; margin:10px auto;padding:15px 25px; display:flex; *justify-content:center;'>
					<input type=text name='ania' style='width:420px; height:22px; vertical-align:middle' style='padding-left:0;'>
					<input type=button value='등록' onclick=\"action='./type_setting.php?action=type_add_reg';CheckForm$number_si();\" class='btn_small_stand' style='margin-left:5px'>
					<input type=button value='수정' onclick=\"action='./type_setting.php?action=type_mod_reg'; CheckForm$number_si();\" class='btn_small_gray' style='margin-left:5px'>
					<input type=button value='삭제' onclick=\"action='./type_setting.php?action=type_del_reg';CheckForm$number_si();\" class='btn_small_dark' style='margin-left:5px'>
				</div>
				</form>
			</td>
			<td>
				<p class='short'>텍스트박스에 카테고리명을 입력하면 등록되며, 등록된 이름을 선택후 수정이나 삭제를 할 수 있습니다.</p>
				<form name='theForm_sub_{$number_si}' method=post style='margin:0;'>
				<input type=hidden name=number_si value='$number_si'>
				<input type='hidden' name='car_type_number_val' id='car_type_number_val_{$number_si}' value=''>
				<div style='border:1px solid #ddd; border-right:none;'>
					<table cellpadding='0' cellspacing='0' border='0' style='width:100%;border-collapse:collapse;'>
						<colgroup>
							<col width='*'>
							<col width='160px'>
						</colgroup>
						<tbody>
							<tr>
								<td style='padding:15px 25px; border:none;'>
									<select name='car_type_number_sub' id='car_type_number_sub_{$number_si}' size='5' onchange=\"javascript:select_sub$number_si();\" style='width:100%; height:100px; padding:5px;'></select>
								</td>
								<td style='border:none; padding:0;'>
									<table cellpadding='0' cellspacing='0' border='0' style='width:100%; border-collapse:collapse;'>
									<tr>
										<td style='border:1px solid #ddd;  border-top:none; text-align:center'><a href='#1' onClick=\"selectsort_sub(document.theForm_sub_$number_si.car_type_number_sub,'top')\" style='display:block;'><img src='../img/btn_move_top.jpg' alt='맨위로' title='맨위로' border='0'></a></td>
									</tr>
									<tr>
										<td style='border:1px solid #ddd; text-align:center'><a href='#1' onClick=\"selectsort_sub(document.theForm_sub_$number_si.car_type_number_sub,'up')\" style='display:block;'><img src='../img/btn_move_up.jpg'alt='위로' title='위로' border='0'></a></td>
									</tr>
									<tr>
										<td style='border:1px solid #ddd; text-align:center'><a href='#1' onClick=\"selectsort_sub(document.theForm_sub_$number_si.car_type_number_sub,'down')\" style='display:block;'><img src='../img/btn_move_down.jpg'  alt='아래로' title='아래로' border='0'></a></td>
									</tr>
									<tr>
										<td style='border:1px solid #ddd; border-bottom:none; text-align:center'><a href='#1' onClick=\"selectsort_sub(document.theForm_sub_$number_si.car_type_number_sub,'bottom')\" style='display:block;'><img src='../img/btn_move_bottom.jpg' alt='맨아래로' title='맨아래로' border='0'></a></td>
									</tr>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div style='border:1px solid #ddd; margin:10px auto;padding:15px 25px; display:flex; *justify-content:center;'>
					<input type=text name='ania_sub' style='width:420px; height:22px; vertical-align:middle' style='padding-left:0;'>
					<input type=button value='등록' onclick=\"action='./type_setting.php?action=type_sub_add_reg';CheckForm_sub$number_si();\" class='btn_small_stand' style='margin-left:5px'>
					<input type=button value='수정' onclick=\"action='./type_setting.php?action=type_sub_mod_reg'; CheckForm_sub$number_si();\" class='btn_small_gray' style='margin-left:5px'>
					<input type=button value='삭제' onclick=\"action='./type_setting.php?action=type_sub_del_reg';CheckForm_sub$number_si();\" class='btn_small_dark' style='margin-left:5px'>
				</div>
				</form>
			</td>
		</tr>
";
}


print <<<END
<script language='JavaScript' src='../js/jquery-1.9.1.min.js' type='text/javascript'></script>

<script language="javascript">
<!--
	function bbsdel(strURL) {
		var msg = "\\n[주의] 삭제하시겠습니까?\\n\\n삭제하실 경우 해당 직종의 하부 정보도 같이 삭제가 됩니다";
		if (confirm(msg)){
			window.location.href= strURL;

		}
	}
	function bbsmod(strURL) {
		var msg = "수정하시겠습니까?";
		if (confirm(msg)){
			window.location.href= strURL;

		}
	}

	function check_update_adult()
	{
		an = confirm("모든 카테고리의 설정이 성인전용으로 변경됩니다. \\n\\n 계속하시겠습니까?");
		if(an == true)
			window.location.href= "?action=update_adult";
	}

	function check_update_adult_no()
	{
		an = confirm("모든 카테고리의 설정이 비성인전용으로 변경됩니다. \\n\\n 계속하시겠습니까?");
		if(an == true)
			window.location.href = "?action=update_adult_no";
	}

	function selectsort(sel,act)
	{
		idx = sel.selectedIndex;

		if ( idx < 0 )
		{
			alert('순서를 변경할 항목을 선택하세요');
			sel.focus();
			return;
		}

		optlen = sel.options.length;
		newidx = -1;

		switch(act)
		{
			case 'top':
				newidx = 0;
				break;
			case 'bottom':
				newidx = optlen-1;
				break;
			case 'up':
				newidx = idx-1;
				break;
			case 'down':
				newidx = idx+1;
				break;
		}

		if ( newidx > optlen-1 || idx == newidx || newidx == -1 )
		{
			return;
		}

		oldtext  = sel.options[idx].text;
		oldvalue = sel.options[idx].value;

		if ( act == "top" )
		{
			while(idx > 0)
			{
				sel.options[idx].text = sel.options[idx-1].text;
				sel.options[idx].value = sel.options[idx-1].value;
				idx--;
			}
		}
		else if ( act == "bottom")
		{
			while(idx < optlen-1)
			{
				sel.options[idx].text = sel.options[idx+1].text;
				sel.options[idx].value = sel.options[idx+1].value;
				idx++;
			}
		}
		else
		{
			sel.options[idx].text = sel.options[newidx].text;
			sel.options[idx].value = sel.options[newidx].value;
		}

		sel.options[newidx].text = oldtext;
		sel.options[newidx].value = oldvalue;
		sel.selectedIndex = newidx;

		var lists = "";
		for ( var i = 0 ; i < sel.length ; i++ )
		{
			lists += ( lists == "" ? "" : "," ) + sel.options[i].value;
		}

		$.ajax({
			url : 'type_setting.php',
			type : 'GET',
			data : {
				'action'		: 'type_sort_reg',
				'sub_numbers'	: lists
			},
			success : function(response){

				if ( response != 'ok' )
				{
					alert(response);
				}
			}
		});
	}


	function selectsort_sub(sel,act)
	{
		idx = sel.selectedIndex;

		if ( idx < 0 )
		{
			alert('순서를 변경할 항목을 선택하세요');
			sel.focus();
			return;
		}

		optlen = sel.options.length;
		newidx = -1;

		switch(act)
		{
			case 'top':
				newidx = 0;
				break;
			case 'bottom':
				newidx = optlen-1;
				break;
			case 'up':
				newidx = idx-1;
				break;
			case 'down':
				newidx = idx+1;
				break;
		}

		if ( newidx > optlen-1 || idx == newidx || newidx == -1 )
		{
			return;
		}

		oldtext  = sel.options[idx].text;
		oldvalue = sel.options[idx].value;

		if ( act == "top" )
		{
			while(idx > 0)
			{
				sel.options[idx].text = sel.options[idx-1].text;
				sel.options[idx].value = sel.options[idx-1].value;
				idx--;
			}
		}
		else if ( act == "bottom")
		{
			while(idx < optlen-1)
			{
				sel.options[idx].text = sel.options[idx+1].text;
				sel.options[idx].value = sel.options[idx+1].value;
				idx++;
			}
		}
		else
		{
			sel.options[idx].text = sel.options[newidx].text;
			sel.options[idx].value = sel.options[newidx].value;
		}

		sel.options[newidx].text = oldtext;
		sel.options[newidx].value = oldvalue;
		sel.selectedIndex = newidx;

		var lists = "";
		for ( var i = 0 ; i < sel.length ; i++ )
		{
			lists += ( lists == "" ? "" : "," ) + sel.options[i].value;
		}

		$.ajax({
			url : 'type_setting.php',
			type : 'GET',
			data : {
				'action'		: 'type_sub_sort_reg',
				'sub_numbers'	: lists
			},
			success : function(response){

				if ( response != 'ok' )
				{
					alert(response);
				}
			}
		});
	}
//-->
</script>


<p class="main_title">$now_location_subtitle
	<span class='small_btn' >
		<input type='button' value='모든 카테고리 성인전용으로' onClick="javascript:check_update_adult()" class="btn_small_stand">
		<input type='button' value='모든 카테고리 비성인전용으로' onClick="javascript:check_update_adult_no()" class="btn_small_gray">
		<input type='button' value='직종추가' onClick="location.href='type_setting.php?action=company_add&category=$category'" class="btn_small_yellow">
	</label>
</p>
<div class="help_style">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>
	<span class="help">도움말</span>
	<p><img src='img/ex15.gif'></p>
</div>
<div id="list_style">
	<div class="box_round_table">
		<div class="box_1"></div>
		<div class="box_2"></div>
		<div class="box_3"></div>
		<div class="box_4"></div>
		<table cellspacing="0" cellpadding="0" border="0" class="bg_style table_line">
		<colspan>
			<col style='width:15%;'></col>
			<col style='width:20%;'></col>
			<col></col>
		</colspan>
		<tr>
			<th>소팅순서</th>
			<th>직종</th>
			<th class="last">하부구분</th>
		</tr>
		$meme_temp
		</table>
	</div>
</div>

<div style="text-align:center; padding:10px 0 20px 0;"><a href=type_setting.php?action=company_add&category=$category class="btn_big_round">직종추가</a></div>

END;
}

function company_mod($number_si) {
	global $type_sub_tb,$type_tb;


	$sql = "select * from $type_tb  where number= '$number_si' ";
	$result = query($sql);
	list($number_si,$gu_si,$sort_number_si,$use_adult) = mysql_fetch_row($result);


	if($use_adult == "1")
		$use_adult_check = "checked";

	print <<<END

	<p class="main_title">직종 수정</p>

	<form action=type_setting.php?action=company_mod_reg method=post style='margin:0;'>
	<input type=hidden name=number_si value=$number_si>
	<input type=hidden name=old_si value='$gu_si'>
	<div id="box_style">
		<div class="box_1"></div>
		<div class="box_2"></div>
		<div class="box_3"></div>
		<div class="box_4"></div>
		<table cellspacing="1" cellpadding="0" border="0" class='bg_style box_height'>
		<colspan>
		<col style='width:15%;'></col>
		<col></col>
		</colspan>
		<tr>
			<th>직종 이름</th>
			<td>
				<p class="short">직종의 이름을 입력하세요 (예:서울)</p>
				<input type='text' name='gu_si' value="$gu_si">
			</td>
		</tr>
		<tr>
			<th>소팅번호</th>
			<td>
				<p class="short">해당직종의 소팅순서를 입력하세요 (출력순서를 정할 수 있습니다 숫자만 입력가능)</p>
				<input type='text' name='sort_number' value="$sort_number_si">
			</td>
		</tr>
		<tr>
			<th>성인인증 사용여부</th>
			<td>
				<p class="short">현재 카테고리와 관련된 구직정보, 구인정보 또한 모두 업데이트 됩니다.<br>(성인전용으로 사용시 해당직종의 하부설정들도 성인전용으로 사용됩니다.)</p>
				<input type='checkbox' name='use_adult' id='use_adult' value="1" $use_adult_check> <label for='use_adult' style='cursor:pointer;'>해당직종을 성인전용으로 사용하시려면 체크해주세요.</label>
			</td>
		</tr>
		</table>

	</div>
	<div align="center"><input type='submit' value='저장하기' class="btn_big_round"></div>
	</form>


END;
}

function company_mod_reg() {
	global $_POST,$type_sub_tb,$type_tb,$number_si,$gu_si,$old_si,$guin_tb,$per_document_tb;
	$sort_number = $_POST[sort_number];


	$sql = "update $type_tb set type = '$gu_si',sort_number = '$sort_number', use_adult = '$_POST[use_adult]'  where number= '$number_si' ";
	$result = query($sql);


	//구인정보 업데이트 성인인증 0 으로
	$sql = "update $guin_tb set use_adult = '0'";
	query($sql);

	//구직정보 업데이트 성인인증 0 으로
	$sql = "update $per_document_tb set use_adult = '0'";
	query($sql);

	//구직, 구인 테이블에는 카테고리 3개 까지 선택가능함! 그러므로 3개 중에 포함된것을 업데이트 하라!
	$sql = "select number from $type_tb where use_adult = '1'";
	$result = query($sql);
	$tmp_arr = array();

	while($Data55 = happy_mysql_fetch_array($result))
	{
		array_push($tmp_arr,$Data55['number']);
	}

	//위에서 모두 0으로 업데이트 했으므로.. 아래서는 해당 카테고리에 포함되는 것만 업데이트 시키자!
	if ( count($tmp_arr) >= 1 )
	{
		$adult_numbers = "( ".implode(",", (array) $tmp_arr)." ) ";
		$sql = "update $guin_tb set use_adult = '1' where ( type1 in $adult_numbers or type2 in $adult_numbers or type3 in $adult_numbers )";
		query($sql);

		$sql = "update $per_document_tb set use_adult = '1' where ( job_type1 in $adult_numbers or job_type2 in $adult_numbers or job_type3 in $adult_numbers ) ";
		query($sql);
	}

	go("type_setting.php");
}


function company_all_adult()
{
	global $_POST,$type_sub_tb,$type_tb,$number_si,$gu_si,$old_si,$guin_tb,$per_document_tb;

	$sql = "update $type_tb set use_adult = '1'";
	$result = query($sql);


	//구인정보 업데이트 성인인증 0 으로
	$sql = "update $guin_tb set use_adult = '1'";
	query($sql);

	//구직정보 업데이트 성인인증 0 으로
	$sql = "update $per_document_tb set use_adult = '1'";
	query($sql);

}



function company_all_adult_No()
{
	global $_POST,$type_sub_tb,$type_tb,$number_si,$gu_si,$old_si,$guin_tb,$per_document_tb;

	$sql = "update $type_tb set use_adult = '0'";
	$result = query($sql);


	//구인정보 업데이트 성인인증 0 으로
	$sql = "update $guin_tb set use_adult = '0'";
	query($sql);

	//구직정보 업데이트 성인인증 0 으로
	$sql = "update $per_document_tb set use_adult = '0'";
	query($sql);

}




function company_add() {
	global$type_sub_tb,$type_tb;

	print <<<END



	<p class="main_title">직종 추가</p>

	<form action=type_setting.php?action=company_add_reg method=post style='margin:0;'>
	<input type=hidden name=category value='$category'>
	<div id="box_style">
		<div class="box_1"></div>
		<div class="box_2"></div>
		<div class="box_3"></div>
		<div class="box_4"></div>
		<table cellspacing="1" cellpadding="0" border="0" class='bg_style box_height'>
		<colspan>
		<col style='width:15%;'></col>
		<col></col>
		</colspan>
		<tr>
			<th>직종 이름</th>
			<td>
				<p class="short">직종의 이름을 입력하세요 (예:서울)</p>
				<input type='text' name='gu_si' value="$gu_si">
			</td>
		</tr>
		<tr>
			<th>소팅번호</th>
			<td>
				<p class="short">해당직종의 소팅순서를 입력하세요 (출력순서를 정할 수 있습니다 숫자만 입력가능)</p>
				<input type='text' name='sort_number' value="$sort_number_si">
			</td>
		</tr>
		<tr>
			<th>성인인증 사용여부</th>
			<td>
				<p class="short">현재 카테고리와 관련된 구직정보, 구인정보 또한 모두 업데이트 됩니다.<br>(성인전용으로 사용시 해당직종의 하부설정들도 성인전용으로 사용됩니다.)</p>
				<input type='checkbox' name='use_adult' id='use_adult' value="1" $use_adult_check> <label for='use_adult' style='cursor:pointer;'>해당직종을 성인전용으로 사용하시려면 체크해주세요.</label>
			</td>
		</tr>
		</table>

	</div>
	<div align="center"><input type='submit' value='저장하기' class="btn_big_round"></div>
	</form>

END;
}


function company_add_reg() {
	global $category,$type_sub_tb,$type_tb,$title_si;
	$type = $_POST["type"];
	$sort_number = $_POST["sort_number"];
	//print_r2($_POST);
	$sql = "insert into $type_tb (type,sort_number,use_adult) values('$_POST[gu_si]','$sort_number', '$_POST[use_adult]') ";
	$result = query($sql);
	go("type_setting.php");
}

function company_del_reg() {
global $type_sub_tb,$type_tb,$category;
$number_si = $_GET[number_company];

//직종 삭제
$sql = "delete from $type_tb where number= '$number_si' ";
$result = query($sql);
//구 삭제
$sql = "delete from $type_sub_tb where type= '$number_si' ";
$result = query($sql);
go("type_setting.php");
}

function type_mod_reg() {
	global $type_sub_tb,$type_tb,$category;
	$ania = $_POST["ania"];
	$type_sub_tb_number = $_POST["car_type_number"];
	$sql = "update $type_sub_tb set  type_sub = '$ania'  where number= '$type_sub_tb_number' ";
	$result = query($sql);
	go("type_setting.php");
}

function type_del_reg() {
global $type_sub_tb,$type_tb,$category;
$ania = $_POST["ania"];
$type_sub_tb_number = $_POST["car_type_number"];
$sql = "delete from $type_sub_tb where number= '$type_sub_tb_number' ";
$result = query($sql);
go("type_setting.php");
}

function type_add_reg() {
global $type_sub_tb,$type_tb,$category;
$number_si = $_POST["number_si"];
$ania = $_POST["ania"];
#$type_sub_tb_number = $_POST["car_type_number"];
#print $number_si . "/ $ania";
$sql = "insert into $type_sub_tb (type,type_sub) values('$number_si','$ania')";
$result = query($sql);
go("type_setting.php");
}

// 3차
function type_sub_add_reg() {
	global $type_sub_sub_tb;

	$number_si				= $_POST["number_si"];
	$car_type_number_val	= $_POST["car_type_number_val"];
	$ania					= $_POST["ania_sub"];


	$sql	= "
				INSERT INTO
							{$type_sub_sub_tb}
				SET
							type_sub	= '{$car_type_number_val}'
							,title		= '{$ania}'
	";
	$result = query($sql);
	go("type_setting.php");
}

function type_sub_mod_reg() {
	global $type_sub_sub_tb;

	$ania					= $_POST["ania_sub"];
	$car_type_number_sub	= $_POST["car_type_number_sub"];

	$sql	= "
				update
						{$type_sub_sub_tb}
				SET
						title	= '$ania'
				WHERE
						number	= '$car_type_number_sub'
	";
	$result = query($sql);

	go("type_setting.php");
}

function type_sub_del_reg() {
	global $type_sub_sub_tb;

	$ania = $_POST["ania_sub"];
	$car_type_number_sub = $_POST["car_type_number_sub"];

	$sql		= "DELETE FROM {$type_sub_sub_tb} WHERE number= '{$car_type_number_sub}' ";
	$result		= query($sql);

	go("type_setting.php");
}

##############################################################################
#js 파일자동생성
function js_make_type() {
global $type_tb,$type_sub_tb;

#디렉토리 정보를 우선 읽어오자 , 접근권한에 대해서 신경쓰자
#	<option value='0' >전체공개</option>
#	<option value='1' >일반회원이상</option>
#	<option value='2' selected>딜러회원</option>
#	<option value='10' >감춤</option>



$sql = "select * from $type_tb  order by sort_number  asc, type asc ";
$result = query($sql);

$content = <<<END
addListGroup("type_select", "type_root");\n
END;
$option_1 = <<<END
addOption("type_root", "1차직종선택", "", 1);\n
END;

$i = "1";
while ( list($number_read,$type_read,$sort_number_read)  = mysql_fetch_row($result) ) {

#매물매장정리
		if (eregi('===',$type_read)){
		$number_read = "";
		}
$option_1 .= "addList('type_root', '$type_read', '$number_read', 'type-$i');\n";

	#디렉토리=>제조사처리
	$sql2 = "select * from $type_sub_tb where type='$number_read' order by type_sub asc";
	$result2 = query($sql2);
	$j = "1";
	$option_2 .= "addOption('type-$i', '2차직종선택', '', 1); \n";
	while (list($number_gu,$si_gu,$gu_gu)=mysql_fetch_row($result2)){

	$option_2 .= "addList('type-$i', '$gu_gu', '$number_gu', 'type-$i-$j'); \n";
	$j ++;
	}
$i ++;
}
#파일로 써보자
$file=@fopen("../inc/type_select.js","w") or Error("../inc/type_select.js 파일을 열 수 없습니다..\\n \\n디렉토리의 퍼미션을 707로 주십시오");
@fwrite($file,"$content$option_1$option_2\n") or Error("../js/type_select.js 수정 실패 \\n \\n디렉토리의 퍼미션을 707로 주십시오");
@fclose($file);
}


include ("tpl_inc/bottom.php");

?>