<? /* Created by SkyTemplate v1.1.0 on 2023/04/11 10:35:11 */
function SkyTpl_Func_226240534 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="padding:10px 0;border-bottom:1px solid #dedede;text-align:left" onclick="location.href='./guin_detail.php?num=<?=$_data['Data']['number']?>&pg=<?=$_data['pg']?>&cou=0&action=search&area_read=&jobclass_read=&edu_read=&career_read=&gender_read=&title_read=&type_read=&pay_read='">
	<table style="width:100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td>
				<table style="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td valign="top" class="option_text"><b><?=$_data['Data']['com_name']?></b></td>
				</tr>
				<tr>
					<td class="con_text" style="padding:2px 0">
						<?=$_data['Data']['title']?>

					</td>
				</tr>
				<tr>
					<td class="con_text_s" style="padding-top:10px"><font color="#<?=$_data['배경색']['모바일']?>">~<?=$_data['Data']['guin_end_date']?></font>&nbsp;&nbsp;|&nbsp;&nbsp;<?=$_data['Data']['guin_career']?>&nbsp;&nbsp;|&nbsp;&nbsp;<?=$_data['Data']['guin_date']['0']?></td>
				</tr>
				</table>
			</td>
			<td style="width:20px">
				<img src="./mobile_img/btn_move_sign.gif">
			</td>
		</tr>
	</table>
</div>


<? }
?>