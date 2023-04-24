<?
/*
	구가 폐지되는 시 정보 업데이트
	(경기 부천시 소사구 -> 경기 부천시)
*/
	include ("../../inc/config.php");
	include ("../../inc/function.php");
	include ("../../inc/lib.php");

	if ( !admin_secure("슈퍼관리자") ) {
			error("접속권한이 없습니다.");
			exit;
	}

	$query_action	= "";	//update 및 delete 실행시 y 값 입력

	$update_si_arr	= array("부천시");
	$update_si_cnt	= count($update_si_arr);

	if ($update_si_cnt == 0)
	{
		echo "수정할 내용이 없습니다.";
		exit;
	}

	foreach($update_si_arr as $update_si)
	{
		$sql	= "
					SELECT
							*
					FROM
							$gu_tb
					WHERE
							gu like '".$update_si." %'
					order by
							number asc
		";
		$Record	= query($sql);

		$count		= 0;
		$gu_num_arr	= array();
		$dong_data	= array();
		$dong_arr	= array();
		while ( $guData = happy_mysql_fetch_array($Record) )
		{
			$gu_num_arr[$count]	= $guData[number];

			$sql2	= "
						SELECT
								*
						FROM
								$dong_tb
						WHERE
								gu_number = '".$guData[number]."'
			";
			$Record2	= query($sql2);
			$dongData = happy_mysql_fetch_array($Record2);

			$dong_data	= explode("\n",$dongData['dong_title']);
			foreach($dong_data as $dongData)
			{
				array_push($dong_arr,$dongData);
			}

			$count++;
		}

		if ($count == 0)
		{
			echo "수정할 내용이 없습니다.";
			exit;
		}

		//print_r2($gu_num_arr);
		//echo nl2br($dong_data);

		//$dong_data	= str_replace(" ","",$dong_data);

		$sql_u	= "
					UPDATE
							$gu_tb
					SET
							gu = '".$update_si."'
					WHERE
							number = '".$gu_num_arr[0]."'
		";
		echo nl2br($sql_u)."<br>";
		if ($query_action == "y")
		{
			query($sql_u);
		}

		$dong_arr		= Array_unique($dong_arr);
		asort($dong_arr);
		$dong_data_all	= implode("\n",$dong_arr);
		$dong_data_all	= str_replace(" ","",$dong_data_all);

		$sql_u2	= "
					UPDATE
							$dong_tb
					SET
							dong_title = '".$dong_data_all."'
					WHERE
							gu_number = '".$gu_num_arr[0]."'
		";
		echo nl2br($sql_u2)."<br>";
		if ($query_action == "y")
		{
			query($sql_u2);
		}

		$gu_num_arr_cnt	= count($gu_num_arr);
		for ($i=1; $i<$gu_num_arr_cnt; $i++)
		{
			$num	= $gu_num_arr[$i];
			$sql_u3	= "
						UPDATE
								$guin_tb
						SET
								gu1 = '".$gu_num_arr[0]."'
						WHERE
								gu1 = '$num'
			";
			echo nl2br($sql_u3)."<br>";
			if ($query_action == "y")
			{
				query($sql_u3);
			}

			$sql_u4	= "
						UPDATE
								$guin_tb
						SET
								gu2 = '".$gu_num_arr[0]."'
						WHERE
								gu2 = '$num'
			";
			echo nl2br($sql_u4)."<br>";
			if ($query_action == "y")
			{
				query($sql_u4);
			}

			$sql_u5	= "
						UPDATE
								$guin_tb
						SET
								gu3 = '".$gu_num_arr[0]."'
						WHERE
								gu3 = '$num'
			";
			echo nl2br($sql_u5)."<br>";
			if ($query_action == "y")
			{
				query($sql_u5);
			}

			$sql_u6	= "
						UPDATE
								$guin_tb
						SET
								gu1_ori = '".$gu_num_arr[0]."'
						WHERE
								gu1_ori = '$num'
			";
			echo nl2br($sql_u6)."<br>";
			if ($query_action == "y")
			{
				query($sql_u6);
			}

			$sql_u7	= "
						UPDATE
								$guin_tb
						SET
								gu2_ori = '".$gu_num_arr[0]."'
						WHERE
								gu2_ori = '$num'
			";
			echo nl2br($sql_u7)."<br>";
			if ($query_action == "y")
			{
				query($sql_u7);
			}

			$sql_u8	= "
						UPDATE
								$guin_tb
						SET
								gu3_ori = '".$gu_num_arr[0]."'
						WHERE
								gu3_ori = '$num'
			";
			echo nl2br($sql_u8)."<br>";
			if ($query_action == "y")
			{
				query($sql_u8);
			}

			$sql_u9	= "
						UPDATE
								$job_com_want_search
						SET
								gu = '".$gu_num_arr[0]."'
						WHERE
								gu = '$num'
			";
			echo nl2br($sql_u9)."<br>";
			if ($query_action == "y")
			{
				query($sql_u9);
			}

			$sql_u10	= "
						UPDATE
								$job_per_want_search
						SET
								gu = '".$gu_num_arr[0]."'
						WHERE
								gu = '$num'
			";
			echo nl2br($sql_u10)."<br>";
			if ($query_action == "y")
			{
				query($sql_u10);
			}

			$sql_u11	= "
						UPDATE
								$per_document_tb
						SET
								job_where1_1 = '".$gu_num_arr[0]."'
						WHERE
								job_where1_1 = '$num'
			";
			echo nl2br($sql_u11)."<br>";
			if ($query_action == "y")
			{
				query($sql_u11);
			}

			$sql_u12	= "
						UPDATE
								$per_document_tb
						SET
								job_where2_1 = '".$gu_num_arr[0]."'
						WHERE
								job_where2_1 = '$num'
			";
			echo nl2br($sql_u12)."<br>";
			if ($query_action == "y")
			{
				query($sql_u12);
			}

			$sql_u13	= "
						UPDATE
								$per_document_tb
						SET
								job_where3_1 = '".$gu_num_arr[0]."'
						WHERE
								job_where3_1 = '$num'
			";
			echo nl2br($sql_u13)."<br>";
			if ($query_action == "y")
			{
				query($sql_u13);
			}

			$sql_d	= "
						DELETE FROM
									$gu_tb
						WHERE
									number = '".$gu_num_arr[$i]."'
			";
			echo nl2br($sql_d)."<br>";
			if ($query_action == "y")
			{
				query($sql_d);
			}

			$sql_d2	= "
						DELETE FROM
									$dong_tb
						WHERE
									gu_number = '".$gu_num_arr[$i]."'
			";
			echo nl2br($sql_d2)."<br>";
			if ($query_action == "y")
			{
				query($sql_d2);
			}
		}
	}

	if ($query_action == "y")
	{
		echo "처리완료";
	}
	else
	{
		echo "출력완료";
	}
?>