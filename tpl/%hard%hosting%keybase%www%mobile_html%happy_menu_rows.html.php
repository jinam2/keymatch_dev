<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 13:51:50 */
function SkyTpl_Func_3413653775 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<strong>
	<a href='<?=$_data['Menu']['menu_link']?>' target='<?=$_data['Menu']['menu_target']?>' style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><?=$_data['Menu']['menu_name']?></a>
</strong>
<?=$_data['하부메뉴']?>
<? }
?>