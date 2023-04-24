<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:13 */
function SkyTpl_Func_987468539 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?=$_data['실시간롤링필수스크립트']?>

<style type="text/css">
	.vTicker {
		width: 100%;
	}
	.vTicker ul {
		width: 100%;
	}
	.vTicker > ul > li {
		display:block;
	}
	.hideuntilready{
		visibility:hidden;
	}
</style>

<div id="news-container<?=$_data['keyword_rank_read_roll_x']?>" class="vTicker hideuntilready">
	<style type="text/css">
		.rankIcon_1{background:#<?=$_data['배경색']['기본색상']?>; color:#fff;}
		.rankIcon_2{background:#fff; border:1px solid #<?=$_data['배경색']['기본색상']?>; color:#<?=$_data['배경색']['기본색상']?>;}
	</style>
	<ul>
		<?=$_data['실시간검색롤링내용']?>

	</ul>
</div>
<? }
?>