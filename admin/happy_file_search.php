<?php

	ini_set('memory_limit', -1);
	set_time_limit(0);

	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/Template.php");
	$TPL = new Template();
	include ("../inc/lib.php");


	if ( !admin_secure("슈퍼관리자전용") ) {
			error("접속권한이 없습니다.");
			exit;
	}


	################################################

	# 검색 허용할 경로(폴더명) - 홈 디렉토리 기준으로 입력
	$SEARCH_FOLDER_LIST		= Array(
									"temp",
									"html_bbs",
									"html_file",
									"js",
									"css",
									"mobile_html",
									"m/js",
									"m/css",
									"admin/temp",
									"admin/html",
									"admin/css",
									"admin/js"
	);

	# 검색 허용할 확장자명
	$SEARCH_ALLOW_EXT		= Array('html','js','css');
	$SEARCH_ALLOW_EXT_TEXT	= implode(", ",$SEARCH_ALLOW_EXT);

	# file_get_contents 옵션
	$phpver					= phpversion();
	$phpver					= $phpver[0];
	$FILE_GET_OPTION		= ( $phpver < 5 ) ? 'FILE_USE_INCLUDE_PATH' : true;

	################################################

	$mode					= $_GET['mode'];
	$search_word			= $_GET['search_word'];
	$search_folder			= $_GET['search_folder'];
	$search_file_path		= $_GET['search_file_path'];

	if ( $mode != "source" )
	{
		//관리자메뉴 [ YOON :2009-10-07 ]
		################################################
		//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
		include ("tpl_inc/top_new.php");
		################################################
	}

	$SEARCH_FILE_LIST		= Array();
	$SEARCH_FILE_LIST_HTML	= "<img src='img/happy_file_search/happy_file_search_guide.jpg' alt='안내이미지' title='안내이미지'>";

	$SEARCH_PATH_LIST		= Array();
	$SEARCH_PATH_LIST_HTML	= "";

	$SEARCH_FILE_COUNT		= 0;

	if ( $mode == "source" )
	{
		if ( $search_word == "" || $search_file_path == "" )
		{
			msgclose("잘못된 접근입니다.");
			exit;
		}

		$file_path_cut		= explode("/",$search_file_path);
		$file_name			= $file_path_cut[count($file_path_cut)-1];
		unset($file_path_cut[count($file_path_cut)-1]);

		$file_name_cut		= explode(".",$file_name);
		$file_ext			= $file_name_cut[count($file_name_cut)-1];
		$file_ext			= strtolower($file_ext);

		$is_search_ok		= false;

		foreach ( $SEARCH_FOLDER_LIST as $now_folder )
		{
			$now_folder_cut		= explode("/",$now_folder);
			$now_folder_check	= 0;

			for ( $i = 0 ; $i < count($now_folder_cut) ; $i++ )
			{
				if ( $file_path_cut[$i] == $now_folder_cut[$i] )
				{
					$now_folder_check++;
				}
			}

			if ( count($now_folder_cut) == $now_folder_check )
			{
				$is_search_ok		= true;
			}
		}

		if ( !$is_search_ok || !in_array($file_ext,$SEARCH_ALLOW_EXT) )
		{
			msgclose("소스보기가 허용되지 않은 파일입니다.");
			exit;
		}

		$file_path_real		= "../".$search_file_path;

		if ( !file_exists($file_path_real) )
		{
			msgclose("{$search_file_path} 파일이 존재하지 않습니다.");
			exit;
		}

		$file_source		= file_get_contents($file_path_real, $FILE_GET_OPTION);

		$file_source		= str_replace($search_word,"__마킹시작__".$search_word."__마킹끝__",$file_source);
		$file_source		= htmlspecialchars($file_source);
		$file_source		= str_replace("__마킹시작__","<span style='background-color:#FFF000'>",$file_source);
		$file_source		= str_replace("__마킹끝__","</span>",$file_source);

		$search_word_val	= htmlspecialchars($search_word);

		echo <<<END
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<TITLE>파일 소스보기 - $search_file_path</TITLE>

<link rel=stylesheet style="text/css" href="css/style.css">
</head>
<body style="background:#fafafa; padding:20px;">

	<div>
		<div style="color:#333333; float:left; font-size:20px; font-family: '맑은 고딕', MalgunGothic, AppleGothic, '돋움', Dotum, '굴림', Gulim; letter-spacong:-1px;"><strong>파일소스보기</strong></div>
		<div style="color:#333333; float:right; font-size:16px; font-family: '맑은 고딕', MalgunGothic, AppleGothic, '돋움', Dotum, '굴림', Gulim;"><span style="background:url('img/happy_file_search/happy_file_search_icon_03.png') no-repeat 0px 5px; letter-spacing:-1px; padding-left:20px;">검색어</span> : <span style="color:#d13b3b;">$search_word_val</span></div>
		<div style="clear:both;"></div>
	</div>

	<div style="border:1px solid #f0d8d8; padding:15px; color:#333333; font-size:16px; font-family: '맑은 고딕', MalgunGothic, AppleGothic, '돋움', Dotum, '굴림', Gulim; margin-top:15px; background:#faebeb;">
		<span style="leftter-spacing:-1px; background:url('img/happy_file_search/happy_file_search_icon_04.gif') no-repeat 0px 5px; padding-left:20px;">현재파일</span> : <span style='color:#d13b3b'>$search_file_path</span>
	</div>

	<div style="height:530px; overflow-y:scroll; white-space:pre-wrap; border:1px solid #e9e9e9; border-top:none; background:#ffffff; padding:30px 0px 30px 30px;">$file_source</div>

	<div style="text-align:center; margin-top:30px;"><a href='javascript:window.close();' class="btn_big">확인</a></div>

</body>
</html>
END;
		exit;
	}
	else if ( $mode == "search" )
	{
		if ( trim($search_word) == "" )
		{
			error("검색어를 입력하세요.");
			exit;
		}

		foreach ( $SEARCH_FOLDER_LIST as $now_folder )
		{
			$now_search_path		= "../".$now_folder;

			if ( $now_folder == "" || !is_dir($now_search_path) )
			{
				continue;
			}

			_HAPPY_FILE_SEARCH_($now_search_path);
		}

		sort($SEARCH_FILE_LIST);
		ksort($SEARCH_PATH_LIST);

		$SEARCH_FILE_COUNT		= count($SEARCH_FILE_LIST);

		$search_word_encode		= urlencode($search_word);
		$search_folder_encode	= urlencode($search_folder);

		//폴더별 카운트 START
		if ( $SEARCH_FILE_COUNT > 0 )
		{
			$all_title_text		= "전체 ($SEARCH_FILE_COUNT)";

			if ( $search_folder == "" )
			{
				$all_title_text		= "<span style='color:#d13b3b;'>$all_title_text</span>";
			}

			$SEARCH_PATH_LIST_HTML	= "
			<div>
				<div class='happy_serch_sub_title_01'>
					폴더별 검색된 파일 개수
					<div style='position:absolute; top:0; right:0; font-size:11px; color:#9d9d9d; font-weight:normal;'>폴더를 클릭하시면 해당 폴더의 파일만 확인할 수 있습니다.</div>
				</div>
				<table cellspacing='1' cellpadding='0' border='0' style='width:100%;' class='search_path_tb'>
				<tr>
					<td><a href='?mode=search&search_word=$search_word_encode'>$all_title_text</a></td>
			";

			$WidthCount				= 4; //가로 최대 출력개수
			$Count					= 1;

			foreach ( $SEARCH_PATH_LIST as $file_folder => $file_count )
			{
				$Count++;

				$file_path_real_encode	= urlencode($file_folder);
				$file_folder_text		= "$file_folder ($file_count)";

				if ( $search_folder != "" && $search_folder == $file_folder )
				{
					$file_folder_text		= "<span style='color:#d13b3b;'>$file_folder_text</span>";
				}

				$SEARCH_PATH_LIST_HTML	.= "
				<td>
					<a href='?mode=search&search_word=$search_word_encode&search_folder=$file_path_real_encode'>$file_folder_text</a>
				</td>
				";

				if ( $Count % $WidthCount == 0 )
				{
					$SEARCH_PATH_LIST_HTML	.= "</tr><tr>";
				}
			}

			if ( count($SEARCH_PATH_LIST)+1 > $WidthCount && $Count % $WidthCount != 0 )
			{
				$ROOP	= 0;

				while ( 1 )
				{
					$Count++;

					$SEARCH_PATH_LIST_HTML	.= "<td>&nbsp;</td>";

					if ( $Count % $WidthCount == 0 || $ROOP > 100 )
					{
						break;
					}

					$ROOP++;
				}
			}

			$SEARCH_PATH_LIST_HTML	.= "
				</tr>
				</table>
			</div>
			";
		}
		//폴더별 카운트 START

		//파일 목록 START
		$ListNo					= $SEARCH_FILE_COUNT;

		if ( $search_folder != "" )
		{
			$ListNo					= $SEARCH_PATH_LIST[$search_folder];
		}

		$ListNoOrg				= $ListNo;

		$SEARCH_FILE_LIST_ROWS	= "";

		foreach ( $SEARCH_FILE_LIST as $file_path_org )
		{
			$file_path_real_cut		= explode("/",$file_path_org);
			unset($file_path_real_cut[count($file_path_real_cut)-1]);
			$file_path_folder		= implode("/",$file_path_real_cut);

			if ( $search_folder != "" && $search_folder != $file_path_folder )
			{
				continue;
			}

			$SEARCH_FILE_LIST_ROWS	.= "
			<tr height='50' onMouseOver=\"this.style.backgroundColor='#F4F4F4'\" onMouseOut=\"this.style.backgroundColor=''\"  >
				<td align='center' style='font-size:12px;'>$ListNo</td>
				<td style='font-size:14px; padding-left:15px;'>$file_path_org</td>
				<td align='center' style='width:100px;'><a href='javascript:void(0);' onClick=\"happy_file_view('$file_path_org');\" class='btn_small_blue' style='width:66px; display:block !important;'>보기</a></td>
			</tr>
			";

			$ListNo--;
		}
		//파일 목록 END

		$SEARCH_FILE_LIST_HTML	= "

		<div class='happy_serch_sub_title_02'>검색된 파일개수 : <span style='color:#c22828;'>{$ListNoOrg}</span> 개</div>

		<div id='list_style'>
		<table cellspacing='0' cellpadding='0' border='0' class='bg_style table_line'>
		<tr>
			<th align='center' height='30'>번호</th>
			<th align='center'>경로/파일명</th>
			<th align='center'>소스보기</th>
		</tr>
		";

		if ( $SEARCH_FILE_COUNT == 0 )
		{
			$SEARCH_FILE_LIST_HTML	.= "<tr><td style='padding:25px 0px;' align='center' colspan='3'><img s src='img/happy_file_search/happy_file_search_no.gif'></td></tr>";
		}
		else
		{
			$SEARCH_FILE_LIST_HTML	.= $SEARCH_FILE_LIST_ROWS;
		}

		$SEARCH_FILE_LIST_HTML	.= "</table></div>";


		$search_word_val		= $search_word;
		$search_word_val		= stripslashes($search_word_val);
		$search_word_val		= str_replace('"',"&quot;",$search_word_val);

	}


	echo <<<END

	<script type="text/javascript">
	<!--
		function happy_file_view(file_path)
		{
			var search_word			= document.forms['searchform'].search_word.value;

			if ( !file_path )
			{
				alert("불러올 파일명이 없습니다.");
				return;
			}

			if ( !search_word )
			{
				alert("검색어를 입력하세요.");
				return;
			}

			var url		= "?mode=source&search_file_path=" + encodeURIComponent(file_path) + "&search_word=" + encodeURIComponent(search_word);
			var popup	= window.open(url,"happy_file_view","width=1000,height=800,resizable=yes");
			popup.focus();
		}
	//-->
	</script>

	<STYLE type="text/css">
		/* 서브타이틀 폴더별 검색된 파일 개수*/
		.happy_serch_sub_title_01 {
		line-height:14px;
		background:url('img/happy_file_search/happy_file_search_icon_01.gif') no-repeat;
		padding-left:22px;
		font-weight:bold;
		font-size:14px;
		letter-spacing:-1px;
		margin-top:30px;
		margin-bottom:10px;
		position:relative;
		}
		/* 서브타이틀 검색된 파일 개수*/
		.happy_serch_sub_title_02 {
		line-height:16px;
		background:url('img/happy_file_search/happy_file_search_icon_02.gif') no-repeat;
		padding-left:22px;
		font-weight:bold;
		font-size:14px;
		letter-spacing:-1px;
		margin-top:30px;
		margin-bottom:10px;
		position:relative;
		}

		/* 경로검색 */
		.search_path_tb { background:#f6e3e3; table-layout:fixed;}
		.search_path_tb td { background:#fef9f9; height:50px; padding-left:20px; }
		.search_path_tb a { color:#333333; }
	</STYLE>


	<div class='main_title'>템플릿파일 문자열 검색</div>

	<div class='help_style' style="padding-bottom:15px;">
		<div class='box_1'></div>
		<div class='box_2'></div>
		<div class='box_3'></div>
		<div class='box_4'></div>
		<span class='help'>도움말</span>

		<div>
			<div style='float:left; line-height:18px;' class='font-s'>
				지정된 경로 안에 있는 <span style="color:#469fcb; letter-spacing:0px;">{$SEARCH_ALLOW_EXT_TEXT}</span> 파일 중 해당 단어를 포함한 파일을 검색합니다.<BR>
				검색된 파일 목록에서 <span style="color:#469fcb;">보기</span> 버튼을 클릭하시면 소스 확인이 가능합니다.
			</div>

			<div style='float:right;'>
				<strong style="color:#333333;">단어검색</strong>
				<!-- 문자열 검색 폼 -->
				<form name='searchform' style="display:inline-block; margin-left:5px;">
					<input type='hidden' name="mode" value="search">
					<input type="text" name="search_word" value="$search_word_val" style="width:340px; height:30px; background:#f4f4f4; border:1px solid #dbdbdb; padding-left:10px;">
					<input type="submit" value="검색" class="btn_small_dark" style="vertical-align:middle;">
				</form>
				<!-- 문자열 검색 폼 -->
			</div>
			<div style='clear:both'></div>
		</div>
	</div>


	$SEARCH_PATH_LIST_HTML
	$SEARCH_FILE_LIST_HTML

END;



	# YOON : 2009-10-29 ###
	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################




	function _HAPPY_FILE_SEARCH_($dir)
	{
		global $SEARCH_ALLOW_EXT, $SEARCH_FILE_LIST, $FILE_GET_OPTION, $search_word;
		global $SEARCH_PATH_LIST;

		$find_word		= $search_word;
		$find_word		= stripslashes($find_word);
		$find_word		= str_replace("&quot;",'"',$find_word);

		$fp				= opendir($dir);

		while( ( $entry = readdir($fp) ) !== false )
		{
			if ( $entry != "." && $entry != ".." && $entry != ".htaccess" )
			{
				if ( is_dir($dir."/".$entry) )
				{
					clearstatcache();
					_HAPPY_FILE_SEARCH_($dir."/".$entry);
				}
				else if ( is_file($dir."/".$entry) )
				{
					$entry_cut		= explode(".",$entry);
					$entry_ext		= $entry_cut[count($entry_cut)-1];
					$entry_ext		= strtolower($entry_ext);

					if ( in_array($entry_ext,$SEARCH_ALLOW_EXT) )
					{
						$file_path		= $dir."/".$entry;

						$file_source	= file_get_contents($file_path, $FILE_GET_OPTION);

						if ( strpos($file_source,$find_word) !== false )
						{
							$file_path_val	= str_replace("../","",$file_path);
							$dir_val		= str_replace("../","",$dir);

							array_push($SEARCH_FILE_LIST,$file_path_val);

							if ( $SEARCH_PATH_LIST[$dir_val] == "" )
							{
								$SEARCH_PATH_LIST[$dir_val] = 0;
							}

							$SEARCH_PATH_LIST[$dir_val]++;
						}

						clearstatcache();
					}
				}
			}
		}
		closedir($fp);
	}

?>