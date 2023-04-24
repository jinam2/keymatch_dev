<? /* Created by SkyTemplate v1.1.0 on 2023/03/09 13:42:44 */
function SkyTpl_Func_3230974367 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellpadding="0" cellspacing="0" style="width:100%; height:35px; border-bottom:1px solid #f9f9f9;">
<tr>
	<td  align="center"><?=$_data['Message']['checkbox']?></td>
	<td style="padding-left:5px;" class="font_12"><span style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap; width:300px;"><a href="<?=$_data['Message']['link']?>&file=message_view.html&adminMode=<?=$_data['_GET']['adminMode']?>"><font color="#888888"><?=$_data['Message']['message']?></a></span></td>
	<td style="width:120px;" class="smfont2" align="center"><?=$_data['Message']['sender_id']?></td>
	<td class="f_font2" style="width:120px; text-align:center; color:#888888;"><?=$_data['Message']['regdate_date2']?></td>
	<td style="width:55px;" align="center"><a href="#" Onclick="mesdel('<?=$_data['Message']['del_link']?>')"><img src="img/message/btn_message_del.gif" border="0" align="absmiddle"></a></td>
</tr>
</table>
<? }
?>