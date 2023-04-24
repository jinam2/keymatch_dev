<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 16:54:00 */
function SkyTpl_Func_3070949510 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!-- 지하철 노선도 선택폼 관련 JS -->
<script language="javascript" src="./js/underground.js"></script>
<!-- 정보입력폼 체크관련 JS start -->
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
		window.open("guin_woodae.php","ZipWin","width=500,height=265,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes");
	}

	function OpenLicense(){
		window.open("guin_license.php","License","width=615,height=340,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes");
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
		//guin_viewLayer('guin_layer_1',0);
		//guin_changeImg('guin_img_1',0);
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
			alert("초빙직급을 선택하세요.");
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
			alert('초빙정보 제목에 HTML태그(<,>)를 입력하실수는 없습니다.');
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

		//내용 체크
		if( CKEDITOR.instances['guin_main'].getData() == '' )
		{
			alert('모집내용을 입력해 주세요.');
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

function guin_career_checked()
{
	var form	= document.forms['regiform'];

	for ( var i = 0 ; i < form.guin_career.length ; i++ )
	{
		if ( form.guin_career[i].checked == true )
		{
			if ( form.guin_career[i].value == "경력" )
			{
				form.guin_career_year.disabled = false;
			}
			else
			{
				form.guin_career_year.disabled = true;
			}
		}
	}
}
</script>


<!-- FORM start -->
<form name="regiform" method="post" action="guin_regist.php" onsubmit="return check_Valid();" ENCTYPE="multipart/form-data" class="regist_form">
<input type="hidden" name="mode" value="add_ok">
<input type="hidden" name='logo_photo3' id="logo_photo3" value=''>
<input type="hidden" name="keyword" id="keyword" readonly value="" style="width:600px; margin-bottom:10px; background:#f1f1f1;" >

<div style="position:relative; padding-top:30px">
	<div class="noto500 font_25" style="color:#333333; letter-spacing:-1px; position:absolute; top:25px;">
	초빙정보 등록하기 <span class="noto400 font_16" style="color:#777777; letter-spacing:-1px; padding-left:5px;"><img src="img/form_icon1.gif" style="vertical-align:middle; margin-right:5px;">표시된 항목은 필수 입력사항입니다.</span>
	</div>
	<table cellpadding="0" cellspacing="0" style="width:100%; background:url('./img/menu_ling_bg.png') 0 bottom repeat-x; border-collapse:collapse; ">
		<tr>
			<td style="width:800px;">
			</td>
			<td>
				<table cellspacing="0" class="tab" cellpadding="0" style="width:100%; table-layout:fixed; border-collapse:collapse ">
					<tr>
						<td>
							<img src="img/tab_guin20_on.gif"  id="guin_img_1" style="cursor:pointer;" onClick="guin_viewLayer('guin_layer_1',0);guin_changeImg('guin_img_1',0);" alt="초빙정보" title="초빙정보" >
						</td>
						<td>
							<img src="img/tab_guin21_off.gif"  id="guin_img_2" style="cursor:pointer;" onClick="guin_viewLayer('guin_layer_2',0);guin_changeImg('guin_img_2',0);" alt="유료서비스 결제" title="유료서비스 결제" >
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
<!--등록탭시작-->
<div id="guin_layer_1" style="margin-top:20px">
	<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed;border-collapse: collapse;">
		<tr>
			<td style="vertical-align:top">
				<h3 class="noto500 font_25" style="padding:10px 0 15px 0; margin:0; letter-spacing:-1px;">기본정보</h3>
				<div style="border:3px solid #<?=$_data['배경색']['기본색상']?>; text-align:center">
					<input type="text" id="guin_title" name="guin_title" class="font_malgun font_16" style="width:100%; height:52px; line-height:52px; text-align:center;"  placeholder="초빙정보 제목을 입력해주세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '초빙정보 제목을 입력해주세요'">
				</div>
				<table cellpadding="0" cellspacing="0" style="width:100%" class="resister_company">
				<?include_template('guin_regist_head.html') ?>

				<tr>
					<th class="title">
						업종선택 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
					</th>
					<td class="sub">
						<table cellpadding="0" cellspacing="0" style="width:100%" class="resister_company">
							<tr>
								<td>
									<div id="jobtype_sel1" style="margin:3px 0;">
										<span class="h_form">
											<!-- { {type_job_type1.0}}{ {type_job_type1.1}} -->
											<select name="type1" id="type1" style="width:200px;">
												<?=$_data['type_opt1']?>

											</select>
											<select name="type_sub1" id="type_sub1" style="width:200px;">
												<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['1']?></option>
												<?=$_data['type_sub_opt1']?>

											</select>
											<select name="type_sub_sub1" id="type_sub_sub1" style="width:200px;">
												<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['2']?></option>
												<?=$_data['type_sub_sub_opt1']?>

											</select>
										</span>
									</div>
									<div id="jobtype_sel2" style="display:none; margin:5px 0;">
										<span class="h_form">
											<!-- { {type_job_type2.0}}{ {type_job_type2.1}} -->
											<select name="type2" id="type2" style="width:200px;">
												<?=$_data['type_opt2']?>

											</select>
											<select name="type_sub2" id="type_sub2" style="width:200px;">
												<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['1']?></option>
												<?=$_data['type_sub_opt2']?>

											</select>
											<select name="type_sub_sub2" id="type_sub_sub2" style="width:200px;">
												<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['2']?></option>
												<?=$_data['type_sub_sub_opt2']?>

											</select>
										</span>
									</div>
									<div id="jobtype_sel3" style="display:none; margin:5px 0;">
										<span class="h_form">
											<!-- { {type_job_type3.0}}{ {type_job_type3.1}} -->
											<select name="type3" id="type3" style="width:200px;">
												<?=$_data['type_opt3']?>

											</select>
											<select name="type_sub3" id="type_sub3" style="width:200px;">
												<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['1']?></option>
												<?=$_data['type_sub_opt3']?>

											</select>
											<select name="type_sub_sub3" id="type_sub_sub3" style="width:200px;">
												<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['2']?></option>
												<?=$_data['type_sub_sub_opt3']?>

											</select>
										</span>
									</div>
									<span class="font_14 noto400 font_tahoma" style="color:#999; letter-spacing:-1px">업/직종은 최대 3까지 선택가능 합니다.</span>
								</td>
								<td class="sub h_form" style="background:none; text-align:right;">
									<a class="h_btn_st2 icon_m uk-icon" uk-icon="icon:plus; ratio:0.8" onClick="formJobtypeAdd()">추가하기</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- 	<tr>
						<th class="title">
							업종선택 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
						</th>
						<td class="sub">
							<table cellpadding="0" cellspacing="0" style="width:100%" class="resister_company">
								<tr>
									<td>
										<div id="jobtype_sel1" style="margin:3px 0;">
											<span class="h_form">
												<?=$_data['type_job_type1']['0']?><?=$_data['type_job_type1']['1']?>

											</span>
										</div>
										<div id="jobtype_sel2" style="display:none; margin:5px 0;">
											<span class="h_form">
												<?=$_data['type_job_type2']['0']?><?=$_data['type_job_type2']['1']?>

											</span>
										</div>
										<div id="jobtype_sel3" style="display:none; margin:5px 0;">
											<span class="h_form">
												<?=$_data['type_job_type3']['0']?><?=$_data['type_job_type3']['1']?>

											</span>
										</div>
										<span class="font_14 noto400 font_tahoma" style="color:#999; letter-spacing:-1px">업/직종은 최대 3까지 선택가능 합니다.</span>
									</td>
									<td class="sub h_form" style="background:none; text-align:right;">
										<a class="h_btn_st2 icon_m uk-icon" uk-icon="icon:plus; ratio:0.8" onClick="formJobtypeAdd()">추가하기</a>
									</td>
								</tr>
							</table>
						</td>
					</tr> -->
					<tr>
						<th class="title">
							기관형태 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
						</th>
						<td class="sub pay"><?=$_data['희망회사규모']?></td>
					</tr>
					<tr>
						<th class="title">
							기관 로고 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
						</th>
						<td class="sub pay h_form">
							<input type='file' id="photo2" name='photo2' style="width:350px;" class="font_14">
							<span class="font_14 noto400 font_tahoma" style="color:#999; letter-spacing:-1px">사이즈 가로 100 X 53 px 권장</span>
						</td>
					</tr>


			 <tr>
						<th class="title">
							유형  <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
						</th>
						<td class="sub pay h_form">
					
<label class="h-radio" for=""><input type="radio" id="" name="" value="기타"> 
<span class="noto400 font_14">유형프로그램필요</span></label>
<label class="h-radio" for=""><input type="radio" id="" name="" value="기타"> 
<span class="noto400 font_14">유형프로그램필요</span></label>
<label class="h-radio" for=""><input type="radio" id="" name="" value="기타"> 
<span class="noto400 font_14">유형프로그램필요</span></label>
<label class="h-radio" for=""><input type="radio" id="" name="" value="기타"> 
<span class="noto400 font_14">유형프로그램필요</span></label>
<label class="h-radio" for=""><input type="radio" id="" name="" value="기타"> 
<span class="noto400 font_14">유형프로그램필요</span></label>
<label class="h-radio" for=""><input type="radio" id="" name="" value="기타"> 
<span class="noto400 font_14">유형프로그램필요</span></label>
						</td>
					</tr>

			 <tr>
						<th class="title">
							진료과  <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
						</th>
						<td class="sub pay h_form">
					<span class="h_form" style="display:inline-block; width:200px;">
					<select name="guin_sort_area">
						<option value="">--진료과--</option>
						<option value="임시직">프로그램체크해주세요</option></select>
					</span>


						</td>
					</tr>

					<tr>
						<th class="title">
							고용형태 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
						</th>
						<td class="sub pay2">
							<?=$_data['고용형태']?>

						</td>
					</tr>
					<tr>
						<th class="title">
							모집인원
						</th>
						<td class="sub pay h_form">
							<input type="text" name="howpeople" id="howpeople" style="width:100px; text-align:right; " > <span class="noto400 font_15">명</span>
						</td>
					</tr>
					<tr>
						<th class="title">
							초빙직급 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
						</th>
						<td class="sub pay">
							<span class="h_form" style="display:inline-block; width:200px;"><?=$_data['채용직급']?></span>
						</td>
					</tr>
					<tr>
						<th class="title">
							급여조건 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
						</th>
						<td class="sub">
							<div style="margin:0 0 10px 0" class="h_form check_radio">
								<label for="pay_type_gross" class="h-radio"><input type='radio' name='pay_type' value='gross' id="pay_type_gross"  style="width:13px; height:13px; vertical-align:middle; cursor:pointer" checked ><span></span></label>
								<label for="pay_type_gross" style="cursor:pointer;">GROSS(세전)</label>
								<label for="pay_type_net" class="h-radio"><input type='radio' name='pay_type' value='net' id="pay_type_net"  style="width:13px; height:13px; vertical-align:middle; cursor:pointer; margin-left:10px"><span></span></label>
								<label for="pay_type_net"  style="cursor:pointer;">NET(세후)</label>
							</div>
							<ul id="tabmenu" style="border-right:1px solid #dbdbdb; float:left">
								<li><a href="javascript:vold();">선택형</a></li>
								<li><a href="javascript:vold();">입력형</a></li>
							</ul>

							<div class="tabcontent" id="select1" style="float:left; margin-left:5px"><span class="h_form"><?=$_data['급여조건']?></span></div>
							<div class="tabcontent" id="select2" style="float:left; margin-left:5px">
								<span class="h_form"><select id='guin_pay_type' name='guin_pay_type' onChange='no_change_pay()' style="width:110px;"><?=$_data['연봉타입']?></select> <input type='text' id='guin_pay' name='guin_pay' value='<?=$_data['DETAIL']['guin_pay']?>' maxlength='15' style="width:150px; text-align:right;"></span> <span class="noto400 font_15">원</span>
								<span class="h_form"><a onClick="document.getElementById('guin_pay').value = '';" class="h_btn_st2">다시입력</a></span>
								<script type="text/javascript">
									no_change_pay();/*guin_pay 연봉타입 선택후 셀렉팅 되도록 하는 소스*/
									tabMenu('');/*텝소스 실행소스*/
								</script>
							</div>
							<p class="clear font_14 noto400" style="color:#999; letter-spacing:-1px; line-height:140%; padding-top:10px;">
								원하시는 급여조건에 대해서 선택형 또는 입력형 둘 중 하나를 선택하여 설정하여 주세요.<br/>입력형으로 작성하실 경우 금액입력 (만)원 단위 글자를 포함해서 작성하여 주세요. (예: 2400~3600만원)
							</p>
						</td>
					</tr>
					<tr>
						<th class="title">
							담당업무 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
						</th>
						<td class="sub h_form">
							<input type='text' name='guin_work_content' style="width:100%;" >
						</td>
					</tr>
				</table>
				<h3 class="noto500 font_25" style="padding:50px 0 15px 0; margin:0; border-bottom:2px solid #dfdfdf; letter-spacing:-1px;">지원자격</h3>
				<table cellpadding="0" cellspacing="0" style="width:100%" class="resister_company">
					<tr>
						<th class="title">경력사항</th>
						<td class="sub h_form">
							 <label for="careers_no" class="h-radio"><input type='radio' name='guin_career' value='무관' id="careers_no" checked  onClick="guin_career_checked()"><span class="noto400 font_15">무관</span></label>
							<label for="careers_new" class="h-radio"><input type='radio' name='guin_career' value='신입' id="careers_new"  style="margin-left:10px"  onClick="guin_career_checked()"><span class="noto400 font_15">신입</span></label>
							<label for="careers" class="h-radio"><input type='radio' name='guin_career' value='경력' id="careers" style="width:13px; height:13px; vertical-align:middle; cursor:pointer; margin-left:10px" onClick="guin_career_checked()"><span class="noto400 font_15">경력</span></label>
							<span style="display:inline-block; width:150px; margin:0 0 0 5px;"><label for="careers"><?=$_data['경력년수']?></label></span> <label class="guide_txt noto400 font_15" style="display:inline-block; vertical-align:middle;">이상</label>
							<script>guin_career_checked();</script>
						</td>
					</tr>
					<tr>
						<th class="title">최종학력</th>
						<td class="sub">
							<span class="h_form" style="display:inline-block; width:200px;"><?=$_data['최종학력']?></span>
						</td>
					</tr>
					<tr>
						<th class="title">성별</th>
						<td class="sub h_form">
							<label for="guin_gender_man" class="h-radio"><input type='radio' name='guin_gender' value='남자' id="guin_gender_man"><span class="noto400 font_15">남자</span></label>
							<label for="guin_gender_woman" class="h-radio"><input type='radio' name='guin_gender' value='여자' id="guin_gender_woman" style="margin-left:10px"><span class="noto400 font_15">여자</span></label>
							<label for="guin_gender_no" class="h-radio"><input type='radio' name='guin_gender' value='무관' id="guin_gender_no" style="margin-left:10px"" checked><span class="noto400 font_15">무관</span></label>
						</td>
					</tr>
					<tr>
						<th class="title">
							나이 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
						</th>
						<td class="sub h_form">
							<input type="text" name="guin_age" style="width:100px; text-align:right; padding-right:3px;" >
							<span class="font_15 noto400" style="color:#666666;">년 이후 출생자 (4자리)</span>
							<label for="age_chk" class='h-check'><input type="checkbox" name="age_chk" id="age_chk" value="제한없음" onclick="sel('age_chk','guin_age')"><span class="noto500 font_15" style='vertical-align:middle;'>제한없음</span></label>
						</td>
					</tr>
					<tr>
						<th class="title">
							결혼유무
						</th>
						<td class="sub h_form">
							<label for="wedding_noting" class="sub_txt radio_sel h-radio"><input type="radio" name="marriage_chk" value="무관" id="wedding_noting" checked><span class="noto400 font_15">무관</span></label>
							<label for="wedding_yes" class="sub_txt check_sel h-radio"><input type="radio" name="marriage_chk" value="기혼" id="wedding_yes"><span class="noto400 font_15">기혼</span></label>
							<label for="wedding_no" class="sub_txt check_sel h-radio"><input type="radio" name="marriage_chk" value="미혼"  id="wedding_no"><span class="noto400 font_15">미혼</span></label>
						</td>
					</tr>
					<tr>
						<td class="sub" colspan="2">
							<p class="font_15 noto400" style="letter-spacing:-1px; line-height:140%">
								모집 초빙에서 <span style="color:#e45858">남녀를 차별</span>하거나, <span style="color:#e45858">여성근로자</span>를 초빙할 때 직무수행에 불필요한 용모, 키, 체중 등의 신체조건, 미혼조건을 제시 또는 요구하는 경우는<br/>
								<span style="color:#e45858">남녀고용 평등과 일,가정 양립 지원에 관한 법률 위반</span>에 따른 <strong>500만원 이하의 벌금</strong>이 부과될 수 있습니다. </br>
								모집 초빙에서 합리적인 이유 없이 연령제한을 하는 경우는 연령차별금지법 위반에 따른 <strong>500만원 이하의 벌금</strong>이 부과될 수 있습니다.
							</p>
						</td>
					</tr>
				</table>
				<h3 class="noto500 font_25" style="padding:50px 0 15px 0; margin:0; border-bottom:2px solid #dfdfdf; letter-spacing:-1px;">우대사항</h3>
				<table cellpadding="0" cellspacing="0" style="width:100%" class="resister_company">
					<tr>
						<th class="title">우대조건</th>
						<td class="sub h_form">
							<input type="text" name="woodae" onclick="OpenWooDae()"  style="width:515px; background:#f1f1f1;" readonly>
							<a onclick="OpenWooDae()" class="h_btn_st2">선택하기</a>
						</td>
					</tr>
					<tr>
						<th class="title">자격증</th>
						<td class="sub h_form">
							<input type="text" name="guin_license" onclick="OpenLicense()"  style="width:515px; background:#f1f1f1;" readonly>
							<a onclick="OpenLicense()" class="h_btn_st2">선택하기</a>
						</td>
					</tr>
					<tr>
						<th class="title">외국어능력</th>
						<td class="sub">
							<div style="position:relative">
								<table cellpadding="0">
									<tr>
										<td class="h_form"><?=$_data['외국어명1']?></td>
										<td class="h_form">
											<span class="noto400 font_15" style="padding:0 10px 0 15px">공인시험</span>
											<input type="text" name="lang_type1" style="width:200px;">
											<span class="noto400 font_15" style="padding:0 10px 0 15px">점수/급수</span>
											<input type="text" id="lang_point1" name="lang_point1" style="width:100px;" >
										</td>
									</tr>
										<td class="h_form" style="padding-top:5px"><?=$_data['외국어명2']?></td>
										<td class="h_form" style="padding-top:5px">
											<span class="noto400 font_15" style="padding:0 10px 0 15px">공인시험</span>
											<input type="text" id="lang_type2" name="lang_type2" style="width:200px;" >
											<span class="noto400 font_15" style="padding:0 10px 0 15px">점수/급수</span>
											<input type="text" name="lang_point2" style="width:100px;" >
										</td>
									</tr>
								</table>
								<p class="font_15 noto400" style="letter-spacing:-1px; line-height:140%; padding-top:10px; color:#999">
									취득하신 외국어능력 공인시험 및 점수(급수) 정보를 입력하시면 됩니다. 최대 2개까지 입력하실 수 있습니다.<br/>
									<span style="text-decoration:underline; color:#666666; font-weight:bold">외국어능력 시험종류 및 점수(급수) 정보</span> <a href="#popup" onClick="foreignLangInfo('view');"><img src="img/btn_help_simple3.gif" alt="도움말버튼" align="absmiddle" title="참고정보" width="16" height="16"></a>
								</p>
								<!-- 외국어능력 시험정보 및 점수(급수) 정보 팝업 레이어 start -->
								<div id="foreign_lang_help" style="display:none;">
									<div style="padding:10px 10px 0 10px;">
										<table cellspacing="0" style="width:100%;">
										<tr>
											<td><div class="font_st_12"><b>외국어능력 시험정보 및 등급방식 정보</b></div></td>
											<td align="right"><div class="btn_popup_close"><img src="img/btn_off.gif"  style="cursor:pointer;" onClick="foreignLangInfo('close')" title="팝업닫기"></div></td>
										</tr>
										</table>
									</div>


									<div class="foreign_info">
										<table cellpadding="0" cellspacing="0">
										<tr>
											<th nowrap>외국어</th>
											<th nowrap>공인시험</th>
											<th nowrap>등급방식</th>
										</tr>

										<!-- 영어 -->
										<tr>
											<td rowspan="15" valign="top">영어</td>
											<td>TOEIC</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>TOEIC(Speaking)</td>
											<td>1급~9급</td>
										</tr>
										<tr>
											<td>TOEIC(S&W)</td>
											<td>1급~9급</td>
										</tr>
										<tr>
											<td>TOEFL(PBT)</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>TOEFL(CBT)</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>TOEFL(iBT)</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>TEPS</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>IELTS</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>G-TELP(GLT)</td>
											<td>1급~5급</td>
										</tr>
										<tr>
											<td>G-TELP(GST)</td>
											<td>1급~5급</td>
										</tr>
										<tr>
											<td>SLEP</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>GRE</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>GMAT</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>PELT</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>OPIc</td>
											<td>급수<br>S, AH, AM, AL IH<br> IM, IL, NH, NM, NL</td>
										</tr>

										<!-- 일어 -->
										<tr>
											<td rowspan="5" valign="top">일어</td>
											<td>JPT</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>JLPT</td>
											<td>1급~4급</td>
										</tr>
										<tr>
											<td>新JLPT</td>
											<td>급수 (N1~N5)</td>
										</tr>
										<tr>
											<td>JTRA</td>
											<td>1급~4급</td>
										</tr>
										<tr>
											<td>NPT</td>
											<td>1급~4급</td>
										</tr>

										<!-- 중국어 -->
										<tr>
											<td rowspan="3" valign="top">중국어</td>
											<td>HSK</td>
											<td>1급~11급</td>
										</tr>
										<tr>
											<td>新HSK</td>
											<td>1급~6급</td>
										</tr>
										<tr>
											<td>HSK회화</td>
											<td>급수 (초,중,고)</td>
										</tr>

										<!-- 독일어 -->
										<tr>
											<td rowspan="4" valign="top">독일어</td>
											<td>ZDAF</td>
											<td>급 (취득)</td>
										</tr>
										<tr>
											<td>ZMP</td>
											<td>급 (취득)</td>
										</tr>
										<tr>
											<td>GDS</td>
											<td>급 (취득)</td>
										</tr>
										<tr>
											<td>KDS</td>
											<td>급 (취득)</td>
										</tr>

										<!-- 프랑스어 -->
										<tr>
											<td rowspan="2" valign="top">프랑스어</td>
											<td>DELF</td>
											<td>1급~2급</td>
										</tr>
										<tr>
											<td>DALF</td>
											<td>급 (취득)</td>
										</tr>

										<!-- 러시아어 -->
										<tr>
											<td valign="top">러시아어</td>
											<td>DELF</td>
											<td>
												기초단계, 기본단계<br> 1단계, 2단계, 3단계, 4단계
											</td>
										</tr>

										<!-- 스페인어 -->
										<tr>
											<td valign="top">스페인어</td>
											<td>DELF</td>
											<td>
												급수 (초,중,고)
											</td>
										</tr>
										</table>
									</div>
								</div>
								<!-- 외국어능력 시험정보 및 점수(급수) 정보 팝업 레이어 end -->
							</div>
						</td>
					</tr>
				</table>
				<h3 class="noto500 font_25" style="padding:50px 0 15px 0; margin:0; border-bottom:2px solid #dfdfdf; letter-spacing:-1px;">근무환경</h3>
				<table cellpadding="0" cellspacing="0" style="width:100%" class="resister_company">
					<tr>
						<th class="title">
							근무지역 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
						</th>
						<td class="sub h_form">
							<span id="area_sel1" style="width:700px">
								<?=$_data['si_info_1']?> <a class="h_btn_st2 icon_m uk-icon" uk-icon="icon:plus; ratio:0.8" onClick="formAreaAdd()">추가하기</a>
								<span class="font_15 noto400" style="letter-spacing:-1px; color:#999">( 최대 3개 )</span>
							</span>
							<span id="area_sel2" style="width:700px; display:none; margin:3px 0 3px 0;"><?=$_data['si_info_2']?></span>
							<span id="area_sel3" style="width:700px; display:none;"><?=$_data['si_info_3']?></span>
						</td>
					</tr>
					<tr>
						<th class="title">
							위치기반 주소 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
						</th>
						<td class="sub">
							<div class="h_form" style="margin-bottom:5px">
								<input type='text' id="user_zip" name='user_zip' value='<?=$_data['MEM']['user_zip']?>' style="width:200px;" >
								<a onClick="window.open('http://<?=$_data['zipcode_site']?>/zonecode/happy_zipcode.php?ht=1&hys=<?=$_data['base64_main_url']?>&hyf=user_zip|user_addr1|user_addr2|<?=$_data['zipcode_add_get']?>','happy_zipcode_popup_<?=$_data['base64_main_url']?>', 'width=600,height=600,scrollbars=yes');" class="h_btn_st2">우편번호검색</a>
							</div>
							<div class="h_form" style="margin-bottom:5px">
								<input type='text' id="user_addr1" name='user_addr1' value='<?=$_data['MEM']['user_addr1']?>'  style="width:400px">
							</div>
							<div class="h_form">
								<input type='text' id="user_addr2" name='user_addr2' value='<?=$_data['MEM']['user_addr2']?>'style="width:400px">
							</div>
							<p class="font_15 noto400" style="letter-spacing:-1px; line-height:140%; padding-top:10px; color:#999">
								내 주변 초빙정보 에서 사용되는 주소입니다
							</p>
						</td>
					</tr>
					<tr>
						<th class="title">
							인근지하철
						</th>
						<td class="sub h_form">
							<span class="regist_subway_select" style="display:inline-block; width:300px;">
								<script type="text/javascript">
								make_underground('0','0')
								</script>
							</span><br>
							<input type="text" id="subway_txt" name="subway_txt" value="<?=$_data['DETAIL']['subway_txt']?>" style="width:300px;">
							<p class="font_15 noto400" style="letter-spacing:-1px; line-height:140%; padding-top:10px; color:#999">
								인근 지하철 정보를 선택하여 주시고, 필요에 따라 추가정보를 입력하여 주세요 .(예: 2호선 반고개역에서 도보로 500m 이내)
							</p>
						</td>
					</tr>
					<tr>
						<th class="title">
							근무요일
						</th>
						<td class="sub h_form">
							<input type="text" name="work_week" value="<?=$_data['DETAIL']['work_week']?>" style="width:300px;" >
							<p class="font_15 noto400" style="letter-spacing:-1px; line-height:140%; padding-top:10px; color:#999">
							(예: 월~금(주5일), 월~토(토요일 격주휴무), 월~토, 격일근무, 기타)
							</p>
						</td>
					</tr>
					<tr>
						<th class="title">
							근무시간
						</th>
						<td class="sub h_form">
							<?=$_data['WorkTime1']?> <?=$_data['WorkTime2']?> <?=$_data['WorkTime3']?> ~ <?=$_data['WorkTime4']?> <?=$_data['WorkTime5']?> <?=$_data['WorkTime6']?>

						</td>
					</tr>
					<tr>
						<th class="title" style="vertical-align:top; padding-top:20px; ">
							복리후생
						</th>
						<td class="sub pay3" >
							<?=$_data['복리후생']?>

						</td>
					</tr>
				</table>

			</td>
		</tr>
	</table>

	<table cellspacing="0" cellpadding="0" style="width:100%; margin-top:40px">
	<tr>
		<td style="width:850px; padding-right:30px;  vertical-align:top">
			<h3 class="noto500 font_25" style="padding:20px 0 15px 0; margin:0; border-top:2px solid #dfdfdf; letter-spacing:-1px;">접수기간 및 방법 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;"></h3>
			<table cellpadding="0" cellspacing="0" style="width:100%; margin-bottom:25px" class="resister_company">
			<tr>
				<th class="title" style="">접수기간 </th>
				<td class="sub h_form">
					<input name="guin_end_date" type="text" maxlength="10" value='' style="width:135px;" ><a href="javascript:void(0)" class="h_btn_square uk-icon" uk-icon="icon:calendar; ratio:1" style="margin-left:3px;" onclick="if(self.gfPop)gfPop.fPopCalendar(document.regiform.guin_end_date);return false;" HIDEFOCUS></a>
					<label for="guin_choongwon" class="h-check"><input type="checkbox" name="guin_choongwon" id="guin_choongwon" value="1" onclick="sel('guin_choongwon','guin_end_date')"><span class="noto500 font_15" style="vertical-align:middle;">충원시</span></label>

				</td>
			</tr>
			<tr>
				<th class="title" style="vertical-align:top; padding-top:15px">접수방법</th>
				<td class="sub pay2">
					<?=$_data['접수방법']?>

				</td>
			</tr>
			</table>

			<h3 class="noto500 font_25" style="padding:20px 0 15px 0; margin:0; border-top:2px solid #dfdfdf; letter-spacing:-1px;">사전인터뷰</h3>
			<table cellpadding="0" cellspacing="0" style="width:100%; margin-bottom:25px" class="resister_company">
			<tr>
				<td class="sub h_form">
					<textarea name="guin_interview" id="guin_interview"  style="height:110px;"  onfocus="javascript:interviewval()"></textarea>
				</td>
			</tr>
			</table>
			<p class="font_14 noto400" style="letter-spacing:-1.2px; color:#666666; line-height:140%; margin-top:5px; margin-bottom:15px; text-align:left">
				사전인터뷰 질문을 등록하시면 온라인 입사지원시 지원자가 이력서와 함께 질문에 대한 답변을 작성해서 보냅니다.<br/>
				<span style="color:#<?=$_data['배경색']['기타페이지2']?>">지원자가 보낸 답변은 지원자 파악 및 서류합격자 선별에 도움이 될 수 있습니다.</span><br/><br/>
				지원자의 답변은 초빙정보의 지원자 현황에서 확인합니다.<br/>
				1개 이상의 질문을 원하시면 [Enter]키로구분해서 입력
			</p>

			<h3 class="noto500 font_25" style="padding:20px 0 15px 0; margin:0; border-top:2px solid #dfdfdf; letter-spacing:-1px;">키워드선택</h3>
			<div style="padding:20px; height:187px; border:1px solid #bdbdc0; background:#fff; overflow-x:hidden; overflow-y:scroll; line-height:140%;" >
				<?=$_data['키워드내용']?>

			</div>


		</td>
		<td style=" border:1px solid #dfdfdf; background:#f9fafb; padding:0 28px 28px 28px; vertical-align:top">

			<h3 class="noto500 font_25" style="padding:20px 0 15px 0; margin:0; letter-spacing:-1px;">담당자 정보</h3>
			<table cellpadding="0" cellspacing="0" style="width:100%; margin-bottom:25px" class="resister_ppl">
				<tr>
					<th class="title">담당자명 </th>
					<td class="sub h_form">
						<input type="text" name="guin_name" value="<?=$_data['MEM']['regi_name']?>" >
					</td>
				</tr>
				<tr>
					<th class="title">회사명</th>
					<td class="sub h_form">
						<input type="text" name="com_name" value='<?=$_data['MEM']['com_name']?>' <?=$_data['MEM']['read_only']?>>
					</td>
				</tr>
				<tr>
					<th class="title">연락처 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;"></th>
					<td class="sub h_form">
						<input type="text" name="guin_phone" value="<?=$_data['MEM']['com_phone']?>">
					</td>
				</tr>
				<tr>
					<th class="title">이메일</th>
					<td class="sub h_form">
						<input type="text" name="guin_email" value="<?=$_data['MEM']['com_email']?>">
					</td>
				</tr>
				<tr>
					<th class="title">팩스</th>
					<td class="sub h_form">
						<input type="text" name="guin_fax"  value="<?=$_data['MEM']['com_fax']?>">
					</td>
				</tr>
				<tr>
					<th class="title">홈페이지</th>
					<td class="sub h_form">
						<input type="text" name="guin_homepage" value="<?=$_data['MEM']['user_homepage']?>">
					</td>
				</tr>
			</table>


			<div style="margin-top:30px">
				<?echo happy_banner('유료옵션배너안내','배너제목','랜덤') ?>

			</div>
			<div style="margin-top:30px">
				<?echo happy_banner('패키지옵션안내','배너제목','랜덤') ?>

			</div>

		</td>
	</tr>
	</table>




	<h3 class="noto500 font_25" style="padding:50px 0 15px 0; margin:0; letter-spacing:-1px;">상세정보 및 이미지 등록</h3>
	<div>
		<!-- 위지윅 시작 -->
		<?echo happy_wys_css('ckeditor','./') ?>

		<?echo happy_wys_js('ckeditor','./') ?>

		<?echo happy_wys('ckeditor','가로100%','세로450','guin_main','','./','happycgi_normal','all') ?>

		<!-- 위지윅끝 -->
	</div>
	<table cellpadding="0" cellspacing="0" style="width:100%" class="resister_company">
		<tr>
			<th class="title">
				이미지등록 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
			</th>
			<td class="sub" style="text-align:right">
				<span class="font_14 noto400" style="display:inline-block; letter-spacing:-1px; line-height:140%; color:#999; padding-right:40px">이미지등록은 추가버튼을 클릭하시면 되며, 최대 5개까지 등록하실 수 있습니다.다시를 클릭하시면 선택한 파일의 파일경로명 값 및 파일설명이 초기화 됩니다. </span>
				<input type="button" value="" onClick="formImageFormAdd('reset')" style="background:url('img/btn_category_onemore.gif') no-repeat; width:85px; height:30px;  cursor:pointer;">
				<input type="button" value="" onClick="formImageFormAdd('add')"  style="background:url('img/btn_category_add.gif') no-repeat; width:85px; height:30px; cursor:pointer;">
			</td>
		</tr>
		<tr>
			<td class="sub" colspan="2">
				<div id="num1" class="regist_image h_form">
					<input type="file" name="img1">
					<input type="text" name="img_text1" class="font_14 noto400" style="letter-spacing:-1px; color:#b6b6b6; margin-top:5px" placeholder="파일설명을 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '파일설명을 입력하세요'" />
				</div>

				<div id="num2" class="regist_image h_form" style="margin-top:10px">
					<input type="file" name="img2">
					<input type="text" name="img_text2" class="font_15 noto400" style="letter-spacing:-1px; color:#b6b6b6; margin-top:5px" placeholder="파일설명을 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '파일설명을 입력하세요'" />
				</div>

				<div id="num3" class="regist_image h_form" style="margin-top:10px">
					<input type="file" name="img3">
					<input type="text" name="img_text3" class="font_15 noto400" style="letter-spacing:-1px; color:#b6b6b6; margin-top:5px" placeholder="파일설명을 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '파일설명을 입력하세요'" />
				</div>

				<div id="num4" class="regist_image h_form" style="margin-top:10px">
					<input type="file" name="img4">
					<input type="text" name="img_text4" class="font_15 noto400" style="letter-spacing:-1px; color:#b6b6b6; margin-top:5px" placeholder="파일설명을 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '파일설명을 입력하세요'" />
				</div>

				<div id="num5" class="regist_image h_form" style="margin-top:10px">
					<input type="file" name="img5">
					<input type="text" name="img_text5" class="font_15 noto400" style="letter-spacing:-1px; color:#b6b6b6; margin-top:5px" placeholder="파일설명을 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '파일설명을 입력하세요'" />
				</div>
			</td>
		</tr>
	</table>
	<h3 class="noto500 font_25" style="padding:50px 0 15px 0; margin:0; letter-spacing:-1px; border-bottom: 2px solid #dfdfdf; <?=$_data['inquiry_use_display']?>">문의하기</h3>
	<table cellpadding="0" cellspacing="0" style="width:100%; <?=$_data['inquiry_use_display']?>" class="resister_company">
		<tr>
			<th class="title">
				문의하기 사용여부
			</th>
			<td class="sub h_form" style="text-align:right">
				<label for='inquiry_use_y' class="h-radio"><input type='radio' name='inquiry_use' value='y' <?=$_data['inquiry_use_checked1']?> id='inquiry_use_y' style="height:13px; width:13px; vertical-align:middle;"><span></span></label>
				<label for='inquiry_use_y' style="vertical-align:middle"><span class="noto500" style="font-size:20px; color:#459ef9;">ON</span> <span class="noto400 font_15"style="color:#459ef9;">사용함</span></label>
				<label for='inquiry_use_n' class="h-radio"> <input type='radio' name='inquiry_use' value='n' <?=$_data['inquiry_use_checked2']?> id='inquiry_use_n' style="height:13px; width:13px; vertical-align:middle;"><span></span></label>
				<label for='inquiry_use_n' style="vertical-align:middle"> <span class="noto500" style="font-size:20px; color:#ef4141;">OFF</span> <span class="noto400 font_15"style="color:#ef4141;">사용안함</span></label>
			</td>
		</tr>
	</table>
	<div style="margin:30px 0 40px 0;" align="center">
		<table cellspacing="0" style="width:100%;">
		<tr>
			<td align="center">
				<table cellspacing="0">
					<tr>
						<td>
							<?=$_data['PAY']['free']?>

							<a href='#pay_move' onClick="guin_viewLayer('guin_layer_2',0);guin_changeImg('guin_img_2',0);">
								<img src="img/skin_icon/make_icon/skin_icon_697.jpg" title="유료서비스결제바로가기" alt="유료서비스결제바로가기" style="vertical-align:middle">
							</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		</table>
	</div>
</div>
<!--등록탭끝-->



<!--유료탭시작-->
<div id="guin_layer_2" style="display:none">
<a name='pay_move'></a>
	<div style="margin-top:20px; border:1px solid #ddd; box-sizing:border-box;">
		<?echo happy_banner('등록페이지유료배너','배너제목','랜덤') ?>

	</div>



	<input type="hidden" name="pack2_now_price" id="pack2_now_price" value="0">
	<input type='hidden' name='pack2_all_number' value='<?=$_data['script_pack2_all']?>'>
	<!-- 패키지즉시적용박스 END -->
	<h3 class="guin_d_tlt_st02">
		 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>광고노출 서비스
	</h3>
	<?=$_data['초빙정보결제페이지']?>


	<div style="margin:30px 0 40px 0;" align="center">
		<table cellspacing="0">
			<tr>
				<td><span id="uryo_button_layer"><?=$_data['등록버튼']?></span></td>
				<td>
					<div id="free_button_layer" style="">
						<table cellspacing="0">
							<td><?=$_data['PAY']['free']?></td>
							<td>
								<a href="member_option_pay_package.php" target="_blank" >
									<img src="img/skin_icon/make_icon/skin_icon_699.jpg" align="absmiddle" style="padding-left:5px">
								</a>
							</td>
						</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>

	<?=$_data['PAY']['loading_script']?>

<!-- 결제등록 및 무료등록 버튼 end -->

</form>
<!-- FORM end -->



<!-- 금액관련 JS -->
<?=$_data['PAY']['loading_script']?>


</div>
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