<?
	//업로드된 이미지중 파일용량이 큰 이미지를 찾아서
	//적당한 사이즈로 줄이도록 추가
	set_time_limit(0);
	include ("../inc/config.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/function.php");

	include ("../inc/lib.php");
	//include ("../inc/board_function.php");

#파일 크기 반환
if ( !function_exists("byteConvert") )
{
	function byteConvert($bytes) {

		$s = array('B', 'Kb', 'MB', 'GB', 'TB', 'PB');
		$e = floor(log($bytes)/log(1024));

		if ( $bytes != '' )
		{
			return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
		}
		else
		{
			return '0';
		}
	}
}

	$t_start = array_sum(explode(' ', microtime()));

	if ( !admin_secure("환경설정") )
	{
		error("접속권한이 없습니다.");
		exit;
	}


	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################

	$cwd = getcwd();
	$cwd = $_SERVER['DOCUMENT_ROOT'];
	//뉴스는 master
	$folder_name = preg_replace("/\/admin$/","",$cwd);

	$count = 1;

	//이 프로그램으로 줄일수 있는 최소 가로사이트
	//0 또는 작은 가로사이즈로 변경해서 원본 이미지 없애버리는 현상 방지
	$min_width = "600";

	//최초
	if ( $_GET['step'] == "" )
	{
		exit;
		$TPL->define("설정폼", "$skin_folder/happy_img_resize.html");
		$content = &$TPL->fetch("설정폼");
		echo $content;
	}
	//파일용량으로 조사
	else if ( $_GET['step'] == "2" )
	{
		if ( $check_size == "" )
		{
			$check_size = "1024";
		}

		if ( $check_size <= "100" )
		{
			error("검색하시려는 이미지파일의 크기는 최소 100KB 이상이어야 합니다.");
			exit;
		}

		dircheck($folder_name,$check_size);
		$file_list = $str;

		if ( $file_list == "" )
		{
			$file_list = '
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center"> 체크된 파일이 없습니다.</td>
			</tr>
			</table>
			';
		}

		$TPL->define("설정폼2", "$skin_folder/happy_img_resize2.html");
		$content = &$TPL->fetch("설정폼2");
		echo $content;
	}
	//선택해서 일괄 리사이즈
	else if ( $_GET['step'] == "3" )
	{
		//print_r($_POST);
		//$_POST['f'] = array("/hard/hosting2/info/www/upload/menu_image/1316695207-318760.jpg");

		if ( count($_POST['f']) <= 0 )
		{
			error("잘못된 접근입니다");
			exit;
		}

		$cwd_patten = str_replace("/","\/",$folder_name);
		foreach($_POST['f'] as $k => $v)
		{
			if ( !preg_match("/\.jp/i",$v) )
			{
				error("잘못된 접근입니다");
				exit;
			}

			if ( !preg_match("/".$cwd_patten."/",$v) )
			{
				error("잘못된 접근입니다2");
				exit;
			}

			$size = array();
			$size = getimagesize($v);

			if ( $size[0] == "" || $size[1] == "" )
			{
				error("잘못된 접근입니다3");
				exit;
			}

			if ( !is_writable($v) )
			{
				error("권한 문제로 파일을 수정할수 없습니다");
				exit;
			}
		}

		$gi_joon = $_POST['width_size'];
		if ( $gi_joon < $min_width )
		{
			//error("이 프로그램으로 조절 가능한 이미지의 최소 가로크기는 ".$min_width."px 입니다.");
			//post 들어온 페이지라 새로 페이지를 읽도록 경로 바꿈 2014-01-03 woo
			gomsg("이 프로그램으로 조절 가능한 이미지의 최소 가로크기는 ".$min_width."px 입니다.","happy_img_resize.php?step=2");
			exit;
		}

		foreach($_POST['f'] as $k => $v)
		{
			$img_path = $v;
			imageUploadNew_resize($img_path,$img_path, $gi_joon, 0, 100);

			echo "<br><br>"; flush();
		}

		msg("이미지 사이즈가 변경되었습니다.");
		go("happy_img_resize.php?step=2");

	}
	//개별 리사이즈
	else if ( $_GET['step'] == "4" )
	{
		$img_path = $_GET['f'];

		//print_r($_GET);
		if ( !preg_match("/\.jp/i",$img_path) )
		{
			error("잘못된 접근입니다");
			exit;
		}

		$cwd_patten = str_replace("/","\/",$folder_name);
		if ( !preg_match("/".$cwd_patten."/",$img_path) )
		{
			error("잘못된 접근입니다2");
			exit;
		}

		//$img_path = "/hard/hosting2/pension/www/index.php";

		//보여줄 만한 정보들
		$size = getimagesize($img_path);
		//print_r($size);
		if ( $size[0] == "" || $size[1] == "" )
		{
			error("잘못된 접근입니다3");
			exit;
		}
		else
		{
			$img_width_size = $size[0];
			$img_height_size = $size[1];
		}

		$img_file_name = array_pop(explode("/",$img_path));
		$img_file_path = preg_replace("/^\//","",str_replace($folder_name,"",$img_path));
		$img_file_size = byteConvert(filesize($img_path));
		$img_file_mtime = date("Y-m-d H:i:s",filemtime($img_path));
		$img_file_atime = date("Y-m-d H:i:s",fileatime($img_path));


		$TPL->define("설정폼4", "$skin_folder/happy_img_resize_one.html");
		$content = &$TPL->fetch("설정폼4");
		echo $content;
	}
	else if ( $_GET['step'] == "5" )
	{
		$img_path = $_POST['f'];
		//print_r($_POST);
		if ( !preg_match("/\.jp/i",$img_path) )
		{
			error("잘못된 접근입니다");
			exit;
		}

		$cwd_patten = str_replace("/","\/",$folder_name);
		if ( !preg_match("/".$cwd_patten."/",$img_path) )
		{
			error("잘못된 접근입니다2");
			exit;
		}

		if ( !is_writable($img_path) )
		{
			error("권한 문제로 파일을 수정할수 없습니다");
			exit;
		}

		$gi_joon = $_POST['width_size'];
		if ( $gi_joon < $min_width )
		{
			error("이 프로그램으로 조절 가능한 이미지의 최소 가로크기는 ".$min_width."px 입니다.");
			exit;
		}

		imageUploadNew_resize($img_path,$img_path, $gi_joon, 0, 100);

		msg("이미지 사이즈가 변경되었습니다.");
		go("happy_img_resize.php?step=2");

	}






	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################







function dircheck($dir,$check_size)
{
	global $total_size,$count,$count2;
	global $gi_joon,$str;

	//$limit_size = 1024000;
	//$limit_size = 300000;

	$limit_size = $check_size * 1000;

	$cwd = getcwd();

	//$str = "";


	//echo $dir."<BR>";
	$dir_obj=@opendir($dir);
	while(($file = @readdir($dir_obj))!==false)
	{
		if ( !is_dir($dir."/".$file) )
		{
			if ( preg_match("/upload|mallimg|file_attach/i",$dir)
				&& !preg_match("/minihome_skin|tmp/i",$dir) )
			//if ( 1 == 1 )
			{
				if ( preg_match("/\.jp/i",$file) )
				{
					if ( filesize($dir."/".$file) >= $limit_size )
					{
						//echo $dir."/".$file."<br>";
						//imageUploadNew($dir."/".$file,$dir."/".$file, $gi_joon, 0, 100);


						//echo $dir."/".$file." : <font color=blue>".byteConvert(filesize($dir."/".$file))."</font><br>\n";
						$img_url = preg_replace("/^\//","",str_replace($_SERVER['DOCUMENT_ROOT'],"",$dir));
						$btn_view = '<a href="../'.$img_url."/".$file.'" target="_BLANK" class="btn_small_blue" style="display:block !important">';
						$btn_view.= '보기';
						$btn_view.= '</a>';

						$btn_mod = '<a href="happy_img_resize.php?step=4&f='.urlencode($dir."/".$file).'" class="btn_small_dark3" style="margin-top:3px">';
						$btn_mod.= '수정';
						$btn_mod.= '</a>';

						$str.= '<tr style="border-bottom:1px solid #c9c9c9;"><tr onmouseover="this.style.backgroundColor=\'#E3DCD2\'" onmouseout="this.style.backgroundColor=\'\'">';
						$str.= '<td class="b_border_td" style="text-align:center;"><input type="checkbox" name="f[]" id="f_'.$count.'" value="'.$dir."/".$file.'"> ['.$count.']</td>';
						$str.= '<td class="b_border_td">'.$img_url."/".$file.'<span  id="msg_'.$count.'"></span></td>';
						$str.= '<td class="b_border_td" style="text-align:center;"><font color=blue>'.byteConvert(filesize($dir."/".$file)).'</font></td>';
						$str.= '<td class="b_border_td" style="text-align:center;">'.date("Y-m-d H:i:s",filemtime($dir."/".$file)).'</td>';
						$str.= '<td class="b_border_td" style="text-align:center; width:100px">'.$btn_view.' '.$btn_mod.'</td>';
						$str.= '</tr>';


						//echo '['.$count.']'." ".$img_url."/".$file." : <font color=blue>".byteConvert(filesize($dir."/".$file))."</font>$btn_view$btn_mod<br>\n";





						$total_size+=filesize($dir."/".$file);
						$count++;

						if ( $count % 10 == 0 )
						{
							$count2++;
							//$str.= "<hr>";
							flush();
						}
					}
				}
			}
		}
		else
		{
			if ( $file != ".." && $file != "." )
			{
				//echo "<font color=blue>".$file."</font><br>";
				if ( !is_link($dir."/".$file) )
				{
					dircheck($dir."/".$file,$check_size);
				}
				else
				{
					echo "<font color=red>".$file."</font><br>";
				}
			}

		}
	}
	@closedir($dir_obj);
}






#예약의 썸네일생성함수를 가져와서 수정함
function imageUploadNew_resize($img_name, $img_name_new, $gi_joon, $height_gi_joon, $picture_quality)
{
	# 사용법
	# imgaeUpload(원본파일네임, 생성할파일네임, 가로크기, 세로크기, 품질, 썸네일추출타입, 로고파일명, 로고포지션)
	# $path는 홈디렉토리의 pwd

	$thumbPosition	= preg_replace("/\D/","",$thumbPosition);
	$logoPosition	= preg_replace("/\D/","",$logoPosition);

	$img_url_re		= $img_name_new;
	$image_top		= 0;
	$image_left		= 0;

	#확장자 체크
	$img_names		= explode(".",$img_name);
	$img_ext		= strtolower($img_names[sizeof($img_names)-1]);

	#단순파일확장자 체크
	if ( $img_ext != 'jpg' && $img_ext != 'jpeg' && $img_ext != 'png' && $img_ext != 'gif' )
	{
		//error("사용할수 없는 확장자 입니다.");
		//return "";
	}

	#기존 이미지를 불러와서 사이즈 체크
	$imagehw		= GetImageSize("$img_name");

	$imagewidth		= $imagehw[0];
	$imageheight	= $imagehw[1];

	if ( $imagewidth <= 900 )
	{
		return;
	}

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


	//$new_width		= $height_gi_joon * $imagewidth / $imageheight ;
	$new_width		= $gi_joon;
	$new_width		= ceil($new_width);
	$new_height		= $gi_joon * $imageheight / $imagewidth ;
	$new_height		= ceil($new_height);

	//$width_per	= $imagewidth / $gi_joon;
	//$height_per	= $imageheight / $height_gi_joon;


	//echo "<br>"."$new_width - $new_height <br> ";


	#배경잡고
	$thumb			= ImageCreate($gi_joon,$new_height);
	$thumb			= imagecreatetruecolor($gi_joon,$new_height);
	$white			= imagecolorallocate($thumb, 255, 255, 255);
	imagefilledrectangle ($thumb,0,0,$gi_joon,$new_height,$white);


	if ( $img_ext == 'png' ) {
		$src		= ImageCreateFromPng("$img_name");
	}
	else if (  $img_ext == 'gif' ) {
		$src		= ImageCreateFromGif("$img_name");
	}
	else {
		$src		= ImageCreateFromJPEG("$img_name");
	}
	$src		= ImageCreateFromJPEG("$img_name");
	imagecopyresampled($thumb,$src,0,0,$image_left,$image_top,$new_width,$new_height,$imagewidth,$imageheight);

	ImageJPEG($thumb,"$img_name_new",$picture_quality);


	return $img_url_re;

}

?>