<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 15:33:50 */
function SkyTpl_Func_2200113275 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="sub_menu_padding" style="width:100%; padding-bottom:18px;" >
	<a href='<?=$_data['Menu']['menu_link']?>'target='<?=$_data['Menu']['menu_target']?>'  title="<?=$_data['Menu']['menu_name']?>" style="color:#8a8a8a; letter-spacing:-1px; display:block; text-align:left; font-size:15px; padding-left:20px; line-height:15px; height:15px;" class="noto400">
		<?=$_data['Menu']['menu_name']?> <?=$_data['Menu']['new_icon']?> </a>
</div>
<? }
?>