<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:06 */
function SkyTpl_Func_4204379961 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<div class="hr_listing_01" style="margin:0 20px 20px;">
	<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>">
		<b>
			<img src="<?=$_data['큰이미지']?>">
		</b>
		<div>
			<p>
				<b><?=$_data['Data']['user_name_cut']?></b>
				<span class="ellipsis_line1"><?=$_data['Data']['job_type']?></span>
			</p>
			<p>
				<strong class="ellipsis_line1">
								<?=$_data['Data']['title']?>

				</strong>
				<span><?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?> / <?=$_data['Data']['grade_lastgrade']?></span>
			</p>
		</div>
	</a>
</div>
<script>all_search_result = 'ok'; // 검색결과 나왔다는 확인용 변수값에 ok값 넣기</script>

<? }
?>