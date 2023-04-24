<?

##### 페이스북 퍼가기

include ("./inc/config.php");
include ("./inc/function.php");

$tb						= $DB_Prefix.$_GET['tb'];
$bbs_num				= $_GET['bbs_num'];

$number					= $_GET['number'];
$com_info_id			= $_GET['com_info_id'];

$page_method			= $_GET['page_method'];

######################### 각 솔루션마다 변수설정 #########################

$facebook_config				= array();

if ( $page_method == 'com_info' )
{
	$facebook_config['title']		= "user_homepage";
	$facebook_config['comment']		= "message";
	$facebook_config['detail_url']	= "com_info.php?com_info_id=$com_info_id";
}
else if ( $page_method == 'guin_detail' )
{
	$facebook_config['title']		= "guin_title";
	$facebook_config['comment']		= "guin_main";
	$facebook_config['detail_url']	= "guin_detail.php?num=$number";
}
else if ( $page_method == 'document_view' )
{
	$facebook_config['title']		= "title";
	$facebook_config['comment']		= "title";
	$facebook_config['detail_url']	= "document_view.php?number=$number";
}

$facebook_config['img_arr']		= Array('img1','img2','img3','img4','img5');// 본문내 이미지가 없을경우 이미지 필드배열
##########################################################################

//모바일기기에서 접근시 referer 누락됨 패치
$is_mobile  = false;
$mobile_array = Array(
		'Windows CE; PPC','iPhone','lgtelecom',
		'IEMobile','BlackBerry','Android','Nokia',
		'SAMSUNG-SGH','SAMSUNG-SCH','iPod','iPad','mobile'
		);

foreach ( $mobile_array as $mobile_list )
{
	if ( preg_match("/{$mobile_list}/i",$_SERVER['HTTP_USER_AGENT']) )
	{
		$is_mobile  = true;
		happy_mobile_cookie($is_mobile);
		break;
	}
}
//모바일기기에서 접근시 referer 누락됨 패치

// 페이스북에서 넘어왔을 경우
// 페이지북 API 정말 안 좋은듯 -_-;
if ( strpos($_SERVER['HTTP_REFERER'], "facebook") !== false || $is_mobile)
{
	$url				= '';
	if ( $number != '' || $com_info_id != '' )
	{
		$url				= $facebook_config['detail_url'];
	}
	else
	{
		$url				= "bbs_detail.php?tb=$_GET[tb]&bbs_num=$bbs_num";
	}

	#echo $url;exit;

	echo "<META HTTP-EQUIV=refresh CONTENT=0;URL=$url>";
	exit;
}

$type					= '';
if ( $bbs_num != '' && $tb != '' )
{
	$sql				= "
							select
									*
							from
									$tb
							where
									number = '$bbs_num'
	";

	$board_info			= happy_mysql_fetch_array(query($sql));

	$facebook_info		= facebook_meta_make( $board_info, 'board' );
}
else if ( $number != '' || $com_info_id != '' )
{
	if ( $page_method == 'com_info' )
	{
		$sql			= "select * from $happy_member where user_id='$com_info_id'";
		$result			= query($sql);
		$detail_info	= happy_mysql_fetch_array($result);
	}
	else if ( $page_method == 'guin_detail' )
	{
		$sql			= "select * from $guin_tb where number='$number'";
		$result			= query($sql);
		$detail_info	= happy_mysql_fetch_array($result);
	}
	else if ( $page_method == 'document_view' )
	{
		$sql			= "SELECT * FROM $per_document_tb WHERE number='$number' ";
		$result			= query($sql);
		$detail_info	= happy_mysql_fetch_array($result);
		#print_r($detail_info);
	}

	$facebook_info		= facebook_meta_make( $detail_info, 'detail' );
}
else
{
	// 인자값 부족
}


echo "
<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title></title>

<meta property=\"og:site_name\" content=\"".$site_name."\"/>
<meta property=\"og:title\" content=\"".$facebook_info['f_title']."\"/>
<meta property=\"og:description\" content=\"".$facebook_info['f_book']."\"/>
<meta property=\"og:image\" content=\"".$facebook_info['f_img']."\"/>

</head>
<body>
</body>
</html>
";

exit;

function facebook_meta_make( $data_arr, $type )
{
	global $main_url, $img_url;
	global $tb, $bbs_num, $number;
	global $facebook_config;

	$facebook_info			= array();

	if ( $type == 'detail' )
	{
		$facebook_text_title	= $data_arr[$facebook_config['title']];
		$facebook_text_comment	= $data_arr[$facebook_config['comment']];

		// 본문이미지가 없을 경우 detail_img_arr 배열 참조(상세페이지의 경우)
		if ( $facebook_info['f_img'] == '' && $type == 'detail' )
		{
			foreach ( $facebook_config['img_arr'] as $value )
			{
				if ( $data_arr[$value] != "" )
				{
					$facebook_info['f_img']			= $img_url.'/'.$data_arr[$value];
					break;
				}
			}
		}
	}
	else
	{
		$facebook_text_title	= $data_arr['bbs_title'];
		$facebook_text_comment	= $data_arr['bbs_review'];
	}

	if ( $facebook_info['f_img'] == '' )
	{
		$sns_img				= array();
		preg_match_all("/<img[^>]*src=[\"']?([^>\"']+(.jp(g|eg)|.gif|.png))[\"']?[^>]*>/i", $facebook_text_comment, $sns_img);
		#print_r2($sns_img);
		$sns_img				= $sns_img[1];

		foreach ( $sns_img as $k => $v )
		{
			if ( !preg_match('/htt(p|ps):\/\//',$v, $matches) && $v != '' )
			{
				$facebook_info['f_img']	= $main_url.$v;
				break;
			}
		}
	}


	// 본문이미지가 없을 경우 bbs_etc6 컬럼 참조(게시판의 경우)
	if ( $facebook_info['img'] == '' && $type == 'board' && $data_arr['bbs_etc6'] != '' )
	{
		$facebook_info['f_img']		= "$main_url/data/$tb/$data_arr[bbs_etc6]";
	}


	$facebook_info['f_title']		= $facebook_text_title;
	$facebook_info["f_book"]  = preg_replace("#<script(.*?)>(.*?)</script>#is", "", $facebook_text_comment);
	$facebook_info['f_book']		= kstrcut(strip_tags($facebook_info["f_book"]), 200, '...');
	$facebook_info['f_book']		= str_replace("\r", "", $facebook_info['f_book']);
	$facebook_info['f_book']		= str_replace("\n", "", $facebook_info['f_book']);
	$facebook_info['f_book']		= str_replace(chr(13), "", $facebook_info['f_book']);


	return $facebook_info;
}
?>