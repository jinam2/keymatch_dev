<? /* Created by SkyTemplate v1.1.0 on 2023/04/17 18:45:09 */
function SkyTpl_Func_1162031005 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div>
	<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse;">
		<tr>
			<td style="width:200px; text-align:center; border-bottom:1px solid #dfdfdf; background:#f5f7fb; vertical-align:center">
				<span style="display:block">
					<a href="document_view.php?number=<?=$_data['Data']['number']?>&read=<?=$_data['Data']['read']?><?=$_data['searchMethod2']?>" style="display:inline-block; width:80px; height:80px; border-radius:50%; border:1px solid #ddd; overflow:hidden;">
						<img src="<?echo happy_image('자동','가로80','세로80','로고사용안함','로고위치7번','기본퀄리티','gif원본출력','img/logo_img.gif','비율대로확대','2') ?>" style="width:100%;" border="0" align="absmiddle">
					</a>
				</span>
				<span style="padding-top:5px; display:block; letter-spacing:-1px color:#333" class="font_16 noto400">
					<?=$_data['Data']['user_name']?>

				</span>
				<span style="display:block; color:#999; letter-spacing:-1px" class="font_14 noto400">
					(<?=$_data['Data']['user_prefix']?>, <?=$_data['Data']['age']?>)
				</span>
				<span style="display:block; margin-top:15px">
					<a href="#" onclick="confirm_del(<?=$_data['Data']['pNumber']?>,<?=$_data['Data']['cNumber']?>,<?=$_data['Data']['cNumber']?>);">
						<img src="img/btn_scrap_del2.gif" border="0" align="absmiddle">
					</a>
				</span>
				<span style="display:block; margin-top:15px; display:none">
					<span style="padding:0 13px; letter-spacing:-1px display:inline-block; background:#8bcaff; color:#fff; line-height:28px" class="font_16 noto400">
						<?=$_data['Data']['read_ok']?> <?=$_data['Data']['doc_ok']?>

					</span>
				</span>
			</td>
			<td style="border-bottom:1px solid #dfdfdf; padding:30px">
				<h4 class="font_18 noto400" style="letter-spacing:-1px color:#333; padding-bottom:15px; margin:0;">
					<a href="document_view.php?number=<?=$_data['Data']['number']?>&read=<?=$_data['Data']['read']?><?=$_data['searchMethod2']?>" style="color:#333">[<?=$_data['Data']['number']?>] <?=$_data['Data']['title_cut']?></a>
				</h4>
				<table cellpadding="0" cellspacing="0" style="width:100%; line-height:26px">
					<tr>
						<th class="font_15 noto400" style="width:70px; color:#999; text-align:left; letter-spacing:-1px; font-weight:normal">
							희망직종
						</th>
						<td class="font_15 noto400" style="letter-spacing:-1px text-align:left; color:#666666">
							<?=$_data['Data']['job_type']?>

						</td>
					</tr>
					<tr>
						<th class="font_15 noto400" style="width:70px; color:#999; text-align:left; letter-spacing:-1px; font-weight:normal">학력</th>
						<td class="font_15 noto400" style="letter-spacing:-1px text-align:left; color:#666666">
							<?=$_data['Data']['grade_lastgrade']?> : <?=$_data['Data']['grade_last_schoolType']?>

						</td>
					</tr>
					<tr>
						<th class="font_15 noto400" style="width:70px; color:#999; text-align:left; letter-spacing:-1px; font-weight:normal">희망지역</th>
						<td class="font_15 noto400" style="letter-spacing:-1px text-align:left; color:#666666"><?=$_data['Data']['job_where']?></td>
					</tr>
					<tr>
						<th class="font_15 noto400" style="width:70px; color:#999; text-align:left; letter-spacing:-1px; font-weight:normal">희망급여</th>
						<td class="font_15 noto400" style="letter-spacing:-1px text-align:left; color:#666666">
							<?=$_data['Data']['grade_money_icon']?> <?=$_data['Data']['grade_money']?>

						</td>
					</tr>
					<tr>
						<td colspan="2" class="font_16 noto400" style="padding:15px 0; background:url('./img/resister_line_01.gif') 0 bottom repeat-x">
							<span class='noto500' style="color:#<?=$_data['배경색']['서브색상']?>"><?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?> <?=$_data['Data']['work_otherCountry']?></span>
							<span style="float:right; color:#999" class="font_14 font_tahoma">
								<?=$_data['Data']['scrapdate']?>

							</span>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="font_13 noto400" style="padding:15px 0 0 0; letter-spacing:-1.2px">
							<img src="./img/bub_ico.gif" style="vertical-align:middle; margin-bottom:2px"> 사전인터뷰답변<br> <?=$_data['Data']['interview']?>

						</td>
					</tr>
				</table>
			</td>
			<td style="width:190px; padding:30px; border-left:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf; vertical-align:top">
				<!-- 스크랩한 이력서에 평점,메모 남기기 -->
				<form action="scrap.php" name="memo_<?=$_data['Data']['bNumber']?>" target="j_blank" method="post">
					<input type="hidden" name="mode" id="mode_<?=$_data['Data']['bNumber']?>" value="com_memo" target="j_blank">
					<input type="hidden" name="pNumber" id="pNumber_<?=$_data['Data']['bNumber']?>" value="<?=$_data['Data']['pNumber']?>">
					<input type="hidden" name="cNumber" id="cNumber_<?=$_data['Data']['bNumber']?>" value="<?=$_data['Data']['cNumber']?>">
					<input type="hidden" name="point" id="point_<?=$_data['Data']['bNumber']?>"  value="<?=$_data['Data']['bPoint']?>">
					<div style="border:1px solid #ccc; background:#f9f9fb;">
						<textarea name="memo" id="memo_<?=$_data['Data']['bNumber']?>" style="background:#fafafa; height:90px; padding:15px; line-height:160%; font-family:'굴림'; color:#888; border:none; resize:none"><?=$_data['Data']['bMemo']?></textarea>
					</div>
					<div class="basic_<?=$_data['Data']['bNumber']?>" data-average="<?=$_data['Data']['bPoint']?>" data-id="1" style="margin:15px auto 15px auto;"></div>
					<input type="image" src="img/btn_memosave.gif" alt="저장하기" style="cursor:pointer; width:100%;">
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