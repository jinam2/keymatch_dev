<?PHP
/********************************************************
*														*
*	CREATED BY Hun ON 2105-12-23						*
*	Copyright 1997 cgimall All rights reserved			*
*														*
********************************************************/

include ("../../../inc/config.php");

//HAPPY_CONFIG 불러오기위해
$DB_Prefix						= "";

$dbconn = @mysql_connect( $db_host, $db_user, $db_pass);
@mysql_select_db( $db_name, $dbconn);

function happy_config_loading_editor()
{
	global $DB_Prefix;
	global $dbconn;
	global $HAPPY_CONFIG;

	switch ( $_COOKIE['pensions_user_skin_change'] )
	{
		case '3' :	$happy_config	= $DB_Prefix.'happy_config_3'; break;
		case '2' :	$happy_config	= $DB_Prefix.'happy_config_2'; break;
		case '1' :	$happy_config	= $DB_Prefix.'happy_config_1'; break;
		default :	$happy_config	= $DB_Prefix.'happy_config'; break;
	}

	$Sql	= "SELECT * FROM $happy_config ORDER BY conf_name ASC";
	$Record	= mysql_query($Sql);

	while ( $Value = happy_mysql_fetch_array($Record) )
	{
		if ( $Value['conf_out_type'] == 'array' )
		{
			$Value['conf_value']	= explode(",",$Value['conf_value']);
		}
		else if ( $Value['conf_out_type'] == 'nl2br' )
		{
			$Value['conf_value']	= nl2br($Value['conf_value']);
		}

		if ( $HAPPY_CONFIG[$Value['conf_name']] == "" )
		{
			$HAPPY_CONFIG[$Value['conf_name']]	= $Value['conf_value'];
		}

		global ${$Value['conf_name']};
		if ( ${$Value['conf_name']} == "" )
		{
			${$Value['conf_name']}				= $Value['conf_value'];
		}
	}

	return $HAPPY_CONFIG;
}
$HAPPY_CONFIG = happy_config_loading_editor();

//HAPPY_CONFIG 불러오기위해


#############################################################
#															#
#	happy_module에서 사용할 공통설정 입니다.				#
#															#
#############################################################
$relative_path				= ".".preg_replace("`\/[^/]*\.php$`i", "/", $_SERVER['PHP_SELF']);	//경로 가져오기.
$ext_check					= 'ok';
$img_main_url				= $wys_url;																//위지윅이 설치된 경로,설치폴더 예를들어 /news 폴더 하부에 설치가 되어 있는 경우 "/news" 로 지정


#############################################################
#															#
#	이미지 업로드 설정										#
#															#
#############################################################
$file_attach_folder			= "wys2/file_attach";												//업로드 폴더 지정
$file_attach_thumb_folder	= "wys2/file_attach_thumb";										//썸네일 업로드 폴더 지정

$logo_file					= '../../../upload/happy_config/logo.png';							//로고파일 위치
$access_ext					= Array('jpg', 'gif', 'jpeg', 'png');								//업로드 가능 이미지 확장자

$default_image_width		= 970;																//기본 썸네일 가로크기
$default_image_height		= 970;																//기본 썸네일 세로크기

# 자동 썸네일 이미지 생성 (별도생성)
$small_image_make			= '';																//썸네일 이미지 자동생성 기능 사용유무(사용시 $file_attach_thumb_folder 폴더에 작은 썸네일 업로드 됨)
$small_image_width			= 200;
$small_image_height			= 140;
$small_image_quality		= 100;
$small_image_type			= '가로기준';
$small_image_position		= 2;
$image_upload_gif			= "gif애니메이션원본출력";											//gif원본출력 은 모든 GIF 파일은 원본 그대로 출력함 , gif썸네일 은 모든 GIF 파일은 썸네일을 생성하여 출력함 , gif애니메이션원본출력 은 GIF 파일중 애니메이션 효과가 있을 경우에만 원본을 출력함.

$jaego_attach_folder		= "../../../$file_attach_folder";
$thumb_jaego_attach_folder	= "../../../$file_attach_thumb_folder";


#############################################################
#															#
#	멀티 이미지 업로드 설정									#
#															#
#############################################################
$swf_attach_folder			= "../../../wys2/swf_upload";
$path						= "../../../wys2/swf_upload";
$fileUrl					= str_replace("//","/","$wys_url/wys2/swf_upload");
$upFolder_name				= "../../../wys2/swf_upload/tmp";
//$gi_joon_ihc = "560";
$width_gi_joon				= 970;
$height_gi_joon				= 970;
$thumb_type					= '가로기준';
$picture_quailty			= 94;
$swf_logo_file				= '../../../upload/happy_config/logo.png';						//로고파일 위치		파일명일 입력하면 썸네일에 로고 추가됨.
$swf_logo_position			= 9;																//1 좌측상단 , 2 중앙상단 , 3 우측상단 , 4 좌측중앙 , 5 중앙 , 6 우측중앙 , 7 좌측하단, 8 중앙하단, 9 우측하단
$allow_filetype				= '*.jpg *.jpeg *.gif *.png';										//선택가능한 파일확장자. IE11 이하버젼에서만 적용되는 옵션입니다.
$multi_image_upload_gif		= "gif애니메이션원본출력";											//gif원본출력 은 모든 GIF 파일은 원본 그대로 출력함 , gif썸네일 은 모든 GIF 파일은 썸네일을 생성하여 출력함 , gif애니메이션원본출력 은 GIF 파일중 애니메이션 효과가 있을 경우에만 원본을 출력함.

#############################################################
#															#
#	HTML5 멀티업로드 추가 설정								#
#															#
#############################################################
$FILE_UPLOAD_SIZE			= 10;			//10MB
$FILE_MAX_COUNT				= 20;			//20개
$swf_attach_folder			= "../../../wys2/swf_upload";
$path						= "wys2/swf_upload";												//에디터 전달용도로 사용하기 위한 변수.
$fileUrl					= str_replace("//","/","$wys_url/wys2/swf_upload");
$upFolder_name				= "../../../wys2/swf_upload/tmp";
//$gi_joon_ihc = "560";
$width_gi_joon				= 1200;
$height_gi_joon				= 700;
$width_gi_joon_thumb		= 156;
$height_gi_joon_thumb		= 100;
$thumb_type					= '비율대로확대';
$img_type					= '가로기준';
$picture_quailty			= 100;
$picture_quality			= $picture_quailty; //변수 호환 hong
//$swf_logo_file				= '../../../upload/happy_config/logo.png';						//로고파일 위치		파일명일 입력하면 썸네일에 로고 추가됨.
$swf_logo_position			= 9;																//1 좌측상단 , 2 중앙상단 , 3 우측상단 , 4 좌측중앙 , 5 중앙 , 6 우측중앙 , 7 좌측하단, 8 중앙하단, 9 우측하단
$allow_filetype				= '*.jpg *.jpeg *.gif *.png';										//선택가능한 파일확장자. IE11 이하버젼에서만 적용되는 옵션입니다.
$multi_image_upload_gif		= "gif애니메이션원본출력";											//gif원본출력 은 모든 GIF 파일은 원본 그대로 출력함 , gif썸네일 은 모든 GIF 파일은 썸네일을 생성하여 출력함 , gif애니메이션원본출력 은 GIF 파일중 애니메이션 효과가 있을 경우에만 원본을 출력함.

#############################################################
#															#
#	유투브 설정은 설정할께 없음								#
#															#
#############################################################
#############################################################
#															#
#	네이버지도 설정											#
#															#
#############################################################
$naver_key						= $HAPPY_CONFIG['naver_key'];
$naver_secret_key				= $HAPPY_CONFIG['naver_secret_key'];


$naver_map_default_width		= "550";
$naver_map_default_height		= "400";
$naver_map_default_zoom			= "8";
$naver_map_enableWheelZoom		= "true";				//마우스 휠을 이용한 지도확대				true / false
$naver_map_enableDragPan		= "true";				//마우스 클릭 드래그를 통한 지도 이동		true / false
$naver_map_enableDblClickZoom	= "true";				//마우스 더블 클릭을 통한 지도 확대			true / false
$naver_map_default_mapMode		= "0";					//0 일반지도 , 1 겹침지도 , 2 위성지도		0 / 1 / 2
$naver_map_default_activateTrafficMap= "false";			//실시간 교통지도 활성화/비활성화 옵션		true / false
$naver_map_default_activateBicycleMap= "false";			//자전거 지도 활성화/비활성화 옵션			true / false
$naver_map_default_minLevel		= 1;					//지도의 최소 축적레벨						1 / 14
$naver_map_default_MaxLevel		= 14;					//지도의 최대 축적레벨						1 / 14

$naver_map_BicycleGuide_use		= 'true';				//자전거 범례 활성화/비활성화				true / false
$naver_map_TrafficGuide_use		= 'true';				//교통 범례 활성화/비활성화					true / false
$naver_map_ZoomControl_use		= 'true';				//지도확대 컨트롤러 활성화/비활성화			true / false

$naver_map_mark_img_array		= array(
											"images/mark_ico01.png",
											"images/mark_ico02.png",
											"images/mark_ico03.png",
											"images/mark_ico04.png",
											"images/mark_ico05.png",
											"images/mark_ico06.png",
											"images/mark_ico07.png",
											"images/mark_ico08.png",
											"images/mark_ico09.png",
											"images/mark_ico10.png",
											"images/mark_ico_def.png"
								);
$naver_map_default_search_arr	= Array(
											"Cgimall",
											"관광",
											"해수욕장",
								);

#############################################################
#															#
#	다음지도 설정											#
#															#
#############################################################
$daum_key							= $HAPPY_CONFIG['daum_key'];
$daum_local_key						= $HAPPY_CONFIG['daum_local_key'];

$daum_map_default_width				= "400";
$daum_map_default_height			= "400";
$daum_map_default_level				= "13";
$daum_map_default_lat				= "35.8557070";
$daum_map_default_lng				= "128.5721620";

$daum_map_draggable					= true;				//마우스 클릭 드래그를 통한 지도 이동		true / false
$daum_map_scrollwheel				= true;				//마우스 휠을 이용한 지도확대				true / false
$daum_map_disableDoubleClickZoom	= false;			//마우스 더블클릭 확대 기능 막기 여부		true / false
$daum_map_minLevel					= 1;				//지도의 최소 축적레벨						1 / 14
$daum_map_maxLevel					= 14;				//지도의 최대 축적레벨						1 / 14

$daum_map_mark_img_array		= array(
										0	=> "images/mark_ico01.png",
										1	=> "images/mark_ico02.png",
										2	=> "images/mark_ico03.png",
										3	=> "images/mark_ico04.png",
										4	=> "images/mark_ico05.png",
										5	=> "images/mark_ico06.png",
										6	=> "images/mark_ico07.png",
										7	=> "images/mark_ico08.png",
										8	=> "images/mark_ico09.png",
										9	=> "images/mark_ico10.png",
										10	=> "images/mark_ico_def.png"
								);
$daum_map_mark_width_array		= Array(
										0	=> '24',
										1	=> '24',
										2	=> '24',
										3	=> '24',
										4	=> '24',
										5	=> '24',
										6	=> '24',
										7	=> '24',
										8	=> '24',
										9	=> '24',
										10	=> '24'
								);

$daum_map_mark_height_array		= Array(
										0	=> '24',
										1	=> '24',
										2	=> '24',
										3	=> '24',
										4	=> '24',
										5	=> '24',
										6	=> '24',
										7	=> '24',
										8	=> '24',
										9	=> '24',
										10	=> '24'
								);

$daum_map_default_search_arr	= Array(
											"Cgimall",
											"관광",
											"해수욕장",
								);

#############################################################
#															#
#	텍스트 이미지 설정										#
#															#
#############################################################

$HAPPY_IMGMAKER_IMG_TYPE			= ARRAY(															//생성하길 원하는 이미지 타입 JPG, GIF, PNG 만 가능하며 다른 타입은 생성불가.
												"JPG",
												"GIF",
												"PNG"
									);


$HAPPY_IMGMAKER_FONT_TYPE			= ARRAY(															//FONT 의 종류를 설정하는 배열 입니다. FONT 를 추가하길 원하실 경우 솔루션이 설치된 폴더의 font 폴더에 TTF 폰트파일을 업로드 하신 후 아래의 배열에 폰트 종류를 추가

												"나눔고딕EB"		=>"NanumGothicExtraBold",
												"나눔명조B"			=>"NanumMyeongjoBold",
												"나눔펜"			=>"NanumPen",
												"나눔손글씨"		=>"NanumBrush",
												"나눔고딕"			=>"NanumGothic",
												"나눔고딕B"			=>"NanumGothicBold",
												"나눔명조"			=>"NanumMyeongjo",
												"나눔명조B"			=>"NanumMyeongjoExtraBold",
												"서울한강B"			=>"SeoulHangangB",
												"서울한강L"			=>"SeoulHangangL",
												"서울한강EB"		=>"SeoulHangangEB",
												"서울한강M"			=>"SeoulHangangM",
												"서울남산B"			=>"SeoulNamsanB",
												"서울남산L"			=>"SeoulNamsanL",
												"서울남산vert"		=>"SeoulNamsanvert",
												"서울남산EB"		=>"SeoulNamsanEB",
												"서울남산M"			=>"SeoulNamsanM",
												"제주고딕"			=>"JejuGothic",
												"제주한라산"		=>"JejuHallasan",
												"arial"			=>"arial"
									);
$HAPPY_IMGMAKER_DEFAULT_FONT_TYPE	= 'NanumGothicExtraBold';										//기본선택 되어질 폰트
$HAPPY_IMGMAKER_DEFAULT_QUALITY		= 94;																//이미지의 기본 퀄리티
$HAPPY_IMGMAKER_DEFAULT_WIDEE		= 200;																//생성될 이미지 기본 가로크기
$HAPPY_IMGMAKER_DEFAULT_HEIGHT		= 30;																//생성될 이미지 기본 세로크기
$HAPPY_IMGMAKER_DEFAULT_FONT_SIZE	= 15;																//글자 기본 크기
$HAPPY_IMGMAKER_DEFAULT_FONT_COLOE	= '25,25,25';														//글자 기본 색상
$HAPPY_IMGMAKER_DEFAULT_FONT_BGCOLOR= '255,255,255';													//글자 기본 배경색상


#############################################################
#															#
#	함수 모음												#
#															#
#############################################################
/*		오류시 경고창 뛰우기 위한 함수		*/
function msg($msg)
{
	print <<<END
	<script>
		alert("$msg");
	</script>
END;
	exit;
}
function upload_btn_replay()
{
	print <<<END
	<script>
		parent.image_upload_submit_no();
	</script>
END;

}
/*		썸네일 생성 함수		*/
function imageUploadNew($img_name, $img_name_new, $gi_joon, $height_gi_joon, $picture_quality, $thumbType="", $thumbPosition="", $logo="", $logoPosition="" )
{
	# 사용법
	# imageUploadNew(원본파일네임, 생성할파일네임, 가로크기, 세로크기, 품질, 썸네일추출타입, 썸네일생성포지션, 로고파일명, 로고포지션)
	# $path는 홈디렉토리의 pwd
	global $ext_check;

	$thumbPosition	= preg_replace("/\D/","",$thumbPosition);
	$logoPosition	= preg_replace("/\D/","",$logoPosition);

	$img_url_re		= $img_name_new;
	$image_top		= 0;
	$image_left		= 0;

	#확장자 체크
	$img_names		= explode(".",$img_name);
	$img_ext		= strtolower($img_names[sizeof($img_names)-1]);

	#단순파일확장자 체크
	if ( $img_ext != 'jpg' && $img_ext != 'jpeg' && $img_ext != 'png' && $img_ext != 'gif' && $ext_check != 'ok' )
	{
		error("사용할수 없는 확장자 입니다.");
	}

	#기존 이미지를 불러와서 사이즈 체크
	$imagehw		= GetImageSize("$img_name");
	$imagewidth		= $imagehw[0];
	$imageheight	= $imagehw[1];

	#원본이미지타입
	#1:gif,2:jpg,3:png
	$src_type = $imagehw[2];

	if ( $src_type == "1" )
	{
		$img_ext = "gif";
	}
	else if ( $src_type == "2" )
	{
		$img_ext = "jpg";
	}
	else if ( $src_type == "3" )
	{
		$img_ext = "png";
	}
	#원본이미지타입


	$new_width		= $height_gi_joon * $imagewidth / $imageheight ;
	$new_width		= ceil($new_width);
	$new_height		= $gi_joon * $imageheight / $imagewidth ;
	$new_height		= ceil($new_height);

	$width_per	= $imagewidth / $gi_joon;
	$height_per	= $imageheight / $height_gi_joon;

	#썸네일 생성 방법별
	if ( $thumbType == '비율대로짜름' )
	{
		if ( $width_per < $height_per ) {
			$gi_joon		= $new_width;
		}
		else {
			$height_gi_joon	= $new_height;
		}
	}
	else if ( $thumbType == '비율대로축소' )
	{
		$thumbType	= ( $width_per > $height_per )? '가로기준세로짜름' : '세로기준가로짜름';
	}
	else if ( $thumbType == '비율대로확대' )
	{
		$thumbType	= ( $width_per > $height_per )? '세로기준가로짜름' : '가로기준세로짜름';
	}

	switch( $thumbType )
	{
		case "가로기준세로짜름" :
									$new_width	= $gi_joon;
									break;
		case "세로기준가로짜름" :
									$new_height	= $height_gi_joon;
									break;
		case "가로기준" :
									if ( $imagewidth < $gi_joon )
									{
										#echo "$gi_joon - $imageheight <br> ";
										$new_width		= $imagewidth;
										$new_height		= $imageheight;
										$gi_joon		= $imagewidth;
										$height_gi_joon	= $imageheight;
									}
									else
									{

										$new_width		= $gi_joon;
										$new_height		= $imageheight / $width_per;
										$height_gi_joon	= $new_height;
									}
									break;
		case "세로기준" :
									if ( $imageheight < $height_gi_joon )
									{
										$new_width		= $imagewidth;
										$new_height		= $imageheight;
										$gi_joon		= $imagewidth;
										$height_gi_joon	= $imageheight;
									}
									else
									{
										$new_width		= $imagewidth / $height_per;
										$gi_joon		= $new_width;
										$new_height		= $height_gi_joon;
									}
									break;
		default :
									$new_width	= $gi_joon;
									$new_height	= $height_gi_joon;
									break;
	}

	#썸네일 추출 위치 ( 가로기준 , 세로기준에만 해당 )
	if ( $thumbType == '가로기준세로짜름' && $thumbPosition != '' && $new_height > $height_gi_joon )
	{
		if ( $thumbPosition == '2' )
		{
			$image_top	= $imageheight * ( ( ( $new_height - $height_gi_joon ) / 2 ) / $new_height );
		}
		else if ( $thumbPosition == '3' )
			$image_top	= $imageheight * ( ( $new_height - $height_gi_joon ) / $new_height );
	}
	else if ( $thumbType == '세로기준가로짜름' && $thumbPosition != '' && $new_width > $gi_joon )
	{
		if ( $thumbPosition == '2' )
			$image_left	= $imagewidth * ( ( ( $new_width - $gi_joon ) / 2 ) / $new_width );
		else if ( $thumbPosition == '3' )
			$image_left	= $imagewidth * ( ( $new_width - $gi_joon ) / $new_width );
	}
	#echo "$image_left - $image_top <br> ";



	#배경잡고
	$thumb			= ImageCreate($gi_joon,$height_gi_joon);
	$thumb			= imagecreatetruecolor($gi_joon,$height_gi_joon);
	$white			= imagecolorallocate($thumb, 255, 255, 255);
	imagefilledrectangle ($thumb,0,0,$gi_joon,$height_gi_joon,$white);


	if ( $img_ext == 'png' ) {
		$src		= ImageCreateFromPng("$img_name");
	}
	else if (  $img_ext == 'gif' ) {
		$src		= ImageCreateFromGif("$img_name");
	}
	else {
		$src		= ImageCreateFromJPEG("$img_name");
	}
	imagecopyresampled($thumb,$src,0,0,$image_left,$image_top,$new_width,$new_height,$imagewidth,$imageheight);

	global $IMAGE;
	$IMAGE['WIDTH']				= $new_width;
	$IMAGE['HEIGHT']			= $new_height;

	#일단 쪼끄만거부터 맹글자
	if ( $img_ext == 'png' ) {
		$phpver=phpversion();$phpver=$phpver[0];$picture_quality = ($picture_quality>9&&$phpver>4)?round($picture_quality/11):$picture_quality; ImagePNG($thumb,"$img_name_new",$picture_quality);
	}
	else if (  $img_ext == 'gif' ) {
		Imagegif($thumb,"$img_name_new",$picture_quality);
	}
	else {
		ImageJPEG($thumb,"$img_name_new",$picture_quality);
	}

	#로고작업
	if ( $logo != "" )
	{
		$logo			= ImageCreateFromPng("$logo");
		$logo_width		= imagesx($logo);
		$logo_height	= imagesy($logo);

		$logo_left	= 0;
		$logo_top	= 0;

		#로고 포지션 잡기
		switch( $logoPosition )
		{
			case "1":	break;
			case "2":
						$logo_left	= ($gi_joon/2) - ($logo_width/2);
						break;
			case "3":
						$logo_left	= $gi_joon - $logo_width;
						break;
			case "4":
						$logo_top	= ($height_gi_joon/2) - ($logo_height/2);
						break;
			case "5":
						$logo_left	= ($gi_joon/2) - ($logo_width/2);
						$logo_top	= ($height_gi_joon/2) - ($logo_height/2);
						break;
			case "6":
						$logo_left	= $gi_joon - $logo_width;
						$logo_top	= ($height_gi_joon/2) - ($logo_height/2);
						break;
			case "7":
						$logo_top	= $height_gi_joon - $logo_height;
						break;
			case "8":
						$logo_left	= ($gi_joon/2) - ($logo_width/2);
						$logo_top	= $height_gi_joon - $logo_height;
						break;
			case "9":
						$logo_left	= $gi_joon - $logo_width;
						$logo_top	= $height_gi_joon - $logo_height;
						break;
			default:
						$logo_top	= $height_gi_joon-$logo_height;
						break;
		}

		imagecopy($thumb,$logo,$logo_left,$logo_top,0,0,$logo_width,$logo_height);
		//ImageJPEG($thumb,"$img_name_new",$picture_quality);
		if ( $img_ext == 'png' ) {
			/*imagepng()함수 PHP5 패치 by kwak16*/$phpver=phpversion();$phpver=$phpver[0];$picture_quality = ($picture_quality>9&&$phpver>4)?round($picture_quality/11):$picture_quality; ImagePNG($thumb,"$img_name_new",$picture_quality);
		}
		else if (  $img_ext == 'gif' ) {
			Imagegif($thumb,"$img_name_new",$picture_quality);
		}
		else {
			ImageJPEG($thumb,"$img_name_new",$picture_quality);
		}
		ImageDestroy($logo);
	}

	ImageDestroy($thumb);

	return $img_url_re;
}

/*		애니메이션 GIF 인지 체크하는 함수		*/
function is_animation($filename) {
	if(!($fh = @fopen($filename, 'rb')))
		return false;
	$count = 0;
	while(!feof($fh) && $count < 2) {
		$chunk = fread($fh, 1024 * 100); //read 100kb at a time
		$count += preg_match_all('#\x00\x21\xF9\x04.{4}\x00[\x2C\x21]#s', $chunk, $matches);
	}
	fclose($fh);
	return $count > 1;
}


/*		결과값을 에디터에게 전달하기 위해 		*/
function make_image_upload_tag($IMAGE)
{
	$width_style = "";
	$height_style = "";
	$print_org_link1 = "";
	$print_org_link2 = "";
	$MAKE_IMAGE_TAG = "";
	global $wys_url;

	if( $_POST['print_org'] == 'y' )
	{
		if ( $IMAGE['WIDTH'] != "" )
		{
			if ( $_POST['print_org_maxwidth'] <= $IMAGE['WIDTH'] )
			{
				$url = $wys_url.'/bbs_close_img.php?file_name='.$IMAGE['FILE_PATH'];
				$rand = mktime();
				$print_org_link1 = '<a href=\"'.$url.'\" target=\"_BLANK'.$rand.'\">';
				$print_org_link2 = '</a>';
				//$width_style					= "width:".$_POST['print_org_maxwidth']."px;";
				//$width_style					= "width:".$IMAGE['WIDTH']."px;";
			}
			else
			{
				//$width_style					= "width:".$IMAGE['WIDTH']."px;";
			}
			//$height_style					= ( $IMAGE['HEIGHT'] != '' ) ? "height: ".$IMAGE['HEIGHT']."px;":"";
			$width_style					= "width:".$IMAGE['WIDTH']."px;";
		}
	}
	else
	{
		$width_style					= ( $IMAGE['WIDTH'] != '' ) ? "width: ".$IMAGE['WIDTH']."px;":"";
		$height_style					= ( $IMAGE['HEIGHT'] != '' ) ? "height: ".$IMAGE['HEIGHT']."px;":"";
	}
	$MAKE_IMAGE_TAG					.= "<img src='".$IMAGE[FILE_PATH]."' style='".$width_style."".$height_style."border-style:solid; border-color:".$IMAGE[IMAGE_BORDER_COLOR]."; border-width:".$IMAGE[IMAGE_BORDER]."px' title='".$IMAGE[IMAGE_ALT]."' alt='".$IMAGE[IMAGE_ALT]."'><br />";

	$MAKE_IMAGE_TAG = $print_org_link1.$MAKE_IMAGE_TAG.$print_org_link2;

	$_POST['editor_name'] = ( $_POST['editor_name'] == "" ) ? "EDITOR_NAME" : $_POST['editor_name'];
	print <<<END
	<script>
		parent.parent.ckeditor_insertcode("$_POST[editor_name]","html","$MAKE_IMAGE_TAG");
		parent.parent.editor_layer_close();
	</script>
END;
}

function make_link_tag($file)
{
	//<a href="/wys2/file_attach/2015/12/23/1450846699-70.png" target="_blank">히히히</a>
	$MAKE_FILE_TAG					.= "<a href='".$file."'>".$file."</a>";
	$_POST['editor_name'] = ( $_POST['editor_name'] == "" ) ? "EDITOR_NAME" : $_POST['editor_name'];
	print <<<END
	<script>
		//parent.parent.ckeditor_insertcode("$_POST[editor_name]","html","$MAKE_FILE_TAG");
		parent.parent.ckeditor_set_attribute("$file","$MAKE_FILE_TAG","$_POST[editor_name]");
		parent.parent.editor_layer_close();
	</script>
END;
}

function make_text_image_tag()
{
	global $wys_url;
	$rpath = str_replace("//","/",'/'.$wys_url.'/');

	$MAKE_TEXT_IMAGE_TAG					= '<img src="'.$rpath.'happy_imgmaker.php?';
	$MAKE_TEXT_IMAGE_TAG					.='news_title='.urlencode($_POST['title']);
	$MAKE_TEXT_IMAGE_TAG					.= '&width='.$_POST['width'];
	$MAKE_TEXT_IMAGE_TAG					.= '&height='.$_POST['height'];
	$MAKE_TEXT_IMAGE_TAG					.= '&fsize='.$_POST['font_size'];
	$MAKE_TEXT_IMAGE_TAG					.= '&outfont='.$_POST['outfont'];
	$MAKE_TEXT_IMAGE_TAG					.= '&format='.$_POST['format'];
	$MAKE_TEXT_IMAGE_TAG					.= '&fcolor='.$_POST['fcolor'];
	$MAKE_TEXT_IMAGE_TAG					.= '&bgcolor='.$_POST['bgcolor'];
	$MAKE_TEXT_IMAGE_TAG					.= '&quality='.$_POST['quality'];
	$MAKE_TEXT_IMAGE_TAG					.= '">';

	$_POST['editor_name'] = ( $_POST['editor_name'] == "" ) ? "EDITOR_NAME" : $_POST['editor_name'];
	print <<<END
	<script>
		try
		{
			parent.parent.ckeditor_insertcode("$_POST[editor_name]","html",'$MAKE_TEXT_IMAGE_TAG');
		}
		catch(e)
		{
			try
			{
				parent.parent.document.getElementById('$_POST[editor_name]').value = '$MAKE_TEXT_IMAGE_TAG';
				parent.parent.document.getElementById('div_$_POST[editor_name]').innerHTML = '$MAKE_TEXT_IMAGE_TAG';
			}
			catch(e)
			{
				alert("에러입니다.");
			}
		}
		parent.parent.editor_layer_close();
	</script>
END;
}


function HAPPY_EXIF_READ_CHANGE2($FILE="",$type="")
{
	global $path;
	global $exif_data_name;

	$IMAGE_MIME_TYPE		= ARRAY("jpg","jpeg","gif","png");

	if( $type == '' )				//이미지를 등록하고 변환하기를 원할 경우...
	{
		$is_make_array				= false;
		if( !is_array( $FILE ) )				//단일변수면 배열에 담아서 사용.
		{
			$is_make_array				= true;
			$TMP_FILE					= ARRAY();
			$TMP_FILE[0]					= $FILE;
		}
		else
		{
			$TMP_FILE					= $FILE;
		}

		foreach( $TMP_FILE as $key => $value )
		{
			$EXIFDATA				= @exif_read_data($value);
			if($EXIFDATA['Orientation'] == 6)												//시계방향으로 90도 돌려줘야 정상인데 270도 돌려야 정상적으로 출력됨
			{
				$degree					= 270;
			}
			else if($EXIFDATA['Orientation'] == 8)											// 반시계방향으로 90도 돌려줘야 정상
			{
				$degree					= 90;
			}
			else if($EXIFDATA['Orientation'] == 3)
			{
				$degree					= 180;
			}

			if($degree)
			{
				if($EXIFDATA[FileType] == 1)
				{
					$source						= imagecreatefromgif($value);
					$source						= imagerotate ($source , $degree, 0);
					imagegif($source, $value);
				}
				else if($EXIFDATA[FileType] == 2)
				{
					$source						= imagecreatefromjpeg($value);
					$source						= imagerotate ($source , $degree, 0);
					imagejpeg($source, $value);
				}
				else if($EXIFDATA[FileType] == 3)
				{
					$source						= imagecreatefrompng($value);
					$source						= imagerotate ($source , $degree, 0);
					imagepng($source, $value);
				}

				imagedestroy($source);
				$exif_data_name[$key]			= $value;
			}

			$TMP_FILE[$key]		= $value;
		}

		if( $is_make_array == true )
		{
			return $TMP_FILE[0];
		}
		else
		{
			return $TMP_FILE;
		}
	}
	else if( $type == 'del' )					//변환을 마감하고 삭제하기를 원할 경우...
	{
		foreach( $exif_data_name as $key => $value )
		{
			unlink($value);
		}
		$exif_data_name		= Array();			//이미지 삭제를 다 했으므로 배열초기화
	}
}
?>