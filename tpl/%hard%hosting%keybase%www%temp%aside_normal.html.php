<? /* Created by SkyTemplate v1.1.0 on 2023/04/18 13:42:24 */
function SkyTpl_Func_3417755397 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellspacing="0" cellpadding="0" style="width:100%; border:1px solid #dcdfe5;">
	<tr>
		<td>
			<table width="100%" cellspacing="0" style="border-collapse:collapse;">
				<tr>
					<td style="border-bottom:1px solid #eaeaea; height:45px; background:#f8f8f8">
						<span style="padding-left:15px; letter-spacing:-1px; color:#333;" class="font_16 noto400"><span style="color:#<?=$_data['배경색']['서브색상']?>;">직종별</span> 초빙정보</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="border-bottom:1px solid #eaeaea; padding: 12px 15px;">
						<?make_category_jikjong_list('가로1개','100자','구인','guin_tasklist_mainrows.html','all_search_aside_tasklist_rows.html','카운터출력함') ?>

					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" cellspacing="0" style="border-collapse:collapse;">
				<tr>
					<td style="border-bottom:1px solid #eaeaea; height:45px; background:#f8f8f8">
						<span style="padding-left:15px; letter-spacing:-1px; color:#333;" class="font_16 noto400"><span style="color:#<?=$_data['배경색']['서브색상']?>;">고용형태별</span> 초빙정보</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="border-bottom:1px solid #eaeaea; padding: 12px 15px;">
						<?search_group('고용형태별','가로1개','세로100개','all_search_asied_guin_rows.html') ?>

					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" cellspacing="0" style="border-collapse:collapse;">
				<tr>
					<td style="border-bottom:1px solid #eaeaea; height:45px; background:#f8f8f8">
						<span style="padding-left:15px; letter-spacing:-1px; color:#333;" class="font_16 noto400"><span style="color:#<?=$_data['배경색']['서브색상']?>;">경력별</span> 초빙정보</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="border-bottom:1px solid #eaeaea; padding: 12px 15px;">
						<?search_group('경력별','가로1개','세로100개','all_search_asied_career_rows.html') ?>

					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<?echo happy_banner('문의배너','배너제목','랜덤') ?>

		</td>
	</tr>
</table>

<div id="rank_container" class="scrollMoveBox2">
	<!--인기검색어-->
	<table width="100%" cellspacing="0" style="border:1px solid #dcdfe5; border-top:none; background:#fff">
	<tr>
		<td style="border-bottom:1px solid #eaeaea; height:45px; background:#f8f8f8;">
			<span style="padding-left:15px; letter-spacing:-1px; color:#333;" class="font_16 noto400">실시간 인기검색어</span>
		</td>
	</tr>
	<tr>
		<td class="search_talent_rank" style="padding:10px 18px 10px 18px">
			<?keyword_rank_read_roll('15개','10개','keyword_html_roll_search.html','keyword_html_roll_sub_search.html','속도100ms','멈춤시간3000ms','fade','true') ?>

		</td>
	</tr>
	</table>
	<!--인기검색어-->
	
</div>
<? }
?>