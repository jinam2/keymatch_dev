<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 16:53:53 */
function SkyTpl_Func_1684049942 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="javascript">
<!--
	function bbsdel2(strURL) {
		var msg = "삭제하시겠습니까?";
		if (confirm(msg)){
			window.location.href= strURL;

		}
	}
	-->
</script>
<script language="javascript">
<!--
	function magam(strURL) {
		var msg = "해당 구인정보를 마감하시겠습니까?";
		if (confirm(msg)){
			window.location.href= strURL;

		}
	}
	-->
</script>

<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	초빙공고관리
	<span style="position:absolute; top:0; right:0">
		<?include_template('happy_member_mypage_com_head.html') ?>

		<a href="member_option_pay.php?mode=pay">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; box-sizing:border-box; background:#fff; padding:3px 15px; border-radius:15px;"><i style="font-style:normal; color:#<?=$_data['배경색']['기본색상']?>;">AD</i> 유료옵션신청</span>
		</a>		
		<a href="guin_regist.php">
			<span style="display:inline-block; font-size:15px; color:#fff; background:#<?=$_data['배경색']['기본색상']?>; padding:3px 15px; border-radius:15px;">초빙공고등록</span>
		</a>
	</span>
</div>

<?include_template('my_point_jangboo_com.html') ?>

<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>진행중인 초빙정보
</h3>

<?include_template('my_head_guin.html') ?>


<div style="border-top:1px solid #dfdfdf; margin-top:20px">
	<?echo guin_extraction_myreg('총5개','가로1개','제목길이30자','진행중','member_guin_list.html','사용함') ?>

</div>
<table cellspacing="0" cellpadding="0" style="width:100%;">
	<tr>
		<td align="center"><?=$_data['구인리스트페이징']?></td>
	</tr>
</table>



<? }
?>