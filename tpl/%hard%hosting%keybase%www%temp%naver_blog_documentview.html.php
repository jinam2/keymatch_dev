<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:50:17 */
function SkyTpl_Func_717360594 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<div style="padding:20px 0 30px 0px; border-bottom:5px solid #333; ">
	<div style="font-size:20px; weight:bold; color:#333; margin-bottom:5px; font-family:'맑은고딕',tahoma,NanumGothic,Helvetica,'Apple SD Gothic Neo',Sans-serif !important;"><strong><?=$_data['Data']['title']?></strong></div>
	<div style="font-family:'맑은고딕',tahoma,NanumGothic,Helvetica,'Apple SD Gothic Neo',Sans-serif !important;"></div>
</div>

<div style="margin-bottom:30px;">
	<div class="view_content" style="margin-bottom:20px;">
		<table cellspacing="0" cellpadding="0" style="width:100%;">

		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">이름</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;">OOO (<?=$_data['Data']['user_prefix']?>, <?=$_data['Data']['user_birth_year']?>-<?=$_data['Data']['user_birth_month']?>-<?=$_data['Data']['user_birth_day']?>) </font></b></td>
		</tr>
		<!--
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">전화</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['Data']['user_phone']?></td>
		</tr>

		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">핸드폰</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['Data']['user_hphone']?></td>
		</tr>

		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">이메일</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['Data']['email']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">홈페이지</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['Data']['user_homepage']?></td>
		</tr>

		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">주소</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['Data']['user_addr1']?> <?=$_data['Data']['user_addr2']?></td>
		</tr>
		-->
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">희망지역</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['Data']['job_where']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">희망업종</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['Data']['job_type']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">고용형태</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['Data']['grade_gtype']?></td>
		</tr>

		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">희망연봉</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['Data']['grade_money_type']?> <b><?=$_data['Data']['grade_money']?></b></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">키워드</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['Data']['keyword']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">보훈대상여부</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['Data']['user_bohun']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">장애대상여부</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['Data']['user_jangae']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">병역사항</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['Data']['user_army']?> <?=$_data['Data']['user_army_status']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">학력사항</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;"><?=$_data['학력리스트내용']?></td>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #dedede; text-align:left; width:100px; padding:12px 0 12px 5px; color:#131313; font-weight:normal; vertical-align:top;">경력사항</th>
			<td style="border-bottom:1px solid #dedede; text-align:left; padding:12px 0 12px 0; vertical-align:top;">
				<b><?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?></b>&nbsp;&nbsp;<span class="font_st_12" style="color:#909090;"><?=$_data['Data']['work_otherCountry']?></span><br>
				<?=$_data['Data']['work_list']?>

			</td>
		</tr>
		</table>
	</div>
</div>

<? }
?>