<?
//***********************************************************************************************************************************/
//	Happy_Initalization
//
//	 Author: Seung-Gwan No
//  Website: http://www.cgimall.co.kr
//	   Date: July 12, 2012
//	License: HappyCGI License (http://www.cgimall.co.kr)
//
//***********************************************************************************************************************************/




$Sql_board	= "SELECT board_name,tbname FROM $board_list ";
$Rec_board	= query($Sql_board);
while($BOARD_LIST	= happy_mysql_fetch_assoc($Rec_board))
{
	$BOARD_NAME_ARRAY[]		= $BOARD_LIST['board_name'];
	$BOARD_TBNAME_ARRAY[]	= $BOARD_LIST['tbname'];
}



$HAPPY_INITIALIZATION_ARRAY =
Array
(
	'회원정보'	=> Array
						(
							'title'		=>	'회원정보제거',
							'explain'	=>	'회원리스트, 회원옵션, 회원탈퇴리스트,쪽지를 초기화 합니다',
							'delete'	=>	Array
												(
													//table, field, contents, thumb
													Array //회원
													(

														'table'		=>	$happy_member,
														'field'		=>	Array
																			(
																				'photo1',
																				'photo2',
																				'photo3'
																			),
														//'contents'	=>	Array(''),
														'thumb'		=>	Array('_thumb','_thumb2','_thumb3')
													),
													Array //회원옵션
													(
														'table'		=>	$happy_member_option
													),
													Array //회원탈퇴
													(
														'table'		=>	$happy_member_out
													),
													Array //회원쪽지
													(
														'table'		=>	$message_tb
													)
												)
						),

	'이력서정보'	=> Array
						(
							'title'		=>	'이력서정보제거',
							'explain'	=>	'이력서,멀티이미지,외국어능력,자격사항,<br>맞춤구인검색,연수,재직 정보를 초기화 합니다',
							'delete'	=>	Array
											(
												Array //이력서
												(
													'table'		=>	$per_document_tb,
													'field'		=>	Array('user_image'),
													'thumb'		=>	Array('_thumb','_thumb2')
													//'contents'	=>	Array(''),
												),

												Array //이력서 멀티이미지업로드
												(
													'table'		=>	$per_file_tb,
													'field'		=>	Array('fileName'),
													'thumb'		=>	Array('_big','_thumb')
												),
												Array //이력서 외국어능력테이블
												(
													'table'		=>	$per_language_tb
												),
												Array //이력서 자격사항
												(
													'table'		=>	$per_skill_tb
												),
												Array //맞춤구인검색
												(
													'table'		=>	$job_per_want_search
												),
												Array //이력서 재직정보
												(
													'table'		=>	$per_worklist_tb
												),
												Array //이력서 연수
												(
													'table'		=>	$per_yunsoo_tb
												),
											)
						),

	'채용정보'=>	Array
						(
							'title'		=>	'채용정보제거',
							'explain'	=>	'채용,이력서신청,입사지원요청,맞춤인재검색 정보를 초기화 합니다',
							'delete'	=>	Array
											(
												Array //채용정보
												(
													'table'		=>	$guin_tb,
													'field'		=>	Array
																			(
																				'img1',
																				'img2',
																				'img3',
																				'img4',
																				'img5'
																			),
													'thumb'		=>	Array('_thumb'),
													'contents'	=>	Array('guin_main')
												),
												Array //채용정보관련
												(
													'table'		=>	$guin_stats_tb
												),
												Array //채용정보에 이력서신청
												(
													'table'		=>	$com_guin_per_tb
												),
												Array //채용정보에 이력서신청 로그
												(
													'table'		=>	$com_guin_per_tb_log
												),
												Array //입사지원요청
												(
													'table'		=>	$com_want_doc_tb
												),
												Array //맞춤인재검색
												(
													'table'		=>	$job_com_want_search
												)
											)

						),

	'유료옵션장부'=>	Array
						(
							'title'		=>	'개인,기업 유료옵션<br>장부 정보제거',
							'explain'	=>	'개인,기업 유료옵션 장부 정보를 초기화 합니다',
							'delete'	=>	Array
											(
												Array
												(
													'table'		=>	$jangboo2
												),
												Array
												(
													'table'		=>	$jangboo
												),
												Array
												(
													'table'		=>	$job_package
												),
												Array
												(
													'table'		=>	$job_jangboo_package
												)
											)
						),

	'통계'=>	Array
						(
							'title'		=>	'통계 정보제거',
							'explain'	=>	'통계 정보를 초기화 합니다',
							'delete'	=>	Array
											(
												Array
												(
													'table'		=>	$stats_tb
												)
											)
						),

	'스크랩'=>	Array
						(
							'title'		=>	'개인,기업회원 스크랩 정보제거',
							'explain'	=>	'개인,기업회원 스크랩 정보를 초기화 합니다',
							'delete'	=>	Array
											(
												Array
												(
													'table'		=>	$scrap_tb
												)
											)
						),


	'자동완성단어'=>	Array
						(
							'title'		=>	'자동완성단어 정보제거',
							'explain'	=>	'자동완성단어 정보를 초기화 합니다',
							'delete'	=>	Array
											(
												Array
												(
													'table'		=>	$auto_search_tb
												)
											)
						),


	/*
	'미니홈'=>	Array
						(
							'title'		=>	'미니홈 정보제거',
							'explain'	=>	'미니홈 정보를 초기화 합니다',
							'delete'	=>	Array
											(
												Array
												(
													'table'		=>	'auction_minihome',
													'field'		=>	Array
																	(
																		'minihome_logo0',
																		'minihome_logo1',
																		'minihome_logo2',
																		'minihome_logo3'
																	),
													'contents'	=>	Array('')
												),

												Array
												(
													'table'		=>	Array("board_short_comment")
												)
											)
						),
	*/

	//게시글명칭수정시 data_initialization() 함수의 "게시글" 명칭도 같이 수정되어야함
	'게시글'=>	Array
						(
							'title'		=>	'게시글 정보제거',
							'explain'	=>	'게시판의 등록된 글,답변,리플을 초기화 합니다',
							'delete'	=>	Array
											(
												Array
												(
													'table'		=>	Array($BOARD_TBNAME_ARRAY),
													'field'		=>	Array
																	(
																		'bbs_etc1',
																		'bbs_attach2',
																		'bbs_attach3'
																	),
													'contents'	=>	Array('bbs_review')
												),

												Array
												(
													'table'		=>	'board_short_comment'
												),

												Array
												(
													'table'		=>	$board_top_gonggi
												)
											)
						),
);

//print_r2($HAPPY_INITIALIZATION_ARRAY);




//자료초기화 설정폼생성
function data_initialization()
{
	global $TPL,$HAPPY_INITIALIZATION_ARRAY,$skin_folder;
	global $INITIALIZATION,$BOARD_NAME_ARRAY,$BOARD_TBNAME_ARRAY;


	$template = "data_initialization_conf_rows.html";
	$random	= rand()%1000;
	if ( !is_file($skin_folder."/".$template) )
	{
		return print"<font color='red'>$skin_folder/$template 파일이 존재하지 않습니다.</font>";
	}
	$TPL->define("자료초기화_$random", $skin_folder."/".$template);



	$INITIALIZATION = Array();
	$content	= "<table align='center' width='100%' border='0' cellspacing='0' cellpadding='0' bgcolor='#FFFFFF'>\n<tbody>\n";
	foreach($HAPPY_INITIALIZATION_ARRAY AS $INIT => $INIT_VAL)
	{
		foreach($INIT_VAL AS $INIT2 => $INIT_VAL2)
		{
			//print_r2($INIT2);echo "<br>";
			if (is_array($INIT_VAL2))
			{
				foreach($INIT_VAL2 AS $INIT3 => $INIT_VAL3)
				{
					//print_r2($INIT3);echo "<br>";
				}
			}
		}


		$INITIALIZATION['main_name']	= $INIT;
		$INITIALIZATION['title']		= $HAPPY_INITIALIZATION_ARRAY[$INIT]['title'];
		$INITIALIZATION['explain']		= $HAPPY_INITIALIZATION_ARRAY[$INIT]['explain'];
		$INIT_DELETE_ARRAY				= $HAPPY_INITIALIZATION_ARRAY[$INIT]['delete'];


		//게시판 리스트 ROWS
		if ($INITIALIZATION['main_name'] == "게시글")
		{
			$template_board = "data_initialization_board_rows.html";
			if ( !is_file($skin_folder."/".$template_board) )
			{
				return print"<font color='red'>$skin_folder/$template_board 파일이 존재하지 않습니다.</font>";
			}
			$TPL->define("게시판리스트_$random", $skin_folder."/".$template_board);

			$INITIALIZATION['board_content']	= "<table align='center' width='100%' border='0' cellspacing='0' cellpadding='0' bgcolor='#e7eaef'>\n<tbody>\n";
			for($bb=0;$bb<sizeof($BOARD_NAME_ARRAY);$bb++)
			{
				$INITIALIZATION['board_name']		= $BOARD_NAME_ARRAY[$bb];
				$INITIALIZATION['tbname']			= $BOARD_TBNAME_ARRAY[$bb];

				$board_tpl	 = &$TPL->fetch("게시판리스트_$random");
				$INITIALIZATION['board_content']	.= "<tr>\n<td>".$board_tpl."</td>\n</tr>";
			}
			$INITIALIZATION['board_content']		.= "</tbody>\n</table>\n";

			$INITIALIZATION['choice_contents']		= $INITIALIZATION['board_content'];
		}
		else
		{
			$INITIALIZATION['choice_contents']		= "
			<input type='radio' name='$INITIALIZATION[main_name]' id='$INITIALIZATION[main_name]_1' value='y'  style='width:13px; height:13px; vertical-align:middle;' onClick=\"document.getElementById('$INITIALIZATION[main_name]_color_1').innerHTML = '<font color=red>예</font>';\" $INITIALIZATION[disabled]><label for='$INITIALIZATION[main_name]_1' style='cursor:pointer' onClick=\"document.getElementById('$INITIALIZATION[main_name]_color_1').innerHTML = '<font color=red>예</font>';\" $INITIALIZATION[disabled]> <span id='$INITIALIZATION[main_name]_color_1'>예</span></label>

			<input type='hidden' name='init_all_y_arr' value='$INITIALIZATION[main_name]'>

			<input type='radio' name='$INITIALIZATION[main_name]' id='$INITIALIZATION[main_name]_2'  style='width:13px; height:13px; vertical-align:middle;'  value='n' onClick=\"document.getElementById('$INITIALIZATION[main_name]_color_1').innerHTML = '<font color=black>예</font>';\" checked $INITIALIZATION[disabled]><label for='$INITIALIZATION[main_name]_2' style='cursor:pointer' onClick=\"document.getElementById('$INITIALIZATION[main_name]_color_1').innerHTML = ' <font color=black>예</font>';\" $INITIALIZATION[disabled]> 아니오 </label>
			";
		}
		//게시판 리스트 ROWS END


		//echo "<br><hr><br>";

		$product	 = &$TPL->fetch("자료초기화_$random");
		$content	.= "<tr>\n<td>".$product."</td>\n</tr>";

		/* 삭제배열
		foreach($INIT_DELETE_ARRAY AS $INIT_DEL => $INIT_DEL_VAL)
		{
			foreach($INIT_DEL_VAL AS $INIT_DEL2 => $INIT_DEL_VAL2)
			{
				//print_r2($INIT_DEL_VAL2);
			}
			//exit;
		}
		*/

	}
	$content	.= "</tbody>\n</table>\n";
	unset($INITIALIZATION,$INIT,$INIT2,$INIT3);

	return $content;

}


?>

