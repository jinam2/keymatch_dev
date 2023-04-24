<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 10:19:14 */
function SkyTpl_Func_830526906 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="border-bottom:1px solid #ddd; padding-top:15px">
	<table cellpadding="0" cellspacing="0" style="width:100%" onclick="location.href='./guin_detail.php?num=<?=$_data['GUIN_INFO']['number']?>'">
		<tr>
			<td style="text-align:left; letter-spacing:-1.5px; color:#333; font-weight:bold; height:28px" class="font_18 noto400">
				<span class="ellipsis_line1"><?=$_data['GUIN_INFO']['guin_title']?></span>
			</td>
		</tr>
		<tr>
			<td style="text-align:left; letter-spacing:-1.5px; height:36px" class="font_14 noto400">
				<span style="color:#fc8476; vertical-align:middle"><?=$_data['GUIN_INFO']['guin_end_date']?></span>
				<span class="font_6" style='vertical-align:middle; display:inline-block; margin:0 5px; color:#ddd'>|</span>
				<span style="letter-spacing:0; vertical-align:middle"><?=$_data['GUIN_INFO']['guin_career']?></span>
				<span class="font_6" style='vertical-align:middle; display:inline-block; margin:0 5px; color:#ddd'>|</span>
				<span style="vertical-align:middle; font-weight:bold"><?=$_data['GUIN_INFO']['guin_end_text']?></span>
			</td>
		</tr>
		<tr>
			<td style="text-align:right; letter-spacing:-1.5px; color:#<?=$_data['배경색']['모바일_기본색상']?>" class="noto400 font_14">
				등록일 : <span class="font_tahoma" style="letter-spacing:0; "><?=$_data['GUIN_INFO']['guin_date']?></span>
			</td>
		</tr>
	</table>
	<div style="padding:13px 0; bakcground:#fcfcfc; border-top:1px solid #e8e8e8; margin-top:10px">
		<table cellspacing="0" cellpadding="0"  style="width:100%; table-layout:fixed; border-collapse:collapse;">
			<tr>
				<td style="text-align:center">
					<a href="guzic_list.php?file=member_guin_chong&number=<?=$_data['GUIN_INFO']['number']?>" style="">
						<span class="font_15 noto400" style="display:block; margin-bottom:5px;">
							총지원자
						</span>
						<span class="font_16 font_tahoma" style="padding-top:5px; color:#<?=$_data['배경색']['모바일_서브색상']?>">
							<?=$_data['GUIN_STATS']['total_jiwon']?><span class="noto400">명</span>
						</span>
					</a>
				</td>
				<td style="text-align:center; border-left:1px solid #e9e9e9; border-right:1px solid #e9e9e9">
					<a href="guzic_list.php?file=member_guin_noview&number=<?=$_data['GUIN_INFO']['number']?>&myroom=&read_ok=N">
						<span class="font_15 noto400" style="display:block; margin-bottom:5px;">
							미열람
						</span>
						<span class="font_16 font_tahoma" style="padding-top:5px; color:#<?=$_data['배경색']['모바일_서브색상']?>"><?=$_data['GUIN_STATS']['total_mi']?><span class="noto400">명</span></span>
					</a>
				</td>
				<td style="text-align:center">
					<a href="guzic_list.php?file=member_guin_ok&number=<?=$_data['GUIN_INFO']['number']?>&myroom=&doc_ok=Y">
						<span class="font_15 noto400" style="display:block; margin-bottom:5px;">
							예비합격자
						</span>
						<span class="font_16 font_tahoma" style="padding-top:5px; color:#<?=$_data['배경색']['모바일_서브색상']?>">
							<?=$_data['GUIN_STATS']['total_pre_pass']?><span class="noto400">명</span>
						</span>
					</a>
				</td>
			</tr>
		</table>
	</div>
</div>






<? }
?>