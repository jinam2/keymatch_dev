<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 11:08:00 */
function SkyTpl_Func_1879211887 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="JavaScript">

				<!--
				var stabSPhoto_on = new Array() ;
				var stabSPhoto_off = new Array() ;
				for (i=1; i<=8; i++){
				 stabSPhoto_on[i] = new Image() ;
				 stabSPhoto_on[i].src = "img/bt_myroom_com_" + i + "_1.gif" ;
				 stabSPhoto_off[i] = new Image() ;
				 stabSPhoto_off[i].src = "img//bt_myroom_com_" + i + "_2.gif" ;
				}
				var stabSPhotoImgName;

				function stabSPhotoAct(){
				 for (i=1; i<=8; i++){
				  stabSPhotoImgName = "stabSPhoto" + i ;
				  document.images[stabSPhotoImgName].src = stabSPhoto_off[i].src ;
				 }
				 stabSPhotoImgName = "stabSPhoto" + arguments[0] ;
				 document.images[stabSPhotoImgName].src = stabSPhoto_on[arguments[0]].src ;
				}
				//-->
</script>

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
<?call_now_nevi('<a href="happy_member.php?mode=mypage">마이페이지</a> > 전체채용정보') ?>


<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	채용공고관리
	<span style="position:absolute; top:0; right:0">
		<?include_template('happy_member_mypage_com_head.html') ?>


		<a href="member_option_pay.php?mode=pay">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; box-sizing:border-box; background:#fff; padding:3px 15px; border-radius:15px;"><i style="font-style:normal; color:#<?=$_data['배경색']['기본색상']?>;">AD</i> 유료옵션신청</span>
		</a>		
		<a href="guin_regist.php">
			<span style="display:inline-block; font-size:15px; color:#fff; background:#<?=$_data['배경색']['기본색상']?>; padding:3px 15px; border-radius:15px;">채용공고등록</span>
		</a>
	</span>
</div>
<?include_template('my_point_jangboo_com.html') ?>


<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>전체 인재정보
</h3>
<?include_template('my_head_guin.html') ?>


<div style="border-top:1px solid #dfdfdf; margin-top:20px">
	<?echo guin_extraction_myreg('총7개','가로1개','제목길이30자','전체','member_guin_list.html','사용함') ?>

</div>
<div style="text-align:center; ">
<?=$_data['구인리스트페이징']?>

</div>



<? }
?>