<? /* Created by SkyTemplate v1.1.0 on 2023/03/22 09:51:33 */
function SkyTpl_Func_2692882913 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<style type="text/css">
	#id_check_msg {display:none;}
	#nick_check_msg {display:none;}
	.guide_txt{display:none}
</style>
<h2 class="noto500 font_25" style="background:#efefef; padding:15px 0 15px 20px; margin:0; color:#000; letter-spacing:-1px;">
	<?=$_data['GROUP']['group_name']?>

</h2>
<table cellspacing="0" cellspacing="0" style="table-layout:fixed; width:100%;  border-collapse: collapse;" class="memview">
<?=$_data['폼내용']?>

</table>
<p align="center" style="margin:30px 0; text-align:center">
	<input type="button" value="확인" onClick="self.close();" class="btn_ok" style="width:150px; height:45px; background:url('./img/btn_ok.gif') 0 0 no-repeat; cursor:pointer; text-indent:-1000px">
</p>

<? }
?>