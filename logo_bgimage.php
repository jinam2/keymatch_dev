<?php
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");




	if ( $_GET['mode'] == "step1" )
	{
		$file = "logo_bgimage.html";

		$폰트선택	= make_selectbox($logo_bgimage_fonts,'--선택--',str_font,"NanumGothicExtraBold");


		$TPL->define("상세", "./$skin_folder/$file");
		$TPL->assign("상세");
		echo $TPL->fetch();
	}
	else if ( $_GET['mode'] == "create" )
	{

		$_POST['str_word']	= str_replace("\'","'",$_POST['str_word']);
		$_POST['str_word']	= str_replace('\"','"',$_POST['str_word']);
		$_POST['format']		= ($_POST['format'] == "")?"PNG":$_POST['format'];

		$_POST['width'] = $ComBannerDstW;
		$_POST['height'] = $ComBannerDstH;


		$_POST['fsize'] = $_POST['str_size'];
		$_POST['str_cut'] = "";
		$_POST['outfont'] = $_POST['str_font'];
		$_POST['fcolor'] = str_replace(")","",str_replace("rgb(","",$_POST['str_fcolor']));
		$_POST['bgcolor'] = str_replace(")","",str_replace("rgb(","",$_POST['str_bgcolor']));



		$img_file = make_titleimg($_POST['width'],$_POST['height'],$_POST['str_word'],$_POST['fsize'],$_POST['str_cut'],$_POST['outfont'],$_POST['format'],$_POST['fcolor'],$_POST['bgcolor'],'95',$_POST['str_align']);

		if( $_COOKIE['happy_mobile'] == 'on' )
		{
			$logo_style		= "style='width:85px; height:33px; margin:0 auto'";
		}
		echo "<div style='text-align:center'><img src=\"".$img_file."\" $logo_style></div>";
		//부모창에 넣을 파일경로
		echo "<input type=\"hidden\" id=\"logo_image\" value=\"".$img_file."\">";


	}




//텍스트를 이미지로 만드는 부분과, 배경이미지를 불러오는 부분의 함수를 합침
function make_titleimg($Width='',$Height='', $text = '', $FontSize = '22' , $str_cut = '', $font = 'NanumGothicExtraBold', $format = "PNG" , $FontColor='80,80,80', $BGColor='255,255,255' ,   $quality = '95',$str_align=''){
	global $server_character;
	global $logo_bgimage_list,$logo_bgimage_folder,$happy_member_upload_path,$happy_member_upload_folder,$ComBannerDstW,$ComBannerDstH;


	$sql = "select * from $logo_bgimage_list where number = '".$_POST['bg_image']."'";
	$result = query($sql);
	$BG_IMAGE = happy_mysql_fetch_assoc($result);


	if (!is_dir("$happy_member_upload_folder"))
	{
		error("첨부파일을 위한 ($happy_member_upload_folder)폴더가 존재하지 않습니다.  ");
		exit;
	}

	$now_year	= date("Y");
	$now_month	= date("m");
	$now_day	= date("d");

	$now_time	= happy_mktime();

	$oldmask = umask(0);
	if (!is_dir("$happy_member_upload_path/$now_year")){
		mkdir("$happy_member_upload_path/$now_year", 0777);
	}
	if (!is_dir("$happy_member_upload_path/$now_year/$now_month")){
		mkdir("$happy_member_upload_path/$now_year/$now_month", 0777);
	}
	if (!is_dir("$happy_member_upload_path/$now_year/$now_month/$now_day")){
		mkdir("$happy_member_upload_path/$now_year/$now_month/$now_day", 0777);
	}
	umask($oldmask);



    $TextPosX = 10; // 글자 시작위치(X좌표)
    $TextPosY = 22; // 글자 시작위치(Y좌표)
	$angle = 0;
	if ($text == '') {
		$text = "입력된 문구가 없습니다";
	}
	if (!$font){
		$font = 'NanumGothicExtraBold';
	}
	if (!$FontColor){
		$FontColor='80,80,80';
	}

	//$font = "SeoulNamsanvert";
    $FontPath = "./font/$font.ttf"; #사용폰트.

	if (!is_file($FontPath)){
		$FontPath = "./font/NanumGothicExtraBold.ttf";
		$text = "$FontPath 폰트파일이 없습니다.";
	}

	$Width		= preg_replace('/\D/', '', $Width);
	$Height		= preg_replace('/\D/', '', $Height);
	$FontSize		= preg_replace('/\D/', '', $FontSize);
	$letter_space		= preg_replace('/\D/', '', $letter_space);
	$str_cut		= preg_replace('/\D/', '', $str_cut);
	$quality		= preg_replace('/\D/', '', $quality);



	#가로,세로가 없으면 ALL 자동모드
	if (!$Width && !$Height ){
		$auto_resize = '1';
	}
	#가로만 있으면 반자동모드
	if (!$Width && $Height ){
		$auto_resize = '2';
	}
	#세로만 있으면 반자동모드
	if ($Width && !$Height ){
		$auto_resize = '3';
	}

	if (preg_match("/kr/i",$server_character)){
	    $text = iconv("euc-kr","utf-8" , $text);
	}

	if ($str_cut){
		$text = strcut_utf8	($text,$str_cut,'','..');
	}


	$FontSize = ceil($FontSize);
	if ($auto_resize == '1'){
		$text_extra = array("linespacing"=>12.2, "charspacing"=>12.9);
		$size = imageftbbox ($FontSize, $angle, $FontPath, $text, $text_extra);

		if ($angle > 0) {
				$width = $size[2] - $size[6];
				$height = $size[1] - $size[5];
				$sx = -$size[6];
				$sy = -$size[5];
		} else {
				$width = $size[4] - $size[0];
				$height = $size[3] - $size[7];
				$sx = -$size[0];
				$sy = -$size[7];
		}
		$Width = $width+2 ;
		$Height = $height ;
		$TextPosX = $sx;
		$TextPosY = $sy;
	}	elseif ($auto_resize == '2'){
		$text_extra = array("linespacing"=>12.2, "charspacing"=>12.9);
		$size = imageftbbox ($FontSize, $angle, $FontPath, $text, $text_extra);

		if ($angle > 0) {
				$width = $size[2] - $size[6];
				$height = $size[1] - $size[5];
				$sx = -$size[6];
				$sy = -$size[5];
		} else {
				$width = $size[4] - $size[0];
				$height = $size[3] - $size[7];
				$sx = -$size[0];
				$sy = -$size[7];
		}
		$Width = $width+2 ;
		$Height = $Height ;
		$TextPosX = $sx;
		$TextPosY = $sy;
	}
	elseif ($auto_resize == '3'){
		$text_extra = array("linespacing"=>12.2, "charspacing"=>12.9);
		$size = imageftbbox ($FontSize, $angle, $FontPath, $text, $text_extra);

		if ($angle > 0) {
				$width = $size[2] - $size[6];
				$height = $size[1] - $size[5];
				$sx = -$size[6];
				$sy = -$size[5];
		} else {
				$width = $size[4] - $size[0];
				$height = $size[3] - $size[7];
				$sx = -$size[0];
				$sy = -$size[7];
		}
		$Width = $Width ;
		$Height = $height ;
		$TextPosX = $sx;
		$TextPosY = $sy;
	}
	else
	{
		$size			= imageftbbox ($FontSize, $angle, $FontPath, $text);
		$width			= $size[4] - $size[0];
	}


    $image = ImageCreate($Width, $Height); // 텍스트 박스 메모리에 생성
    $bgcolor = explode(",", $BGColor);
    $BgColor = ImageColorAllocate($image, $bgcolor[0], $bgcolor[1], $bgcolor[2]); // 텍스트 박스 BGcolor 설정

    $fontcolor = explode(",", $FontColor);
    $TextColor = ImageColorAllocate($image, $fontcolor[0], $fontcolor[1], $fontcolor[2]); // 텍스트 컬러 설정

    ImageRectangle($image, 0, 0, $Width+2, $Height+2, $BgColor); // 각 설정에 따른 사각형 텍스트 박스 생성

    ImageTTFText($image, $FontSize, 0, $TextPosX, $TextPosY, $TextColor, $FontPath, $text ); // 생성된 텍스트 박스에 설정좌표에 글씨쓰기


	#$savefile 경로가 있으면 파일저장. (so memory use)
	//$savefile = "data/test.jpg";
	$ext = "png";
	$rand_number =  rand(0,1000000);
	//텍스트로고이미지
	$img_url_re			= "${happy_member_upload_path}$now_year/$now_month/$now_day/png_$now_time-$rand_number.$ext";
	$img_url_file_name	= "${happy_member_upload_folder}$now_year/$now_month/$now_day/png_$now_time-$rand_number.$ext";

	//합성한 결과물
	$img_name = $BG_IMAGE['icon_file'];
	$img_names = explode(".",$img_name);
	$img_ext		= strtolower($img_names[sizeof($img_names)-1]);

	$img_url_re2		= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-$rand_number.$img_ext";
	$img_url_file_name2	= "${happy_member_upload_folder}$now_year/$now_month/$now_day/$now_time-$rand_number.$img_ext";
	//_thumb.jpg 붙은 파일도 하나 복사하자.
	$img_url_re3		= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-${rand_number}_thumb.$img_ext";


	$savefile = $img_url_re;

	if ($format == 'JPG'){
		//header("Content-Type:image/jpeg");
		///// 설정 포멧에 맞게 이미지 뿌려주기 /////
		imageJpeg($image, "$savefile", $quality);
	}
	elseif ($format == 'PNG'){
		//header("Content-Type:image/png");
		///// 설정 포멧에 맞게 이미지 뿌려주기 /////
		imagecolortransparent($image, $bg);
		/*imagepng()함수 PHP5 패치 by kwak16*/$phpver=phpversion();$phpver=$phpver[0]; $quality = ( $quality>9&&$phpver>4)?round( $quality/11): $quality; ImagePNG($image, "$savefile", $quality);
	}
	imagedestroy($image); // 메모리에 올려져 있는 이미지 지우기


	//퀄리티 100 줘봐도 안쁘네
	//$quality = 100;


	$logo = imagecreatefrompng($savefile);
	$logo_width		= imagesx($logo);
	$logo_height	= imagesy($logo);




	if ( $img_ext == 'png' )
	{
		$src		= ImageCreateFromPng("$img_name");
	}
	else if (  $img_ext == 'gif' )
	{
		$src		= ImageCreateFromGif("$img_name");
	}
	else
	{
		$src		= ImageCreateFromJPEG("$img_name");
	}
	$bg_width = imagesx($src);
	$bg_height = imagesy($src);


	$gi_joon = $bg_width;
	$height_gi_joon = $bg_height;

	//echo "로고사이즈:".$logo_width."X".$logo_height."<br>";
	//echo "배경사이즈:".$bg_width."X".$bg_height."<br>";

	//만들어진 로고는 센터에
	$logo_left	= 0;
	$logo_top	= 0;
	//$logo_left	= ($gi_joon/2) - ($logo_width/2);
	if($width >= $gi_joon)
	{
		$logo_left	= 0;
	}
	else
	{
		switch($str_align)
		{
			case "left":	$logo_left	= 0;break;
			case "center":	$logo_left	= ($gi_joon/2)-($width/2)-10;break;
			case "right":	$logo_left	= $gi_joon-$width-20;break;
		}
	}
	$logo_top	= ($height_gi_joon/2) - ($logo_height/2);

	//echo "로고 top:".$logo_top." / 로고 left".$logo_left."<br>";


	imagecopy($src,$logo,$logo_left,$logo_top,0,0,$gi_joon,$height_gi_joon);
	/*imagepng()함수 PHP5 패치 by kwak16*/$phpver=phpversion();$phpver=$phpver[0];$quality = ($quality>9&&$phpver>4)?round($quality/11):$quality; ImagePNG($src,"$img_url_re2",$quality);
	ImageDestroy($logo);
	ImageDestroy($src);

	//합성하기전 텍스트이미지
	//echo "<img src=\"".$img_url_file_name."\"><br>";
	unlink($img_url_re);

	if ( preg_match("/jp/i",$img_ext) )
	{
		copy($img_url_re2,$img_url_re3);
	}

	return $img_url_file_name2;
}
##############################################################################

?>