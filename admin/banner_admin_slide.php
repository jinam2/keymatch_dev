<?php
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");


	#관리자 접속 체크 루틴
	if ( !admin_secure("배너관리툴") ) {
		error("접속권한이 없습니다.   ");
		exit;
	}
	#관리자 접속 체크 루틴

	include ("tpl_inc/top_new.php");


	#변수 체크
	$type			= $_GET['type'];
	$number			= preg_replace('/\D/', '',$_GET['number']);


	if ( $type == "" )									# 배너 리스트출력 ################################################
	{
		#검색
		$search_type	= $_GET["search_type"];
		$search_word	= $_GET["search_word"];

		$WHERE		= "";
		if ( $search_word != "" )
		{
			$WHERE	.= " AND $search_type like '%${search_word}%' ";
		}

		if ( $search_type == "title")
		{
			$selected2 = "selected";
		}


		####################### 페이징처리 ########################
		$start			= ( $_GET["start"]=="" )?0:$_GET["start"];
		$scale			= 15;

		$Sql	= "select count(*) from $happy_banner_slide WHERE 1=1 $WHERE ";
		$Temp	= happy_mysql_fetch_array(query($Sql));
		$Total	= $Count	= $Temp[0];

		if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
		$pageScale		= 6;

		$searchMethod	= "";
			#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
				$searchMethod	.= "&search_order=$search_order&keyword=$keyword&group_select=$group_select";
			#검색값 입력완료

		$paging		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		###################### 페이징처리 끝 #######################


		$Sql	= "SELECT * FROM $happy_banner_slide WHERE 1=1 $WHERE ORDER BY number desc LIMIT $start,$scale ";
		$Record	= query($Sql);


		print <<<END


				<script>
					function review_del(no)
					{
						if ( confirm('정말 삭제하시겠습니까?') )
						{
							window.location.href = '?type=del&start=$start&search_order=$search_order&keyword=$keyword&number='+no;
						}
					}
					</script>

					<script language='javascript'>
					function OpenWindow(url,intWidth,intHeight) {
					window.open(url, '_blank', 'width='+intWidth+',height='+intHeight+',resizable=1,scrollbars=1');
					}
				</script>

				<div class='main_title'>$now_location_subtitle
					<span class='small_btn'>
						<a href="banner_admin_slide.php?type=add" class='btn_small_blue'>+배너추가</a> <a href="happy_config_view.php?number=54" class='btn_small_navy'>배너설정</a>
					</span>
				</div>

				<div style='background:#f9f9f9; border:1px solid #dfdfdf; padding:10px; margin-bottom:10px;' class='input_style_adm'>
					<form name='search_frm' action='banner_admin_slide.php' style='margin:0;'>
						<select name='search_type'>
						<option value='title' $selected2>배너명</option>
					</select>
					<input type='text' name='search_word' value='$_GET[search_word]' id=search_word class="input_type1" style='vertical-align:middle'>
					<input type='submit' value='검색하기' id=search_btn class='btn_small_dark' style='height:29px'>

					</form>
				</div>

				<div class='help_style'>
					<div class='box_1'></div>
					<div class='box_2'></div>
					<div class='box_3'></div>
					<div class='box_4'></div>
					<span class='help'>도움말</span>
					<p>
					현재 메인화면 상단에서 확인하실 수 있습니다.<br>
					출력태그는 < iframe name="big_banner_iframe" src="slide_big_banner.php" style="width:990px; height:260px; background-color:#000;" frameborder="0"></iframe > 입니다.<br>
					상세설정은 <a href="happy_config_view.php?number=49">이곳</a>을 클릭하세요.
					</p>
				</div>

				<div id='list_style'>
					<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
					<tr>
						<th style='width:50px;'>번호</th>
						<th>이미지</th>
						<th style='width:200px;'>배너제목</th>
						<th style='width:60px;'>소팅</th>
						<th>배너마감일</th>
						<th style='width:100px;'>관리자툴</th>
					</tr>

END;




		$Count2 = 0;
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			//$rows_color 는 top.php 에서 설정 [ YOON : 2010-03-23 ]
			$bgcolor	= ( $Count2%2 == 0 )?"white":$rows_color;

			$nowDate			= date("Y-m-d");
			$regdate			= substr($Data['regdate'],0,10);
			$editdate			= substr($Data['editdate'],0,10);
			$enddate			= substr($Data['enddate'],0,10);

			$regdate			= $nowDate == $regdate  ? substr($Data['regdate'],10,9)  : $regdate;
			$editdate			= $nowDate == $editdate ? substr($Data['editdate'],10,9) : $editdate;

			$Data['title']		= $Data['title'] == "" ? "등록된 제목이 없습니다.":$Data['title'];
			$preview_banner		= "<img src='".$wys_url."/$Data[img]' height='135'>";


			echo "
				<tr>
					<td style='text-align:center;'>$listNo</td>
					<td style='max-width:500px; overflow:hidden; text-align:center;'>$preview_banner</td>
					<td style='text-align:center;' class='bg_green'>$Data[title]</td>
					<td style='text-align:center;'>$Data[sort]</td>
					<td style='text-align:center;'>$enddate</td>
					<td style='text-align:center;'>
						<a href='?type=add&number=$Data[number]&start=$start&search_order=$search_order&keyword=$keyword' class='btn_small_dark3'>수정</a> <a href='#delete' onClick=\"review_del('$Data[number]')\" class='btn_small_red2' style='margin-top:3px'>삭제</a></td>
				</tr>
			";
			$Count2++;
			$listNo--;

		}


		echo "
				</table>
			</div>
			<div align='center' style='padding:20px 0 30px 0;'>$paging</div>
			<div align='center'><a href='banner_admin_slide.php?type=add' class='btn_big'>등록하기</a></div>
			</form>
		";


	}
	else if ( $type == "add" )							# 배너 작성하기 ##################################################
	{

		if ( $number != '' )		## 수정모드일때 ##
		{
			$Sql	= "SELECT * FROM $happy_banner_slide WHERE number='$number' ";
			$Data	= happy_mysql_fetch_array(query($Sql));

			$Data['title']		= addslashes($Data['title']);
			$preview_banner		= "<img src='".$wys_url."/$Data[img]' height='135'>";

			$button_title		= '수정';

			$startdate = $Data['startdate'];
			$enddate = $Data['enddate'];

			$display_y = "";
			$display_n = "";

			if ( $Data['display'] == 'Y' )
			{
				$display_y = " checked ";
			}
			else
			{
				$display_n = " checked ";
			}


		}
		else						## 새로작성할때 ##
		{
			$button_title		= '등록';
			$display_y = " checked ";

			#등록시 최대값
			$sql2= "select MAX(number) as number from $happy_banner_slide";
			$result2 = query($sql2);
			$B_NUM = happy_mysql_fetch_assoc($result2);
			#등록시에는 +1
			$Data["number"] = $B_NUM["number"] + 1;
		}


		#폼출력
		echo "

			<script>
				function check_Valid()
				{
					Form = document.banner_frm;
					if(Form.title.value == '')
					{
						alert('배너제목을 입력해주세요');
						Form.title.focus();
						return false;
					}

					return true;
				}



				function ck_string(target,string_type)
				{
					var t_value = target.value;

					if (t_value != '')
					{
						switch (string_type)
						{
							case 'number':
															//match_regular	= /[0-9.]/g;
															match_regular	= /[0-9]+$/;
															match_string	= '숫자만 가능합니다 ';
															break;
							case 'alphabet_number':
															match_regular	= /[a-zA-Z0-9]+$/;
															match_string	= '영문이나 숫자만 가능합니다 ';
															break;
						}

						//alert(t_value.test(match_regular));
						//alert(match_regular.test(t_value)+':'+string_type+':'+t_value);
						//if (!t_value.test(match_regular))
						if (t_value.match(match_regular) == null)
						{
							alert(match_string);
							target.value = '';
							return false;
						}
					}

					return true;
				}
			</script>


			<!-- 달력에 필요한프레임 -->
			<iframe width=188 height=166 name=\"gToday:datetime:agenda.js:gfPop:plugins_time.js\" id=\"gToday:datetime:agenda.js:gfPop:plugins_time.js\" src=\"../js/time_calrendar/ipopeng.htm\" scrolling=\"no\" frameborder=\"0\" style=\"visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;\">
			</iframe>

			<p class='main_title'>$now_location_subtitle</p>

			<!-- 배너정보 추가 [ start ] -->
			<form name='banner_frm' action='?type=reg' method='post' enctype='multipart/form-data' onSubmit='return check_Valid()'>
			<input type='hidden' name='number' value='$number'>
			<div id='box_style'>
				<div class='box_1'></div>
				<div class='box_2'></div>
				<div class='box_3'></div>
				<div class='box_4'></div>
				<table cellspacing='1' cellpadding='0' class='bg_style box_height'>
				<tr>
					<th>배너제목</th>
					<td><input type='text' name='title' value='$Data[title]'></td>
				</tr>
				<tr>
					<th>이미지 파일선택</th>
					<td>
						<input type='file' name='img' size=40>
						<p style='padding-top:10px;'>$preview_banner <img src='img/blank_banner.gif' align='absmiddle' id='preview_banner_help'></p>
					</td>
				</tr>
				<tr>
					<th>배너링크</th>
					<td><input type='text' name='link' value='$Data[link]'></td>
				</tr>
				<tr>
					<th>시작시간</th>
					<td>
						<p class='short'>시작일시을 설정해주세요</p>
						<input type='text' name='startdate' value='$startdate' style=\"width:140;\"> <a href=\"javascript:void(0)\" onclick=\"if(self.gfPop)gfPop.fPopCalendar(document.banner_frm.startdate);return false;\" ><img name=\"popcal\" align=\"absmiddle\" src=\"img/sms/calbtn2.gif\" width=\"34\" height=\"22\" border=\"0\" alt=\"\"></a>
					</td>
				</tr>
				<tr>
					<th>마감시간</th>
					<td>
						<p class='short'>마감일시을 설정해주세요</p>
						<input type='text' name='enddate' value='$enddate' style=\"width:140;\"> <a href=\"javascript:void(0)\" onclick=\"if(self.gfPop)gfPop.fPopCalendar(document.banner_frm.enddate);return false;\" ><img name=\"popcal\" align=\"absmiddle\" src=\"img/sms/calbtn2.gif\" width=\"34\" height=\"22\" border=\"0\" alt=\"\"></a>
					</td>
				</tr>
				<tr>
					<th>정렬순서(Sort)</th>
					<td>
						<p class='short'>
							<b>정렬순서(Sort) 란?</b><br>
							설정하신 숫자가 높을수록 슬라이드 배너이미지가 먼저 나오게 되며 기입하지 않을 경우 '0' 으로 설정됩니다<br>
							정렬순서는 숫자로 기입해주셔야 합니다
						</p>
						<input type='text' name='sort' value='$Data[sort]' style='width:70px;' onkeyUp=\"ck_string(this,'number')\">
					</td>
				</tr>
				<tr>
					<th>출력여부</th>
					<td>
						<input type='radio' name='display' value='Y' $display_y class=input_chk style='width:13px; height:13px; vertical-align:middle;'> 출력함
						<input type='radio' name='display' value='N' $display_n class=input_chk style='width:13px; height:13px; vertical-align:middle;'> 출력안함
					</td>
				</tr>
				</table>
			</div>
			<div align='center' style='padding:20px 0 20px 0;'>
				<input type='submit' value='저장하기' class='btn_big'>
					<A HREF=\"banner_admin_slide.php\" class='btn_big_gray'>목록으로</A>
			</div>
			</form>

		";



	}
	else if ( $type == "reg" )
	{
		#넘어온 변수값 정리
		$title		= $_POST['title'];
		$link		= $_POST['link'];
		$startdate	= $_POST['startdate'];
		$enddate	= $_POST['enddate'];
		$sort		= $_POST['sort'];
		$display	= $_POST['display'];
		$number		= preg_replace('/\D/', '',$_POST['number']);


		#첨부된 파일
		$img_name		= 'img';
		$upImageName	= $_FILES[$img_name]["name"];
		$upImageTemp	= $_FILES[$img_name]["tmp_name"];
		$now_time		= happy_mktime();

		$rand_number	= rand(1,999999);
		$rand_number2	= rand(1,999999);
		$temp_name		= explode(".",$upImageName);
		$ext			= strtolower($temp_name[sizeof($temp_name)-1]);

		if ( $ext=="html" || $ext=="htm" || $ext=="php" || $ext=="cgi" || $ext=="inc" || $ext=="php3" || $ext=="pl" )
		{
			error("등록이 불가능한 확장자 입니다.");
			exit;
		}

		$pngClass		= $ext == "png" ? "png":"";

		$imgFileName	= $pngClass.md5("${rand_number2}${now_time}${rand_number}");
		$img_url_re		= "$banner_folder_admin_slide/".$imgFileName;
		$img			= "$banner_folder_slide/".$imgFileName;

		if ($upImageTemp != "")
		{
			if ( copy($upImageTemp,"$img_url_re") )
			{
				$fileSql	= " img = '$img', ";
				unlink($upImageTemp);
				chmod($img_url_re,0777);

			}
		}

		if ( $banner_auto_addslashe == '' )
		{
			$title		= addslashes($_POST["title"]);
		}


		#쿼리문 생성
		$SetSql		= "
						title		= '$title',
						$fileSql
						link		= '$link',
						editdate	= now(),
						startdate	= '$startdate',
						enddate		= '$enddate',
						sort		= '$sort',
						display		= '$display'
		";

		if ( $number == '' )
		{
			$Sql	= "
						INSERT INTO
								$happy_banner_slide
						SET
								$SetSql ,
								regdate		= now()
			";
			$okMsg	= "등록되었습니다.";
		}
		else
		{
			$Sql	= "UPDATE $happy_banner_slide SET $SetSql WHERE number = '$number'";
			$okMsg	= "수정되었습니다.";
		}

		#echo nl2br($Sql);exit;
		query($Sql);

		gomsg($okMsg, "?");


	}
	else if ( $type == "del" )							#배너 삭제하기 ##################################################
	{
		$number	= preg_replace("/\D/","",$number);

		$Sql	= "DELETE FROM $happy_banner_slide WHERE number='$number' ";
		query($Sql);

		gomsg("삭제되었습니다.","?");
	}



	include ("tpl_inc/bottom.php");
?>