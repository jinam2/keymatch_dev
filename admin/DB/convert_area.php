<?php

	include ("../../inc/config.php");
	include ("../../inc/function.php");
	include ("../../inc/lib.php");
	include ("../../inc/Template.php");
	$TPL = new Template;


	if ( admin_secure("환경설정") ) {
		error("접속권한이 없습니다.");
		exit;
	}


	$links_run		= "1"; //정보계열 또는 메인컨텐츠에 구/동 정보를 갱신해야될때
	$flash_run		= "1";

	$sol_type		= "links";

	if($sol_type == 'links')
	{
		$upso2_si_tb			= $upso2_si;
		$upso2_si_gu_tb			= $upso2_si_gu;
		$upso2_si_gu_dong_tb	= $upso2_si_gu_dong;

		$links_tb				= $links;
	}


	//gu테이블에 si 값이 잘못된 0값으로 드간게 있어 삭제
	$sql			= "delete from $upso2_si_gu_tb where si=0 ";
	query($sql);


	$h_area	= array(
		"seoul"	=> '서울',
		"gyunggi" => '경기도',
		"gangwon" => '강원도',
		"daegu" => '대구',
		"busan" => '부산',
		"incheon" => '인천',
		"gwangju" => '광주',
		"daejeon" => '대전',
		"ulsan" => '울산',
		"sejong" => '세종시',
		"chungbuk" => '충청북도',
		"chungnam" => '충청남도',
		"gyeongbuk" => '경상북도',
		"gyeongnam" => '경상남도',
		"jeonbuk" => '전라북도',
		"jeonnam" => '전라남도',
		"jeju" => '제주도'
	);


	foreach($h_area AS $val_city => $val_text)
	{
		$sql_si		= "select * from $upso2_si_tb where si='$val_text' ";
		$rec_gu		= query($sql_si);
		$SI_DATA	= happy_mysql_fetch_array($rec_gu);


		if($val_text == '경기도')
		{
			$sql_u	= "update $upso2_si_gu_tb set gu='여주시' where si='$SI_DATA[number]' and gu='여주군' ";
			query($sql_u);

			$sql_u	= "update $upso2_si_gu_tb set gu='용인시 기흥구' where si='$SI_DATA[number]' and gu='용인시  기흥구' ";
			query($sql_u);
		}

		$GU_SWAP	= Array();
		if($val_text == '경상남도')
		{
			if($links_run == 1)
			{
				//동에 구정보가 있으므로 미리 담아둔다
				$sql_gu_tb		= "select * from $upso2_si_gu_tb where gu='창원시' ";
				$rec_gu_tb		= query($sql_gu_tb);
				$GU_TB	= happy_mysql_fetch_assoc($rec_gu_tb);


				$sql_links_gu		= "select * from $links_tb where gu='$GU_TB[number]' ";
				$rec_links_gu		= query($sql_links_gu);
				while($LINKS		= happy_mysql_fetch_assoc($rec_links_gu))
				{
					$GU_SWAP[$LINKS['number']]	= $GU_TB['gu']." ".$LINKS['dong'];
				}
			}

			$sql_d		= "delete from $upso2_si_gu_tb where si='$SI_DATA[number]' and gu='창원시' ";
			query($sql_d);
		}





		$txt_arr	= array();
		$sql		= "select gu,dong from jusogokr_happy_zipcode_{$val_city} group by gu, dong order by gu,dong";
		$result		= query($sql);
		while($data = happy_mysql_fetch_array($result))
		{
			$txt_arr[$data['gu']][]	= $data['dong'];
		}



		foreach($txt_arr AS $key => $val )
		{
			$gu_cnt		= 0;
			$sql_gu		= "select * from $upso2_si_gu_tb where si='$SI_DATA[number]' and gu='$key' ";
			$rec_gu		= query($sql_gu);
			while($GU_DATA	= happy_mysql_fetch_assoc($rec_gu))
			{
				$gu_cnt++;

				$sql_dong	= "update $upso2_si_gu_dong_tb set dong_title='".implode("\n",$val)."' where gu_number='$GU_DATA[number]' ";
				query($sql_dong);
			}

			if($gu_cnt == 0)
			{
				echo $val_text."/".$key."<br>"; //신규생성될 구 정보 확인


				if(trim($key) == '')
				{
					continue;
				}



				$sql_in		= "insert into $upso2_si_gu_tb set si='$SI_DATA[number]', gu='$key' ";
				query($sql_in);

				$sql_id		= "SELECT LAST_INSERT_ID();";
				$result_id	= query($sql_id);
				list($idx)	= mysql_fetch_row($result_id);

				$sql_dong	= "insert into $upso2_si_gu_dong_tb set gu_number='$idx', dong_title='".implode("\n",$val)."' ";
				query($sql_dong);


				if($links_run == 1)
				{
					foreach($GU_SWAP AS $g_key => $g_val)
					{
						if(preg_match("/".$key."/",$g_val))
						{
							$g_ex	= explode(" ",$g_val);
							$sql_u	= "update $links set gu='$idx' , dong='$g_ex[2]' where number='$g_key' ";
							query($sql_u);
						}
					}
					unset($g_key,$g_val);
				}

			}
		}

		//정보계열 또는 메인컨텐츠에 저장하는 애들만, 개포1동 -> 개포동
		if($links_run == 1)
		{
			$sql_links	= "select * from $links_tb where dong != '' ";
			$rec_links	= query($sql_links);
			while($L_DATA = happy_mysql_fetch_assoc($rec_links))
			{
				if(preg_match("/[0-9]/",$L_DATA['dong']))
				{
					$dong_replace = preg_replace("/[0-9]/","",$L_DATA['dong']);
					$sql_u	= "update $links_tb set dong='$dong_replace' where number='$L_DATA[number]' ";
					query($sql_u);
				}
			}
		}

		if($flash_run == 1)
		{
			for ( $i=0 , $max=sizeof($xml_area1) ; $i<$max ; $i++ )
			{
				$xmlpath	= "../../";
				xmlAddressCreate($AREA_SI_NUMBER[$xml_area1[$i]]);
			}
		}

	}
	echo "done!!";

?>