<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:49:15 */
function SkyTpl_Func_3300171733 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<span class="h_form" style="display:inline-block; padding-bottom:10px;">
	<label for="keyword_<?=$_data['key']?>" class="h-check"><input type="checkbox" name="job_keyword[]" id="keyword_<?=$_data['key']?>" value="<?=$_data['key']?>" onClick="return checkSize2(this.checked,'<?=$_data['key']?>')" <?=$_data['checked']?>><span class="noto400 font_14" style="vertical-align:middle;"><?=$_data['key']?></span></label>
</span>

<? }
?>