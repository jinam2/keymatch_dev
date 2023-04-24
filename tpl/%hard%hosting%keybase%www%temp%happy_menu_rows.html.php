<? /* Created by SkyTemplate v1.1.0 on 2023/03/06 16:47:03 */
function SkyTpl_Func_563160360 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<a href='<?=$_data['Menu']['menu_link']?>' target='<?=$_data['Menu']['menu_target']?>' class="menu_color_<?=$_data['Count']?> noto400 font_17" onMouseOut="change_main_top_close('<?=$_data['Count']?>')" onmouseover="change_main_top('<?=$_data['Count']?>');"  style="color:#000; "><?=$_data['Menu']['menu_name']?></a>
<? }
?>