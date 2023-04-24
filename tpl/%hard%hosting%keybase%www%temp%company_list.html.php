<? /* Created by SkyTemplate v1.1.0 on 2023/03/21 09:54:42 */
function SkyTpl_Func_120116245 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	채용공고관리
	<span style="position:absolute; right:0">
		<?include_template('happy_member_mypage_com_head.html') ?>

		<a href="member_option_pay.php?mode=pay">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; box-sizing:border-box; padding:3px 15px; border-radius:15px;"><i style="color:#<?=$_data['배경색']['기본색상']?>; font-style:normal;">AD</i> 유료옵션신청</span>
		</a>
		<a href="guin_regist.php">
			<span style="display:inline-block; font-size:15px; color:#fff; background:#<?=$_data['배경색']['기본색상']?>; padding:3px 15px; border-radius:15px;">채용공고등록</span>
		</a>
	</span>
</div>

<div>
	<?include_template('my_point_jangboo_com.html') ?>

</div>

<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>헤드헌팅 기업정보
</h3>
<div style="border-top:1px solid #ddd;">	
<?newPaging_option('번호양쪽9개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

<?company_extraction_list('가로1개','세로10개','mypage_rows_company_list.html','내가등록한회사') ?>

</div>

<table width='100%' cellspacing="0">
	<tr>
		<td align="center" class="page" style="padding:0 0 30px"><?=$_data['페이징']?></td>
	</tr>
	<tr>
		<td style="text-align:center"><a href="?mode=add"><img src='img/btn_head_add.gif' alt='등록하기' title='등록하기' /></a></td>
	</tr>
</table>

<? }
?>