<?php

//헤드헌팅 모듈입니다.

/*
CREATE TABLE `job_company`
(
	`number` int(11) NOT NULL auto_increment,
	`user_id` varchar(50) NOT NULL default '',
	`establish_year` varchar(4) NOT NULL default '',
	`establish_month` varchar(2) NOT NULL default '',
	`sales_money` varchar(100) NOT NULL default '',
	`worker_count` int(11) NOT NULL default '0',
	`company_shape` varchar(50) NOT NULL default '',
	`homepage` varchar(200) NOT NULL default '',
	`take_person` varchar(100) NOT NULL default '',
	`company_name` varchar(100) NOT NULL default '',
	`phone` varchar(15) NOT NULL default '',
	`email` varchar(100) NOT NULL default '',
	`fax` varchar(50) NOT NULL default '',
	`reg_date` datetime NOT NULL default '0000-00-00 00:00:00',
	PRIMARY KEY  (`number`),
	KEY `user_id` (`user_id`)
)

alter table job_guin add company_number int not null;
alter table job_guin add key company_number(`company_number`);

alter table job_com_guin_per add company_number int not null;
alter table job_com_guin_per add key company_number(`company_number`);



alter table job_company add present_name varchar(100) not null default '' after fax; //대표자명
alter table job_company add company_type varchar(200) not null default '' after present_name; // 업종
alter table job_company add company_content text not null default '' after company_type; // 사업내용
*/


//{{회사리스트 가로2개,세로2개,rows_company_list.html,내가등록한회사}}
function company_extraction_list()
{
	global $TPL, $skin_folder;
	global $happy_member_login_value, $job_company;
	global $rows, $페이징, $listNo;


	$arg_title			= array('가로수','세로수','rows파일','리스트타입');
	$arg_names			= array('widthSize','heightSize','template','type');
	$arg_types			= array(
								'widthSize'		=> 'int',
								'heightSize'	=> 'int'
	);

	for ( $i = 0, $max = func_num_args(); $i < $max; $i++ )
	{
		$value = func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int':		$$arg_names[$i] = preg_replace('/\D/','',$value);break;
			case 'char':	$$arg_names[$i] = preg_replace('/\n/','',$value);break;
			default :		$$arg_names[$i] = $value;break;
		}
		//echo '$'.$arg_names[$i]. ' = '. $$arg_names[$i] .'<br>';
	}


	$offset				= $heightSize * $widthSize;


	$WHERE				= '1=1';

	if ( $type == '내가등록한회사' )
	{
		$WHERE				.= " AND user_id = '$happy_member_login_value' ";
	}

	//페이징처리
	$start				= $_GET["start"];
	$scale				= $offset;


	$Sql				= "
							SELECT
									COUNT(*)
							FROM
									$job_company
							WHERE
									$WHERE
	";

	$Temp				= happy_mysql_fetch_array(query($Sql));
	$Total				= $Count = $Temp[0];

	if( $start ) { $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }

	$pageScale			= 10;
	$searchMethod		= "";

	$페이징				= newPaging( $Total, $scale, $pageScale, $start, "<img src='img/btn_pageing_prev.gif' border='0' align='absmiddle'>", "<img src='img/btn_pageing_next.gif' border='0' align='absmiddle'>", $searchMethod);



	$Sql				= "
							SELECT
									*
							FROM
									$job_company
							WHERE
									$WHERE
							ORDER BY
									number DESC
							LIMIT
									$start, $scale
	";

	$Result				= query($Sql);

	$random				= rand(0,9999);
	$TPL->define("회사리스트_$random", "$skin_folder/$template");
	$내용				= "";

	$i = 1;
	while ( $rows = happy_mysql_fetch_assoc($Result) )
	{
		$main_new			= $TPL->fetch("회사리스트_$random");

		if ( $widthSize == "1" )
		{
			$main_new			= "<tr><td valign='top'>".$main_new."</td></tr>";
		}
		elseif ( $i % $widthSize == "1" )
		{
			$main_new			= "<tr><td valign='top'>".$main_new."</td>";
		}
		elseif ( $i % $widthSize == "0" )
		{
			$main_new			= "<td valign='top'>".$main_new."</td></tr>";
		}
		else
		{
			$main_new			= "<td valign='top'>".$main_new."</td>";
		}

		$내용				.= $main_new;
		$i++;

		$listNo--;
	}

	if ( $Total > 0 )
	{
		$내용				= "
								<table cellspacing='0' cellpadding='0' border='0' width=100%>
								$내용
								</table>
		";
	}
	else
	{
		$내용				= "
								<table cellspacing='0' cellpadding='0' border='0' width=100%>
								<tr>
									<td align='center' height='100'>
										등록된 회사가 없습니다.
									</td>
								</tr>
								</table>
		";
	}

	print $내용;
}


// /guin_regist.php 에서 사용될 회사선택 셀렉트박스
// {{회사박스 DETAIL,company}}
function company_select_box($Sel_Global = '', $Sel_Val = '')
{
	global $job_company, $happy_member_login_value, $guin_tb;

	if ( $Sel_Global != '' )
	{
		global $$Sel_Global;

		$Data			= $$Sel_Global;

		$Sel_Val		= $Data[$Sel_Val];
	}

	$WHERE			= '1=1';
	if ( $happy_member_login_value != '' )
	{
		$WHERE			.= " AND user_id = '$happy_member_login_value' ";
	}
	else if ( $_GET['num'] != '' && $_GET['own'] == 'admin' )
	{
		//관리자 수정의 경우 GET값으로 조회후 등록자 ID값 알아내기
		$Sql			= "
							SELECT
									guin_id
							FROM
									$guin_tb
							WHERE
									number = '$_GET[num]'
		";
		$Temp			= happy_mysql_fetch_assoc(query($Sql));

		$WHERE			.= " AND user_id = '$Temp[guin_id]' ";
	}
	else
		$WHERE			.= "AND false";

	$Sql			= "
						SELECT
								company_name,
								number
						FROM
								$job_company
						WHERE
								$WHERE
						ORDER BY
								number DESC
	";
	//echo nl2br($Sql);
	$Record			= query($Sql);
	$Option			= '';
	while ( $rows = happy_mysql_fetch_assoc($Record) )
	{
		$Selected		= $Sel_Val == $rows['number'] ? 'selected' : '';
		$Option			.= "<option value='$rows[number]' $Selected>$rows[company_name]</option>\n";
	}

	$SelectBox		= "
						<select name='company_number'>
							<option value=''>--- 선택 ---</option>
							$Option
						</select>
	";

	echo $SelectBox;
}



// 권한 체크함수 ralear 2014-01-03
function secure_member_bool($user_id, $secure_text)
{
	global $happy_member_login_value, $happy_member, $happy_member_secure;

	$loginUserID	= $happy_member_login_value;

	$Sql			= "SELECT `group` FROM $happy_member WHERE user_id = '$loginUserID' ";
	list($nowGroup)	= happy_mysql_fetch_array(query($Sql));

	$Sql			= "
						SELECT
								Count(*)
						FROM
								$happy_member_secure
						WHERE
								group_number	= '$nowGroup'
								AND
								menu_title		= '$secure_text'
								AND
								menu_use		= 'y'
	";
	//echo nl2br($Sql);
	list($sChk)		= happy_mysql_fetch_array(query($Sql));


	if ( $sChk > 0 )
	{
		return true;
	}
	else
	{
		return false;
	}

	return false;
}



//헤드헌팅 검색박스 2014-01-10 ralear
//{{헤드헌팅검색박스 가로5개,채용}}
//{{헤드헌팅검색박스 가로5개,이력서}}
function company_search_box()
{
	global $happy_member_login_value, $job_company, $hunting_use;

	if ( $hunting_use != true )
	{
		return;
	}

	$arg_title			= array('가로수','검색타입');
	$arg_names			= array('widthSize','search_type');
	$arg_types			= array(
								'widthSize'		=> 'int',
								'heightSize'	=> 'int'
	);

	for ( $i = 0, $max = func_num_args(); $i < $max; $i++ )
	{
		$value = func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int':		$$arg_names[$i] = preg_replace('/\D/','',$value);break;
			case 'char':	$$arg_names[$i] = preg_replace('/\n/','',$value);break;
			default :		$$arg_names[$i] = $value;break;
		}
		//echo '$'.$arg_names[$i]. ' = '. $$arg_names[$i] .'<br>';
	}

	if ( $widthSize == '' )
	{
		echo "가로개수를 지정해 주세요.";
		return;
	}

	$Sql				= "
							SELECT
									*
							FROM
									$job_company
							WHERE
									user_id = '$happy_member_login_value'
							ORDER BY
									number DESC
	";
	//echo nl2br($Sql);

	$Result				= query($Sql);

	$내용				= "";

	$search_name		= $search_type == '채용' ? 'company_guin' : 'company_document';

	$Tmp_Rows			= Array('');
	while ( $rows = happy_mysql_fetch_assoc($Result) )
	{
		array_push($Tmp_Rows, $rows);
	}

	$width				= ceil(100 / $widthSize);
	$i					= 0;
	foreach ( $Tmp_Rows as $Key => $Value )
	{
		$rows				= $Value;

		if ( $i % $widthSize == 0 )
		{
			$내용				.= "<tr>";
		}

		if ( $i == 0 )
		{
			$rows['number']			= '';
			$rows['company_name']	= '전체';
		}

		$checked			= $_GET[$search_name] == $rows['number'] ? 'checked' : '';

		$main_new			= "<span class='h_form'><label for='".$rows['number']."' class='h-radio'><input type='radio' name='".$search_name."' id='".$rows['number']."' value='".$rows['number']."' ".$checked."/><span class='noto400 font_15'>".$rows['company_name']."</span></label></span>";

		$내용				.= "<td valign='top' width='{$width}%' style='line-height:50px; letter-spacing:-1.2px; padding-right:15px'>".$main_new."</td>";
		$i++;

		if ( $i % $widthSize == 0 )
		{
			$내용				.= "</tr>";
		}
	}

	if ( $i % $widthSize != 0 )
	{
		for ( $i = $i % $widthSize; $i < $widthSize; $i++ )
		{
			$내용	.= "<td width='{$width}%' style='line-height:25px;'>&nbsp;</td>\n";
		}

		$내용	.= "</tr>";
	}

	//hidden 값 생성
	$Hidden_Tag			= '';
	foreach ( $_GET as $Key => $Value )
	{
		if ( $Key == $search_name ) continue;

		$Hidden_Tag			.= "
								<input type='hidden' name='".$Key."' value='".$Value."' />\n
		";
	}

	if ( $i > 1 )
	{
		$내용				= "
								<form name='company_search' method='get' style='margin:0px;'>
								$Hidden_Tag

									<table cellspacing='0' cellpadding='0' border='0' width=100%>
										<tr>
											<td style='padding:22px 15px '>
												<table cellspacing='0' cellpadding='0' border='0' width=''>
												$내용
												</table>
											</td>
											<td style='border-left:1px solid #e9e9e9; width:92px;' align='center'>
												<input type='image' src='img/btn_s_search.gif' alt='검색하기' title='검색하기' align='absmiddle' style='cursor:pointer'/>
											</td>
										</tr>
									</table>
								</form>
		";
	}
	else
	{
		$내용				= "
								<table cellspacing='0' cellpadding='0' border='0' width=100%>
								<tr>
									<td align='center' height='100'>
										등록된 회사가 없습니다.
									</td>
								</tr>
								</table>
		";
	}

	print $내용;
}
?>