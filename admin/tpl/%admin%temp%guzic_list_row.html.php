<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 08:58:26 */
function SkyTpl_Func_3192844098 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div id='list_style'>
	<table cellspacing='0' cellpadding='0' border='0' class='b_border' style='table-layout:fixed; width:100%'>
	<colgroup>
	<col style='width:10%;'></col>
	<col></col>
	<col style='width:10%;'></col>
	<col style='width:8%;'></col>
	<col style='width:8%;'></col>
	<col style='width:15%;'></col>
	<col style='width:12%;'></col>
	</colgroup>
	<tr>
		<td class='b_border_td'><input type='checkbox' name=Tnumber[] id=Tnumber[] value="<?=$_data['Data']['number']?>"> <img src="<?=$_data['작은이미지']?>" width="60" border='0' align='absmiddle' id="docimg_<?=$_data['Data']['number']?>"></td>
		<td class='b_border_td'>
			<font color='#0080FF'><b>[<?=$_data['Data']['user_name']?>/<?=$_data['Data']['user_id']?>]</b></font> (<?=$_data['Data']['age']?>) / <?=$_data['Data']['user_prefix']?> <?=$_data['Data']['display_print']?>

			<div style='padding:5px 0 5px 0;'><?=$_data['OPTION']['bgcolor1']?><a href="../document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>" target='_blank' style="color:#676565; font-family:'돋움'" class="font_14"><?=$_data['OPTION']['color']?><?=$_data['OPTION']['bolder']?><?=$_data['Data']['title_cut']?></a> <?=$_data['OPTION']['bgcolor2']?></div>
			<span style="margin-top:5px; display:block">
				<?=$_data['OPTION']['user_photo']?> <?=$_data['OPTION']['icon']?>

			</span>
		</td>
		<td class='b_border_td' style="text-align:center;"><?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?></td>
		<td class='b_border_td' style='text-align:center;'><?=$_data['Data']['logo_change']?></td>
		<td class='b_border_td' style='text-align:center;'><a href='guzic_option.php?action=option&number=<?=$_data['Data']['number']?>' class="btn_small_blue">옵션수정</a></td>
		<td class='b_border_td' style='text-align:center;'><?=$_data['Data']['regdate']?></td>
		<td class='b_border_td' style='text-align:center;'>

			<div style='margin-bottom:12px;'><a href='../document.php?mode=modify&subMode=type1&number=<?=$_data['Data']['number']?>&history=admin' target='_blank' class='btn_small_red'>수정</a> <a href="javascript:guzicdel('guzic_del.php?number=<?=$_data['Data']['number']?>');" class='btn_small_dark'>삭제</a></div>
			<div style='margin-bottom:12px;'><a href='admin_online_doc.php?guzic_number=<?=$_data['Data']['number']?>' class='btn_small_gray'>입사<strong style='color:#1686e5;'>지원</strong>내역</a></div>
			<div><a href='admin_online_doc_request.php?mode=guzic&guzic_number=<?=$_data['Data']['number']?>' class='btn_small_gray'>입사<strong style='color:#e01313;'>요청</strong>내역</a></div>

		</td>
	</tr>
	</table>
</div>

<? }
?>