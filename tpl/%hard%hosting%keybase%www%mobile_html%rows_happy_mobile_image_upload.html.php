<? /* Created by SkyTemplate v1.1.0 on 2023/03/22 15:39:34 */
function SkyTpl_Func_3660774039 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<div style="padding:2%; box-sizing:border-box; ">
<table cellpadding="0" cellspacing="0" border="0" >
	<tr>
		<td>
			<div style="position:relative; left:0; top:0;">
				<div style="position:absolute; left:0px; top:0px;">
					<img src="mobile_img/btn_img_delete.jpg" alt="이미지삭제" title="이미지삭제" id="<?=$_data['btn_img']?>" onclick="deleteOK(this);" style="cursor:pointer; width:25px">
				</div>
				<img id="<?=$_data['img_url_re_thumb_id']?>" src="<?=$_data['img_url_re_thumb']?>"  class="mobile_thumb"/>
			</div>
		</td>
	</tr>
	<tr>
		<td style="padding-top:3px;">
			<form id="<?=$_data['form_name']?>" name="<?=$_data['form_name']?>" class="">
				<input type="file" name="<?=$_data['input_type_file_name']?>" id="<?=$_data['input_type_file_name']?>" onchange="fileupload(this);" style="width:100px"/>
			</form>
		</td>
	</tr>
</table>
</div>
<? }
?>