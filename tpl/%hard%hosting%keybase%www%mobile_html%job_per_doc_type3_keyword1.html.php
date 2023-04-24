<? /* Created by SkyTemplate v1.1.0 on 2023/03/22 15:39:33 */
function SkyTpl_Func_3523504894 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<span class='h_form' style="display:inline-block; padding-bottom:5px;"><label for='job_keyword<?=$_data['key']?>' class="h-check"><input type="checkbox" name="job_keyword[]" value="<?=$_data['key']?>" id="job_keyword<?=$_data['key']?>" onClick="return checkSize(this.checked,'<?=$_data['key']?>')" style='border:0px solid; background:#FFF; width:14px; height:14px;' <?=$_data['checked']?>><span></span></label></span>
<label for='job_keyword<?=$_data['key']?>' style='cursor:pointer; margin-left:3px'><?=$_data['key']?></label>
<? }
?>