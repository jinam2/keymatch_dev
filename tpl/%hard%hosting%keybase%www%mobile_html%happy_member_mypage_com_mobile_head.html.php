<? /* Created by SkyTemplate v1.1.0 on 2023/04/17 19:13:44 */
function SkyTpl_Func_2013952715 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellspacing="0" cellpadding="0" class="mypage_tab" style="margin-top:25px">
	<tr>
		<td class="mypage_on" overClass="mypage_on" outClass="mypage_off" id="class_kwak_div_1" onClick="happy_tab_menu('class_kwak_div','1');" style="border-top:2px solid #d8d8d8;">
			전체 초빙공고</td>
		<td class="mypage_off" overClass="mypage_on" outClass="mypage_off" id="class_kwak_div_2" onClick="happy_tab_menu('class_kwak_div','2');" style="border-top:2px solid #d8d8d8; border-left:2px solid #d8d8d8; border-right:2px solid #d8d8d8">진행중인 초빙공고</td>
		<td class="mypage_off" overClass="mypage_on" outClass="mypage_off" id="class_kwak_div_3" onClick="happy_tab_menu('class_kwak_div','3');" style="border-top:2px solid #d8d8d8;">헤드헌팅 초빙공고</td>
	</tr>
</table>
<div style="padding:10px">
	<div id="class_kwak_div_layer_1">
		<?echo guin_extraction_myreg('총3개','가로1개','제목길이135자','전체','mypage_member_guin_list_rows.html','사용안함') ?>

		<div class="font_16 font_malgun" style="letter-spacing:-1px; margin-top:15px">
			<a href="member_guin.php?type=all" style="display:block; border:1px solid #bfbfbf; padding:10px 0; text-align:center">더보기</a>
		</div>
	</div>
	<div style="display:none;" id="class_kwak_div_layer_2">
		<?echo guin_extraction_myreg('총3개','가로1개','제목길이140자','진행중','mypage_member_guin_list_rows.html','사용안함') ?>

		<div class="font_16 font_malgun" style="letter-spacing:-1px; margin-top:15px">
			<a href="member_guin.php" style="display:block; border:1px solid #bfbfbf; padding:10px 0; text-align:center">더보기</a>
		</div>
	</div>
	<div style="display:none;" id="class_kwak_div_layer_3">
		<?echo guin_extraction_myreg('총3개','가로1개','제목길이140자','헤드헌팅','mypage_member_guin_list_rows.html','사용안함') ?>

		<div class="font_16 font_malgun" style="letter-spacing:-1px; margin-top:15px">
			<a href="company.php" style="display:block; border:1px solid #bfbfbf; padding:10px 0; text-align:center">더보기</a>
		</div>
	</div>
</div>
<? }
?>