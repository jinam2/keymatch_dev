<?

include ("./inc/Template.php");
$TPL = new Template;

include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");



#시이름, 구이름 변수에 담아두기
$Sql	= "SELECT * FROM $si_tb ";
$Record	= query($Sql);
while ( $Data = happy_mysql_fetch_array($Record) )
{
	$siSelect[$Data["number"]]	= $Data["si"];
	$siNumber[$Data["si"]]		= $Data["number"];
}

$Sql	= "SELECT * FROM $gu_tb ";
$Record	= query($Sql);
while ( $Data = happy_mysql_fetch_array($Record) )
{
	$guSelect[$Data["number"]]	= $Data["gu"];
	$guNumber[$Data["gu"]]		= $Data["number"];
}


$Sql	= "SELECT * FROM $per_document_tb WHERE number='$number' ";
$Data	= happy_mysql_fetch_array(query($Sql));

//이력서등록한 회원
$User = happy_member_information($Data['user_id']);
$User['per_birth'] = $User['user_birth_year']."-".$User['user_birth_month']."-".$User['user_birth_day'];


//로그인한회원
$MEM = happy_member_information(happy_member_login_check());
//로그인한회원이 보유한 유료옵션
$tmp_array = array("guzic_view","guzic_view2","guin_docview","guin_docview2","sms_point");
$Tmem = happy_member_option_get_array($happy_member_option_type,$MEM['user_id'],$tmp_array);
$MEM = array_merge($MEM,$Tmem);
$userid = $MEM['user_id'];
$user_id = $userid;
$MEM['id'] = $user_id;
$MEM['guin_smspoint'] = $MEM['sms_point'];


#보기가능한 날짜
$guin_docview_p = $MEM["guin_docview"] - $real_gap;
if ($guin_docview_p > 0 ) {
	$guin_docview_p_date = date("Y-m-d",happy_mktime(0,0,0,date("m"),date("d")+$guin_docview_p,date("Y")));
} else {
	$guin_docview_p_date = "기간만료";
}

#보기가능한 회수
$guin_docview_c = $MEM["guin_docview2"];
#sms문자발송가능건수
$smsPoint = $MEM["guin_smspoint"];

$Sql	= "SELECT count(*) as cnt FROM $job_com_doc_view_tb WHERE com_id='$user_id' AND doc_number='$number' ";
$Tmp	= happy_mysql_fetch_array(query($Sql));

#회수를 사용하여 볼수 있을때
if ($Tmp["cnt"] != 0) {
	$com_id_secure		= "ok";
}

#기간을 사용하여 볼수 있을때
if ( $MEM["guin_docview"] > $real_gap ) {
	$com_id_secure		= "ok";
	#기간별 이력서를 볼수 있는 권한이 있을경우
}


#echo $com_id_secure;


# 볼수있나 없나 권한을 체크하자 #
if ( $com_id_secure == "ok" )
{
	$secure		= "ok";
}
else if ( $_COOKIE["ad_id"] != "" )
{
	$secure	= "ok";
	$a		= $Data["user_id"];
}
else if ( !happy_member_secure($happy_member_secure_text[0].'보기') )
{
	$secure	= "no";
}





	$returnUrl	= $_SERVER["REQUEST_URI"];
	$returnUrl	= str_replace("&","??",$returnUrl);

	if ( happy_member_secure($happy_member_secure_text[0].'보기') && $_COOKIE["ad_id"] == "" )
	{
		if ( !eregi($userid."," , $Data["viewList"] ) )
		{
			$Data["viewList"]	.= $userid.",";
		}

		$Sql	= "SELECT Count(*) FROM $per_noViewList WHERE per_id='$Data[user_id]' AND com_id='$userid' ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));

		if ( $Tmp[0] != 0 )
		{
			$secure	= "no";
			exit;
		}

		#나중에 스크랩버튼 보이는 기준이 틀려지면 아래꺼 써보아요 ㅡㅡ
		#$Sql	= "SELECT Count(*) FROM $scrap_tb WHERE userid='$user_id' AND pNumber='$number' ";
		#$Tmp	= happy_mysql_fetch_array(query($Sql));

	}
	else if ( ( happy_member_login_check() !="" && $userid == $Data["user_id"] ) || $_COOKIE["ad_id"] != "" )
	{
		$secure	= "ok";

	}

	$search_user_id			= $Data["user_id"];

	$Data["email"]	= $Data["user_email1"];
	if ( $Data["user_email2"] != "" )
		$Data["email"]	.= ( $Data["email"] == "" )?$Data["user_email2"]:",".$Data["user_email2"];



	if ( str_replace("http://","",strtolower($Data["user_homepage"])) == "" )
	{
		$Data["user_homepage"]	= "정보없음";
	}

	if ( $secure == "guinView" )
	{
		if ( !eregi("홈페이지",$viewUserState) )
		{
			$Data["user_homepage"]	= "비공개";
		}
		if ( !eregi("전화번호",$viewUserState) )
		{
			$Data["user_phone"]		= "비공개";
		}
		if ( !eregi("핸드폰",$viewUserState) )
		{
			$Data["user_hphone"]	= "비공개";
		}
		if ( !eregi("주소",$viewUserState) )
		{
			$Data["user_zipcode"]	= "비공개";
			$Data["user_addr1"]		= "비공개";
			$Data["user_addr2"]		= "비공개";
		}
		if ( !eregi("E-mail",$viewUserState) )
		{
			$Data["user_email1"]	= "비공개";
			$Data["user_email2"]	= "비공개";
			$Data["email"]			= "비공개";
		}
	}
	else if ( $secure != "ok" )
	{
		#$Data["title"]			= "열람불가";
		$Data["profile"]		= "열람불가";
		$tmp					= strlen($Data["user_id"]);
		$Data["user_id"]		= substr($Data["user_id"],0,$tmp-3) . "***";
		$Data["user_name"]		= "○○○";
		$Data["user_phone"]		= "열람불가";
		$Data["user_hphone"]	= "열람불가";
		$Data["user_email1"]	= "열람불가";
		$Data["user_email2"]	= "열람불가";
		$Data["user_homepage"]	= "열람불가";
		$Data["user_zipcode"]	= "열람불가";
		$Data["user_addr1"]		= "열람불가";
		$Data["user_addr2"]		= "";
		$Data["email"]			= "열람불가";

		for ( $i=1 ; $i<6 ; $i++ )
		{
			$tmp	= $Data["grade". $i ."_schoolName"];

			for ( $j=0,$max=strlen($tmp),$tmp2="" ; $j<$max ; $j++ )
				$tmp2	.= "○";

			$Data["grade". $i ."_schoolName"]	= $tmp2;
		}
	}



	# 기본 이력서 테이블 값 정리하기 #
	$Count2	= 0;
	for ( $i=1 ; $i<=5 ; $i++ )
		if ( $Data["file".$i] != "" )
			$Count2++;
	$파일수	= $Count2;


	if ( $Data["user_image"] == "" )
	{
		$큰이미지	= $main_url."/img/noimg.gif";
		$작은이미지	= $main_url."/img/noimg.gif";
	}
	else if ( !eregi($per_document_pic,$Data["user_image"]) )
	{
		$큰이미지	= $main_url."/".$Data["user_image"];
		$작은이미지	= $main_url."/".$Data["user_image"];
	}
	else
	{
		$Tmp		= explode(".",$Data["user_image"]);
		if (preg_match("/jpg/i",$Tmp[sizeof($Tmp)-1])) {
			$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], "_thumb.".$Tmp[sizeof($Tmp)-1], $Data["user_image"]);
		} else {
			$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], ".".$Tmp[sizeof($Tmp)-1], $Data["user_image"]);
		}
		$큰이미지	= $main_url."/".$Data["user_image"];
		$작은이미지	= $main_url."/".$Tmp2;
	}
	$이미지	= $큰이미지;

	for ( $i=0,$max=sizeof($skillArray) ; $i<$max ; $i++ )
	{
		switch ( $Data[$skillArray[$i]] )
		{
			case "3": $Data[$skillArray[$i]."_han"] = "상";break;
			case "2": $Data[$skillArray[$i]."_han"] = "중";break;
			case "1": $Data[$skillArray[$i]."_han"] = "하";break;
			default : $Data[$skillArray[$i]."_han"] = "";$Data[$skillArray[$i]] = "0";break;
		}
	}

	$Data["job_type1"]		= $TYPE[$Data["job_type1"]];
	$Data["job_type2"]		= $TYPE[$Data["job_type2"]];
	$Data["job_type3"]		= $TYPE[$Data["job_type3"]];

	$Data["job_type_sub1"]	= $TYPE_SUB[$Data["job_type_sub1"]];
	$Data["job_type_sub2"]	= $TYPE_SUB[$Data["job_type_sub2"]];
	$Data["job_type_sub3"]	= $TYPE_SUB[$Data["job_type_sub3"]];

	for ( $i=1, $Data["job_type"]="" ; $i<4 ; $i++ )
		if ( $Data["job_type_sub".$i] != "" )
		{
			$Data["job_type"]	.= ( $Data["job_type"] == "" )?"":"<br>";
			$Data["job_type"]	.= $Data["job_type".$i] ." > ". $Data["job_type_sub".$i];
		}

	$Data["job_type"]		= ( trim($Data["job_type"]) == "" )?"<font style=font-size:11px>정보없음</font>":$Data["job_type"];

	$Data["work_year"]		= ( $Data["work_year"] == "" )?"경력없음":$Data["work_year"]." 년";
	$Data["work_month"]		= ( $Data["work_month"] == "" )?"":$Data["work_month"]." 개월";


	$Data["user_bohun"]		= ( $Data["user_bohun"] == "Y" )?"대상":"비대상";
	$Data["user_jangae"]	= ( $Data["user_jangae"] != "" )?"장애 ". $Data["user_jangae"]."급":"비장애";
	switch ( $Data["user_army"] )
	{
		case "Y":	$Data["user_army"] = "군필";break;
		case "N":	$Data["user_army"] = "미필";break;
		case "G":	$Data["user_army"] = "면제";break;
	}

	if ( $Data["user_army"] == "군필" && $Data["user_army_start"] != "" && $Data["user_army_end"] != ""  )
	{
		$Data["user_army_status"]	= $Data["user_army_start"]." 입대 ".$Data["user_army_end"]." 제대 ".$Data["user_army_type"]." ".$Data["user_army_level"];
	}
	else
		$Data["user_army_status"]	= "상세정보없음";

	$Data["keyword"]	= ( $Data["keyword"] == "" )?"<font style=font-size:11px>정보없음</font>":$Data["keyword"];

	$Data["job_where1"]	= $siSelect[$Data["job_where1_0"]] ." ". $guSelect[$Data["job_where1_1"]];
	$Data["job_where2"]	= $siSelect[$Data["job_where2_0"]] ." ". $guSelect[$Data["job_where2_1"]];
	$Data["job_where3"]	= $siSelect[$Data["job_where3_0"]] ." ". $guSelect[$Data["job_where3_1"]];

	$Data_job_where		= array();
	array_push($Data_job_where, $Data["job_where1"]);
	array_push($Data_job_where, $Data["job_where2"]);
	array_push($Data_job_where, $Data["job_where3"]);

	for ( $i=0, $max=sizeof($Data_job_where), $Data["job_where"]="" ; $i<$max ; $i++ )
		if ( str_replace(" ","",$Data_job_where[$i]) != "" )
		{
			$Data["job_where"]	.= ( $Data["job_where"] == "" )?"":", ";
			$Data["job_where"]	.= $Data_job_where[$i];
		}

	$Data["job_where"]	= ( trim($Data["job_where"]) == "" )?"정보없음":$Data["job_where"];

	$Data["work_otherCountry"]	= ( $Data["work_otherCountry"] == "Y" )?"해외근무경력있음":"";

//해당 등록폼 불러오기
	# 이미지 정보 추출
	$Sql			= "SELECT * FROM $per_file_tb where doc_number='$number' order by number asc";
	$imageRecord	= query($Sql);

	while ( $imageData = happy_mysql_fetch_array($imageRecord) )
	{
		$imageData['fileName_thumb']	= str_replace("((thumb_name))","_thumb",$imageData['fileName']);
		$imageData['fileName_big']		= str_replace("((thumb_name))","_big",$imageData['fileName']);
		$imageData['fileName']			= str_replace("((thumb_name))","",$imageData['fileName']);

		if( is_file($imageData['fileName_thumb']) ) {
			$outputList	.= "<List miniimg='$imageData[fileName_thumb]' orgimg='$imageData[fileName_big]' title='$xml_popup_names[$i]'/>\n";
		}

	}

if($Data[etc8] == '있음'){
	$incom = $Data[etc9];
}else{
	$incom = "소속사 없음";
}

$Data[work_list] = str_replace("\r","",$Data[work_list]);

$Data[title] = kstrcut($Data[title], 46, "...");

#활동가능요일
$TempDays = explode(" ",$Data['etc7']);
$Data['etc7'] = "";
foreach($TempDays as $k => $v)
{
	$Yicon = $TDayNames[$v];
	if ( $v != '' )
	{
		$Data['etc7'] .= $comma.$Yicon;
		$comma = ",";
	}
}
if ( $Data['etc7'] == '' )
{
	$Data['etc7'] = $HAPPY_CONFIG['MsgNoInputDay1'];
}
#활동가능요일


print <<<END
<?xml version="1.0" encoding="euc-kr"?>
<xmlstart>

<banner>

$outputList


</banner>

<galleryoption wcount="5" Width="70" Height="90" orgWidth="400" orgHeight="600" bgWidth="150" bgHeight="150" bgcount="6" bgrepeat="45" />
<speed infotext="&lt;font size='11'&gt;&lt;b&gt;&lt;font size='16' color='#bf2305'&gt;$Data[title]&lt;/font&gt;&lt;/b&gt;\n 이름 : $Data[user_name] ($Data[user_id])\n 연락처 : $Data[user_hphone] \n 희망지역 : $Data[job_where] \n 희망급여 : $Data[grade_money_type] $Data[grade_money] \n 활동가능요일 : $Data[etc7]"/>
<bgimage bgimage="img/logo/minialbumlogo.png"/>

<!--
\n&lt;b&gt;&lt;font size='12' color='#ff6e03'&gt;경력사항&lt;/font&gt;&lt;/b&gt;\n$Data[work_list]

-->

</xmlstart>

END;
?>