<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:06 */
function SkyTpl_Func_1130521809 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="guzic_focus_list">
	<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>" style="color:#666666">
		<div>
			<span><?=$_data['Data']['job_where']?></span>
			<strong class="ellipsis_line2">
								<?=$_data['Data']['title_cut']?>

				<?=$_data['Data']['adult_guzic_icon']?>

			</strong>
			<p class="ellipsis_line1"><?=$_data['Data']['job_type_sub1']?><?=$_data['Data']['job_type_sub2']?><?=$_data['Data']['job_type_sub3']?></p>	
		</div>
		<div>			
			<img src="<?=$_data['작은이미지']?>">
			<p>
				<span><?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?>/ <?=$_data['Data']['grade_lastgrade']?></span>
				<b><?=$_data['Data']['user_name_cut']?> <small>(<?=$_data['Data']['user_prefix']?>/<?=$_data['Data']['age']?>세)<?=$_data['OPTION']['freeicon']?></small></b>
			</p>		
		</div>
	</a>
</div>

<script>all_search_result = 'ok'; // 검색결과 나왔다는 확인용 변수값에 ok값 넣기</script>

<? }
?>