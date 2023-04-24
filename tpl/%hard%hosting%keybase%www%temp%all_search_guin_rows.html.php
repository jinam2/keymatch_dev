<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:06 */
function SkyTpl_Func_1727054700 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div>
	<ul>
		<li style="width:0;"><?=$_data['스크랩버튼']?></li>
		<li>
			<a href="guin_detail.php?num=<?=$_data['Data']['number']?>&pg=<?=$_data['pg']?>&cou=0&action=search&area_read=&jobclass_read=&edu_read=&career_read=&gender_read=&title_read=&type_read=&pay_read=">
				<b><?=$_data['Data']['name']?> <?=$_data['Data']['adult_guin_icon']?> <span class="comsize_icon" style="border:1px solid #<?=$_data['배경색']['기본색상']?>; color:#<?=$_data['배경색']['기본색상']?>;"><?=$_data['Data']['HopeSize']?></span></b>			
				<strong><?=$_data['Data']['bgcolor1']?><?=$_data['Data']['title']?><?=$_data['Data']['bgcolor2']?></strong>
			</a>
			<p><?=$_data['Data']['freeicon_com_out']?> <?=$_data['Data']['우대조건2']?> <?=$_data['Data']['식사제공2']?> <?=$_data['Data']['보너스2']?> <?=$_data['Data']['주5일근무2']?> </p>
		</li>
		<li>
			<span><?=$_data['Data']['si1']?> <?=$_data['Data']['gu1']?><br>	<?=$_data['Data']['underground1']?> <?=$_data['Data']['underground2']?></span>
		</li>
		<li>
			<span><?=$_data['Data']['guin_career']?><br><?=$_data['Data']['guin_edu']?></span>			
		</li>
		<li>
			<span class="d_day"><?=$_data['Data']['guin_end_date']?></span>
			<a href="guin_detail.php?num=<?=$_data['Data']['number']?>&pg=<?=$_data['pg']?>&cou=0&action=search&area_read=&jobclass_read=&edu_read=&career_read=&gender_read=&title_read=&type_read=&pay_read=">
				<span style="border:1px solid #<?=$_data['배경색']['기본색상']?>; color:#<?=$_data['배경색']['기본색상']?>;">입사지원</span>
			</a>
		</li>
	</ul>	
</div>
<!-- { {NEW.guin_end_date_dday} } -->
<script>all_search_result = 'ok'; // 검색결과 나왔다는 확인용 변수값에 ok값 넣기</script>
<? }
?>