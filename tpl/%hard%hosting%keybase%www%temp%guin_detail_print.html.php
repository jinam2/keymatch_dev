<? /* Created by SkyTemplate v1.1.0 on 2023/04/11 10:19:58 */
function SkyTpl_Func_4104771190 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language=javascript>
<!--
var downLayerId;
var dropDegree = 5; //스크롤 속도
var doDirect;
var DirectTerm = 4000; //스크롤 지연시간
var curDropIdx = 0;

function DirectDown()
{
clearInterval(doDirect);
clearInterval(downLayerId);

for(i = curDropIdx ;i < document.all["DropHit"].length + curDropIdx;i++){
  document.all["DropHit"][i%document.all["DropHit"].length].style.posTop = document.all["DropHit"][i%document.all["DropHit"].length].style.posHeight * (-1*((i-curDropIdx)%document.all["DropHit"].length));
}
var temp = 'setInterval("DownLayer()",20)';
downLayerId = eval(temp);
direction = "down";
}
function DownLayer()
{
if(document.all["DropHit"][curDropIdx].style.posTop < document.all["DropHit"][curDropIdx].style.posHeight){
  for(j = curDropIdx ;j < document.all["DropHit"].length + curDropIdx;j++){
   document.all["DropHit"][j%document.all["DropHit"].length].style.posTop += dropDegree;
  }
}else{
  clearInterval(downLayerId);
  for(j = curDropIdx ;j < document.all["DropHit"].length + curDropIdx;j++){
   document.all["DropHit"][j%document.all["DropHit"].length].style.posTop = document.all["DropHit"][j%document.all["DropHit"].length].style.posHeight *((-1*((j-curDropIdx)%document.all["DropHit"].length))+1);
  }
  curDropIdx = (curDropIdx + 1) ;
  curDropIdx = curDropIdx > document.all["DropHit"].length-1 ? curDropIdx%document.all["DropHit"].length:curDropIdx;
  var temp = 'setInterval("DirectDown()",DirectTerm)';
  doDirect = eval(temp);
}
}
function DirectUp()
{
clearInterval(doDirect);
clearInterval(downLayerId);
var tempIdx = 0;
for(i = 0;i<document.all["DropHit"].length;i++){
  tempIdx = (document.all["DropHit"].length + curDropIdx - i) %document.all["DropHit"].length;
  document.all["DropHit"][tempIdx].style.posTop = i*document.all["DropHit"][tempIdx].style.posHeight;
}
var temp = 'setInterval("UpLayer()",20)';
downLayerId = eval(temp);
direction = "up";
}
function UpLayer()
{
var tempIdx = 0;
if(document.all["DropHit"][curDropIdx].style.posTop < document.all["DropHit"][curDropIdx].style.posHeight && document.all["DropHit"][curDropIdx].style.posTop > document.all["DropHit"][curDropIdx].style.posHeight * (-1)){
  for(j = 0 ;j < document.all["DropHit"].length;j++){
   tempIdx = (document.all["DropHit"].length + curDropIdx - j) %document.all["DropHit"].length;
   document.all["DropHit"][tempIdx].style.posTop -= dropDegree;
  }
}else{
  clearInterval(downLayerId);
  for(j = 0;j<document.all["DropHit"].length;j++){
   tempIdx = (document.all["DropHit"].length + curDropIdx - j) % document.all["DropHit"].length;
   document.all["DropHit"][tempIdx].style.posTop = (j-1)*(document.all["DropHit"][tempIdx].style.posHeight);
  }
  curDropIdx = (curDropIdx - 1) ;
  curDropIdx = curDropIdx < 0 ? document.all["DropHit"].length-1:curDropIdx;
  var temp = 'setInterval("DirectUp()",DirectTerm)';
  doDirect = eval(temp);
}
}
//-->
</script>


<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td height="40" align="center"><b><font size='3' color='black'><?=$_data['DETAIL']['guin_title']?></font></b></td>
	</tr>
</table>

<table cellpadding="0" cellspacing="1" bgcolor="#dfdfdf" width="100%;" style="line-height:20px">
<tr>
	<td bgcolor="#f9f9f9" colspan="4" height="40" align="center"><b>회사정보</b></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>대표자</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" width="200" class="font_12" align="left"><?=$_data['DETAIL']['boss_name']?></td>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>설립연도</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['com_open_year']?> 년도</td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>직원수</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['com_worker_cnt']?></td>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>업종</td>
	<!--<td bgcolor="#FFFFFF" style="padding-left:5px; padding-top:2px;" class="font_st_11" align="left"><?=$_data['DETAIL']['type']?></td>-->
	<td bgcolor="#FFFFFF" style="padding-left:5px; padding-top:2px;" class="font_st_11" align="left"><?=$_data['COM']['extra13']?></td>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="1" bgcolor="#dfdfdf" width="100%"  style="line-height:20px">
<tr>
	<td bgcolor="#f9f9f9" colspan="4" height="40" align="center"><b>담당자 정보</b></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>회사명</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" width="200" class="font_12" align="left"><?=$_data['DETAIL']['guin_com_name']?></td>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>전화번호</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['guin_phone']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>담당자</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['guin_name']?></td>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>팩스</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['guin_fax']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>홈페이지</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['guin_homepage']?></td>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>이메일</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['guin_email']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>회사주소</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" colspan="3" class="font_12" align="left"><font color="#0066FF">(<?=$_data['COM']['com_zip']?>)</font> <?=$_data['COM']['com_addr1']?> <?=$_data['COM']['com_addr2']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>역세권</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" colspan="3" class="font_12" align="left"><?=$_data['DETAIL']['underground1']?> <?=$_data['DETAIL']['underground2']?></td>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="1" bgcolor="#dfdfdf" width="100%"  style="line-height:20px">
<tr>
	<td bgcolor="#f9f9f9" colspan="2" height="40" align="center"><b>모집요강 기본정보</b></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>담당업무</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['guin_work_content']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>채용분야</td>
	<td bgcolor="#FFFFFF" style="padding:5px;" class="font_12" align="left"><?=$_data['DETAIL']['type']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>업무방법</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['guin_type']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>채용직급</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['guin_grade']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>모집인원</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['howpeople']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>급여조건</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12_tahoma" align="left"><?=$_data['DETAIL']['guin_pay_type']?> <?=$_data['DETAIL']['guin_pay']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>우대사항</td>
	<td bgcolor="#FFFFFF" style="padding:5px;" class="font_12" align="left"><?=$_data['우대사항2']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>회사규모</td>
	<td bgcolor="#FFFFFF" style="padding:5px;" class="font_12" align="left"><?=$_data['DETAIL']['HopeSize']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>키워드</td>
	<td bgcolor="#FFFFFF" style="padding:5px;" class="font_12" align="left"><?=$_data['키워드2']?></td>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="1" bgcolor="#dfdfdf" align="center" width="100%">
<tr>
	<td bgcolor="#f9f9f9" colspan="4" height="40" align="center"><b>자격요건</b></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>경 력</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" width="200" class="font_12" align="left"><?=$_data['DETAIL']['guin_career_temp']?></td>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>결혼유무</td>
	<!--<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['lang_type1']?></td>-->
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['marriage_chk']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>업무일</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['lang_type2']?></td>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>성 별</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['guin_gender']?> (나이:<?=$_data['DETAIL']['guin_age_temp']?>)</td>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="1" bgcolor="#dfdfdf" width="100%">
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40"><b>상세요강</td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" style="padding:8px; word-break:break-all;" align="left"><?=$_data['DETAIL']['guin_main']?></td>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="1" bgcolor="#dfdfdf" width="100%">
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40"><b>복리후생</td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" class="font_12" style="padding:10px;"><?=$_data['복리후생']?></td>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="0"  width="100%">
<tr>
	<td height="1" bgcolor="#dfdfdf" colspan="3"></td>
</tr>
<tr>
	<td width="1" bgcolor="#dfdfdf"></td>
	<td bgcolor="#f9f9f9" align="center" height="40"><b>근무지역</td>
	<td width="1" bgcolor="#dfdfdf"></td>
</tr>
<tr>
	<td height="1" bgcolor="#dfdfdf" colspan="3"></td>
</tr>
<tr>
	<td width="1" bgcolor="#dfdfdf"></td>
	<td bgcolor="#FFFFFF" class="font_12" style="padding:10px;"><?=$_data['DETAIL']['area']?></td>
	<td width="1" bgcolor="#dfdfdf"></td>
</tr>
<tr>
	<td height="1" bgcolor="#dfdfdf" colspan="3"></td>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="1" bgcolor="#dfdfdf" align="center" width="100%">
<tr>
	<td bgcolor="#f9f9f9" colspan="2" align="center" height="40"><b>접수방법</td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>접수기간</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['접수기간']?></td>
</tr>
<tr>
	<td bgcolor="#f9f9f9" align="center" height="40" width="120" class="font_12"><b>접수방법</td>
	<td bgcolor="#FFFFFF" style="padding-left:5px;" class="font_12" align="left"><?=$_data['DETAIL']['howjoin']?></td>
</tr>
</table>

<br>
<center>
<?=$_data['프린트버튼']?>

</center>
<br>
<? }
?>