<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 16:53:16 */
function SkyTpl_Func_3486652398 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
	<tr>
		<td style="border:1px solid #dfdfdf; border-left:0 none; text-align:center; letter-spacing:-1.2px; background:#fafafa; padding:35px 0; cursor:pointer" class="font_18 noto400" onclick="location.href='member_guin.php?type=all'">
			<span style="display:block">
				<a href="member_guin.php?type=all">전체 초빙공고</a>
			</span>
			<div style="display:inline-block; margin:0 auto; padding-top:15px">
				<span style="width:4px; height:38px; float:left; display:inline-block; background:url('./img/skin_icon/make_icon/skin_icon_703.jpg') 0 0 no-repeat">
				</span>
				<span style="color:#fff; float:left; padding:0 15px 0 9px; height:38px; line-height:38px; background:url('./img/skin_icon/make_icon/skin_icon_704.jpg') right 0 repeat-x" class="font_24 noto500">
					<a href="member_guin.php?type=all" style="color:#fff"><?=$_data['COMMEMBER']['guin_total_cnt_comma']?></a>
				</span>
			</div>
		</td>
		<td style="border:1px solid #dfdfdf; border-left:1px solid #fff !important; text-align:center; letter-spacing:-1.2px; background:#fafafa; padding:35px 0; cursor:pointer" class="font_18 noto400" onclick="location.href='member_guin.php'">
			<span style="display:block">
				<a href="member_guin.php">진행중인 초빙공고</a>
			</span>
			<div style="display:inline-block; margin:0 auto; padding-top:15px">
				<span style="width:4px; height:38px; float:left; display:inline-block; background:url('./img/count_line_bg_01.png') 0 0 no-repeat">
				</span>
				<span style="color:#fff; float:left; padding:0 15px 0 9px; height:38px; line-height:38px; background:url('./img/count_line_bg_02.png') right 0 repeat-x" class="font_24 noto500">
					<a href="member_guin.php" style="color:#fff"><?=$_data['COMMEMBER']['ing_cnt_comma']?></a>
				</span>
			</div>
		</td>
		<td style="border:1px solid #dfdfdf; border-left:1px solid #fff !important; text-align:center; letter-spacing:-1.2px; background:#fafafa; padding:35px 0; cursor:pointer" class="font_18 noto400" onclick="location.href='member_guin.php?type=magam'">
			<span style="display:block">
				<a href="member_guin.php?type=magam">마감된 초빙공고</a>
			</span>
			<div style="display:inline-block; margin:0 auto; padding-top:15px">
				<span style="width:4px; height:38px; float:left; display:inline-block; background:url('./img/count_line_bg_01.png') 0 0 no-repeat">
				</span>
				<span style="color:#fff; float:left; padding:0 15px 0 9px; height:38px; line-height:38px; background:url('./img/count_line_bg_02.png') right 0 repeat-x" class="font_24 noto500">
					<a href="member_guin.php?type=magam" style="color:#fff"><?=$_data['COMMEMBER']['magam_cnt_comma']?></a>
				</span>
			</div>
		</td>
		<td style="border:1px solid #dfdfdf; border-left:1px solid #fff !important; text-align:center; letter-spacing:-1.2px; background:#fafafa; padding:35px 0; cursor:pointer" class="font_18 noto400" onclick="location.href='com_guin_want.php?mode=perview'">
			<span style="display:block">
				<a href="com_guin_want.php?mode=perview">면접제의 인재</a>
			</span>
			<div style="display:inline-block; margin:0 auto; padding-top:15px">
				<span style="width:4px; height:38px; float:left; display:inline-block; background:url('./img/skin_icon/make_icon/skin_icon_706.jpg') 0 0 no-repeat">
				</span>
				<span style="color:#fff; float:left; padding:0 15px 0 9px; height:38px; line-height:38px; background:url('./img/skin_icon/make_icon/skin_icon_707.jpg') right 0 repeat-x" class="font_24 noto500">
					<a href="com_guin_want.php?mode=perview" style="color:#fff"><?=$_data['COMMEMBER']['interview_cnt_comma']?></a>
				</span>
			</div>
		</td>
		<td style="border:1px solid #dfdfdf; border-left:1px solid #fff !important; text-align:center; letter-spacing:-1.2px; background:#fafafa; padding:35px 0; cursor:pointer" class="font_18 noto400" onclick="location.href='com_guin_want.php?mode=interview'">
			<span style="display:block">
				<a href="com_guin_want.php?mode=interview">입사제의 인재</a>
			</span>
			<div style="display:inline-block; margin:0 auto; padding-top:15px">
				<span style="width:4px; height:38px; float:left; display:inline-block; background:url('./img/count_line_bg_01.png') 0 0 no-repeat">
				</span>
				<span style="color:#fff; float:left; padding:0 15px 0 9px; height:38px; line-height:38px; background:url('./img/count_line_bg_02.png') right 0 repeat-x" class="font_24 noto500">
					<a href="com_guin_want.php?mode=interview" style="color:#fff"><?=$_data['COMMEMBER']['req_cnt_comma']?></a>
				</span>
			</div>
		</td>
		<td style="border:1px solid #dfdfdf; border-left:1px solid #fff; border-right:0 none; text-align:center; letter-spacing:-1.2px; background:#fafafa; padding:35px 0; cursor:pointer" class="font_18 noto400" onclick="location.href='guzic_list.php?file=member_guin_scrap'">
			<span style="display:block">
				<a href="guzic_list.php?file=member_guin_scrap">스크랩한 인재</a>
			</span>
			<div style="display:inline-block; margin:0 auto; padding-top:15px">
				<span style="width:4px; height:38px; float:left; display:inline-block; background:url('./img/count_line_bg_01.png') 0 0 no-repeat">
				</span>
				<span style="color:#fff; float:left; padding:0 15px 0 9px; height:38px; line-height:38px; background:url('./img/count_line_bg_02.png') right 0 repeat-x" class="font_24 noto500">
					<a href="guzic_list.php?file=member_guin_scrap" style="color:#fff"><?=$_data['COMMEMBER']['scrap_cnt1_comma']?></a>
				</span>
			</div>
		</td>
	</tr>
</table>

</div>


<? }
?>