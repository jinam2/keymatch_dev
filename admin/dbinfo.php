<?
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");


	if ( !admin_secure("슈퍼관리자전용") ) {
		error("접속권한이 없습니다.");
		exit;
	}
	include ("tpl_inc/top_new.php");

	$table_memo	= Array(
					'counter'					=> '사용안되는 테이블',
					'happy_banner'				=> '배너관리툴 테이블',
					'happy_banner_log'			=> '배너 로그 테이블',
					'job_admin'					=> '구인구직 기본설정 테이블',
					'job_area'					=> '구인/구직 옵션설정 테이블',
					'job_com_doc_view'			=> '기업회원이 이력서 본 체크 테이블',
					'job_com_guin'				=> '개인회원이 구인에 접수한 테이블 => 옛날꺼인듯..',
					'job_com_guin_per'			=> '개인회원이 구인에 접수한 테이블',
					'job_com_member'			=> '기업회원정보 테이블',
					'job_com_want_doc'			=> '기업회원이 특정 이력서(개인회원)에게 입사지원요청 하는 테이블',
					'job_conf'					=> '유료설정테이블',
					'job_gongi'					=> '사용안함',
					'job_guin'					=> '구인정보테이블',
					'job_guin_stats'			=> '사용안함',
					'job_guzic'					=> '사용안함',
					'job_jangboo'				=> '기업회원 결제내역 테이블',
					'job_jangboo2'				=> '개인회원 결제내역 테이블',
					'job_keyword'				=> '실시간검색 키워드 순위 테이블',
					'job_main_banner'			=> '사용안함',
					'job_per_document'			=> '이력서테이블',
					'job_per_file'				=> '개인회원 첨부파일 리스트 (미니앨범)',
					'job_per_language '			=> '이력서 정보중 외국어 구사능력 테이블',
					'job_per_member'			=> '개인회원정보 테이블',
					'job_per_mylist'			=> '개인맞춤구직테이블',
					'job_per_noViewList'		=> '개인회원이 자신의 이력서를 특정회사에는 보이지 않도록 설정하는 테이블',
					'job_per_skill'				=> '이력서 정보중 자격사항(자격증) 테이블',
					'job_per_view'				=> '사용안함',
					'job_per_worklist'			=> '이력서 정보중 경력사항 리스트 테이블',
					'job_per_yunsoo'			=> '이력서 정보중 해외연수 리스트 테이블',
					'job_scrap'					=> '스크랩 테이블 (개인/기업 공동사용)',
					'job_si'					=> '지역정보(시) 테이블',
					'job_si_gu'					=> '지역정보(구) 테이블',
					'job_si_gu_dong'			=> '지역정보(동) 테이블',
					'job_stats'					=> '접속통계 테이블',
					'job_type'					=> '직종설정(1차)',
					'job_type_sub'				=> '직종설정(2차)',
					'job_vote'					=> '투표 테이블',
					'job_zip'					=> '우편번호 테이블'
	);



	echo "
		<STYLE TYPE='text/css'>
			.titleTBL1{width:20%; background-color:#FBF8EE; font-weight:bold; text-align:center; color:#555;padding:7px 0 5px 0; border-width:1px 0 1px 0; border-style:solid; border-color:#CCC;}	 /* Field*/
			.titleTBL2{width:20%; background-color:#FBF8EE; font-weight:bold; text-align:center; color:#555;padding:7px 0 5px 0; border-width:1px 0 1px 0; border-style:solid; border-color:#CCC;}	 /* Type */
			.titleTBL3{width:10%; background-color:#FBF8EE; font-weight:bold; text-align:center; color:#555;padding:7px 0 5px 0; border-width:1px 0 1px 0; border-style:solid; border-color:#CCC;}	 /* Null */
			.titleTBL4{width:7%; background-color:#FBF8EE; font-weight:bold; text-align:center; color:#555;padding:7px 0 5px 0; border-width:1px 0 1px 0; border-style:solid; border-color:#CCC;}	 /* Key */
			.titleTBL5{width:20%; background-color:#FBF8EE; font-weight:bold; text-align:center; color:#555;padding:7px 0 5px 0; border-width:1px 0 1px 0; border-style:solid; border-color:#CCC;}	 /* Default */
			.titleTBL6{width:; background-color:#FBF8EE; font-weight:bold; text-align:center; color:#555;padding:7px 0 5px 0; border-width:1px 0 1px 0; border-style:solid; border-color:#CCC;}	 /* Extra */

			.valueTBL1{padding:4px 5px 3px 5px; font-size:11px; font-family:tahoma; background-color:white; text-align:left;}	 /* Field 값 */
			.valueTBL2{padding:4px 5px 3px 5px; font-size:11px; font-family:tahoma; background-color:white; text-align:left;}	 /* Type 값 */
			.valueTBL3{padding:4px 5px 3px 5px; font-size:11px; font-family:tahoma; background-color:white; text-align:center;}	 /* Null 값 */
			.valueTBL4{padding:4px 5px 3px 5px; font-size:11px; font-family:tahoma; background-color:white; text-align:center;}	 /* Key 값 */
			.valueTBL5{padding:4px 5px 3px 5px; font-size:11px; font-family:tahoma; background-color:white; text-align:left;}	 /* Default 값 */
			.valueTBL6{padding:4px 5px 3px 5px; font-size:11px; font-family:tahoma; background-color:white; text-align:left;}	 /* Extra 값 */

			.infoTBL1{width:150px; font-size:12px; font-weight:bold; background-color:#DFE3AA; padding:5px 5px 3px 10px; color:#222; text-align:left;}
			.infoTBL2{width:10px;}
			.infoTBL3{width:275px; text-align:left;}
			.infoTBL3_2{ text-align:left; }
			.infoTBL4{font-size:12px; font-weight:bold; background-color:#D8DD96; padding:5px 5px 3px 5px; color:#222;}

			.hrNormal{border-width:1px; border-style:dotted; border-color:#CCC; margin:-5px 0 0 0;}
			.hrNormal2{border-width:1px; height:2px; border-style:solid; border-color:#CCC; margin:-3px 0 0 0;}
			.hrNormalDiv{width:100%; height:6px; border:0 solid red; overflow:hidden;}
			.hrNormalDiv2{width:100%; height:10px; border:0 solid red; overflow:hidden;}
		</STYLE>
	";



	$Sql	= "SHOW TABLE STATUS FROM $db_name";
	$dbRec	= query($Sql);


	while ( $dbData = happy_mysql_fetch_array($dbRec) )
	{
		$sTable		= $dbData['Name'];
		$tableMemo	= $table_memo[$sTable];

		if ( $tableMemo == '' )
		{
			$tableMemo	= eregi("board_",$sTable)? '게시판 생성 테이블' : '정보없음';
		}



		echo "



<center>
				<div style='width:98%;'>

				<BR><BR>

				<table  border='0' cellspacing='0' cellpadding='0' align='center'>
				<tr>
					<td width='21' height='40' background='img/bg_titlebar01a.gif'></td>
					<td background='img/bg_titlebar01b.gif' style='color:#07A; font-weight:bold; padding:1 15 0 15; font-family:tahoma; 돋움;'>$dbData[0] <FONT style='font-family:돋움; color:#333;'> 테이블정보</FONT></td>
					<td width='21' background='img/bg_titlebar01c.gif'></td>
				</tr>
				</table>

				<BR>

				<div style='width:98%;' id='box_style'>
					<div class='box_1'></div>
					<div class='box_2'></div>
					<div class='box_3'></div>
					<div class='box_4'></div>
					<table border='0' cellpadding='0' cellspacing='1' class='bg_style'>
					<tr>
						<th>테이블 설명</th>
						<td colspan='3'>$tableMemo</td>

					</tr>

					<tr>
						<th>테이블생성시간</th>
						<td>$dbData[Create_time]</td>

						<th>열의 수</th>
						<td>$dbData[Rows] 개</td>
					</tr>

					<tr>
						<th>인덱스파일길이</th>
						<td>$dbData[Index_length]</td>

						<th>데이타파일길이</th>
						<td>$dbData[Data_length]</td>
					</tr>

					<tr>
						<th>마지막 업데이트</th>
						<td>$dbData[Update_time]</td>

						<th>Collation</th>
						<td>$dbData[Collation]</td>
					</tr>

					</table>
				</div>

				<div style='width:98%;' id='box_style'>
					<table border='0' cellpadding='0' cellspacing='1' class='bg_style'>
						<tr>
							<th>테이블 스키마</th>
						</tr>
						<tr>
							<td>

								<table width='100%' border='0' cellspacing='1' cellpadding='0' bgcolor='#CCCCCC'>
								<tr>
									<th>Field</th>
									<th>Type</th>
									<th>Null</th>
									<th>Key</th>
									<th>Default</th>
									<th>Extra</th>
								</tr>
		";



		$Sql	= "DESC $sTable";
		$Record	= query($Sql);

		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			echo "
						<tr>
							<td class='valueTBL1'>$Data[Field]</td>
							<td class='valueTBL2'>$Data[Type]</td>
							<td class='valueTBL3'>$Data[Null]</td>
							<td class='valueTBL4'>$Data[Key]</td>
							<td class='valueTBL5'>$Data[Default]</td>
							<td class='valueTBL6'>$Data[Extra]</td>
						</tr>
						<!-- <tr>
							<td colspan='6'><div class='hrNormalDiv'><hr size='0' class='hrNormal'></div></td>
						</tr> -->

			";
		}

		echo "

							</table>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<BR><BR><BR>

		";
	}

include ("tpl_inc/bottom.php");


?>