<?
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	if ( happy_member_login_check() == "" && !$_COOKIE["ad_id"] ) {
		gomsg("로그인 후 이용하세요","./happy_member_login.php");
		exit;
	}

	//스크랩한 채용정보, 이력서에 평점,메모기능 추가 2015-10-05 kad
	//alter table job_scrap add point int(11) not null default 0;
	//alter table job_scrap add memo text not null default '';


function guin_info_list()
{
	global $plus,$_GET,$GUIN_STATS,$guin_stats_tb,$guin_tb,$list_temp,$MEM,$ADMIN,$guin_banner_tb,$CONF,
	$ARRAY,$ARRAY_NAME,$ARRAY_NAME2,$TPL,$GUIN_INFO,$banner_info, $com_guin_per_tb;
	$ex_limit = '5';

	$org_query = "where (guin_id = '$MEM[id]') and (guin_end_date >= curdate() or guin_choongwon ='1')";

	$sql = "select count(*) from $guin_tb $org_query ";
	//echo "$sql2";
	$result = query($sql);
	list($numb) = mysql_fetch_row($result);//총레코드수



	$up_time = "$MEM[id]" . "/" . happy_mktime();
	$sql2 = "select * ,(TO_DAYS(curdate())-TO_DAYS('2005-10-21')) as gap from $guin_tb $org_query order by guin_end_date asc ";
	//echo "$sql2";
	$result2 = query($sql2);
	$numb = mysql_num_rows($result2);//총레코드수



	if ( $numb == "0" ) {
		$list_temp = "
			<table width='690' cellpadding=0 cellspacing=3 border=0>
				<tr>
					<td align=center>등록중인 구인정보가 없습니다.</td>
				</tr>
			</table>";
		#return $list_temp;
		#exit;
	}

	$list_temp	= "";

	while ($GUIN_INFO = happy_mysql_fetch_array($result2) ){

		$banner_info = "";
		$j = '0';
		$now_info = "<table border=0 width=100% cellspacing=0>	<tr bgcolor=#f4f4f4 ><td > <b>배너모양</td><td> <b>노출형태 </td><td align=center colspan=2> <b>잔여정보 </td><td> </td></tr>	";
		foreach ($ARRAY as $list){
			$list_option = $list . "_option";

			if ($CONF[$list_option] == '기간별') {
			$GUIN_INFO[$list] = $GUIN_INFO[$list] - $GUIN_INFO[gap]; #날짜가 마이너스인 사람은 광고가 끝인사람임
			$print_end = "일 남음";
			}
			else {
			$print_end = "회 남음";
			}

			if ($GUIN_INFO[$list] > 0){
			$now_info .= "<tr><td>$ARRAY_NAME[$j] : </td><td> $CONF[$list_option] </td><td align=right>$GUIN_INFO[$list] </td><td> $print_end</td></tr>";
			}
		$j++;
		}
		$now_info .= "</table>";

		if (eregi(":",$now_info)){ #내용이 없다면
		$banner_info = "<a  onMouseover=\"ddrivetip('$now_info','white', 230)\"; onMouseout=\"hideddrivetip()\"><font color=#15A9D4>유료옵션을 사용하고 있습니다.</a>";
		}
		else {
		$banner_info = "현재 유료채용공고를 이용하고 있지 않습니다.";
		}



		$GUIN_INFO[guin_title] = kstrcut($GUIN_INFO[guin_title], 100 , "...");
		$TPL->parse("리스트");
		$list_temp = &$TPL->fetch();

		$i++;
	}
	#$list_temp .= $TPL->fetch();
	#$list_temp .= "<input type=\"radio\" name=\"cNumber\" value=\"0\">일반 스크랩하기<br>";

	$plus = "&type=$_GET[type]";
	include ("./page.php");
	//$list_temp .= "$page_print";

	return $list_temp;
}


	$mode	= $_GET["mode"];
	$mode	= ( $_POST["mode"] != "" )?$_POST["mode"]:$mode;

	if ( $mode == "com" )
	{
		//이력서 스크랩
		if ( !happy_member_secure($happy_member_secure_text[0].'스크랩') )
		{
			error($happy_member_secure_text[0].'스크랩'."권한이 없습니다.");
			exit;
		}

		$현재위치 = "$prev_stand > <a href=guzic_list.php>인재정보</a> > 스크랩";
		$TPL->define("리스트", "./$skin_folder/scrap_guin_rows.html");

		$list_temp	= guin_info_list();

		$TPL->define("본문내용", "$skin_folder/scrap_guin.html");
		$TPL->assign("본문내용");
		$내용 = &$TPL->fetch();

		$TPL->define("껍데기", "$skin_folder/default.html");
		$TPL->assign("껍데기");

		echo $TPL->fetch();
	}
	else if ( $mode == "per" )
	{

		//채용정보 스크랩
		$cNumber	= preg_replace("/\D/","",$_GET["cNumber"]);
		$userType	= $_GET["userType"];
		$returnUrl	= str_replace("??","&",$_GET["returnUrl"]);
		$listNumber	= preg_replace("/\D/","",$_GET["listNumber"]);

		if ( $cNumber == "" || $userType != "per" )
		{
			error("잘못된 경로로 접근하신거 같네요~ ^^v");
			exit;
		}
		else
		{
			$Sql	= "SELECT Count(*) FROM $scrap_tb WHERE cNumber='$cNumber' AND userid='$user_id' ";
			$Tmp	= happy_mysql_fetch_array(query($Sql));
			if ( $Tmp[0] != 0 )
			{
				$Sql	= "SELECT number FROM $scrap_tb WHERE cNumber='$cNumber' AND userid='$user_id' ";
				$Tmp	= happy_mysql_fetch_array(query($Sql));

				$Sql	= "
							UPDATE
									$scrap_tb
							SET
									cNumber		= '$cNumber',
									userid		= '$user_id',
									userType	= 'per',
									scrapdate	= now()
							WHERE
									number		= '$Tmp[0]'
				";
				#error("이미 등록하신 스크랩입니다.");
				#exit;
			}
			else
			{
				$Sql	= "
							INSERT INTO
									$scrap_tb
							SET
									cNumber		= '$cNumber',
									userid		= '$user_id',
									userType	= 'per',
									scrapdate	= now()
				";
			}
			query($Sql);

			//gomsg("스크랩목록에 추가되었습니다.",$returnUrl);
			if($_GET['is_ajax'] == 'ajax')
			{
				if ( $_COOKIE['happy_mobile'] == "on" )
				{
					if($_GET['img_type'] == 1)
					{
						$scrap_img		= "<img src='mobile_img/star_ico_fill_01.png' alt='★' onClick=\"happy_scrap_change('per','per_del',$cNumber,1,$listNumber);\" style='vertical-align:middle'>";
					}
					else if($_GET['img_type'] == 2)
					{
						$scrap_img		= "<img src='mobile_img/star_ico_fill_02.gif' alt='★2' onClick=\"happy_scrap_change('per','per_del',$cNumber,2,$listNumber);\" style='vertical-align:middle'>";
					}
				}
				else
				{
					if($_GET['img_type'] == 1)
					{
						$scrap_img		= "<img src='img/star_ico_fill_01.png' alt='★' onClick=\"happy_scrap_change('per','per_del',$cNumber,1,$listNumber);\" style='vertical-align:middle'>";

					}
					else if($_GET['img_type'] == 2)
					{
						$scrap_img		= "<img src='img/star_ico_fill_02.gif' alt='★2' onClick=\"happy_scrap_change('per','per_del',$cNumber,2,$listNumber);\" style='vertical-align:middle'>";
					}
				}
				echo "ok___cut___{$scrap_img}";
			}
			else
			{
				error("스크랩목록에 추가되었습니다.");
			}
			exit;
		}
	}
	else if ( $mode == "com_action" )
	{
		$pNumber	= preg_replace("/\D/","",$_POST["pNumber"]);
		$cNumber	= preg_replace("/\D/","",$_POST["cNumber"]);
		$userType	= $_POST["userType"];
		$returnUrl	= str_replace("??","&",$_POST["returnUrl"]);

		if ( $cNumber == "" )
		{
			#채용정보 없이 이력서를 그냥 스크랩할때
			$cNumber = '0';
		}

		#if ( $pNumber == "" || $cNumber == "" || $userType != "com" )
		if ( $pNumber == "" || $userType != "com" )
		{
			error("잘못된 경로로 접근하신거 같네요~ ^^v");
			exit;
		}
		else
		{
			$Sql	= "SELECT Count(*) FROM $scrap_tb WHERE pNumber='$pNumber' AND cNumber='$cNumber' ";
			#echo $Sql;

			$Tmp	= happy_mysql_fetch_array(query($Sql));
			if ( $Tmp[0] != 0 )
			{
				$Sql	= "SELECT number FROM $scrap_tb WHERE pNumber='$pNumber' AND cNumber='$cNumber' ";
				$Tmp	= happy_mysql_fetch_array(query($Sql));

				$Sql	= "
							UPDATE
									$scrap_tb
							SET
									pNumber		= '$pNumber',
									cNumber		= '$cNumber',
									userid		= '$user_id',
									userType	= 'com',
									scrapdate	= now()
							WHERE
									number		= '$Tmp[0]'
				";
				#error("이미 등록하신 스크랩입니다.");
				#exit;
			}
			else
			{
				$Sql	= "
							INSERT INTO
									$scrap_tb
							SET
									pNumber		= '$pNumber',
									cNumber		= '$cNumber',
									userid		= '$user_id',
									userType	= 'com',
									scrapdate	= now()
				";
			}
			query($Sql);

			gomsg("스크랩목록에 추가되었습니다.",$returnUrl);
			exit;
		}
	}
	elseif ( $mode == "com_del") {
		#기업회원이 스크랩이력서 삭제

		$sql = "select * from $scrap_tb where pNumber = '$_GET[pNumber]' and cNumber = '$_GET[cNumber]' and userid = '$MEM[id]'";
		$result = query($sql);
		$row = happy_mysql_fetch_assoc($result);

		if ( $row['userid'] !=  $mem_id &&  $mem_id && $_COOKIE['ad_id'] == "" )
		{
			error("잘못된 접근입니다.");
			exit;
		}

		#print_r2($MEM);
		$sql = "delete from $scrap_tb where pNumber = '$_GET[pNumber]' and cNumber = '$_GET[cNumber]' and userid = '$MEM[id]'";
		query($sql);

		gomsg("스크랩목록에서 삭제되었습니다.","guzic_list.php?file=member_guin_scrap");


	}
	elseif ( $mode == "per_del") {

		$listNumber	= preg_replace("/\D/","",$_GET["listNumber"]);

		$sql = "select * from $scrap_tb where cNumber = '$_GET[cNumber]' and userid = '$MEM[id]'";
		$result = query($sql);
		$row = happy_mysql_fetch_assoc($result);

		if ( $row['userid'] !=  $mem_id &&  $mem_id && $_COOKIE['ad_id'] == "" )
		{
			error("잘못된 접근입니다.");
			exit;
		}

		#개인회원이 스크랩한 채용정보 삭제
		#print_r2($MEM);
		$go_url	= ($_GET['returnUrl'] == '')?"guin_scrap.php":$_GET['returnUrl'];

		$sql = "delete from $scrap_tb where cNumber = '$_GET[cNumber]' and userid = '$MEM[id]'";
		query($sql);

		if($_GET['is_ajax'] == 'ajax')
		{
			if ( $_COOKIE['happy_mobile'] == "on" )
			{
				if($_GET['img_type'] == 1)
				{
					$scrap_img		= "<img src='mobile_img/star_ico_01.png' alt='☆' onClick=\"happy_scrap_change('per','per',$_GET[cNumber],1,$listNumber);\" style='vertical-align:middle'>";
				}
				else if($_GET['img_type'] == 2)
				{
					$scrap_img		= "<img src='mobile_img/star_ico_02.gif' alt='☆2' onClick=\"happy_scrap_change('per','per',$_GET[cNumber],2,$listNumber);\" style='vertical-align:middle'>";
				}
			}
			else
			{
				if($_GET['img_type'] == 1)
				{
					$scrap_img		= "<img src='img/star_ico_01.png' alt='☆' onClick=\"happy_scrap_change('per','per',$_GET[cNumber],1,$listNumber);\" style='vertical-align:middle'>";
				}
				else if($_GET['img_type'] == 2)
				{
					$scrap_img		= "<img src='img/star_ico_02.gif' alt='☆2' onClick=\"happy_scrap_change('per','per',$_GET[cNumber],2,$listNumber);\" style='vertical-align:middle'>";
				}
			}
			echo "ok___cut___{$scrap_img}";
		}
		else
		{
			gomsg("스크랩목록에서 삭제되었습니다.",$go_url);
		}
		exit;
	}
	else if ( $mode == "com_memo" )
	{
		$point	= preg_replace("/\D/","",$_POST["point"]);
		$memo	= $_POST["memo"];

		$sql = "select * from $scrap_tb where pNumber = '$_POST[pNumber]' and cNumber = '$_POST[cNumber]' and userid = '$MEM[id]'";
		$result = query($sql);
		$row = happy_mysql_fetch_assoc($result);

		if ( $row['userid'] !=  $mem_id &&  $mem_id && $_COOKIE['ad_id'] == "" )
		{
			msg("잘못된 접근입니다.");
			exit;
		}

		$sql = "update $scrap_tb set ";
		$sql.= "point = '$point', ";
		$sql.= "memo='$memo' ";
		$sql.= "where pNumber = '$_POST[pNumber]' and cNumber = '$_POST[cNumber]' and userid = '$MEM[id]'";
		//echo $sql;exit;
		query($sql);

		msg("메모가 변경되었습니다.");
		echo "<script>parent.document.location.reload();</script>";

	}
	else if ( $mode == "per_memo" )
	{
		$point	= preg_replace("/\D/","",$_POST["point"]);
		$memo	= $_POST["memo"];

		$sql = "select * from $scrap_tb where cNumber = '$_POST[cNumber]' and userid = '$MEM[id]'";
		$result = query($sql);
		$row = happy_mysql_fetch_assoc($result);

		if ( $row['userid'] !=  $mem_id &&  $mem_id && $_COOKIE['ad_id'] == "" )
		{
			msg("잘못된 접근입니다.");
			exit;
		}

		$sql = "update $scrap_tb set ";
		$sql.= "point = '$point', ";
		$sql.= "memo='$memo' ";
		$sql.= "where cNumber = '$_POST[cNumber]' and userid = '$MEM[id]'";
		//echo $sql;exit;
		query($sql);

		msg("메모가 변경되었습니다.");
		echo "<script>parent.document.location.reload();</script>";

	}





?>