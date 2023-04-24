<?php
$t_start = array_sum(explode(' ', microtime()));
include ("../inc/Template.php");
$TPL = new Template;

include ("../inc/config.php");

include ("../inc/function.php");
include ("../inc/lib.php");

if ( !admin_secure("구인리스트") ) {
		error("접속권한이 없습니다.");
		exit;
}

################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################
if($_GET['a'] == 'guzic')
 $now_location_subtitle = '이력서등록리스트';

if ( $_GET["a"] == "guin" )
{


	$지역검색		= make_si_selectbox("search_si","search_gu","$search_si","$search_gu","80","100","s_f_guin");
	$확장지역검색	= make_si_selectbox("search_si","search_gu","$search_si","$search_gu","80","100","a_f_guin");

	$search_type	= ( $search_type == "" )?$_GET["guzic_jobtype1"]:$search_type;
	$search_type_sub	= ( $search_type_sub == "" )?$_GET["guzic_jobtype2"]:$search_type_sub;
	$업종검색		= make_type_selectbox("search_type","search_type_sub","$search_type","$search_type_sub","140","140","s_f_guin");
	$확장업종검색	= make_type_selectbox("search_type","search_type_sub","$search_type","$search_type_sub","140","140","a_f_guin");


	$구인타입		= make_selectbox($job_arr,'--선택--',job_type_read,"$job_type_read");

	$career			= array('무관','신입','경력');
	$경력검색		= make_selectbox($career,'--선택--',career_read,"$career_read");
	$gender			= array('무관','남자','여자');
	$성별검색		= make_selectbox($gender,'--선택--',gender_read,"$gender_read");
	$연봉검색		= make_selectbox($money_arr,'--선택--',pay_read,"$pay_read");
	$학력검색		= make_selectbox($edu_arr,'--선택--',edu_read,"$edu_read");
	$직급선택		= make_selectbox($grade_arr,'--선택--',grade_read,"$grade_read");

	#학력검색 변경함
	$학력검색 = make_selectbox2($TEducation,$TEducation,"학력","guineducation",$_GET['guineducation'],$select_width="100");
	$학력검색 = make_selectbox($edu_arr,'--학력선택--','guineducation',$_GET['guineducation']);

	$최종학력체크박스	= make_checkbox2( $edu_arr, $edu_arr, 4, "edu_read", "edu_read", "__".@implode("__", (array) $_GET["edu_read"])."__","__");

	$고용형태체크박스	= make_checkbox2( $job_arr, $job_arr, 4, "job_type_read", "job_type_read", "__".@implode("__", (array) $_GET["job_type_read"])."__","__");

	$연령검색박스	= dateSelectBox( "guin_age", 2010, 1900, $_GET["guin_age"], "년생", "연령선택", "" , -1);




	//규모별 검색
	$규모별검색 = make_selectbox2($tHopeSize,$tHopeSize,'---선택---',"HopeSize",$_GET['HopeSize'],$select_width="100");
	//$sql = "update $guin_tb set HopeSize = '중소기업' where HopeSize = '' ";
	//query($sql);

$names	= Array("want_money_arr");
$return	= Array("연봉타입");
$vals	= Array($_GET[guin_pay_type]);

for ( $x=0,$xMax=sizeof($names) ; $x<$xMax ; $x++ )
{
	$options	= "";
	for ( $i=0,$max=sizeof(${$names[$x]}) ; $i<$max ; $i++ )
	{
		$checked	= ( $vals[$x] == ${$names[$x]}[$i] )?"selected":"";
		$options	.= "<option value='".${$names[$x]}[$i]."' $checked >".${$names[$x]}[$i]."</option>\n";
	}
	${$return[$x]}	= $options;
}


		$ex_limit = '30';
		$ex_width ='1';
		$ex_title_cut ='44';
		$ex_category1 = "$search_type";
		$ex_category2 = "$search_type_sub";
		$ex_area1 = "$search_si";
		$ex_area2 = "$search_gu";
		$ex_type= "$search_option";
			if ($ex_type == '일반'){
			$wait_query = "";
			$check_ex = '1';
			}
			else {
				for ($i = 0; $i <=6 ; $i ++){
					if ($ex_type == $ARRAY_NAME[$i]){
					$check_ex = '1';
						$tmp_option = $ARRAY[$i] . "_option";
						if ($CONF[$tmp_option] == '기간별'){
						$wait_query = "$ARRAY[$i] > $real_gap ";
						}
						else {
						$wait_query = "$ARRAY[$i] > '0' ";
						}
					break;
					}

				}

			}
			$QUERY = array();
			$ai_comment = "";
			$plus = "&";

			#지역별 검색 다시
			if ($ex_area1 == "전체" || $ex_area1 == '전국' || $search_si == "$SI_NUMBER[전국]"){
			$area_query1 = "";
			}
			elseif ($ex_area1 )
			{
				#ex_area2도 자동일것임.
				if ($ex_area1 && $ex_area2)
				{
					#시구까지 존재
					//지역개선작업
					$guAddC		= "";
					if ( $gu_temp_array["부모값_".$ex_area2] == 'sub' )
					{
						$guAddC		= "_ori";
					}
					//지역개선작업

					$area_query_total = "
						(
							(
								si1				= '$ex_area1'
								and
								gu1{$guAddC}	= '$ex_area2'
							)
							or
							(
								si2				= '$ex_area1'
								and
								gu2{$guAddC}	= '$ex_area2'
							)
							or
							(
								si3				= '$ex_area1'
								and
								gu3{$guAddC}	= '$ex_area2'
							)
							or
							(
								si1				= '$SI_NUMBER[전국]'
								or
								si2				= '$SI_NUMBER[전국]'
								or
								si3				= '$SI_NUMBER[전국]'
							)
						)
					";
					$plus .= "&search_si=$ex_area1&search_gu=$ex_area2&";
					$ai_comment .= "<font color=#AE06A0>$SI[$ex_area1] $GU[$ex_area2] 지역내 </font>";
					array_push($QUERY, "$area_query_total");
				}
				elseif ($ex_area1){
				$area_query_total = "  ( (si1='$SI_NUMBER[전국]' or si2='$SI_NUMBER[전국]' or si3='$SI_NUMBER[전국]' ) or (si1='$ex_area1' or si2='$ex_area1' or si3='$ex_area1')   ) ";
				$plus .= "&search_si=$ex_area1&search_gu=$ex_area2&";
				$ai_comment .= "<font color=#AE06A0>$SI[$ex_area1] 지역내</font>";
				array_push($QUERY, "$area_query_total");
				}
				else {
				$area_query_total = '';
				$plus .= "&search_si=$ex_area1&";
				}
			}


			#직종별 작업해야함.
			if ($ex_category1 == "전체" || $ex_category1 == ""){
			$category_query1 = "";
			}
			elseif ($ex_category1){
				if ($ex_category1 && $ex_category2){
				$category_query1 = " ( (type1 = '$ex_category1' and type_sub1 = '$ex_category2') or (type2 = '$ex_category1' and type_sub2 = '$ex_category2') or (type3 = '$ex_category1' and type_sub3 = '$ex_category2') )  ";
				array_push($QUERY, "$category_query1");
				$plus .= "search_type=$ex_category1&search_sub_type=$ex_category2&";
				$ai_comment .= " <font color=#464BB7>$TYPE[$ex_category1] $TYPE_SUB[$ex_category2]</font> ";
				}
				elseif ($ex_category1 && $ex_category2 == ''){
				$category_query1 = " (type1 = '$ex_category1' or type2 = '$ex_category1' or type3 = '$ex_category1' )  ";
				array_push($QUERY, "$category_query1");
				$plus .= "search_type=$ex_category1&";
				$ai_comment .= " <font color=#464BB7>$TYPE[$ex_category1]"."</font> ";
				}
				else {
				$category_query1 = '';
				}
			}

		#plus jobclass_read ,area_read

			/*
			// 학력정리
			if ($edu_read ) {
			$edu_search = "guin_edu like '%$edu_read%'  ";
			array_push($QUERY, "$edu_search");
			$ai_comment .= " <font color=#AE06A0>$edu_read"."학력</font> ";
			$plus .= "edu_read=$edu_read&";
			}
			*/

			$guineducation = $_GET['guineducation'];

			if ( $guineducation != '' )
			{
				//$WHERE[] = " ( guineducation = '$guineducation' ) ";
				$edu_search = "( guin_edu = '$guineducation' ) ";
				array_push($QUERY, "$edu_search");
				$plus .= "guineducation=$guineducation&";
				$ai_comment .= " <font color=#AE06A0>$guineducation"."학력</font> ";
			}

			// 경력 정리
			if ($career_read ) {
			$career_search  = "guin_career like '%$career_read%' ";
			array_push($QUERY, "$career_search");
			$ai_comment .= " <font color=#7EA105>경력"."$career_read </font>";
			$plus .= "career_read=$career_read&";
			}

			//성별정리
			if ($gender_read) {
			$gender_search = "guin_gender like '%$gender_read%' ";
			array_push($QUERY, "$gender_search");
			$ai_comment .= " 성별"."(<font color=#A18C03>$gender_read</font>) ";
			$plus .= "gender_read=$gender_read&";
			}

			//제목 키워드 정리
			if ($title_read) {
			$title_search = "(guin_title like '%$title_read%' OR guin_com_name  like '%$title_read%')";
			array_push($QUERY, "$title_search");
			$plus .= "title_read=$title_read&";
			}

			//고용형태
			if ($job_type_read ) {
			$type_search = "guin_type = '$job_type_read' ";
			array_push($QUERY, "$type_search");
			$plus .= "job_type_read=$job_type_read&";
			}


			//희망연봉정리
			if ($pay_read) {
			$pay_search = "guin_pay like '%$pay_read%' ";
			array_push($QUERY, "$pay_search");
			$ai_comment .= "연봉"."(<font color=#AE029F>$pay_read</font>) ";
			$plus .= "pay_read=$pay_read&";
			}



			#category_query 와 wait_query 를 where로 정리해보자
			if ($wait_query){
			array_push($QUERY, "$wait_query");
			}




			if ( $HopeSize != "" )
			{
				$size_search = "HopeSize = '$HopeSize' ";
				array_push($QUERY, "$size_search");
				$ai_comment .= "규모"."(<font color=#AE029F>$HopeSize</font>) ";
				$plus .= "HopeSize=$HopeSize&";
			}

			//print_r($_GET);

			if ( $guin_pay_type != "" )
			{
				$pay_type_search = "guin_pay_type = '$guin_pay_type' ";
				array_push($QUERY, "$pay_type_search");
				$ai_comment .= "연봉타입"."(<font color=#AE029F>$guin_pay_type</font>) ";
				$plus .= "guin_pay_type=$guin_pay_type&";

				if ( $guin_pay != "" && $guin_pay_type != "급여협의" )
				{
					$guin_pay_search = "guin_pay = '$guin_pay' ";
					array_push($QUERY, "$guin_pay_search");
					$ai_comment .= "급여"."(<font color=#AE029F>$guin_pay</font>) ";
					$plus .= "guin_pay=$guin_pay&";
				}
			}





			#마지막 쿼리문정리
			$last_query = "where ";
			foreach ($QUERY as $list){
			$last_query .= " $list and";
			}
			$last_query .= " number is not null";

			$sql1 = "select count(*) from   $guin_tb $last_query  ";
			//print "<br><br>$sql1<hr>";


			$result1 = query($sql1);
			$get_tt = mysql_fetch_row($result1);
			$numb = $get_tt[0];

/*
			if (!$numb){
			print $확장검색부분;
			print  " <br><center>$ai_comment"."로 검색결과 등록된 채용정보가 없습니다";
			exit;
			}
*/


			$pg = $_GET[pg];
			if($pg==0 || $pg==""){$pg=1;}
			//페이지 나누기
			$total_page = ( $numb - 1 ) / $ex_limit+1; //총페이지수
			$total_page = floor($total_page);
			$view_rows = ($pg - 1) * $ex_limit;
			$co  =  $numb  -  $ex_limit  *  ( $pg - 1 );





		#########################################################################
		$sql = "select * from $guin_tb $last_query  order by number  desc limit $view_rows,$ex_limit";
		##########################################################################
		//echo $sql;

		$result = query($sql);

				$i = "1";
		$main_new_out = <<<END

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
		request.open("GET", "../sub_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
		request.onreadystatechange = handleStateChange;
		request.send(null);
		}

		function startRequest2(sel,target,size)
		{
		var trigger = sel.options[sel.selectedIndex].value;
		var form = sel.form.name;
		createXMLHttpRequest();
		request.open("GET", "../sub_type_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
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

		<script language="javascript">
		<!--
			function bbsdel(strURL) {
				var msg = "삭제하시겠습니까?";
				if (confirm(msg)){
					window.location.href= strURL;

				}
			}

			function allCheck(objname)
			{
				obj = document.getElementsByName(objname)
				cnt = obj.length;

				for ( i=0; i<cnt;i++ )
				{
					if ( obj[i].checked )
					{
						obj[i].checked = false;
					}
					else
					{
						obj[i].checked = true;
					}
				}
			}

			function check_sel(objname)
			{
				obj = document.getElementsByName(objname)
				cnt = obj.length;
				TStr = "";
				gubun = "";
				for ( i=0; i<cnt;i++ )
				{
					if ( obj[i].checked )
					{
						TStr += gubun+obj[i].value;
						gubun = "|";
					}
				}

				if ( TStr == '' )
				{
					alert('옵션을 수정하실 채용정보를 하나라도 선택을 해주셔야 합니다.');
					return;
				}
				else
				{
					document.location.href = 'guin_option.php?action=option_multi&pg=$pg&numbers='+TStr;
				}
			}

function no_change_pay()
{
	var obj	= document.getElementById('guin_pay_type')

	if ( obj.selectedIndex == 1 )
	{
		document.getElementById('guin_pay').disabled = true;
	}
	else
		document.getElementById('guin_pay').disabled = false;
}

			-->
		</script>


<p class='main_title'>$now_location_subtitle <span class='small_btn'><img src='img/icon_orange3.gif' align=absmiddle> 총 채용인재 수 : <font color=red> $numb</font> 건</label></p>


<form name='s_f_guin' style='margin:0;'>
<input type='hidden' name='a' value='$_GET[a]'>
<input type='hidden' name='mode' value='$_GET[mode]'>
	<div id='box_style'>
		<div class='box_1'></div>
		<div class='box_2'></div>
		<div class='box_3'></div>
		<div class='box_4'></div>
		<p class='short' style=''>등록되어있는 채용정보를 검색할 수 있습니다. 지역 및 직종은 1단계를 선택하면 2단계가 출력 됩니다.</p>
		<table cellspacing='0' cellpadding='0' style='width:100%;' class=''>
		<tr>
			<td style='width:100px; height:34px;'><strong>지역/직종</strong></td>
			<td class="input_style_adm">$지역검색 $업종검색</td>
		</tr>
		<tr>
			<td style='width:100px; height:34px;'><strong>등록옵션</strong></td>
			<td class="input_style_adm">
				$구인타입 $성별검색 $학력검색 $규모별검색
				<select name="guin_pay_type" id="guin_pay_type" onChange="no_change_pay()">
					<option value="">연봉</option>$연봉타입
				</select>
				<input type='text' name='guin_pay' id='guin_pay' value='$_GET[guin_pay]'>
				<script>no_change_pay();</script>
			</td>
		</tr>
		<tr>
			<td style='width:100px; height:34px;'><strong>키워드</strong></td>
			<td class="input_style_adm"><input type=text name=title_read size=40 value='$_GET[title_read]'> <input type='submit' value='검색하기' class='btn_small_dark' style='height:31px; margin-bottom:2px'></td>
		</tr>
		</table>
	</div>
</form>


<div id='list_style'>

	<table cellspacing='0' cellpadding='0' border='0' class="bg_style b_border">
	<thead>
	<colgroup>
		<col style='width:10%;'></col>
		<col></col>
		<col style='width:12%;'></col>
		<col style='width:8%;'></col>
		<col style='width:8%;'></col>
		<col style='width:15%;'></col>
		<col style='width:12%;'></col>
	</colgroup>
	<tr>
		<th><input type=checkbox name=allcheck onclick="javascript:allCheck('Tnumber[]');"> 기업명</th>
		<th>제목</th>
		<th>경력</th>
		<th>로고수정</th>
		<th>유료옵션</th>
		<th>등록/마감일</th>
		<th class='last'>관리자툴</th>
	</tr>
	</thead>



END;
$Count	= 0;

				while  ($NEW = happy_mysql_fetch_array($result))
				{

					# 유료옵션 아이콘 추가 ralear
					# 유료옵션 배열
					$money_array = array
					(
						0	=> 'guin_banner1',
						1	=> 'guin_banner2',
						2	=> 'guin_banner3',
						3	=> 'guin_bold',
						4	=> 'guin_list_hyung',
						5	=> 'guin_pick',
						6	=> 'guin_ticker',
						7	=> 'guin_bgcolor_com',
						8	=> 'freeicon_comDate',
						9	=> 'guin_uryo1',
						10	=> 'guin_uryo2',
						11	=> 'guin_uryo3',
						12	=> 'guin_uryo4',
						13	=> 'guin_uryo5'
					);

					$money_name = array
					(
						0	=> '우대등록',
						1	=> '프리미엄',
						2	=> '스피드',
						3	=> '볼드',
						4	=> '스페셜',
						5	=> '추천',
						6	=> '뉴스티커',
						7	=> '배경색',
						8	=> '아이콘',
						9	=> $CONF['guin_uryo1_title'],	// 커뮤니티노출
						10	=> $CONF['guin_uryo2_title'],	// 페이지보조노출
						11	=> $CONF['guin_uryo3_title'],	// 통합검색노출
						12	=> $CONF['guin_uryo4_title'],	// 4번옵션
						13	=> $CONF['guin_uryo5_title']	// 5번옵션
					);

					$money_icon_list = "";

					foreach( $money_array as $key => $list  )
					{
						if ( $NEW[$list] > $real_gap )
						{
							if ( $key == 9 || $key == 10 || $key == 11 || $key == 12 || $key == 13 )
							{
								$money_icon_list .= "<div style=\"float:left; background:url('./img/yuryo/bg_money.gif') no-repeat; width:70px; height:13px; color:white; font-size:11px; letter-spacing:-2px; font-weight:normal; margin-right:3px; margin-bottom:3px; padding-top:1px; text-align:center;\">$money_name[$key]</div>";
							}
							else
							{
								$money_icon_list .= "<img src='img/yuryo/$money_array[$key].gif' alt='$money_name[$key]' align='absmiddle' style='margin-right:3px; margin-bottom:3px; float:left;'/>";
							}
						}
					}


					# 로고추가 ralear
					$Tmem		= happy_member_information($NEW['guin_id']);
					//$bns_img	= $Tmem['photo2'];
					//$bnl_img	= $Tmem['photo3'];

					$bns_img	= $NEW['photo2'];
					$bnl_img	= $NEW['photo3'];

					if ( $bnl_img == "" )
					{
						if(!$_COOKIE['ad_id'] && !$_COOKIE['adult_check'] && !$mem_id && $NEW['use_adult'])
						{
							$NEW[com_logo] = $HAPPY_CONFIG['adult_guin'];
						}
						else
						{
							$NEW[com_logo] = "../".$HAPPY_CONFIG['IconComNoLogo1']."";
						}
					}
					else
					{
						//2010-09-30 Hun 추가함 19금에 걸릴 경우.. 19금 이미지를 넣어주자!
						if(!$_COOKIE['ad_id'] && !$_COOKIE['adult_check'] && !$mem_id && $NEW['use_adult'])
						{
							$NEW[logo] = $HAPPY_CONFIG['adult_guin'];
						}
						else	//기존소스 입니다.
						{
							$NEW[com_logo] = "../$bnl_img";
							$Happy_Img_Name[0] = $NEW[com_logo];
							$NEW[com_logo] = happy_image("자동","가로85","세로33","로고사용안함","로고위치7번","퀄리티100","gif원본출력","img/no_photo.gif","비율대로축소","2");
						}
					}

					if ( $bns_img == "" )
					{
						$NEW[com_logo2]	= "../".$HAPPY_CONFIG['IconComNoBanner1']."";
					}
					else
					{
						$NEW[com_logo2]	= "../$bns_img";
						$Happy_Img_Name[0] = $NEW[com_logo2];
						$NEW[com_logo2] = happy_image("자동","가로85","세로33","로고사용안함","로고위치7번","퀄리티100","gif원본출력","img/no_photo.gif","비율대로축소","2");
					}


					if(!preg_match("/NoLogo/",$NEW[com_logo]))
					{
						$com_logo_info	= "<img src='$NEW[com_logo]' width='85' height='33'  align='absmiddle' style='border:1px solid #dedede;' />";
					}
					else if(!preg_match("/NoLogo/",$NEW[com_logo2]))
					{
						$com_logo_info	= "<img src='$NEW[com_logo2]' width='85' height='33' align='absmiddle' style='border:1px solid #dedede;' />";
					}
					else
					{
						$com_logo_info	= "<img src='$NEW[com_logo]' width='85' height='33' align='absmiddle' style='border:1px solid #dedede;' />";
					}




						#print_r2($NEW);
						#guin_end_date : 마감일
						#guin_choongwon: 충원 1 : 충원시 0

						if ($NEW[guin_choongwon] == "1") {
							$guin_end_date = "충원시";
						} else {
							$guin_end_date = $NEW[guin_end_date]." 00:00:00";
						}

						$tableColor	= ( $Count++ % 2 == 0 )?"white":"#F8F8F8";

						if ( $NEW[guin_career] == "경력" ) {
							$NEW[guin_career] = "경력 $NEW[guin_career_year]↑";
						}

						$j ='0'; #type
						$this_bold = "";
						$NEW[icon] = "";
						foreach ($ARRAY as $list){
							$list_option = $list . "_option";

							if ($CONF[$list_option] == '기간별') {
							$NEW[$list] = $NEW[$list] - $real_gap; #날짜가 마이너스인 사람은 광고가 끝인사람임
							}
							if ($NEW[$list] > 0 && $j != '3'){ #볼드는 아이콘을 안보여준다
							#$NEW[icon] .= "<img src=../img/pay_$ARRAY_NAME2[$j] border=0 align=absmiddle> ";
							$NEW[icon] .= "<img src=../$ARRAY_NAME2[$j] border=0 align=absmiddle> ";
							}
							if ($NEW[$list] > 0 && $j == '3'){
							$this_bold = "1";
							}
						$j++;
						}


						if ( $NEW[guin_etc1] ) {
							$NEW[end_temp] = "<img src='./img/full.gif'>";
						}
						else {
							$NEW[end_temp] = "<font color=red>$NEW[guin_end_date]</font>";
						}
						/////////////////날짜 자르고 비교하기
						$guin_date = explode(" ",$NEW[guin_date]);
						$today = date("Y-m-d");
						if ( $NEW[guin_date][0] == $today ) {
							$NEW[new_icon] = "<img src='img/icon_aninew.gif' align=absmiddle>&nbsp; ";
						}
						else {
							$NEW[new_icon] = "";
						}
						$NEW[title] = kstrcut($NEW[guin_title], $ex_title_cut, "..."); #type
						if ($this_bold){
						$NEW[title] = "<font color=#C30000><b>$NEW[title]</b></font>";
						}
						$NEW[name] = kstrcut($NEW[guin_com_name], 10, "...");

						#업체로고구하기
						$sql2 = "select photo2 as etc1, photo3 as etc2,number,`group`, user_id  from $happy_member where user_id='$NEW[guin_id]'";
						$result2 = query($sql2);
						list ( $bnl_img,$bns_img,$m_number,$m_group,$user_id ) = mysql_fetch_row($result2);

						if ( $bnl_img == "" ) {
							$NEW[logo] = "../img/logo_img.gif";
						}
						else {
							$NEW[logo] = "../upload/$bns_img";
						}




						//유흥이라서 추가
						$logo_change = "<a href='#1' onClick=\"window.open('../logo_change.php?number=".$m_number."&member_group=".$m_group."&member_id=".$user_id."&guin_number=".$NEW['number']."','com_log','width=600,height=400,toolbar=no,scrollbars=yes')\" class='btn_small_yellow'>로고변경</a>";



						//기존꺼
						$admin_online_doc_org = "../com_info.php?com_info_id=$NEW[guin_id]";

						//변경된거
						$admin_online_doc = "./admin_online_doc.php?search_type=guin_id&search_word=$NEW[guin_id]&guin_number=$NEW[number]";





						$main_new = "
						<tbody>
						<tr>
							<td class='b_border_td'><input type='checkbox' name=Tnumber[] id=Tnumber[] value='$NEW[number]'> <a href='$admin_online_doc_org' target='_blank' style='color:#121212;'>$NEW[name]</a></td>
							<td class='b_border_td' style='padding:15px 0;'>
								$com_logo_info <span style='color:#0080FF; font-weight:bold'>[$NEW[guin_id]]</span>
								<div style='padding:10px 0 10px 0; font-family:'돋움'' class='font_14'>
									<a href='../guin_detail.php?num=$NEW[number]' target='_blank' style='color:#121212;'>$NEW[title]</a>
								</div>
								$money_icon_list

							</td>
							<td class='b_border_td'>$NEW[guin_career]</td>
							<td class='b_border_td' style='text-align:center;'>$logo_change </td>
							<td class='b_border_td' style='text-align:center;'><a href='guin_option.php?number=$NEW[number]&action=option&pg=1' class='btn_small_blue'>옵션수정</a></td>
							<td class='b_border_td' style='text-align:center; line-height:22px; font-family:tahoma'>
								$NEW[guin_date]<br><font color='#0080FF'>$guin_end_date</font>
							</td>
							<td class='b_border_td' style='text-align:center;'>

								<div>
									<div style='margin-bottom:12px;'><a href='../guin_mod.php?mode=mod&num=$NEW[number]&own=admin' target='_blank' class='btn_small_red'>수정</a> <a href=\"javascript:bbsdel('../del.php?mode=guin&num=$NEW[number]&own=admin');\" class='btn_small_dark'>삭제</a></div>
									<div style='margin-bottom:12px;'><a href='$admin_online_doc' class='btn_small_gray'>입사<font style='color:#1686e5; font-weight:bold'>지원</font>내역</a></div>
									<div><a href='admin_online_doc_request.php?mode=guin&guin_number=$NEW[number]' class='btn_small_gray'>입사<font style='color:#e01313; font-weight:bold'>요청</font>내역</a></div>
								</div>


							</td>
						</tr>
						</tbody>
						";
						$main_new_out .= $main_new;

				$i ++;
				}


				if ( !$numb )
				{
					$main_new = "<tr><td align=center colspan=7>검색된 채용정보가 없습니다.</td></tr></tr>";
					$main_new_out .= $main_new;
				}

				$main_new_out .= "</table></div>";


			if ($ex_category =="검색") {
				include ("./search_page.php");
			}
			else {
				include ("./page.php");
			}

			print $확장검색부분;
			if ( !$numb )
			{
				print $main_new_out;
			}
			else
			{
				print $main_new_out . "<div style='padding:20px 0 10px 0;' align='center'>$page_print</div>";
				echo "<input type=\"button\" onclick=\"javascript:check_sel('Tnumber[]')\" value=\"선택한 채용공고의 유료옵션변경\" class='btn_small_dark'>";
			}


}
else
{

	guzic_search_form();


	$guzic_money	= addslashes($_GET["guzic_money"]);
	$guzic_school	= addslashes($_GET["guzic_school"]);
	$guzic_level	= addslashes($_GET["guzic_level"]);
	$guzic_keyword	= addslashes($_GET["guzic_keyword"]);
	$guzic_si		= addslashes($_GET["guzic_si"]);
	$guzic_gu		= addslashes($_GET["guzic_gu"]);
	$guzic_type		= addslashes($_GET["guzic_jobtype1"]);
	$guzic_type_sub	= addslashes($_GET["guzic_jobtype2"]);
	$guzic_prefix	= addslashes($_GET["guzic_prefix"]);
	#$guzic_prefix	= ( $_GET["career_read"] != "" )?addslashes($_GET["career_read"]):$guzic_prefix;
	$career_read	= addslashes($_GET["career_read"]);
	$job_type_read	= addslashes($_GET["job_type_read"]);
	$guzic_keyword	= addslashes($_GET["guzic_keyword"]);

	$guzic_prefix	= ( $guzic_prefix == "man" )?"남자":$guzic_prefix;
	$guzic_prefix	= ( $guzic_prefix == "girl" )?"여자":$guzic_prefix;



	echo "<br>";
	echo "
		<script>
			function guzicdel(url)
			{
				if ( confirm('정말 삭제 하시겠습니까?') )
				{
					window.location.href = url;
				}
			}
		</script>
	";


	echo "

		<script>
		var request;
		function createXMLHttpRequest()
		{
			if (window.XMLHttpRequest) {
			request = new XMLHttpRequest();
			} else {
			request = new ActiveXObject('Microsoft.XMLHTTP');
			}
		}

		function startRequest(sel,target,size)
		{
		var trigger = sel.options[sel.selectedIndex].value;
		var form = sel.form.name;
		createXMLHttpRequest();
		request.open('GET', '../sub_select.php?form=' + form + '&trigger=' + trigger + '&target=' + target + '&size=' + size, true);
		request.onreadystatechange = handleStateChange;
		request.send(null);
		}

		function startRequest2(sel,target,size)
		{
		var trigger = sel.options[sel.selectedIndex].value;
		var form = sel.form.name;
		createXMLHttpRequest();
		request.open('GET', '../sub_type_select.php?form=' + form + '&trigger=' + trigger + '&target=' + target + '&size=' + size, true);
		request.onreadystatechange = handleStateChange;
		request.send(null);
		}

		function handleStateChange() {
			if (request.readyState == 4) {
				if (request.status == 200) {
				var response = request.responseText.split('---cut---');
				eval(response[0]+ '.innerHTML=response[1]');
				window.status='완료'
				}
			}
			if (request.readyState == 1)  {
			window.status='로딩중.....'
			}
		}

		function allCheck(objname)
		{
			obj = document.getElementsByName(objname)
			cnt = obj.length;

			for ( i=0; i<cnt;i++ )
			{
				if ( obj[i].checked )
				{
					obj[i].checked = false;
				}
				else
				{
					obj[i].checked = true;
				}
			}
		}

		function check_sel(objname)
		{
			obj = document.getElementsByName(objname)
			cnt = obj.length;
			TStr = '';
			gubun = '';
			for ( i=0; i<cnt;i++ )
			{
				if ( obj[i].checked )
				{
					TStr += gubun+obj[i].value;
					gubun = \"|\";
				}
			}

			if ( TStr == '' )
			{
				alert('옵션을 수정하실 구직정보를 하나라도 선택을 해주셔야 합니다.');
				return;
			}
			else
			{
				document.location.href = 'guzic_option.php?action=option_multi&pg=$pg&numbers='+TStr;
			}
		}

		</script>

<p class='main_title cover'>$now_location_subtitle
	<span class='small_btn'><span id='totalguzic'></span></span>
</p>


<form name='search_frm' style='margin:0;'>
<input type='hidden' name='a' value='$_GET[a]'>
<input type='hidden' name='mode' value='$_GET[mode]'>

<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<p class='short' style=''>등록되어있는 이력서정보를 검색할 수 있습니다. 지역 및 직종은 1단계를 선택하면 2단계가 출력 됩니다.</p>
	<table cellspacing='0' cellpadding='0' style='width:100%;' class=''>
	<tr>
		<td style='width:100px; height:34px;'><strong>지역/직종</strong></td>
		<td class='input_style_adm'>$지역검색 $업종검색</td>
	</tr>
	<tr>
		<td style='width:100px; height:34px;'><strong>등록옵션</strong></td>
		<td class='input_style_adm'>
			<select name='guzic_prefix'>
				<option value=''>성별선택</option>
				$성별선택옵션
				</select>
				<select name='grade_money_type'>
				<option value=''>희망연봉선택</option>
				$희망연봉타입
				</select>
				$연령검색박스  $경력검색
				$전공별검색 $규모별검색
		</td>
	</tr>
	<tr>
		<td style='width:100px; height:34px;'><strong>키워드</strong></td>
		<td class='input_style_adm'><input type=text name=guzic_keyword value='$_GET[guzic_keyword]' > <input type='submit' value='검색하기' class='btn_small_dark' style='height:31px; margin-bottom:2px'></td>
	</tr>
	</table>
</div>
</form>


<div id='list_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<table cellspacing='0' cellpadding='0' border='0' class='bg_style b_border'>
	<thead>
	<colgroup>
		<col style='width:10%;'></col>
		<col></col>
		<col style='width:10%;'></col>
		<col style='width:8%;'></col>
		<col style='width:8%;'></col>
		<col style='width:15%;'></col>
		<col style='width:12%;'></col>
	</colgroup>
	<tr>
		<th><input type=checkbox name=allcheck onclick=\"javascript:allCheck('Tnumber[]');\"> 사진</th>
		<th>신상정보</th>
		<th>경력</th>
		<th>사진수정</th>
		<th>유료옵션</th>
		<th>등록일</th>
		<th class='last'>관리자툴</th>
	</tr>
	</thead>
	</table>
	";
	document_extraction_list( 1, 20, '전체', '전체', '관리자모드', '전체', '최근등록일순', 100, 0, 'guzic_list_row.html', "페이징사용" );
	echo '</div><br><input type="button" onclick="javascript:check_sel(\'Tnumber[]\')" value="선택옵션수정" class="btn_small_gray">';
	echo "<div align='center' style='padding:20px 0 20px 0;'>$페이징</div>";

	echo "
		<script>
			document.getElementById('totalguzic').innerHTML	= \"&nbsp;&nbsp;총 이력서 수 : <font color=red> <b>$이력서수</b></font> 개\";

			Imgs = document.getElementsByTagName('img');
			ImgCnt = Imgs.length;
			TmpReg = /admin\/upload\/happy_config/g;
			TmpReplace = 'upload/happy_config';

			for(i=0; i<ImgCnt;i++)
			{
				if ( Imgs[i].src.match(TmpReg) )
				{
					Imgs[i].src = Imgs[i].src.replace(TmpReg,TmpReplace);
				}
			}
		</script>
	";


}


include ("tpl_inc/bottom.php");

if ($demo){
$exec_time = array_sum(explode(' ', microtime())) - $t_start;
$exec_time = round ($exec_time, 2);
print   "<center><font color=gray size=1>Query Time : $exec_time sec";
}
exit;

?>