<? /* Created by SkyTemplate v1.1.0 on 2023/03/30 15:04:44 */
function SkyTpl_Func_3592757235 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('마이페이지 > 채용공고 열람관리') ?>


<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	입사지원관리
	<span style="position:absolute; top:5px; right:0">
		<a href="html_file_per.php?file=my_guin_activities.html" title="취업활동 증명서">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">취업활동 증명서</span>
		</a>
		<a href="html_file_per.php?mode=per_guin_view" title="채용공고 열람관리">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">채용공고 열람관리</span>
		</a>
		<a href="per_no_view_list.php" title="이력서 열람불가 설정">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">이력서 열람불가 설정</span>
		</a>
		<a href="per_want_search.php?mode=setting_form" title="맞춤 채용공고 설정">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">맞춤 채용공고 설정</span>
		</a>
		<a href="per_want_search.php?mode=list" title="맞춤 채용공고">
			<span  style="display:inline-block; font-size:15px; color:#fff; background:#<?=$_data['배경색']['기본색상']?>; padding:3px 15px; border-radius:15px;">맞춤채용공고</span>
		</a>
	</span>
</div>

<?include_template('my_point_jangboo_per2.html') ?>


<p class="font_13 noto400" style="color:#797979; border:1px solid #dfdfdf; background:#f7f7f7; margin:20px 0 0 0; padding:15px; line-height:18px; letter-spacing:-1px">
	아래 출력되는 채용정보 리스트는 <span class="noto500" style='color:#333'>채용정보열람 횟수</span>를 기준으로해서 채용정보 상세보기 페이지에서 <span class="noto500" style='color:#333'>[채용정보열람]</span> 버튼을 클릭하여 해당 채용정보를 볼 수 있게된 채용정보들을 리스트로 출력하여 줍니다.<br>
	<span class="noto500" style='color:#333'>채용정보 열람기간</span>으로 유료서비스를 이용중인 경우에는 아래 채용정보 리스트에는 출력되지 않습니다.
</p>

<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>채용공고 열람관리
</h3>


<div><?guin_extraction_ajax('총100개','가로1개','제목길이999자','자동','자동','자동','자동','일반','열람가능','mypage_rows_recruit_view.html','누락0개','사용함') ?></div>
<div align="center"><?=$_data['페이징']?></div>
<? }
?>