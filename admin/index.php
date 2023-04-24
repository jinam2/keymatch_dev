<?php
include ("../inc/config.php");
include ("../inc/Template.php");
$TPL = new Template;

include ("../inc/function.php");

include ("../inc/lib.php");
// woo TEST
if( $_SERVER["REMOTE_ADDR"] ==  "115.93.87.163")
{
//echo "$pass_id == $admin_id<BR>$pass_pw == $admin_pw";
}

if ( !isset($_COOKIE["ad_id"]) && !$admin )
{
	if ( $demo_lock )
	{
		$demoid	= $admin_id;
		$demopass	= $admin_pw;
	}
	include ("./html/login.html");
	exit;
}


if ( $admin == "login" )
{
	if ( ($pass_id == $admin_id) && ($pass_pw == $admin_pw) )
	{
		setcookie("ad_id","$pass_id",0,"/",$cookie_url);
		setcookie("ad_pass",md5("$pass_pw"),0,"/",$cookie_url);
		//echo "$pass_id == $admin_id<BR>$pass_pw == $admin_pw";
		go("./index.php");
	}
	else
	{
		error("비밀번호가 일치하지 않습니다.");
	}
}
elseif ( $admin == "logout" )
{
	$_COOKIE["ad_id"]	= "";
	$_COOKIE["ad_pass"]	= "";
	setcookie("ad_id","",happy_mktime()-3600,"/",$cookie_url);
	setcookie("ad_pass","",happy_mktime()-3600,"/",$cookie_url);
	Header("Location: $PHP_SELF");
	exit;
}

	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################



	//개인 회원 출력
	$sql = "select number,user_id,user_name,reg_date,user_phone,user_hphone,user_email,`group`,photo1 from $happy_member ";
	$sql .= "  order by number desc limit 7";
	$result = query($sql);
	//if(list($per_num,$id,$per_name,$per_date,$per_phone,$per_cell,$per_email,$per_group) = mysql_fetch_row($result));

	while(list($per_num,$id,$per_name,$per_date,$per_phone,$per_cell,$per_email,$per_group, $photo1) = mysql_fetch_row($result))
	{
		$per_date = explode(" ",$per_date);
		$group_name = happy_member_group_name($per_group);

		if ( $photo1 != "" )
		{
			if ( !preg_match("/http/i",$photo1) )
			{
				$photo1 = "<img src='$main_url/$photo1' align='absmiddle' width='120' />";
			}
			else
			{
				$photo1 = "<img src='$photo1' align='absmiddle' width='120' />";
			}
		}

		$id2		= outputSNSID($id);

		$per_phone	= $per_phone	== ""? "<span style='color:#D0C4CC' class='font_st_11'>정보없음</span>" : $per_phone;
		$per_cell	= $per_cell		== ""? "<span style='color:#D0C4CC' class='font_st_11'>정보없음</span>" : $per_cell;
		$per_email	= $per_email	== ""? "<span style='color:#D0C4CC' class='font_st_11'>정보없음</span>" : $per_email;

		//happy_member.php?type=add&number=326&group_select=0&start=0&search_word=&search_type=
		$per_mem_temp .= "
		<tr>
			<td style='height:35px'>$per_name</td>
			<td>$id2</td>
			<td style='text-align:center;'>$group_name</td>
			<td><span class=font_st_12_tahoma>$per_phone</span></td>
			<td><span class=font_st_12_tahoma>$per_cell</span></td>
			<td style='text-align:center;'><span class=font_st_12_tahoma>$per_date[0]</span></td>
			<td>$per_email</td>
			<td style='text-align:center;'><a href='happy_member.php?type=add&number=$per_num&group_select=$per_group&start=0&search_word=&search_type=' class='btn_small_dark3'>수정</a> <a href=\"javascript:review_del('$per_num');\" class='btn_small_red2' style='margin-top:3px'>삭제</a></td>
		</tr>
		";
		$co--;
		}





	//전체 개인 회원 수
	$sql2 = "select Count(*) from $happy_member";
	$result2 = query($sql2);
	list ( $total_member ) = mysql_fetch_row($result2 );

	//전체 업소 회원 수
	$sql3 = "select Count(*) from $happy_member";
	$result3 = query($sql3);
	list ( $total_member2 ) = mysql_fetch_row($result3 );

	//전체 구인 수
	$sql4 = "select Count(*) from $guin_tb";
	$result4 = query($sql4);
	list ( $total_guin ) = mysql_fetch_row($result4 );

	//전체 구직 수
	$sql5 = "select Count(*) from $per_document_tb";
	$result5 = query($sql5);
	list ( $total_guzic ) = mysql_fetch_row($result5 );


	//전체 접속자 수
	$Sql	= "SELECT sum(totalCount) AS kwak FROM $stats_tb ";
	$Data	= happy_mysql_fetch_array(query($Sql));
	$total	= ( $Data["kwak"] == "" )?"0":$Data["kwak"];

	//오늘 접속자 수
	$chkDate	= date("Y-m-d");
	$Sql	= "SELECT sum(totalCount) AS kwak FROM $stats_tb WHERE left(regdate,10) = '$chkDate' ";
	$Data	= happy_mysql_fetch_array(query($Sql));
	$tday	= ( $Data["kwak"] == "" )?"0":$Data["kwak"];

	//어제 접속자 수
	$chkDate	= date("Y-m-d", happy_mktime(0,0,0,date("m"), date("d")-1, date("Y")) );
	$Sql	= "SELECT sum(totalCount) AS kwak FROM $stats_tb WHERE left(regdate,10) = '$chkDate' ";
	$Data	= happy_mysql_fetch_array(query($Sql));
	$yday	= ( $Data["kwak"] == "" )?"0":$Data["kwak"];





	//장부 통계 시작
	$DateNow	= date("Y-m-d");
	$DateYester	= date("Y-m-d", happy_mktime(0,0,0,date("m"), date("d")-1, date("Y")) );
	$DateMonNow	= date("Y-m");
	$DateMonYst	= date("Y-m", happy_mktime(0,0,0,date("m")-1, date("d"), date("Y")) );

	$Sql		= "SELECT sum(goods_price) , count(*) FROM $jangboo ";
	$Data		= happy_mysql_fetch_array(query($Sql));

	$Sql		= "SELECT sum(goods_price) , count(*) FROM $jangboo2 ";
	$Data2		= happy_mysql_fetch_array(query($Sql));

	$sumPrice	= $Data[0] + $Data2[0];						//총결제금액
	$sumCount	= $Data[1] + $Data2[1];						//총유료결제건수
	$pyunggun	= @number_format($sumPrice / $sumCount);		//1회평균 결제금액


	$Sql		= "SELECT count(*) FROM $jangboo WHERE left(jangboo_date,10) = '$DateNow' ";
	$Data		= happy_mysql_fetch_array(query($Sql));

	$Sql		= "SELECT count(*) FROM $jangboo2 WHERE left(jangboo_date,10) = '$DateNow' ";
	$Data2		= happy_mysql_fetch_array(query($Sql));

	$todayCount	= $Data[0] + $Data2[0];						//오늘유료결제횟수


	$Sql		= "SELECT count(*) FROM $jangboo WHERE left(jangboo_date,10) = '$DateYester' ";
	$Data		= happy_mysql_fetch_array(query($Sql));

	$Sql		= "SELECT count(*) FROM $jangboo2 WHERE left(jangboo_date,10) = '$DateYester' ";
	$Data2		= happy_mysql_fetch_array(query($Sql));

	$yesterCount	= $Data[0] + $Data2[0];					//어제유료결제횟수


	$Sql		= "SELECT count(*) FROM $jangboo WHERE left(jangboo_date,7) = '$DateMonNow' ";
	$Data		= happy_mysql_fetch_array(query($Sql));

	$Sql		= "SELECT count(*) FROM $jangboo2 WHERE left(jangboo_date,7) = '$DateMonNow' ";
	$Data2		= happy_mysql_fetch_array(query($Sql));

	$tMonCount	= $Data[0] + $Data2[0];						//이번달유료결제횟수


	$Sql		= "SELECT count(*) FROM $jangboo WHERE left(jangboo_date,7) = '$DateMonYst' ";
	$Data		= happy_mysql_fetch_array(query($Sql));

	$Sql		= "SELECT count(*) FROM $jangboo2 WHERE left(jangboo_date,7) = '$DateMonYst' ";
	$Data2		= happy_mysql_fetch_array(query($Sql));

	$yMonCount	= $Data[0] + $Data2[0];					//저번달유료결제횟수



	//구인 출력


	$sql6 = "select number,guin_id,guin_com_name,guin_title,guin_date,guin_career,guin_career_year,guin_end_date,guin_choongwon from $guin_tb ";
	$sql6 .= "  order by number desc limit 6";
	$result6 = query($sql6);
	//if(list($guin_num,$guin_id,$guin_com_name,$guin_title,$guin_date,$guin_career,$guin_career_year,$guin_end_date,$guin_choongwon) = mysql_fetch_row($result6));

	while(list($guin_num,$guin_id,$guin_com_name,$guin_title,$guin_date,$guin_career,$guin_career_year,$guin_end_date,$guin_choongwon) = mysql_fetch_row($result6))
	{
		$guin_date = explode(" ",$guin_date);
		$guin_title = kstrcut($guin_title, 36, "...");

		if ( $guin_career == "무관" | $guin_career == "신입"  )
		{
			$guin_career_year = "";
		}
		else
		{
			$guin_career_year = "(".$guin_career_year.")";
		}

		$마감일 = "";
		if ( $guin_choongwon == "1" )
		{
			$마감일 = "충원시";
		}
		else
		{
			$마감일 = $guin_end_date;
		}

		//로고수정
		$TmpMember = happy_member_information($guin_id);
		$logo_url = "../logo_change.php?number=".$TmpMember['number']."&member_group=".$TmpMember['group']."&member_id=".$guin_id;


		$logo_url2 = "../logo_change.php?number=".$TmpMember['number']."&member_group=".$TmpMember['group']."&member_id=".$guin_id."&guin_number=".$guin_num;



		$guin_mem_temp .= "
		<tr>
			<td style='height:35px'><a href='../com_info.php?com_info_id=$guin_id' target='_blank' style='color:#676565;'>$guin_com_name</a></td>
			<td><a href='../guin_detail.php?num=$guin_num' target='_blank' style='color:#676565;'>$guin_title</a></td>
			<td><span class=font_st_11_tahoma style=letter-spacing:0;>$guin_career $guin_career_year</span></td>
			<td style='text-align:center;'><a onClick=\"window.open('$logo_url2','com_log','width=600,height=350,toolbar=no,scrollbars=yes')\" class='btn_small_yellow'>로고수정</a></td>
			<td style='text-align:center;'><a href='guin_option.php?number=$guin_num&action=option&pg=1' class='btn_small_blue'>옵션수정</a></td>
			<td style='text-align:center;'><span class=font_st_11_tahoma>$guin_date[0] / $마감일</span></td>
			<td style='text-align:center;'><a href='../guin_mod.php?mode=mod&num=$guin_num&own=admin' class='btn_small_dark3'>수정</a> <a href=\"javascript:bbsdel('../del.php?mode=guin&num=$guin_num&own=admin');\" class='btn_small_red2' style='margin-top:3px'>삭제</a></td>
		</tr>
		";
		$co--;
		}


	//구직 출력

	$sql7 = "select number,user_id,user_name,title,regdate,user_image,work_year,work_month from $per_document_tb ";
	$sql7 .= "  order by number desc limit 6";
	$result7 = query($sql7);
	//if(list($guzic_num,$guzic_id,$guzic_name,$guzic_title,$guzic_date,$user_image,$work_year,$work_month) = mysql_fetch_row($result7));

	while(list($guzic_num,$guzic_id,$guzic_name,$guzic_title,$guzic_date,$user_image,$work_year,$work_month) = mysql_fetch_row($result7))
	{
		$guzic_date = explode(" ",$guzic_date);
		$guzic_title = kstrcut($guzic_title, 60, "...");


		#사진
		$img_tag = "";
		if ( $user_image == "" )
		{
			$img_tag = '<img src="../upload/no_image.gif" align="absmiddle" border="0" width="60" height="80">';
		}
		else
		{
			if ( !preg_match("/http/i",$user_image) )
			{
				$img_tag = '<img src="../'.$user_image.'" align="absmiddle" border="0" width="60" height="80">';
			}
			else
			{
				$img_tag = '<img src="'.$user_image.'" align="absmiddle" border="0" width="60" height="80">';
			}
		}

		#경력
		$경력 = "";
		if ( $work_year != "" )
		{
			$경력 = (int)$work_year." 년";
		}

		if ( $work_month != "" )
		{
			$경력 .= (int)$work_month." 개월";
		}

		if ( $경력 == "" )
		{
			$경력 = "선택안됨";
		}

		//로고수정
		$TmpMember = happy_member_information($guzic_id);
		$logo_url = "../logo_change.php?number=".$TmpMember['number']."&member_group=".$TmpMember['group']."&member_id=".$guzic_id;

		$guzic_mem_temp .= "
		<tr>
			<td style='text-align:center; height:35px'>$img_tag</td>
			<td><a href='../document_view.php?number=$guzic_num' target='_blank' style='color:#676565;'><font color='#0080FF'>[$guzic_name]</font><br>$guzic_title</a></td>
			<td style='text-align:center;'>$경력</td>
			<td style='text-align:center;'><a onClick=\"window.open('$logo_url','per_log','width=400,height=600,toolbar=no')\" class='btn_small_yellow'>로고수정</a></td>
			<td style='text-align:center;'><a href='guzic_option.php?action=option&number=$guzic_num' class='btn_small_blue'>옵션수정</a></td>
			<td style='text-align:center;'>$guzic_date[0]</td>
			<td style='text-align:center;'><a href='../document.php?mode=modify&subMode=type1&number=$guzic_num' class='btn_small_dark3'>수정</a> <a href=\"javascript:guzicdel('guzic_del.php?number=$guzic_num');\" class='btn_small_red2' style='margin-top:3px'>삭제</a></td>
		</tr>
		";
		$co--;
	}










echo "

<script language='javascript'>
<!--
	function bbsdel(strURL) {
		var msg = ' 회원을 삭제하시겠습니까?';
		if (confirm(msg)){
			window.location.href= strURL;

		}
	}


	function review_del(no)
	{
		if ( confirm('정말 삭제하시겠습니까?') )
		{
			window.location.href = 'happy_member.php?type=del&start=0&search_word=&search_type=&number='+no;
		}
	}
-->
</script>
<script>
	function guzicdel(url)
	{
		if ( confirm('정말 삭제 하시겠습니까?') )
		{
			window.location.href = url;
		}
	}
</script>
<p class='main_title'>최근 회원 가입현황<span class='small_btn'><A HREF='happy_member.php' class='btn_small_stand'>더보기</a></span></p>

<div id='list_style'>
	<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
	<tr>
		<th>이름</th>
		<th>아이디</th>
		<th>회원그룹</th>
		<th>연락처</th>
		<th>휴대폰</th>
		<th>등록일</th>
		<th>이메일</th>
		<th style='width:10%'>관리자툴</th>
	</tr>
	$per_mem_temp
	</table>
</div>


<div style='padding:10px;'></div>


<p class='main_title'>최근 채용정보 등록<span class='small_btn'><A HREF='guin.php?a=guin&mode=list' class='btn_small_stand'>더보기</a></span></p>

<div id='list_style'>
	<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
	<tr>
		<th style='width:15%'>기업명</th>
		<th>제목</th>
		<th>경력</th>
		<th style='width:7%'>로고수정</th>
		<th style='width:7%'>유료옵션</th>
		<th>등록/마감일</th>
		<th style='width:10%'>관리자툴</th>
	</tr>
	$guin_mem_temp
	</table>
</div>


<div style='padding:10px;'></div>


<p class='main_title'>최근 이력서 등록<span class='small_btn'><A HREF='guin.php?a=guin&mode=list' class='btn_small_stand'>더보기</A></span></p>

<div id='list_style'>
	<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
	<tr>
		<th style='width:7%;'>사진</th>
		<th>신상정보</th>
		<th>경력</th>
		<th style='width:8%;'>로고수정</th>
		<th style='width:8%;'>유료옵션</th>
		<th style='width:10%;'>등록일</th>
		<th style='width:10%;'>관리자툴</th>
	</tr>
	$guzic_mem_temp
	</table>
</div>

";

include ("tpl_inc/bottom.php");

?>