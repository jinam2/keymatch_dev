<?
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");
	include ("../inc/underground.php");


	if ( !admin_secure("지하철설정") ) {
		error("접속권한이 없습니다.");
		exit;
	}


/*********************************************************
	★☆★☆★ 주의 ★☆★☆★
	디자인을 고치실때 꼭 백업 해두시고 하세요~
	자바스크립트가 많아서 여차 잘못하면 작동안됩니다.
	2008년1월 HappyCGI 곽재걸 제작
	눈돌아가시겟네..-.-;;
**********************************************************/

	//기본셋팅들 (특별히 안건드는게 좋은 설정들)
	$iconNum		= "12";				// 1번~??번 아이콘수를 입력하기~
	$iconListTR		= "6";				// 한줄에 출력수(블럭선택화면)

	$maxBlockWidth	= "50";				// 바둑판 가로칸수
	$maxBlockHeight	= "35";				// 바둑판 세로칸수
	$gubun			= "__";				// 구분필드
	$gubun2			= "+HappyCGI+";		// 구분필드2

	$standardX		= "0";				// 개별 역에 대한 X 위치 조절 좌표값 ( 0보다 작으면 왼쯕으로 / 0보다 크면 오른쪽으로 이동)
	$standardY		= "100";			// 개별 역에 대한 Y 위치 조절 좌표값 ( 0보다 작으면 위쪽으로 / 0보다 크면 아래쪽으로 이동)
	$controlX		= "1";				// 역이름 표시자 전체 X 좌표 조절값
	$controlY		= "1";				// 역이름 표시자 전체 Y 좌표 조절값
	$rotation		= "-35";			// 역이름 표시자 각도 설정 ( ' - ' 각도값으로 설정 0 > a > -80 )
	//////////////////////////////////////////////////

	$iconListTR++;

	#파일선택 select box 생성
	$loading_files	= filelist("../$xml_under_folder","xml_under_");
	$inputTag		= "<select name='xml_fileName' >";
	$inputTag		.= "	<option value=''>새파일</option>";
	for ( $z=0, $maxz=sizeof($loading_files) ; $z<$maxz ; $z++ )
	{
		$nowValue	= $loading_files[$z];
		if ( strpos($nowValue, 'HH') !== false )
		{
			continue;
		}
		$selected	= ( $_GET['xml_fileName'] == $nowValue )?" selected ":"";
		$nowValue2	= str_replace(".xml","",str_replace("xml_under_","",$nowValue));
		$inputTag	.= "<option value='$nowValue' $selected >$nowValue2</option>";
	}
	$inputTag	.= "</select>";


	if ( $_GET['xml_fileName'] != '' )	#수정시 넘어온 파일명을 기준으로 xml 파싱
	{
		//######### 파싱 기본 루틴 시작
		//$xmlFile	= iconv("utf-8","euc-kr",$_GET['xml_fileName']);
		$xmlFile	= $_GET['xml_fileName'];
		$xml = file_get_contents("../$xml_under_folder/$xmlFile");
		$parser = new XMLParser($xml);
		$parser->Parse();
		//######### 파싱 기본 루틴 종료

		if ( $_GET['mode'] == 'del' )	# 삭제루틴
		{
			if ( $xmlFile != '' )
				unlink("../$xml_under_folder/$xmlFile");
			gomsg("$xmlFile 이 삭제완료 되었습니다.","underground_maker.php");
			exit;
		}


		//배열에 포인트별 값 담기..
		$xmlDataArr		= Array();
		$i				= 0;
		$loading_script	= "";
		$map_list_val	= "";
		if( is_array( $parser->document->stationarea[0]->staion ) )
		foreach ( $parser->document->stationarea[0]->staion as $station )
		{
			$xmlDataArr[$i]	= Array();

			$xmlDataArr[$i]['name']			= $station->tagAttrs['name'];
			$xmlDataArr[$i]['pointX']		= $station->tagAttrs['coodinationx'];
			$xmlDataArr[$i]['pointY']		= $station->tagAttrs['coodinationy'];
			$xmlDataArr[$i]['check']		= $station->tagAttrs['check'];
			$xmlDataArr[$i]['lineType']		= $station->tagAttrs['linetype'];
			$xmlDataArr[$i]['url']			= $station->tagAttrs['url'];
			$xmlDataArr[$i]['target']		= $station->tagAttrs['target'];

			if ( $xmlDataArr[$i]['pointX'] != '' && $xmlDataArr[$i]['pointY'] != '' )
			{
				$map_list_tmp				= 	$xmlDataArr[$i]['name'] . $gubun .
												$xmlDataArr[$i]['pointX'] . $gubun .
												$xmlDataArr[$i]['pointY'] . $gubun .
												$xmlDataArr[$i]['check'] . $gubun .
												$xmlDataArr[$i]['lineType'] . $gubun .
												$xmlDataArr[$i]['url'] . $gubun .
												$xmlDataArr[$i]['target'];

				$xmlDataArr[$i]['xmlData']	= "\nxmlData[".$xmlDataArr[$i]['pointY']."][".$xmlDataArr[$i]['pointX']."] = '".$xmlDataArr[$i]['lineType'] ."_".$xmlDataArr[$i]['check'] ."'";

				//$map_list_tmp2	= iconv("UTF-8","CP949",$map_list_tmp);
				$map_list_tmp	= trim($map_list_tmp2) == '' ? $map_list_tmp : $map_list_tmp2;

				$xmlDataArr[$i]['xmlData2']	= "\nxmlData2[".$xmlDataArr[$i]['pointY']."][".$xmlDataArr[$i]['pointX']."] = \"". $map_list_tmp."\"";

				$loading_script				.= $xmlDataArr[$i]['xmlData'] . $xmlDataArr[$i]['xmlData2'];
				$map_list_val				.= ( $map_list_val == "" )?"":$gubun2;
				$map_list_val				.= $map_list_tmp;
			}

			$i++;
		}
		$map_list_val	.= $map_list_val == "" ?"":$gubun2;
		$loadingOnLoad	= $map_list_val == ""?"":"background_draw();";


		$default_title	= str_replace("xml_under_","",str_replace(".xml","",$xmlFile));
		//$default_title	= iconv("euc-kr","utf-8",$default_title);
		$title_readOnly	= "readonly";

		$default_speed	= $parser->document->option[0]->tagAttrs['speed'];					// 라인애니메이션속도
		$default_scale	= $parser->document->option[0]->tagAttrs['elasticscale'];			// 탄력적인액션
		if ( $default_scale == "1" ) {
			$default_scale1	= "checked";	// 탄력적인액션 사용에 체크유무
			$default_scale2	= "";			// 탄력적인액션 미사용에 체크유무
		}
		else {
			$default_scale1	= "";			// 탄력적인액션 사용에 체크유무
			$default_scale2	= "checked";	// 탄력적인액션 미사용에 체크유무
		}
		$default_color1	= str_replace("0x","",$parser->document->stationarea[0]->tagAttrs['linecolor']);	// 선색상
		$default_color2	= str_replace("0x","",$parser->document->stationarea[0]->tagAttrs['pointcolor']);	// 역아이콘색상

		$iconWidth		= $parser->document->option[0]->tagAttrs['linewidth'];		// 아이콘가로크기
		$iconHeight		= $parser->document->option[0]->tagAttrs['lineheight'];		// 아이콘세로크기
		$blockWidth		= $parser->document->option[0]->tagAttrs['countx'];			// 바둑판 가로칸수
		$blockHeight	= $parser->document->option[0]->tagAttrs['county'];			// 바둑판 세로칸수

	}
	else
	{
		$xmlFile		= "";
		$default_title	= "";			// 기본 타이틀(지하철호선)
		$default_speed	= "1";			// 라인애니메이션속도
		$default_scale1	= "checked";	// 탄력적인액션 사용에 체크유무
		$default_scale2	= "";			// 탄력적인액션 미사용에 체크유무
		$default_color1	= "DE0029";		// 선색상
		$default_color2	= "FF0000";		// 역아이콘색상

		$iconWidth		= "25";			// 아이콘가로크기
		$iconHeight		= "25";			// 아이콘세로크기
		$blockWidth		= "30";			// 바둑판 가로칸수
		$blockHeight	= "20";			// 바둑판 세로칸수

		$map_list_val	= "";			//수정필요없음 공백
	}

	$widthSize	= $blockWidth;
	$heightSize	= $blockHeight;



	//XML파일로 저장하자!!!!!!!!
	if ( $_GET['mode'] == 'reg' && $_POST )
	{
		if ( $demo_lock )
		{
			error("데모버젼은 수정하실수 없습니다.");
			exit;
		}
		$datas			= explode($gubun2,$_POST['map_list']);
		$title			= str_replace("'","",$_POST['title']);
		$title			= str_replace(" ","",$title);
		$lineColor		= str_replace("'","",$_POST['lineColor']);
		$pointColor		= str_replace("'","",$_POST['pointColor']);
		$speed			= preg_replace("/\D/","",$_POST['speed']);
		$lineWidth		= preg_replace("/\D/","",$_POST['lineWidth']);
		$lineHeight		= preg_replace("/\D/","",$_POST['lineHeight']);
		$elasticScale	= preg_replace("/\D/","",$_POST['elasticScale']);
		$stageWidth		= preg_replace("/\D/","",$_POST['width_size']);
		$stageHeight	= preg_replace("/\D/","",$_POST['height_size']);

		//$title_real = iconv("utf-8","euc-kr",$title);
		$title_real = $title;

		#초기화폼
		/*
		$Tmp		= happy_mysql_fetch_array(query("select count(*) FROM $job_underground_tb WHERE title='$title' AND depth='1'"));
		if ( $Tmp[0] == 0 )
		{
			$Tmp	= happy_mysql_fetch_array(query("select * FROM $job_underground_tb WHERE depth='1' ORDER BY sort DESC LIMIT 1"));
			$tSort	= $Tmp['sort'];
			query("INSERT INTO $job_underground_tb SET title='$title', sort='$tSort', depth='1',underground1='0'");
		}
		$oTmp	= happy_mysql_fetch_array(query("select * FROM $job_underground_tb WHERE title='$title' AND depth='1'"));
		*/
		#초기화폼 종료

		$content	= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n\n";

		$content	.= "<stationStart>\n";
		$content	.= "\t<stationArea title=\"$title_real\" standardX=\"$standardX\" standardY=\"$standardY\" lineColor=\"0x$lineColor\" pointColor=\"0x$pointColor\">\n";

		for ( $i=0,$max=sizeof($datas) ; $i< $max ; $i++ )
		{
			$Data		= explode($gubun,$datas[$i]);
			//$Data[0]	= iconv("utf-8","euc-kr",$Data[0]);
			//$Data[5]	= iconv("utf-8","euc-kr",$Data[5]);
			if ( $Data[2] != '' && $Data[1] != '' )
			{

				#초기화폼
				/*
				$ooo	= str_replace(' ','',$Data[0]);
				if ( $ooo != '' )
				{
					$Tmp		= happy_mysql_fetch_array(query("select count(*) FROM $job_underground_tb WHERE title='$Data[0]' AND depth='2' AND underground1='$oTmp[number]'"));
					if ( $Tmp[0] == 0 )
					{
						query("INSERT INTO $job_underground_tb SET title='$Data[0]', sort='1', depth='2',underground1='$oTmp[number]'");
					}
				}
				*/
				#초기화폼 종료

				$Data[5]	= stripslashes($Data[5]);
				$xmlOutput[$Data[1]."-".$Data[2]]	= "\t\t<staion name=\"$Data[0]\" coodinationX=\"$Data[1]\" coodinationY=\"$Data[2]\" check=\"$Data[3]\" lineType=\"$Data[4]\" url=\"$Data[5]\" target=\"$Data[6]\"/>\n";
				//$content	.= "\t\t<staion name=\"$Data[0]\" coodinationX=\"$Data[1]\" coodinationY=\"$Data[2]\" check=\"$Data[3]\" lineType=\"$Data[4]\" url=\"$Data[5]\" target=\"$Data[6]\"/>\n";
			}
		}

		$content	.= @implode("", (array) $xmlOutput);
		$content	.= "\t</stationArea>\n";
		$content	.= "\t<option speed=\"$speed\" rotation=\"$rotation\" controlX=\"$controlX\" controlY=\"$controlY\" lineWidth=\"$lineWidth\" lineHeight=\"$lineHeight\" elasticScale=\"$elasticScale\" countX='$stageWidth' countY='$stageHeight' />\n";
		$content	.= "</stationStart>";

		$fileName	= "../$xml_under_folder/xml_under_". str_replace('%', 'HH', $_POST['title_encode']).".xml";
		$fp			= fopen($fileName,"w+");
		@fwrite($fp,$content);

		$fileName2	= "../$xml_under_folder/xml_under_$title.xml";
		$fileName	= "../$xml_under_folder/xml_under_$title_real.xml";
		$fp			= fopen($fileName,"w+");
		@fwrite($fp,$content);

		gomsg(" $fileName2 으로 파일이 생성되었습니다. \\n 파일이 생성되지 않았을때는 $xml_under_folder 폴더의 권한을 777로 주시면 됩니다.","?");
		exit;
	}







	#xmlData 변수는 초기에 맵 그릴때만 사용
	$xmlData	= "var xmlData	= new Array();\n";
	for ( $i=0 ; $i<$maxBlockHeight; $i++ )
	{
		$xmlData	.= "xmlData[$i]	= new Array();\n";
	}


	#xmlData2 변수는 나중에 아이콘/역이름등 변경시 사용
	$xmlData2	= "var xmlData2	= new Array();\n";
	for ( $i=0 ; $i<$maxBlockHeight; $i++ )
	{
		$xmlData2	.= "xmlData2[$i]	= new Array();\n";
	}


	//선택하는 아이콘들 배치
	$iconList	= "<table bgcolor='gray' border='0' cellspacing='1' cellpadding='0'>";
	$imgLoading	= "";
	for ( $i=1 ; $i<=$iconNum ; $i++ )
	{
		$nowNum		= ( $i<10 )?"0".$i : $i;
		if ( $i == 1 )
			$iconList	.= "<tr>";
		if ( $i % $iconListTR == 0 )
			$iconList	.= "</tr><tr>";

		$iconList	.= "<td width='$iconWidth' height='$iconHeight'><img src='./img/line". $nowNum ."_0.gif' width='$iconWidth' height='$iconHeight' border='1' style='cursor:pointer;border-color: white' id='select_img_$nowNum' onClick=\"select_image('$nowNum')\"></td>";

		$imgLoading	.= $imgLoading == "" ? "" : ",";
		$imgLoading	.= "'./img/line". $nowNum ."_0.gif'";
	}
	$iconList	.= "</table>";


$bodyOnLoad	= "onLoad=\"MM_preloadImages($imgLoading);$loadingOnLoad\"";
$bodyOnLoad	= ";MM_preloadImages($imgLoading);$loadingOnLoad";
$bodyOnLoad	= "MM_preloadImages($imgLoading);$loadingOnLoad";
################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################

	echo <<<END

<div class="main_title">$now_location_subtitle
	<span class="small_btn">
		<a href="http://cgimall.co.kr/xml_manual/manual_main.php?db_name=manual_adultjob&number=11" target="_blank" class="btn_small_yellow">도움말</a>
	</span>
</div>
<div id="box_style">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>
	<table cellspacing="1" cellpadding="0" border="0" class='bg_style'>
	<colgroup>
	<col style="width:15%;"></col>
	<col style="width:85%;"></col>
	</colgroup>
	<tr>
		<th>파일 불러오기</th>
		<td style="border-bottom:0 none" class="input_style_adm">
			<p class="short">각 지하철 노선파일을 불러 옵니다.</p>
			<form name='search_frm' method='get' name='fileSelect_frm' style='margin:0; padding:0px;'>
			<input type='hidden' name='mode' value=''>

			$inputTag <input type='submit' value='+ 불러오기' class="btn_small_dark2"> <input type='button' value='- 삭제하기' onClick="if ( confirm('정말 파일을 삭제하시겠습니까?')){ this.form.mode.value = 'del';this.form.submit(); }" class="btn_small_red">

			</form>
		</td>
	</tr>
	</table>
</div>

	<form name='ground_frm' id='ground_frm' method="post" action="?mode=reg" style='margin:0px; padding:0px;'>
<div id="box_style">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>
	<table cellspacing="1" cellpadding="0" border="0" class='bg_style'>
	<colgroup>
	<col style="width:15%;"></col>
	<col style="width:85%;"></col>
	</colgroup>
	<tr>
		<th>지하철 제목보기</th>
		<td>
			<p class="short">불러온 역의 제목은 변경할 수 없습니다.</p>
			<input type='hidden' name='map_list' id='map_list' value="$map_list_val" size='100'>
			<input type='hidden' name='title_encode' id='title_encode' value="" size='100'>
			<input type='text' name='title' id='title' value='$default_title' style="width:250px;" $title_readOnly >

			<div style='margin-top:10px;'> <img src='img/um01.gif'></div>
		</td>
	</tr>
	<tr>
		<th>노선도 라인색상</th>
		<td>
			<p class="short">지하철 노선의 라인색상을 지정 합니다. (HTML색상 코드를 입력합니다. 단, #은 입력하지 않습니다.)</p>
			# <input type='text' name='lineColor' id='lineColor' value='$default_color1' style="width:100px;">
			<div style='margin-top:10px;'> <img src='img/um02.gif'></div>
		</td>
	</tr>
	<tr>
		<th>역 아이콘 색상</th>
		<td>
			<p class="short">역의 색상을 지정 합니다. (HTML색상 코드를 입력합니다. 단, #은 입력하지 않습니다.)</p>
			# <input type='text' name='pointColor' id='pointColor' value='$default_color2' style="width:100px;">
			<div style='margin-top:10px;'> <img src='img/um03.gif'></div>

		</td>
	</tr>
	<tr>
		<th>바둑판 가로사이즈</th>
		<td>
			<p class="short">생성되는 바둑판의 가로사이즈를 지정 합니다.</p>
			<input type='text' name='lineWidth' id='lineWidth' value='$iconWidth' style="width:30;" onKeyPress="if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;" > 픽셀
			<div style='margin-top:10px;'> <img src='img/um04.gif'></div>
		</td>
	</tr>
	<tr>
		<th>바둑판 세로사이즈</th>
		<td>
			<p class="short">생성되는 바둑판의 가로 사이즈를 지정 합니다.</p>
			<input type='text' name='lineHeight' id='lineHeight' value='$iconHeight' style="width:30;" onKeyPress="if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;" > 픽셀
			<div style='margin-top:10px;'> <img src='img/um04.gif'></div>
		</td>
	</tr>
	<tr>
		<th>바둑판 가로X세로 갯수</th>
		<td>
			<p class="short">생성되는 바둑판의 갯수를 지정 합니다.</p>
			<input type='hidden' name='speed' id='speed' value='$default_speed' size='2' onKeyPress="if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;" >

			가로 : <input type='text' name='width_size' id='width_size'  onKeyPress="if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;" style="width:30px; margin-bottom:5px;" value='$widthSize'> 개<br>
			세로 : <input type='text' name='height_size' id='height_size'  onKeyPress="if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;" style="width:30px;" value='$heightSize'> 개

			<input type='button' value='+ 바둑판생성' onClick="background_draw()" class="btn_small_dark">
		</td>
	</tr>
	<tr>
		<th>반응 모션 설정</th>
		<td>
			<p class="short">마우스를 역에 마우스를 올렸을때 액션을 줄지 주지 않을지를 정할 수 있습니다. 역의 갯수가 많을때는 느려질수 있습니다.</p>
			<input type='hidden' name='speed' id='speed' value='$default_speed' size='2' onKeyPress="if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;" >
			<input type="radio" name='elasticScale' value="1" $default_scale1> 사용
			<input type="radio" name="elasticScale" value="0" $default_scale2> 미사용
		</td>
	</tr>
	<tr>
		<th>XML 파일저장</th>
		<td>
			<p class="short">저장을 하시면 ./xml_under_folder/xml_under_{지하철제목}.xml 파일로 저장이 됩니다.<br>기존파일이 있을경우 삭제후 새로운 파일을 생성후 저장이 됩니다.</p>
			<a onClick='save_xml_file()' class='btn_small_yellow'><b>XML파일로 저장</b></a>
		</td>
	</tr>
	</table>
	</form> <!-- 폼태그 위치 조심 -->
</div>

<!-- 바둑판을 그려야할 DIV -->
<div id="box_style_xml">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>
	<p class="short">아래의 바둑판에서 지하철을 설정할 수 있습니다. 빈바둑판을 클릭하여 역라인 및 일반역 환승역을 생성할 수 있습니다.</p>
	<div style="position:relative;">
		<div style="position:absolute;top:0px;left:0px; border" id="underground_box"></div>
	</div>
	<div id='background' align='center'></div>
	<!-- 바둑판을 그려야할 DIV 끝 -->
</div>


<!-- 블럭 선택시 오픈되는 레이어 -->


<div id='selectBlock' style="display:none;">
	<table border="1" bgcolor='#666666' cellspacing="1" cellpadding="0">
	<tr>
		<td style='padding:0;'>
			<form name='sel_frm'>
			<input type='hidden' name='sumValue' value=''>
			<table bgcolor='#FFFFCC'>
			<tr>
				<td align='center'>$iconList</td>
			</tr>
			<tr>
				<td align='center'>
					<input type='radio' name='station' value='0' onClick="select_station('0','none');">역아님
					<input type='radio' name='station' value='1' checked onClick="select_station('1','');">일반역
					<input type='radio' name='station' value='2' onClick="select_station('2','');">환승역
				</td>
			</tr>
			<tr id='station_name_tr' style='display:none'>
				<td style='padding-left:5px;'>역이름 : <input type='text' name='station_name' id='station_name' value='' size='18' onKeyUp="select_stationNameInput()"></td>
			</tr>
			<tr >
				<td style='padding-left:5px;'>링크 : <input type='text' name='station_link' id='station_link' value="" size='20' ></td>
			</tr>
			<tr >
				<td style='padding-left:5px;'>
					타겟 :
					<select name='station_target' id='station_target' onChange="select_target()">
					<option value='0'>_self</option>
					<option value='1'>_blank</option>
					<option value='2'>_parent</option>
					<option value='3'>_top</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="center">
					<input type='button' value='저장하기' onClick="select_save()" class="btn_small_stand">
					<input type='button' value='취소(닫기)' onClick="underShowHideLayer2('underground_box','','hide');" class="btn_small_dark">
				</td>
			</tr>
			</table>
			</form>
		</td>
	</tr>
	</table>
	<!-- 블럭 선택시 오픈되는 레이어 끝 -->
</div>



		<script>

			$xmlData

			$xmlData2

			$loading_script

			var start_map_list				= "$map_list_val";

			var selectBlockHtml				= document.getElementById('selectBlock').innerHTML;
			var default_lineNum				= '${iconNum}_0';	//배경에 깔릴 아이콘 넘버
			var prev_select_img				= 'select_img_01';	//최고 선택되어진 선모양 img의 id값
			var gubun						= '$gubun';			//데이타넘길때 구분값
			var gubun2						= '$gubun2';		//데이타넘길때 아이콘별 구분값
			var maxBlockWidth				= $maxBlockWidth;	//최대가로수
			var maxBlockHeight				= $maxBlockHeight;	//최대세로수

			var iconWidth					= '';				//한개아이콘가로크기			- [★수정필요없음.. 빈값입력★]
			var iconHeight					= '';				//한개아이콘세로크기			- [★수정필요없음.. 빈값입력★]
			var widthSize					= '';				//가로칸수						- [★수정필요없음.. 빈값입력★]
			var heightSize					= '';				//세로칸수						- [★수정필요없음.. 빈값입력★]
			var make_chk					= 'N';				//수정 절대 하지마시오.

			var default_title				= '';				//지하철 몇호선?				- [★수정필요없음.. 빈값입력★]
			var default_selImgNo			= '01';				//선모양 선택화면에서 초기선택번호
			var default_selStationNo		= '1';				//선모양 선택화면에서 초기 역정보 ( value값입력 )
			var default_stationNameDisplay	= '';				//선모양 선택화면에서 초기 역이름작성 display = ? ( 공백 혹은 none )
			var default_stationTarget		= '0';				//선모양 선택화면에서 타겟선택

			var now_layer					= '';				//현재 선택한 칸의 레이어명		- [★수정필요없음.. 빈값입력★]
			var now_selImgNo				= '01';				//현재 선택한 선모양 (선 선택화면에서)
			var now_stationNo				= '0';				//현재 선택한 역아님,일반역,환승역
			var now_stationName				= '';				//현재 입력한 역이름			- [★수정필요없음.. 빈값입력★]
			var now_link					= '';				//현재 입력한 링크				- [★수정필요없음.. 빈값입력★]
			var now_x						= '';				//현재 선택한 좌표 X
			var now_y						= '';				//현재 선택한 좌표 Y
		</script>

		<script>
			//배경을 깔아부려 ~~
			function background_draw()
			{
				default_title		= document.getElementById('title').value;
				widthSize			= document.getElementById('width_size').value;
				heightSize			= document.getElementById('height_size').value;
				var content			= "<table bgcolor='gray' border='0' cellspacing='1' cellpadding='0'>";

				now_layer			= "";
				iconWidth			= document.getElementById('lineWidth').value;
				iconHeight			= document.getElementById('lineHeight').value;

				underShowHideLayer2('underground_box','','hide');
				document.getElementById('map_list').value	= start_map_list;

				if ( widthSize == '' || heightSize == '' ) {
					alert('가로,세로를 입력후 생성해주세요.');
					return false;
				}

				if ( widthSize > maxBlockWidth ) {
					alert('가로칸수는 '+ maxBlockWidth +'칸이상 입력하실수 없습니다.');
					return false;
				}

				if ( heightSize > maxBlockHeight ) {
					alert('세로칸수는 '+ maxBlockHeight +'칸이상 입력하실수 없습니다.');
					return false;
				}

				if ( iconWidth == '' || iconHeight == '' ) {
					alert('출력아이콘의 가로,세로 크기를 입력후 생성해주세요.');
					return false;
				}

				if ( default_title == '' ) {
					alert('타이틀(지하철호선)을 입력후 생성해주세요.');
					return false;
				}

				for ( i=0 ; i<heightSize ; i++ )
				{
					content	+= "<tr bgcolor='white'>\\n";
					for ( j=0 ; j<widthSize ; j++ )
					{
						if ( xmlData[i][j] == '' || xmlData[i][j] == undefined )
							lineNum	= default_lineNum;
						else
							lineNum	= xmlData[i][j];
						content	+= "<td width='"+ iconWidth +"' height='"+ iconHeight +"'><img src='./img/line"+ lineNum +".gif' id='"+i+"_"+j+"_img' onClick=changeBox('"+i+"_"+j+"_img') widht='"+ iconWidth +"' height='"+ iconHeight +"' style='cursor:pointer'></td>\\n";
					}
					content	+= "</tr>\\n";
				}
				content	+= "</table>";

				document.getElementById('background').innerHTML		= content;
				document.getElementById('selectBlock').innerHTML	= '';
				make_chk	= 'Y';
			}

			function underShowHideLayer2(LayerName, tttt, State)
			{
				if ( State == 'show' )
				{
					document.getElementById(LayerName).style.display = '';
				}
				else
				{
					document.getElementById(LayerName).style.display = 'none';
				}
			}

			//선모양,역선택,역이름작성,링크주소 입력하는 레이어창 띄우기 함수
			function changeBox( layName )
			{
				var imsiHTML	= selectBlockHtml;

				now_layer		= layName;

				document.getElementById('underground_box').innerHTML	= imsiHTML;
				underShowHideLayer2('underground_box','','show');


				now_layer_split	= now_layer.split("_");
				now_x			= parseInt(now_layer_split[0]);
				now_y			= parseInt(now_layer_split[1]);

				xmlD			= xmlData2[now_x][now_y];

				if ( xmlD == '' || xmlD == undefined )		//data가 업으면 그냥 default값들 불러온다.
				{
					select_image( default_selImgNo );
					select_station( default_selStationNo , default_stationNameDisplay );
					document.getElementById('station_target').value	= default_stationTarget;
					select_stationNameInput();
				}
				else										//data가 있으니 변수분해해서 그 값들을 불러온다.
				{
					xmlDs	= xmlD.split(gubun);

					select_image( xmlDs[4] );
					select_station( xmlDs[3] , '' );
					document.getElementById('station_target').value	= xmlDs[6];
					document.getElementById('station_name').value	= xmlDs[0];
					document.getElementById('station_link').value	= xmlDs[5];
				}
			}


			//선모양 선택화면에서 선모양 아이콘 클릭시 일어나는 이벤트
			function select_image( selImgNo )
			{
				select_img			= "select_img_"+ selImgNo;
				default_selImgNo	= selImgNo;

				document.getElementById( prev_select_img ).style.borderColor	= 'white';
				document.getElementById( select_img ).style.borderColor		= 'red';

				prev_select_img	= select_img;
				now_selImgNo	= selImgNo;
			}


			//선모양 선택화면에서 역선택시 일어나는 이벤트
			function select_station( selStationNo, StationNameDisplay )
			{
				now_stationNo			= selStationNo;
				default_selStationNo	= selStationNo;
				var radio_obj			= document.getElementById('station');

				document.sel_frm.station[selStationNo].checked = true;
				document.getElementById('station_name_tr').style.display= StationNameDisplay;
			}


			//선모양 선택화면에서 역이름 입력시 일어나는 이벤또 onKeyUp
			function select_stationNameInput( )
			{
				stationName_value	= document.getElementById('station_name').value;
				link_tmp			= "javascript:underlink('"+ default_title +"','"+ stationName_value +"')";

				document.getElementById('station_link').value	= link_tmp;

				now_stationName		= stationName_value;
				now_link			= link_tmp;
			}


			//선모양 선택화면에서 타겟을 변경했을때 다음 블럭선택시에도 해당타겟이 자동선택되게끔 하기
			function select_target()
			{
				var imsiSel				= document.getElementById('station_target').selectedIndex;
				default_stationTarget	= document.getElementById('station_target').options[imsiSel].value;
			}


			//선모양 선택화면에서 저장버튼 눌렀을때~
			function select_save()
			{
				document.getElementById(now_layer).src	= "./img/line"+ now_selImgNo +"_"+ now_stationNo +".gif";
				underShowHideLayer2('underground_box','','hide');

				outXml	= now_stationName +gubun+ now_y +gubun+ now_x +gubun+ now_stationNo +gubun+ now_selImgNo +gubun+ now_link +gubun+ default_stationTarget;

				xmlData2[now_x][now_y]	= outXml;

				document.getElementById('map_list').value	= document.getElementById('map_list').value + outXml + gubun2;
			}


			//XML파일로 저장하기!!!
			function save_xml_file()
			{
				if ( make_chk != 'Y' )
				{
					alert('바둑판생성후 이용해주세요.');
					return false;
				}

				document.getElementById('title').value			= default_title;
				document.getElementById('width_size').value		= widthSize;
				document.getElementById('height_size').value	= heightSize;
				document.getElementById('lineWidth').value		= iconWidth;
				document.getElementById('lineHeight').value		= iconHeight;


				var chk_lineColor		= document.getElementById('lineColor').value;
				var chk_pointColor		= document.getElementById('pointColor').value;
				var chk_speed			= document.getElementById('speed').value;

				if ( chk_lineColor == '' ) {
					alert('선색상을 입력해주세요.');
					return false;
				}
				else if ( chk_pointColor == '' ) {
					alert('역아이콘 색상을 입력해주세요.');
					return false;
				}
				else if ( chk_speed == '' ) {
					alert('라인 애니메이션 속도를 입력해주세요.');
					return false;
				}
				else {
					document.getElementById('title_encode').value	= encodeURI(default_title);
					document.getElementById('ground_frm').submit();
				}

			}


			//지정한 이미지 미리 로딩해두기
			function MM_preloadImages() { //v3.0
				var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
				var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
				if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
			}


		</script>

		<script type="text/javascript">
			$bodyOnLoad
		</script>


END;

include ("tpl_inc/bottom.php");


?>
