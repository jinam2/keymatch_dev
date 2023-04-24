<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 13:51:50 */
function SkyTpl_Func_2397351432 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="photo_gall">
	<a href="./bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&tb=<?=$_data['B_CONF']['tbname']?>">
		<img src="<?=$_data['BOARD']['thumb']?>" alt="게시물 썸네일 이미지">
	</a>
	<p>
		<a href="./bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&tb=<?=$_data['B_CONF']['tbname']?>">
			<strong><?=$_data['BOARD']['bbs_title_none']?></strong>
		</a>
		<span><?=$_data['BOARD']['bbs_date']?></span>
	</p>	
</div>
<? }
?>