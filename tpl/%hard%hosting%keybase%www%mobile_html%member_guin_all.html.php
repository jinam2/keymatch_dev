<? /* Created by SkyTemplate v1.1.0 on 2023/03/28 17:36:26 */
function SkyTpl_Func_2599117640 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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
<h3 class="sub_tlt_st01" onclick="location.href='happy_member.php?mode=mypage'" style="padding-bottom:30px; border-bottom:1px solid #ddd; box-sizing:border-box;">
	<b style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><?=$_data['MEM']['user_name']?>님의 </b>
	<span>마이페이지</span>
</h3>
<div style="padding-top:20px;">
	<h3 class="m_tlt_m_01">
		<strong style="margin-bottom:20px; display:block;">전체 채용정보</strong>				
	</h3>
	<div style="border-bottom:1px solid #ddd;">
		<?echo guin_extraction_myreg('총20개','가로1개','제목길이150자','전체','member_guin_list.html','사용함') ?>

	</div>
	<div style="text-align:center;">
		<?=$_data['구인리스트페이징']?>

	</div>	
</div>

<? }
?>