<?php

include ("../inc/config.php");
include ("../inc/Template.php");
$TPL = new Template;

include ("../inc/function.php");
include ("../inc/lib.php");


if ($working){
print "프로그램 업그레이드중";
exit;
}


//$_GET
//$_POST
//$_COOKIE

// 과거의 날짜
@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// 항상 변경됨
@header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

// HTTP/1.1
@header("Cache-Control: no-store, no-cache, must-revalidate");
@header("Cache-Control: post-check=0, pre-check=0", false);

// HTTP/1.0
@header("Pragma: no-cache");


if ( !admin_secure("지역설정") ) {
		error("접속권한이 없습니다.");
		exit;
}


	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################






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



elseif ($action == "type_add_reg") {
	type_add_reg();
}
elseif ($action == "type_mod_reg") {
	type_mod_reg();
}
elseif ($action == "type_del_reg") {
	type_del_reg();
}
elseif ($action == "dong_mod_reg") {
	dong_mod_reg();
}



else {
	main();
}

###############################################################################

function main() {
global $si_tb,$gu_tb, $now_location_subtitle;


print <<<END
	<script>
var request;
function createXMLHttpRequest()
{
	if (window.XMLHttpRequest) {
	request = new XMLHttpRequest();
	} else {
	request = new ActiveXObject("Microsoft.XMLHTTP");
	}
}

function startRequest(sel,target,target2,target3,size,level,form_name)
{
var trigger = sel.options[sel.selectedIndex].value;
var form = form_name;
createXMLHttpRequest();
request.open("GET", "area_dong_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&target2=" + target2 + "&target3=" + target3 + "&size=" + size + "&level=" + level, true);
request.onreadystatechange = handleStateChange;
request.send(null);
}

function handleStateChange() {
	if (request.readyState == 4) {
		if (request.status == 200) {
		var response = request.responseText.split("---cut---");
		eval(response[0]+'.dong.value = response[1]');
		window.status="전송완료"
		}
	}
	if (request.readyState == 1)  {
	window.status="로딩중"
	}
}
</script>
END;



#car_company 테이블을 읽어오면서 car_type을 정리를 해주자.
$sql = "select * from $si_tb order by sort_number asc";
$result = query($sql);
while(list($number_si,$si_si,$sort_number_si) = mysql_fetch_row($result)) {

	#받은 값으로 다시 쿼리를 주고

	$sql2 = "select * from $gu_tb where si = '$number_si' order by si asc,gu asc  ";
	$result2 = query($sql2);
	$select_option = "";
	$i = "";


print <<<END
<script>
function select$number_si() {
        for( i=0 ; i < document.theForm_$number_si.car_type_number.length ; i++){
                if(theForm_$number_si.car_type_number.options[i].selected){
                var ani = theForm_$number_si.car_type_number.options[i].value;
        var ani1 = theForm_$number_si.car_type_number.options[i].text;
                }else{
                }
        }
        theForm_$number_si.ania.value = ani1


}

function CheckForm$number_si()
{
	if (theForm_$number_si.ania.value.length < 2	)
	{
		 alert("'구'를 선택하시거나 새로운 '구'를 입력하세요");
		 theForm_$number_si.ania.focus();
		 return (false);
	}
	document.theForm_$number_si.submit();
}

</script>

END;

	while(list($number_gu,$si_gu,$gu_gu) = mysql_fetch_row($result2)) {
	$select_option .= "<option value='$number_gu'>$gu_gu</option>";
	$i ++;
	}

	$dis = '';
	if ( $number_si == 30 )
	{
		$dis = 'none';
	}

	$meme_temp .= "

<!-- ITEM START -->
<tr>
	<td style='text-align:center;'>$sort_number_si 번째</td>
	<td align='center' >
		<div style='margin-bottom:10px'>$si_si</div>
		<a href='area_setting.php?action=company_mod&number_company=$number_si' class='btn_small_red'>수정</a>
		<a href=\"javascript:bbsdel('area_setting.php?action=company_del_reg&number_company=$number_si');\" style='display:$dis' class='btn_small_dark'>삭제</a>
	</td>
	<td align='center' valign='top'>
		<form name=theForm_$number_si method=post style='margin:0;'>
		<input type=hidden name=number_si value='$number_si'>

		<p style='margin-bottom:5px; text-align:left'><select name=car_type_number onchange=\"javascript:select$number_si();\" style='width:400px; height:100px' size='8'>$select_option</select></p>
		<div style='text-align:left'>
			<input type=text name='ania' style='width:260px; height:21px; vertical-align:middle'>

			<input type=button value='등록' onclick=\"action='./area_setting.php?action=type_add_reg'; CheckForm$number_si();\" class='btn_small_blue'> <input type=button value='수정' onclick=\"action='./area_setting.php?action=type_mod_reg'; CheckForm$number_si();\" class='btn_small_red'> <input type=button value='삭제' onclick=\"action='./area_setting.php?action=type_del_reg'; CheckForm$number_si();\" class='btn_small_dark'>
		</div>
		</form>

	</td>
</tr>
<!-- ITEM END -->


	";
}


print <<<END

<script language="javascript">
<!--
	function bbsdel(strURL) {
		var msg = "\\n[주의] 삭제하시겠습니까?\\n\\n삭제하실 경우 해당 지역의 '구' 정보도 같이 삭제가 됩니다";
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
	-->
</script>

<p class="main_title">$now_location_subtitle</p>
<style>
	.area_gudong select { width:257px; padding:5px; height:150px; }
	.area_gudong_t textarea { width:250px; padding:5px;}
</style>
<div class="help_style">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>
	<span class="help">도움말</span>
	<p>텍스트박스에 '구'명을 입력하여 등록하며, 등록된 이름을 선택후 수정이나 삭제를 할 수 있습니다.</p>
</div>
<div id="list_style">
	<table cellspacing="0" cellpadding="0" border="0" class="bg_style table_line">
		<tr>
			<th style='width:180px;'>출력순서</th>
			<th style='width:400px;'>지역 (시 / 도)</th>
			<th>군 / 구</th>
		</tr>
		$meme_temp
	</table>
</div>
<div style="text-align:center;">
	<input type="button" onClick="location.href='area_setting.php?action=company_add&category=$category'" value="등록" class="btn_big_round">
</div>


END;
}

function company_mod($number_si) {
global $gu_tb,$si_tb;


$sql = "select * from $si_tb  where number= '$number_si' ";
$result = query($sql);
list($number_si,$gu_si,$sort_number_si) = mysql_fetch_row($result);

print <<<END

<p class="main_title">지역수정</p>

<form action=area_setting.php?action=company_mod_reg method=post style='margin:0;'>
<input type=hidden name=number_si value=$number_si>
<input type=hidden name=old_si value='$gu_si'>
<div id="box_style">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>

	<table cellspacing="1" cellpadding="0" border="0" class='bg_style'>
	<colgroup>
	<col style="width:15%;"></col>
	<col style="width:75%;"></col>
	</colgroup>
	<tr>
		<th>지역 이름</th>
		<td>
			<p class="short">지역의 이름을 입력하세요 (예:서울)</p>
			<input type='text' name='gu_si' value="$gu_si">
		</td>
	</tr>
	<tr>
		<th>소팅번호</th>
		<td>
			<p class="short">해당지역의 소팅순서를 입력하세요 (출력순서를 정할 수 있습니다 숫자만 입력가능)</p>
			<input type='text' name='sort_number' value="$sort_number_si">
		</td>
	</tr>
	</table>
</div>
<div style="text-align:center;"><input type='submit' value='저장하기' class="btn_big_round"></div>
</form>


END;
}

function company_mod_reg()
{
	global $_POST,$gu_tb,$si_tb,$number_si,$gu_si,$old_si,$wgs_get_type;
	$sort_number = $_POST[sort_number];

	if ( $wgs_get_type == 'google' )
	{
		$data			= getcontent_wgs_google(iconv("euc-kr", "utf-8",$gu_si));

		$ypoint			= getpoint($data,"<lat>","</lat>");
		$xpoint			= getpoint($data,"<lng>","</lng>");

		$wgsArr			= get_wgs_point($xpoint[0], $ypoint[0]);
	}
	else
	{
		$data			= getcontent_wgs($gu_si);

		$xpoint			= getpoint($data,"<x>","</x>");
		$ypoint			= getpoint($data,"<y>","</y>");

		$wgsArr			= get_wgs_point($xpoint, $ypoint);
	}


	$sql = "update $si_tb set si = '$gu_si',sort_number = '$sort_number', x_point='$wgsArr[x_point]', y_point='$wgsArr[y_point]'  where number= '$number_si' ";
	$result = query($sql);

	go("area_setting.php");
}


function company_add() {
global$gu_tb,$si_tb,$now_location_subtitle;



print <<<END

<p class="main_title">$now_location_subtitle</p>
<form action=area_setting.php?action=company_add_reg method=post style='margin:0;'>
<input type=hidden name=category value='$category'>
<div id="box_style">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>

	<table cellspacing="1" cellpadding="0" border="0" class='bg_style'>
	<colgroup>
	<col style="width:15%;"></col>
	<col style="width:75%;"></col>
	</colgroup>
	<tr>
		<th>지역 이름</th>
		<td>
			<p class="short">지역의 이름을 입력하세요 (예:서울)</p>
			<input type='text' name='gu_si' value="$gu_si">
		</td>
	</tr>
	<tr>
		<th>소팅번호</th>
		<td>
			<p class="short">해당지역의 소팅순서를 입력하세요 (출력순서를 정할 수 있습니다 숫자만 입력가능)</p>
			<input type='text' name='sort_number' value="$sort_number_si">
		</td>
	</tr>
	</table>
</div>
<div style="text-align:center;"><input type='submit' value='저장하기' class="btn_big_round"></div>
</form>


END;
}
function dong_mod_reg() {
global $car_type_number,$_POST,$si_tb,$gu_tb,$gu_tb_dong;

$_POST[dong] = str_replace('\r','',$_POST[dong]);
$_POST[dong] = str_replace('\n','/',$_POST[dong]);

$sql = "select * from $gu_tb_dong  where gu_number= '$car_type_number' ";
$result = query($sql);
$DONG = happy_mysql_fetch_array($result);


	if ($DONG[number]){
	$sql = "update $gu_tb_dong set dong_title = '$_POST[dong]' where gu_number= '$car_type_number' ";
	$result = query($sql);
	}
	else {
	$sql = "insert into  $gu_tb_dong set dong_title = '$_POST[dong]' , gu_number= '$car_type_number' ";
	$result = query($sql);
	}

$time = happy_mktime();

go("area_setting.php?id=$time");

exit;


}

function company_add_reg()
{
	global $category,$gu_tb,$si_tb,$title_si,$wgs_get_type;
	$gu_si = $_POST["gu_si"];
	$sort_number = $_POST["sort_number"];

	if ( $wgs_get_type == 'google' )
	{
		$data			= getcontent_wgs_google(iconv("euc-kr", "utf-8",$gu_si));

		$ypoint			= getpoint($data,"<lat>","</lat>");
		$xpoint			= getpoint($data,"<lng>","</lng>");

		$wgsArr			= get_wgs_point($xpoint[0], $ypoint[0]);
	}
	else
	{
		$data			= getcontent_wgs($gu_si);

		$xpoint			= getpoint($data,"<x>","</x>");
		$ypoint			= getpoint($data,"<y>","</y>");

		$wgsArr			= get_wgs_point($xpoint, $ypoint);
	}


	$sql = "update $si_tb set si = '$gu_si',sort_number = '$sort_number', x_point='$wgsArr[x_point]', y_point='$wgsArr[y_point]'  where number= '$number_si' ";

	$sql = "insert into $si_tb (si,sort_number,x_point,y_point) values('$gu_si','$sort_number','$x_point','$y_point') ";
	$result = query($sql);
	go("area_setting.php");
}

function company_del_reg() {
	global $gu_tb,$si_tb,$category;
	global $dong_tb;

	$number_si = $_GET[number_company];

	//지역 삭제
	$sql = "delete from $si_tb where number= '$number_si' ";
	$result = query($sql);

	$Sql	= "select number from $gu_tb where si= '$number_si' ";
	$result = query($Sql);
	while($GU = happy_mysql_fetch_array($result))
	{
		$sql2 = "delete from $dong_tb where gu_number= '".$GU[number]."' ";
		$result2 = query($sql2);
	}

	//구 삭제
	$sql = "delete from $gu_tb where si= '$number_si' ";
	$result = query($sql);
	go("area_setting.php");
}

function type_mod_reg() {
global $gu_tb,$si_tb,$category;
$ania = $_POST["ania"];
$gu_tb_number = $_POST["car_type_number"];
$sql = "update $gu_tb set  gu = '$ania'  where number= '$gu_tb_number' ";
$result = query($sql);
go("area_setting.php");
}

function type_del_reg() {
	global $gu_tb,$si_tb,$category, $dong_tb;

	$ania = $_POST["ania"];
	$gu_tb_number = $_POST["car_type_number"];

	$sql = "delete from $gu_tb where number= '$gu_tb_number' ";
	$result = query($sql);

	$sql = "delete from $dong_tb where gu_number= '$gu_tb_number' ";
	$result = query($sql);

	go("area_setting.php");
}

function type_add_reg() {
global $gu_tb,$si_tb,$category;
$number_si = $_POST["number_si"];
$ania = $_POST["ania"];
#$gu_tb_number = $_POST["car_type_number"];
#print $number_si . "/ $ania";
$sql = "insert into $gu_tb (si,gu) values('$number_si','$ania')";
$result = query($sql);
go("area_setting.php");
}


##############################################################################
#js 파일자동생성
function js_make() {
global $si_tb,$gu_tb;

#디렉토리 정보를 우선 읽어오자 , 접근권한에 대해서 신경쓰자
#	<option value='0' >전체공개</option>
#	<option value='1' >일반회원이상</option>
#	<option value='2' selected>딜러회원</option>
#	<option value='10' >감춤</option>



$sql = "select * from $si_tb  order by sort_number  asc, si asc ";
$result = query($sql);

$content = <<<END
addListGroup("area_select", "area_root");\n
END;
$option_1 = <<<END
addOption("area_root", "지역선택", "", 1);\n
END;

$i = "1";
while ( list($number_read,$si_read,$sort_number_read)  = mysql_fetch_row($result) ) {

#매물매장정리
		if (eregi('===',$si_read)){
		$number_read = "";
		}

$option_1 .= "addList('area_root', '$si_read', '$number_read', 'area-$i');\n";

	#디렉토리=>제조사처리
	$sql2 = "select * from $gu_tb where si='$number_read' order by gu asc";
	$result2 = query($sql2);
	$j = "1";

	$option_2 .= "addOption('area-$i', '세부지역선택', '', 1); \n";
	while (list($number_gu,$si_gu,$gu_gu)=mysql_fetch_row($result2)){
	$option_2 .= "addList('area-$i', '$gu_gu', '$number_gu', 'area-$i-$j'); \n";
	$j ++;
	}
$i ++;
}
#파일로 써보자
$file=@fopen("../inc/area_select.js","w") or Error("../inc/area_select.js 파일을 열 수 없습니다..\\n \\n디렉토리의 퍼미션을 707로 주십시오");
@fwrite($file,"$content$option_1$option_2\n") or Error("../js/area_select.js 수정 실패 \\n \\n디렉토리의 퍼미션을 707로 주십시오");
@fclose($file);
}


include ("tpl_inc/bottom.php");

?>