<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 11:08:07 */
function SkyTpl_Func_819793662 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table width="100%" cellspacing="0">
	<tr>
		<td width="60" align="center" class='h_form' style="border-left:1px solid #ccc; border-bottom:1px solid #ccc; border-right:1px solid #ccc ">
			<label class='h-radio'><input type="radio" name="guin_number" value="<?=$_data['Data']['number']?>" id="<?=$_data['Data']['number']?>"<?=$_data['checked_info']?>><span></span></label>
		</td>
		<td>
			<table cellspacing="0"  width="100%">
				<tr>
					<td class="noto400 font_16" style="width:100px; height:50px; padding-left:20px; background:#f5f7fb; border-bottom:1px solid #ccc; border-right:1px solid #ccc">제목</td>
					<td class="noto500 font_15" style="padding-left:20px; ;border-bottom:1px solid #ccc; border-right:1px solid #ccc; color:#<?=$_data['배경색']['기본색상']?>;">[<?=$_data['Data']['number']?>] <a href='./guin_detail.php?num=<?=$_data['Data']['number']?>' target="_blank" style="color:inherit;"><?=$_data['Data']['guin_title']?></a></td>
				</tr>
				<tr>
					<td class="noto400 font_16" style="width:100px; height:50px; padding-left:20px; background:#f5f7fb; border-bottom:1px solid #ccc; border-right:1px solid #ccc"">담당업무</td>
					<td class="noto400 font_15" style="padding-left:20px; ;border-bottom:1px solid #ccc; border-right:1px solid #ccc"><?=$_data['Data']['guin_work_content']?></td>
				</tr>
				<tr>
					<td class="noto400 font_16" style="width:100px; height:50px; padding-left:20px; background:#f5f7fb; border-bottom:1px solid #ccc; border-right:1px solid #ccc"">직 종</td>
					<td class="noto400 font_15" style="padding-left:20px; ;border-bottom:1px solid #ccc; padding:10px 0 10px 20px; border-right:1px solid #ccc "><?=$_data['Data']['guin_job']?></td>
				</tr>
				<tr>
					<td class="noto400 font_16" style="width:100px; height:50px; padding-left:20px; background:#f5f7fb; border-bottom:1px solid #ccc; border-right:1px solid #ccc"">키워드</td>
					<td class="noto400 font_15" style="padding-left:20px; ;border-bottom:1px solid #ccc; border-right:1px solid #ccc"><?=$_data['Data']['keyword']?></td>
				</tr>
			</table>

		</td>
	</tr>
</table>
<? }
?>