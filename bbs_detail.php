<?php

	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$master_check_original	= $master_check;


	$sql1 = "select * from $board_list where tbname = '$tb'";
	$result1 = query($sql1);
	$B_CONF = happy_mysql_fetch_array($result1);
	//실제 테이블이 있는가?
	$result3 = happy_mysql_list_tables("$db_name");
	while( list($ex_table) = mysql_fetch_row($result3) )
	{
		if ($ex_table == "$B_CONF[tbname]" )
		{
			$check_board = "1";
		}
	}

	if ($check_board != "1")
	{
		error("해당 테이블이 존재하지 않습니다");
		exit;
	}



	#show columns 시키자. 업그레이드시킴
	$sql = "show columns from $tb";
	$result = query ($sql);
	while ($COL = happy_mysql_fetch_array($result))
	{
		if ($COL[Field] == 'bbs_id' )
		{
			$new_board = '1';
		}
	}

	if (!$new_board && $tb)
	{
		$sql = "ALTER TABLE $tb

		  ADD `phone` varchar(150) NOT NULL default '',
		  ADD `hphone` varchar(150) NOT NULL default '',
		  ADD `address` text NOT NULL,
		  ADD `zip` varchar(10) NOT NULL default '',
		  ADD `select1` int(10) NOT NULL default '0',
		  ADD `select2` int(10) NOT NULL default '0',
		  ADD `select3` varchar(100) NOT NULL default '',
		  ADD `radio1` varchar(100) NOT NULL default '',
		  ADD `radio2` varchar(100) NOT NULL default '',
		  ADD `radio3` varchar(100) NOT NULL default '',
		  ADD `text1` text NOT NULL,
		  ADD `text2` text NOT NULL,
		  ADD `text3` text NOT NULL,
		  ADD `gou_number` varchar(50) NOT NULL default '',
		  ADD `delivery` int(1) NOT NULL default '0',
		  ADD `money_in` int(1) NOT NULL default '0',
		  ADD `total_price` int(100) NOT NULL default '0',
		  ADD `b_category` varchar(150) NOT NULL default '',
		  ADD `reply_stats` int(1) NOT NULL default '0',
		  ADD `write_ip` varchar(100) NOT NULL default '',
		  ADD `org_writer` varchar(100) NOT NULL default '',
		  ADD `view_lock` int(1) NOT NULL default '0',
		  ADD `notice` int(1) NOT NULL default '0',
		  ADD `bbs_id` varchar(200) NOT NULL default '' ,
		  ADD KEY `select1` (`select1`),
		  ADD KEY `select2` (`select2`),
		  ADD KEY `org_writer` (`org_writer`),
		  ADD KEY `gou_number` (`gou_number`),
		  ADD KEY `bbs_id` (`bbs_id`),
		  ADD KEY `notice` (`notice`)

		";
		$result = query ($sql);
	}


	if( !(is_file("$skin_folder_bbs/$B_CONF[board_temp_detail]")) )
	{
		print "리스트페이지 $skin_folder_bbs/$B_CONF[board_temp_detail] 파일이 존재하지 않습니다. <br>";
		return;
	}



	#읽을수 있는 회원인가? 5/관리자 , 2/기업 , 1/회원
	if ($B_CONF[board_read] == '5')
	{
		$msg_title = '관리자';
	}
	elseif ($B_CONF[board_read] == '2')
	{
		$msg_title = '기업회원';
	}
	elseif ($B_CONF[board_read] == '1')
	{
		$msg_title = '개인회원';
	}
	else
	{
		$msg_title = '전체회원';
	}



	########################################################################
	# 게시판읽기
	########################################################################

	$bbs_num = preg_replace("/\D/","",$bbs_num);
	$pg = preg_replace("/\D/","",$pg);

	$sql2 = "update $tb set bbs_count= bbs_count + 1 where number='$bbs_num'";
	$result2 = query($sql2);

	$sql = "select * from $tb where number='$bbs_num'";
	$result = query($sql);
	$BOARD = happy_mysql_fetch_array($result);

	if (!admin_secure("게시판관리") )
	{
		if ( !happy_member_secure('%게시판%'.$tb.'-view') )
		{
			if ( $happy_member_login_value == $BOARD['bbs_id'] && $BOARD['bbs_id'] != '' )
			{
				// 자기가 작성한 글은 보게하자
			}
			else if ( $happy_member_login_value == "" )
			{
				$returnUrl = urlencode($_SERVER['REQUEST_URI']);
				//gomsg("로그인이 필요한 페이지입니다.","happy_member_login.php?returnUrl=$returnUrl");
				go("happy_member_login.php?returnUrl=$returnUrl");
				exit;
			}
			else
			{
				error ("접속 권한이 없습니다.");
				exit;
			}
		}
	}

	//게시글이 없을때 메인페이지로
	//포털검색등에서 접근할때는 이전페이지가 없어서 메인페이지로 보냄
	if ( $BOARD['number'] == "" )
	{
		msg("등록된 게시글이 없습니다.");
		go($main_url);
		exit;
	}
	//게시글이 없을때 메인페이지로
	//포털검색등에서 접근할때는 이전페이지가 없어서 메인페이지로 보냄

	//뉴스상점 START
	if ( $BOARD['news_gongu'] == "1" )
	{
		//게시판TB명/원본사이트고유번호_받은사이트고유번호/bbs_게시글고유번호.html
		$contents_file_name = "upload/news_data/bbs_contents/".$tb."/".$BOARD['sharing_site']."_".$BOARD['shared_site']."/bbs_".$BOARD['number'].".html";

		if ( file_exists($contents_file_name) )
		{
			$BOARD['bbs_review'] = file_get_contents($contents_file_name);
		}
		else
		{
			error("잘못된 접근입니다.");
			exit;
		}
	}
	//뉴스상점 END

	$site_name = $BOARD['bbs_title']." - ".$site_name;


	#게시판의 list를 읽자
	$게시판상단 = $B_CONF[up];
	$게시판하단 = $B_CONF[down];

	if (!($BOARD[bbs_etc4]))
	{
		$BOARD[bbs_etc4] = "0";
	}

	#이메일이 있으면 이름에 자동으로 링크를 걸자
	if (eregi("@",$BOARD[bbs_email]))
	{
		$BOARD[bbs_name] = "<a href=mailto:$BOARD[bbs_email]><img src='bbs_img/e_mail2.gif' align='absmiddle' border='0'> <font color=#676767>$BOARD[bbs_name]</a>";
	}

	//에디터 네이버지도 모바일 크기 조절 - ranksa
	$BOARD['bbs_review']	= mobile_naver_map_replace($BOARD['bbs_review']);


	//2011-05-11 HYO start 트위터, 페이스북, 미투데이 추가
$twitter						= array();
$twitter["text"]				= preg_replace("#<script(.*?)>(.*?)</script>#is", "", $BOARD["bbs_review"]);
$twitter['text']				= kstrcut(strip_tags($twitter["text"]), 100, '...');
$twitter['text']				= str_replace("'","",$twitter['text']);		//트위터로 보내기... IE에서의 교차스크립트 방지의 원인이므로 .. 제거

if ($server_character == 'euckr')
{
	$twitter['text']				= iconv("euc-kr" , "UTF-8",$twitter['text']);
}

$twitter['text']				= urlencode($twitter['text']);
$twitter['original_referer']	= urlencode("http://".$_SERVER['HTTP_HOST']."$_SERVER[REQUEST_URI]");
$twitter['url']					= "http://".$_SERVER['HTTP_HOST'].urlencode($_SERVER[REQUEST_URI]);
$twitter['return_to']			= "/intent/tweet?original_referer=$twitter[original_referer]&text=$twitter[text]&tw_p=tweetbutton&url=$twitter[url]";

$tweeter_url					= "https://twitter.com/intent/tweet";
$tweeter_url					.= "?original_referer=".$twitter['original_referer'];
$tweeter_url					.= "&return_to=".$twitter['return_to'];
$tweeter_url					.= "&text=".$twitter['text'];
$tweeter_url					.= "&url=".$twitter['url'];
$tweeter_url					= "<a href='$tweeter_url' target='_blank' onfocus='blur();'><img src='img/sns_icon/icon_twitter.png' align='absmiddle' border='0' alt='트위터로 보내기'  class='png24'></a>";
##################### tweeter 를 위한 API : 2010.11.1 NeoHero ####################


#facebook 를 위한 API : 2010.11.1 NeoHero
$facebook_p_url	= urlencode("$main_url/facebook_scrap.php?tb=$tb&bbs_num=$_GET[bbs_num]");
$facebook_url	= "<a href='javascript:void(0);'><img src='img/sns_icon/icon_facebook.png' align='absmiddle' style='cursor:pointer; ' onclick=\"window.open('https://www.facebook.com/sharer/sharer.php?sdk=joey&u=$facebook_p_url','facebook_scrap','width=640,height=460');\" /></a>";
#facebook 를 위한 API : 2010.11.1 NeoHero

		$site_name2 = $BOARD['bbs_title']." - ".$site_name;

		// 네이버 밴드 공유 하기 - x2chi 2015-01-28 (앱 말고 웹전용) - {{naverBand}}
		$naverBandTitle		= (preg_match('/euc/i',$server_character)) ? iconv("euc-kr", "UTF-8", $site_name2) : $site_name2;
		$naverBandTitle		= rawurlencode( $naverBandTitle." http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] );
		$naverBand = "
			<script type=\"text/javascript\">
				function naverBand ()
				{
					window.open(\"http://www.band.us/plugin/share?body=".$naverBandTitle."&route=".$_SERVER["SERVER_NAME"]."\", \"share_band\", \"width=410, height=540, resizable=no\");
				}
			</script>
			<a href='javascript:void(0);'><img src=\"img/sns_icon/icon_naver_band_02.png\" onclick=\"naverBand();\" align=\"absmiddle\" style=\"cursor:pointer;\" alt=\"네이버 밴드 공유\"></a>
		";

/*
	#me2day 를 위한 API : 2010.11.1 NeoHero
	$me2day_text_u = "\"$main_url/bbs_detail.php?bbs_num=$BOARD[number]&tb=$_GET[tb]\":$main_url/bbs_detail.php?bbs_num=$BOARD[number]&tb=$_GET[tb]";
	$me2day_text_t = "$BOARD[bbs_title]";
	if ($server_character == 'euckr'){
		$me2day_text_u = iconv("euc-kr" , "UTF-8",$me2day_text_u);
		$me2day_text_t = iconv("euc-kr" , "UTF-8",$me2day_text_t);
	}
	$me2day_text_u = urlencode($me2day_text_u);
	$me2day_text_t = urlencode($me2day_text_t);
	$me2day_url = "<a href='http://me2day.net/posts/new?new_post[body]=$me2day_text_u&new_post[tags]=$me2day_text_t' target=_blank onfocus='blur();'><img src=img/sns_icon/icon_me2day.png align=absmiddle border=0 alt='미투데이로 보내기' class=png24></a>";
	#me2day  를 위한 API : 2010.11.1 NeoHero
	//2011-05-11 HYO end 트위터, 페이스북, 미투데이 추가

	#cyword C공감을 위한 API 2011.02.10 hun
$cyworld_text_u = "$main_url/bbs_detail.php?bbs_num=$BOARD[number]&tb=$tb&id=&pg=$pg";
$cyworld_text_t = $BOARD[bbs_title];
$cyworld_text_h = strip_tags($BOARD[bbs_review]);

if ($server_character == 'euckr')
{
	$cyworld_text_u = iconv("euc-kr" , "UTF-8",$cyworld_text_u);
	$cyworld_text_t = iconv("euc-kr" , "UTF-8",$cyworld_text_t);
	$cyworld_text_h = iconv("euc-kr" , "UTF-8",$cyworld_text_h);
}

preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $BOARD['bbs_review'], $sns_img);
$cyworld_thumb = '';
for ($i = 0; $i < 2; $i++ )
{
	if (!preg_match('/http:\/\//',$sns_img[1][$i],$matches) && $sns_img[1][$i] )
	{
		$cyworld_thumb = "$main_url" . $sns_img[1][$i];
		break;
	}
}

if ( $cyword_thumb == "" )
{
	if ( $BOARD['bbs_etc6'] != "" )
	{
		$cyword_thumb = "$main_url/data/$_GET[tb]/$BOARD[bbs_etc6]";
	}
}

$cyworld_text_u = urlencode($cyworld_text_u);
$cyworld_text_t = urlencode(base64_encode($cyworld_text_t));
$cyworld_text_h = urlencode(base64_encode($cyworld_text_h));

$C공감 = "<img style='cursor: pointer;' border='0' align='absmiddle' src='img/sns_icon/icon_cyworld.png' onclick='window.open(\"http://csp.cyworld.com/bi/bi_recommend_pop.php?url=$cyworld_text_u&title=$cyworld_text_t&thumbnail=$cyworld_thumb&summary=$cyworld_text_h&writer=$main_url\", \"recom_icon_pop\", \"width=400,height=364,scrollbars=no,resizable=no\");' alt='싸이월드 공감' title='싸이월드 공감' >";
#cyword C공감을 위한 API 2011.02.10 hun
*/
	#모바일일 경우 이미지 width값 220px
	$board_mobile_mode = false;
	if ( $m_version )
	{
		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$board_mobile_mode = true;

			$width_info = "width = ";
		}
	}

	#첨부파일이 있으면 첨부파일 아이콘을 보여주자. 이미지는 팝업을 띄우자
	$attach_array = array('bbs_etc1','bbs_attach2','bbs_attach3','text1','text2'); #이미지필드선언
	$BOARD[attach] = '';
	foreach ($attach_array as $list)
	{
		if ( $BOARD[$list] != "" &&  !(preg_match("/갤러리/",$B_CONF[admin_etc6])) &&  !(preg_match("/갤러리/",$B_CONF[board_name])) )
		{
			if (preg_match('/.jp/i', $BOARD[$list]) || preg_match('/.gif/i', $BOARD[$list]))
			{
				$imagehw = GetImageSize("./data/$tb/$BOARD[$list]");
				$img_width = $imagehw[0];
				$img_height = $imagehw[1];

				$BOARD[attach] .= "
					<a href=\"javascript:openNewWindow('bbs_close_img.php?tb=$tb&number=$BOARD[number]&file_name=./data/$tb/$BOARD[$list]','$img_width','$img_height')\" uk-icon='icon:image; ratio:1' class='icon_m noto400 h_btn_r'>$BOARD[$list]</a>
				";
			}
			elseif (preg_match("/\./i", $BOARD[$list]))
			{
				$BOARD[attach] .= "
					<a href='./data/$tb/$BOARD[$list]'  uk-icon='icon:link; ratio:1' class='icon_m noto400 h_btn_r'>$BOARD[$list]</a>
				";
			}
			else
			{
				$BOARD[attach] .= "";
			}
		}
	}





#팝업스크립트
$BOARD[img_java] = <<<END
<script language="JavaScript">
function openNewWindow(window,width,height) {
open (window,"NewWindow","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width="+ width +", height="+height+",top=0,left=0");
}
</script>
END;

	#모바일일 경우 이미지 width값 220px
	$board_mobile_mode = false;
	if ( $m_version )
	{
		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$board_mobile_mode = true;

			$B_CONF[img_width] = "220";
		}
	}

	#첨부파일이 jpg나 gif면 자동으로 그림을 보여주자

	$BOARD[img_auto] = '';

	$img_width_total = 0;

	foreach ($attach_array as $list)
	{
		$temp_w = 0;
		if ( ( preg_match("/\.jp/i", $BOARD[$list]) || preg_match("/\.gif/i", $BOARD[$list]) ) && $B_CONF[auto_img] == '1'  )
		{
			#본문에 보여줌
			$main_img_temp = "./data/$tb/$BOARD[$list]";
			$BOARD[img_auto] .= "<img src='$main_img_temp' style='margin-top:10px;' border=0 width=$B_CONF[img_width]><br>";
			$temp_w = $B_CONF[img_width];
		}
		elseif ( ( preg_match("/\.jp/i", $BOARD[$list]) || preg_match("/\.gif/i", $BOARD[$list]) ) && $B_CONF[auto_img] == '2'  )
		{
			#이미지 안보여줌
			$main_img_temp = "./data/$tb/$BOARD[$list]";
			$BOARD[img_auto] .= "";
		}
		elseif ( ( preg_match("/\.jp/i", $BOARD[$list]) || preg_match("/\.gif/i", $BOARD[$list]) ) && !$B_CONF[auto_img]  )
		{
			#팝업
			if (preg_match("/\.jp/i", $BOARD[$list])  )
			{
				#jpg는 썸네일 불러냄
				$temp_name = explode(".",$BOARD[$list]);
				$ext = strtolower($temp_name[sizeof($temp_name)-1]);
				$t_file_name = strtolower($temp_name[sizeof($temp_name)-2]);
				$org_file_name = "$t_file_name.$ext";
				$main_img_temp = "./data/$tb/${t_file_name}-thumb.$ext";
			}
			else
			{
				#gif는 원본을 불러냄
				$main_img_temp = "./data/$tb/$BOARD[$list]";
			}

			$imagehw = GetImageSize("./data/$tb/$BOARD[$list]");
			$img_width = $imagehw[0];
			$img_height = $imagehw[1];
			$BOARD[img_auto] .= "<td class='bbs_img_auto_box'><a href=\"javascript:openNewWindow('bbs_close_img.php?tb=$tb&number=$BOARD[number]&file_name=./data/$tb/$BOARD[$list]','$img_width','$img_height')\"><img src='$main_img_temp' width='$B_CONF[mini_thumb]' border=0></a></td>";
			$temp_w = $B_CONF[mini_thumb];
			$img_width_total = $img_width_total + $temp_w;

			if ($img_width_total > $attach_file_align_size  - $temp_w)
			{
				$BOARD[img_auto] .= "</tr><tr>";
				$img_width_total = 0;
			}
		}
	}

	#모바일/일반웹 사진정리 , 지도정리 By NeoHero : 2010.04.12 -> 뉴스에서 가져옴
	#iphone change img width
	if (preg_match('/iPhone/i',$_SERVER['HTTP_USER_AGENT']) && $_COOKIE['happy_mobile'] && $m_version)
	{
		$mobile_width = '280';
	}
	elseif (!preg_match('/iPhone/i',$_SERVER['HTTP_USER_AGENT']) && $_COOKIE['happy_mobile'] && $m_version)
	{
		$mobile_width = '310';
	}

	if ($_COOKIE['happy_mobile'] == 'on' && $m_version)
	{
		$BOARD['bbs_review_mobile'] = preg_replace("/<img(.*?)>/e" ," detail_convert_mobile('\\1')",$BOARD["bbs_review"]);

		#네이버지도 모바일크기
		$BOARD['bbs_review_mobile'] = preg_replace("/<div style=\"width:(.*?)px/" ,"<div style=\"width:${mobile_width}px",$BOARD['bbs_review_mobile']);
		$BOARD['bbs_review_mobile'] = preg_replace("/,600,/" ,",$mobile_width,",$BOARD['bbs_review_mobile']);
	}
	#모바일/일반웹 사진정리 , 지도정리끝 2010-10-20 -> 뉴스에서 가져옴

	#잠긴글 비밀번호를 넣었다.
	if ($_POST[write_password])
	{
		#잠긴글에 관리자가 답변하여 잠근경우 글쓴이도 보자.
		if ($BOARD[depth] > 0)
		{
			#답변글이다. 원본글추적
			$sql = "select * from $tb where groups='$BOARD[groups]' and depth='0' ";
			$result = query($sql);
			$RE_BOARD = happy_mysql_fetch_array($result);
		}

		#비밀번호가 글 비밀번호나 혹은 게시판전체비밀번호와 같은지 비교한다.
		if ($_POST[write_password] == $B_CONF[board_pass] || $_POST[write_password] == $BOARD[bbs_pass] )
		{
			$master_check = '1';
		}
		#원본글의 비밀번호를 알아도 답변글의 잠긴글을 볼수 있다.
		elseif ($_POST[write_password] == $RE_BOARD[bbs_pass] )
		{
			$master_check = '1';
		}
		else
		{
			error("\\n비밀번호가 일치하지 않습니다. \\n\\n다시 입력해주세요 ");
			exit;
		}
	}

	#자기글일때
	if ( $BOARD['bbs_id'] == $mem_id && $mem_id )
	{
		$master_check = "1";
	}


	#잠긴글일때
	$sns_link_btn_display	= "";
	if ($BOARD[view_lock] == "1")
	{
		$sns_link_btn_display	= "none;";
	}
	if (!$master_check && $BOARD[view_lock]){

		$view_lock_chk	= "no";
		if ( $mem_id != '' && $mem_id == $BOARD['bbs_id'] )
		{
			#자신의글에 권한획득
			$view_lock_chk = "yes";
		}
		else if ( $mem_id == $BOARD[bbs_etc7] && $BOARD[bbs_etc7] )
		{
			$view_lock_chk = "yes";
		}
		elseif ( $mem_id != '' )
		{
			#회원이면 원본글을 조사하여 권한획득
			$uDepth	= $BOARD['depth'] - 1;
			$Sql	= "SELECT bbs_name FROM $tb WHERE groups='$BOARD[groups]' AND ( depth='$uDepth' or depth='0' )";
			$rTmp	= query($Sql);

			while ( $Tmp = happy_mysql_fetch_array($rTmp) )
			{
				if ( $Tmp[0] == $mem_id && $mem_id)
				{
					$view_lock_chk	= "yes";
				}
			}
		}

	if ( $view_lock_chk == "no" )
		{
			$BOARD[img_auto] = '';
			$BOARD[attach] = '';

			if ( $_COOKIE['happy_mobile'] == "on" )
			{
				$BOARD['bbs_review_mobile'] = $BOARD['bbs_review'] = "

				<form name='regiform' method='post' action='./bbs_detail.php?id=$_GET[id]&num=$_GET[num]&tb=$tb&minihome_id=$_GET[minihome_id]&bbs_num=$bbs_num&top_gonggi=$_GET[top_gonggi]'>
				<input type=hidden name='tb' value='$tb'>
				<input type=hidden name='minihome_id' value='$_GET[minihome_id]'>
				<input type=hidden name='bbs_num' value='$bbs_num'>
				<input type=hidden name='top_gonggi' value='$_GET[top_gonggi]'>
					<div style='border:1px solid #e2e2e2; background:#f9f9f9; padding:30px 0px;'>
						<div style='color:#222222; text-align:center; font-size:1.2em' ><strong>게시글잠금</strong></div>
						<div style='color:#999999; text-align:center; margin-top:10px;' class='font_15'>작성시 입력하신 비밀번호를 입력하여 주세요.</div>
						<div class='h_form' style='text-align:center; margin-top:10px;'>
							<input type=password name='write_password' class='input_text_st' style='width:150px;'/><button style='background:#ffffff; margin-left:5px;'>확인</button>
						</div>
					</div>
				</form>
				";
			}else{
				$BOARD['bbs_review_mobile'] = $BOARD['bbs_review'] = "
				<form name='regiform' method='post' action='./bbs_detail.php?minihome_id=$_GET[minihome_id]&id=$_GET[id]'>
				<input type=hidden name='tb' value='$tb'>
				<input type=hidden name='minihome_id' value='$_GET[minihome_id]'>
				<input type=hidden name='bbs_num' value='$bbs_num'>
				<input type=hidden name='top_gonggi' value='$_GET[top_gonggi]'>
				<div style='width:350px; margin:0 auto; border:1px solid #e2e2e2; background:#f9f9f9; padding:30px; margin-bottom:60px;'>
					<div style='color:#222222; text-align:center; font-size:20px;' class='noto400'>게시글잠금</div>
					<div style='color:#999999; text-align:center; font-size:15px; margin-top:10px;' class='noto400'>작성시 입력하신 비밀번호를 입력하여 주세요.</div>
					<div class='h_form' style='text-align:center; margin-top:10px;'>
						<input type=password name='write_password' class='input_text_st' style='width:150px;'/><button style='background:#ffffff; margin-left:3px;'>확인</button>
					</div>
				</div>
				</form>
				";

			}

			//모바일모드일때 글잠금 처리 2012-03-19 kad
			$BOARD['bbs_review_mobile'] = $BOARD['bbs_review'];
			//모바일모드일때 글잠금 처리 2012-03-19 kad
		}
	}



	#뉴스스타일 일때~
	if (preg_match("/뉴스/",$B_CONF[admin_etc6]))
	{
		$align_left = "align=left cellpadding=1";
	}
	else
	{
		$align_left = "align=center";
	}


	#테이블 만들어주자
	if (!$B_CONF[auto_img])
	{
		$BOARD[img_auto] = "$BOARD[img_java]\n<table border=0 $align_left><tr>$BOARD[img_auto]</tr></table>";
	}
	else
	{
		$BOARD[img_auto] = $BOARD[img_java] . $BOARD[img_auto];
	}

	#해당 게시판속성이 뉴스라면 사진을 옆으로 붙인다
	if (preg_match("/뉴스/",$B_CONF[admin_etc6]))
	{
		$BOARD[bbs_review] = $BOARD[img_auto] . $BOARD[bbs_review];
		$BOARD[img_auto] = '';
	}
	#뉴스일때~끝

	if ($B_CONF[category])
	{
		$BOARD[b_category_dis] = "";

		if ($BOARD[b_category] == "")
		{
			$BOARD[b_category] = '전체';
			$BOARD[b_category_dis] = "display:none;";
		}
		$BOARD[b_category_con] = '<span>[' . $BOARD[b_category] . ']</span>';
	}
	else
	{
		$BOARD[b_category_dis] = "display:none;";
	}

	#모바일/일반웹 사진정리 , 지도정리 By NeoHero : 2010.04.12 -> 뉴스에서 가져옴
	#iphone change img width
	if (preg_match('/iPhone/i',$_SERVER['HTTP_USER_AGENT']) && $_COOKIE['happy_mobile'] && $m_version)
	{
		$mobile_width = '';
	}
	elseif (!preg_match('/iPhone/i',$_SERVER['HTTP_USER_AGENT']) && $_COOKIE['happy_mobile'] && $m_version)
	{
		$mobile_width = '';
	}

	if ($_COOKIE['happy_mobile'] == 'on' && $m_version)
	{
		$BOARD['bbs_review_mobile'] = preg_replace("/<img(.*?)>/e" ," detail_convert_mobile('\\1')",$BOARD["bbs_review"]);

		#네이버지도 모바일크기
		$BOARD['bbs_review_mobile'] = preg_replace("/<div style=\"width:(.*?)px/" ,"<div style=\"width:${mobile_width}px",$BOARD['bbs_review_mobile']);
		$BOARD['bbs_review_mobile'] = preg_replace("/,600,/" ,",$mobile_width,",$BOARD['bbs_review_mobile']);
	}
	//echo $BOARD['bbs_review_mobile'];
	#모바일/일반웹 사진정리 , 지도정리끝 2010-10-20 -> 뉴스에서 가져옴

	#게시판정보
	if ($B_CONF[board_read] == "0")
	{
		$게시판권한 = "공개게시판";
	}
	elseif ($B_CONF[board_read] == "1")
	{
		$게시판권한 = "회원읽기";
	}
	elseif ($B_CONF[board_read] == "2")
	{
		$게시판권한 = "딜러읽기";
	}
	elseif ($B_CONF[board_read] == "5")
	{
		$게시판권한 = "관리자전용읽기";
	}
	else
	{
		$게시판권한 = "머죠!";
	}

	#관리자 로그인정보
	if ( admin_secure("게시판관리") )
	{
		$관리자로그인 = "<A HREF='./bbs_logout.php?id=$_GET[id]&num=$num&tb=$tb'><img src='bbs_img/bt_admin_logout.gif' border=0 align=absmiddle></A>";
		$master_check = '1';
	}
	else
	{
		$관리자로그인 = "<A HREF='./admin/admin.php' target=_blank><img src='bbs_img/bt_admin_login.gif' border=0 align=absmiddle></A>";
	}

	#카테고리정보추가
	$plus .= "&b_category=$b_category";

	#버튼들을 정리하자
	if ($_GET[id])
	{
		$add_search_board = "and bbs_etc7 = '$_GET[id]' ";
		$add_search_page = "&id=$_GET[id]";
		$plus .= "&id=$_GET[id]";
		$add_normal_board = "where bbs_etc7 = '$_GET[id]'";

		$sql = "select * from $happy_member where user_id='$_GET[id]'";
		$result = query($sql);
		$DEAL = happy_mysql_fetch_array($result);

		if($DEAL['minihome_template'] == "")
		{
			echo "잘못된 접근입니다";
			exit;
		}
		$large_template = "$minihome_folder/".$DEAL[minihome_template];
	}
	else
	{
		if($B_CONF['board_temp'] == "")
		{
			echo "잘못된 접근입니다";
			exit;
		}
		$large_template = "$skin_folder_bbs/".$B_CONF[board_temp];
	}

	/*
	print_r2($MEM);
	print_r2($B_CONF);
	echo $master_check;
	*/

	#버튼들 관리자모드에서 설정하도록 업그레이드됨
	$modify_button = $HAPPY_CONFIG['IconModify1'];
	$list_button = $HAPPY_CONFIG['IconList1'];
	$pick_button = $HAPPY_CONFIG['IconPick1'];
	$reply_button = $HAPPY_CONFIG['IconReply2'];
	$delete_button = $HAPPY_CONFIG['IconDelete1'];
	$source_button = $HAPPY_CONFIG['IconSource1'];



	$추천 = '<A HREF="./bbs_pick.php?tb='.$tb.$add_link.'&bbs_num='.$BOARD['number'].'&pg='.$pg.$plus.'" uk-icon="icon:heart; ratio:1" class="icon_m uk-icon">추천</A>';

	if (  happy_member_secure('%게시판%'.$tb.'-reply') || $master_check )
	{
		$답변 = '<A HREF="./bbs_reply.php?mode=reply&tb='.$tb.$add_link.'&bbs_num='.$BOARD['number'].'&pg='.$pg.$plus.'" class="icon_m uk-icon" uk-icon="icon:comment; ratio:1">답변</A>';

		if ( $tb == "board_albaguin" )
		{
			//알바채용 게시판에서는 답변이 필요없음.
			$답변 = "";
		}

		if ( $B_CONF['admin_etc6'] == "스케쥴게시판" )
		{
			//일정게시판도 답변이 없음
			$답변 = "";
		}
	}

	if ( happy_member_secure('%게시판%'.$tb.'-modify') )
	{
		$수정 = '<a href="./bbs_mod.php?tb='.$tb.$add_link.'&bbs_num='.$BOARD['number'].'&pg='.$pg.$plus.'&links_number='.$_GET['links_number'].'" class="icon_m uk-icon" uk-icon="icon:file-edit; ratio:1">수정</a>';
	}

	if ( happy_member_secure('%게시판%'.$tb.'-delete') )
	{
		$삭제 = '<a href="javascript:bbsdel(\'./bbs_del.php?tb='.$tb.$add_link.'&bbs_num='.$BOARD['number'].'&pg='.$pg.$plus.'\');" class="icon_m uk-icon" uk-icon="icon:trash; ratio:1">삭제</A>';
	}

//목록보기 버튼 띄어쓰기되어서 맨앞으로 붙여둠.
	$목록 =<<<END
<A HREF="./bbs_list.php?tb=$tb&pg=$pg$plus" uk-icon="icon:list; ratio:1" class="icon_m uk-icon">목록보기</A><script language="javascript">
	<!--
		function bbsdel_confirm(strURL, short_number)
		{
			obj = document.getElementById("password_input_" + short_number);
			if ( obj.value == "" )
			{
				alert("패스워드를 입력해주세요.");
				obj.focus();
				return false;
			}
			else
			{
				strURL += "&password=" + obj.value;
				window.location.href= strURL;
			}
		}

		function bbsdel(strURL, short_number)
		{
			var ismember	= '$happy_member_login_value';
			var admin_check	= "$_COOKIE[ad_id]";

			if ( ismember == "" && admin_check == "" && short_number != undefined )
			{
				obj = document.getElementById("nonmember_pass_" + short_number);
				if ( obj.style.display == "block" )
				{
					obj.style.display = "none";
					document.getElementById("password_input_" + short_number).value = "";
					return;
				}
				else
				{
					obj.style.display = "block";
					alert("패스워드를 입력해주세요.");
					document.getElementById("password_input_" + short_number).focus();
					return;
				}
			}
			else
			{
				var msg = "삭제하시겠습니까?";
				if (confirm(msg))
				{
					window.location.href= strURL;
				}
			}
		}
	-->
	</script>
END;


	$소스 = '<a href="javascript:void(0);" class="icon_m uk-icon" uk-icon="icon:file-text; ratio:1" onclick="window.open(\'bbs_source_view.php?tb='.$tb.'&bbs_num='.$BOARD['number'].'&write_password='.$_POST['write_password'].'&id='.$_GET['id'].'\',\'bad\',\'width=500,height=400,scrollbars=no\')">소스보기</a>';



$댓글보기권한 = "";
$댓글쓰기권한 = "";
if ( happy_member_secure('%게시판%'.$tb.'-comment_view') )
{
	$댓글보기권한 = "1";
}

if ( happy_member_secure('%게시판%'.$tb.'-comment_write') )
{
	$댓글쓰기권한 = "1";
}

if ( happy_member_secure('%게시판%'.$tb.'-comment_write') )
{
	# 비회원이 댓글쓰기권한이 있을때 ralear
	if ( $happy_member_login_value == "" && $_COOKIE['ad_id'] == "" )
	{
		#######################################################################################################
		# 도배방지키 : NeoHero 2009.08.01
		#######################################################################################################
		$dobae_1 = rand(1,9);$dobae_2 = rand(1,9);$dobae_3 = rand(1,9);$dobae_4 = rand(1,9);
		$gara1 = "<font color=#ffffff>".rand(0,9)."</font>";
		$gara2 = "<font color=#ffffff>".rand(0,9)."</font>";
		$gara3 = "<font color=#ffffff>".rand(0,9)."</font>";
		$gara4 = "<font color=#ffffff>".rand(0,9)."</font>";
		$rand1 = rand(100,9000);
		$rand2 = rand(100,9000);
		$rand3 = rand(100,9000);
		$rand4 = rand(100,9000);
		@eval('$dobae_org =' .$dobae_1.$dobae_2.$dobae_3.$dobae_4. ';');
		$dobae_org = $dobae_number - $dobae_org;
		$bbs_dobae = "&nbsp;" . $dobae_1 . "$gara1<img src=img/dot.gif name=bbs_name0 $rand1><span style=disply:none bt_adminlogout_login></span>" .
										 $dobae_2 . "$gara2<img src=img/dot.gif name=pass happycgi.com=test$rand2>" .
										 $dobae_3 . "$gara3<img src=img/dot.gif name=email happycgi.com=cgimall.co.kr-$rand3>" .
										 $dobae_4 . "$gara4<img src=img/dot.gif name=comment happycgi.com=$rand4>" ;
		#######################################################################################################
		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$nomember_passform =<<<END

			<div class='dp_table_100' style='margin-top:5px;'>
				<div class='dp_table_row'>
					<div class='dp_table_cell'>
						<input type="password" name="password" style="width:100%" id="short_password_0" placeholder="비밀번호"/>
					</div>
					<div class='dp_table_cell' style='width:100px; padding:0px 5px;'>
						<input name='dobae' type='text' style="width:100%;" id="short_dobae_0" maxlength="4" placeholder="도배방지키"/>
					</div>
					<div class='dp_table_cell' style='width:110px; text-align:right;'>
						<span class="bbs_dobae bbs_dobae_width">$bbs_dobae</span>
						<input type=hidden name=dobae_org value='$dobae_org'>
					</div>
				</div>
			</div>

END;
		}
		else
		{
			$nomember_passform =<<<END

			<div style="margin-top:10px;">
				<div style="float:left">
					<input type="password" name="password" id="short_password_0" style="width:120px;" placeholder="비밀번호 입력"/> <span class="font_15 noto400" style="color:#999999;">수정/삭제시 이용합니다.</span>
				</div>
				<div style="float:right">
					<input name='dobae' type='text' id="short_dobae_0" style="width:130px;" maxlength="4" placeholder="도배방지키 입력"/><span class="bbs_dobae" style="margin-left:5px;">$bbs_dobae</span>
					<input type=hidden name=dobae_org value='$dobae_org'>
				</div>
				<div style="clear:both;"></div>
			</div>

END;
		}
	}
}


#댓글이 있다면 읽어주자
if ($BOARD[bbs_etc2] > 0 )
{
	//$sql = "select * from $board_short_comment where tbname='$tb' and board_number = '$bbs_num' order by number asc ";
	//공지게시글 댓글 패치 2012-07-12
	$sql = "select * from $board_short_comment where tbname='$tb' and board_number = '$bbs_num' order by comment_group asc, comment_seq asc ";
	$result = query($sql);
	while ($SHORT = happy_mysql_fetch_array($result))
	{
		//echo "댓글번호: $SHORT[number] / 댓글그룹: $SHORT[comment_group] / 댓글순서: $SHORT[comment_seq] / 댓글깊이: $SHORT[depth]<br>";
		//댓글수정
		$댓글수정폼 = "";
		$비회원대댓글 = "";
		$비회원대댓글2 = "";
		$SHORT['comment_org'] = $SHORT['comment'];
		#$SHORT['comment'] = $SHORT['number'].'-'.$SHORT['comment_group'].'-'.$SHORT['comment_seq'].'-'.$SHORT['depth'].'-'.$SHORT['parent_number'].' ::: '.$SHORT['comment'];


		#대댓글 기능 추가 sikim
		if($SHORT['depth'] <= 0)
		{
			$Content_Depth = "reply_content_depth_0";
		}
		else
		{
			$Content_Depth	= "reply_content_depth_".$SHORT['depth'];
		}
		$답글아이콘		= "";

		if( $댓글쓰기권한 == "1" && $SHORT['depth'] < $recomment_depth)
		{
			$답글아이콘 = <<<END
				<a href="javascript:show_reply_reply('$SHORT[number]')" class="h_btn_s" style="color:rgb(166,166,166); font-family:'Noto Sans KR', sans-serif !important;" onmouseover="this.style.color='#797979'" onmouseout="this.style.color='#a6a6a6'">대댓글 달기</a>
END;
		}
		#대댓글 기능 추가 sikim

		if ( $happy_member_login_value == "" && $_COOKIE['ad_id'] == "" )
		{
			if ( $_COOKIE['happy_mobile'] == "on" ){
			$비회원대댓글 = "
				<div class='h_form' style='margin-top:3px;'>
					<p style='display:flex; justify-content:space-between;'>
						<input type=\"password\" name=\"password\" id='short_password_$SHORT[number]' placeholder='비밀번호'/>
						<input name='dobae' type='text' id='short_dobae_$SHORT[number]' style=' margin-left:3px; max-width:100px; min-width:100px;' maxlength='4' placeholder='도배방지키'/>
						<span class='bbs_dobae' style='margin-left:10px; display:block; max-width:100px;  min-width:100px; margin-left:3px;'>$bbs_dobae</span><input type=hidden name=dobae_org value='$dobae_org'>
					</p>
				</div>";
			$비회원대댓글2 = "
				<div class='h_form'>
					<div class='dp_table_cell' style='padding-top:5px;'>
						<input type=\"password\" name=\"password\" id='short_password_mod_$SHORT[number]'  placeholder='비밀번호 입력'/>
					</div>
				</div>
				";
			}else{
				$비회원대댓글 = "

				<div class='h_form' style='margin-top:10px; display:flex; justify-content:space-between;'>
					<p>
						<input type=\"password\" name=\"password\" id='short_password_$SHORT[number]' style='width:120px; 'placeholder='비밀번호 입력'/>
						<span class='font_15 noto400' style='color:#999'>수정/삭제시 이용합니다.</span>
					</p>
					<p>
						<input name='dobae' type='text' id='short_dobae_$SHORT[number]' style=' margin-left:3px; width:130px;' maxlength='4' placeholder='도배방지키 입력'/>
						<span class='bbs_dobae' style='margin-left:10px; display:inline-block; width:100px; margin-left:3px;'>$bbs_dobae</span><input type=hidden name=dobae_org value='$dobae_org'>
					</p>
				</div>";
				$비회원대댓글2 = "
				<div class='h_form' style='padding:0 15px 15px 15px;'>
					<input type=\"password\" name=\"password\" id='short_password_mod_$SHORT[number]'  placeholder='비밀번호 입력' style='width:120px;'/> <span class='font_15 noto400' style='color:#999999;'>수정시 이용합니다.</span>
				</div>
				";
			}

		}

		if ( ( $master_check == "1" || $SHORT[id] == $mem_id ) && happy_member_secure('%게시판%'.$tb.'-comment_delete') )
		{

			$btn_modify = "<a href=\"javascript:show_reply_mod('$SHORT[number]');\" class=\"h_btn_s\"style=\"font-family:Noto Sans KR, sans-serif !important; color:#a6a6a6;\" onmouseover=\"this.style.color='#797979'\">MOD</a>";


			if ( ( $master_check == "1" || $SHORT[id] == $mem_id ) && happy_member_secure('%게시판%'.$tb.'-comment_delete') )
			{
				//$del_short = "<a href=\"javascript:bbsdel('bbs_short_comment.php?action=del&tb=$tb&number=$SHORT[number]&bbs_num=$bbs_num&pg=$pg$plus','$SHORT[number]');\"><font color=gray size=1><font color=#FD5A5A>X</a>";
				$del_short = $btn_modify." <a href=\"javascript:bbsdel('bbs_short_comment.php?action=del&top_gonggi=$top_gonggi_comment&tb=$tb&number=$SHORT[number]&bbs_num=$bbs_num&pg=$pg$plus','$SHORT[number]');\" class=\"h_btn_s\" style=\"color:red; font-family:'Noto Sans KR', sans-serif !important; \">DEL</a>";
			}

			if ( $mem_id == "" && $_COOKIE['ad_id'] == "" && $SHORT['is_admin'] == "1" )	// 로그아웃상태(유저,관리자 둘다)에서 관리자가 쓴 글이라면
			{
				$del_short = "";	// 관리자가 작성한 댓글은 관리자만 삭제가 가능하게끔 변경
			}
		}
		else
		{
			$del_short = "";
		}

		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$댓글작성폼 = "
				<!-- 댓글에 댓글 수정-->
				<table cellpadding='0' cellspacing='0' style='width:100%; display:none; margin:10px 0; border-top:1px solid #ddd;' id='reply_mod_$SHORT[number]'>
					<tr>
						<td>
							<table cellpadding='0' cellspacing='0' border='0' style='width:100%;'>
							<tr>
								<td style='padding:10px 0;'>
									<b class='n_font' style='color:#666; font-weight:normal;'>댓글 수정</b>
								</td>
							</tr>
							<tr>
								<td class='bbs_comment_st h_form font_14'>
									<input type='hidden' name='action' value='mod' />
									<input type='hidden' name='number' value='$SHORT[number]' />
									<textarea style='height:71px;' name='short_comment_mod' id='short_comment_mod_$SHORT[number]' >$SHORT[comment_org]</textarea>
								</td>
							</tr>
							<tr>
								<td>$비회원대댓글2</td>
							</tr>
							<tr>
								<td align=right class='h_form' style='padding-top:5px;'>
									<button onClick=\"check_comment_form('$SHORT[number]','mod')\"  class='icon_m_100p h_btn_st1 uk-icon' uk-icon='icon:pencil; ratio:0.8' style='width:100%;'>댓글수정</button>
								</td>
							</tr>
							</table>
						</td>
					</tr>
				</table>
				<!-- 댓글에 댓글 -->
						<table cellpadding='0' cellspacing='0' style='width:100%; display:none; margin:10px 0; border-top:1px solid #ddd;' id='reply_$SHORT[number]'>
							<tr>
								<td style='padding:10px 0;'>
									<b class='n_font' style='color:#666; font-weight:normal;'>답글쓰기</b>
								</td>
							</tr>
							<tr>
								<td>
									<table style='width:100%;' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='h_form'><textarea style='width:100%; height:71px; border:1px solid #dbdbdb; font-size:12px;' name='short_comment' id='short_comment_$SHORT[number]' class=Sinput2 ></textarea></td>
										</tr>
										<tr>
											<td>$비회원대댓글</td>
										</tr>
										<tr>
											<td align=right class='h_form' style='width:100px; padding-top:5px;'><button  onClick=\"check_comment_form('$SHORT[number]',document.reply_add_form)\"  class='icon_m_100p h_btn_st1 uk-icon' uk-icon='icon:pencil; ratio:0.8' style='width:100%;'>답글쓰기</button></td>
										</tr>
									</table>
								</td>
							</tr>

						</table>
				";
		}
		else
		{
			$댓글작성폼 = "
				<!-- 댓글에 댓글 수정-->
				<table cellpadding='0' cellspacing='0' style='width:100%; display:none; margin-bottom:10px; margin-top:10px; padding-top:10px; border-top:1px solid #ddd; ' id='reply_mod_$SHORT[number]'>
				<tr>
					<td style=' padding-bottom:10px;'>
						<b class='n_font' style='font-size:14px; color:#666; font-weight:normal;'>댓글수정</b>
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding='0' cellspacing='0' style='width:100%;'>
						<tr>
							<td class='h_form'>
							<input type='hidden' name='action' value='mod' />
								<input type='hidden' name='number' value='$SHORT[number]' />
								<textarea name='short_comment_mod' id='short_comment_mod_$SHORT[number]' style='height:71px;'>$SHORT[comment_org]</textarea>
							</td>
							<td style='width:10px;'></td>
							<td align=right class='h_form' style='width:130px;'><a href='javascritp:void(0);' onClick=\"check_comment_form('$SHORT[number]','mod')\" alt='수정하기' class='font_14 h_btn_l icon_l h_btn_st1 uk-icon' uk-icon='icon:pencil; ratio:1'>댓글수정</a></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>$비회원대댓글2</td>
				</tr>
				</table>
				<!-- 댓글에 댓글 -->
				<table cellpadding='0' cellspacing='0' style='width:100%; display:none; margin:10px 0; padding-top:10px; border-top:1px solid #ddd;' id='reply_$SHORT[number]'>
				<tr>
					<td style=' padding-bottom:10px;'>
						<b class='n_font' style='font-size:14px; color:#666; font-weight:normal;'>답글쓰기</b>
					</td>
				</tr>
				<tr>
					<td>
						<table style='width:100%;' cellpadding='0' cellspacing='0'>
						<tr>
							<td class='h_form'><textarea name='short_comment' id='short_comment_$SHORT[number]' class='Sinput2 dd_txt_box'></textarea></td>
							<td class='h_form' style='width:130px;'><a href='javascritp:void(0);'  onClick=\"check_comment_form('$SHORT[number]',document.reply_add_form)\" class='font_14 h_btn_l icon_l h_btn_st1 uk-icon' uk-icon='icon:pencil; ratio:1' style='width:100%;'>답글쓰기</a></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>$비회원대댓글</td>
				</tr>
				</table>
			";
		}

		list($s_day,$s_time) = split(" ",$SHORT[reg_date]);
		$SHORT[comment] = nl2br($SHORT[comment]);

		if ( $SHORT['is_admin'] == '1' )
		{
			$comment_nick			= '관리자';
		}
		else if ( $SHORT['id'] == '' )
		{
			$comment_nick			= preg_replace("/(\d*)\.(\d*)\.(\d*)\.(\d*)/", "\\1.\\2.***.\\4", $SHORT['user_ip']);
		}
		else
		{
			$comment_user			= happy_mysql_fetch_array(query("SELECT user_nick FROM $happy_member WHERE user_id='$SHORT[id]'"));
			$comment_nick			= ( $comment_user['user_nick'] == '' ) ? $SHORT['id'] : $comment_user['user_nick'];
		}


			if ( $happy_member_login_value == "" && $_COOKIE['ad_id'] == "" )
			{
				if ( $_COOKIE['happy_mobile'] == "on" )
				{
					$nomember_passform =<<<END
					<table cellpadding='0' cellspacing='0' border='0' style='display:none; width:100%; background:#fff; margin-top:5px;' id="nonmember_pass_$SHORT[number]">
						<tr>
							<td style="padding:10px;">
								<div class="h_form">
									<div class="dp_table_cell">
										<input type="password" name="password" id="password_input_$SHORT[number]" tabindex='1'  placeholder="비밀번호 입력"/>
									</div>
									<div class="dp_table_cell" style="padding-left:3px;">
										<button onClick="bbsdel_confirm('bbs_short_comment.php?action=del&tb=$tb$add_link&number=$SHORT[number]&bbs_num=$bbs_num&pg=$pg$plus','$SHORT[number]')" class="h_btn_st1">댓글삭제</button>
									</div>
								</div>
							</td>
						</tr>
					</table>
END;
				}
				else
				{
					$nomember_passform =<<<END
					<table cellpadding='0' cellspacing='0' border='0' style='display:none; width:100%; background:#fff; margin-top:5px;' id='nonmember_pass_$SHORT[number]'>
						<tr>
							<td style="padding:15px 0;">
								<table cellpadding='0' cellspacing='0' border='0'>
								<tr>
									<td align="center" class="h_form" style='padding-left:15px;'><input type="password" name="password" id="password_input_$SHORT[number]" tabindex='1'class='input_text_st' style="width:120px;"  placeholder="비밀번호 입력"/></td>
									<td class="h_form" style='padding-left:5px;'>
										<button onClick="bbsdel_confirm('bbs_short_comment.php?action=del&tb=$tb$add_link&number=$SHORT[number]&bbs_num=$bbs_num&pg=$pg$plus','$SHORT[number]')" class="h_btn_st1">댓글삭제</button>
									</td>
								</tr>
								</table>
							</td>
						</tr>
					</table>

END;
				}
			}


			// 자신이 작성한 댓글 출력 여부 - 16.10.10 x2chi
			$Sql		= "
							SELECT
									Count(*)
							FROM
									$happy_member_secure
							WHERE
									menu_title		= '".$happy_member_secure_board_code.$tb."-comment_view_me'
									AND
									menu_use		= 'y'
			";
			list($chk)	= happy_mysql_fetch_array(query($Sql));
			$comment_view_me_checked	= $chk > 0 ? true : false;


			if ( happy_member_secure('%게시판%'.$tb.'-comment_view') OR ( $comment_view_me_checked AND $SHORT['id'] == $happy_member_login_value ) )
			{
				$댓글보기권한 = "1";

				if ( $_COOKIE['happy_mobile'] == "on" )
				{
					$댓글 .= <<<END
					<div class=$Content_Depth style=$depth_style>
						<table cellpadding='0' cellspacing='0' border='0' style='width:100%;'>
							<tr>
								<td style='padding:15px 0;'>
									<table cellpadding='0' cellspacing='0' border='0' style='width:100%;$highlight'>
									<tr>
										<td colspan="2">
											<table cellpadding='0' cellspacing='0' border='0' style='width:100%;'>
												<tr>
													<td class="detail_st_12 detail_link" style="color:#6f6f6f;">
														<table cellspacing="0" cellpadding="0">
														<tr>
															<td><strong>$comment_nick</strong></td>
															<td style='padding-left:5px;'>$group_icon</td>
															<td style='padding-left:10px; color:#a8a8a8;' class="detail_st_11">$s_day $s_time</td>
														</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<!-- 대댓글 기능 추가 sikim -->
										<td rowspan="2" >
											<p style='width:100%; word-wrap:break-word; line-height:17px; color:#797979; padding:15px 0;' class="detail_st_12">$SHORT[comment]</p>
											<p class="h_form" style="text-align:right;">$del_short $답글아이콘</p>$댓글작성폼$nomember_passform
										</td>
										<!-- 대댓글 기능 추가 sikim -->
									</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
END;
				}
				else
				{
				$댓글 .= <<<END
				<!-- 댓글 ~ -->
				<div class=$Content_Depth>
					<table cellpadding='0' cellspacing='0' border='0' style='width:100%;'>
						<tr>
							<td style='padding:15px 0;'>
								<table cellpadding='0' cellspacing='0' border='0' style='width:100%;'>
								<tr>
									<td>
										<table cellpadding='0' cellspacing='0' border='0' style='width:100%;'>
										<tr>
											<td class="font_14" style="color:#6f6f6f;"><span class="noto500">$comment_nick</span> &nbsp;&nbsp;&nbsp;<span class="font_14 font_tahoma" style="color:#a8a8a8;">$s_day $s_time</span></td>

											<td align='right' class="h_form">$del_short $답글아이콘</td>
										</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="padding:12px 0 5px 0; letter-spacing:-1px"><p style='width:100%; word-wrap:break-word; color:#797979;' class="font_15 noto400">$SHORT[comment]</p></td>
								</tr>
								<tr>
									<td>$nomember_passform</td>
								</tr>
								</table>
								$댓글작성폼
							</td>
						</tr>
					</table>
				</div>
				<!-- 댓글 ~ -->
END;
				}
			}
	}
}



if ( happy_member_secure('%게시판%'.$tb.'-comment_write') )
{
		# 비회원이 댓글쓰기권한이 있을때 ralear
	if ( $happy_member_login_value == "" && $_COOKIE['ad_id'] == "" )
	{

		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$nomember_passform =<<<END

			<div class='dp_table_100' style='margin-top:5px;'>
				<div class='dp_table_row'>
					<div class='dp_table_cell'>
						<input type="password" name="password" style="width:100%" id="short_password_0" placeholder="비밀번호"/>
					</div>
					<div class='dp_table_cell' style='width:100px; padding:0px 5px;'>
						<input name='dobae' type='text' style="width:100%;" id="short_dobae_0" maxlength="4" placeholder="도배방지키"/>
					</div>
					<div class='dp_table_cell' style='width:110px; text-align:right;'>
						<span class="bbs_dobae bbs_dobae_width">$bbs_dobae</span>
						<input type=hidden name=dobae_org value='$dobae_org'>
					</div>
				</div>
			</div>

END;
		}
		else
		{
			$nomember_passform =<<<END

			<div style="margin-top:10px;">
				<div style="float:left">
					<input type="password" name="password" id="short_password_0" style="width:120px;" placeholder="비밀번호 입력"/> <span class="font_15 noto400" style="color:#999999;">수정/삭제시 이용합니다.</span>
				</div>
				<div style="float:right">
					<input name='dobae' type='text' id="short_dobae_0" style="width:130px;" maxlength="4" placeholder="도배방지키 입력"/><span class="bbs_dobae" style="margin-left:5px;">$bbs_dobae</span>
					<input type=hidden name=dobae_org value='$dobae_org'>
				</div>
				<div style="clear:both;"></div>
			</div>

END;
		}
	}
	$댓글수정히든 = "
	<input type=hidden name='action_real' id='action_real' value='add'>
	<input type=hidden name='short_comment_real' id='short_comment_real' value=''>
	<input type=hidden name='password_real' id='password_real' value=''>
	<input type=hidden name='dobae_real' id='dobae_real' value=''>
	<input type=hidden name='dobae_org' value='$dobae_org'>
	<input type=hidden name='parent_number' id='parent_number' value=''>
	";

	$댓글쓰기폼 = <<<END
<script language='javascript'>
<!--

function memoLengthCheck(form,maxlen)
{
	var t;
	var msglen;
	msglen = 0;

	l = form.short_comment.value.length;
	for(k=0;k<l;k++){
	    if (msglen > maxlen ) {
			form.short_comment.focus();
			alert("입력 가능한 글자수를 초과했습니다.");
			return false;
	    }
	    t = form.short_comment.value.charAt(k);
	    if (escape(t).length > 4) msglen += 2;
	    else msglen++;
	}
}



		// 비회원일때 패스워드 스크립트
		function check_comment_form(short_number,mode)
		{
			var ismember = '$happy_member_login_value';
			var admin_check	= '$_COOKIE[ad_id]';

			Form_Obj		= document.reply_add_form;


			if ( mode == 'mod' )
			{
				short_comment_r		= document.getElementById('short_comment_mod_' + short_number);
				short_password_r	= document.getElementById('short_password_mod_' + short_number);
				short_dobae_r		= document.getElementById('short_dobae_mod_' + short_number);

				Form_Obj.action_real.value	= 'mod';
			}
			else
			{
				short_comment_r		= document.getElementById('short_comment_' + short_number);
				short_password_r	= document.getElementById('short_password_' + short_number);
				short_dobae_r		= document.getElementById('short_dobae_' + short_number);

				Form_Obj.action_real.value	= 'add';
			}

			if ( short_comment_r.value == '' )
			{
				alert('댓글을 입력해주세요.');
				short_comment_r.focus();
				return false;
			}

			if ( ismember == '' && admin_check	== '')
			{
				if ( short_password_r.value == '' )
				{
					alert('패스워드를 입력해주세요.');
					short_password_r.focus();
					return false;
				}

				Form_Obj.password_real.value		= short_password_r.value;

				if ( mode != 'mod' )
				{
					if ( short_dobae_r.value == '' )
					{
						alert('도배방지키를 입력해주세요.');
						short_dobae_r.focus();
						return false;
					}

					Form_Obj.dobae_real.value			= document.getElementById('short_dobae_' + short_number).value;
				}
			}

			Form_Obj.short_comment_real.value	= short_comment_r.value;


			if ( short_number != 0 )
			{
				// 댓글에 댓글임
				Form_Obj.parent_number.value = short_number;
			}
			else
			{
				// 그냥 댓글임
				Form_Obj.parent_number.value = '';
			}

			Form_Obj.submit();
		}

		var comment_display_number = '';

		function show_reply_reply(short_number)
		{
			document.getElementById('reply_mod_' + short_number).style.display = 'none';
			comment_display_number = '';

			if ( comment_display_number != '' )
			{
				document.getElementById('reply_' + comment_display_number).style.display = 'none';
			}

			if ( comment_display_number == short_number )
			{
				document.getElementById('reply_' + short_number).style.display = 'none';
				comment_display_number = '';
			}
			else
			{
				document.getElementById('reply_' + short_number).style.display = '';
				comment_display_number = short_number;
			}
		}

		function show_reply_mod(short_number)
		{
			document.getElementById('reply_' + short_number).style.display = 'none';
			comment_display_number = '';

			if ( comment_display_number != '' )
			{
				document.getElementById('reply_mod_' + comment_display_number).style.display = 'none';
			}

			if ( comment_display_number == short_number )
			{
				document.getElementById('reply_mod_' + short_number).style.display = 'none';
				comment_display_number = '';
			}
			else
			{
				document.getElementById('reply_mod_' + short_number).style.display = '';
				comment_display_number = short_number;
			}
		}
-->
</script>


<form name='reply_add_form' action=bbs_short_comment.php?id=$_GET[id]&action=add method=post target='xiframe'>
<input type=hidden name=tb value=$tb>
<input type=hidden name=id value='$_GET[id]'>
<input type=hidden name=bbs_num value=$bbs_num>
<input type=hidden name=pg value=$pg>
<!-- 공지게시글 댓글 패치 2012-07-12 -->
<input type=hidden name=top_gonggi value=$top_gonggi_comment>
$댓글수정히든

<div class='short_comment_size' style='float:left;'>
	<textarea name='short_comment' id='short_comment_0' style='width:100%; height:71px;'></textarea>
</div>
<div style='float:right; width:130px;'>
	<a href='javascript:void(0);' class='h_btn_l icon_l h_btn_st1' uk-icon='icon:pencil; ratio:1' onClick='check_comment_form(0, document.reply_add_form)'>댓글쓰기</a>
</div>
<div style='clear:both;'></div>

$nomember_passform
</form>

END;

	$댓글쓰기폼_모바일 = <<<END
<script language='javascript'>
<!--

function memoLengthCheck(form,maxlen)
{
	var t;
	var msglen;
	msglen = 0;

	l = form.short_comment.value.length;
	for(k=0;k<l;k++){
	    if (msglen > maxlen ) {
			form.short_comment.focus();
			alert("입력 가능한 글자수를 초과했습니다.");
			return false;
	    }
	    t = form.short_comment.value.charAt(k);
	    if (escape(t).length > 4) msglen += 2;
	    else msglen++;
	}
}


		// 비회원일때 패스워드 스크립트
		function check_comment_form(short_number,mode)
		{
			var ismember = '$happy_member_login_value';
			var admin_check	= '$_COOKIE[ad_id]';


			Form_Obj		= document.reply_add_form;


			if ( mode == 'mod' )
			{
				short_comment_r		= document.getElementById('short_comment_mod_' + short_number);
				short_password_r	= document.getElementById('short_password_mod_' + short_number);
				short_dobae_r		= document.getElementById('short_dobae_mod_' + short_number);

				Form_Obj.action_real.value	= 'mod';
			}
			else
			{
				short_comment_r		= document.getElementById('short_comment_' + short_number);
				short_password_r	= document.getElementById('short_password_' + short_number);
				short_dobae_r		= document.getElementById('short_dobae_' + short_number);

				Form_Obj.action_real.value	= 'add';
			}


			if ( short_comment_r.value == '' )
			{
				alert('댓글을 입력해주세요.');
				short_comment_r.focus();
				return false;
			}

			if ( ismember == '' && admin_check	== '')
			{
				if ( short_password_r.value == '' )
				{
					alert('패스워드를 입력해주세요.');
					short_password_r.focus();
					return false;
				}

				Form_Obj.password_real.value		= short_password_r.value;

				if ( mode != 'mod' )
				{
					if ( short_dobae_r.value == '' )
					{
						alert('도배방지키를 입력해주세요.');
						short_dobae_r.focus();
						return false;
					}

					Form_Obj.dobae_real.value			= document.getElementById('short_dobae_' + short_number).value;
				}
			}

			Form_Obj.short_comment_real.value	= short_comment_r.value;


			if ( short_number != 0 )
			{
				// 댓글에 댓글임
				Form_Obj.parent_number.value = short_number;
			}
			else
			{
				// 그냥 댓글임
				Form_Obj.parent_number.value = '';
			}

			Form_Obj.submit();
		}

		var comment_display_number = '';

		function show_reply_reply(short_number)
		{
			document.getElementById('reply_mod_' + short_number).style.display = 'none';
			comment_display_number = '';

			if ( comment_display_number != '' )
			{
				document.getElementById('reply_' + comment_display_number).style.display = 'none';
			}

			if ( comment_display_number == short_number )
			{
				document.getElementById('reply_' + short_number).style.display = 'none';
				comment_display_number = '';
			}
			else
			{
				document.getElementById('reply_' + short_number).style.display = '';
				comment_display_number = short_number;
			}
		}

		function show_reply_mod(short_number)
		{
			document.getElementById('reply_' + short_number).style.display = 'none';
			comment_display_number = '';

			if ( comment_display_number != '' )
			{
				document.getElementById('reply_mod_' + comment_display_number).style.display = 'none';
			}

			if ( comment_display_number == short_number )
			{
				document.getElementById('reply_mod_' + short_number).style.display = 'none';
				comment_display_number = '';
			}
			else
			{
				document.getElementById('reply_mod_' + short_number).style.display = '';
				comment_display_number = short_number;
			}
		}
-->
</script>

<form name='reply_add_form' action=bbs_short_comment.php?id=$_GET[id] method=post target='xiframe'>
<input type=hidden name=tb value=$tb>
<input type=hidden name=id value='$_GET[id]'>
<input type=hidden name=bbs_num value=$bbs_num>
<input type=hidden name=pg value=$pg>
<!-- 공지게시글 댓글 패치 2012-07-12 -->
<input type=hidden name=top_gonggi value=$top_gonggi_comment>
<input type=hidden name=links_number value=$_GET[links_number]>
$댓글수정히든
	<div style='padding:10px;'>
		<div><textarea name='short_comment' id='short_comment_0' style='height:71px;' placeholder='댓글을 입력해주세요.'></textarea></div>
		$nomember_passform
		<div style='margin-top:5px;'><a href="javascript:void(0);" class="icon_m_100p h_btn_st1" uk-icon="icon:pencil; ratio:0.8" onClick="check_comment_form(0, 'add')" style='width:100%;'>댓글쓰기</a></div>
	</div>
<iframe name=xiframe id='xiframe' src='' width='0' height='0' marginwidth='0' marginheight='0' hspace='0' vspace='0' frameborder='0' scrolling='no' style='visibility:hidden; display:none;'></iframe>
</form>

END;

	$댓글쓰기폼.= "<iframe name=xiframe id='xiframe' src='' width='0' height='0' marginwidth='0' marginheight='0' hspace='0' vspace='0' frameborder='0' scrolling='no' style='visibility:hidden; display:none;'></iframe>";
	$댓글쓰기폼_모바일.= "<iframe name=xiframe id='xiframe' src='' width='0' height='0' marginwidth='0' marginheight='0' hspace='0' vspace='0' frameborder='0' scrolling='no' style='visibility:hidden; display:none;'></iframe>";
}

	#게시판의 list를 읽자

	#비공개(글잠금 글일때 댓글관련폼도 가리자 -hong)
	if ( $view_lock_chk == "no" )
	{
		$댓글쓰기폼 = "";
		$댓글 = "";
	}

	$현재위치 = "$prev_stand_bbs >  <a href=bbs_list.php?&id=$_GET[id]&tb=$tb>$B_CONF[board_name]</a> > 상세보기 ";

	//관리자일때 네이버블로그전송내용 작성
	if ( admin_secure('게시판관리') && is_file("$skin_folder/naver_blog_bbsdetail.html") !== false )
	{
		$TPL->define("네이버블로그전송내용", "$skin_folder/naver_blog_bbsdetail.html");
		$네이버블로그전송내용	= &$TPL->fetch('네이버블로그전송내용');
	}

	$master_check	= $master_check_original;
	//echo "$skin_folder_bbs/$B_CONF[board_temp_detail]";
	$TPL->define("게시판리스트", "$skin_folder_bbs/$B_CONF[board_temp_detail]");
	$내용 = &$TPL->fetch();




	#오늘날짜 뽀너스로 구하기
	setlocale (LC_TIME, "ko_KR.UTF-8");

	$매장매물갯수 = $numb;
	$투표내용 = vote_read();
	$오늘날짜 = strftime("%Y년 %b %d일(%a)");

	$메인주소 = $main_url;
	$현재카테고리 = $number_category;
	$투표내용 = vote_read();

	$TPL->define("전체", "$large_template");
	$TPL->assign("전체");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "Query Time : $exec_time sec";
	$TPL->tprint();

?>