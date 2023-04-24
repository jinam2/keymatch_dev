<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 15:42:34 */
function SkyTpl_Func_1699740525 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<li>
	<b>[<?=$_data['rData']['language_title']?>]<?=$_data['rData']['language_check']?> <?=$_data['rData']['language_point']?> (점/급)</b>
	<p>
		<img src="mobile_img/graph<?=$_data['rData']['language_skill']?>.png" alt="<?=$_data['Data']['skill_search_han']?>">
		<span><?=$_data['rData']['language_skill_han']?></span>
	</p>
</li>
<? }
?>