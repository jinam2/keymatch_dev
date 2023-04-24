<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:06 */
function SkyTpl_Func_3442173823 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<div class="hire_listing_03">
	<a href="guin_detail.php?num=<?=$_data['Data']['number']?>&pg=<?=$_data['pg']?>&cou=0&action=search&area_read=&jobclass_read=&edu_read=&career_read=&gender_read=&title_read=&type_read=&pay_read=">
		<b><?=$_data['Data']['name']?></b>
		<strong><?=$_data['Data']['bgcolor1']?><?=$_data['Data']['title']?><?=$_data['Data']['bgcolor2']?></strong>		
	</a>
	<p>
		<?=$_data['Data']['guin_end_date']?>

		<b><?=$_data['스크랩버튼']?></b>
	</p>
</div>
<script>all_search_result = 'ok'; // 검색결과 나왔다는 확인용 변수값에 ok값 넣기</script>

<? }
?>