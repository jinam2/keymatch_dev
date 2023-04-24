<?

include ("./inc/config.php");
include ("./inc/function.php");

if(!session_id()) session_start();
$folder_name = "upload/tmp/".session_id();

//echo $folder_name;


$cntt		= $_GET['cntt'] == "" ? "40" : $_GET['cntt'];
$wcount		= $_GET['wcount'] == "" ? "10" : $_GET['wcount'];
$boxtext	= $_GET['boxtext'] == "" ? "[이미지1]||[이미지2]||[이미지3]||[이미지4]||[이미지5]||[이미지6]||[이미지7]||[이미지8]||[이미지9]||[이미지10]||[이미지11]||[이미지12]||[이미지13]||[이미지14]||[이미지15]||[이미지16]||[이미지17]||[이미지18]||[이미지19]||[이미지20]||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||":$_GET['boxtext'];
$noimage	= $_GET['noimage'] == "" ? "img/noimg_4.gif" : $_GET['noimage'];
$mode		= $_GET['mode'] == "" ? "tmp" : $mode ;




$fileNames		= "";
$startScript	= "";
$i				= 0;


if ( $mode == "db" )	# DB에서 파일정보를 불러와서 fileName으로 넘기기 (수정시사용)
{
	$dbname		= $_GET['dbname'] == "" ? $per_file_tb : $_GET['dbname'];
	$fields		= $_GET['fields'] == "" ? "fileName" : $_GET['fields'];
	$upfolder	= $_GET['upfolder'] == "" ? "" : $_GET['upfolder'];
	if ( $_GET['number'] == '' )
	{
		echo "<center><br>넘어온 number 값이 없습니다.<br>&nbsp;</center>";
		exit;
	}
	else
		$number	= $_GET['number'];

	$Sql	= "SELECT $fields FROM $dbname WHERE doc_number = '$number' order by number ";
	$Record	= query($Sql);

	$tmp	= explode(",",$fields);
	$i		= 0;
	while ( $Data = happy_mysql_fetch_array($Record) )
	{

		$Data['fileName']	= str_replace("((thumb_name))","_thumb",$Data['fileName']);
		//echo $upfolder; exit;
		$fileName	= $Data['fileName'] ;


		$fileNames	.= ( $i==0 )?"":"||";
		$fileNames	.= ( $fileName == "" ) ?"":"./".$upfolder.$fileName;

		$startScript	.= "parent.document_frm.img${i}.value	= '".$Data['fileName']."';\n";

		$i++;

	}
}

if ( $mode == "tmp" || $mode == "db" )	# tmp 파일에서 세션폴더에 있는 정보를 추출후 fileName으로 넘기기 (등록시사용)
{
	//쓰레기 파일을 $_FILES 변수에 담쟈
	$fileList	= Array();
	if(is_dir($folder_name)) {
		$dir_obj=opendir($folder_name);
		while(($file_str = readdir($dir_obj))!==false){
			if($file_str!="." && $file_str!=".." && eregi("_thumb",$file_str)){
				$fileList[]	= $file_str;
			}
			else
			{
				//echo $file_str."<br>";
				$temp_name2	= explode(".",$file_str);
				$ext2		= $temp_name2[sizeof($temp_name2)-1];
				//echo $ext2."<br>";
				if ( preg_match("/gif/i",$ext2) )
				{
					$fileList[]	= $file_str;
				}
			}
		}
		closedir($dir_obj);
		sort($fileList);

		for ( $j=0, $max=sizeof($fileList) ; $j<$max ; $i++, $j++ )
		{
			$split_str	= explode("__swfupload__",$fileList[$j]);
			$temp_name	= explode(".",$fileList[$j]);
			$ext		= $temp_name[sizeof($temp_name)-1];

			$file_str2	= str_replace(".$ext","_thumb.$ext",$fileList[$j]);

			$fileName	= is_file($folder_name."/".$file_str2) ? $file_str2 : $fileList[$j] ;

			$fileNames	.= ( $fileNames == "" )?"":"||";
			$fileNames	.= $folder_name."/".$fileName;

			$startScript	.= "parent.document_frm.img${i}.value	= '".$fileList[$j]."';\n";
		}
	}
}

#echo $fileNames;
echo <<<END
<html>

<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<script language="JavaScript" src="js/swf_upload.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/style_common.css" type="text/css">
</head>

<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">

	<table cellpadding="0" cellspacing="0" width="100%" align="center">
		<tr>
			<td height="25" bgcolor="#f4f4f4" align="center" class="font_st_12">
				<font color="#8ba9bf" >*이미지를 <b>드래그하여 위치를 변경</b>하세요. 이미지가 원활하게 로딩되지 않을경우 우측에 있는 아이콘을 클릭하세요</font>
				<img src='img/btn_refresh.gif' onClick='location.reload()' style='cursor:pointer' align='absmiddle'>
			</td>
		</tr>
		<tr>
			<td height="5"></td>
		</tr>
		<tr>
			<td align='center'>

				<script>

					function startScript_go()
					{
						$startScript
					}

					makeDragImg(
						get_cntt			= "$cntt",
						get_Width		= 57,
						get_Height		= 70,
						get_limitimg	= 20,
						get_Xpoint		= -38,
						get_Ypoint		= 0,
						get_wcount	= "$wcount",
						get_boxcolor	= "8ba9bf",
						get_overcolor	= "aaaaaa",
						get_extla		= "zip,rar,tar,gz,hwp,pdf,xls,ppt",
						get_images	= "$fileNames",
						movie_id		= "kwak16",
						get_boxtext	= "$boxtext",
						get_noimage	= "$noimage"
					);

					setTimeout("startScript_go()",1000);
				</script>
			</td>
		</tr>
	</table>
</body>

</html>
END;
?>
