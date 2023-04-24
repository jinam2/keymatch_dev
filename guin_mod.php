<?php
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");
include ("./inc/happy_sms.php");
//print_r2($_POST);exit;
if (!$master_check)
{
	if ( !happy_member_secure($happy_member_secure_text[1].'등록') )
	{
		gomsg($happy_member_secure_text[1].'등록'."권한이 없습니다.","./happy_member_login.php");
		exit;
	}
}
else
{
	//print "<html><title>슈퍼관리자로그인중</title>";
}

upload_dir_check($per_document_pic."/".date("Y"));
upload_dir_check($per_document_pic."/".date("Y")."/".date("m"));
$per_document_pic2 = $per_document_pic."/".date("Y")."/".date("m");


$temp = "$guin_list";
//현재위치
$now_stand = "$prev_stand > <a href=./guin_list.php>구인정보</a> > 구인정보 수정";

//수정화면 출력
if ( $mode == "mod" )
{
	$widthSize	= 1;
	$heightSize	= 30;
	$tableSize	= 600;
	$Template1	= "job_per_doc_type3_keyword1.html";
	$Template2	= "job_per_doc_type3_keyword2.html";

	$키워드내용	= keyword_extraction_list( $widthSize, $heightSize , $tableSize, $Template1 , $Template2 , $cutSize="","guin");

	$sql = "select * from $guin_tb where number='$num'";
	$result = query($sql);
	$DETAIL = happy_mysql_fetch_array($result);

	//PC 에서 등록한 정보는 모바일에서 수정할 수 없다.
	if( $_COOKIE['happy_mobile'] == 'on' && $DETAIL['regist_mobile'] == 'n' )
	{
		error("PC에서 등록한 정보는 모바일에서 수정 할 수 없습니다.");exit;
	}

	if ($DETAIL[type1])
	{
		$add_location1 = "<a href=guin_list.php?guzic_jobtype1=$DETAIL[type1]>".$TYPE_ARRAY_NAME[$DETAIL['type1']] . "</a>";
	}
	if ($DETAIL[type_sub1])
	{
		$add_location2 = "<a href=guin_list.php?guzic_jobtype1=$DETAIL[type1]&guzic_jobtype2=$DETAIL[type_sub1]>". $TYPE_SUB_NAME[$DETAIL["type_sub1"]] . "</a>";
	}


	if ( $master_check )
	{
		$member_id = $DETAIL["guin_id"];
	}

	#이전페이지 입력
	$prev_url = $HTTP_REFERER;
	$sql = "select * from $happy_member where user_id ='$member_id'";
	$result = query($sql);
	$MEM = happy_mysql_fetch_array($result);

	$MEM['id'] = $MEM['user_id'];
	$MEM['etc1'] = $MEM['photo2'];
	$MEM['etc2'] = $MEM['photo3'];
	$MEM['com_job'] = $MEM['extra13'];
	$MEM['com_profile1'] = nl2br($MEM['message']);
	$MEM['com_profile2'] = nl2br($MEM['memo']);
	$MEM['boss_name'] = $MEM['extra11'];
	$MEM['com_open_year'] = $MEM['extra1'];
	$MEM['com_worker_cnt'] = $MEM['extra2'];
	$MEM['com_zip'] = $MEM['user_zip'];
	$MEM['com_addr1'] = $MEM['user_addr1'];
	$MEM['com_addr2'] = $MEM['user_addr2'];
	$MEM['regi_name'] = $MEM['extra12'];
	$MEM['com_phone'] = $MEM['user_hphone'];
	$MEM['com_fax'] = $MEM['user_fax'];
	$MEM['com_email'] = $MEM['user_email'];
	$MEM['com_homepage'] = $MEM['user_homepage'];
	$MEM['sms_ok'] = $MEM['sms_forwarding'];
	$MEM['com_cell'] = $MEM['user_hphone'];



	#관리자는 회사명수정가능
	if (!$master_check)
	{
		$MEM[read_only] = "readonly";
	}

	#구인메일을 위한 정리
	//$DETAIL[guin_main] = ereg_replace("\n", "", $DETAIL[guin_main]);
	//$DETAIL[guin_main] = ereg_replace("\r", "", $DETAIL[guin_main]);
	//$DETAIL[guin_main] = ereg_replace('"', '\"', $DETAIL[guin_main]);
	//$DETAIL[guin_main] = ereg_replace("'", "\\'", $DETAIL[guin_main]);
	$DETAIL[guin_type_temp] = make_radiobox($job_arr,2,guin_type,guin_type,$DETAIL[guin_type]);

	//성별분류
	$guin_gender_checked = Array();
	switch ( $DETAIL['guin_gender'] )
	{
		case "남자"	: $guin_gender_checked[0] = 'checked'; break;
		case "여자"	: $guin_gender_checked[1] = 'checked'; break;
		default		: $guin_gender_checked[2] = 'checked';
	}

	//경력여부
	$guin_career_checked = Array();
	switch ( $DETAIL['guin_career'] )
	{
		case "신입"	: $guin_career_checked[0] = 'checked'; break;
		case "경력"	: $guin_career_checked[1] = 'checked'; break;
		default		: $guin_career_checked[2] = 'checked';
	}


	//급여조건(세전/세후)
	$guin_pay_type_checked = Array();
	switch ( $DETAIL['pay_type'] )
	{
		case "gross"	: $guin_pay_type_checked[0] = 'checked'; break;
		case "net"		: $guin_pay_type_checked[1] = 'checked'; break;
		default			: $guin_pay_type_checked[0] = 'checked';
	}

	//충원시
	$guin_choongwon_checked	= ( $DETAIL['guin_choongwon'] == '' OR $DETAIL['guin_choongwon'] == '0' ) ? '' : 'checked';

	//나이제한
	$DETAIL['guin_age']		= $DETAIL['guin_age'] == 0 ? '' : $DETAIL['guin_age'];
	$guin_age_checked		= $DETAIL['guin_age'] == 0 ? 'checked' : '';


	#언어부분 값정리
	list($DETAIL[lang_title1],$DETAIL[lang_type1],$DETAIL[lang_point1],$DETAIL[lang_title2],$DETAIL[lang_type2],$DETAIL[lang_point2]) = split(",",$DETAIL[guin_lang]);


	//결혼유무
	$marriage_chk_checked = Array();
	switch ( $DETAIL['marriage_chk'] )
	{
		//case "상관없음"	: $marriage_chk_checked[0] = 'checked'; break;
		//case "유"		: $marriage_chk_checked[1] = 'checked'; break;
		//case "무"		: $marriage_chk_checked[2] = 'checked'; break;

		case "무관"		: $marriage_chk_checked[0] = 'checked'; break;
		case "기혼"		: $marriage_chk_checked[1] = 'checked'; break;
		case "미혼"		: $marriage_chk_checked[2] = 'checked'; break;
	}

	// 이미지첨부 처리
	$툴팁소스		= '';
	$aaz			= 0;
	for ( $i=1 ; $i<=5 ; $i++ )
	{
		$Happy_Img_Name = array();
		${"이미지Display".$i}	= "none";
		if ( $DETAIL["img".$i] != "" )
		{
			$aaz++;

			$filename	= $DETAIL["img".$i];
			$fileTmp	= explode(".",$filename);
			$fileExt	= $fileTmp[sizeof($fileTmp)-1];
			//$filename	= str_replace(".".$fileExt, "_thumb.".$fileExt, $filename);

			$Happy_Img_Name[0] = $DETAIL["img".$i];
			$filename = happy_image("자동","200","133","로고사용함","로고위치7번","100","gif원본출력","./img/guin_noimg.gif","가로기준","");

			${"미리보기_".$i}	= "<br><img src='$filename'>";
			${"삭제".$i}		= "<span class='h_form'><label for='img_del".$i."'  title='등록한 이미지를 삭제하기 원하시면 체크해 주시면 됩니다.' class='h-check'><input type='checkbox' name='file${i}_del' id='img_del".$i."' value='ok' style='vertical-align:middle;'><span class='noto400 font_14'>삭제</span></label></span>";
			${"이미지Display".$i}	= "block";

			//구번젼 툴팁은 삭제
			//${"미리보기".$i}	= "<a href='#image_preview' onMouseover=\" ddrivetip('<IMG src=$filename border=0 width=200>','white')\" onMouseout='hideddrivetip()' title='등록한 이미지 미리보기'>미리보기</a>";
			${"미리보기".$i}	= "<a class='h_btn_st2' href='javascript:void(0);' data-tooltip='happy_tooltip_{$i}'>미리보기</a>";

			//YOON : 2011-10-20 등록된 이미지가 있을 경우의 class 명
			// 배경번호 이미지가 노출안되는 관계로 사용안함
			${"regist_image_true_flase".$i}		= "regist_image_true";

			//echo $DETAIL["img".$i].'<br />';
			$툴팁소스	.= "<div id='happy_tooltip_{$i}' class='atip'><img src='".$filename."' /></div>";
		}
		else
		{
			${"미리보기_".$i}	= "";
			${"삭제".$i}		= "";
			${"미리보기".$i}	= "";

			//YOON : 2011-10-20 등록된 이미지가 없을 경우의 class 명
			// 배경번호 이미지가 노출안되는 관계로 사용안함
			${"regist_image_true_flase".$i}		= "regist_image_false";

		}
	}


$si_info_1 = make_si_selectbox("si1","gu1","$DETAIL[si1]","$DETAIL[gu1]","110","120","regiform");
$si_info_2 = make_si_selectbox("si2","gu2","$DETAIL[si2]","$DETAIL[gu2]","110","120","regiform");
$si_info_3 = make_si_selectbox("si3","gu3","$DETAIL[si3]","$DETAIL[gu3]","110","120","regiform");
//$type_info_1 = make_type_selectbox("type1","type_sub1","$DETAIL[type1]","$DETAIL[type_sub1]","200","200","regiform");
//$type_info_2 = make_type_selectbox("type2","type_sub2","$DETAIL[type2]","$DETAIL[type_sub2]","200","200","regiform");
//$type_info_3 = make_type_selectbox("type3","type_sub3","$DETAIL[type3]","$DETAIL[type_sub3]","200","200","regiform");

// 카테고리 추가
$js_arr1			= get_type_selectbox($DETAIL['type1'],$DETAIL['type_sub1'],$DETAIL['type_sub_sub1']);
$type_opt1			= $js_arr1['type_opt'];
$type_sub_opt1		= $js_arr1['type_sub_opt'];
$type_sub_sub_opt1	= $js_arr1['type_sub_sub_opt'];

$js_arr2			= get_type_selectbox($DETAIL['type2'],$DETAIL['type_sub2'],$DETAIL['type_sub_sub2']);
$type_opt2			= $js_arr2['type_opt'];
$type_sub_opt2		= $js_arr2['type_sub_opt'];
$type_sub_sub_opt2	= $js_arr2['type_sub_sub_opt'];

$js_arr3			= get_type_selectbox($DETAIL['type3'],$DETAIL['type_sub3'],$DETAIL['type_sub_sub3']);
$type_opt3			= $js_arr3['type_opt'];
$type_sub_opt3		= $js_arr3['type_sub_opt'];
$type_sub_sub_opt3	= $js_arr3['type_sub_sub_opt'];

$js_arr	= get_type_selectbox_js();
$type2_key_js = $js_arr['type2_key_js'];
$type2_val_js = $js_arr['type2_val_js'];
$type3_key_js = $js_arr['type3_key_js'];
$type3_val_js = $js_arr['type3_val_js'];

#$복리후생 = make_checkbox($bokri_arr,5,bokri,bokri_chk,$DETAIL[guin_bokri]);
#복리후생패치함
$복리후생 = make_checkbox2($bokri_arr,$bokri_arr_title,5,bokri,bokri_chk,$DETAIL[guin_bokri]);

$DETAIL[guin_pay2] = $DETAIL[guin_pay_type] == '' ? $DETAIL[guin_pay] : '';
$DETAIL[guin_pay] = $DETAIL[guin_pay_type] == '' ? '' : $DETAIL[guin_pay];
$급여조건 = make_selectbox($money_arr,'--급여선택--',guin_pay2,$DETAIL[guin_pay2]);

//학력무관 한 채용정보 버그패치 2018-01-22 kad
$최종학력 = make_selectbox($edu_arr2,'--학력선택--',guin_edu,$DETAIL[guin_edu]);
$경력년수 = make_selectbox($career_arr,'--경력년수--',guin_career_year,$DETAIL[guin_career_year]);
$채용직급 = make_selectbox($grade_arr,'--직급선택--',guin_grade,$DETAIL[guin_grade]);
$외국어명1 = make_selectbox($lang_arr,'--외국어명--',lang_title1,$DETAIL[lang_title1]);
$외국어명2 = make_selectbox($lang_arr,'--외국어명--',lang_title2,$DETAIL[lang_title2]);
$접수방법 = make_checkbox2($guin_howjoin,$guin_howjoin,1,howjoin,howjoin_chk,$DETAIL[howjoin]);
$고용형태 = make_radiobox($job_arr,3,guin_type,guin_type, $DETAIL[guin_type]);
//$고용형태 = make_selectbox($job_arr,'--고용형태--',guin_type,$DETAIL[guin_type]);

//선택형인지 2013-07-16 kad
//print_r($DETAIL[guin_pay_type]);
/*
if ( in_array($DETAIL[guin_pay],$money_arr) && $DETAIL[guin_pay_type] == '' )
{
	$급여조건스크립트 = "showHideLayer(0);";
}
else
{
	$급여조건스크립트 = "showHideLayer(1);";
}
*/
//선택형인지 2013-07-16 kad
//print_r2($want_money_arr);
//$DETAIL[guin_pay_type]	= $DETAIL[guin_pay_type] == '' ? $want_money_arr[0] : $DETAIL[guin_pay_type];
$DETAIL[guin_pay_type]	= $DETAIL[guin_pay_type] == '' ? '' : $DETAIL[guin_pay_type];

$names	= Array("want_money_arr");
$return	= Array("연봉타입");
$vals	= Array($DETAIL[guin_pay_type]);

for ( $x=0,$xMax=sizeof($names) ; $x<$xMax ; $x++ )
{
	$options	= "<option value=''>- 선택 -</option>";
	for ( $i=0,$max=sizeof(${$names[$x]}) ; $i<$max ; $i++ )
	{
		$checked	= ( $vals[$x] == ${$names[$x]}[$i] )?"selected":"";
		$options	.= "<option value='".${$names[$x]}[$i]."' $checked >".${$names[$x]}[$i]."</option>\n";
	}
	$options = str_replace("\n","",$options);
	$options = str_replace("\r","",$options);

	${$return[$x]}	= $options;
}

$현재위치 = "$prev_stand > <a href=\"./happy_member.php?mode=mypage\">채용정보수정</a></li>
	";
//$현재위치 = "$prev_stand > <a href=member_info.php>회원정보</a>";


#추가된 필드들
#근무가능요일
$WeekDays = make_checkbox2(array_keys($TDayIcons),$TDayIconsTag,"7","work_day","work_day",$DETAIL['work_day'],"");
#근무시간
$StartWorkTime = explode("-",$DETAIL['start_worktime']);
$FinishWorkTime = explode("-",$DETAIL['finish_worktime']);
$WorkTime1 = make_selectbox2($TTime1,$TTime1,"","work_time1",$StartWorkTime[0],$select_width="110px");
$WorkTime2 = make_selectbox2($TTime2,$TTime2,"","work_time2",$StartWorkTime[1],$select_width="110px");
$WorkTime3 = make_selectbox2($TTime3,$TTime3,"","work_time3",$StartWorkTime[2],$select_width="110px");
$WorkTime4 = make_selectbox2($TTime1,$TTime1,"","work_time4",$FinishWorkTime[0],$select_width="110px");
$WorkTime5 = make_selectbox2($TTime2,$TTime2,"","work_time5",$FinishWorkTime[1],$select_width="110px");
$WorkTime6 = make_selectbox2($TTime3,$TTime3,"","work_time6",$FinishWorkTime[2],$select_width="110px");
#구인자
$GuinPerson = make_radiobox2($TGuinPerson,$TGuinPerson,2,"guinperson","guinperson",$DETAIL['guinperson']);
#학력
$GuinEducation = make_selectbox2($TEducation,$TEducation,"학력","guineducation",$DETAIL['guineducation'],$select_width="100");
#국적
$GuinNational = make_radiobox2($TNational,$TNational,4,"guinnational","guinnational",$DETAIL['guinnational']);
#파견업체연락
$SiCompany = make_radiobox2($TSiCompany,$TSiCompany,2,"guinsicompany","guinsicompany",$DETAIL['guinsicompany']);

//희망회사규모
$희망회사규모 = make_radiobox2($tHopeSize,$tHopeSize,5,"HopeSize","HopeSize",$DETAIL['HopeSize']);

//2018-07-27 모바일등록 추가 hun
if( $_COOKIE['happy_mobile'] == 'on' )
{
	$고용형태 = make_radiobox($job_arr,2,guin_type,guin_type,'정규직');
	$희망회사규모 = make_radiobox2($tHopeSize,$tHopeSize,2,"HopeSize","HopeSize",$DETAIL['HopeSize']);
	$복리후생 = make_checkbox2($bokri_arr,$bokri_arr_title,2,bokri,bokri_chk,$DETAIL[guin_bokri]);
	$접수방법 = make_checkbox2($guin_howjoin,$guin_howjoin,2,howjoin,howjoin_chk,'온라인이력서접수,전화접수');
}

//이미지삭제
if ( $DETAIL['photo2'] != "" )
{
	$value = $DETAIL['photo2'];
	if (eregi('.jp', $value) )
	{
		$value_thumb = str_replace(".jpg",".jpg",$value);
	}
	else
	{
		$value_thumb = $value;
	}

	$Happy_Img_Name[0] = "./".$value_thumb;
	$value_thumb = happy_image("자동","가로{$ComLogoDstW}","세로{$ComLogoDstH}","로고사용안함","로고위치7번","퀄리티100","gif원본출력","img/no_photo.gif","비율대로축소","2");

	$photo2_del = "<span class='h_form'><label for='photo2_del' class='h-check'><input id='photo2_del' name='photo2_del' type='checkbox' value='1'><span class='noto400 font_13'>회원정보의 기업로고 사용</span></label></span>";
	$photo2_미리보기 = "<img src='".$value_thumb."' border='0' width='".$ComLogoDstW."' height='".$ComLogoDstH."' onError=this.src='./img/noimage_del.jpg' style='margin-top:5px;'>";
}
if ( $DETAIL['photo3'] != "" )
{
	$value = $DETAIL['photo3'];
	if (eregi('.jp', $value) )
	{
		$value_thumb = str_replace(".jpg",".jpg",$value);
	}
	else
	{
		$value_thumb = $value;
	}

	$Happy_Img_Name[0] = "./".$value_thumb;
	$value_thumb = happy_image("자동","가로{$ComBannerDstW}","세로{$ComBannerDstH}","로고사용안함","로고위치7번","퀄리티100","gif원본출력","img/no_photo.gif","비율대로축소","2");

	$photo3_del = "<span class='h_form'><label for='photo3_del' class='h-check'><input id='photo3_del' name='photo3_del' type='checkbox' value='1'><span class='noto400 font_13'>회원정보의 기업광고용로고 사용</span></label></span>";
	$photo3_미리보기 = "<img src='".$value_thumb."' border='0' width='".$ComBannerDstW."' height='".$ComBannerDstH."' onError=this.src='./img/noimage_del.jpg' style='margin-top:5px;'>";
}
//이미지삭제

#업소문의설정 - hong 추가
$inquiry_use_display	= "display:none;";
if ( $HAPPY_CONFIG['inquiry_form_use_conf'] == "upche" )
{
	$inquiry_use_display	= "display:block;";
}
else if ( $HAPPY_CONFIG['inquiry_form_use_conf'] == "admin" && admin_secure("구인리스트") )
{
	$inquiry_use_display	= "display:block;";
}

switch ( $DETAIL['inquiry_use'] )
{
	case 'y'	: $inquiry_use_checked1 = "checked"; break;
	default		: $inquiry_use_checked2 = "checked"; break;
}

//echo "./$skin_folder/guin_mod.html";
$TPL->define("구인상세", "./$skin_folder/guin_mod.html");
$TPL->assign("구인상세");
$내용 = &$TPL->fetch();

$내용 = <<<END
<script language="javascript" src="calendar.js"></script>
<script>
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
	if (request.readyState == 1)  {
	window.status="로딩중....."
	}
}
</script>

	$내용
<!-- 아래 자바스크립트를 삭제하시면 안됩니다. -->
<script language="javascript" >
createLayer('Calendar');
</script>


END;



//YOON : 2011-10-19 : 회원그룹관리 지정 껍데기 템플릿파일로 변경
$happy_member_login_id	= happy_member_login_check();

$Member					= happy_member_information($happy_member_login_id);
$member_group			= $Member['group'];

$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
$Group					= happy_mysql_fetch_array(query($Sql));

$Template_Default				= ( $Group['mypage_default'] == '')? $happy_member_mypage_default_file : $Group['mypage_default'];

//YOON : 2011-11-26
//개인회원 로그인중이고, 관리자로 로그인중일 때 개인회원 껍데기 템플릿파일 적용되는 것을 방지
//$member_group		>> 1이면 개인회원, 2이면 기업회면
if ($member_group == 1)
{
	$Template_Default = "happy_member_default_mypage_com.html";
}

#echo $Template_Default;
$TPL->define("껍데기", "./$skin_folder/$Template_Default");
//$TPL->define("껍데기", "./$skin_folder/default_com.html");
$TPL->assign("껍데기");
echo $TPL->fetch();

exit;
}

//수정하고 돌아가기
elseif ( $mode == "mod_ok" ) {

	/*
	#복리는 1이없다
	$bokri_co = count($bokri_arr);
	for ( $h=0; $h<$bokri_co; $h++) {
		if ( $bokri[$h] == "on" ) {
			$guin_bokri .= "$bokri_arr[$h]>";
		}
	}
	*/
	#복리후생 부분 패치됨
	if ( is_array($_POST['bokri_chk']) )
	{
		$guin_bokri = @implode(">", (array) $_POST['bokri_chk']);
	}
	#복리후생 부분 패치됨


	//키워드 저장 안되던것 패치 - ranksa
	if ( is_array($_POST['job_keyword']) )
	{
		$keyword = @implode(", ", (array) $_POST['job_keyword']);
	}



	//태그 벗기기
	$guin_title = strip_tags($guin_title);
	$guin_work_content = strip_tags($guin_work_content);
	$guin_lang = 	$guin_lang = "$lang_title1,$lang_type1,$lang_point1,$lang_title2,$lang_type2,$lang_point2";
	#$guin_bokri = substr($guin_bokri,0,-1);
	$guin_woodae = $woodae;
	$guin_license = strip_tags($guin_license);
	$guin_interview = strip_tags($guin_interview);
	$guin_title = strip_tags($guin_title);
	$guin_work_content = strip_tags($guin_work_content);
	$guin_main = ereg_replace("’", "\'", $guin_main);

	#금지단어 체크
	if ( DenyWordCheck($guin_title,$TDenyWordList) )
	{
		error(" 사용하실수 없는 금지단어가 제목에 포함되어 있습니다.");
		exit;
	}
	#금지단어 체크

	#금지단어 체크
	if ( DenyWordCheck($guin_main,$TDenyWordList) )
	{
		error(" 사용하실수 없는 금지단어가 상세설명에 포함되어 있습니다.");
		exit;
	}
	#금지단어 체크



	$img1	= imageUpload($per_document_pic2,$guin_pic_width[0],$guin_pic_height[0],$guin_pic_width[1],$guin_pic_height[1],"90","img1","");
	$img2	= imageUpload($per_document_pic2,$guin_pic_width[0],$guin_pic_height[0],$guin_pic_width[1],$guin_pic_height[1],"90","img2","");
	$img3	= imageUpload($per_document_pic2,$guin_pic_width[0],$guin_pic_height[0],$guin_pic_width[1],$guin_pic_height[1],"90","img3","");
	$img4	= imageUpload($per_document_pic2,$guin_pic_width[0],$guin_pic_height[0],$guin_pic_width[1],$guin_pic_height[1],"90","img4","");
	$img5	= imageUpload($per_document_pic2,$guin_pic_width[0],$guin_pic_height[0],$guin_pic_width[1],$guin_pic_height[1],"90","img5","");



	//관리자도 로그인하고, 회원도 로그인했을때 이미지 교체되던 버그 처리 2013-08-29 kad
	if ( !admin_secure("구인리스트") )
	{
		//이미지 추가 회원정보에 업로드 하는 것하고 같게 처리해야 함
		$sql = "select * from $guin_tb where number='".$num."'";
		$result = query($sql);
		$DETAIL = happy_mysql_fetch_assoc($result);

		//이미지 추가 회원정보에 업로드 하는 것하고 같게 처리해야 함
		$Tmem = happy_member_information(happy_member_login_check());

	}
	else
	{
		//이미지 추가 회원정보에 업로드 하는 것하고 같게 처리해야 함
		$sql = "select * from $guin_tb where number='".$num."'";
		$result = query($sql);
		$DETAIL = happy_mysql_fetch_assoc($result);

		$Tmem = happy_member_information($DETAIL["guin_id"]);
	}
	//관리자도 로그인하고, 회원도 로그인했을때 이미지 교체되던 버그 처리 2013-08-29 kad

	//파일삭제
	for( $i=1; $i<=5; $i++ )
	{
		$fname = "img".$i;
		$fname2 = "file".$i."_del";

		if ( ($DETAIL[$fname] != "" && $$fname != "") || $$fname2 == "ok" )
		{
			//echo $DETAIL[$fname]."지우자<br>";
			unlink_with_thumb($DETAIL[$fname]);
		}
	}

	if ( $_POST['photo2_del'] == "1" )
	{
		$photo2 = $Tmem['photo2'];
	}
	else
	{
		$photo2 = ( $DETAIL['photo2'] != "" ) ? $DETAIL['photo2'] : $Tmem['photo2'];
	}

	if ( $_POST['photo3_del'] == "1" )
	{
		$photo3 = $Tmem['photo3'];
	}
	else
	{
		$photo3 = ( $DETAIL['photo3'] != "" ) ? $DETAIL['photo3'] : $Tmem['photo3'];
	}



	for ($i=2;$i<=3;$i++)
	{
		$nowField = 'photo'.$i;

		$WHERE = " and field_name = '$nowField' ";
		$Sql	= "SELECT * FROM $happy_member_field WHERE member_group = '$Tmem[group]' $WHERE ";
		$Record	= query($Sql);
		$Form = happy_mysql_fetch_assoc($Record);

		if ( $_FILES[$nowField]["name"] != "" )
		{
			#echo $nowField."<br>";
			$upImageName	= $_FILES[$nowField]["name"];
			$upImageTemp	= $_FILES[$nowField]["tmp_name"];


			$temp_name		= explode(".",$upImageName);
			$ext			= strtolower($temp_name[sizeof($temp_name)-1]);

			$options		= explode(",",$Form['field_option']);

			#echo $ext ."- ".$Form['field_option']." - ". sizeof($options)."<hr>";

			for ( $z=0,$m=sizeof($options),$ext_check='' ; $z<$m ; $z++ )
			{
				#echo " $ext = ".$options[$z] ."<br>";
				if ( $ext == trim($options[$z]))
				{
					$ext_check	= 'ok';
					break;
				}
			}

			if ( $ext_check != 'ok' && $_POST[$nowField."_del"] != 'ok' )
			{
				$addMessage	= "\\n\\n$nowField 필드 : 파일업로드 가능한 확장자가 아닙니다.($ext) \\n업로드 가능한 확장자는 $Form[field_option] 입니다.";
				#echo $addMessage;

				msg("로고 파일이 업로드가 가능한 확장자가 아닙니다.($ext)\\n업로드 가능한 확장자는 $Form[field_option] 입니다.");
				continue;
			}
			else
			{
				$now_time = happy_mktime();
				$rand_number =  rand(0,1000000);

				//디렉토리 생성 추가 2013-08-29 kad
				$now_year	= date("Y");
				$now_month	= date("m");
				$now_day	= date("d");

				$oldmask = umask(0);
				if (!is_dir("$happy_member_upload_path/$now_year")){
					mkdir("$happy_member_upload_path/$now_year", 0777);
				}
				if (!is_dir("$happy_member_upload_path/$now_year/$now_month")){
					mkdir("$happy_member_upload_path/$now_year/$now_month", 0777);
				}
				if (!is_dir("$happy_member_upload_path/$now_year/$now_month/$now_day")){
					mkdir("$happy_member_upload_path/$now_year/$now_month/$now_day", 0777);
				}
				umask($oldmask);
				//디렉토리 생성 추가 2013-08-29 kad

				$img_url_re			= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-$rand_number.$ext";
				$img_url_re_thumb	= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-$rand_number"."_thumb.$ext";
				$img_url_re_thumb2	= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-$rand_number"."_thumb2.$ext";
				$img_url_file_name	= "${happy_member_upload_folder}$now_year/$now_month/$now_day/$now_time-$rand_number.$ext";

				if (copy($upImageTemp,"$img_url_re"))
				{
					//이거네.
					${$nowField}	= $img_url_file_name;


					//$nowField : photo1 -> 개인회원 사진
					//$nowField : photo2 -> 개인회원이력서 사진
					//$nowField : photo3 -> 개인회원이력서 사진

					if ( $nowField == "photo1" )
					{
						$happy_member_image_width = $PerPhotoDstW;
						$happy_member_image_height = $PerPhotoDstH;
						$happy_member_image_type = $PerPhotoCreateType;
					}
					else if ( $nowField == "photo2" )
					{
						$happy_member_image_width = $ComLogoDstW;
						$happy_member_image_height = $ComLogoDstH;
						$happy_member_image_type = $ComPhotoCreateType1;
					}
					else if ( $nowField == "photo3" )
					{
						$happy_member_image_width = $ComBannerDstW;
						$happy_member_image_height = $ComBannerDstH;
						$happy_member_image_type = $ComPhotoCreateType2;
					}


					if ($happy_member_image_width && $happy_member_image_height )
					{
						happyMemberimageUpload(
								$img_url_re,								#원본파일 경로
								$img_url_re_thumb,							#썸네일 저장 경로
								$happy_member_image_width,					#썸네일 가로크기
								$happy_member_image_height,					#썸네일 세로크기
								$happy_member_image_quality,				#썸네일 퀄리티
								$happy_member_image_type,					#썸네일 추출타입
								$happy_member_image_position,				#썸네일 포지션 (왼쪽1,중간2,오른쪽3) (상단1,중간2,하단3)
								$happy_member_image_logo,					#썸네일 로고
								$happy_member_image_logo_position			#썸네일 로고 위치
						);
					}

					if ($happy_member_image_width2 && $happy_member_image_height2 )
					{
						happyMemberimageUpload(
								$img_url_re,								#원본파일 경로
								$img_url_re_thumb2,							#썸네일 저장 경로
								$happy_member_image_width2,					#썸네일 가로크기
								$happy_member_image_height2,				#썸네일 세로크기
								$happy_member_image_quality2,				#썸네일 퀄리티
								$happy_member_image_type2,					#썸네일 추출타입
								$happy_member_image_position2,				#썸네일 포지션 (왼쪽1,중간2,오른쪽3) (상단1,중간2,하단3)
								$happy_member_image_logo2,					#썸네일 로고
								$happy_member_image_logo_position2			#썸네일 로고 위치
						);

					}
				} #copy 완료마지막
			}
		}
	}

	//생성한걸 쓰겠다라고 하면
	if ( $_POST['logo_photo3'] != "" )
	{
		$photo3 = $_POST['logo_photo3'];
	}
	//이미지 추가 회원정보에 업로드 하는 것하고 같게 처리해야 함



	$addSql	= "";

	$addSql	.= ( $img1 != "" )?" , img1 = '$img1' ":"";
	$addSql	.= ( $img2 != "" )?" , img2 = '$img2' ":"";
	$addSql	.= ( $img3 != "" )?" , img3 = '$img3' ":"";
	$addSql	.= ( $img4 != "" )?" , img4 = '$img4' ":"";
	$addSql	.= ( $img5 != "" )?" , img5 = '$img5' ":"";

	$addSql	.= ( $img1 == "" && $file1_del == "ok" )?" , img1 = '' ":"";
	$addSql	.= ( $img2 == "" && $file2_del == "ok" )?" , img2 = '' ":"";
	$addSql	.= ( $img3 == "" && $file3_del == "ok" )?" , img3 = '' ":"";
	$addSql	.= ( $img4 == "" && $file4_del == "ok" )?" , img4 = '' ":"";
	$addSql	.= ( $img5 == "" && $file5_del == "ok" )?" , img5 = '' ":"";

	$addSql	.= " , img_text1 = '$img_text1' ";
	$addSql	.= " , img_text2 = '$img_text2' ";
	$addSql	.= " , img_text3 = '$img_text3' ";
	$addSql	.= " , img_text4 = '$img_text4' ";
	$addSql	.= " , img_text5 = '$img_text5' ";

	$howjoin	= @implode(",", (array) $_POST["howjoin_chk"]);
	$howpeople	= $_POST["howpeople"];

	#근무요일
	$work_day				= @implode(" ",$_POST["work_day"]);			#근무가능요일
	#근무시간
	$start_worktime = $_POST['work_time1']."-".$_POST['work_time2']."-".$_POST['work_time3'];
	$finish_worktime = $_POST['work_time4']."-".$_POST['work_time5']."-".$_POST['work_time6'];
	#구인자
	$guinperson = $_POST['guinperson'];
	#희망학력
	$guineducation = $_POST['guineducation'];
	#국적
	$guinnational = $_POST['guinnational'];
	#파견업체연락
	$guinsicompany = $_POST['guinsicompany'];


	$sql = "select count(*) as ct from $type_tb where (number = '$type1' OR number = '$type2' OR number = '$type3') AND use_adult = 1; ";
	$result = query($sql);
	$adult_check_count = happy_mysql_fetch_array($result);

	if($adult_check_count[ct]){
		$use_adult = "1";
	}

	//문의하기 사용여부
	$inquiry_use	= $_POST['inquiry_use'];

	if ( $guin_pay_type == '' )
	{
		$guin_pay	= $_POST['guin_pay2'];
	}

	$company_number		= preg_replace("/\D/", "", $_POST['company_number']);

	//지역개선작업
	$addsql		= "";
	$addsql		.= $gu_temp_array2["오리지날_".$gu1] == '' ? "gu1_ori = '".$gu1."'," : "gu1_ori = '".$gu_temp_array2["오리지날_".$gu1]."',";
	$addsql		.= $gu_temp_array2["오리지날_".$gu2] == '' ? "gu2_ori = '".$gu2."'," : "gu2_ori = '".$gu_temp_array2["오리지날_".$gu2]."',";
	$addsql		.= $gu_temp_array2["오리지날_".$gu3] == '' ? "gu3_ori = '".$gu3."'," : "gu3_ori = '".$gu_temp_array2["오리지날_".$gu3]."',";
	//지역개선작업

	$sql = "update ".$guin_tb." set ";
	$sql.= "si1='".$si1."', ";
	$sql.= "si2='".$si2."', ";
	$sql.= "si3='".$si3."', ";
	$sql.= "gu1='".$gu1."', ";
	$sql.= "gu2='".$gu2."', ";
	$sql.= "gu3='".$gu3."', ";

	$sql.= $addsql; //지역개선작업

	$sql.= "type1='".$type1."', ";
	$sql.= "type2='".$type2."', ";
	$sql.= "type3='".$type3."', ";
	$sql.= "type_sub1='".$type_sub1."', ";
	$sql.= "type_sub2='".$type_sub2."', ";
	$sql.= "type_sub3='".$type_sub3."', ";
	$sql.= "type_sub_sub1='".$type_sub_sub1."', ";
	$sql.= "type_sub_sub2='".$type_sub_sub2."', ";
	$sql.= "type_sub_sub3='".$type_sub_sub3."', ";
	$sql.= "guin_name='".$guin_name."', ";
	$sql.= "guin_com_name='".$com_name."', ";
	$sql.= "guin_phone='".$guin_phone."', ";
	$sql.= "guin_fax='".$guin_fax."', ";
	$sql.= "guin_email='".$guin_email."', ";
	$sql.= "guin_homepage='".$guin_homepage."', ";
	$sql.= "guin_method='".$guin_method."', ";
	$sql.= "guin_type='".$guin_type."', ";
	$sql.= "guin_gender='".$guin_gender."', ";
	$sql.= "guin_age='".$guin_age."', ";
	$sql.= "guin_pay='".$guin_pay."', ";
	$sql.= "guin_pay_type='".$guin_pay_type."', ";
	$sql.= "guin_edu='".$guin_edu."', ";
	$sql.= "guin_career='".$guin_career."', ";
	$sql.= "guin_career_year='".$guin_career_year."', ";
	$sql.= "guin_end_date='".$guin_end_date."', ";
	$sql.= "guin_title='".$guin_title."', ";
	$sql.= "guin_work_content='".$guin_work_content."', ";
	$sql.= "guin_main='".$guin_main."', ";
	$sql.= "guin_choongwon='".$guin_choongwon."', ";
	$sql.= "guin_etc5='".$guin_etc5."', ";
	$sql.= "guin_woodae = '".$guin_woodae."', ";
	$sql.= "guin_grade = '".$guin_grade."', ";
	$sql.= "guin_lang = '".$guin_lang."', ";
	$sql.= "guin_license = '".$guin_license."', ";
	$sql.= "guin_interview = '".$guin_interview."', ";
	$sql.= "guin_bokri = '".$guin_bokri."', ";
	$sql.= "guin_modify = now(), ";
	$sql.= "howpeople	= '".$howpeople."', ";
	$sql.= "howjoin		= '".$howjoin."', ";
	$sql.= "keyword		= '".$keyword."', ";
	$sql.= "underground1	= '".$underground1."', ";
	#추가필드
	$sql.= "work_day = '".$work_day."', ";
	$sql.= "start_worktime = '".$start_worktime."', ";
	$sql.= "finish_worktime = '".$finish_worktime."', ";
	$sql.= "guinperson = '".$guinperson."', ";
	$sql.= "guineducation = '".$guineducation."', ";
	$sql.= "guinnational = '".$guinnational."', ";
	$sql.= "guinsicompany = '".$guinsicompany."', ";
	#추가필드
	$sql.= "underground2	= '".$underground2."' ";
	$sql.= $addSql;
	$sql.= ",use_adult	= '".$use_adult."'";
	$sql.= ",HopeSize	= '".$HopeSize."'";
	$sql.= ",subway_txt	= '".$subway_txt."'";
	$sql.= ",marriage_chk	= '".$marriage_chk."'";
	$sql.= ",work_week	= '".$work_week."'";

	//위치기반주소
	$sql.= ",user_zip = '".$user_zip."'";
	$sql.= ",user_addr1 = '".$user_addr1."'";
	$sql.= ",user_addr2 = '".$user_addr2."' ";

	//큰이미지 photo2
	//작은이미지 photo3
	$sql.= ",photo2 = '".$photo2."' ";
	$sql.= ",photo3 = '".$photo3."' ";

	$sql.= ",pay_type = '".$_POST['pay_type']."' ";

	//헤드헌팅(대표자명, 설립연도, 직원수, 업소소개) 추가
	if ( $company_number != '' )
	{
		$sql.= ",company_number = '".$company_number."' ";
	}

	$sql.= ",boss_name = '".$boss_name."' ";
	$sql.= ",com_open_year = '".$com_open_year."' ";
	$sql.= ",com_worker_cnt = '".$com_worker_cnt."' ";
	$sql.= ",com_profile1 = '".$com_profile1."' ";

	if( $_COOKIE['happy_mobile'] != 'on' )				//PC 모드에서 등록했으니 무조건 PC 모드로 교체.
	{
		$sql.= ",regist_mobile		= 'n'  ";
	}

	//문의하기 여부
	$sql.= ",inquiry_use		= '".$inquiry_use."' ";





	$sql.= " where number='".$num."'";

	//echo nl2br($sql);exit;

	$result = query($sql);

	// 맞춤채용알림
	$value	= array(
		'type1'				=> $type1,				// 분야
		'type2'				=> $type2,				// 분야
		'type3'				=> $type3,				// 분야
		'type_sub1'			=> $type_sub1,			// 분야
		'type_sub2'			=> $type_sub2,			// 분야
		'type_sub3'			=> $type_sub3,			// 분야
		'si1'				=> $si1,				// 시
		'si2'				=> $si2,				// 시
		'si3'				=> $si3,				// 시
		'gu1'				=> $gu1,				// 구
		'gu2'				=> $gu2,				// 구
		'gu3'				=> $gu3,				// 구
		'guin_type'			=> $guin_type,			// 고용형태(정규직 등)
		'guin_edu'			=> $guin_edu,			// 학력
		'guin_career'		=> $guin_career,		// 경력
		'guin_career_year'	=> $guin_career_year,	// 경력연수
		'guin_gender'		=> $guin_gender,		// 성별
		'guin_age'			=> $guin_age,			// 연령
		'guin_pay'			=> $guin_pay,			// 급여
		'guin_pay_type'		=> $guin_pay_type		// 급여
	);
	want_job_send_msg($value);

	//헤드헌팅
	//회사번호가 바뀌면 $com_guin_per_tb company_number 컬럼도 update , 2014-01-13 ralear
	if ( $DETAIL['company_number'] != $company_number )
	{
		$Sql			= "
							UPDATE
									$com_guin_per_tb
							SET
									company_number	= '".$company_number."'
							WHERE
									cNumber			= '".$DETAIL['number']."'
		";
		query($Sql);
	}
	//헤드헌팅

	//인접매물 업데이트 2013-03-08 kad
	//주소를 바로 입력받아서 좌표구하는 형태
	$now_number = $num;

	if ( $user_addr1 != '' && $user_addr2 != '' )
	{

		$nowAddr		= $user_addr1.' '.$user_addr2;

		if ( $wgs_get_type == 'google' )
		{
			$data			= getcontent_wgs_google($nowAddr);

			$ypoint			= getpoint($data,"<lat>","</lat>");
			$xpoint			= getpoint($data,"<lng>","</lng>");

			$wgsArr			= get_wgs_point($xpoint[0], $ypoint[0]);
		}
		else
		{
			if( $wgs_get_type == 'naver' )
			{
				$data				= getcontent_wgs($nowAddr);
			}
			else
			{
				$data				= getcontent_wgs_daum($nowAddr);
			}

			$xpoint			= getpoint($data,"<y>","</y>");
			$ypoint			= getpoint($data,"<x>","</x>");
			$xpoint			= $xpoint[0];
			$ypoint			= $ypoint[0];

			$wgsArr			= get_wgs_point($ypoint, $xpoint);
		}


		$Sql	= "
					UPDATE
							$guin_tb
					SET
							x_do		= '$wgsArr[x_do]',
							x_min		= '$wgsArr[x_min]',
							x_sec		= '$wgsArr[x_sec]',
							y_do		= '$wgsArr[y_do]',
							y_min		= '$wgsArr[y_min]',
							y_sec		= '$wgsArr[y_sec]',
							x_point		= '$wgsArr[x_point]',
							y_point		= '$wgsArr[y_point]',
							x_point2	= '$wgsArr[x_point2]',
							y_point2	= '$wgsArr[y_point2]'
					WHERE
							number		= '$now_number'
		";
		//echo $Sql."<br>";

		query($Sql);
	}
	else
	{
		$x_do		= '';
		$x_min		= '';
		$x_sec		= '';

		$y_do		= '';
		$y_min		= '';
		$y_sec		= '';

		$x_point	= '';
		$y_point	= '';

		$x_point2	= '';
		$y_point2	= '';

		$Sql	= "
					UPDATE
							$guin_tb
					SET
							x_do		= '$x_do',
							x_min		= '$x_min',
							x_sec		= '$x_sec',
							y_do		= '$y_do',
							y_min		= '$y_min',
							y_sec		= '$y_sec',
							x_point		= '$x_point',
							y_point		= '$y_point',
							x_point2	= '$x_point2',
							y_point2	= '$y_point2'
					WHERE
							number	= '$now_number'
		";
		query($Sql);
	}
	//exit;
	//인접매물 업데이트


	if ( substr_count($_SERVER['REQUEST_URI'],'/') == 1 )
	{
		for ( $i=0 , $max=sizeof($xml_area1) ; $i<$max ; $i++ )
		{
			xmlAddressCreate($AREA_SI_NUMBER[$xml_area1[$i]]);
		}
	}


	gomsg("해당 채용정보를 수정하였습니다.", "$prev_url");
	exit;
}

?>