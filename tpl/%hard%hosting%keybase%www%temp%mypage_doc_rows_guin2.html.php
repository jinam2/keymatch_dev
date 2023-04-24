<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 16:24:57 */
function SkyTpl_Func_1518505796 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div>
	<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse;">
		<tr>
			<td style="width:200px; vertical-align:top; padding-top:30px; text-align:center; border-bottom:1px solid #dfdfdf; background:#f0f6fc; line-height:24px">
				<span style="display:block">
					<a href="document_view.php?number=<?=$_data['Data']['number']?>&read=<?=$_data['Data']['read']?><?=$_data['searchMethod2']?>">
						<img src="<?echo happy_image('자동','가로106','세로120','로고사용안함','로고위치7번','기본퀄리티','gif원본출력','img/no_photo.gif','비율대로확대','2') ?>" style="width:70px; height:80px">
					</a>
				</span>
				<span style="padding-top:5px; display:block; font-weight:bold; letter-spacing:-1.2px; color:#333" class="font_16 font_malgun">
					<?=$_data['Data']['user_name']?>

				</span>
				<span style="display:block; color:#999; letter-spacing:-1px" class="font_13 font_malgun">
					(<?=$_data['Data']['user_prefix']?>, <?=$_data['Data']['age']?>)
				</span>
				<span style="display:block; margin-top:15px">
					<span style="padding:0 13px; letter-spacing:-1.2px; color:#<?=$_data['배경색']['서브색상']?>; line-height:28px; font-weight:bold" class="font_16 font_malgun">
						 <?=$_data['Data']['doc_ok']?>

					</span>
				</span>
				<span style="display:block; margin-top:15px">
					<span style="padding:0 30px; letter-spacing:-1.2px; display:inline-block; background:#fff; color:#707070; line-height:28px; border:1px solid #707070" class="font_13 font_malgun">
						<a href="<?=$_data['Data']['예비합격버튼_링크']?>"><?=$_data['Data']['예비합격버튼_텍스트']?></a>
					</span>
				</span>
			</td>
			<td style="border-bottom:1px solid #dfdfdf; padding:30px">
				<h4 class="font_16 font_malgun" style="letter-spacing:-1.2px; color:#333; padding-bottom:15px">
					<a href="document_view.php?number=<?=$_data['Data']['number']?>&read=<?=$_data['Data']['read']?><?=$_data['searchMethod2']?>" style="color:#333">
						[<?=$_data['Data']['number']?>] <?=$_data['Data']['title_cut']?>

					</a>
					<span style="margin-left:10px"> <?=$_data['Data']['app_im_info']?> </span>
					<span style="font-size:12px; color:#<?=$_data['배경색']['서브색상']?>"><?=$_data['Data']['read_ok']?></span>
				</h4>
				<table cellpadding="0" cellspacing="0" style="width:100%; line-height:24px">
					<tr>
						<th class="font_13 font_malgun" style="width:70px; color:#999; text-align:left; letter-spacing:-1.2px; font-weight:normal">
							희망직종
						</th>
						<td class="font_13 font_malgun" style="letter-spacing:-1.2px; text-align:left; color:#666666">
							<?=$_data['Data']['job_type']?>

						</td>
					</tr>
					<tr>
						<th class="font_13 font_malgun" style="width:70px; color:#999; text-align:left; letter-spacing:-1.2px; font-weight:normal">학력</th>
						<td class="font_13 font_malgun" style="letter-spacing:-1.2px; text-align:left; color:#666666">
							<?=$_data['Data']['grade_lastgrade']?> : <?=$_data['Data']['grade_last_schoolType']?>

						</td>
					</tr>
					<tr>
						<th class="font_13 font_malgun" style="width:70px; color:#999; text-align:left; letter-spacing:-1.2px; font-weight:normal">희망지역</th>
						<td class="font_13 font_malgun" style="letter-spacing:-1.2px; text-align:left; color:#666666"><?=$_data['Data']['job_where']?></td>
					</tr>
					<tr>
						<th class="font_13 font_malgun" style="width:70px; color:#999; text-align:left; letter-spacing:-1.2px; font-weight:normal">희망급여</th>
						<td class="font_13 font_malgun" style="letter-spacing:-1.2px; text-align:left; color:#666666">
							<?=$_data['Data']['grade_money_icon']?> <?=$_data['Data']['grade_money']?>

						</td>
					</tr>
					<tr>
						<td class="font_16 font_malgun" style="width:200px; padding:10px 0; background:url('./img/resister_line_01.gif') 0 bottom repeat-x">
							<strong style="color:#333"><?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?> <?=$_data['Data']['work_otherCountry']?></strong>
						</td>
						<td class="font_tahoma" style="color:#999; text-align:right;  background:url('./img/resister_line_01.gif') 0 bottom repeat-x">
							<?=$_data['Data']['bregdate']?>

						</td>
					</tr>
				<!-- 	<tr>
						<td colspan="2" class="font_13 font_malgun" style="padding:15px 0 0 0; letter-spacing:-1.2px">
							<img src="./img/bub_ico.gif" style="vertical-align:middle; margin-bottom:2px"> 사전인터뷰답변: &nbsp;&nbsp;<?=$_data['Data']['interview']?>

						</td>
					</tr> -->
				</table>
			</td>
			<td style="width:190px; padding:30px; border-left:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf; vertical-align:top">
				<!-- 스크랩한 이력서에 평점,메모 남기기 -->
				<form action="online_doc_change.php" name="memo_<?=$_data['Data']['bNumber']?>" target="j_blank" method="post">
				<input type="hidden" name="mode" id="mode_<?=$_data['Data']['bNumber']?>" value="com_memo" target="j_blank">
				<input type="hidden" name="bNumber" id="pNumber_<?=$_data['Data']['bNumber']?>" value="<?=$_data['Data']['bNumber']?>">
				<input type="hidden" name="point" id="point_<?=$_data['Data']['bNumber']?>"  value="<?=$_data['Data']['bPoint']?>">
					<div style="border:1px solid #ccc; background:#f9f9fb; padding:15px">
						<textarea name="memo" id="memo_<?=$_data['Data']['bNumber']?>" style="background:#fafafa; height:90px; padding:10px; line-height:160%; font-family:'굴림'; color:#888; border:none; resize:none"><?=$_data['Data']['bMemo']?></textarea>
					</div>
					<div class="basic_<?=$_data['Data']['bNumber']?>" data-average="<?=$_data['Data']['bPoint']?>" data-id="1" style="margin:15px auto 15px auto;"></div>
					<input type="image" src="img/btn_memosave.gif" alt="저장하기">
				</div>
				</form>
			</td>
		</tr>
	</table>
</div>

<script type="text/javascript">
$(document).ready(function(){
	document.memo_<?=$_data['Data']['bNumber']?>.point.value = '<?=$_data['Data']['bPoint']?>';
	$('.basic_<?=$_data['Data']['bNumber']?>').jRating({
		step:true,
		length : 5,
		rateMax:5,
		canRateAgain : true,
		nbRates : 9999,
		onClick : function(element,rate) {
			//alert(rate/2+5);
			//p = ((rate/2+5) < 10)?'0'+(rate/2+5):(rate/2+5);
			p = rate;
			document.memo_<?=$_data['Data']['bNumber']?>.point.value = p;
		}
	});
});
</script>
<? }
?>