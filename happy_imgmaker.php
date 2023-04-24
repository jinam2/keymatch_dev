<?PHP
include ("./inc/config.php");
$server_character	= 'utf8';
########################################################################################
#이미지 creator : 2012.3.24 NeoHero
#가로 세로값을 넣지않으면 , 글자사이즈에 대비하여 자동으로 이미지크기가 생성됩니다.
#가로값만 넣으면 가로이미지가 고정됩니다.
#세로값만 넣으면 세로이미지가 고정됩니다.
#레퍼러 반드시 check , GD / iconv 서버에 필수모듈
#
#링크로 사용시.
#<img src='happy_imgmaker.php?fsize=15&news_title=샘플 글자 따옴표 src에 쳐주세요&outfont=JejuHallasan&fcolor=57,150,198'>
#함수로 사용시.
#make_titleimg('가로사이즈(INT)','세로사이즈(INT)',"출력글자(TEXT)","폰트크기(INT)","글자자름(INT)","폰트체(TEXT)","포맷(JPG|PNG)");
########################################################################################

###### 아래 정상접근체크를 해제하는 경우 외부에서 이미지를 도용할수 있습니다. 유의하세요.  ######
$main_url = str_replace('/','\/',str_replace('www.','',$main_url));
$s_refer = str_replace('www.','',$_SERVER["HTTP_REFERER"]);
$s_refer = preg_replace("/^http:\/\/m\./i","http://",$s_refer);
$s_refer = preg_replace("/^https:\/\/m\./i","https://",$s_refer);
$s_refer   = str_replace('http://','',$s_refer);
$s_refer   = str_replace('https://','',$s_refer);

$main_url_ch  = str_replace('http:\/\/','',$main_url);
$main_url_ch  = str_replace('https:\/\/','',$main_url_ch);

if (!preg_match("/$main_url_ch/i",$s_refer)){
	print  '정상적인 접근이 아닙니다.';
	exit;
}
#######################################################################################

$_GET[news_title]		= urldecode($_GET[news_title]);
$_GET[news_title]		= str_replace("\'","'",$_GET[news_title]);
$_GET[news_title]		= str_replace('\"','"',$_GET[news_title]);
$_GET[format]			= ($_GET[format] == "")?"PNG":$_GET[format];
make_titleimg("$_GET[width]","$_GET[height]","$_GET[news_title]","$_GET[fsize]","$_GET[str_cut]","$_GET[outfont]","$_GET[format]","$_GET[fcolor]","$_GET[bgcolor]");

function make_titleimg($Width='',$Height='', $text = '', $FontSize = '22' , $str_cut = '', $font = 'NanumGothicExtraBold', $format = "PNG" , $FontColor='80,80,80', $BGColor='255,255,255' ,   $quality = '94'){
	global $server_character,$path;

	$angle = 0;

	if ($text == ''){
		$text				= "입력된 문구가 없습니다";
	}
	if (!$font){
		$font				= 'NanumGothicExtraBold';
	}
	if (!$FontColor){
		$FontColor			='80,80,80';
	}
	if (!$BGColor){
		$BGColor			="255,255,255";
	}

    $FontPath = "{$path}font/$font.ttf"; #사용폰트.

	if (!is_file($FontPath)){
		$FontPath			= "{$path}font/NanumGothicExtraBold.ttf";
		$text				= "$FontPath 폰트파일이 없습니다.";
	}

	$Width				= preg_replace('/\D/', '', $Width);
	$Height				= preg_replace('/\D/', '', $Height);
	$FontSize			= preg_replace('/\D/', '', $FontSize);
	$str_cut			= preg_replace('/\D/', '', $str_cut);
	$quality			= preg_replace('/\D/', '', $quality);

	if (!$Width && !$Height ){						#가로,세로가 없으면 ALL 자동모드
		$auto_resize = '1';
	}
	if (!$Width && $Height ){						#가로만 있으면 반자동모드
		$auto_resize = '2';
	}
	if ($Width && !$Height ){						#세로만 있으면 반자동모드
		$auto_resize = '3';
	}

	$FontSize			= ceil($FontSize);
	if (preg_match("/kr/i",$server_character)){
	    $text				= iconv("euc-kr","utf-8" , $text);
	}
	if ($str_cut){
		$text				= strcut_utf8($text,$str_cut,'','..');
	}

	$text_extra			= array("linespacing"=>12.2, "charspacing"=>12.9);
	$size				= imageftbbox ($FontSize, $angle, $FontPath, $text, $text_extra);

	if ($angle > 0){
		$width				= $size[2] - $size[6];
		$height				= $size[1] - $size[5];
		$sx					= -$size[6];
		$sy					= -$size[5];
	}
	else{
		$width				= $size[4] - $size[0];
		$height				= $size[3] - $size[7];
		$sx					= -1;
		$sy					= -$size[7];
	}
	$TextPosX			= $sx;
	$TextPosY			= $sy;

	if ( $auto_resize == '1' ){
		$Width				= $width+2 ;
		$Height				= $height +2;
	}
	else if ( $auto_resize == '2' ){
		$Width				= $width+2 ;
		$Height				= $Height+2 ;
	}
	else if ( $auto_resize == '3' ){
		$Width				= $Width ;
		$Height				= $height ;
	}

    $image				= ImageCreate($Width, $Height); // 텍스트 박스 메모리에 생성
    $bgcolor			= explode(",", $BGColor);
    $BgColor			= ImageColorAllocate($image, $bgcolor[0], $bgcolor[1], $bgcolor[2]); // 텍스트 박스 BGcolor 설정

    $fontcolor			= explode(",", $FontColor);
    $TextColor			= ImageColorAllocate($image, $fontcolor[0], $fontcolor[1], $fontcolor[2]); // 텍스트 컬러 설정

    ImageRectangle($image, 0, 0, $Width, $Height, $BgColor); // 각 설정에 따른 사각형 텍스트 박스 생성
    ImageTTFText($image, $FontSize, 0, $TextPosX, $TextPosY, $TextColor, $FontPath, $text ); // 생성된 텍스트 박스에 설정좌표에 글씨쓰기

	#$savefile 경로가 있으면 파일저장. (so memory use)
	$savefile	= NULL;
	if ( preg_match("/jpg/i",$format) || preg_match("/jpeg/i",$format) ){
		header("Content-Type:image/jpeg");
		imageJpeg($image, $savefile, $quality);			///// 설정 포멧에 맞게 이미지 뿌려주기 /////
	}
	else if ( preg_match("/gif/i",$format) ){
		header("Content-Type:image/jpeg");
		Imagegif($image, $savefile, $quality);			///// 설정 포멧에 맞게 이미지 뿌려주기 /////
	}
	elseif ( preg_match("/png/i",$format) ){
		header("Content-Type:image/png");
		imagecolortransparent($image, $bg);					///// 설정 포멧에 맞게 이미지 뿌려주기 /////
		/*imagepng()함수 PHP5 패치 by kwak16*/
		$phpver				= phpversion();
		$phpver				= $phpver[0];
		$quality			= ( $quality > 9 && $phpver > 4 ) ? round( $quality/11) : $quality;
		ImagePNG($image, $savefile, $quality);
	}
    imagedestroy($image); // 메모리에 올려져 있는 이미지 지우기
}
##############################################################################

 function strcut_utf8($str, $len, $checkmb=false, $tail='') {
    /**
     * UTF-8 Format
     * 0xxxxxxx = ASCII, 110xxxxx 10xxxxxx or 1110xxxx 10xxxxxx 10xxxxxx
     * latin, greek, cyrillic, coptic, armenian, hebrew, arab characters consist of 2bytes
     * BMP(Basic Mulitilingual Plane) including Hangul, Japanese consist of 3bytes
     **/
    preg_match_all('/[\xE0-\xFF][\x80-\xFF]{2}|./', $str, $match); // target for BMP

    $m = $match[0];
    $slen = strlen($str); // length of source string
    $tlen = strlen($tail); // length of tail string
    $mlen = count($m); // length of matched characters

    if ($slen <= $len) return $str;
    if (!$checkmb && $mlen <= $len) return $str;

    $ret = array();
    $count = 0;
    for ($i=0; $i < $len; $i++) {
        $count += ($checkmb && strlen($m[$i]) > 1)?2:1;
        if ($count + $tlen > $len) break;
        $ret[] = $m[$i];
    }
    return join('', $ret).$tail;
}
?>