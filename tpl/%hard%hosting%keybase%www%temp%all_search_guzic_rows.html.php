<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:06 */
function SkyTpl_Func_2950567839 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div>
	<ul>
		<li>
			<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>">
				<b class="ellipsis_line1"><?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?> | <?=$_data['Data']['grade_lastgrade']?> | <?=$_data['Data']['job_type']?></b>
				<strong class="ellipsis_line_1">
					<?=$_data['OPTION']['bgcolor1']?>

						<?=$_data['OPTION']['bolder']?>

							<?=$_data['OPTION']['color']?>

								<?=$_data['Data']['title']?><?=$_data['Data']['adult_guzic_icon']?> <?=$_data['OPTION']['user_photo']?> <?=$_data['OPTION']['icon']?>

							<?=$_data['OPTION']['color2']?>

						<?=$_data['OPTION']['bolder2']?>

					<?=$_data['OPTION']['bgcolor2']?>

				</strong>
			</a>
			<p><?=$_data['OPTION']['special2']?> <?=$_data['OPTION']['powerlink2']?> <?=$_data['OPTION']['focus2']?></p>
		</li>
		<li>
			<?=$_data['OPTION']['freeicon']?><big style="color:#333; letter-spacing:0;"><?=$_data['Data']['user_name_cut']?></big><span>(<?=$_data['Data']['user_prefix']?>ㆍ<?=$_data['Data']['age']?>세)</span>
		</li>
		<li>
			<span><?=$_data['Data']['job_where']?></span>			
		</li>
		<li>
			<big><?=$_data['Data']['regdate_cut']?></big><span>(수정일 : <?=$_data['Data']['modifydate_cut']?>)</span>
		</li>
	</ul>	
</div>

<script>all_search_result = 'ok'; // 검색결과 나왔다는 확인용 변수값에 ok값 넣기</script>
<? }
?>