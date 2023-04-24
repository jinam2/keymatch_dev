<?php
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");


$happy_member_login_id = happy_member_login_check();
$user_id = $happy_member_login_id;

if ( $num == '' )
{
	error("필요한 매개변수가 넘어오지 않았습니다.");
	exit;
}
else
{
	$HappyTodayGuin	= $_COOKIE["HappyTodayGuin"];

	//쿠키 정리 및 시간 지난건 지우기 (오늘본 채용정보)
	$timeChk	= happy_mktime() - 86400;
	$nowNumChk	= "no";
	$cookieVal	= "";

	$arr		= explode(",",$HappyTodayGuin);
	for ( $i=0, $Count=0, $max=sizeof($arr) ; $i<$max ; $i++ )
	{
		$tmp	= explode("_",$arr[$i]);
		if ( $tmp[1] > $timeChk )
		{
			$cookieVal	.= ( $Count == 0 )?"":",";
			/*
			$cookieVal	.= $arr[$i];
			if ( $num == $tmp[0] )
			{
				$nowNumChk	= "ok";
			}
			*/
			if ( $num != $tmp[0] && $tmp[0] != "" )
			{
				$cookieVal	.= $arr[$i];
			}
			$Count++;
		}
	}
	if ( $nowNumChk != "ok" )
	{
		$cookieVal	.= ( $Count == 0 )?"":",";
		$cookieVal	.= $num ."_". happy_mktime();
	}

	//cookie("HappyTodayGuin",$cookieVal,1);
	setcookie("HappyTodayGuin",$cookieVal,time()+86400,"/",$cookie_url);
	$_COOKIE["HappyTodayGuin"]	= $cookieVal;
	#echo $_COOKIE["HappyTodayGuin"]."<hr>";
}

$Sql	= "update $guin_tb SET guin_count = guin_count + 1 WHERE number='$num'";
query($Sql);

$sql = "select * from $guin_tb where number='$num'";
$result = query($sql);
$DETAIL = happy_mysql_fetch_array($result);

//상세페이지 구인아작스 추추릿 아이디 넘기려고
$_SERVER['QUERY_STRING'].= "&com_info_id=".$DETAIL['guin_id'];

$site_name2 = $DETAIL['guin_title']." - ".$site_name;


if ( $DETAIL['number'] == '' )
{
	//error("삭제된 채용정보 입니다.");
	msg("삭제된 채용정보 입니다.");
	if ( $_SERVER['HTTP_REFERER'] != "" )
	{
		go( $_SERVER['HTTP_REFERER']);
	}
	else
	{
		go($main_url);
	}
	exit;
}

//슈퍼관리자가 아니면서...성인인증을 받지 않았거나 로그인(성인)을 하지 않은 경우는 성인 리스트를 보여주지 말자!
//if(!$_COOKIE['ad_id'] && !$_COOKIE['adult_check'] && !$mem_id && $DETAIL['use_adult'])
//{
//	#echo $_SERVER['REQUEST_URI']; exit;
//	$go_url = urlencode($_SERVER['REQUEST_URI']);
//	gomsg("성인인증을 하셔야 합니다.", "$main_url/html_file.php?file=adultcheck.html&file2=login_default.html&mode=adult_check&go_url=$go_url");
//	exit;
//}

//성인인증 여부
$adult_check = happy_adult_check();
if ( $adult_check != "1" && $DETAIL['use_adult'] )
{
	#echo $_SERVER['REQUEST_URI']; exit;
	$go_url = urlencode($_SERVER['REQUEST_URI']);

	if ( happy_member_login_check() != "" )
	{
		gomsg("회원로그인 이후 성인인증을 1번이라도 하셔야 합니다.","$main_url/html_file.php?file=adultcheck_only.html&file2=login_default.html&mode=adult_check&go_url=$go_url");
	}
	else
	{
		gomsg("성인인증을 하셔야 합니다.", "$main_url/html_file.php?file=adultcheck.html&file2=login_default.html&mode=adult_check&go_url=$go_url");
	}
	exit;
}
//성인인증 여부


$MEM["guzic_view"] = happy_member_option_get($happy_member_option_type,$member_id,'guzic_view');
$MEM["guzic_view2"] = happy_member_option_get($happy_member_option_type,$member_id,'guzic_view2');
$MEM["guzic_smspoint"] = happy_member_option_get($happy_member_option_type,$member_id,'guzic_smspoint');
$MEM["guin_view"] = happy_member_option_get($happy_member_option_type,$member_id,'guin_view');
$MEM["guin_view2"] = happy_member_option_get($happy_member_option_type,$member_id,'guin_view2');
$MEM["guin_smspoint"] = happy_member_option_get($happy_member_option_type,$member_id,'guin_smspoint');


#채용정보 열람권한
$guin_view_numbers = array();
if ( happy_member_secure($happy_member_secure_text[1].'보기') )
{
	$guin_view_numbers = guin_view_numbers($mem_id);
}
else if ( $happy_member_login_id != $DETAIL['guin_id'] )
{
	if ( $happy_member_login_id == '' )
	{
		gomsg("로그인을 해주세요.","happy_member_login.php");
		exit;
	}
	else
	{
		error($happy_member_secure_text[1].'보기 권한이 없습니다.');
		exit;
	}
}

$guin_view = false;
$guin_view = guin_view($DETAIL);
#채용정보 열람권한

$DETAIL['underground1_etc1'] = $DETAIL['underground1'];
$DETAIL['underground2_etc1'] = $DETAIL['underground2'];

$DETAIL['underground1']	= ( $DETAIL['underground1'] == 0 )?"정보없음":$undergroundTitle[$DETAIL['underground1']];
$DETAIL['underground2']	= $undergroundTitle[$DETAIL['underground2']];

if ( $demo_lock == '' )
{
	if ( $guin_view == false )
	{
		$DETAIL['guin_phone'] = "열람불가";
		$DETAIL['guin_name'] = "열람불가";
		$DETAIL['guin_fax'] = "열람불가";
		$DETAIL['guin_homepage'] = "";
		$DETAIL['guin_email'] = "";

		$DETAIL['underground1'] = "열람불가";
		$DETAIL['underground2'] = "";


		$DETAIL['boss_name'] = "열람불가";
		$DETAIL['com_open_year'] = "열람불가";
		$DETAIL['com_worker_cnt'] = "열람불가";
		$DETAIL['com_profile1'] = "열람불가";

		$DETAIL['user_zip'] = "열람불가";
		$DETAIL['user_addr1'] = "";
		$DETAIL['user_addr2'] = "";

	}
}

//echo var_dump($guin_view);






if ( happy_member_secure($happy_member_secure_text[1].'보기 유료결제') && $guin_view == false && $MEM['guzic_view2'] > 0 )
{
	if ( $_COOKIE['happy_mobile'] == "on" )
		{
		$채용정보보기버튼 = "<div style='padding:10px 10px 10px 0; text-align:right'>
										<span class='guin_view_btn'><a href='guin_uryo_view.php?number=".$DETAIL['number']."' >채용정보열람중</a></span>
									</div>
									";
		} else{
			$채용정보보기버튼 = "<a href='guin_uryo_view.php?number=".$DETAIL['number']."' ><img src='img/view_btn_guin.gif' align='absmiddle' border='0' alt='채용정보보기' style='margin-right:3px; vertical-align:middle'></a>";
		}
}


$DETAIL["guin_date_cut"]	= substr($DETAIL["guin_date"],0,10);
$DETAIL["howpeople"]		= ( $DETAIL["howpeople"] == "" || $DETAIL["howpeople"] == 0 )?"00":$DETAIL["howpeople"];
$DETAIL["guin_main"]		= ( $DETAIL["guin_main"] == "" )?"상세요강이 없습니다.":$DETAIL["guin_main"];

if( $DETAIL[regist_mobile] == 'y' )
{
	$DETAIL[guin_main]		= nl2br($DETAIL[guin_main]);
}


if ( $DETAIL["guin_woodae"] != "" )
{
	$arr		= explode(",",$DETAIL["guin_woodae"]);

	$우대사항	= "";
	$우대사항2	= "";
	for ( $i=0,$max=sizeof($arr) ; $i<$max ; $i++ )
	{
		$우대사항	.= ( $i == 0 )?"":", ";
		$우대사항2	.= ( $i == 0 )?"":", ";
		$val		= trim($arr[$i]);

		$우대사항	.= "<a href='guin_list.php?se_order=guin_woodae&se_key=$val' >$val</a>";
		$우대사항2	.= "$val";
	}
}
#비었으면 정보없음으로
if ( $우대사항 == "" )
{
	$우대사항 = "정보없음";
	$우대사항2 = "정보없음";
}
#비었으면 정보없음으로

if ( $DETAIL["keyword"] != "" )
{
	$arr		= explode("/",$DETAIL["keyword"]);

	$키워드	= "";
	$키워드2	= "";
	for ( $i=0,$max=sizeof($arr) ; $i<$max ; $i++ )
	{
		$키워드	.= ( $i == 0 )?"":", ";
		$키워드2	.= ( $i == 0 )?"":", ";
		$val		= trim($arr[$i]);

		$키워드	.= "<a href='guin_list.php?se_order=keyword&se_key=$val'>$val</a>";
		$키워드2	.= "$val";
	}
}
#비었으면 정보없음으로
if ( $키워드 == "" )
{
	$키워드 = "정보없음";
	$키워드2 = "정보없음";
}
#비었으면 정보없음으로

$method		= explode("?", $_SERVER["REQUEST_URI"]);

$온라인입사지원버튼	= "";
$온라인입사지원버튼_모바일	= "모바일 입사지원";
$온라인입사지원폼	= "";
$스크랩버튼			= "";


$view_ok	= $_GET["view_ok"];
if ( $view_ok == "y" && $user_id != "" )
{
	$Sql	= "UPDATE $com_want_doc_tb SET read_ok='Y' WHERE per_id='$user_id' AND guin_number='$num' ";
	query($Sql);
}

$clickChk			= $_GET["clickChk"];
if ( $clickChk != "" && $DETAIL[$clickChk] != "" && $DETAIL[$clickChk] != 0 )
{
	$clickCookieName	= "clickChk_$num_$clickChk";
	if ( $_COOKIE[$clickCookieName] == '' )
	{
		setcookie($clickCookieName,'ok',0,"/",$cookie_url);
		$Sql	= "update $guin_tb SET $clickChk = $clickChk - 1 WHERE number='$num'";
		query($Sql);
	}
}

if ( $happy_member_login_id == "" )
{
	$온라인입사지원버튼_모바일 = "
	<script>
	function online_login_check(msg,url)
	{
		if ( confirm(msg) )
		{
			location.href = url;
		}
	}
	</script>";

	$returnUrl = "happy_member_login.php?returnUrl=".urlencode($_SERVER['REQUEST_URI']);

//	echo $returnUrl;

	$온라인입사지원버튼		= "<a href='javascript:void(0);' onclick=\"alert('로그인 후 이용하세요'); window.location.href='$returnUrl';\">$com_guin_per_button[0]</a>";
	$온라인입사지원버튼_모바일.= "<a href='javascript:void(0);' onclick='online_login_check(\"로그인을 하셔야 합니다.\",\"$returnUrl\");'>모바일 입사지원</a>";
}
else if ( !happy_member_secure($happy_member_secure_text[4]) )
{
	$온라인입사지원버튼_모바일= "<a href='javascript:void(0);' onclick='alert(\"온라인입사지원 권한이 없습니다.\");'>모바일 입사지원</a>";
}


if ( happy_member_secure($happy_member_secure_text[1].'보기') )
{
	$Sql		= "SELECT * FROM $com_guin_per_tb WHERE cNumber='$DETAIL[number]' AND per_id='$user_id' ";
	//echo $Sql;
	$docData	= happy_mysql_fetch_array(query($Sql));

	if ( happy_member_secure($happy_member_secure_text[4]) && $docData["number"] == "" && preg_match("/온라인이력서접수/",$DETAIL["howjoin"]) )
	{
		if ( $DETAIL['guin_end_date'] > $nowDate || $DETAIL['guin_choongwon'] == 1 && $happy_member_login_value != '' )
		{
			if ( $hunting_use == true && $DETAIL['company_number'] != 0 ) //헤드헌팅
			{
				$sql						= "select * from $job_company where number = $DETAIL[company_number]";
				$company_info				= happy_mysql_fetch_assoc(query($sql));

				$DETAIL['guin_com_name']	= $company_info['company_name'];
			}

			$온라인입사지원버튼	= "<a href='#1' onClick='go_guin_join()'>$com_guin_per_button[0]</a>";

			$온라인입사지원버튼_모바일	= "<a href='#online_application' onClick='go_guin_join()'>모바일 입사지원</a>";

			$온라인입사지원폼	= "
				<script>
					function go_guin_join()
					{
						document.guin_join_frm.submit();
					}
				</script>
				<form name='guin_join_frm' method='post' action='guin_join.php'>
					<input type='hidden' name='cNumber' value='$DETAIL[number]'>
					<input type='hidden' name='com_id' value='$DETAIL[guin_id]'>
					<input type='hidden' name='com_name' value='$DETAIL[guin_com_name]'>
					<input type='hidden' name='per_id' value='$user_id'>
				</form>
			";
		}
	}
	else if ( happy_member_secure($happy_member_secure_text[4]) && $docData["number"] != "" && preg_match("/온라인이력서접수/",$DETAIL["howjoin"]) )
	{
		$온라인입사지원버튼 = "<a href='#online_application' onClick='alert(\"이미 온라인 입사지원을 하신 구인정보입니다.\");'>$com_guin_per_button[0]</a>";

		$온라인입사지원버튼_모바일	= "<a href='#online_application' onClick='alert(\"이미 온라인 입사지원을 하신 구인정보입니다.\");'>모바일 입사지원</a>";
	}

	$이메일접수버튼		= "<a href='javascript:void(0);' onclick=\"alert('로그인 후 이용하세요'); window.location.href='$returnUrl';\">$com_guin_per_button[1]</a>";

	if ( happy_member_secure($happy_member_secure_text[6]) && preg_match("/이메일접수/",$DETAIL["howjoin"]) )
	{
		if ( $DETAIL['guin_end_date'] > $nowDate || $DETAIL['guin_choongwon'] == 1 && $happy_member_login_value != '' )
		{
			$이메일접수버튼	= "<a href='#1'  onClick=\"window.open('igocom.php?$method[1]','document_comeon','width=450,height=865,toolbar=no')\">$com_guin_per_button[1]</a>";
		}
	}

	if ( preg_match("/전화접수/",$DETAIL["howjoin"]) )
	{
		if ( $DETAIL['guin_end_date'] > $nowDate || $DETAIL['guin_choongwon'] == 1 )
		{
			$전화접수버튼	= "$com_guin_per_button[2]";
		}
	}

	if ( preg_match("/우편접수/",$DETAIL["howjoin"]) )
	{
		if ( $DETAIL['guin_end_date'] > $nowDate || $DETAIL['guin_choongwon'] == 1 )
		{
			$우편접수버튼	= "$com_guin_per_button[3]";
		}
	}

	if ( preg_match("/방문접수/",$DETAIL["howjoin"]) )
	{
		if ( $DETAIL['guin_end_date'] > $nowDate || $DETAIL['guin_choongwon'] == 1 )
		{
			$방문접수버튼	= "$com_guin_per_button[4]";
		}
	}

	if ( $happy_member_login_id == "" )
	{
		$스크랩링크1 = "<a href=\"javascript:void(0);\" onclick=\"alert('회원으로 로그인을 하셔야 합니다.');\">";
		$스크랩링크2 = "</a>";
	}
	else if ( !happy_member_secure($happy_member_secure_text[1].'스크랩') )
	{
		$스크랩링크1 = "<a href=\"javascript:void(0);\" onclick=\"alert('스크랩 권한이 없습니다.');\">";
		$스크랩링크2 = "</a>";
	}

	if ( $_COOKIE['happy_mobile'] == "on" )
	{
		$스크랩버튼	= $스크랩링크1."<img src=\"./mobile_img/star_ico_01.png\" style='width:22px;'>".$스크랩링크2;
	}
	else
	{
		$스크랩버튼		= "<a href='javascript:void(0);' onclick=\"alert('로그인 후 이용하세요'); window.location.href='$returnUrl';\"><img src='img/btn_scrap_per.gif' border='0' alt='스크랩하기' align='absmiddle' style='margin-right:3px; vertical-align:middle'></a>";
	}



	//echo var_dump(happy_member_secure($happy_member_secure_text[1].'스크랩'));

	if ( happy_member_secure($happy_member_secure_text[1].'스크랩') && $happy_member_login_id != "" )
	{
		$Sql	= "SELECT Count(*) FROM $scrap_tb WHERE cNumber='$num' AND userid='$user_id' AND userType='per' ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));

		if ( $Tmp[0] == 0 )
		{
			$returnUrl	= $_SERVER["REQUEST_URI"];
			$returnUrl	= str_replace("&","??",$returnUrl);

			if ( $_COOKIE['happy_mobile'] == "on" )
			{
				$스크랩버튼	= "<a href='scrap.php?cNumber=$num&userType=per&mode=per&returnUrl=$returnUrl'><img src=\"./mobile_img/star_ico_01.png\"></a>";
			}
			else
			{
				$스크랩버튼	= "<a href='scrap.php?cNumber=$num&userType=per&mode=per&returnUrl=$returnUrl'><img src='img/btn_scrap_per.gif' border='0' alt='스크랩하기' align='absmiddle' style='margin-right:3px; vertical-align:middle'></a>";

			}
		}
		else
		{
			if ( $_COOKIE['happy_mobile'] == "on" )
			{
				$스크랩버튼	= "<a href='javascript:void(0);' onclick=\"alert('이미 스크랩되어 있는 구인정보입니다.');\"><img src=\"./mobile_img/star_ico_fill_01.png\"></a>";
			}
			else
			{
				$스크랩버튼	= "<a 'javascript:void(0);' onclick=\"alert('이미 스크랩되어 있는 구인정보입니다.');\"><img src='./img/btn_scrap_per.gif' alt='스크랩' style='vertical-align:middle; cursor:pointer' ></a>";
				#$스크랩버튼	= "<a href='scrap.php?cNumber=$num&userType=per&mode=per&returnUrl=$returnUrl'><img src='img/btn_scrap_per.gif' border='0' alt='스크랩하기' align='absmiddle'></a>";
			}
		}
	}

	$howjoinMsg	= "";
}
else
{
	$howjoinMsg	= " &nbsp; &nbsp; <font color='gray' style='font-size:8pt'>[ 개인회원으로 로그인하시면 하단에 버튼들이 생성됩니다. ]</font>";
}

$DETAIL["howjoin"]	= ( str_replace(" ","",$DETAIL["howjoin"]) == "" )?"등록된 접수방법이 없습니다.":$DETAIL["howjoin"];
$DETAIL["howjoin"]	.= $howjoinMsg;

$j ='0'; #type
$this_bold = "";
$DETAIL[icon] = "";
foreach ($ARRAY as $list){
	$list_option = $list . "_option";

	if ($CONF[$list_option] == '기간별') {
	$DETAIL[$list] = $DETAIL[$list] - $real_gap; #날짜가 마이너스인 사람은 광고가 끝인사람임
	}
	if ($DETAIL[$list] > 0 ){ #볼드는 아이콘을 안보여준다 : detail에서는 다 보여주자
	$DETAIL[icon] .= "<img src=img/$ARRAY_NAME2[$j] border=0 align=absmiddle> ";
	}
$j++;
}

/////////////////상시채용인지 확인
if ( $DETAIL[guin_choongwon] ) {
	$DETAIL[guin_end_temp] = "충원시";
}
else {
	$DETAIL[guin_end_temp] = "$DETAIL[guin_end_date]";

	//채용마감일의 D-day
	$tnow = date("Y-m-d H:i:s");
	$DETAIL['guin_end_date_dday'] = "D".happy_date_diff($tnow,$DETAIL[guin_end_date]);

}

if ( $DETAIL[guin_choongwon] )
{
	$접수기간	= $접수마감카운터 = "상시채용";
}
else if ( $DETAIL["guin_end_temp"] != "" )
{
	$접수기간	= $DETAIL["guin_date_cut"] ." ~ ". $DETAIL["guin_end_temp"];
}


#접수마감카운터
$접수마감카운터2	= "<span style='color:#{$배경색['서브색상']}'>".$접수마감카운터."</span>";
if( $접수기간 != "상시채용" )
{
	$tnow = date("Y-m-d H:i:s");
	//$end_day = happy_date_diff($tnow,$DETAIL["guin_end_date"]);
	$end_day = happy_date_diff($tnow,$DETAIL["guin_end_date"]);

	$접수마감카운터		= "<span style='color:#333;'>마감</span>  <span style='font-weight:500;'>$end_day</span> <span style='color:#333;'>일전</span>";

	if ( $end_day > 0 )
	{
		$접수마감카운터2	= "<b style='color:#{$배경색['서브색상']}; font-weight:normal;'>D-" . $end_day . "</b><span class='sentence'> 남았습니다.</span>";
	}
	else
	{
		$접수마감카운터2	= "<span style='color:#{$배경색['서브색상']}'>마감되었습니다.</span>";
	}
}

#모바일일 경우 이미지 width값 220px
$board_mobile_mode = false;
if ( $m_version )
{
	if ( $_COOKIE['happy_mobile'] == "on" )
	{
		$board_mobile_mode = true;

		$width_info = "";
		$height_info = "";
	}
	else
	{
		$width_info = " width='$guin_pic_width[1]' ";
		$height_info = " height='$guin_pic_height[1]' ";
	}
}


for ( $i=1 ; $i<=5 ; $i++ )
{
	$Happy_Img_Name = array();

	if ( $DETAIL["img".$i] != "" )
	{
		$tmp		= explode(".",$DETAIL["img".$i]);
		$image_ext	= $tmp[sizeof($tmp)-1];

		/*
		if ( eregi("jp",$image_ext) )
			$image_name	= str_replace( ".".$image_ext , "_thumb.".$image_ext , $DETAIL["img".$i]);
		else
			$image_name	= $DETAIL["img".$i];
		*/
		$Happy_Img_Name[0] = $DETAIL["img".$i];
		$image_name = happy_image("자동",$guin_pic_width[1],$guin_pic_height[1],"로고사용안함","로고위치7번","100","gif원본출력","./img/guin_noimg.gif",$guin_pic_thumb_type,"");

		${"이미지".$i}		= "<img src='". $image_name ."' ".$width_info." ".$height_info." align='absmiddle' style='cursor:pointer' onClick=\"window.open('guin_detail_img.php?num=$num&nowImage=$i','guin_img_view','width=750,height=745,scrollbars=no,toolbar=no')\">";
		${"이미지설명".$i}	= $DETAIL["img_text".$i];
	}
	else
	{
		//${"이미지".$i}		= "<img src='img/icon_detail_noimg.gif' align='absmiddle'".$width_info.">";
		${"이미지설명".$i}	= "";
		$DETAIL["img".$i]	= "img/no_guin_img.gif";
	}
}



/////////////////나이제한
if ( $DETAIL[guin_age] == "0" ) {
	$DETAIL[guin_age_temp] = "제한 없음";
}
else {
	$DETAIL[guin_age_temp] = "$DETAIL[guin_age] 년 이후 출생자";
}

$DETAIL[guin_age_temp2]	= ( $DETAIL["guin_age_temp"] == "제한 없음" )?"제한 없음":( date("Y") - $DETAIL["guin_age"] + 1 )."세 이하";

//////////////////경력 여부
if ( $DETAIL[guin_career] == "경력" )
{
	$DETAIL[guin_career_temp] = "경력 $DETAIL[guin_career_year] 이상";
}
else
{
	if ( $_COOKIE['happy_mobile'] == "on" )
	{
		$DETAIL[guin_career_temp] = "경력{$DETAIL['guin_career']}";
	}
	else
	{
		$DETAIL[guin_career_temp] = "$DETAIL[guin_career]";
	}
}


#근무지역
if ($DETAIL[si1]){
	if ($GU{$DETAIL[gu1]} == ''){
	$GU{$DETAIL[gu1]} = '전체';
	}
$DETAIL[area] .= "<span style='padding-right:10px'><img src='img/icon_detail_map01.gif' style='vertical-align:middle' class='darea_ico'> ".$SI{$DETAIL[si1]}."".$GU{$DETAIL[gu1]}."</span>";
}
if ($DETAIL[si2]){
	if ($GU{$DETAIL[gu2]} == ''){
	$GU{$DETAIL[gu2]} = '전체';
	}
$DETAIL[area] .= "<span style='padding-right:10px'><img src='img/icon_detail_map02.gif' style='vertical-align:middle' class='darea_ico'> ".$SI{$DETAIL[si2]}."".$GU{$DETAIL[gu2]}."</span>";
}
if ($DETAIL[si3]){
	if ($GU{$DETAIL[gu3]} == ''){
	$GU{$DETAIL[gu3]} = '전체';
	}
$DETAIL[area] .= "<span style='padding-right:10px'><img src='img/icon_detail_map03.gif' style='vertical-align:middle' class='darea_ico'> ".$SI{$DETAIL[si3]}."".$GU{$DETAIL[gu3]}."</span>" ;
}

#채용분야
if ($DETAIL[type1]){
	// 카테고리 추가
	$TYPE_SUB_SUB{$DETAIL[type_sub_sub1]}	= ( $TYPE_SUB_SUB{$DETAIL[type_sub_sub1]} == '' )?"<span color='gray'>정보없음</span>":$TYPE_SUB_SUB{$DETAIL[type_sub_sub1]};
	$TYPE_SUB{$DETAIL[type_sub1]}			= ( $TYPE_SUB{$DETAIL[type_sub1]} == '' )?"<span color='gray'>정보없음</span>":$TYPE_SUB{$DETAIL[type_sub1]};

	$DETAIL[type] .= "<span>".$TYPE{$DETAIL[type1]} . " - " . $TYPE_SUB{$DETAIL[type_sub1]} . " - " . $TYPE_SUB_SUB{$DETAIL[type_sub_sub1]} . "</span>";
}
if ($DETAIL[type2]){
	// 카테고리 추가
	$TYPE_SUB_SUB{$DETAIL[type_sub_sub2]}	= ( $TYPE_SUB_SUB{$DETAIL[type_sub_sub2]} == '' )?"<span color='gray'>정보없음</span>":$TYPE_SUB_SUB{$DETAIL[type_sub_sub2]};
	$TYPE_SUB{$DETAIL[type_sub2]}			= ( $TYPE_SUB{$DETAIL[type_sub2]} == '' )?"<span color='gray'>정보없음</span>":$TYPE_SUB{$DETAIL[type_sub2]};

	$DETAIL[type] .= "<span>".$TYPE{$DETAIL[type2]} . " - " . $TYPE_SUB{$DETAIL[type_sub2]} . " - " . $TYPE_SUB_SUB{$DETAIL[type_sub_sub2]} . "</span>" ;
}
if ($DETAIL[type3]){
	// 카테고리 추가
	$TYPE_SUB_SUB{$DETAIL[type_sub_sub3]}	= ( $TYPE_SUB_SUB{$DETAIL[type_sub_sub3]} == '' )?"<span color='gray'>정보없음</span>":$TYPE_SUB_SUB{$DETAIL[type_sub_sub3]};
	$TYPE_SUB{$DETAIL[type_sub3]}			= ( $TYPE_SUB{$DETAIL[type_sub3]} == '' )?"<span color='gray'>정보없음</span>":$TYPE_SUB{$DETAIL[type_sub3]};

	$DETAIL[type] .= "<span>".$TYPE{$DETAIL[type3]} . " - " . $TYPE_SUB{$DETAIL[type_sub3]} . " - " . $TYPE_SUB_SUB{$DETAIL[type_sub_sub3]} . "</span>";
}
$DETAIL[type]	= $DETAIL[type] == '' ? "<span color='gray'>정보없음</span>":$DETAIL[type];

$DETAIL[guin_work_content] = $DETAIL[guin_work_content]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_work_content];

#외국어능력
list($DETAIL[lang_title1],$DETAIL[lang_type1],$DETAIL[lang_point1],$DETAIL[lang_title2],$DETAIL[lang_type2],$DETAIL[lang_point2]) = split(",",$DETAIL[guin_lang]);

$DETAIL[guin_lang] = str_replace(",","",$DETAIL[guin_lang]);
$DETAIL[guin_lang] = $DETAIL[guin_lang] == '' ?"<font color='gray'>정보없음</font>":"$DETAIL[lang_title1] ,  $DETAIL[lang_type1] , $DETAIL[lang_point1] / $DETAIL[lang_title2] ,  $DETAIL[lang_type2] , $DETAIL[lang_point2]";

if ( $DETAIL['lang_type2'] == "" )
{
	$DETAIL['lang_type2'] = "정보없음";
}

#인터뷰정리 , 내용
$DETAIL[guin_interview] = ereg_replace ("\n", "<br>", $DETAIL[guin_interview]);


//복리후생
$bokriArr	= Array();
$bokriNames	= Array();
$bokri	= explode(">",$DETAIL["guin_bokri"]);

if ( is_array($bokri_arr) )
{
	$i = 0;
	foreach( $bokri_arr as $k => $v )
	{
		$bokriArr[$i] = array();
		$Tmpbokri = explode(":",$v);

		if ( array_search($Tmpbokri[0],$bokriNames) === false )
		{
			array_push($bokriNames,$Tmpbokri[0]);
		}
		$i++;
	}
}

if ( is_array($bokri) )
{
	foreach($bokri as $k => $v )
	{
		$Tmpbokri = explode(":",$v);
		#echo $v."<br>";
		if ( array_search($Tmpbokri[0],$bokriNames) !== false )
		{
			$n_key = array_search($Tmpbokri[0],$bokriNames);
			$bokriArr[$n_key][] = $Tmpbokri[1];
		}
	}
}
#print_r2($bokriArr);
#print_r2($bokriNames);


$bokriContent	= "<table cellpadding='0' cellspacing='0' width='100%'>";
$Count			= 0;
for ( $i=0, $max=sizeof($bokriArr) ; $i<$max ; $i++ )
{
	for ( $j=0, $max2=sizeof($bokriArr[$i]); $j<$max2 ; $j++ )
	{
		$Count++;
		if ( $j == 0 )
		{
			$bokriContent	.= "<tr><td class='font_13 font_malgun'>".$bokriNames[$i]." : ".$bokriArr[$i][$j];
		}
		else
			$bokriContent	.= ", ".$bokriArr[$i][$j];
	}
}
$bokriContent	.= "</table>";

$복리후생	= ( $Count == 0 )?"<font color='gray'>등록된 복리후생이 없습니다.</font>":$bokriContent;




$DETAIL[guin_bokri] = ereg_replace (">", ",", $DETAIL[guin_bokri]);
$DETAIL['com_profile1'] = nl2br($DETAIL['com_profile1']);

#회사정보뽑기
$sql = "select * from $happy_member where user_id='$DETAIL[guin_id]'";
$result = query($sql);
$COM = happy_mysql_fetch_array($result);

$COM['id'] = $COM['user_id'];
//$COM['etc1'] = $COM['photo2'];
//$COM['etc2'] = $COM['photo3'];

$COM['etc1'] = $DETAIL['photo2'];
$COM['etc2'] = $DETAIL['photo3'];
$COM['com_job'] = $COM['extra13'];
$COM['com_profile1'] = nl2br($DETAIL['message']);
$COM['com_profile2'] = nl2br($COM['memo']);
$COM['boss_name'] = $COM['extra11'];
$COM['com_open_year'] = $COM['extra1'];
$COM['com_worker_cnt'] = $COM['extra2'];
$COM['com_zip'] = $DETAIL['user_zip'];
$COM['com_addr1'] = $DETAIL['user_addr1'];
$COM['com_addr2'] = $DETAIL['user_addr2'];
$COM['regi_name'] = $COM['extra12'];
$COM['com_phone'] = $COM['user_hphone'];
$COM['com_fax'] = $COM['user_fax'];
$COM['com_email'] = $COM['user_email'];
$COM['com_homepage'] = $COM['user_homepage'];
$COM['sms_ok'] = $COM['sms_forwarding'];
$COM['com_cell'] = $COM['user_hphone'];

$naver_get_addr	= $COM['com_addr1'] ." ". $COM['com_addr2'];



if ( $hunting_use == true && $DETAIL[company_number] != 0 ) //헤드헌팅
{
	$sql = "select * from $job_company where number = $DETAIL[company_number]";
	//echo $sql;
	$company_info = happy_mysql_fetch_assoc(query($sql));

	if($company_info['number'] != '')
	{
		$DETAIL[guin_com_name] = $company_info[company_name];
		$COM[extra11] = $company_info[present_name];
		$COM[extra13] = $company_info[company_type];
		$COM[extra14] = nl2br($company_info[company_content]);
		$COM[extra17] = $company_info[sales_money];
		$COM[extra2] = $company_info[worker_count];


		$COM['extra1']				= $company_info['establish_year']; //설립년도
		$COM['com_maechul']			= $company_info['sales_money']; //매출액
		$COM['com_homepage']		= $company_info['homepage']; //홈페이지

		$DETAIL['boss_name']		= $company_info['present_name']; //대표자
		$DETAIL['com_open_year']	= $company_info['establish_year']; //설립연도
		$DETAIL['com_worker_cnt']	= $company_info['worker_count']; //직원수
	}
}
else
{
	$COM['com_maechul']				= $COM['extra17']; //매출액
	$COM['com_jabon']				= ( !$COM['extra15'] )?"0":number_format($COM['extra15']);

	$DETAIL['boss_name']			= $COM['extra11']; //대표자
	$DETAIL['com_open_year']		= $COM['extra1']; //설립연도
	$DETAIL['com_worker_cnt']		= $COM['extra2']; //직원수
}
//$COM['com_maechul']	= ( !$COM['extra17'] )?"0":number_format($COM['extra17']);

//$COM['com_maechul']	= ( !$COM['extra17'] )?"0":money_type_change($COM['extra17'],'','억','만원','0','korea');


if ( $demo_lock == '' )
{
	if ( $guin_view == false )
	{
		$COM['com_zip'] = "열람불가";
		$COM['com_addr1'] = "";
		$COM['com_addr2'] = "열람불가";
		$naver_get_addr = "열람불가";
	}
}





if ($master_check == '1' || $mem_id == "$COM[id]")
{
	if ( $_COOKIE["ad_id"] )
	{
		$option_modify	= "<a href='admin/guin_option.php?number=$DETAIL[number]&action=option' target='_blank'><img src='img/btn_admin_option_mod.gif' alt='옵션수정' border=0 align='absmiddle'></a>";
	}

$admin_action = <<<END
<script language="javascript">
<!--
	function bbsdel(strURL) {
		var msg = "삭제하시겠습니까?";
		if (confirm(msg)){
			window.location.href= strURL;

		}
	}
-->
</script>
<span>
	<a href=guin_mod.php?mode=mod&num=$DETAIL[number]&own=admin><img src='img/btn_admin_modify.gif' alt='수정' border=0 align='absmiddle'></a> <a href="javascript:bbsdel('./del.php?mode=guin&num=$DETAIL[number]&own=admin');"><img src='img/btn_admin_del.gif' alt='삭제' border=0 align='absmiddle'></a> $option_modify
</span>



END;
}

if ( $_GET['nowPrint'] != '1' )
{
	//$DETAIL[guin_title] .= $admin_action;
}

if ($DETAIL[type1])
{
	$add_location1 = " <a href=guin_list.php?guzic_jobtype1=$DETAIL[type1]>".$TYPE[$DETAIL['type1']] . "</a>";
}
if ($DETAIL[type_sub1])
{
	$add_location2 = " > <a href=guin_list.php?guzic_jobtype1=$DETAIL[type1]&guzic_jobtype2=$DETAIL[type_sub1]>". $TYPE_SUB[$DETAIL["type_sub1"]] . "</a>";
}

//상단 카테고리명 출력
$카테고리명			= Array();
$카테고리명['1차']	= ( $DETAIL['type1'] != "" )		? $TYPE[$DETAIL['type1']]			: "";
$카테고리명['2차']	= ( $DETAIL['type_sub1'] != "" )	? $TYPE_SUB[$DETAIL['type_sub1']]	: "";


$현재위치 = "$prev_stand > <a href=./guin_list.php>채용정보</a> $add_location1 $add_location2  > 상세보기";



$DETAIL[guin_work_content] = $DETAIL[guin_work_content]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_work_content];
$DETAIL[guin_fax] = $DETAIL[guin_fax]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_fax];
$DETAIL[guin_name] = $DETAIL[guin_name]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_name];
$DETAIL[guin_phone] = $DETAIL[guin_phone]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_phone];
$DETAIL[com_name] = $DETAIL[com_name]==''?"<font color='gray'>정보없음</font>":$DETAIL[com_name];
#채용형태는 아이콘으로 추가됨
$DETAIL['guin_type_icon'] = guin_type_icon($DETAIL['guin_type']);
$DETAIL[guin_type] = $DETAIL[guin_type]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_type];



$DETAIL[howpeople] = $DETAIL[howpeople]==''?"<font color='gray'>정보없음</font>":$DETAIL[howpeople]." 명";
$DETAIL[guin_grade] = $DETAIL[guin_grade]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_grade];
$DETAIL[guin_pay] = $DETAIL[guin_pay]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_pay];
$DETAIL[guin_career_temp] = $DETAIL[guin_career_temp]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_career_temp];
$DETAIL[guin_edu] = $DETAIL[guin_edu]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_edu];
$DETAIL[guin_gender] = $DETAIL[guin_gender]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_gender];
$DETAIL[guin_age_temp] = $DETAIL[guin_age_temp]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_age_temp];

// 급여조건(세전/세후)
$DETAIL['pay_type_txt'] = ( $DETAIL['pay_type'] == 'gross' ) ? '세전' : '세후';
if( $DETAIL['guin_pay'] == '면접후 결정' )
{
	$DETAIL['pay_type_txt']	= "";
}

if ( $_GET['nowPrint'] != '1' )
{
	$DETAIL[guin_homepage]	= strtolower($DETAIL[guin_homepage]);
	if (!preg_match("/http(|s):\/\//i",$DETAIL[guin_homepage]))
	{
		$DETAIL[guin_homepage]	= 'http://'.$DETAIL[guin_homepage];
	}
	$DETAIL[guin_homepage]	= ( $DETAIL[guin_homepage] == 'http://' || $DETAIL[guin_homepage] == 'https://' )?"정보없음":"<a href='$DETAIL[guin_homepage]' target='_blank'>".kstrcut($DETAIL[guin_homepage],35,"...")."</a>";
	$DETAIL[guin_email] = $DETAIL[guin_email]==''?"<font color='gray'>정보없음</font>":"<a href='mailto:$DETAIL[guin_email]'>$DETAIL[guin_email]</a>";
}
else
{
	$DETAIL[guin_homepage]	= ( $DETAIL[guin_homepage] == '' || $DETAIL[guin_homepage] == 'http://' )?"정보없음":kstrcut($DETAIL[guin_homepage],35,"...");
	$DETAIL[guin_email] = $DETAIL[guin_email]==''?"<font color='gray'>정보없음</font>":"$DETAIL[guin_email]";
}
#$DETAIL[guin_homepage] = $DETAIL[guin_homepage]==''?"<font color='gray'>정보없음</font>":"<a href='$DETAIL[guin_homepage]' target='_blank'>$DETAIL[guin_homepage]</a>";

$DETAIL[guin_license] = $DETAIL[guin_license]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_license];
$DETAIL[guin_woodae] = $DETAIL[guin_woodae]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_woodae];
$DETAIL[guin_main] = $DETAIL[guin_main]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_main];
$DETAIL[guin_bokri] = $DETAIL[guin_bokri]==''?"<font color='gray'>정보없음</font>":$DETAIL[guin_bokri];
$DETAIL[area] = $DETAIL[area]==''?"<div align='center' style='padding:5;'><font color='gray'>정보없음</font></div>":$DETAIL[area];
$DETAIL[howjoin] = $DETAIL[howjoin]==''?"<font color='gray'>정보없음</font>":$DETAIL[howjoin];



$COM[com_name] = $COM[com_name]==''?"<font color='gray'>정보없음</font>":$COM[com_name];
$COM[boss_name] = $COM[boss_name]==''?"<font color='gray'>정보없음</font>":$COM[boss_name];
$COM[com_type] = $COM[com_type]==''?"<font color='gray'>정보없음</font>":$COM[com_type];
$COM[com_worker_cnt] = $COM[com_worker_cnt]==''?"<font color='gray'>정보없음</font>":$COM[com_worker_cnt]." 명";
$COM[com_job] = $COM[com_job]==''?"<font color='gray'>정보없음</font>":$COM[com_job];
$COM[com_money] = $COM[com_money]==''?"<font color='gray'>정보없음</font>":$COM[com_money];
$COM[main_item] = $COM[main_item]==''?"<font color='gray'>정보없음</font>":$COM[main_item];


$DETAIL[boss_name] = $DETAIL[boss_name]==''?"<font color='gray'>정보없음</font>":$DETAIL[boss_name];
$DETAIL[com_open_year] = $DETAIL[com_open_year]==''?"<font color='gray'>정보없음</font>":$DETAIL[com_open_year];
$DETAIL[com_worker_cnt] = $DETAIL[com_worker_cnt]==''?"<font color='gray'>정보없음</font>":$DETAIL[com_worker_cnt];
$DETAIL[com_profile1] = $DETAIL[com_profile1]==''?"<font color='gray'>정보없음</font>":$DETAIL[com_profile1];

$최종수정일 = ( $DETAIL[guin_modify] == "0000-00-00 00:00:00" )?"수정없음":date_view($DETAIL[guin_modify], "Y년 m월 d일");



if ( file_exists ("./$COM[etc1]") && $COM[etc1] != "" )
{
	$Happy_Img_Name = array();

	$logo_img = explode(".",$COM[etc1]);

	//회사로고 gif 원본출력여부 hong
	if ( $is_logo_gif_org_print && preg_match("/gif/i",$logo_img[1]) )
	{
		$logo_temp = $logo_img;
	}
	else
	{
		$logo_temp = $logo_img[0].".".$logo_img[1];
	}

	$SNS_logo_temp = $main_url."/".$logo_temp;

	if ( file_exists ("./$logo_temp" ) )
	{
		$COM[logo_temp] = "<img src='./$logo_temp' border='0' align='absmiddle'>";
		$Happy_Img_Name[0] = "./".$logo_temp;
	}
	else
	{
		$COM[logo_temp] = "<img src='./$COM[etc1]' border='0' align='absmiddle'>";
		$Happy_Img_Name[0] = "./".$COM['etc1'];
	}
}
else
{
	$COM[logo_temp] = "<img src='./img/logo_img.gif' border='0' align='absmiddle'>";
}



//kakao
$DETAIL['title'] = $DETAIL['guin_title'];
$COM['message_tag'] = strip_tags($COM['message']);
$상세설명텍스트2 = kstrcut(nl2br($COM['message_tag']),132,"...");
$상세설명_카카오스토리 = str_replace("\n","",str_replace("\r","",$상세설명텍스트2));

//카카오스토리
$site_name1 = $site_name;

//카카오스토리 & 카톡으로 보낼 이미지1
$kakao_story_img	= "";
$story_img			= array();
$story_img[0]		= $COM['etc1'];
$src_thumb			= happy_image("story_img.0",300,200,"로고사용안함","로고위치7번","100","gif원본출력",$HAPPY_CONFIG['ImgNoImage1'],"비율대로확대","2");
$kakao_story_img	= $main_url."/".$src_thumb;
//echo $kakao_story_img;

$title_img			= array();
$title_img[0]		= $COM['etc1'];




if ( $guin_view == true )
{
	#쪽지기능 추가됨
	$쪽지보내기 = "<a href='#' onclick=\"window.open('happy_message.php?mode=send&receiveid=".$DETAIL['guin_id']."','happy_message_send','width=730,height=610,toolbar=no,scrollbars=no');\"><img src='./img/btn_message.gif' align='absmiddle' alt='쪽지보내기' border='0'></a>";
}

#활동가능요일
$TempDays = explode(" ",$DETAIL['work_day']);
$DETAIL['work_day'] = '';
foreach($TempDays as $k => $v)
{
	$Yicon = $TDayIcons[$v];
	if ( $v != '' )
	{
		$DETAIL['work_day'] .= '<img src="'.$Yicon.'" border="0" align="absmiddle">';
	}
}
if ( $DETAIL['work_day'] == '' )
{
	$DETAIL['work_day'] = $HAPPY_CONFIG['MsgNoInputDay1'];
}
#활동가능요일

//채용정보수 출력
$type_search = "";
if ( $hunting_use == true && $DETAIL['company_number'] != '' )
{
	$type_search = " AND company_number = '$DETAIL[company_number]' ";
}

$sql01 = "select count(*) from $guin_tb where guin_id='$DETAIL[guin_id]' and  (guin_end_date >= curdate() or guin_choongwon ='1') $type_search";
$result01 = query($sql01);
$COM_WANT_CNT = mysql_fetch_row($result01);

$진행중인채용정보 = number_format($COM_WANT_CNT[0]);

#근무시간
if ( $DETAIL['start_worktime'] != '' )
{
	$TStartWorkTime = explode("-",$DETAIL['start_worktime']);
	$DETAIL['start_worktime'] = $TStartWorkTime[0]." ".$TStartWorkTime[1]."시".$TStartWorkTime[2];
}
else
{
	$DETAIL['start_worktime'] = $HAPPY_CONFIG['MsgNoInputWorkTime1'];
}

if ( $DETAIL['finish_worktime'] != '' )
{
	$TFinishWorkTime = explode("-",$DETAIL['finish_worktime']);
	$DETAIL['finish_worktime'] = $TFinishWorkTime[0]." ".$TFinishWorkTime[1]."시".$TFinishWorkTime[2];
}
else
{
	$DETAIL['finish_worktime'] = $HAPPY_CONFIG['MsgNoInputWorkTime1'];
}

#구직자
if ( $DETAIL['guinperson'] == '' )
{
	$DETAIL['guinperson'] = $HAPPY_CONFIG['MsgNoInputguzicperson1'];
}

#학력
if ( $DETAIL['guineducation'] == '' )
{
	$DETAIL['guineducation'] = $HAPPY_CONFIG['MsgNoInputguziceducation1'];
}

#국적
if ( $DETAIL['guinnational'] == '' )
{
	$DETAIL['guinnational'] = $HAPPY_CONFIG['MsgNoInputguzicnational1'];
}

#파견업체
if ( $DETAIL['guinsicompany'] == '' )
{
	$DETAIL['guinsicompany'] = $HAPPY_CONFIG['NoInputguzicsicompany1'];
}


#문자전송
if ( $CONF['paid_conf'] == "0" || ( $CONF['guzic_smspoint'] == "" ) )
{
	//무료화면 문자를 항상 보내주도록 하자.
	$sms_point = "1";
}
else if ( $MEM['guin_smspoint'] > 0 )
{
	//기업회원 포인트 먼저 차감
	$extra_input2 = "";
	$sms_point = $MEM['guin_smspoint'];
}
else if ( $MEM['guzic_smspoint'] > 0 )
{
	//개인회원 나중
	$extra_input2 = "per";
	$sms_point = $MEM['guzic_smspoint'];
}
else
{
	$sms_point = "0";
}


//if( $MEM["group"] == 1 )
if( is_per_member($happy_member_login_value) == true ) //개인회원이면 , 구직정보등록 권한이 있으면 개인회원
{
	$이력서등록 = <<<END
			<dl class="receipt_method_true_guide">
				<dt>
					<ul>
						<li>[온라인 입사지원] 접수방법을 진행하고 있을 경우 온라인입사지원 버튼을 클릭한 후 자신이 등록한 이력서를 이용하여 입사지원 할 수 있습니다.</li>
						<li>아직 $site_name_original 온라인 이력서를 등록하지 않으셨다면 이력서를 등록하여 주세요.
						<li style='color:#555;'>만약, 본 채용공고에 온라인 입사지원을 한 경우이거나, 본 채용공고에서 [온라인 입사지원] 접수방법을 사용하지 않을 경우 [온라인입사지원] 버튼은 출력되지 않습니다.
					</ul>
				<dd><input type="button" value="이력서등록" onClick="location.href='./document.php?mode=add'" class="btn_resume_regist">
			</dl>
END;
}

if ( $COM['sms_ok'] == 'y' && $COM['com_cell'] != '' && $sms_point > 0 )
{
	$COM['com_cell'] = str_replace("-","",$COM['com_cell']);
	if ( strlen($COM['com_cell']) >= 7 && strlen($COM['com_cell']) <= 12 )
	{

		//Base: hyo : add YOON : 2011-12-01 : 개인회원로그인 채용공고상세 문자발송부분에 사용
		list($group, $user_name) = happy_mysql_fetch_array(query("select `group`, user_name from $happy_member where user_id='$user_id'"));

		$Sql	= "SELECT group_name FROM $happy_member_group WHERE number='$group'";
		list($Group) = happy_mysql_fetch_array(query($Sql));
		$그룹명 = $Group;
		//$SMS포인트 = happy_member_option_get($happy_member_option_type,$user_id,'guin_smspoint');
		$SMS포인트 = happy_member_option_get($happy_member_option_type,$user_id,'guzic_smspoint');
		$SMS포인트 = number_format($SMS포인트);
		//end

		$Data["secure_phone"]	= secure_phone_number($COM["com_cell"]);
		$smsTemplate	= "guin_detail_sms.html";

		$user_dis = $user_id == '' ? 'none' : '';

		$rand	= rand(0,10000);
		$TPL->define("문자전송폼".$rand, "$skin_folder/$smsTemplate");
		$TPL->assign("문자전송폼".$rand);
		$문자전송 = $TPL->fetch();
	}
}
#문자전송



	# 프린트 버튼
	if ( $_GET['nowPrint'] == '1' )
	{
		$template1	= 'guin_detail_print.html';
		$template2	= 'default_guin_print.html';
		$프린트버튼	= "<script>window.print();</script><a href='#print' onClick=\"window.print();\"><img src='img/print_btn_guin.gif' align='absmiddle' border='0' alt='프린트'></a>";
		$프린트버튼1	= "<script>window.print();</script><a href='#print' onClick=\"window.print();\"><img src='img/btn_detail_print1.gif' align='absmiddle' border='0' alt='프린트'></a>";
	}
	else
	{
		$template1	= 'guin_detail.html';
		$template2	= 'default_guin_detail.html';
		$프린트버튼	= "<a href='#print' onClick=\"guinPrint = window.open('?num=$_GET[num]&nowPrint=1','guin_print','width=900,height=600,scrollbars=yes,toolbar=yes');\"><img src='img/print_btn_guin.gif' border='0' align='absmiddle' alt='프린트'></a>";
		$프린트버튼1	= "<a href='#print' onClick=\"guinPrint = window.open('?num=$_GET[num]&nowPrint=1','guin_print','width=900,height=600,scrollbars=yes,toolbar=yes');\"><img src='img/btn_detail_print1.gif' border='0' align='absmiddle' alt='프린트'></a>";
	}

	$tweet_text				= htmlspecialchars(str_replace("'","",$DETAIL['guin_title']));
	//사진을 추출할 본문
	$tweet_img_text			= $DETAIL['guin_main'];
	//상세페이지URL twrand 를 추가한것은 트위터가 캐싱을 해서
	$tweet_url				= "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&twrand=".rand(1,10000);
	//작성자명
	$tweet_writer			= "";

	//클릭이벤트
	$onclicktweet			= 'sns_tweet(\''.$tweet_url.'\',\''.$tweet_text.'\');';

	$tweeter_url = "<a href='javascript:void(0);' onclick=\"".$onclicktweet."\" onfocus='blur();'><img src='img/sns_icon/icon_twitter.png' align='absmiddle' border='0' alt='트위터로 보내기' width='23' height='23' class='png24'></a>";
	$tweeter_url .= '<script>';
	$tweeter_url .= 'function sns_tweet(url,title)';
	$tweeter_url .= '{';
	$tweeter_url .= 'popupURL = \'https://twitter.com/intent/tweet?text=\'+encodeURIComponent(title)+\'&url=\'+encodeURIComponent(url);';
	$tweeter_url .= 'popOption = "width=350, height=500, resizable=no, scrollbars=no, status=no;";';
	$tweeter_url .= 'window.open(popupURL,"pop",popOption);';
	$tweeter_url .= '}';
	$tweeter_url .= '</script>';

	//사진 찾기
	$tweet_img_src				= "";

	for( $img_num = 1 ; $img_num <= 5 ; $img_num++ )
	{
		if ( $DETAIL['img'.$img_num] != "" )
		{
			$tweet_img_src			= $main_url."/".$DETAIL['img'.$img_num]."?".rand(111111,999999);
			break;
		}
	}

	if ( $tweet_img_src == "" )
	{
		//본문에 포함된 사진 찾기
		preg_match_all("/<img[^>]*src=[\"\"]?([^>\"\"]+)[\"\"]?[^>]*>/i",$tweet_img_text,$IMG_INFO);
		//print_r2(array_filter($IMG_INFO[1]));
		if ( $IMG_INFO[1][0] != "" )
		{
			$title_img[0]		= ".".$IMG_INFO[1][0];
			$title_img[0]		= str_replace("./wys2","wys2",$title_img[0]);
			$tweet_img			= array();
			$tweet_img[0]		= $title_img[0];
			$src_thumb			= happy_image("tweet_img.0",600,400,"로고사용안함","로고위치7번","100","gif원본출력",$HAPPY_CONFIG['ImgNoImage1'],"비율대로확대","2");
			//$src_thumb			= "flash_banner/event_8.jpg";
			$tweet_img_src	= $main_url."/".$src_thumb."?".rand(111111,999999);
		}
	}


	$tweeter_meta  = '<meta name="twitter:card"           content="summary_large_image">'."\n";
	$tweeter_meta .= '<meta name="twitter:site"           content="'.$site_name.'">'."\n";
	$tweeter_meta .= '<meta name="twitter:title"          content="'.$tweet_text.'">'."\n";
	$tweeter_meta .= '<meta name="twitter:creator"        content="'.$tweet_writer.'">'."\n";
	$tweeter_meta .= '<meta name="twitter:image"          content="'.$tweet_img_src.'">'."\n";
	$tweeter_meta .= '<meta name="twitter:description"    content="'.kstrcut(strip_tags($tweet_img_text),100,"..").'">'."\n";
	##################### tweeter 를 위한 API : 2010.11.1 NeoHero ####################

	$meta_url	= $main_url.'/guin_detail.php?num='.$_GET[num].'&cou='.$_GET[cou];
	$default_meta	= '<meta property="og:title"		content="'.$tweet_text.'"/>'."\n";
	$default_meta	.= '<meta property="og:type"		content="website"/>'."\n";
	$default_meta	.= '<meta property="og:url"			content="'.$meta_url.'"/>'."\n";
	$default_meta	.= '<meta property="og:image"		content="'.$tweet_img_src.'"/>'."\n";
	$default_meta	.= '<meta property="og:description"	content="'.kstrcut(strip_tags($tweet_img_text),100,"..").'">'."\n";
	$default_meta	.= '<meta property="og:author"		content="'.$DETAIL['guin_name'].'"/>'."\n";



	#facebook 를 위한 API : 2012.04.30  NeoHero
	$facebook_p_url	= urlencode("$main_url/facebook_scrap.php?number=$_GET[num]&page_method=guin_detail");
	$facebook_url	= "<a href='javascript:void(0);'><img src='img/sns_icon/icon_facebook.png' align='absmiddle' style='cursor:pointer' onclick=\"window.open('https://www.facebook.com/sharer/sharer.php?sdk=joey&u=$facebook_p_url','facebook_scrap','width=640,height=460');\" /></a>";
	#facebook 를 위한 API : 2012.04.30  NeoHero

	$site_name2 = $DETAIL['title']." - ".$site_name;

	// 네이버 밴드 공유 하기 - x2chi 2015-01-28 (앱 말고 웹전용) - {{naverBand}}
	$naverBandTitle		= (preg_match('/euc/i',$server_character)) ? iconv("euc-kr", "UTF-8", $site_name2) : $site_name2;
	$naverBandTitle		= rawurlencode( $naverBandTitle." http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] );
	$naverBand = "
		<script type=\"text/javascript\">
			function naverBand ()
			{
				window.open(\"http://www.band.us/plugin/share?body=".$naverBandTitle."&route=".$_SERVER["SERVER_NAME"]."\", \"share_band\", \"width=410, height=540, resizable=no\");
			}
		</script>
		<a href='javascript:void(0);'><img src=\"img/sns_icon/icon_naver_band_02.png\" onclick=\"naverBand();\" align=\"absmiddle\" style=\"cursor:pointer;\" alt=\"네이버 밴드 공유\"></a>
	";
	/*
$C공감 = cyword_scrap('detail');


#me2day 를 위한 API : 2010.11.1 NeoHero
$me2day_text_u = "\"$main_url/guin_detail.php?num=$DETAIL[number]\":$main_url/guin_detail.php?num=$DETAIL[number]";
$me2day_text_t = "$DETAIL[guin_title]";
if ($server_character == 'euckr'){
	$me2day_text_u = iconv("euc-kr" , "UTF-8",$me2day_text_u);
	$me2day_text_t = iconv("euc-kr" , "UTF-8",$me2day_text_t);
}
$me2day_text_u = urlencode($me2day_text_u);
$me2day_text_t = urlencode($me2day_text_t);
$me2day_url = "<a href='http://me2day.net/posts/new?new_post[body]=$me2day_text_u&new_post[tags]=$me2day_text_t' target=_blank onfocus='blur();'><img src=img/sns_icon/icon_me2day.png align=absmiddle border=0 alt='미투데이로 보내기'></a>";
*/
#me2day  를 위한 API : 2010.11.1 NeoHero
//2011-05-11 HYO end 트위터, 페이스북, 미투데이 추가

	#hyo by add > YOON by edited 2011-11-27
	//if ($DETAIL['underground1'] == 0)
	if ($DETAIL['underground1'] == '' || $DETAIL['underground1'] == '정보없음(열람불가)' || $DETAIL['underground1'] == '열람불가')
	{
		#역검색 버튼
		$역검색 = "";
		$주변채용검색버튼 = "";
	}
	else
	{
		#역검색 버튼
		$역검색 = "onclick=window.location.href='guin_list.php?action=search&file=guin_list_after.html&underground1=$DETAIL[underground1_etc1]&underground2=$DETAIL[underground2_etc1]'";
		//$역검색 = "guin_list.php?action=search&file=guin_list_after.html&underground1=$DETAIL[underground2_etc1]&underground2=$DETAIL[underground2_etc1]";
		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$주변채용검색버튼 = "<input type='button' value='주변채용검색' style='border:1px solid #dedede; padding:5px; letter-spacing:-1.5px; background:#fff; vertical-align:middle' $역검색 class='font_12 font_malgun'>";
		} else{
			$주변채용검색버튼 = "<input type='button' value='$DETAIL[underground2]역 주변채용검색' style='border:1px solid #dedede; height:21px; line-height:21px; padding:0 5px 0 5px;' $역검색>";
		}
	}


//채용정보 열람 사용자 인원수 체크 hong
$DETAIL['guin_detail_view'] = guin_detail_view_check($DETAIL['number']);

$문의하기 = "";
if ( happy_member_secure( $happy_member_secure_text[1].'문의' ) && $HAPPY_CONFIG['inquiry_form_use_conf'] != "no" )
{
	if ( $HAPPY_CONFIG['inquiry_form_use_conf'] == "all" || $DETAIL['inquiry_use'] == "y" )
	{
		$문의하기	= "<a href='happy_inquiry.php?links_number=$DETAIL[number]' onfocus='this.blur();'><img src='img/detail_btn_qna_on.gif' border='0' alt='문의하기' align='absmiddle' style='margin-left:2px;'></a>";
	}
}

//관리자일때 네이버블로그전송내용 작성
if ( admin_secure('슈퍼관리자전용') && is_file("$skin_folder/naver_blog_guindetail.html") !== false )
{
	$TPL->define("네이버블로그전송내용", "$skin_folder/naver_blog_guindetail.html");
	$네이버블로그전송내용	= &$TPL->fetch('네이버블로그전송내용');
}

//echo "./$skin_folder/$template1";
$TPL->define("구인상세", "./$skin_folder/$template1");
$TPL->assign("구인상세");
$내용 = &$TPL->fetch();

#echo "./$skin_folder/$template2";
$TPL->define("껍데기", "./$skin_folder/$template2");
$TPL->assign("껍데기");
$ALL = &$TPL->fetch();


echo $ALL;
exit;


?>