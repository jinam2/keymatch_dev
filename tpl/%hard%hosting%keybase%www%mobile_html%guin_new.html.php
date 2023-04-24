<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 15:20:36 */
function SkyTpl_Func_3526529900 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<style type="text/css">
	/* 페이지내 rows디자인 색생 변경을 위한 css입니다 */
	/* 서브페이지 우대 및 프리미엄 rows 삼각형 */
	.triangle1{width:75px; height:75px; position:absolute; top:0; right:0; color:#fff}
	.triangle1::after{
		position: absolute;
		top:0;
		right: calc(0% - 75px);
		content: " ";
		height: 0;
		z-index: 100;
		border-bottom: 75px solid;
		border-left: 75px solid rgba(0, 0, 0, 0);
		border-right: 75px solid rgba(0, 0, 0, 0);
		color: #<?=$_data['배경색']['모바일_서브색상']?>;
		transform: rotate(-180deg);
		-webkit-transform: rotate(-180deg);
		-moz-transform: rotate(-180deg);
		-o-transform: rotate(-180deg);
		-ms-transform: rotate(-180deg);
	}

	.triangle2{width:75px; height:75px; position:absolute; top:0; right:0; color:#fff}
	.triangle2::after{
		position: absolute;
		top:0;
		right: calc(0% - 75px);
		content: " ";
		height: 0;
		z-index: 100;
		border-bottom: 75px solid;
		border-left: 75px solid rgba(0, 0, 0, 0);
		border-right: 75px solid rgba(0, 0, 0, 0);
		color: #af9e67;
		transform: rotate(-180deg);
		-webkit-transform: rotate(-180deg);
		-moz-transform: rotate(-180deg);
		-o-transform: rotate(-180deg);
		-ms-transform: rotate(-180deg);
	}

	.txt{
		position:absolute;
		top:16px;
		right:0;
		color:#fff;
		z-index:1000;
		transform: rotate(45deg);
		-webkit-transform: rotate(45deg);
		-moz-transform: rotate(45deg);
		-o-transform: rotate(45deg);
		-ms-transform: rotate(45deg);
	}
	<!--관리자 색상 변경기능 을 위한 강제 스타일 빼면안됨-->
	.wodea_in .d_day{color:#<?=$_data['배경색']['서브색상']?>}
	.premium_in .d_day{color:#<?=$_data['배경색']['서브색상']?>}
	.sub_list_in .d_day{color:#<?=$_data['배경색']['서브색상']?>}
</style>
<script type="text/javascript">
		// <![CDATA[
		$(document).ready(function(){
			$('.cate_layer').hide();
			$('.cate_btn_1').toggle(function(){
				$('.cate_layer').css("display","block");
				$(".cate_btn_1").toggleClass("sch_btn_on");
			},
			function(){
				$('.cate_layer').css("display","none");
				$(".cate_btn_1").toggleClass("sch_btn_on");
			});
		});
	// ]]>
</script>
<h2 style="padding:20px 0; background:url('./mobile_img/m_tit_bg.gif') 0 0 repeat; text-align:center; letter-spacing:-1.5px; font-weight:bold; border-bottom:2px solid #dbdbdb; line-height:130%" class="font_24 font_malgun">
	<span style="color:#<?=$_data['배경색']['모바일_서브색상']?>">☆1차 카테고리명</span><br/>
	신입사원 채용정보
</h2>
<div class="snb_area" style="border-bottom:2px solid #878787; position:relative; background:url('./mobile_img/search_line_bg.gif') 0 bottom repeat">
	<table class="tbl snb" cellpadding="0" style="width:100%">
		<tr>
			<td style="color:#424242; padding:12px; letter-spacing:-1.5px;" class="font_20 font_malgun">채용정보 상세검색</td>
			<td style="width:40px; text-align:center">
				<span class="cate_btn_1"></span>
			</td>
		</tr>
	</table>
</div>
<div class="cate_layer" style="display:none">
	<?include_template('search_form_guin.html') ?>

</div>
<!--채용정보카테고리-->
<div style="padding:10px 0 10px 10px; border-bottom:2px solid #<?=$_data['배경색']['모바일_서브색상']?>" class="categroup">
	<?make_category_list('가로2개','100자','구인','sub_category.html','신입') ?>

</div>
<div style="padding:10px">
	<h3 style="color:#424242; padding:12px; letter-spacing:-1.5px;" class="font_20 font_malgun">
		채용정보 리스트 <span class="font_tahoma" style="color:#<?=$_data['배경색']['모바일_서브색상']?>">★22</span>
	</h3>
	<table class="tbl guin_search_form" style="width:100%; table-layout:fixed">
		<tr>
			<td style="padding-right:5px" class="input_style sel2">
				<?=$_data['채용정보정렬']?>

			</td>
			<td style="padding-left:5px" class="input_style sel2">
				<?=$_data['채용정보마감일정렬']?>

			</td>
		</tr>
	</table>
	<table class="tbl" style="width:100%; margin-top:10px">
		<tr>
			<td>
				<?guin_main_extraction('총2개','가로1개','제목길이1000자','자동','자동','자동','자동','우대등록','자동','sub_rows_guin_pick_01.html','전체','누락0개','사용안함','','랜덤추출','','신입') ?>

			</td>
		</tr>
	</table>
	<table class="tbl" style="width:100%">
		<tr>
			<td class="font_14 font_malgun" style="padding:20px 0 10px 0; border-bottom:2px solid #757575; letter-spacing:-1.2px">
				<img src="mobile_img/ico_txt_week5.gif" style="vertical-align:middle; height:14px"> 주5일근무&nbsp;
				<img src="mobile_img/ico_txt_bonus.gif" style="vertical-align:middle; height:14px"> 보너스&nbsp;
				<img src="mobile_img/ico_txt_food.gif" style="vertical-align:middle; height:14px"> 식사제공&nbsp;
				<img src="mobile_img/ico_commercial_udae.gif" style="vertical-align:middle; height:14px"> 우대조건&nbsp;
			</td>
		</tr>
		<tr>
			<td>
				<?guin_extraction_ajax('총20개','가로1개','제목길이200자','자동','자동','자동','자동','일반','자동','sub_guin_list_rows_01.html','누락0개','사용함','','최근등록일순','','','신입') ?>

			</td>
		</tr>
	</table>
</div>

<? }
?>