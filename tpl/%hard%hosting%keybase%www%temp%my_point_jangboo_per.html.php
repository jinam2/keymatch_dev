<? /* Created by SkyTemplate v1.1.0 on 2023/03/10 10:14:35 */
function SkyTpl_Func_2153687555 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
	<tr>
		<td style="border:1px solid #dfdfdf; border-left:0 none; text-align:center; letter-spacing:-1px; background:#fafafa; padding:35px 0; cursor:pointer" class="font_18 noto400" onclick="location.href='html_file_per.php?file=member_regph.html'">
			<span style="display:block">
				<a href="html_file_per.php?file=member_regph.html">전체 이력서</a>
			</span>
			<div style="display:inline-block; margin:0 auto; padding-top:15px">
				<span style="width:4px; height:38px; float:left; display:inline-block; background:url('./img/skin_icon/make_icon/skin_icon_706.jpg') 0 0 no-repeat">
				</span>
				<span style="float:left; padding:0 15px 0 9px; height:38px; line-height:38px; background:url('./img/skin_icon/make_icon/skin_icon_707.jpg') right 0 repeat-x" class="font_24 noto500">
					<a href="html_file_per.php?file=member_regph.html" style="color:#fff"><?=$_data['PERMEMBER']['guzic_total_cnt_comma']?></a>
				</span>
			</div>
		</td>
		<td style="border:1px solid #dfdfdf; border-left:1px solid #fff !important; text-align:center; letter-spacing:-1px; background:#fafafa; padding:35px 0; cursor:pointer" class="font_18 noto400" onclick="location.href='html_file_per.php?file=member_regph_ing.html'">
			<span style="display:block">
				<a href="html_file_per.php?file=member_regph_ing.html">공개중인 이력서</a>
			</span>
			<div style="display:inline-block; margin:0 auto; padding-top:15px">
				<span style="width:4px; height:38px; float:left; display:inline-block; background:url('./img/count_line_bg_01.png') 0 0 no-repeat">
				</span>
				<span style="float:left; padding:0 15px 0 9px; height:38px; line-height:38px; background:url('./img/count_line_bg_02.png') right 0 repeat-x" class="font_24 noto400">
					<a href="html_file_per.php?file=member_regph_ing.html" style="color:#fff"><?=$_data['PERMEMBER']['use_cnt_comma']?></a>
				</span>
			</div>
		</td>
		<td style="border:1px solid #dfdfdf; border-left:1px solid #fff !important; text-align:center; letter-spacing:-1px; background:#fafafa; padding:35px 0; cursor:pointer" class="font_18 noto400" onclick="location.href='html_file_per.php?file=member_regph_stop.html'">
			<span style="display:block">
				<a href="html_file_per.php?file=member_regph_stop.html">비공개 이력서</a>
			</span>
			<div style="display:inline-block; margin:0 auto; padding-top:15px">
				<span style="width:4px; height:38px; float:left; display:inline-block; background:url('./img/count_line_bg_01.png') 0 0 no-repeat">
				</span>
				<span style="float:left; padding:0 15px 0 9px; height:38px; line-height:38px; background:url('./img/count_line_bg_02.png') right 0 repeat-x" class="font_24 noto500">
					<a href="html_file_per.php?file=member_regph_stop.html" style="color:#fff"><?=$_data['PERMEMBER']['wait_cnt_comma']?></a>
				</span>
			</div>
		</td>

		<td style="border:1px solid #dfdfdf; border-left:1px solid #fff !important; text-align:center; letter-spacing:-1px; background:#fafafa; padding:35px 0; cursor:pointer" class="font_18 noto400" onclick="location.href='per_guin_want.php'">
			<span style="display:block">
				<a href="per_guin_want.php">입사제의</a>
			</span>
			<div style="display:inline-block; margin:0 auto; padding-top:15px">
				<span style="width:4px; height:38px; float:left; display:inline-block; background:url('./img/count_line_bg_01.png') 0 0 no-repeat">
				</span>
				<span style="float:left; padding:0 15px 0 9px; height:38px; line-height:38px; background:url('./img/count_line_bg_02.png') right 0 repeat-x" class="font_24 noto500">
					<a href="per_guin_want.php" style="color:#fff"><?=$_data['PERMEMBER']['req_cnt_comma']?></a>
				</span>
			</div>
		</td>
		<td style="border:1px solid #dfdfdf; border-left:1px solid #fff; text-align:center; letter-spacing:-1px; background:#fafafa; padding:35px 0; cursor:pointer" class="font_18 noto400" onclick="location.href='per_guin_want.php?mode=preview'">
			<span style="display:block">
				<a href="per_guin_want.php?mode=preview">면접제의</a>
			</span>
			<div style="display:inline-block; margin:0 auto; padding-top:15px">
				<span style="width:4px; height:38px; float:left; display:inline-block; background:url('./img/count_line_bg_01.png') 0 0 no-repeat">
				</span>
				<span style="font-weight:bold; float:left; padding:0 15px 0 9px; height:38px; line-height:38px; background:url('./img/count_line_bg_02.png') right 0 repeat-x" class="font_24 noto500">
					<a href="per_guin_want.php?mode=preview" style="color:#fff"><?=$_data['PERMEMBER']['interview_cnt_comma']?></a>
				</span>
			</div>
		</td>
		<td style="border:1px solid #dfdfdf; border-left:1px solid #fff !important;  border-right:0 none; text-align:center; letter-spacing:-1px; background:#fafafa; padding:35px 0" class="font_18 noto400">
			<span style="display:block">
				내이력서 열람수
			</span>
			<div style="display:inline-block; margin:0 auto; padding-top:15px">
				<span style="width:4px; height:38px; float:left; display:inline-block; background:url('./img/count_line_bg_01.png') 0 0 no-repeat">
				</span>
				<span style="color:#fff; font-weight:bold; float:left; padding:0 15px 0 9px; height:38px; line-height:38px; background:url('./img/count_line_bg_02.png') right 0 repeat-x" class="font_24 noto500">
					<?=$_data['PERMEMBER']['view_cnt_comma']?>

				</span>
			</div>
		</td>
	</tr>
</table>

</div>

<? }
?>