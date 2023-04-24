<? /* Created by SkyTemplate v1.1.0 on 2023/04/17 19:13:44 */
function SkyTpl_Func_2982847642 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="padding-top:20px; border-bottom:1px solid #ddd; box-sizing:border-box;">
	<table cellpadding="0" cellspacing="0" style="width:100%" onclick="location.href='./guin_detail.php?num=<?=$_data['Data']['cNumber']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['GUIN_INFO']['guin_count']?>&clickChk=<?=$_data['clickChk']?>'">
		<tr>
			<td style="text-align:center;">
				<a href="./guin_detail.php?num=<?=$_data['Data']['cNumber']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['GUIN_INFO']['guin_count']?>&clickChk=<?=$_data['clickChk']?>" target="_blank"><img src="<?=$_data['GUIN_INFO']['logo']?>" alt="기관로고" width="80" height="36" onError="this.src='./img/img_noimage_100x36.jpg'" style="border:1px solid #dedede;"></a>
			</td>
		</tr>
		<tr>
			<td style="text-align:left; letter-spacing:-1.5px; color:#333; font-weight:500; height:28px; padding-top:10px" class="font_20 noto400">
				<span class="ellipsis_line1"><?=$_data['GUIN_INFO']['guin_title']?></span>
			</td>
		</tr>
		<tr>
			<td style="text-align:left; letter-spacing:-1.5px; padding:10px 0" class="font_16 noto400">
				<span style="vertical-align:middle"><?=$_data['채용지역정보']?></span>
			</td>
		</tr>
		<tr>
			<td style="text-align:left; letter-spacing:-1.5px;" class="font_16 noto400">
				<span style="vertical-align:middle"><?=$_data['GUIN_INFO']['guin_end_date']?></span>
				<span class="font_6" style='vertical-align:middle; display:inline-block; margin:0 5px; color:#ddd'>|</span>
				<span style="letter-spacing:0; vertical-align:middle"><?=$_data['GUIN_INFO']['guin_career']?></span>
				<span class="font_6"  style='vertical-align:middle; display:inline-block; margin:0 5px; color:#ddd'>|</span>
				<span style="color:#<?=$_data['배경색']['모바일_서브색상']?>; vertical-align:middle"><?=$_data['Data']['read_ok_info']?></span>
			</td>
		</tr>
	</table>
	<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; margin-top:20px; margin-bottom:20px" class="tb_st_btns">
		<tbody>
			<tr>
				<td >
					<span style="letter-spacing:-1.5px; display:block" onclick="location.href='document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>'" class="mobile_del_btn font_16 noto400">이력서보기</span>
				</td>
				<td >
					<span style="letter-spacing:-1.5px; "class="gray_btn2 font_16 noto400" ><?=$_data['Data']['OnlineCancelBtn']?></span>
				</td>
			</tr>
		</tbody>		
	</table>
</div>
<? }
?>