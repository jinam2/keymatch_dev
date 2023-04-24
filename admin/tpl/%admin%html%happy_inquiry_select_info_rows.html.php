<? /* Created by SkyTemplate v1.1.0 on 2023/04/10 15:52:24 */
function SkyTpl_Func_909742135 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #e8e8e8;">
<tr>
	<td style="padding:10px 0px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<!-- 썸네일 -->
			<td align="left" width="85"><a href="javascript:void(0);" onclick="select_info(<?=$_data['Data']['number']?>);"><img src='<?echo happy_image('자동','가로85','세로45','로고사용안함','로고위치7번','퀄리티100','gif원본출력','img/noimg.gif','비율대로확대') ?>' style="border:1px solid #d8d8d8; width:85px; height:45px;"></a></td>
			<!-- 중간간격조절 -->
			<td align="left" style="padding-left:10px; font-size:11px; color:#666666; line-height:18px;">
				고유번호 : <a href="javascript:void(0);" onclick="select_info(<?=$_data['Data']['number']?>);"><?=$_data['Data']['number']?></a><BR>
				<a href="javascript:void(0);" onclick="select_info(<?=$_data['Data']['number']?>);"><span style="color:#666666;"><strong><?=$_data['Data']['guin_title']?></b></strong></a><BR>
				<?=$_data['카테고리정보']?>

			</td>
			<td align="center" width="100"><a href="javascript:void(0);" onclick="select_info(<?=$_data['Data']['number']?>);"><img src="../img/btn_inquiry_select_ok.gif" alt="채용정보지정" title="채용정보지정" border="0"></a></td>
		</tr>
		</table>
	</td>
</tr>
</table>

<? }
?>