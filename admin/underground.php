<?
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");


	if ( !admin_secure("지하철설정") ) {
		error("접속권한이 없습니다.");
		exit;
	}

	include ("tpl_inc/top_new.php");

/*********************************************************
	★☆★☆★ 주의 ★☆★☆★
	디자인을 고치실때 꼭 백업 해두시고 하세요~
	자바스크립트가 많아서 여차 잘못하면 작동안됩니다.
	역세권 셀렉트박스를 부를려면
	<SCRIPT language="javascript" src="./js/underground.js"></SCRIPT>
	<script>make_underground('값1','값2')</script>
	2008년1월 HappyCGI 곽재걸 제작
**********************************************************/

	$mode		= $_GET['mode'];
	$number		= $_GET['number'];
	$maxDepth	= 2;


	if ( $mode == '' )
	{
		if ( $number != '' )
		{
			$Sql		= "SELECT title,depth FROM $job_underground_tb WHERE number='$number' ";
			$Tmp		= happy_mysql_fetch_array(query($Sql));
			$depth		= $Tmp[1] + 1;
			$nowCate	= $Tmp[0]." 관리";
		}
		else
		{
			$depth		= 1;
			$nowCate	= "<p class='main_title'>역세권 설정</p>";
		}

		ground_admin($depth,$number);
	}
	else if ( $mode == 'reg' )
	{
		if ( $demo_lock )
		{
			error("데모버젼은 수정하실수 없습니다.");
			exit;
		}
		$number		= $_POST['number'];
		$ndepth		= $_POST['ndepth'];
		$udepth		= $ndepth - 1;
		$changeList	= explode("||||",$_POST['groundChangeList']);
		$deleteList	= explode(",",$_POST['groundDeleteList']);


		#일단 삭제한것들 삭제하자
		for ( $i=0, $max=sizeof($deleteList) ; $i<$max ; $i++ )
		{
			$num	= $deleteList[$i];
			if ( $ndepth < $maxDepth && $ndepth != 1 && $ndepth )
			{
				query("DELETE FROM $job_underground_tb WHERE underground${ndepth} = '$num'");
			}
			query("DELETE FROM $job_underground_tb WHERE number = '$num'");
		}

		#수정된것들 차례대로 입력 및 수정해버리자
		if ( $ndepth != '1' && $number != '' )
			$addSql	= ", depth='$ndepth', underground${udepth}='$number' ";
		else
			$addSql	= ", depth='$ndepth'";

		for ( $i=0, $max=sizeof($changeList) ; $i<$max ; $i++ )
		{
			list($num, $names)	= explode("___",$changeList[$i]);

			#번호가 0인것은 새로추가된것임
			if ( $num == '0' )
				$Sql	= "INSERT INTO $job_underground_tb SET title='$names', sort='$i' $addSql";
			else
				$Sql	= "UPDATE $job_underground_tb SET  title='$names', sort='$i' $addSql WHERE number='$num' ";

			query($Sql);
			#echo $Sql."<br>";
		}


		#등록된 기존 xml 파일 불러오기
		$loading_files	= filelist("../$xml_under_folder","xml_under_");
		$fileSize		= " xmlFileWidth = new Array();\n xmlFileHeight = new Array();\n ";
		for ( $z=0, $maxz=sizeof($loading_files) ; $z<$maxz ; $z++ )
		{
			$fileName	= $loading_files[$z];

			//######### 파싱 기본 루틴 시작
			$xml = file_get_contents("../$xml_under_folder/$fileName");
			$parser = new XMLParser($xml);
			$parser->Parse();

			$iconWidth		= $parser->document->option[0]->tagAttrs['linewidth'];		// 아이콘가로크기
			$iconHeight		= $parser->document->option[0]->tagAttrs['lineheight'];		// 아이콘세로크기
			$blockWidth		= $parser->document->option[0]->tagAttrs['countx'];			// 바둑판 가로칸수
			$blockHeight	= $parser->document->option[0]->tagAttrs['county'];			// 바둑판 세로칸수
			//######### 파싱 기본 루틴 종료

			$flashWidth		= $iconWidth * $blockWidth;
			$flashHeight	= $iconHeight * $blockHeight + 120;

			$fileSize	.= " xmlFileWidth['$fileName']	= '$flashWidth'; \n xmlFileHeight['$fileName']	= '$flashHeight';\n ";
		}



		######## js 파일로 저장 ##################################################
		$Sql	= "SELECT * FROM $job_underground_tb WHERE depth='1' ORDER BY sort ASC, title ASC";
		$Record	= query($Sql);

		$groundList	= "
			//이파일은 admin/underground.php 에서 조절됩니다.
			//권한을777로 주셔야 하며 수정은 관리자모드의 역세권관리에서 해주시기 바랍니다.
			//이파일에 반영을 위해서는 관리자모드 -> 구인구직관리 -> 역세권설정 -> 수정된 내용 DB에저장 을 하시면 됩니다.

			$fileSize

			var under1_title	= new Array();
			var under1_numbe	= new Array();
			var under1_getTitle	= new Array();
			var under2_title	= new Array();
			var under2_numbe	= new Array();
			var under2_getTitle	= new Array();
					";
		$Count		= 0;
		$groundNext	= array();
		$groundNum	= array();
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$groundList	.= "
				under1_title[$Count]	= '$Data[title]';
				under1_numbe[$Count]	= '$Data[number]';
				under1_getTitle['$Data[title]']	= '$Data[number]';

				under2_title[$Data[number]]	= new Array();
				under2_numbe[$Data[number]]	= new Array();
				under2_getTitle['$Data[title]']	= new Array();
				";

			$Sql	= "SELECT number,title FROM $job_underground_tb WHERE depth = '2' AND underground1 = '$Data[number]' ORDER BY sort ASC, title ASC";
			$Rec	= query($Sql);
			$j		= 0;
			while ( $Tmp = happy_mysql_fetch_array($Rec) )
			{
				$groundList	.= "
					under2_title[$Data[number]][$j]	= '$Tmp[title]';
					under2_numbe[$Data[number]][$j]	= '$Tmp[number]';
					under2_getTitle['$Data[title]']['$Tmp[title]']	= '$Tmp[number]';
					";
				$j++;
			}

			$Count++;

		}
		#select 만들어주는 함수 제작
		$groundList	.= "
			//select 자동생성 함수
			function make_underground( nowNum, nowNum2 )
			{
				var under1_maxlen	= under1_title.length;
				var sel	= \"<select name='underground1' id='underground1' onChange=underground_change('')>\";
				sel	+= \"<option value=''>역세권선택</option>\";
				for ( i=0 ; i<under1_maxlen ; i++ )
				{
					selected	= nowNum == under1_numbe[i] ?'selected':'';
					sel	+= \"<option value='\"+ under1_numbe[i] +\"' \"+selected+\">\"+ under1_title[i] +\"</option>\";
				}
				sel	+= '</select>';

				sel	+= \" <select name='underground2' id='underground2'><option value=''>지하철역 선택</option></select>\";

				document.write(sel);
				if ( nowNum != '0' && nowNum != '' )
					underground_change( nowNum2 );
			}


			//역세권 선택시 지하철 역 출력함수
			function underground_change( nowNum2 )
			{
				var obj_under1	= document.getElementById('underground1');
				var obj_under2	= document.getElementById('underground2');
				var nowSelect	= obj_under1.selectedIndex;
				var nowNumber	= obj_under1.options[nowSelect].value;
				var nowText		= obj_under1.options[nowSelect].text;

				if ( nowSelect > 0 )
				{
					var under2_max	= obj_under2.length;
					for ( i=0 ; i<under2_max ; i++ )
					{
						obj_under2.options[0] = null;
					}

					var maxLen		= under2_numbe[nowNumber].length;
					var selected	= 0;

					obj_under2.options[0]	= new Option(nowText+' 지하철역 선택','',true);
					for ( i=0,j=1 ; i<maxLen ; i++,j++ )
					{
						selected	= nowNum2 == under2_numbe[nowNumber][i] ?j:selected;
						obj_under2.options[j]	= new Option(under2_title[nowNumber][i],under2_numbe[nowNumber][i]);
					}

					obj_under2.selectedIndex	= selected;
				}
			}


			var nowStation	= '';
			//검색에 사용될 select 자동생성 함수
			function make_underground2( nowNum , nowStationTmp )
			{
				nowStation	= nowStationTmp;
				var under1_maxlen	= under1_title.length;
				var sel	= \"<select name='underground1_sel' id='underground1_sel' onChange=underground_change2()>\";
				for ( i=0 ; i<under1_maxlen ; i++ )
				{
					selected	= nowNum == under1_numbe[i] ?'selected':'';
					sel	+= \"<option value='\"+ under1_numbe[i] +\"' \"+selected+\">\"+ under1_title[i] +\"</option>\";
				}
				sel	+= '</select>';

				document.getElementById('underground_list_selectbox').innerHTML	= sel;
				underground_change2();
			}


			//역세권 선택시 지하철 역 출력함수2
			function underground_change2()
			{
				var obj_under1	= document.getElementById('underground1_sel');
				var nowSelect	= obj_under1.selectedIndex;
				var nowNumber	= obj_under1.options[nowSelect].value;
				var nowText		= obj_under1.options[nowSelect].text;
				var width_len	= $under_print_width;

				if ( nowSelect >= 0 )
				{
					var maxLen	= under2_numbe[nowNumber].length;
					var output	= \"<table width='100%' cellspacing='0' cellpadding='0'>\"
					var tdwidth	= parseInt(100 / width_len);

					for ( i=0,j=1 ; i<maxLen ; i++,j++ )
					{
						tit		= under2_title[nowNumber][i];
						val		= under2_numbe[nowNumber][i];
						output	+= \"<td width='\"+ tdwidth +\"%'>∴<a href='#1' onClick=underlink('\"+ nowText +\"','\"+ tit +\"')>\"+ tit +\"</td>\";
						if ( j % width_len == 0 ) {
							output	+= \"</tr><tr>\";
						}
					}

					if ( j % width_len != 0 )
					{
						for ( i = j%width_len ; i<width_len ; i++ )
						{
							output	+= \"<td width='\"+ tdwidth +\"'>&nbsp;</td>\";
						}
					}
					output		+= \"</tr></table><br>\";
					//output_img	= \"<img id='underground_\"+nowNumber+\"' src='./img/under_\"+nowNumber+\".jpg' alt='\"+nowText+\" 지하철 노선 이미지'>\";

					xmlFileName2	= \"xml_under_\"+ nowText +\".xml\";

					nowText		= encodeURI(nowText);
					nowText		= nowText.replace(/\%/g, 'HH');
					xmlFileName	= \"xml_under_\"+ nowText +\".xml\";

					xmlFile		= \"flash_swf/subway.swf?fileName=xml_under/\"+xmlFileName +\"&nowstation=\"+ encodeURI(nowStation);
					wid			= xmlFileWidth[xmlFileName2];
					hei			= xmlFileHeight[xmlFileName2];


					output_img =\"<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='\"+ wid +\"' height='\"+ hei +\"'>\";
					output_img += \"<param name='movie' value='\"+ xmlFile +\"'>\";
					output_img += \"<param name='quality' value='high'>\";
					output_img += \"<param name='menu' value='false'>\";
					output_img += \"<param name='wmode' value='transparent'>\";
					output_img += \"<embed src='\"+ xmlFile +\"' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='\"+ wid +\"' height='\"+ hei +\"'></embed>\";
					output_img += \"</object>\";

					//document.getElementById('underground_list').innerHTML	= output+'<center>'+output_img+'</center>';
					document.getElementById('underground_list').innerHTML	= '<center>'+output_img+'</center>';
				}
			}


			//검색 링크 함수
			function underlink( station1 , station2 )
			{
				//alert( station1 +' '+ station2);

				under1_out_val	= ( under1_getTitle[station1] != undefined )?under1_getTitle[station1]:'';
				under2_out_val	= ( under2_getTitle[station1][station2] != undefined )?under2_getTitle[station1][station2]:'';

				document.getElementById('underground1').value	= under1_out_val;
				document.getElementById('underground2').value	= under2_out_val;

				document.a_f_guin.submit();
			}

		";

		$fp	= fopen("../js/underground.js","w");
		fwrite($fp,$groundList);

		#echo nl2br(str_replace("<","&lt;",$groundList));exit;

		########################################################################## js파일저장완료

		gomsg("변경된 사항이 저장완료되었습니다.","?number=$number");

	}
	else if ( $mode == 'db_reset' )
	{
		$fp	= file("./under.sql","r");

		foreach ( $fp AS $line ) {
			query($line);
		}
		go("?mode=reg");
	}
	else if ( $mode == 'db_clear' )
	{
		query("DROP TABLE IF EXISTS job_underground");
		query("create table job_underground ( number int not null auto_increment primary key, title varchar(50) not null default '', sort int not null default '0', depth int not null default '1', underground1 int not null default '0', key(title), key(depth), key(sort), key(underground1) )");
		gomsg("지하철 DataBase의 내용을 모두 지웠습니다.","?number=$number");
	}




####################################################################################################################################

	function ground_admin( $depth, $number )
	{
		global $job_underground_tb, $maxDepth, $nowCate;


		$downDepth	= $depth-1;
		$upDepth	= $depth+1;

		$WHERE		= ( $depth < $maxDepth )?" depth='1' ":" depth='$depth' AND underground$downDepth = '$number' ";
		$text		= ( $depth < $maxDepth )?"역세권":"지하철";
		$changeDB	= ( $depth < $maxDepth )?"no":"kin";
		$selectMsg	= ( $depth < $maxDepth )?"선택된 ${text} 하부관리":" 역세권 관리화면 이동 ";
		$onChange	= ( $depth < $maxDepth )?"1":"2";
		$display	= ( $depth < $maxDepth )?"":" style='display:none' ";

		$Sql	= "SELECT * FROM $job_underground_tb WHERE $WHERE ORDER BY sort ASC, title ASC";
		$Record	= query($Sql);

		$groundList	= "<select name='underground_list' id='underground_list' size='15' style='width:100%; margin-bottom:15px; height:255px' onChange=\"ground_change('$onChange')\" >";
		$Count		= 0;
		$groundNext	= array();
		$groundNum	= array();
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$groundList	.= "<option value='$Data[number]___$Data[title]'>$Data[title]</option>";

			if ( $depth < $maxDepth )
			{
				$Sql	= "SELECT title FROM $job_underground_tb WHERE depth = '$upDepth' AND underground$depth = '$Data[number]' ORDER BY sort ASC, title ASC";
				$Rec	= query($Sql);
				$groundNext[$Count]	= "";
				$groundNum[$Count]	= $Data[number];
				while ( $Tmp = happy_mysql_fetch_array($Rec) )
				{
					$groundNext[$Count]	.= "$Tmp[title]___";
				}
			}
			$Count++;
		}
		$groundList	.= "</select>";

		if ( $depth < $maxDepth )
		{
			$addValues	= "var preview = new Array();\n";
			for ( $i=0, $max=sizeof($groundNext) ; $i<$max ; $i++ )
			{
				$addValues	.= str_replace("___';","';","preview[$groundNum[$i]] = '$groundNext[$i]';\n");
			}
		}

		echo <<<END

			<script>
				$addValues

				var changeDB	= '$changeDB';

				//위아래로 움직여버리자
				function selectMove( no )
				{
					sel				= document.getElementById('underground_list');
					nowSelect		= sel.selectedIndex;
					maxSelect		= sel.length - 1;
					reCallFunc		= false;

					if ( nowSelect == -1 )
					{
						alert('움직일 ${text}를 선택하신후 이동시켜주세요.');
						return;
					}
					else if ( no > 0 )
					{
						if ( nowSelect >= maxSelect )
							return;
						else
						{
							changeSelect	= no - 1;
							moveSelect		= nowSelect + 1;
							reCallFunc		= ( changeSelect > 0 )?true:false;
						}
					}
					else if ( no < 0 )
					{
						if ( nowSelect <= 0 )
							return;
						else
						{
							changeSelect	= no + 1;
							moveSelect		= nowSelect - 1;
							reCallFunc		= ( changeSelect < 0 )?true:false;
						}
					}
					else
						return;

					sel1		= document.getElementById('underground_list')[nowSelect];
					sel2		= document.getElementById('underground_list')[moveSelect];

					text1		= sel1.text;
					value1		= sel1.value;
					text2		= sel2.text;
					value2		= sel2.value;

					sel1.text	= text2;
					sel1.value	= value2;
					sel2.text	= text1;
					sel2.value	= value1;

					sel.selectedIndex	= moveSelect;
					changeDB	= 'yes';

					if ( reCallFunc == true )
						selectMove(changeSelect);
				}


				//셀렉트 체인지 이벤트
				function ground_change( no )
				{
					sel			= document.getElementById('underground_list');
					nowSelect	= sel.selectedIndex;

					if ( nowSelect == -1 )
					{
						document.getElementById('titleEdit').value	= '';
						document.getElementById('titleEdit').readOnly	= true;
						document.getElementById('ground_msg2').innerHTML	= "수정하실 ${text}을 선택하세요.";
						document.getElementById('editbutton').style.display = 'none';
						document.getElementById('deletebutton').style.display = 'none';

						document.getElementById('nextView').value			= '';
						return;
					}
					else
					{
						text	= sel.options[nowSelect].text;
						document.getElementById('titleEdit').value	= text;
						document.getElementById('titleEdit').readOnly	= false;
						document.getElementById('ground_msg2').innerHTML	= "<font color='red'>"+ text +"</font> ${text} 수정";
						document.getElementById('editbutton').style.display = '';
						document.getElementById('deletebutton').style.display = '';

						tmpValue	= sel.options[nowSelect].value;
						tmpValues	= tmpValue.split('___');

						nowNumber	= tmpValues[0];

						if ( no == '1' )
						{
							str			= preview[nowNumber];
							previews	= str.replace(/\\___/g,'\\n');

							document.getElementById('nextView').value	= previews;
						}
					}
				}


				//셀렉트 해제
				function ground_unSelect()
				{
					sel			= document.getElementById('underground_list');
					sel.selectedIndex	= -1;
					ground_change();
				}


				//신규 등록
				function addNewTitle()
				{
					var texst = document.getElementById('title').value;
					if ( texst == '' )
					{
						alert('제목을 입력후 이용해주세요.');
						document.getElementById('title').focus();
						return;
					}
					else
					{
						var values		= "0___" + texst;
						var sel			= document.getElementById('underground_list');
						var maxlength	= sel.length ;

						sel.options[maxlength]	= new Option(texst,values,true);

						document.getElementById('title').value	= '';

						sel.selectedIndex	= maxlength;
						changeDB	= 'yes';
					}
				}


				//정보수정
				function editTitle()
				{
					sel			= document.getElementById('underground_list');
					nowSelect	= sel.selectedIndex;

					var text = document.getElementById('titleEdit').value;
					if ( text == '' )
					{
						alert('제목을 입력후 이용해주세요.');
						document.getElementById('titleEdit').focus();
						return;
					}
					else
					{
						original_text	= sel.options[nowSelect].text;
						original_value	= sel.options[nowSelect].value;

						value_array		= original_value.split('___');

						sel.options[nowSelect].text		= text;
						sel.options[nowSelect].value	= value_array[0] +'___'+ text;

						ground_unSelect();
						changeDB	= 'yes';
					}
				}


				//정보삭제
				function deleteTitle()
				{
					sel			= document.getElementById('underground_list');
					nowSelect	= sel.selectedIndex;

					if ( nowSelect != -1 )
					{
						selText		= sel.options[nowSelect].text;
						if ( confirm("'"+ selText +"'를 삭제하시겠습니까?") )
						{
							tmpValue	= sel.options[nowSelect].value;
							tmpValues	= tmpValue.split('___');
							nowNumber	= tmpValues[0];

							var obj		= document.getElementById('groundDeleteList');

							delList		= obj.value;
							obj.value	= ( obj.value == '' )?nowNumber:delList +","+ nowNumber;

							sel.options[nowSelect]	= null;
							changeDB	= 'yes';
							ground_unSelect();
						}
					}
					else
					{
						alert('삭제하실 역세권을 선택해주세요');
						return;
					}
				}


				//선택된 역세권 하부관리 // 상위카테고리관리
				function selectNext()
				{
					if ( changeDB == 'no' )
					{
						sel			= document.getElementById('underground_list');
						nowSelect	= sel.selectedIndex;

						if ( nowSelect != -1 )
						{
							selValue	= sel.options[nowSelect].value;
							tmpValues	= selValue.split('___');
							nowNumber	= tmpValues[0];

							window.location.href	= '?number='+ nowNumber;
						}
						else
							alert('하부관리 하실 역세권을 선택해주세요.');
					}
					else if ( changeDB == 'kin' )
					{
						window.location.href	= '?';
					}
					else
					{
						alert('수정된 사항들을 저장후 이용해주세요');
						return;
					}
				}


				//수정된 내용 DB에 저장하기
				function dbSubmit()
				{
					var sel		= document.getElementById('underground_list');
					var maxLen	= sel.length;
					var gList	= "";

					for ( i=0 ; i<maxLen ; i++ )
					{
						gList	+= ( i == 0 )?"":"||||";
						gList	+= sel.options[i].value;
					}

					document.getElementById('groundChangeList').value	= gList;

					document.ground_frm.submit();
				}
			</script>

			<form name='ground_frm' method='post' action='?mode=reg'>
			<input type='hidden' name='number' value='$_GET[number]'>
			<input type='hidden' name='ndepth' value='$depth'>

			$nowCate
			<div id='box_style'>
				<div class='box_1'></div>
				<div class='box_2'></div>
				<div class='box_3'></div>
				<div class='box_4'></div>

					<table cellspacing='1' cellpadding='0' border='0' class='bg_style'>
					<colgroup>
					<col style='width:38%'></col>
					<col style='width:24%'></col>
					<col style='width:38%'></col>
					</colgroup>
					<tr>
						<th>현재 등록된 역세권</th>
						<th>신규역세권 등록</th>
						<th ${display}>하부내용 미리보기</th>
					</tr>
					<tr>
						<td>
							<p style='margin-bottom:10px; text-align:center;'><a href='#1' onClick='selectMove(-9999)' class='btn_small_stand'>맨위로</a> <a href='#1' onClick='selectMove(-10)' class='btn_small_stand'>위로 10 칸</a> <a href='#1' onClick='selectMove(-5)' class='btn_small_stand'>위로 5 칸</a> <a href='#1' onClick='selectMove(-1)' class='btn_small_stand'>위로</a></p>

							$groundList
							<input type='hidden' name='groundChangeList' id='groundChangeList' value=''>
							<input type='hidden' name='groundDeleteList' id='groundDeleteList' value=''>

							<p style='text-align:center;'><a href='#1' onClick='selectMove(+1)' class='btn_small_stand'>아래로</a> <a href='#1' onClick='selectMove(+5)' class='btn_small_stand'>아래로 5 칸</a> <a href='#1' onClick='selectMove(+10)' class='btn_small_stand'>아래로 10 칸</a> <a href='#1' onClick='selectMove(+9999)' class='btn_small_stand'>맨아래로</a></p>
						</td>
						<td>
							<p style='padding-bottom:30px; margin-bottom:20px; border-bottom:1px solid #dbdbdb;'>제목 : <input type='text' name='title' id='title' value='' size='15' style='height:23px; line-height:26px; vertical-align:middle'> <input type='button' value='등록하기' onClick="addNewTitle()" class='btn_small_dark' style=''></p>

							<p id='ground_msg2'>수정하실 ${text}을 선택하세요.</p>

							<div><br>제목 : <input type='text' name='titleEdit' id='titleEdit' value='' size='13' readonly  style='height:23px; line-height:26px; vertical-align:middle'> <input type='button' value='수정' onClick="editTitle()" id='editbutton' class='btn_small_red'> <input type='button' value='삭제' onClick="deleteTitle()" id='deletebutton' class='btn_small_dark'></div>
						</td>
						<td ${display}><textarea name='nextView' id='nextView' style='width:100%; height:250px;' rows='14' readonly></textarea></td>
					</tr>
					<tr>
						<td colspan='3' style='text-align:center;'>
							<p class="short" style="text-align:left">
								여기서 수정/등록/삭제 하신내용은 <font color='blue'>DB에저장버튼</font>을 누르지 않으시면 적용이 되지 않습니다.<br>
								수정완료하신후 반드시 DB에저장버튼을 눌러서 저장을 하셔야 합니다.
							</p>
							<input type='button' value='선택${text} 해제' onClick="ground_unSelect()" class='btn_small'>
							<input type='button' value='$selectMsg' onClick='selectNext()' class='btn_small'>
							<input type='button' value='수정된 내용 DB에저장' onClick="dbSubmit()" class='btn_small_yellow'>
							<input type='button' value='DB 초기화' class='btn_small_dark' onClick="if ( confirm('지하철 DB를 초기상태로 복구 시키겠습니까?') ){ window.location.href='?mode=db_reset'; }">
							<input type='button' value='DB 비우기' class='btn_small_dark' onClick="if ( confirm('지하철 DB를 깨끗이 비우시겠습니까?') ){ window.location.href='?mode=db_clear'; }"><br><br>

						</td>
					</tr>
					</table>
			</div>
			</form>


END;
	}

include ("tpl_inc/bottom.php");
####################################################################################################################################
?>