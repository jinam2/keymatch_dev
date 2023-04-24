<?php
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");


	$number	= preg_replace("/\D/","",$_GET["number"]);
	if ( $number == '' )
	{
		error("필요한 매개변수가 넘어오지 않았습니다.");
		exit;
	}

	$HappyTodayGuzic	= $_COOKIE["HappyTodayGuzic"];

	//쿠키 정리 및 시간 지난건 지우기 (오늘본 채용정보)
	$timeChk	= happy_mktime() - 86400;
	$nowNumChk	= "no";
	$cookieVal	= "";

	$arr		= explode(",",$HappyTodayGuzic);
	for ( $i=0, $Count=0, $max=sizeof($arr) ; $i<$max ; $i++ )
	{
		$tmp	= explode("_",$arr[$i]);
		if ( $tmp[1] > $timeChk )
		{
			$cookieVal	.= ( $Count == 0 )?"":",";
			$cookieVal	.= $arr[$i];
			if ( $number == $tmp[0] )
			{
				$nowNumChk	= "ok";
			}
			$Count++;
		}
	}
	if ( $nowNumChk != "ok" )
	{
		$cookieVal	.= ( $Count == 0 )?"":",";
		$cookieVal	.= $number ."_". happy_mktime();
	}

	cookie("HappyTodayGuzic",$cookieVal,1);
	$_COOKIE["HappyTodayGuzic"]	= $cookieVal;
	#echo $_COOKIE["HappyTodayGuzic"]."<hr>";



	if ($Data[job_type1]){
		$add_location1 = " > <a href=guin_list.php?guzic_jobtype1=$Data[type1]>".$TYPE[$Data['job_type1']] . "</a>";
	}
	if ($Data[job_type_sub1]){
		$add_location2 = " > <a href=guin_list.php?guzic_jobtype1=$Data[type1]&guzic_jobtype2=$Data[job_type_sub1]>". $TYPE_SUB[$Data["job_type_sub1"]] . "</a>";
	}
	$현재위치	= " $prev_stand > <a href='guzic_list.php?k=1$searchMethod'>인재정보</a> > <a href='document_view.php?number=$_GET[number]$searchMethod2'>이력서보기</a> $add_location1 $add_location2";


	$mainTemplate	= "doc_view_main.html";
	$workTemplate	= "doc_view_work.html";
	$skillTemplate	= "doc_view_skill.html";
	$langTemplate	= "doc_view_lang.html";
	$yunsooTemplate	= "doc_view_yunsoo.html";
	$schoolTemplate	= "doc_view_school.html";

	if ( $_GET["viewfile"] != "" && eregi(".html",$_GET["viewfile"]) )
		$mainTemplate	= $_GET["viewfile"];


	$내용	= document_view( $mainTemplate, $workTemplate, $skillTemplate, $langTemplate, $yunsooTemplate, $schoolTemplate );



	# 이미지 정보 추출
	$Sql			= "SELECT * FROM $per_file_tb where doc_number='$number' order by number asc";
	$imageRecord	= query($Sql);

	$imageData2 = array();
	$imageData3 = array();
	while ( $imageData = happy_mysql_fetch_array($imageRecord) )
	{
		$imageData['fileName_thumb']	= str_replace("((thumb_name))","_thumb",$imageData['fileName']);
		#$imageData['fileName_big']		= str_replace("((thumb_name))","_big",$imageData['fileName']);
		$imageData['fileName']			= str_replace("((thumb_name))","",$imageData['fileName']);

		#멀티업로드 패치하면서 big 이미지 생성안하도록 변경.
		$Happy_Img_Name = array();
		$Happy_Img_Name[0] = str_replace("((thumb_name))","",$imageData['fileName']);

		//해피이미지로 변경 hong
		$imageData['fileName_thumb']	= happy_image("자동",$HAPPY_CONFIG['doc_img_width_small'],$HAPPY_CONFIG['doc_img_height_small'],"로고사용안함","로고위치7번","100","gif원본출력","img/no_image.gif","비율대로확대","2");
		$imageData['fileName_big']		= happy_image("자동",$HAPPY_CONFIG['doc_img_width_big'],$HAPPY_CONFIG['doc_img_height_big'],"로고사용안함","로고위치7번","100","gif원본출력","img/no_image_big.gif","비율대로확대","2");

		//모바일용 스와이프
		$imageData3[] = $imageData['fileName'];

		$imageData2[] = $imageData;
	}

	//minialbum2.html 에서 사용할 이미지경로들
	for ( $i=0;$i<20;$i++ )
	{
		if ( $imageData2[$i]['fileName'] == "" )
		{
			$imageData2[$i]['fileName_big'] = "img/no_image_big.gif";
			$imageData2[$i]['fileName_thumb'] = "img/no_image.gif";

			//모바일용 스와이프
			$imageData3[$i] = "img/no_image_big.gif";
		}
	}
	//minialbum2.html 에서 사용할 이미지경로들

	/*
	while ( $imageData = happy_mysql_fetch_array($imageRecord) )
	{
		$imageData['fileName_thumb']	= str_replace("((thumb_name))","_thumb",$imageData['fileName']);
		$imageData['fileName_big']		= str_replace("((thumb_name))","_big",$imageData['fileName']);
		$imageData['fileName']			= str_replace("((thumb_name))","",$imageData['fileName']);
	}
	*/

	if ( $_GET['file'] != '' )
	{
		$file		= $_GET["file"];
		$tmp		= explode(".",$file);
		$file_ext	= $tmp[sizeof($tmp)-1];
		$file		= str_replace($file_ext,"",$file);
		$file		= preg_replace("/\W/","",$file) .".". $file_ext;
	}
	else
		$file		= "minialbum2.html";

	if ( $_GET['file2'] != '' )
	{
		$file2		= $_GET["file2"];
		$tmp		= explode(".",$file2);
		$file_ext2	= $tmp[sizeof($tmp)-1];
		$file2		= str_replace($file_ext2,"",$file2);
		$file2		= preg_replace("/\W/","",$file2) .".". $file_ext2;
	}
	else
		$file2		= "default_minialbum.html";



	$TPL->define("상세", "./$skin_folder/$file");
	$TPL->assign("상세");
	$내용 = &$TPL->fetch();



	$TPL->define("껍데기", "./$skin_folder/$file2");
	$TPL->assign("껍데기");
	echo $TPL->fetch();

exit;



?>