<?PHP
	if(!session_id()) session_start();
	$upload_id			= session_id();
	header("Content-type: text/html; charset=utf-8");
	require_once('../secure_config.php') ;												//보안설정
	require_once('../config.php') ;																	//에디터 모듈 통합설정

	$Request_Data			= file_get_contents('php://input');
	$Json_Data				= json_decode($Request_Data);
	#print_r($Request_Data);

	#파일첨부 관련정리#######################################################
	$now_year				= date("Y");
	$now_month				= date("m");
	$now_day				= date("d");

	if (!is_dir("$swf_attach_folder")){
		error("첨부파일을 위한 ($swf_attach_folder)폴더가 존재하지 않습니다.  ");
	}

	if ( !(is_writable("$swf_attach_folder")) ) {
		error("$swf_attach_folder 폴더의 퍼미션을 777로 조정하세요");
	}

	$oldmask				= umask(0);
	if (!is_dir("$swf_attach_folder/$now_year")){
		mkdir("$swf_attach_folder/$now_year", 0777);
	}
	if (!is_dir("$swf_attach_folder/$now_year/$now_month")){
		mkdir("$swf_attach_folder/$now_year/$now_month", 0777);
	}
	if (!is_dir("$swf_attach_folder/$now_year/$now_month/$now_day")){
		mkdir("$swf_attach_folder/$now_year/$now_month/$now_day", 0777);
	}
	umask($oldmask);

	$attach_folder_path	= "$swf_attach_folder/$now_year/$now_month/$now_day";
	$attach_folder_url	= "$fileUrl/$now_year/$now_month/$now_day";
	$editor_file_path	= "$path/$now_year/$now_month/$now_day";


	$RESULT				= Array();
	$contents			= "";
	foreach( $Json_Data as $key => $value )			//배열만큼 파일 이동 시켜라.
	{
		$value2			= str_replace("$upFolder_name/$upload_id","$attach_folder_path",$value);
		#echo "$key => $value \n";
		#echo "$key => $value2 \n";

		rename($value, $value2);
		$upload_file_src = "/".$img_main_url.str_replace("../","",$value2);
		$contents	.= "<img src=$upload_file_src border=0 align=absmiddle><br><br>";
	}

	if( $contents != '' ){
		$RESULT[status]			= "success";
		$RESULT[contents]		= $contents;
	}
	else{
		$RESULT[status]			= "error";
		$RESULT[message]		= "이미지 업로드 후 등록 바랍니다.";
	}

	echo json_encode($RESULT);exit;
?>