<? /* Created by SkyTemplate v1.1.0 on 2023/03/31 08:34:54 */
function SkyTpl_Func_2091998794 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!-- 지하철 노선도 선택폼 관련 JS -->
<script language="javascript" src="./js/underground.js"></script>
<script language="javascript" src="./m/js/skin_tab.js"></script>
<script language="javascript" src="calendar.js"></script>
<!-- 정보입력폼 체크관련 JS start -->

<iframe width=188 height=166 name='gToday:datetime:agenda.js:gfPop:plugins_time.js' id='gToday:datetime:agenda.js:gfPop:plugins_time.js' src='./js/time_calrendar/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px; border:0px solid;'></iframe>

<script language="javascript">
	function no_change_pay()
	{
		var obj	= document.getElementById('guin_pay_type');

		if( typeof regiform.guin_pay_type != "undefined" )
		{
			if ( obj.selectedIndex == 0 )
			{
				document.getElementById('guin_pay').disabled = true;
			}
			else
				document.getElementById('guin_pay').disabled = false;
		}
	}

	function OpenWooDae(){
		window.open("guin_woodae.php","ZipWin","width=500,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes");
	}

	function OpenLicense(){
		window.open("guin_license.php","License","width=500,height=325,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes");
	}


	function sel(check1,d1)
	{
		var tmp1 = eval('document.regiform.'+check1);
		var tmp2 = eval('document.regiform.'+d1);
		if (tmp1.checked == true )
		{
			tmp2.disabled = true;
			tmp2.value = '';
		}
		else
		{
			tmp2.disabled = false;
		}
	}

	function change_tab()
	{
		guin_viewLayer('guin_layer_1',0);
		guin_changeImg('guin_img_1',0);
	}

	function check_Valid()
	{
		//고용형태체크
		if (typeof(regiform.guin_type) == "object")
		{
			var guintype = regiform.guin_type;
			var guin_type_cnt = guintype.length;
			var guin_type_check = false;

			for( i = 0; i < guin_type_cnt; i++)
			{
				if (guintype[i].checked == true)
				{
					guin_type_check = true;
					break;
				}
			}

			if (guin_type_check == false)
			{
				alert("고용형태를 체크해주세요");
				change_tab();
				regiform.guin_type[0].focus();
				return false;
			}
		}

		//이름 체크
		if ( regiform.guin_name.value == "" )
		{
			alert("담당자명을 입력해 주세요.");
			change_tab();
			regiform.guin_name.focus();
			return false;
		}

		//연락처 체크
		if ( regiform.guin_phone.value == "" )
		{
			alert("전화번호를 입력해 주세요.");
			change_tab();
			regiform.guin_phone.focus();
			return false;
		}

		//이메일 체크
		if ( regiform.guin_email.value == "" )
		{
			alert("당담자 이메일을 입력해 주세요.");
			change_tab();
			regiform.guin_email.focus();
			return false;
		}
		if (( regiform.guin_email.value.indexOf('@') < 0) || (regiform.guin_email.value.indexOf('.') < 0 ))
		{
			alert("이메일주소가 바르지 않습니다.");
			change_tab();
			regiform.guin_email.focus();
			return false;
		}

		if ( regiform.guin_choongwon.checked == false &&  regiform.guin_end_date.value == "" )
		{
			alert("\n마감일을 입력해 주세요. \n\n충원시일 경우 체크해 주세요   ");
			change_tab();
			regiform.guin_end_date.focus();
			return false;
		}

		if ( regiform.guin_choongwon.checked == false &&  regiform.guin_end_date.value < "<?=$_data['chkDate']?>" )
		{
			alert("마감일은 현재날짜로부터 최소 <?=$_data['chkDay']?>일 이후로 선택가능합니다.");
			change_tab();
			regiform.guin_end_date.focus();
			return false;
		}

		if ( regiform.age_chk.checked == false )
		{
			if (  regiform.guin_age.value == "" )
			{
				alert("\n나이제한을 입력해 주세요. \n\n제한이 없을 경우 [제한없음]을 체크해 주세요  ");
				change_tab();
				regiform.guin_age.focus();
				return false;
			}
			//나이제한
			if ( regiform.guin_age.value.length != 4 )
			{
				alert("나이제한은 출생년도 4자리로 입력해 주세요.");
				change_tab();
				regiform.guin_age.focus();
				return false;
			}
		}

		if ( regiform.age_chk.checked == true &&  regiform.guin_age.value != "" )
		{
			alert("나이제한이 있을경우 [제한없음] 체크를 없애주세요");
			change_tab();
			regiform.guin_age.focus();
			return false;
		}

		//급여조건
		if ( document.getElementById('guin_pay_type') )
		{
			if ( regiform.guin_pay2.selectedIndex == 0
			&& ( ( document.getElementById('guin_pay_type').selectedIndex != 0 && regiform.guin_pay.value == "" )
			|| ( document.getElementById('guin_pay_type').selectedIndex == 0 && regiform.guin_pay.value != "" )
			|| ( document.getElementById('guin_pay_type').selectedIndex == 0 && regiform.guin_pay.value == "" ) )
			)
			{
				alert("급여조건을 입력해 주세요.");
				change_tab();
				regiform.guin_pay.focus();
				return false;
			}
		}

		/*
		//최종학력
		if ( regiform.guin_edu.value == "" )
		{
			alert("최종학력을 입력해 주세요.");
			regiform.guin_edu.focus();
			return false;
		}
		*/

		if ( regiform.si1.value =='' && regiform.si2.value == '' && regiform.si3.value == ''  )
		{
			alert("근무지역은 적어도 하나는 선택하셔야 합니다");
			change_tab();
			regiform.si1.focus();
			return false;
		}

		if ( regiform.type1.value =='' && regiform.type2.value == '' && regiform.type3.value == ''  )
		{
			alert("업/직종은 적어도 하나는 선택하셔야 합니다");
			change_tab();
			regiform.type1.focus();
			return false;
		}


		if ( regiform.type1.value && regiform.type_sub1.value == ''  )
		{
			alert("2차직종을 선택해주세요");
			change_tab();
			regiform.type_sub1.focus();
			return false;
		}
		if ( regiform.type2.value && regiform.type_sub2.value == ''  )
		{
			alert("2차직종을 선택해주세요");
			change_tab();
			regiform.type_sub2.focus();
			return false;
		}
		if ( regiform.type3.value && regiform.type_sub3.value == ''  )
		{
			alert("2차직종을 선택해주세요");
			change_tab();
			regiform.type_sub3.focus();
			return false;
		}

		if ( regiform.guin_grade.value == "" )
		{
			alert("채용직급을 선택하세요.");
			change_tab();
			regiform.guin_grade.focus();
			return false;
		}


		//제목
		if ( regiform.guin_title.value == "" )
		{
			alert("제목을 입력해 주세요.");
			change_tab();
			regiform.guin_title.focus();
			return false;
		}

		//제목에 html 코드 입력방지
		tag_lt = regiform.guin_title.value.indexOf("<");
		tag_gt = regiform.guin_title.value.indexOf(">");

		if ( tag_lt != -1 && tag_gt != -1  )
		{
			alert('채용정보 제목에 HTML태그(<,>)를 입력하실수는 없습니다.');
			change_tab();
			regiform.guin_title.focus();
			return false;
		}

		//담당업무 체크
		if ( regiform.guin_work_content.value == "" )
		{
			alert("담당업무를 입력해 주세요.");
			change_tab();
			regiform.guin_work_content.focus();
			return false;
		}

		return true;
	}

	function interviewval()
	{
		if(regiform.guin_interview.value == "면접전 지원자의 답변을 미리 보실수 있습니다 / 1개이상 질문을 원하시면 [엔터]키로 구분하십시오")
		{
			regiform.guin_interview.value = '';
		}
	}


//입력형 희망연봉 값 초기화
function gradeMoneyReset() {
	document.getElementById("guin_pay").value = "";
	//document.getElementById("grade_money").value = "";
}



	var keyword_size	= 1;
	function checkSize(val , key)
	{
		var frm		= document.regiform;

		key_word	= frm.keyword.value;
		if ( key_word == "" )
		{
			keyword_size	= 0;
		}
		else
		{
			keywords2		= key_word.split(", ");
			keyword_size	= keywords2.length;
		}
		//alert(keyword_size);


		if ( val == true )
		{
			if ( keyword_size > 14 )
			{
				alert("더이상 선택이 불가능합니다.");
				return false;
			}
			else
			{
				frm.keyword.value	+= ( keyword_size == 0 )?"":", ";
				frm.keyword.value	+= key;
			}
		}
		else
		{
			frm.keyword.value	= "";
			for ( i=0 ; i<keyword_size ; i++ )
			{
				if ( keywords2[i] != key )
				{
					frm.keyword.value	+= ( frm.keyword.value != "" )?", ":"";
					frm.keyword.value	+= keywords2[i];
				}
			}
		}
	}

	//패키지(즉시적용) + 단일유료옵션
var swap_now_price				= Array();
function Func_pack2_now_price(chk_num)
{
	var pack2_uryo_val			= document.getElementById('pack2_uryo_'+chk_num).value;
	var pack2_uryo_val_split	= pack2_uryo_val.split(':');


	swap_now_price[chk_num]		= 0; //초기화

	if(document.getElementById('pack2_use_'+chk_num).checked == true)
	{
		swap_now_price[chk_num]	= parseInt(swap_now_price[chk_num]) + parseInt(pack2_uryo_val_split[4]);
	}


	var total				= 0;
	for(var idx in swap_now_price)
	{
		total				= parseInt(total) + parseInt(swap_now_price[idx]);
	}

	if ( document.getElementById('uryo_button_layer') && document.getElementById('free_button_layer') )
	{
		if ( total > 0 )
		{
			document.getElementById('uryo_button_layer').style.display = "";
			document.getElementById('free_button_layer').style.display = "none";
		}
		else
		{
			document.getElementById('uryo_button_layer').style.display = "none";
			document.getElementById('free_button_layer').style.display = "";
		}
	}

	document.getElementById('pack2_now_price').value	= total;
}
//패키지(즉시적용) + 단일유료옵션 END
</script>

<style>
	.sub_tab_menu03 > ul > li.tab_on1{border-top:4px solid #<?=$_data['배경색']['모바일_기본색상']?>;}
	h5.front_bar_st_tlt:before{background:#<?=$_data['배경색']['모바일_기본색상']?>;}
</style>

<!-- FORM start -->
<form name="regiform" method="post" action="guin_regist.php" onsubmit="return check_Valid();" ENCTYPE="multipart/form-data" class="regist_form">
<input type="hidden" name="mode" value="add_ok">
<input type="hidden" name='logo_photo3' id="logo_photo3" value=''>
<input type="hidden" name="keyword" id="keyword" readonly value="" style="width:600px; margin-bottom:10px; background:#f1f1f1;" >

<h3 class="sub_tlt_st01" >
	<b style="color:#<?=$_data['배경색']['모바일_기본색상']?>">초빙공고 </b>
	<span>등록하기</span>
</h3>
<div class="sub_tab_menu03">
	<ul>
		<li class="tab_on1" id="class_div1" onclick="TabChange_class('class','class_div','1','1');">초빙정보입력</li>
		<li class="tab_off1" id="class_div2" onclick="TabChange_class('class','class_div','2','1');">유료서비스 결제</li>
	</ul>
</div>
<div id="class1" class="guzic_regist_content_wrap">
	<ul>
		<li>
			<h5 class="front_bar_st_tlt">담당자 정보</h5>
			<table class="tb_st_04" cellpadding="0" style="width:100%">
				<colgroup>
					<col width="30%;"/>
					<col width="70%;"/>
				</colgroup>
				<tbody>
					<tr>
						<th style="border-bottom:1px solid #dedede">담당자명</th>
						<td style="border-bottom:1px solid #dedede; padding-bottom:10px" class="info h_form">
							<input type="text" name="guin_name" value="<?=$_data['MEM']['regi_name']?>" style="background:#fff;" >
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">회사명</th>
						<td style="border-bottom:1px solid #dedede; padding-bottom:10px" class="info h_form">
							<input type="text" name="com_name" value='<?=$_data['MEM']['com_name']?>' <?=$_data['MEM']['read_only']?> style="background:#fff">
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">연락처</th>
						<td style="border-bottom:1px solid #dedede; padding-bottom:10px" class="info h_form">
							<input type="text" name="guin_phone" value="<?=$_data['MEM']['com_phone']?>" style="background:#fff">
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">이메일</th>
						<td style="border-bottom:1px solid #dedede; padding-bottom:10px" class="info h_form">
							<input type="text" name="guin_email" value="<?=$_data['MEM']['com_email']?>" style="background:#fff">
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">팩스</th>
						<td style="border-bottom:1px solid #dedede; padding-bottom:10px" class="info h_form">
							<input type="text" name="guin_fax"  value="<?=$_data['MEM']['com_fax']?>" style="background:#fff" >
						</td>
					</tr>
					<tr>
						<th style="">홈페이지</th>
						<td style="padding-bottom:10px" class="info h_form">
							<input type="text" name="guin_homepage" value="<?=$_data['MEM']['user_homepage']?>" style="background:#fff" >
						</td>
					</tr>
				</tbody>				
			</table>
		</li>
		<li>
			<h5 class="front_bar_st_tlt">기본정보 입력</h5>
			<table class="tb_st_04" cellpadding="0" style="width:100%">
				<colgroup>
					<col width="30%;"/>
					<col width="70%;"/>
				</colgroup>
				<tbody>
					<tr>
						<th colspan="2" style="background:#<?=$_data['배경색']['메인페이지']?>; padding-bottom:10px; border-bottom:1px solid #dedede"" class="h_form">
							<input  type="text" id="guin_title" name="guin_title" placeholder="채용공고 제목을 입력해주세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '채용공고 제목을 입력해주세요'" style="border:1px solid #<?=$_data['배경색']['모바일_기본색상']?>">
						</th>
					</tr>
					<tr style="display:<?=$_data['hunting_use_dis']?>">
						<th style="border-bottom:1px solid #dedede">기업선택</th>
						<td style="border-bottom:1px solid #dedede" class="info">
							<div style="margin:10px 0">
								<table cellpadding="0" cellspacing="0" style="width:100%">
									<tr>
										<td class="h_form select_width"><?company_select_box('') ?></td>
									</tr>
									<tr>
										<td>
											<p class="font_10" style="color:#5f5f5f; margin-top:5px; letter-spacing:-1px; line-height:1.333em; ">
												<span style="color:#3a6ab2;">해드헌팅 기업정보 설정</span>에서 등록된 기업을 선택합니다.</span>
											</p>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">업종선택</th>
						<td style="border-bottom:1px solid #dedede" class="guzic_info_hope_area">
							<ul>
								<li id="jobtype_sel1" class="h_form">
									<!-- { {type_job_type1.0}}{ {type_job_type1.1}} -->
									<select name="type1" id="type1" style="width:100%;">
										<?=$_data['type_opt1']?>

									</select>
									<select name="type_sub1" id="type_sub1" style="width:100%;">
										<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['1']?></option>
										<?=$_data['type_sub_opt1']?>

									</select>
									<select name="type_sub_sub1" id="type_sub_sub1" style="width:100%;">
										<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['2']?></option>
										<?=$_data['type_sub_sub_opt1']?>

									</select>
								</li>
								<li id="jobtype_sel2" style="display:none;"  class="h_form">
									<!-- { {type_job_type2.0}}{ {type_job_type2.1}} -->
									<select name="type2" id="type2" style="width:100%;">
										<?=$_data['type_opt2']?>

									</select>
									<select name="type_sub2" id="type_sub2" style="width:100%;">
										<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['1']?></option>
										<?=$_data['type_sub_opt2']?>

									</select>
									<select name="type_sub_sub2" id="type_sub_sub2" style="width:100%;">
										<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['2']?></option>
										<?=$_data['type_sub_sub_opt2']?>

									</select>
								</li>
								<li id="jobtype_sel3" style="display:none;"  class="h_form">
									<!-- { {type_job_type3.0}}{ {type_job_type3.1}} -->
									<select name="type3" id="type3" style="width:100%;">
										<?=$_data['type_opt3']?>

									</select>
									<select name="type_sub3" id="type_sub3" style="width:100%;">
										<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['1']?></option>
										<?=$_data['type_sub_opt3']?>

									</select>
									<select name="type_sub_sub3" id="type_sub_sub3" style="width:100%;">
										<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['2']?></option>
										<?=$_data['type_sub_sub_opt3']?>

									</select>
								</li>
							</ul>			
							<input type='button' value='추가하기'  onClick="formJobtypeAdd()" style="background:#<?=$_data['배경색']['기본색상']?>; border:1px solid #<?=$_data['배경색']['기본색상']?>; border-radius:5px; box-sizing:border-box; padding:4px; width:100%; cursor:pointer; font-size: 1.143em; color:#fff; letter-spacing:-1.5px; margin-top:10px;">			
							<ul class="list_front_dot_st">
								<li>업/직종은 최대 3개까지 입력 가능합니다.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">기업로고</th>
						<td style="border-bottom:1px solid #dedede" class="">
							<div style="margin:10px 0" class="check_radio h_form">
								<input type='file' id="photo2" name='photo2' style="width:100%">
							</div>
							<ul class="list_front_dot_st">
								<li>사이즈 가로 100 X 53 px 권장.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">기업광고용로고</th>
						<td style="border-bottom:1px solid #dedede" class="">
							<div style="margin:10px 0 0 0" class="check_radio h_form">
								<input type='file' id="photo3" name='photo3' style="width:100%">
							</div>
							<div style="margin:5px 0 10px 0">
								<table cellpadding="0" cellspacing="0" style="width:100%">
									<tr>
										<td class="regist_info" >
											<input type='button' value='로고이미지생성하기'  onClick="javascript:open_window('bg_image', 'logo_bgimage.php?mode=step1',0,0,750,770,0,0,0,0,0)" style="background:#<?=$_data['배경색']['기본색상']?>; border:1px solid #<?=$_data['배경색']['기본색상']?>; border-radius:5px; box-sizing:border-box; padding:4px; width:100%; cursor:pointer; font-size: 1.143em; color:#fff; letter-spacing:-1.5px; margin-top:10px;">
										</td>
									</tr>
								</table>
							</div>
							<ul class="list_front_dot_st">
								<li>사이즈 가로 85 X 33 px 권장</li>
							</ul>
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">고용형태</th>
						<td style="border-bottom:1px solid #dedede" class="regist_info">
							<div style="margin:10px 0" class="check_radio">
								<?=$_data['고용형태']?>

							</div>
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">모집인원</th>
						<td style="border-bottom:1px solid #dedede" class="">
							<div style="margin:10px 0" class="check_radio">
								<table cellpadding="0" cellspacing="0" style="width:100%">
									<tr>
										<td class="h_form" >
											<input type="text" name="howpeople" id="howpeople" style="text-align:right;">
										</td>
										<td style="text-align:center; width:30px">
											명
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">채용직급</th>
						<td style="border-bottom:1px solid #dedede" class="">
							<div style="margin:10px 0" class="h_form select_width">
								<?=$_data['채용직급']?>

							</div>
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">급여조건</th>
						<td style="border-bottom:1px solid #dedede">
							<style>
									#tabmenu{display:table; width:100%;}
									#tabmenu li{display:table-cell; width:50%; text-align:center}
									#tabmenu li a{display:block; width:100%; height:36px; line-height:36px; background:#fff; border:1px solid #<?=$_data['배경색']['기본색상']?>; color:#<?=$_data['배경색']['기본색상']?>; box-sizing:border-box;}
									#tabmenu li .selected{background:#<?=$_data['배경색']['기본색상']?>; color:#fff;}
								</style>
							<div style="margin:10px 0 5px 0">
								<ul id="tabmenu" style="">
									<li><a style="cursor:pointer;">선택형</a></li>
									<li><a style="cursor:pointer;">입력형</a></li>
								</ul>
							</div>
							<div class="tabcontent" id="select1" style="margin-bottom:10px">
								<table cellpadding="0" cellspacing="0" style="width:100%">
									<tr>
										<td class="h_form select_width" >
											<?=$_data['급여조건']?>

										</td>
									</tr>
								</table>
							</div>
							<div class="tabcontent" id="select2" style="margin-bottom:10px">
								<table cellpadding="0" cellspacing="0" style="width:100%">
									<tr>
										<td class="h_form select_width" colspan="2">
											<select id='guin_pay_type' name='guin_pay_type' onChange='no_change_pay()'><?=$_data['연봉타입']?></select>
										</td>
									</tr>
									<tr>
										<td class="h_form " style="padding-top:5px" >
											<input type='text' id='guin_pay' name='guin_pay' value='<?=$_data['DETAIL']['guin_pay']?>' maxlength='15' >
										</td>
										<td style="text-align:center; width:30px">
											원
										</td>
									</tr>
									<tr>
										<td class="regist_info" style="padding-top:5px"  colspan="2">
											<input type='button' value='다시입력' onClick="document.getElementById('guin_pay').value = '';" style="background:#000; width:100%; height:30px; cursor:pointer; font-size: 1.143em; color:#fff; letter-spacing:-1.5px">
										</td>

									</tr>
								</table>
							</div>
							<ul class="list_front_dot_st">
								<li>원하시는 급여조건에 대해서 선택형 또는 입력형 둘 중 하나를 선택하여 설정하여 주세요.</li>
								<li>단위 글자를 포함해서 작성하여 주세요. (예: 2400~3600만원)</li>
							</ul>
							<script type="text/javascript">
								no_change_pay();/*guin_pay 연봉타입 선택후 셀렉팅 되도록 하는 소스*/
								tabMenu('');/*텝소스 실행소스*/
							</script>
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">기업형태</th>
						<td class="regist_info" style="border-bottom:1px solid #dedede">
							<div style="margin:10px 0" class="check_radio scale_com_tb_wrap">
								<?=$_data['희망회사규모']?>

							</div>
						</td>
					</tr>
					<tr>
						<th>담당업무</th>
						<td>
							<div style="margin:10px 0" class="h_form">
								<input type='text' name='guin_work_content' style="width:100%;" >
							</div>
						</td>
					</tr>
				</tbody>			
			</table>
		</li>
		<li>
			<h5 class="front_bar_st_tlt">지원자격</h5>
			<table style="width:100%" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
				<colgroup>
					<col style="width:30%">
					<col style="width:70%">
				</colgroup>
				<tr>
					<th style="padding-bottom:5px; border-bottom:1px solid #dedede" class="regist_info">
						경력사항
					</th>
					<td class="info" style="border-bottom:1px solid #dedede">
						<div style="margin:0 0 10px 0" class="h_form check_radio">
							<label for="careers_no" class="h-radio"><input type='radio' name='guin_career' value='무관' id="careers_no"  style="width:13px; height:13px; vertical-align:middle; cursor:pointer" checked ><span></span></label>
							<label for="careers_no" style="cursor:pointer;">무관</label>

							<label for="careers_new" class="h-radio"><input type='radio' name='guin_career' value='신입' id="careers_new"  style="width:13px; height:13px; vertical-align:middle; cursor:pointer; margin-left:10px"><span></span></label>
							<label for="careers_new"  style="cursor:pointer;">신입</label>

							<label for="careers"  class="h-radio"><input type='radio' name='guin_career' value='경력' id="careers" style="width:13px; height:13px; vertical-align:middle; cursor:pointer; margin-left:10px"><span></span></label>
							<label for="careers"  style="cursor:pointer;">경력</label>
						</div>
						<div style="margin-bottom:10px">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td class="h_form select_width">
										<?=$_data['경력년수']?>

									</td>
									<td style="width:30px; text-align:center">이상</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<th style="border-bottom:1px solid #dedede">최종학력</th>
					<td style="border-bottom:1px solid #dedede" class="h_form">
						<div style="margin:10px 0" class="select_width">
							<?=$_data['최종학력']?>

						</div>
					</td>
				</tr>
				<tr>
					<th style="border-bottom:1px solid #dedede">성별</th>
					<td style="border-bottom:1px solid #dedede">
						<div style="margin:10px 0" class="h_form check_radio">
							<label for="guin_gender_man" class="h-radio"><input type='radio' name='guin_gender' value='남자' id="guin_gender_man"  style="width:13px; height:13px; vertical-align:middle; cursor:pointer"><span></span></label>
							<label for="guin_gender_man"  style="cursor:pointer;">남자</label>

							<label for="guin_gender_woman" class="h-radio"><input type='radio' name='guin_gender' value='여자' id="guin_gender_woman"  style="width:13px; height:13px; vertical-align:middle; cursor:pointer; margin-left:10px"><span></span></label>
							<label for="guin_gender_woman"  style="cursor:pointer;">여자</label>

							<label for="guin_gender_no" class="h-radio"><input type='radio' name='guin_gender' value='무관' id="guin_gender_no"  style="width:13px; height:13px; vertical-align:middle; cursor:pointer; margin-left:10px" checked><span></span></label>
							<label for="guin_gender_no" style="cursor:pointer;">무관</label>
						</div>
					</td>
				</tr>
				<tr>
					<th style="border-bottom:1px solid #dedede">나이</th>
					<td style="border-bottom:1px solid #dedede">
						<div style="margin:10px 0">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td class="h_form">
										<input type="text" name="guin_age">
									</td>
									<td style="width:150px; text-align:center">년 이후 출생자 (4자리)</td>
								</tr>
								<tr>
									<td colspan="2" class="h_form" style="padding-top:3px;">
										<label for="age_chk" class="h-check"><input type="checkbox" name="age_chk" id="age_chk" value="제한없음" onclick="sel('age_chk','guin_age')" style="width:13px; height:13px; vertical-align:middle;"><span></span></label>
										<label for="age_chk" style="cursor:pointer">제한없음</label>
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<th style="border-bottom:1px solid #dedede">결혼유무</th>
					<td style="border-bottom:1px solid #dedede">
						<div style="margin:10px 0" class="h_form check_radio">
							<label for="wedding_noting" class="h-radio"><input type="radio" name="marriage_chk" value="무관" id="wedding_noting"  style="width:13px; height:13px; vertical-align:middle; cursor:pointer" checked><span></span></label>
							<label for="wedding_noting" class="sub_txt radio_sel" style="cursor:pointer">무관</label>

							<label for="wedding_yes" class="h-radio"><input type="radio" name="marriage_chk" value="기혼" id="wedding_yes" style="width:13px; height:13px; vertical-align:middle; cursor:pointer; margin-left:10px"><span></span></label>
							<label for="wedding_yes" class="sub_txt check_sel"  style="cursor:pointer;">기혼</label>

							<label for="wedding_no" class="h-radio"><input type="radio" name="marriage_chk" value="미혼"  id="wedding_no" style="width:13px; height:13px; vertical-align:middle; cursor:pointer; margin-left:10px"><span></span></label>
							<label for="wedding_no" class="sub_txt check_sel"  style="cursor:pointer;">미혼</label>
						</div>
					</td>
				</tr>		
				<tr>
					<td colspan="2">
						<ul class="list_front_dot_st" style="margin:10px 0; color:#666">
							<li>모집 채용에서 <span style="color:#e45858">남녀를 차별</span>하거나, <span style="color:#e45858">여성근로자</span>를 채용할 때 직무수행에 불필요한 용모, 키, 체중 등의 신체조건, 미혼조건을 제시 또는 요구하는 경우는 <span style="color:#e45858">남녀고용 평등과 일,가정 양립 지원에 관한 법률 위반</span>에 따른 <strong style="color:#333">500만원 이하의 벌금</strong>이 부과될 수 있습니다.</li>
							<li>모집 채용에서 합리적인 이유 없이 연령제한을 하는 경우는 연령차별금지법 위반에 따른 <strong style="color:#333">500만원 이하의 벌금</strong>이 부과될 수 있습니다.</li>
						</ul>
					</td>
				</tr>
			</table>	
		</li>
		<li>
			<h5 class="front_bar_st_tlt">우대사항</h5>
			<table style="width:100%" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
				<colgroup>
					<col style="width:30%">
					<col style="width:70%">
				</colgroup>
				<tr>
					<th  style="padding-bottom:5px; border-bottom:1px solid #dedede" class="regist_info">
						우대조건
					</th>
					<td class="info" style="border-bottom:1px solid #dedede">
						<div style="margin:0 0  5px 0" class="">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td class="h_form" style="padding-bottom:5px">
										<input type="text" name="woodae" onclick="OpenWooDae()"  style="background:#f1f1f1;" readonly>
									</td>
								</tr>
								<tr>
									<td>
										<input type='button' value='추가하기'  onclick="OpenWooDae()" style="background:#<?=$_data['배경색']['기본색상']?>; border:1px solid #<?=$_data['배경색']['기본색상']?>; border-radius:5px; box-sizing:border-box; padding:4px; width:100%; cursor:pointer; font-size: 1.143em; color:#fff; letter-spacing:-1.5px; margin-top:10px;"">
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<th  style="padding-bottom:5px; border-bottom:1px solid #dedede" class="regist_info">
						자격증
					</th>
					<td class="info" style="border-bottom:1px solid #dedede">
						<div style="margin:5px 0  5px 0" class="">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td class="h_form" style="padding-bottom:5px">
										<input type="text" name="guin_license" onclick="OpenLicense()"  style="background:#f1f1f1;" readonly>
									</td>
								</tr>
								<tr>
									<td>
										<input type='button' value='추가하기'  onclick="OpenLicense()" style="background:#<?=$_data['배경색']['기본색상']?>; border:1px solid #<?=$_data['배경색']['기본색상']?>; border-radius:5px; box-sizing:border-box; padding:4px; width:100%; cursor:pointer; font-size: 1.143em; color:#fff; letter-spacing:-1.5px; margin-top:10px;">
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<th  style="padding-bottom:5px; border-bottom:1px solid #dedede" class="regist_info">
						외국어능력
					</th>
					<td class="info" style="border-bottom:1px solid #dedede">
						<div style="margin:5px 0  5px 0" class="">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td class="h_form select_width" style="padding-bottom:5px">
										<?=$_data['외국어명1']?>

									</td>
								</tr>
								<tr>
									<td class="h_form">
										<input type="text" name="lang_type1" placeholder="공인시험" onfocus="this.placeholder = ''"onblur="this.placeholder = '공인시험'">
									</td>
								</tr>
								<tr>
									<td class="h_form" style="padding:5px 0 10px 0; border-bottom:1px solid #ddd">
										<input type="text" id="lang_point1" name="lang_point1" placeholder="점수/급수" onfocus="this.placeholder = ''"onblur="this.placeholder = '점수/급수'">
									</td>
								</tr>
								<tr>
									<td class="h_form select_width" style="padding-bottom:5px; padding-top:10px">
										<?=$_data['외국어명2']?>

									</td>
								</tr>
								<tr>
									<td class="h_form">
										<input type="text" name="lang_type2" placeholder="공인시험" onfocus="this.placeholder = ''"onblur="this.placeholder = '공인시험'">
									</td>
								</tr>
								<tr>
									<td class="h_form" style="padding-top:5px">
										<input type="text" id="lang_point2" name="lang_point2" placeholder="점수/급수" onfocus="this.placeholder = ''"onblur="this.placeholder = '점수/급수'">
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
			</table>
		</li>
		<li>
			<h5 class="front_bar_st_tlt">근무환경</h5>
			<table style="width:100%; table-layout:fixed;" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
				<colgroup>
					<col style="width:30%">
					<col style="width:70%">
				</colgroup>
				<tbody>
					<tr>
						<th>근무지역</th>
						<td class="info guzic_info_hope_area">
							<ul>
								<li id="area_sel1"  class="h_form "><?=$_data['si_info_1']?></li>
								<li id="area_sel2" style="display:none;"  class="h_form "><?=$_data['si_info_2']?></li>
								<li id="area_sel3" style="display:none;" class="h_form "><?=$_data['si_info_3']?></li>
							</ul>
							<input type='button' value='추가하기'  onClick="formAreaAdd()" style="background:#<?=$_data['배경색']['기본색상']?>; border:1px solid #<?=$_data['배경색']['기본색상']?>; border-radius:5px; box-sizing:border-box; padding:4px; width:100%; cursor:pointer; font-size: 1.143em; color:#fff; letter-spacing:-1.5px; margin-top:10px;">							
							<ul class="list_front_dot_st">
								<li>최대 3개까지 입력 가능합니다.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<th>위치기반주소</th>
						<td class="info">
							<table cellspacing="0" cellpadding="0" style="width:100%;">
								<tbody>
									<tr>
										<td class="h_form"><input type='text' id="user_zip" name='user_zip' value='<?=$_data['MEM']['user_zip']?>' style="" ></td>
										<td class="regist_info" style="width:100px; text-align:right; padding-left:3px;"><span class="btn_zipcode" style="padding:0 10px;  height:40px; line-height:40px; text-align:center; color:#fff; letter-spacing:-1.2px; background:#666666; cursor:pointer; display:inline-block;" onClick="window.open('http://<?=$_data['zipcode_site']?>/zonecode/happy_zipcode.php?ht=1&hys=<?=$_data['base64_main_url']?>&hyf=user_zip|user_addr1|user_addr2|<?=$_data['zipcode_add_get']?>','happy_zipcode_popup_<?=$_data['base64_main_url']?>', 'width=600,height=600,scrollbars=yes');">
											우편번호검색
										</span></td>
									</tr>
								</tbody>								
							</table>
							<div class="h_form" style="padding:5px 0;">
								<input type='text' id="user_addr1" name='user_addr1' value='<?=$_data['MEM']['user_addr1']?>' style="width:100%">
							</div>
							<div class="h_form">
								<input type='text' id="user_addr2" name='user_addr2' value='<?=$_data['MEM']['user_addr2']?>' style="width:100%;">
							</div>
						</td>
					</tr>
					<tr>
						<th style="padding-bottom:5px; border-bottom:1px solid #dedede" class="regist_info">
							인근지하철
						</th>
						<td class="info">
							<div class="h_form select_half">
								<script type="text/javascript">
									make_underground('0','0')
								</script>
							</div>
							<div class="h_form" style="margin-top:5px">
								<input type="text" id="subway_txt" name="subway_txt" placeholder="추가정보입력" onfocus="this.placeholder = ''"onblur="this.placeholder = '추가정보입력'" style="">
							</div>
							<ul class="list_front_dot_st">
								<li>인근 지하철 정보를 선택하여 주시고, 필요에 따라 추가정보를 입력하여 주세요 .(예: 2호선 반고개역에서 도보로 500m 이내)</li>
							</ul>
						</td>
					</tr>
					<tr>
						<th  style="padding-bottom:5px; border-bottom:1px solid #dedede" class="regist_info">
							근무요일
						</th>
						<td class="info">
							<div class="h_form">
								<input type="text" name="work_week" value="<?=$_data['DETAIL']['work_week']?>" style="" placeholder="월,화,격일근무,기타,주5일 등" onfocus="this.placeholder = ''"onblur="this.placeholder = '월,화,격일근무,기타,주5일 등'">
							</div>
							<ul class="list_front_dot_st">
								<li>(예: 월~금(주5일), 월~토(토요일 격주휴무), 월~토, 격일근무, 기타)</li>
							</ul>						
						</td>
					</tr>
					<tr>
						<th  style="padding-bottom:5px; border-bottom:1px solid #dedede" class="regist_info">
							근무시간
						</th>
						<td class="info">
							<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed;">
								<tr>
									<td class="h_form regist_time_select" style="width:30%">
										<?=$_data['WorkTime1']?>

									</td>
									<td class="h_form regist_time_select" style="width:35%; padding:0 5px;">
										<?=$_data['WorkTime2']?>

									</td>
									<td class="h_form" style="width:35%">
										<div style="padding-right:25px; position:relative;" class="regist_time_select">
											<?=$_data['WorkTime3']?>

											<span style="position:absolute; top:5px; right:8px">~</span>
										</div>
									</td>
								</tr>
							</table>
							<table cellpadding="0" cellspacing="0" style="width:100%; margin-top:5px; table-layout:fixed;">
								<tr>
									<td class="h_form regist_time_select" style="width:30%">
										<?=$_data['WorkTime4']?>

									</td>
									<td class="h_form regist_time_select" style="width:30%; padding:0 5px;">
										<?=$_data['WorkTime5']?>

									</td>
									<td class="h_form regist_time_select" style="width:30%">
										<?=$_data['WorkTime6']?>

									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th class="regist_info">
							복리후생
						</th>
						<td class="info">
							<div class="check_radio">
								<?=$_data['복리후생']?>

							</div>
						</td>
					</tr>
				</tbody>				
			</table>
		</li>
		<li>
			<h5 class="front_bar_st_tlt">접수기간 및 방법</h5>
			<table style="width:100%" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
				<colgroup>
					<col style="width:30%">
					<col style="width:70%">
				</colgroup>
				<tbody>
					<tr>
						<th style="border-bottom:1px solid #dedede">접수기간</th>
						<td style="border-bottom:1px solid #dedede; padding-bottom:10px" class="info">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td class="h_form">
										<input name="guin_end_date" type="text" maxlength="10" value='' onclick="if(self.gfPop)gfPop.fPopCalendar(document.regiform.guin_end_date);return false;" HIDEFOCUS>
									</td>
								</tr>
								<tr>
									<td class="h_form" style="padding-top:3px;">
										<label for="guin_choongwon" class="h-check"><input type="checkbox" name="guin_choongwon" id="guin_choongwon" value="1" onclick="sel('guin_choongwon','guin_end_date')" style=" width:13px; height:13px; vertical-align:middle; "><span></span></label>
										<label for="guin_choongwon" class="font_14" style="font-weight:bold; cursor:pointer; color:#666666">충원시</label>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">접수방법</th>
						<td style="border-bottom:1px solid #dedede; padding-bottom:10px" class="info">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td class="regist_info check_radio">
										<?=$_data['접수방법']?>

									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>				
			</table>
		</li>
	<!-- 	<li>
			<h5 class="front_bar_st_tlt">사전 인터뷰</h5>
			<table width="100%" class="tb_st_04">
				<tbody>
					<tr>
						<td>
							<div class="h_form">
								<textarea name="guin_interview" id="guin_interview"  style="width:100%; height:115px;"  onfocus="javascript:interviewval()"></textarea>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<ul class="list_front_dot_st">
								<li>사전인터뷰 질문을 등록하시면 온라인 입사지원시 지원자가 이력서와 함께 질문에 대한 답변을 작성해서 보냅니다.</li>
								<li><span style="color:#<?=$_data['배경색']['기타페이지2']?>">지원자가 보낸 답변은 지원자 파악 및 서류합격자 선별에 도움이 될 수 있습니다.</span></li>
								<li>지원자의 답변은 채용정보의 지원자 현황에서 확인합니다.</li>
								<li>1개 이상의 질문을 원하시면 [Enter]키로구분해서 입력</li>	
							</ul>
						</td>
					</tr>
				</tbody>
			</table>			
		</li> -->
		<!-- <li>
			<h5 class="front_bar_st_tlt">키워드 선택</h5>
			<table style="width:100%" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
				<tbody>
					<tr>
						<th>
							<div class="check_radio">
								<?=$_data['키워드내용']?>

							</div>
						</th>
					</tr>
				</tbody>
			</table>
		</li> -->
		<li>
			<h5 class="front_bar_st_tlt">상세정보 및 이미지등록</h5>
			<table style="width:100%" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
				<colgroup>
					<col style="width:30%">
					<col style="width:70%">
				</colgroup>
				<tbody>	
					<tr>
						<td class="h_form" colspan="2">
							<textarea name="guin_main" id="guin_main"  style="width:100%; height:115px;"  placeholder="상세정보를  작성해주세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '상세정보를  작성해주세요'"></textarea>
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #dedede">이미지등록</th>
						<td style="border-bottom:1px solid #dedede" class="check_radio">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td style="padding:10px 0 5px 0">
										<div id="num1" class="h_form regist_image">
											<input type="file" name="img1" style="width:100%">
											<input type="text" name="img_text1" class="font_11 font_dotum" style="letter-spacing:-1px; color:#b6b6b6; margin-top:5px" placeholder="파일설명을 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '파일설명을 입력하세요'" />
										</div>

										<div id="num2" class="h_form regist_image" style="margin-top:10px">
											<input type="file" name="img2" style="width:100%">
											<input type="text" name="img_text2" class="font_11 font_dotum" style="letter-spacing:-1px; color:#b6b6b6; margin-top:5px" placeholder="파일설명을 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '파일설명을 입력하세요'" />
										</div>

										<div id="num3" class="h_form regist_image" style="margin-top:10px">
											<input type="file" name="img3" style="width:100%">
											<input type="text" name="img_text3" class="font_11 font_dotum" style="letter-spacing:-1px; color:#b6b6b6; margin-top:5px" placeholder="파일설명을 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '파일설명을 입력하세요'" />
										</div>

										<div id="num4" class="h_form regist_image" style="margin-top:10px">
											<input type="file" name="img4" style="width:100%">
											<input type="text" name="img_text4" class="font_11 font_dotum" style="letter-spacing:-1px; color:#b6b6b6; margin-top:5px" placeholder="파일설명을 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '파일설명을 입력하세요'" />
										</div>

										<div id="num5" class="h_form regist_image" style="margin-top:10px">
											<input type="file" name="img5" style="width:100%">
											<input type="text" name="img_text5" class="font_11 font_dotum" style="letter-spacing:-1px; color:#b6b6b6; margin-top:5px" placeholder="파일설명을 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '파일설명을 입력하세요'" />
										</div>
									</td>
								</tr>
								<tr>
									<td class="regist_info" style="padding-bottom:5px">
										<input type='button' value='다시입력'  onClick="formImageFormAdd('reset')" style="border:1px solid #ddd; border-radius:3px; display:inline-block; padding:5px 10px; color:#666; background:#f5f5f5; width:100%">
										<input type='button' value='추가'  onClick="formImageFormAdd('add')" style="background:#<?=$_data['배경색']['기본색상']?>; border:1px solid #<?=$_data['배경색']['기본색상']?>; border-radius:5px; box-sizing:border-box; padding:4px; width:100%; cursor:pointer; font-size: 1.143em; color:#fff; letter-spacing:-1.5px; margin-top:10px;">
									</td>
								</tr>
								<tr>
									<td class="regist_info" style="padding-bottom:10px">
										<ul class="list_front_dot_st">
											<li>이미지등록은 추가버튼을 클릭하시면 되며, 최대 5개까지 등록하실 수 있습니다.다시를 클릭하시면 선택한 파일의 파일경로명 값 및 파일설명이 초기화 됩니다.</li>
										</ul>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</li>
		<li style="<?=$_data['inquiry_use_display']?>">
			<h5 class="front_bar_st_tlt">문의하기 사용여부</h5>
			<table style="width:100%" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
				<colgroup>
					<col style="width:30%">
					<col style="width:70%">
				</colgroup>
				<tbody>				
					<tr>
						<th>문의하기 사용여부</th>
						<td class="h_form check_radio">
							<label for='inquiry_use_y' class="h-radio"><input type='radio' name='inquiry_use' value='y' <?=$_data['inquiry_use_checked1']?> id='inquiry_use_y' style="height:13px; width:13px; vertical-align:middle;"><span></span></label>
							<label for='inquiry_use_y' style="vertical-align:middle"> <span style="font-size:20px; color:#459ef9; font-family:Arial,Sans-Serif;"><strong>ON</strong></span> <span style="color:#459ef9;">사용함</span></label>

							<label for='inquiry_use_n' class="h-radio"><input type='radio' name='inquiry_use' value='n' <?=$_data['inquiry_use_checked2']?> id='inquiry_use_n' style="height:13px; width:13px; vertical-align:middle;"><span></span></label>
							<label for='inquiry_use_n' style="vertical-align:middle"> <span style="font-size:20px; color:#ef4141; font-family:Arial,Sans-Serif;"><strong>OFF</strong></span> <span style="color:#ef4141;">사용안함</span></label>
						</td>
					</tr>
				</tbody>
			</table>
		</li>
		<li>
			<ul class="pay_btns_wrap">
				<li class="pay_free_btn"><?=$_data['PAY']['free']?></li>
				<li class="pay_btn_ver_b">
					<a href='#pay_move' id="class_div2" onclick="TabChange_class('class','class_div','2','1');">
						<input type="button" value="유료서비스 결제" style="color:#fff; background:#<?=$_data['배경색']['모바일_기본색상']?>" >
					</a>
				</li>
			</ul>
		</li>
	</ul>
</div>
<div id="class2" style="display:none">
	<a name='pay_move'></a>
	<div class="banner_img" style="border-bottom:1px solid #bcbcbc">
		<?echo happy_banner('모바일채용공고배너','배너제목','랜덤') ?>

	</div>
	<div>
		<div style="margin-top:40px;">
			<!-- 패키지즉시적용박스 -->
			<h5 class="front_bar_st_tlt">광고노출 패키지 퀵 서비스</h5>
			<div style="border-bottom:1px solid #ddd">
				<?=$_data['패키지즉시적용박스']?> <!--temp/package2_selectbox.html-->
			</div>
			<input type="hidden" name="pack2_now_price" id="pack2_now_price" value="0">
			<input type='hidden' name='pack2_all_number' value='<?=$_data['script_pack2_all']?>'>
			<!-- 패키지즉시적용박스 END -->
		</div>
		<div style="margin-top:40px;">
			<h5 class="front_bar_st_tlt">광고노출 서비스</h5>
			<?=$_data['채용정보결제페이지']?>

		</div>
		<ul class="pay_btns_wrap">
			<li id="uryo_button_layer" class="pay_btn_ver_b"><?=$_data['등록버튼']?></li>
			<li id="free_button_layer">
				<ul class="pay_btns_wrap">
					<li class="pay_free_btn"><?=$_data['PAY']['free']?></li>
					<li class="pay_btn_ver_b"><input type="button" value="패키지옵션 결제" style="color:#fff; background:#<?=$_data['배경색']['모바일_서브색상']?>" onclick="window.open('member_option_pay_package.php')"></li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<!-- 결제등록 및 무료등록 버튼 end -->
</form>
<!-- FORM end -->
<!-- 금액관련 JS -->
<?=$_data['PAY']['loading_script']?>


<!--유료결제탭끝-->


<!-- 근무지역 / 업,직종선택 / 이미지등록 폼추가 관련 JS start -->
<script type="text/javascript">
	//근무지역
	var area_sel		= new Array();
	area_sel[0] = document.getElementById("area_sel1");
	area_sel[1] = document.getElementById("area_sel2");
	area_sel[2] = document.getElementById("area_sel3");
	/*
	area_sel[1].style.display = "none";
	area_sel[2].style.display = "none";
	*/

	//업,직종선택
	var jobtype_sel		= new Array();
	jobtype_sel[0] = document.getElementById("jobtype_sel1");
	jobtype_sel[1] = document.getElementById("jobtype_sel2");
	jobtype_sel[2] = document.getElementById("jobtype_sel3");
	/*
	jobtype_sel[1].style.display = "none";
	jobtype_sel[2].style.display = "none";
	*/


	//이미지등록
	var image_regist		= new Array();
	image_regist[0] = document.getElementById("num1");
	image_regist[1] = document.getElementById("num2");
	image_regist[2] = document.getElementById("num3");
	image_regist[3] = document.getElementById("num4");
	image_regist[4] = document.getElementById("num5");
	image_regist[1].style.display = "none";
	image_regist[2].style.display = "none";
	image_regist[3].style.display = "none";
	image_regist[4].style.display = "none";

	var aai = 0;
	var aaj = 0;
	var aaz = 0;

	//근무지역 추가
	function formAreaAdd(){

		if(aai < area_sel.length) {
			area_sel[aai].style.display = "block";
		}else{
			alert("최대 3개 까지이며 더 이상 추가하실 수 없습니다.");
		}
		aai++;

	}

	//업,직종선택 추가
	function formJobtypeAdd(){

		if(aaj < jobtype_sel.length) {
			jobtype_sel[aaj].style.display = "block";
		}else{
			alert("최대 3개 까지이며 더 이상 추가하실 수 없습니다.");
		}
		aaj++;
	}

	//이미지등록 추가
	function formImageFormAdd(state){

		var frm	= document.regiform;

		if (state == "add")
		{
			if(aaz < image_regist.length) {
				image_regist[aaz].style.display = "block";
			}else{
				alert("최대 5개 까지이며 더 이상 추가하실 수 없습니다.");
			}
			aaz++;
		}

		if (state == "reset")
		{
			frm.img1.select();
			document.execCommand('Delete');
			frm.img_text1.select();
			document.execCommand('Delete');

			frm.img2.select();
			document.execCommand('Delete');
			frm.img_text2.select();
			document.execCommand('Delete');

			frm.img3.select();
			document.execCommand('Delete');
			frm.img_text3.select();
			document.execCommand('Delete');

			frm.img4.select();
			document.execCommand('Delete');
			frm.img_text4.select();
			document.execCommand('Delete');

			frm.img5.select();
			document.execCommand('Delete');
			frm.img_text5.select();
			document.execCommand('Delete');

			image_regist[1].style.display = "none";
			image_regist[2].style.display = "none";
			image_regist[3].style.display = "none";
			image_regist[4].style.display = "none";

			aaz = 1;
		}
	}

	formAreaAdd();
	formJobtypeAdd();
	formImageFormAdd('add');
</script>
<!-- 근무지역 / 업,직종선택 / 이미지등록 폼추가 관련 JS end -->


<? }
?>