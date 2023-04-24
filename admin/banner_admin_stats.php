<?
	include_once("../inc/happy_function.php"); //include_once 필요

	$php_version1 = "4";

	if ( $php_version1 == "4" )
	{
		$ve = "";
	}
	else
	{
		$ve = "5";
	}

	include ("./banner_graph/mischoi.php3"); //str2uni함수 include
	include ("./banner_graph{$ve}/jpgraph.php");
	include ("./banner_graph{$ve}/jpgraph_bar.php");
	include ("./banner_graph{$ve}/jpgraph_line.php");
	include ("./banner_graph{$ve}/jpgraph_pie.php");
	include ("./banner_graph{$ve}/jpgraph_pie3d.php");

	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");


	#관리자 접속 체크 루틴
	if ( !admin_secure("배너관리툴") ) {
		error("접속권한이 없습니다.   ");
		exit;
	}
	#관리자 접속 체크 루틴

	include ("tpl_inc/top_new.php");



	###값정리###
	$getYear	= preg_replace("/\D/","",$_GET['getYear']) == '' ? date('Y') : preg_replace("/\D/","",$_GET['getYear']);
	$getMonth	= preg_replace("/\D/","",$_GET['getMonth']) == '' ? date('m') : preg_replace("/\D/","",$_GET['getMonth']);
	$lastDay	= date("t",happy_mktime(0,0,0,$getMonth,1,$getYear));

	$bannerID	= $_GET['bannerID'];
	$groupID	= $_GET['groupID'];
	$bannerSql	= $bannerID ? " AND bannerID = '$bannerID' " : '';
	$groupSql	= $groupID ? " AND groupID = '$groupID' " : '';

	if ( $bannerSql != '' )
	{
		$Sql		= "SELECT title FROM $happy_banner_tb WHERE number='$bannerID' ";
		$Tmp		= happy_mysql_fetch_array(query($Sql));
		$bannerName	= $Tmp['title'];
	}
	else if ( $groupSql != '' )
		$bannerName	= $groupID .' 그룹';
	else
		$bannerName	= '전체';


	#메뉴아래 상단 HTML
	$yearSelect		= dateSelectBox( 'getYear', 2008, date('Y'), $getYear, "년", "선택", "onChange='this.form.submit()'" );
	$monSelect		= dateSelectBox( 'getMonth', 1, 12, $getMonth, "월", "선택", "onChange='this.form.submit()'" );

	echo "
		<form>
		<input type='hidden' name='bannerID' value='$bannerID'>
		<input type='hidden' name='groupID' value='$groupID'>
			<div class='main_title'>배너통계 <label>$yearSelect $monSelect</label></div>
		</form>
		";







	################################# 그래프1 시작 #######################################

	$statsArray1	= Array();
	$statsArray2	= Array();
	$statsArray3	= Array();
	$statsArrayName	= Array();
	$message		= "${getYear}년 ${getMonth}월 [${bannerName} 배너] 통계";

	for ( $i=1 ; $i<=$lastDay ; $i++ )
	{
		//$j		= $i < 10 ? "0".$i : $i;
		//$oDate	= "$getYear-$getMonth-$j";
		$oDate		= $i.iconv("utf-8","euc-kr","일");
		#아래의 주석을 풀면 현재날짜이상일 경우 출력안됨 => 버그가 있어서 -,.-
		#if ( $oDate > date("Y-m-d") ){ break; }

		$Sql	= "
					SELECT
							sum(viewcount) AS viewCountSum,
							sum(linkcount) AS linkCountSum
					FROM
							$happy_banner_log_tb
					WHERE
							year	= '$getYear' AND
							month	= '$getMonth' AND
							day		= '$i'
							$bannerSql
							$groupSql
					GROUP BY year,month,day
				";
		$Count	= happy_mysql_fetch_array(query($Sql));

		if ( $bannerSql != "" || $groupSql != "" )
		{
			$Sql	= "
						SELECT
								sum(viewcount) AS viewCountSum,
								sum(linkcount) AS linkCountSum
						FROM
								$happy_banner_log_tb
						WHERE
								year	= '$getYear' AND
								month	= '$getMonth' AND
								day		= '$i'
						GROUP BY year,month,day
					";
			$Count2	= happy_mysql_fetch_array(query($Sql));
			$Count['viewCountSum']	= $Count['viewCountSum'] == '0' ? '' : $Count['viewCountSum'];
			array_push($statsArray3,$Count2['viewCountSum']);
		}
		$Count['linkCountSum']	= $Count['linkCountSum'] == '0' ? '' : $Count['linkCountSum'];

		array_push($statsArray1,$Count['viewCountSum']);
		array_push($statsArray2,$Count['linkCountSum']);
		array_push($statsArrayName,$oDate);
	}

	#echo implode(", ", (array) $statsArray1);

	$message          = iconv("utf-8", "euc-kr", $message);
	for($i = 0; $i < sizeof($pieArrayName); $i++)
	{
		 $pieArrayName[$i]          = iconv("utf-8", "euc-kr", $pieArrayName[$i]);
	}

	//그래프를 그릴 데이터가 없다면 보여주지 말자
	if ( array_sum($statsArray1) == 0 && array_sum($statsArray2) == 0 && array_sum($statsArray3) == 0 )
	{

		echo "
			<table width='1000' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td align='center'><img src='img/no_grahp.jpg'></td>
			</tr>
			</table>
		";



	}

	//그래프를 그릴 데이터가 없다면 보여주지 말자

	if ( $bannerSql != "" || $groupSql != "" )
	{
		happyGraphDraw_bar(
					720,									# 그래프 가로크기
					480,									# 그래프 세로크기
					$message,								# 타이틀 메세지
					'img/banner_back2.jpg',					# 그래프의 배경이미지경로
					$statsArray3,							# 그래프 배열값
					$statsArrayName,						# X측 배열 이름 ( 날짜등등 )
					'banner_graph/outimg/outimg1.jpg',		# 그래프를 저장할 이미지파일 이름 ( 777권한 필요 )
					$statsArray1,							# 추가 그래프 ( 파란색선으로 그려짐 )
					$statsArray2							# 추가 그래프 ( 빨강색선으로 그려짐 )
		);

	}
	else
	{
		happyGraphDraw_bar(
					720,									# 그래프 가로크기
					480,									# 그래프 세로크기
					$message,								# 타이틀 메세지
					'img/banner_back1.jpg',					# 그래프의 배경이미지경로
					$statsArray1,							# 그래프 배열값
					$statsArrayName,						# X측 배열 이름 ( 날짜등등 )
					'banner_graph/outimg/outimg1.jpg',		# 그래프를 저장할 이미지파일 이름 ( 777권한 필요 )
					$statsArray2,							# 추가 그래프 ( 파란색선으로 그려짐 )
					''										# 추가 그래프 ( 빨강색선으로 그려짐 )
		);
	}

	################################# 그래프1 종료 #######################################





	################################# 그래프2,3 시작 #######################################


	if ( $bannerSql == "" )		// 그룹명으로 넘어왔거나 전체배너통계일때
	{
		$pieArrayView	= Array();
		$pieArrayCount	= Array();
		$pieArrayName	= Array();

		if ( $groupSql != "" )
		{
			$addSql		= $groupSql;
			$groupBy	= 'year,month,bannerID';
			$message	= '배너별';
			$titleName	= 'bannerID';
		}
		else
		{
			$addSql		= '';
			$groupBy	= 'year,month,groupID';
			$message	= '그룹별';
			$titleName	= 'groupID';
		}

		$Sql	= "
					SELECT
							sum(viewcount) AS viewCountSum,
							sum(linkcount) AS linkCountSum,
							$titleName
					FROM
							$happy_banner_log_tb
					WHERE
							year	= '$getYear' AND
							month	= '$getMonth'
							$addSql
					GROUP BY $groupBy
				";
		$Record	= query($Sql);

		while ( $pieData = happy_mysql_fetch_array($Record) )
		{
			if ( $groupSql != "" )
			{
				$Sql	= "SELECT title FROM $happy_banner_tb WHERE number='".$pieData[$titleName]."'";
				$Tmp	= happy_mysql_fetch_array(query($Sql));
				$pieData[$titleName]	= $Tmp['title'];
			}

			$pieData['linkCountSum']	= $pieData['linkCountSum'] == '0' ? '1' : $pieData['linkCountSum'];

			array_push($pieArrayView,$pieData['viewCountSum']);
			array_push($pieArrayCount,$pieData['linkCountSum']);
			array_push($pieArrayName,$pieData[$titleName]);
		}
	}

	if ( $bannerSql != '' || ( $groupSql != '' && sizeof($pieArrayView) < 2 ) )	// 배너명으로 넘어왔거나 그룹명으로 넘어왔지만 값이 하나일때
	{
		$pieArrayView	= Array();
		$pieArrayCount	= Array();
		$pieArrayName	= Array();

		$message	= '전체배너에 대한 통계';

		$titleName	= $bannerSql != '' ? 'bannerID' : 'groupID';
		$titleValue	= $bannerSql != '' ? $bannerID : $groupID;
		$outTitle	= $bannerSql != '' ? $bannerName : $titleValue;


		#해당 그룹 혹은 배너의 뷰,링크 카운트 추출
		$Sql	= "
					SELECT
							sum(viewcount) AS viewCountSum,
							sum(linkcount) AS linkCountSum
					FROM
							$happy_banner_log_tb
					WHERE
							year	= '$getYear' AND
							month	= '$getMonth'
							$bannerSql
							$groupSql
					GROUP BY year,month,$titleName
				";
		$pieData = happy_mysql_fetch_array(query($Sql));

		$pieData['linkCountSum']	= $pieData['linkCountSum'] == '0' ? '1' : $pieData['linkCountSum'];

		array_push($pieArrayView,$pieData['viewCountSum']);
		array_push($pieArrayCount,$pieData['linkCountSum']);
		array_push($pieArrayName,$outTitle);


		#현재 그룹혹은 배너를 제외한 전체 카운트 추출
		$Sql	= "
					SELECT
							sum(viewcount) AS viewCountSum,
							sum(linkcount) AS linkCountSum,
							$titleName
					FROM
							$happy_banner_log_tb
					WHERE
							year	= '$getYear' AND
							month	= '$getMonth' AND
							$titleName != '$titleValue'
					GROUP BY year,month
				";
		$pieData = happy_mysql_fetch_array(query($Sql));

		$pieData['linkCountSum']	= $pieData['linkCountSum'] == '0' ? '1' : $pieData['linkCountSum'];

		array_push($pieArrayView,$pieData['viewCountSum']);
		array_push($pieArrayCount,$pieData['linkCountSum']);
		array_push($pieArrayName,'기타배너');
	}

	$message          = iconv("utf-8", "euc-kr", $message);
	for($i = 0; $i < sizeof($pieArrayName); $i++)
	{
		 $pieArrayName[$i]          = iconv("utf-8", "euc-kr", $pieArrayName[$i]);
	}

	happyGraphDraw_pie(
				700,									#파이그래프 가로크기
				450,									#파이그래프 세로크기
				$message,								#파이그래프 타이틀 메세지
				$pieArrayView,							#파이그래프 배열값
				$pieArrayName,							#파이그래픅 각 배열값에 해당하는 이름
				'banner_graph/outimg/outimg2.jpg'		#그래프를 저장할 이미지파일 이름 ( 777권한 필요 )
	);

	happyGraphDraw_pie(
				700,									#파이그래프 가로크기
				450,									#파이그래프 세로크기
				$message,								#파이그래프 타이틀 메세지
				$pieArrayCount,							#파이그래프 배열값
				$pieArrayName,							#파이그래픅 각 배열값에 해당하는 이름
				'banner_graph/outimg/outimg3.jpg'		#그래프를 저장할 이미지파일 이름 ( 777권한 필요 )
	);

	################################# 그래프2,3 종료 #######################################








print<<<END
						<!-- TBL -->
						<table width="100%" border="0" cellspacing="1" cellpadding="0" class=tbl_box2>

						<!-- 전체배너 통계 -->
						<tr bgcolor=white>
							<td width=140 align=center class='tbl_box2_item1' style='padding:10;'><div style='color:#FD7439; font-size:16pt; font-family:tahoma; font-weight:bold; margin:0 0 12 0;'>$getYear<font style='color:black; font-family:맑은 고딕,돋움; font-size:9pt;'>년</font> $getMonth<font style='color:black; font-family:맑은 고딕,돋움; font-size:9pt;'>월</font></div><font class=item_txt>전체배너통계 그래프</font></td>
							<td class=tbl_box2_padding align=center>

								<img src='banner_graph/outimg/outimg1.jpg' galleryimg=no><br><br><hr size=0 style='border:1px solid #CCC;'>

							</td>
						</tr>

						<!-- 배너그룹별 노출수 -->
						<tr bgcolor=white>
							<td align=center class='tbl_box2_item1' style='padding:10px;'><font class=item_txt>배너그룹별 노출수</font></td>
							<td class=tbl_box2_padding align=center>

								<p align='center'><img src='banner_graph/outimg/outimg2.jpg' border='0' galleryimg=no></p>

							</td>
						</tr>

						<!-- 배너그룹별 클릭수 -->
						<tr bgcolor=white>
							<td align=center class='tbl_box2_item1' style='padding:10px;'><font class=item_txt>배너그룹별 클릭수</font></td>
							<td class=tbl_box2_padding align=center>

								<p align='center'><img src='banner_graph/outimg/outimg3.jpg' border='0' galleryimg=no></p>

							</td>
						</tr>

						</table>
END;









####################################################################################################################################
############################################ 함수시작 ##############################################################################
####################################################################################################################################



function happyGraphDraw_bar( $width, $height, $message, $background, $arr1 , $arr_name , $file_name, $arr2="", $arr3="" )
{
	global $php_version1;

	if ( !is_array($arr1) || !is_array($arr_name) || sizeof($arr1) == 0 || sizeof($arr_name) == 0 )
		return print "";

	if ( $php_version1 == "5" )
	{
		$message	= str2uni($message);

		foreach($arr_name as $k => $v)
		{
			$arr_name[$k]	= str2uni($v);
		}

		foreach($arr1 as $k => $v)
		{
			$arr1[$k]		= str2uni($v);
		}
	}


	// Create the graph.
	$graph = new Graph($width,$height);
	$graph->SetScale("textlin");
	$graph->SetMarginColor('white');

	// Adjust the margin slightly so that we use the
	// entire area (since we don't use a frame)
	$graph->SetMargin(50,10,45,70);

	// Box around plotarea
	$graph->SetBox();

	// No frame around the image
	$graph->SetFrame(false);


	// Setup the tab title
	$graph->tabtitle->Set("$seller_info");
	$graph->tabtitle->SetFont(FF_SIMSUN,FS_NORMAL,10);

	$graph->SetShadow();
	$graph->title->Set("$message");
	$graph->title->SetFont(FF_SIMSUN,FS_NORMAL);
	/*
	$graph->xaxis->title->Set("아우러");
	$graph->yaxis->title->Set("아우러");
	$graph->xaxis->title->SetFont(FF_SIMSUN,FS_NORMAL);
	$graph->yaxis->title->SetFont(FF_SIMSUN,FS_NORMAL);
	*/

	// Setup the X and Y grid
	$graph->ygrid->SetFill(true,'#DDDDDD@0.5','#BBBBBB@0.5');
	$graph->ygrid->SetLineStyle('dashed');
	$graph->ygrid->SetColor('gray');
	$graph->xgrid->Show();
	$graph->xgrid->SetLineStyle('dashed');
	$graph->xgrid->SetColor('gray');


	// Setup month as labels on the X-axis
	$graph->xaxis->SetTickLabels($arr_name);
	$graph->xaxis->SetFont(FF_SIMSUN,FS_NORMAL,7);
	$graph->xaxis->SetLabelAngle(0);
	$graph->xaxis->SetColor('black');
	$graph->yaxis->SetColor('black');

	if ( $background != '' )
		$graph->SetBackgroundImage($background,BGIMG_COPY);

	// Create a bar pot
	$bplot = new BarPlot($arr1);
	$bplot->SetWidth(0.6);
	if ( $legend[0] != '' )
		$bplot->SetLegend($legend[0]);

	$fcol='#440000';
	$tcol='#FF9090';

	$bplot->SetFillGradient($fcol,$tcol,GRAD_LEFT_REFLECTION);

	// Set line weigth to 0 so that there are no border
	// around each bar
	$bplot->SetWeight(0);



	// Create a bar pot
	$bplot2 = new BarPlot($arr2);
	$bplot2->SetWidth(0.6);
	if ( $legend[0] != '' )
		$bplot2->SetLegend($legend[0]);

	$fcol='#440000';
	$tcol='#FF9090';

	$bplot2->SetFillGradient($fcol,$tcol,GRAD_LEFT_REFLECTION);

	// Set line weigth to 0 so that there are no border
	// around each bar
	$bplot2->SetWeight(0);


	$graph->Add($bplot);

	if ( is_array($arr2) )
	{
		$lplot = new LinePlot($arr2);
		$lplot->SetFillColor('skyblue@0.5');
		$lplot->SetColor('navy@0.7');
		$lplot->SetBarCenter();

		$lplot->mark->SetType(MARK_SQUARE);
		$lplot->mark->SetColor('blue@0.5');
		$lplot->mark->SetFillColor('lightblue');
		$lplot->mark->SetSize(6);

		if ( $legend[1] != '' )
			$lplot->SetLegend($legend[1]);
		$graph->Add($lplot);

	}

	if ( is_array($arr3) )
	{
		$lplot2 = new LinePlot($arr3);
		$lplot2->SetFillColor('pink@0.5');
		$lplot2->SetColor('pink@0.7');
		$lplot2->SetBarCenter();

		$lplot2->mark->SetType(MARK_SQUARE);
		$lplot2->mark->SetColor('red@0.5');
		$lplot2->mark->SetFillColor('red');
		$lplot2->mark->SetSize(6);

		if ( $legend[2] != '' )
			$lplot->SetLegend($legend[2]);

		$graph->Add($lplot2);
	}

	// .. and finally send it back to the browser
	$graph->Stroke($file_name);
}


####################################################################################################################################





function happyGraphDraw_pie( $width, $height, $message, $arr1, $arr_name, $file_name)
{
	global $php_version1;

	if ( !is_array($arr1) || !is_array($arr_name) || sizeof($arr1) == 0 || sizeof($arr_name) == 0 )
		return print "";

	if ( $php_version1 == "5" )
	{
		$message	= str2uni($message);

		foreach($arr_name as $k => $v)
		{
			$arr_name[$k]	= str2uni($v);
		}

		foreach($arr1 as $k => $v)
		{
			$arr1[$k]		= str2uni($v);
		}
	}


	$graph = new PieGraph($width,$height,"auto");
	$graph->SetShadow();
	$graph->title->Set("$message");
	$graph->title->SetFont(FF_SIMSUN,FS_NORMAL);

	$p1 = new PiePlot3D($arr1);
	$p1->ExplodeSlice(2);
	$p1->SetCenter(0.45);
	$p1->value->SetFont(FF_FONT1,FS_BOLD);
	$p1->value->SetColor("darkred");
	$p1->value->SetFormat('%.1f %%');

	if ( $php_version1 == "5" )
	{
		$p1->SetSize(0.35);
	}

	$p1->SetLegends($arr_name);
	$graph -> legend -> SetFont(FF_SIMSUN,FS_NORMAL, 8);

	$graph->Add($p1);
	$graph->Stroke($file_name);
}




####################################################################################################################################













	#샘플23번 샘플24번





	#하단 공통 HTML
		echo "";
		include ("tpl_inc/bottom.php");

		exit;

?>