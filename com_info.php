<?php
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	$현재위치	= " $prev_stand > <a href='guin_list.php'>채용정보</a> > <a href='com_info.php?com_info_id=$_GET[com_info_id]'>기업회원 정보보기</a>";


	if ( $_COOKIE["ad_id"] != "" )
	{
		$관리툴	= "
			<a href='admin/admin.php?a=com&mode=mod&num=$COM_INFO[number]' target='_blank'><img src='admin/img/bt_admin_board_mod.gif' border='0' align='absmiddle'></a>
			<a href='#1' onClick=\" if ( confirm('정말 삭제 하시겠습니까?') ){ window.location.href='admin/admin.php?a=com&mode=del_ok&num=$COM_INFO[number]&pg=1&pagechk=user'; } \"><img src='admin/img/bt_admin_board_del.gif' border='0' align='absmiddle'></a>
		";
	}


	//개인회원 정보
	$sql = "select * from $happy_member where user_id='$com_info_id'";
	//echo "$sql";
	$result = query($sql);
	$COM_INFO = happy_mysql_fetch_array($result);

	$COM_INFO['etc1'] = $COM_INFO['photo2'];
	$COM_INFO['etc2'] = $COM_INFO['photo3'];
	$COM_INFO['com_job'] = $COM_INFO['extra13'];
	$COM_INFO['com_profile1'] = nl2br($COM_INFO['message']);
	$COM_INFO['com_profile2'] = nl2br($COM_INFO['memo']);
	$COM_INFO['boss_name'] = $COM_INFO['extra11'];
	$COM_INFO['com_open_year'] = $COM_INFO['extra1'];
	$COM_INFO['com_worker_cnt'] = $COM_INFO['extra2'];
	$COM_INFO['com_zip'] = $COM_INFO['user_zip'];
	$COM_INFO['com_addr1'] = $COM_INFO['user_addr1'];
	$COM_INFO['com_addr2'] = $COM_INFO['user_addr2'];
	$COM_INFO['regi_name'] = $COM_INFO['extra12'];
	$COM_INFO['com_phone'] = $COM_INFO['user_hphone'];
	$COM_INFO['com_fax'] = $COM_INFO['user_fax'];
	$COM_INFO['com_email'] = $COM_INFO['user_email'];
	$COM_INFO['com_homepage'] = $COM_INFO['user_homepage'];

	$COM_INFO['com_jabon']	= ( !$COM_INFO['extra15'] )?"0":number_format($COM_INFO['extra15']);
	//$COM_INFO['com_maechul']	= ( !$COM_INFO['extra17'] )?"0":number_format($COM_INFO['extra17']);
	$COM_INFO['com_maechul']	= ( !$COM_INFO['extra17'] )?"0":money_type_change($COM_INFO['extra17'],'','억','만원','0','korea');
	$COM_INFO['history']		= nl2br($COM_INFO['extra18']);	//연혁 및 실적 (YOON : 2011-12-06)
	$COM_INFO['com_hopesize']	= $COM_INFO['extra19'];	//기업형태 - ranksa

	$naver_get_addr	= $COM_INFO['com_addr1'] ." ". $COM_INFO['com_addr2'];

	//채용정보 별로 저장된 데이터
	$guin_number = intval($_GET['guin_number']);
	if ( $hunting_use == true && $guin_number != 0 )
	{
		$COM_INFO_ORG = $COM_INFO;

		$sql = "select * from $guin_tb where number='$guin_number'";
		//echo "$sql";
		$result = query($sql);
		//사진2개, 우편번호, 주소
		$COM_INFO = happy_mysql_fetch_array($result);

		//회사정보 가져오기 - 2017-06-26 hong
		if ( $COM_INFO['company_number'] != '' )
		{
			$Sql = "SELECT * FROM $job_company WHERE number = '{$COM_INFO['company_number']}'";
			$COM_INFO2 = happy_mysql_fetch_array(query($Sql));
		}

		//각 개별 채용정보
		$COM_INFO['etc1'] = $COM_INFO['photo2'];
		$COM_INFO['etc2'] = $COM_INFO['photo3'];

		//회사정보 가져오기 - 2017-06-26 hong
		if ( $COM_INFO2['number'] != '' )
		{
			$COM_INFO['com_name']			= $COM_INFO2['company_name']; //업소명
			$COM_INFO['com_job']			= $COM_INFO2['company_type']; //업종
			$COM_INFO['boss_name']			= $COM_INFO2['present_name']; //대표자명
			$COM_INFO['com_open_year']		= $COM_INFO2['establish_year']; //설립년도
			$COM_INFO['com_worker_cnt']		= $COM_INFO2['worker_count']; //직원수
			$COM_INFO['com_profile1']		= $COM_INFO2['company_content']; //업소소개
			$COM_INFO['com_homepage']		= $COM_INFO2['homepage']; //홈페이지
			$COM_INFO['com_maechul']		= $COM_INFO2['sales_money']; //매출액
			$COM_INFO['com_hopesize']		= $COM_INFO2['company_shape'];	//기업형태
		}
		else
		{
			$COM_INFO['com_name']			= $COM_INFO_ORG['com_name']; //업소명
			$COM_INFO['com_job']			= $COM_INFO_ORG['com_job']; //업종
			$COM_INFO['boss_name']			= $COM_INFO_ORG['boss_name']; //대표자명
			$COM_INFO['com_open_year']		= $COM_INFO_ORG['com_open_year']; //설립년도
			$COM_INFO['com_worker_cnt']		= $COM_INFO_ORG['com_worker_cnt']; //직원수
			$COM_INFO['com_profile1']		= $COM_INFO_ORG['com_profile1']; //업소소개
			$COM_INFO['com_homepage']		= $COM_INFO_ORG['guin_homepage']; //홈페이지
		}

		$COM_INFO['com_zip'] = $COM_INFO['user_zip'];
		$COM_INFO['com_addr1'] = $COM_INFO['user_addr1'];
		$COM_INFO['com_addr2'] = $COM_INFO['user_addr2'];

		$COM_INFO['com_phone'] = $COM_INFO['guin_phone'];

		$naver_get_addr = $COM_INFO['com_addr1'] ." ". $COM_INFO['com_addr2'];

		$MEM["guzic_view"] = happy_member_option_get($happy_member_option_type,$member_id,'guzic_view');
		$MEM["guzic_view2"] = happy_member_option_get($happy_member_option_type,$member_id,'guzic_view2');
		$MEM["guzic_smspoint"] = happy_member_option_get($happy_member_option_type,$member_id,'guzic_smspoint');
		$MEM["guin_view"] = happy_member_option_get($happy_member_option_type,$member_id,'guin_view');
		$MEM["guin_view2"] = happy_member_option_get($happy_member_option_type,$member_id,'guin_view2');
		$MEM["guin_smspoint"] = happy_member_option_get($happy_member_option_type,$member_id,'guin_smspoint');

		#채용정보 열람권한
		$guin_view_numbers = array();
		if ( happy_member_secure($happy_member_secure_text[1].'보기') )
		{
			$guin_view_numbers = guin_view_numbers($mem_id);
		}

		$guin_view = false;
		$guin_view = guin_view($COM_INFO);
		#채용정보 열람권한

		$guin_view = true; //디자인팀 요청으로 정보 모두 오픈함 - 2018-01-22 hong
		if ( $demo_lock == '' ) //회사정보 가져오기 - 2017-06-26 hong
		{
			//echo var_dump($guin_view);
			if ( $guin_view == false )
			{
				$COM_INFO['guin_phone'] = "열람불가";
				$COM_INFO['guin_name'] = "열람불가";
				$COM_INFO['guin_fax'] = "열람불가";
				$COM_INFO['guin_homepage'] = "";
				$COM_INFO['guin_email'] = "";

				$COM_INFO['underground1'] = "열람불가";
				$COM_INFO['underground2'] = "";

				$COM_INFO['boss_name'] = "열람불가";
				$COM_INFO['com_open_year'] = "열람불가";
				$COM_INFO['com_worker_cnt'] = "열람불가";
				$COM_INFO['com_profile1'] = "열람불가";

				$COM_INFO['com_zip'] = "열람불가";
				$COM_INFO['com_addr1'] = "";
				$COM_INFO['com_addr2'] = "열람불가";
				$naver_get_addr = "열람불가";

				$COM_INFO['com_homepage'] = "열람불가";
			}
		}

	}
	//채용정보 별로 저장된 데이터


	#query("update $happy_member set user_addr1 = '대구 두류동', user_addr2='776-9번지'");


	if ( $COM_INFO[etc1] != "" && is_file("./$COM_INFO[etc1]") )
	{
		$logo_img = explode(".",$COM_INFO["etc0"]);
		$logo_temp = $logo_img[0]."_thumb.".$logo_img[1];

		$SNS_logo_temp = $main_url."/".$logo_temp;

		if ( file_exists ("./$logo_temp" ) )
		{
			$logo_temp = "<img src='./$logo_temp' border='0' align='absmiddle' width='$ComBannerDstW ' height='$ComBannerDstH '>";
		}
		else
		{
			$logo_temp = "<img src='./$COM_INFO[etc1]' border='0' align='absmiddle' width='$ComBannerDstW ' height='$ComBannerDstH '>";
		}
	}
	else
	{
		$logo_temp = "<img src='./img/logo_img.gif' border='0' align='absmiddle'>";
	}


	$COM_INFO[com_name_ori]	= $COM_INFO[com_name];
	$COM_INFO[com_name] = $COM_INFO[com_name]==''?"<font color='gray'>정보없음</font>":$COM_INFO[com_name];
	#홈페이지 주소에 http:// 만 있는 거는 정보없음이 나오도록 수정
	$tmp_homepage = str_replace("http://","",str_replace("https://","",$COM_INFO[com_homepage]));
	$COM_INFO[com_homepage] = $tmp_homepage==''?"<font color='gray'>정보없음</font>":"<a href='$COM_INFO[com_homepage]' style='color:#333;' target=top>$COM_INFO[com_homepage]</a>";
	$COM_INFO[com_job] = $COM_INFO[com_job]==''?"<font color='gray'>정보없음</font>":$COM_INFO[com_job];
	$COM_INFO[boss_name] = $COM_INFO[boss_name]==''?"<font color='gray'>정보없음</font>":$COM_INFO[boss_name];
	$COM_INFO[com_worker_cnt] = $COM_INFO[com_worker_cnt]==''?"<font color='gray'>정보없음</font>":$COM_INFO[com_worker_cnt]."명";
	$COM_INFO[com_open_year] = $COM_INFO[com_open_year]==''?"<font color='gray'>정보없음</font>":$COM_INFO[com_open_year]."년도";
	$COM_INFO[com_listed] = $COM_INFO[com_listed]==''?"<font color='gray'>정보없음</font>":$COM_INFO[com_listed];
	$COM_INFO[com_money] = $COM_INFO[com_money]==''?"<font color='gray'>정보없음</font>":$COM_INFO[com_money];
	$COM_INFO[com_sale_money] = $COM_INFO[com_sale_money]==''?"<font color='gray'>정보없음</font>":$COM_INFO[com_sale_money];
	$COM_INFO[com_phone] = $COM_INFO[com_phone]==''?"<font color='gray'>정보없음</font>":$COM_INFO[com_phone];
	$COM_INFO[com_fax] = $COM_INFO[com_fax]==''?"<font color='gray'>정보없음</font>":$COM_INFO[com_fax];
	$COM_INFO[main_item] = $COM_INFO[main_item]==''?"<font color='gray'>정보없음</font>":$COM_INFO[main_item];
	$COM_INFO[com_profile1] = $COM_INFO[com_profile1]==''?"<font color='gray'>정보없음</font>":$COM_INFO[com_profile1];
	$COM_INFO[com_profile2] = $COM_INFO[com_profile2]==''?"<font color='gray'>정보없음</font>":$COM_INFO[com_profile2];
	$COM_INFO[com_type] = $COM_INFO[com_type]==''?"<font color='gray'>정보없음</font>":$COM_INFO[com_type];

	//채용정보수 출력
	$type_search = "";
	if ( $hunting_use == true && $guin_number != 0 )
	{
		if ( $COM_INFO2['number'] != "" )
		{
			$type_search = " AND company_number = '$COM_INFO2[number]' ";
		}
	}
	$Sql = "SELECT COUNT(*) FROM $guin_tb WHERE guin_id = '$com_info_id' {$type_search} and (guin_end_date >= curdate() or guin_choongwon ='1')";
	list($회사채용정보수) = happy_mysql_fetch_array(query($Sql));

	#쪽지기능추가됨
	$쪽지보내기 = "<a href='#' onclick=\"window.open('happy_message.php?mode=send&receiveid=".$_GET['com_info_id']."','happy_message_send','width=730,height=610,toolbar=no,scrollbars=no');\"><img src='./img/btn_message.gif' align='absmiddle' alt='쪽지보내기' border='0'></a>";

/*
	$twitter						= array();
	$twitter["text"]				= preg_replace("#<script(.*?)>(.*?)</script>#is", "", $COM_INFO['user_homepage']);
	$twitter['text']				= kstrcut(strip_tags($twitter["text"]), 100, '...');
	if ($server_character == 'euckr' || $server_character == '')
	{
		$twitter['text']				= iconv("euc-kr" , "UTF-8",$twitter['text']);
	}

	$twitter['text']				= urlencode($twitter['text']);
	$twitter['original_referer']	= urlencode("$main_url/$_SERVER[REQUEST_URI]");
	$twitter['url']					= "$main_url/$_SERVER[REQUEST_URI]";
	$twitter['return_to']			= "/intent/tweet?original_referer=$twitter[original_referer]&text=$twitter[text]&tw_p=tweetbutton&url=$twitter[url]";

	$tweeter_url					= "https://twitter.com/intent/tweet";
	$tweeter_url					.= "?original_referer=".$twitter['original_referer'];
	$tweeter_url					.= "&return_to=".$twitter['return_to'];
	$tweeter_url					.= "&text=".$twitter['text'];
	$tweeter_url					.= "&url=".$twitter['url'];
	$tweeter_url					= "<a href='$tweeter_url' target='_blank' onfocus='blur();'><img src='img/sns_icon/icon_twitter.png' align='absmiddle' border='0' alt='트위터로 보내기' class='png24'></a>";
	##################### tweeter 를 위한 API : 2010.11.1 NeoHero ####################
*/

	#################### tweeter 를 위한 API : 2010.11.1 NeoHero ####################
	$tweet_text				= htmlspecialchars(str_replace("'","",$COM_INFO2['company_name']));
	//사진을 추출할 본문
	$tweet_img_text			= $COM_INFO2['company_content'];
	//상세페이지URL twrand 를 추가한것은 트위터가 캐싱을 해서
	$tweet_url				= "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&twrand=".rand(1,10000);
	//작성자명
	$tweet_writer			= "";

	//클릭이벤트
	$onclicktweet			= 'sns_tweet(\''.$tweet_url.'\',\''.$tweet_text.'\');';

	$tweeter_url = "<a href='javascript:void(0);' onclick=\"".$onclicktweet."\" onfocus='blur();'><img src='img/sns_icon/icon_twitter.png' align='absmiddle' border='0' alt='트위터로 보내기' width='23' height='23' class='png24'></a>";
	$tweeter_url .= '<script>';
	$tweeter_url .= 'function sns_tweet(url,title)';
	$tweeter_url .= '{';
	$tweeter_url .= 'popupURL = \'https://twitter.com/intent/tweet?text=\'+encodeURIComponent(title)+\'&url=\'+encodeURIComponent(url);';
	$tweeter_url .= 'popOption = "width=350, height=500, resizable=no, scrollbars=no, status=no;";';
	$tweeter_url .= 'window.open(popupURL,"pop",popOption);';
	$tweeter_url .= '}';
	$tweeter_url .= '</script>';

	//사진 찾기
	if ( $COM_INFO['etc1'] != "" )
	{
		$tweet_img_src			= $main_url."/".$COM_INFO['etc1']."?".rand(111111,999999);
	}
	//다른 솔루션과 다르게 본문이라는 개념이 없기 때문에 본문 이미지 찾기 기능은 없음을 유의.

	$tweeter_meta  = '<meta name="twitter:card"           content="summary_large_image">'."\n";
	$tweeter_meta .= '<meta name="twitter:site"           content="'.$site_name.'">'."\n";
	$tweeter_meta .= '<meta name="twitter:title"          content="'.$tweet_text.'">'."\n";
	$tweeter_meta .= '<meta name="twitter:creator"        content="'.$tweet_writer.'">'."\n";
	$tweeter_meta .= '<meta name="twitter:image"          content="'.$tweet_img_src.'">'."\n";
	$tweeter_meta .= '<meta name="twitter:description"    content="'.kstrcut(strip_tags($tweet_img_text),100,"..").'">'."\n";
	##################### tweeter 를 위한 API : 2010.11.1 NeoHero ####################

	$meta_url	= $main_url.'/com_info.php?com_info_id='.$_GET[com_info_id].'&guin_number='.$COM_INFO[number];
	$default_meta	= '<meta property="og:title"		content="'.$tweet_text.'"/>'."\n";
	$default_meta	.= '<meta property="og:type"		content="website"/>'."\n";
	$default_meta	.= '<meta property="og:url"			content="'.$meta_url.'"/>'."\n";
	$default_meta	.= '<meta property="og:image"		content="'.$tweet_img_src.'"/>'."\n";
	$default_meta	.= '<meta property="og:description"	content="'.kstrcut(strip_tags($tweet_img_text),100,"..").'"/>'."\n";
	$default_meta	.= '<meta property="og:author"		content="'.$COM_INFO2[take_person].'"/>'."\n";


	#facebook 를 위한 API : 2012.04.30  NeoHero
	$facebook_p_url	= urlencode("$main_url/facebook_scrap.php?com_info_id=$_GET[com_info_id]&page_method=com_info");
	$facebook_url	= "<a href='javascript:void(0);'><img src='img/sns_icon/icon_facebook.png' align='absmiddle' style='cursor:pointer' onclick=\"window.open('https://www.facebook.com/sharer/sharer.php?sdk=joey&u=$facebook_p_url','facebook_scrap','width=640,height=460');\" /></a>";
	#facebook 를 위한 API : 2012.04.30  NeoHero

	$C공감 = cyword_scrap('detail');


	#me2day 를 위한 API : 2010.11.1 NeoHero
	$me2day_text_u = "\"$main_url/com_info.php?com_info_id=$_GET[com_info_id]\":$main_url/com_info.php?com_info_id=$_GET[com_info_id]";
	$me2day_text_t = "$COM_INFO[com_name]";
	if ($server_character == 'euckr'){
		$me2day_text_u = iconv("euc-kr" , "UTF-8",$me2day_text_u);
		$me2day_text_t = iconv("euc-kr" , "UTF-8",$me2day_text_t);
	}
	$me2day_text_u = urlencode($me2day_text_u);
	$me2day_text_t = urlencode($me2day_text_t);
	$me2day_url = "<a href='http://me2day.net/posts/new?new_post[body]=$me2day_text_u&new_post[tags]=$me2day_text_t' target=_blank onfocus='blur();'><img src=img/sns_icon/icon_me2day.png align=absmiddle border=0 alt='미투데이로 보내기'></a>";
	#me2day  를 위한 API : 2010.11.1 NeoHero
	//2011-05-16 HYO end 트위터, 페이스북, 미투데이 추가

	//관리자일때 네이버블로그전송내용 작성
	if ( admin_secure('슈퍼관리자전용') && is_file("$skin_folder/naver_blog_cominfo.html") !== false )
	{
		$TPL->define("네이버블로그전송내용", "$skin_folder/naver_blog_cominfo.html");
		$네이버블로그전송내용	= &$TPL->fetch('네이버블로그전송내용');
	}

	$TPL->define("알맹이", "./$skin_folder/com_info_popup.html");
	$TPL->assign("알맹이");
	$내용 = &$TPL->fetch();

	$TPL->define("껍데기", "$skin_folder/default_cominfo.html");
	$TPL->assign("껍데기");
	echo $TPL->fetch();


?>