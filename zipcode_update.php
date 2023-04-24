<?php

	include ("./inc/config.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

#########################################################################################################

exit;

if($_FILES)
{
	define("STARTMICROTIME", array_sum( explode(' ', microtime() ) ) );

	// 파일 올리는지 검사
	if( $_FILES['csv_file']['name'] == "" )
	{
		error("파일을 업로드 하세요.");
		exit;
	}

	// 확장자 csv 만 가능
	if( $_FILES['csv_file']['name'] != "" )
	{
		$ext	= strtolower(strrchr($_FILES['csv_file']['name'], "."));

		$allow	= '.csv';

		if( $ext != $allow )
		{
			error("csv 파일만 업로드 가능합니다.");
			exit;
		}
	}

	$zip_tb		= 'happy_member_zip';
	//$zip_tb		= 'happy_member_zip';

	// 테이블 삭제
	query("truncate table $zip_tb");

	if(isset($_FILES['csv_file']) && is_uploaded_file($_FILES['csv_file']['tmp_name']))
	{
		// 업로드 폴더
		$upload_dir			= "data/";

		// 파일이름을 알아온다
		$file_path			= $upload_dir . $_FILES['csv_file']['name'];

		// 임시 폴더로 옮긴다.
		if (!move_uploaded_file($_FILES['csv_file']['tmp_name'], $file_path))
		{
			// 오류 발생!!!
			echo "파일 업로드중 오류 발생!";
			exit;
		}

		//setlocale(LC_CTYPE, 'ko_KR.utf8'); 

		// 올린 파일을 열어 읽어온다.
		$handle				= fopen($file_path, 'r');

		$a					= 0;

		$error_file_msg		= "";

		while ( ($data = fgetcsv($handle, 1000, ',')) !== FALSE)
		{
			if( strpos($data[0], '-') === false )
			{
				$zipcode		= substr($data[0], 0, 3) . '-' . substr($data[0], 3, 3);
			}
			// 읽어온 파일을 디비에 넣는다.
			$sql				= "
									INSERT INTO
											$zip_tb
									SET
									zip			= '$zipcode',
									si			= '$data[1]',
									gu			= '$data[2]',
									dong		= '$data[3] $data[4]',
									bun			= '$data[5]'
			";
			//echo $sql . "<BR>";
			query($sql);

			$a++;
		}

		// 올려진 csv 파일을 지운다.
		unlink($file_path);

		$page_gen_time	= round(array_sum( explode(" ", microtime())) - STARTMICROTIME, 2);

		echo "
		<html>
		<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			<title>우편번호 업데이트</title>
		</head>
		<body style=\"background-color: #F4F5F6;\">

		<div id=\"message\" style=\"border: 1px solid #BDBDBD; background-color: #FFFFB4; position:absolute; z-index:1; left: 20px; top: 140px; padding: 10px; font-family: '맑은 고딕', MalgunGothic, AppleGothic, '돋움', Dotum, '굴림', Gulim; word-wrap: break-word; font-size:1.2em;\">$a / $page_gen_time 초</div>

		</body>
		</html>
		";
	}
	exit;
}
?>
<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
     <title>우편번호 업데이트</title>
</head>

<style type="text/css">

*{ margin:0; padding:0;}

body { 
	font-family: "맑은 고딕", MalgunGothic, AppleGothic, "돋움", Dotum, "굴림", Gulim;
	letter-spacing: 0.01em;
	margin: 17px 0 5px;
	padding: 20px;
	word-wrap: break-word;
	background-color: #F4F5F6;
}

hr { border: solid 1px #CCCCCC; margin: 10px 0 10px 0; }

h2 {
	font-family: "맑은 고딕", MalgunGothic, AppleGothic, "돋움", Dotum, "굴림", Gulim;
	font-size: 20px;
	text-shadow: 1px 1px white;
	color: #444;
}

#content {
	width: 100%;
}

#content_body {
	width: 400px;
}

#comment {
	border-top: 1px dotted #CCCCCC;
	margin: 20px 0 20px 0;
	font-size: 14px;
}

.file {
		display: block;
		font-family: "맑은 고딕", MalgunGothic, AppleGothic, "돋움", Dotum, "굴림", Gulim;
		margin: 0 0 30px 0;
		background-color: #F1F1F2;
}

.submit {
		font-family: "맑은 고딕", MalgunGothic, AppleGothic, "돋움", Dotum, "굴림", Gulim;
		background-color: #F1F1F2;
}

</style>

<body>

<div id="content">
	<div id="content_body">

		<form name="csv_frm" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

			<h2>우편번호 업데이트</h2>
			<hr>

			<input type="file" name="csv_file" class="file" />
			<input type="submit" value="업로드" class="submit" />

			<div id="comment">
				CSV 파일로 업로드 하셔야 합니다.
				<br /><br />
				우편번호 / 시 / 구 / 동 / 번지(시 + 구 + 동) 형식입니다.
			</div>

		</form>

	</div>
</div>

</body>
</html>
