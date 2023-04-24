<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 11:07:57 */
function SkyTpl_Func_2667968186 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?
	//고용형태별 보기 페이지일 경우 스페셜, 파워링크, 포커스 인재정보 정보출력은 숨기기
	global $job_type_read, $career_read, $career_read_start, $career_read_end;
	if ($job_type_read || $career_read || $career_read_start || $career_read_end) {
			echo "
				<style type='text/css'>
					#commercial_option3,#commercial_option4 {display:none;}
				</style>
			";
	}
?>
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
		color: #559fc0;
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
<!--
	var request;
	function createXMLHttpRequest()
	{
		if (window.XMLHttpRequest) {
			request = new XMLHttpRequest();
		} else {
			request = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}

	function startRequest(sel,target,size)
	{
		var trigger = sel.options[sel.selectedIndex].value;
		var form = sel.form.name;
		createXMLHttpRequest();
		request.open("GET", "sub_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
		request.onreadystatechange = handleStateChange;
		request.send(null);
	}

	function startRequest2(sel,target,size)
	{
		var trigger = sel.options[sel.selectedIndex].value;
		var form = sel.form.name;
		createXMLHttpRequest();
		request.open("GET", "sub_type_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
		request.onreadystatechange = handleStateChange;
		request.send(null);
	}

	function handleStateChange() {
		if (request.readyState == 4) {
			if (request.status == 200) {
				var response = request.responseText.split("---cut---");
				eval(response[0]+ '.innerHTML=response[1]');
				window.status="완료"
			}
		}
		if (request.readyState == 1) {
			window.status="로딩중....."
		}
	}

	function searchbox(){
		for(i=1;i<=2;i++){
			if(document.getElementById(i).style.display == 'none'){
				document.getElementById(i).style.display='';
			}else{
				document.getElementById(i).style.display='none';
			}
		}

	}
	function no_change_pay()
	{
		var obj	= document.getElementById('grade_money_type')

		if ( obj.selectedIndex == 0 )
		{
			document.getElementById('grade_money').disabled = true;
		}
		else
			document.getElementById('grade_money').disabled = false;
	}
//-->
</script>
<script type="text/javascript">
		// <![CDATA[
		$(document).ready(function(){

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

<!--인재정보상세검색-->
<div class="sub_wrap">
	<h3 class="sub_tlt_st01">
		<b style="color:#<?=$_data['배경색']['모바일_기본색상']?>"></b>
		<span>인재정보</span>
	</h3>
	<?include_template('search_form_guzic.html') ?>

	<ul class="guzic_optionlist_wrap">
		<li>
			<h4 class="m_semi_tlt_m">
				<strong style="color:#<?=$_data['배경색']['모바일_기본색상']?>;">FOCUS</strong>
			</h4>
			<div class="m_gz_list_wrap m_gz_list_wrap01">
				<?document_extraction_list_main('가로6개','세로1개','옵션1','옵션2','포커스','옵션4','전체','200글자짜름','누락0개','sub_rows_model_focus.html') ?>

			</div>
		</li>
		<li>
			<h4 class="m_semi_tlt_m">
				<strong style="color:#<?=$_data['배경색']['모바일_기본색상']?>;">	SPECIAL</strong>
			</h4>
			<div class="m_gz_list_wrap m_gz_list_wrap02">
				<?document_extraction_list_main('가로6개','세로1개','옵션1','옵션2','스페셜','옵션4','전체','200글자짜름','누락0개','sub_rows_model_special.html') ?>

			</div>
		</li>
		<li>
			<h4 class="m_semi_tlt_m" style="margin-bottom:0;">
				<strong style="color:#<?=$_data['배경색']['모바일_기본색상']?>;">POWER</strong>
			</h4>
			<div class="m_gz_list_wrap m_gz_list_wrap03" style="margin-left:0;">
				<?document_extraction_list_main('가로1개','세로5개','옵션1','옵션2','파워링크','옵션4','전체','200글자짜름','누락0개','sub_rows_model_power.html') ?>

			</div>
		</li>
	</ul>
	<div class="sub_guzic_list_wrap">
		<h3 class="m_tlt_m_01">
			<strong style="margin-bottom:20px; display:block;"><?=$_data['카테고리명']['1차']?> 인재정보 리스트  <span style="color:#<?=$_data['배경색']['모바일_기본색상']?>;"><span id="guzic_counting" >로딩중</span>  건</span></strong>		
			<p class="h_form sub_list_select">
				<span><?=$_data['인재정보정렬']?></span>
			</p>
		</h3>
		<div class="sub_guin_list">
			<div class="sub_guin_td">
				<?document_extraction_list_ajax('가로1개','세로20개','옵션1','옵션2','옵션3','옵션4','최근등록일순','글자999글자짜름','누락0개','sub_guzic_list_rows_01.html','페이징사용') ?>

			</div>			
		</div>
	</div>
</div>
<? }
?>