<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:48:52 */
function SkyTpl_Func_3324103695 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<div style="padding:20px 0 30px 0px; border-bottom:5px solid #333; ">
	<div style="font-size:20px; weight:bold; color:#333; margin-bottom:5px; font-family:'맑은고딕',tahoma,NanumGothic,Helvetica,'Apple SD Gothic Neo',Sans-serif !important;"><strong><?=$_data['DETAIL']['guin_com_name']?></strong></div>
	<div style="font-family:'맑은고딕',tahoma,NanumGothic,Helvetica,'Apple SD Gothic Neo',Sans-serif !important;"><?=$_data['DETAIL']['guin_title']?></div>
</div>

<div style="margin-bottom:30px;">
	<div class="view_content" style="margin-bottom:20px;">
		<table cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">회사명</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['DETAIL']['guin_com_name']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">대표자명</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['COM']['extra11']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">업종</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['COM']['extra13']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">사업내용</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['COM']['extra14']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">매출액</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['COM']['extra17']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">사원수</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['COM']['extra2']?>명</td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">채용분야</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['DETAIL']['type']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">담당업무</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['DETAIL']['guin_work_content']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">기업형태</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['DETAIL']['HopeSize']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">고용형태</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['DETAIL']['guin_type']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">채용직급</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['DETAIL']['guin_grade']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">모집인원</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['DETAIL']['howpeople']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">급여조건</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['DETAIL']['guin_pay_type']?> <?=$_data['DETAIL']['guin_pay']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">자격조건</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;">경력 : <?=$_data['DETAIL']['guin_career_temp']?> / 학력 : <?=$_data['DETAIL']['guin_edu']?> / 성별 : <?=$_data['DETAIL']['guin_gender']?> / 나이 : <?=$_data['DETAIL']['guin_age_temp']?> / 결혼유무 : <?=$_data['DETAIL']['marriage_chk']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">우대사항</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['우대사항']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">키워드</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['키워드']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">인근지하철</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['DETAIL']['underground1']?> <?=$_data['DETAIL']['underground2']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">근무시간</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['DETAIL']['work_week']?> / ><?=$_data['DETAIL']['start_worktime']?> ~ <?=$_data['DETAIL']['finish_worktime']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">복리후생</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['복리후생']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">접수기간</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['접수기간']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">접수방법</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['DETAIL']['howjoin']?></td>
		</tr>
		</table>
	</div>
</div>


<div style="margin-bottom:20px;">
	<div style="font-size:20px; weight:bold; border-bottom:2px solid #333; padding-bottom:10px; font-family:'맑은고딕',tahoma,NanumGothic,Helvetica,'Apple SD Gothic Neo',Sans-serif !important;"><strong>상세정보</strong></div>
	<div><?=$_data['DETAIL']['guin_main']?></div>
</div>
<? }
?>