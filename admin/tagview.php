<?
	include ("../inc/config.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/function.php");
	include ("../inc/lib.php");

	if ( !admin_secure("슈퍼관리자전용") ) {
			error("접속권한이 없습니다.");
			exit;
	}
	include ("tpl_inc/top_new.php");

	#무슨태그인지 이름 입력
	$masTitle	= Array("이력서추출","이력서리스트","구인추출","구인리스트","게시판리스트","실시간검색","서브카테고리출력","직종전체보기","검색결과","설문조사추출","3D클라우드태그추출","게시판제목추출","게시판링크추출");

	#실질적으로 호출되는 태그명 입력 {{태그명 옵션1,옵션2}}
	$masValue	= Array("이력서추출","이력서리스트","구인추출","구인리스트","게시판보기","실시간검색","서브카테고리출력","직종전체보기","검색결과","설문","구름태그3d","게시판제목","게시판링크");

	array_unshift($SI_ARRAY_NAME,"자동");
	array_unshift($TYPE_ARRAY_NAME,"자동");



	###################### 파트0 #####################

		#각 옵션별 이름 입력
		$tagName[0]		= Array(
							"가로출력개수",
							"세로출력개수",
							"지역선택옵션",
							"직종선택옵션",
							"유료옵션",
							"회원관련옵션",
							"정렬순서",
							"글자짜름",
							"누락개수",
							"상세템플릿",
							"페이징사용유무",
							"모바일스크롤",
							"인접순추출",
							"신입/경력"
						);

		#각 옵션별 속성 입력
		$tagValue[0][0]		= "1";
		$tagValue[0][1]		= "5";
		$tagValue[0][2]		= $SI_ARRAY_NAME;
		$tagValue[0][3]		= $TYPE_ARRAY_NAME;
		$tagValue[0][4]		= Array(
								"특별",
								"포커스",
								"파워링크",
								"이력서스킨",
								"아이콘",
								"볼드",
								"컬러",
								"자유아이콘",
								"총지원자",
								"미열람",
								"예비합격자",
								"인재스크랩"
							);
		$tagValue[0][5]		= Array(
								"내가등록한이력서",
								"(아이디)test"
							);
		$tagValue[0][6]		= Array(
								"최근등록일순",
								"등록일순",
								"오래된순",
								"랜덤추출",
								"최근수정순",
								"수정순",
								"최근등록순",
								"등록순",
								"아이디순",
								"아이디역순",
								"경력많은순",
								"경력작은순"
							);
		$tagValue[0][7]		= "30";
		$tagValue[0][8]		= "0";
		$tagValue[0][9]		= filelist("../temp","doc_rows,member_guin_");
		$tagValue[0][10]	= Array("페이징사용","페이징사용안함");
		$tagValue[0][11]	= Array("","모바일스크롤");
		$tagValue[0][12]	= Array("","인접순추출","회원인접업체");
		$tagValue[0][13]	= Array("","신입","경력");


		#각 옵션별 값(2차 배열로 입력 또는 text,none,int,select)
		#select 시 전체옵션이나 없음 등등이 들어갈땐 "/"(슬러시)로 구분하여 입력한다.. ex1) select/전체 ex2) select/없음
		$tagType[0]		= Array("int","int","select/전체","select/전체","select/전체","select/전체","select","int","int","select","select","select","select","select");



	###################### 파트1 #####################

		#각 옵션별 이름 입력
		$tagName[1]		= Array(
							"가로출력개수",
							"세로출력개수",
							"지역선택옵션",
							"직종선택옵션",
							"유료옵션",
							"회원관련옵션",
							"정렬순서",
							"글자짜름",
							"누락개수",
							"상세템플릿",
							"페이징사용",
							"모바일스크롤",
							"인접순추출",
							"신입/경력"
						);

		#각 옵션별 속성 입력
		$tagValue[1][0]		= "1";
		$tagValue[1][1]		= "5";
		$tagValue[1][2]		= $SI_ARRAY_NAME;
		$tagValue[1][3]		= $TYPE_ARRAY_NAME;
		$tagValue[1][4]		= Array(
								"특별",
								"포커스",
								"파워링크",
								"이력서스킨",
								"아이콘",
								"볼드",
								"컬러",
								"자유아이콘",
								"총지원자",
								"미열람",
								"예비합격자",
								"인재스크랩"
							);

		//헤드헌팅
		if ( $hunting_use == true )
		{
			array_push($tagValue[1][4], "헤드헌팅");
		}

		$tagValue[1][5]		= Array(
								"내가등록한이력서",
								"(아이디)test"
							);
		$tagValue[1][6]		= Array(
								"최근등록일순",
								"등록일순",
								"오래된순",
								"랜덤추출",
								"최근수정순",
								"수정순",
								"최근등록순",
								"등록순",
								"아이디순",
								"아이디역순",
								"경력많은순",
								"경력작은순"
							);
		$tagValue[1][7]		= "30";
		$tagValue[1][8]		= "0";
		$tagValue[1][9]		= filelist("../temp","doc_rows,member_guin_");
		$tagValue[1][10]	= Array("페이징사용","사용안함");
		$tagValue[1][11]	= Array("","모바일스크롤");
		$tagValue[1][12]	= Array("","인접순추출","회원인접업체");
		$tagValue[1][13]	= Array("","신입","경력");


		#각 옵션별 값(2차 배열로 입력 또는 text,none,int,select)
		#select 시 전체옵션이나 없음 등등이 들어갈땐 "/"(슬러시)로 구분하여 입력한다.. ex1) select/전체 ex2) select/없음
		$tagType[1]		= Array("int","int","select/전체","select/전체","select/전체","select/전체","select","int","int","select","select","select","select","select");



	###################### 파트2 #####################

		#각 옵션별 이름 입력
		$tagName[2]		= Array(
							"총출력개수",
							"가로출력개수",
							"제목길이",
							"직종선택",
							"서브직종",
							"시/도/군",
							"동선택",
							"유료옵션",
							"직업종류",
							"상세템플릿",
							"정렬순서",
							"누락",
							"모바일스크롤",
							"신입/경력"
						);

		#각 옵션별 속성 입력
		$tagValue[2][0]		= "10";
		$tagValue[2][1]		= "1";
		$tagValue[2][2]		= "20";
		$tagValue[2][3]		= $TYPE_ARRAY_NAME;
		$tagValue[2][4]		= $TYPE_SUB_NAME;
		$tagValue[2][5]		= $SI_ARRAY_NAME;
		$tagValue[2][6]		= $GU_ARRAY_NAME;
		$tagValue[2][7]		= $ARRAY_NAME;
		$tagValue[2][8]		= Array(
							"자동"
							);
		$tagValue[2][9]		= filelist("../temp","output_");
		$tagValue[2][10]	= Array("랜덤추출","최근등록순");
		$tagValue[2][11]	="0";
		$tagValue[2][12]	= Array("","모바일스크롤");
		$tagValue[2][13]	= Array("","신입","경력");

		#각 옵션별 값(2차 배열로 입력 또는 text,none,int,select)
		$tagType[2]		= Array("int","int","int","select/전체","select/전체","select/전체","select/전체","select/전체","select/전체","select","select","int","select","select");

		//헤드헌팅
		if ( $hunting_use == true )
		{
			array_push($tagName[2], "헤드헌팅");
			array_push($tagValue[2], Array("","헤드헌팅"));
			array_push($tagType[2], "select");
		}

	###################### 파트3 #####################

		#$tagName[2]		= $tagName[1];
		$tagName[3]		= Array(
							"총출력개수",
							"가로출력개수",
							"제목길이",
							"직종선택",
							"서브직종",
							"시/도/군",
							"동선택",
							"유료옵션",
							"직업종류",
							"상세템플릿",
							"누락",
							"페이징사용",
							"맞춤구인정보",
							"정렬순서",
							"인접순추출",
							"신입/경력"
						);

		$tagValue[3][0]	= "10";
		$tagValue[3][1]	= "1";
		$tagValue[3][2]	= "20";
		$tagValue[3][3]	= $TYPE_ARRAY_NAME;
		$tagValue[3][4]	= $TYPE_SUB_NAME;
		$tagValue[3][5]	= $SI_ARRAY_NAME;
		$tagValue[3][6]	= $GU_ARRAY_NAME;
		$tagValue[3][7]	= $ARRAY_NAME;
		$tagValue[3][8]	= Array(
						"자동",
						"회사관련구인",
						"스크랩"
						);
		$tagValue[3][9]	= filelist("../temp","output_");

		//2011-11-22 추가된
		$tagValue[3][10] = "0";
		$tagValue[3][11] = array("사용안함","사용함");
		$tagValue[3][12] = array("맞춤구인정보");
		$tagValue[3][13] = array("최근등록일순","등록일순","오래된순","랜덤추출","최근수정순","수정순","등록순","아이디순","아이디역순");
		$tagValue[3][14]	= Array("","인접순추출","회원인접업체");
		$tagValue[3][15]	= Array("","신입","경력");

		#$tagType[2]		= $tagType[1];
		$tagType[3]		= Array("int","int","int","select/전체","select/전체","select/전체","select/전체","select/전체","select/전체","select","int","select/전체","select/전체","select","select","select");


		//헤드헌팅
		if ( $hunting_use == true )
		{
			array_push($tagName[3], "헤드헌팅");
			array_push($tagValue[3], Array("","헤드헌팅"));
			array_push($tagType[3], "select");
		}

	###################### 파트4 #####################

		$Sql	= "SELECT board_name, board_keyword FROM $board_list ";
		$Result	= query($Sql);
		$i		= 0;
		$board_keyword_list = array();
		while ( $Data = happy_mysql_fetch_array($Result) ) {
			$board_name_list[$i++]	= $Data[0];

			if ( $Data[1] != '' ){//게시판 추출명칭
				array_push($board_keyword_list, $Data[1]);
				$board_name_list[$i++]	= '┖'.$Data[1];
			}
		}

		#각 옵션별 이름 입력
		$tagName[4]		= Array(
							"총출력개수",
							"가로출력개수",
							"제목길이",
							"본문길이",
							"게시판제목",
							"사용템플릿"
						);

		#각 옵션별 속성 입력
		$tagValue[4][0]		= "10";
		$tagValue[4][1]		= "1";
		$tagValue[4][2]		= "40";
		$tagValue[4][3]		= "360";
		$tagValue[4][4]		= $board_name_list;
		$tagValue[4][5]		= filelist("../html_bbs","bbs_rows");


		#각 옵션별 값(2차 배열로 입력 또는 text,none,int,select)
		$tagType[4]		= Array("int","int","int","int","select","select");


	###################### 파트5 #####################

		$tagName[5]		= Array(
							"총출력개수",
							"껍데기HTML",
							"알맹이HTML",
							"구분문자"
						);

		$tagValue[5][0]	= "10";
		$tagValue[5][1]	= filelist("../temp","keyword");
		$tagValue[5][2]	= filelist("../temp","keyword");
		$tagValue[5][3]	= "--";

		$tagType[5]		= Array("int","select","select","text");



	###################### 파트6 #####################

		$tagName[6]		= Array(
							"가로출력개수",
							"제목길이",
							"구인/구직",
							"알맹이HTML",
							"경력"
						);

		$tagValue[6][0]	= "4";
		$tagValue[6][1]	= "30";
		$tagValue[6][2]	= Array("구인","구직");
		$tagValue[6][3]	= filelist("../temp","sub_");
		$tagValue[6][4]	= Array("","경력");

		$tagType[6]		= Array("int","int","select","select","select");

		//헤드헌팅
		if ( $hunting_use == true )
		{
			array_push($tagValue[6][4], "헤드헌팅");
		}


	###################### 파트7 #####################

		$tagName[7]		= Array(
							"가로출력개수",
							"제목길이",
							"구인/구직",
							"알맹이HTML",
							"껍데기HTML"
						);

		$tagValue[7][0]	= "4";
		$tagValue[7][1]	= "30";
		$tagValue[7][2]	= Array("구인","구직");
		$tagValue[7][3]	= filelist("../temp","guin_task");
		$tagValue[7][4]	= filelist("../temp","guin_task");

		$tagType[7]		= Array("int","int","select","select","select");




	###################### 파트8 #####################

		$i = 0;
		foreach ( $check_part AS $key )
		{
			$check_part_name[$i++]	= key($check_part);
			next($check_part);
		}

		$tagName[8]		= Array(
							"제목길이",
							"가로출력개수",
							"세로출력개수",
							"껍데기HTML",
							"알맹이HTML",
							"검색대상"
						);

		$tagValue[8][0]	= "60";
		$tagValue[8][1]	= "1";
		$tagValue[8][2]	= "15";
		$tagValue[8][3]	= filelist("../temp","all_search","all_search.html");
		$tagValue[8][4]	= filelist("../temp","all_search_");
		$tagValue[8][5]	= $check_part_name;

		$tagType[8]		= Array("int","int","int","select","select","select");




	###################### 파트9 #####################

		$tagName[9]		= Array(
							"세로출력개수",
							"가로출력개수",
							"키워드",
							"진행여부",
							"제목템플릿 HTML",
							"응답템플릿 HTML",
							"정렬순서"
						);

		$tagValue[9][0]	= "1";
		$tagValue[9][1]	= "1";
		$tagValue[9][2]	= "자동";
		$tagValue[9][3]	= Array(
							"진행",
							"마감"
						);
		$tagValue[9][4]	= filelist("../$skin_folder","poll_main");
		$tagValue[9][5]	= filelist("../$skin_folder","poll_rows_list");
		$tagValue[9][6]	= Array(
							"랜덤",
							"등록번호순",
							"최근등록순",
							"제목순",
							"제목역순"
						);

		$tagType[9]		= Array("int","int","text","select/전체","select","select","select");




	###################### 파트10 #####################
		$tagName[10]		= Array(
							"가로크기",
							"세로크기",
							"단어개수",
							"무빙스피드",
							"마우스오버시 컬러",
							"단어크기(pt)",
							"단어색깔(미지정시 랜덤)",
							"배경색깔(미지정시 투명)"
						);

		$tagValue[10][0]	= "300";
		$tagValue[10][1]	= "300";
		$tagValue[10][2]	= "15";
		$tagValue[10][3]	= "100";
		$tagValue[10][4]	= "ff0000";
		$tagValue[10][5]	= "15";
		$tagValue[10][6]	= "0000ff";
		$tagValue[10][7]	= "ccffff";

		$tagType[10]		= Array("text","text","text","text","text","text", "text","text");


	###################### 파트8 #####################
	//게시판 추출명칭
		$tagName[11]		= Array(
							"게시판 추출명칭",
							"노출방식"
						);

		$tagValue[11][0]	= $board_keyword_list;
		$tagValue[11][1]	= Array(
								'텍스트',
								'이미지(Size=20/OutFont=NanumPen/Format=PNG/Bgcolor=255.255.255/fcolor=63.63.63)'
		);

		$tagType[11]		= Array("select","select");

	###################### 파트9 #####################
	//게시판 추출명칭
		$tagName[12]		= Array(
							"게시판명칭"
						);

		$tagValue[12][0]	= $board_keyword_list;

		$tagType[12]		= Array("select");
	###################################### 공통사용변수 ######################################

		#공통변수 이름 입력
		$gongTitle	= Array(
						"메인회원로그인",
						"회원로그인",
						"투표",
						"추천키워드",
						"지역검색",
						"확장지역검색",
						"업종검색",
						"현재위치",
						"검색부분",
						"확장검색부분",
						"심플검색부분",
						"상세검색부분",
						"숨은검색부분",
						"페이징"
					);





####################################################################################################################################
################################################            출력 고고고고           ################################################
####################################################################################################################################

	##### 태그보기 버튼을 위한 스크립트 생성 ( IE에서만 작동할듯 )
	$tagViewFunction	= "
		<script>
			function {{functionName}}(no)
			{

				var tags	= new Array();
				{{tagAction}}

				var max		= tags.length;
				var vals	= '';

				for ( i=0 ; i<max ; i++ )
				{
					vals	+= ( vals != '' )?',':'';
					vals	+= tags[i];
				}

				var preview	= '{{{{masTitle}} '+ vals +'}}';

				document.all.subPreview_{{i}}.innerHTML = ''+ preview;
				if ( no == 'ok' )
				{
					if ( document.mainView_frm.mainViewTag.value == '' )
						document.mainView_frm.mainViewTag.value	= document.mainView_frm.mainViewTag.value +''+ preview;
					else
						document.mainView_frm.mainViewTag.value	= document.mainView_frm.mainViewTag.value +'\\n'+ preview;
				}
			}
		</script>
	";

	#태그만 추가하는 스크립트 출력
	echo "
		<script>
			function addTagOnly( tag )
			{
				if ( document.mainView_frm.mainViewTag.value == '' )
					document.mainView_frm.mainViewTag.value	= document.mainView_frm.mainViewTag.value +''+ tag;
				else
					document.mainView_frm.mainViewTag.value	= document.mainView_frm.mainViewTag.value +'\\n'+ tag;


			}
		</script>
	";

	##### 미리보기를 위한 폼과 스크립트 생성 ( -ㅁ- )
	$lastFormAction		= "
		<div id='menu_fixed' style='text-align:center; left:207px; width:1044px; background:#4b4b4b;'>
				<form name='mainView_frm' method='post' action='../tagview.php' target='_blank'>
				<table width=100%  border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td style='height:25px; color:#bcbcbc; padding-left:10px; font:12px 굴림;' valign='bottom' align='left'>
						생성된 코드를 복사하여 HTML소스상으로 붙여넣으시면 해당 기능이 출력됩니다.
						</td>
						<td style='width:110px; padding-top:10px;'>
							<input type='button' value='초기화' style='width:98px;height:26' class=btn1 onClick='document.mainView_frm.reset()'>
						</td>
					</tr>
					<tr>
						<td align=left style='padding:10px;'>
							<textarea  rows='5' style='width:100%; border:1px solid #363636; background:#e8e8e8;' name='mainViewTag' onChange='memoLengthCheck(this.form,300)' onKeyUp='memoLengthCheck(this.form,300)'>$tag</textarea>
						</td>
						<td style='width:110px;'><input type=image src='img/btn_tag_view.gif' value='미리보기' ></td>
					</tr>
				</table>
			</form>
		</div>

		</center>
	";

	echo "

		<a name='top'></a>
		<script type='text/javascript'>
		if(typeof document.compatMode!='undefined'&&document.compatMode!='BackCompat'){
			cot_t1_DOCtp='_top:expression(document.documentElement.scrollTop+document.documentElement.clientHeight-this.clientHeight);_left:expression(document.documentElement.scrollLeft + document.documentElement.clientWidth - offsetWidth);}';
		}
		else{
			cot_t1_DOCtp='_top:expression(document.body.scrollTop+document.body.clientHeight-this.clientHeight);_left:expression(document.body.scrollLeft + document.body.clientWidth - offsetWidth);}';
		}
		var menu_bodyCSS='* html {background:#fff1b8;}';
		var menu_fixedCSS='#menu_fixed{position:fixed;';
		var menu_fixedCSS=menu_fixedCSS+'_position:absolute;';
		var menu_fixedCSS=menu_fixedCSS+'z-index:999;';
		var menu_fixedCSS=menu_fixedCSS+'width:100%;';
		var menu_fixedCSS=menu_fixedCSS+'bottom:0px;';
		var menu_fixedCSS=menu_fixedCSS+'right:0px;';
		var menu_fixedCSS=menu_fixedCSS+'clip:rect(0 100% 100% 0);';
		var menu_fixedCSS=menu_fixedCSS+cot_t1_DOCtp;
		document.write('<style type=text/css>'+menu_bodyCSS+menu_fixedCSS+'</style>');
		</script>

		<div class='main_title'>$now_location_subtitle<span class='small_btn'><a href=\"http://cgimall.co.kr/xml_manual/manual_main.php?db_name=manual_adultjob&number=5\" target='_blank' class='btn_small_yellow'>도움말</a></span></div>

		<div class='help_style'>
			<div class='box_1'></div>
			<div class='box_2'></div>
			<div class='box_3'></div>
			<div class='box_4'></div>
			<span class='help'>도움말</span>
			<p>
				<B>템플릿 태그생성기</B>는 해당 정보를 불러내는 태그명령어를 템플릿(HTML) 파일에 직접 입력하는 번거로움을 덜기 위해서 만들어진 기능입니다. 각 항목의 해당사항에 맞는 항목을 선택하신 후 <B>[태그보기]</B> 버튼을 클릭하시면 <B>미리보기</B> 항목에 사용할 수 있는 태그명령어가 생성이 됩니다. 이 생성된 태그명령어를 복사하여 템플릿파일 해당 위치에 붙여넣기
				하여 사용하시면 되겠습니다.
			</p>
		</div>




	<table cellspacing='0' cellpadding='0' border='0' width='100%'>
			";

	##### 루프돌면서 생성해볼까요~
	for ( $i=0,$max=sizeof($masTitle),$startScript="",$startScript2="",$mainStartFunc="" ; $i<$max ; $i++ )
	{
		if ($i%1 == 0) echo "<tr>";
		echo "<td valign='top' align='center'>";

		if ( $max != sizeof($masValue) || $max != sizeof($tagValue) || $max != sizeof($tagType) )
		{
			echo "<font color='red'>배열의 수가 일정치 않습니다. 확인바랍니다.</font>";
			exit;
		}

		if ( sizeof($tagName[$i]) != sizeof($tagValue[$i]) || sizeof($tagName[$i]) != sizeof($tagType[$i]) )
		{
			echo "<font color='red'>". $masTitle[$i] ." 아래의 배열의 수가 일정치 않습니다. 확인바랍니다.</font>";
			exit;
		}


		$funcName		= "viewTag_${i}";
		$startScript	= $funcName ."('ok');";
		$startScript2	= $funcName ."('no');";
		$mainStartFunc	.= $startScript2;
		$colspan		= 2;
		#$colspan		= sizeof($tagName[$i]) + 2;
		#echo "<br>";
		echo"<div id='box_style'>
				<div class='box_1'></div>
				<div class='box_2'></div>
				<div class='box_3'></div>
				<div class='box_4'></div>
				";
		echo "<table border='0' cellpadding='0' cellspacing='1' class='bg_style' style='width:100%'>";
		echo "
					<tr>
						<th height='35' colspan='$colspan' ><b>". $masTitle[$i] ." 태그</b></th>
					</tr>
		";


		for ( $j=0,$maxj=sizeof($tagName[$i]),$tagAction="" ; $j<$maxj ; $j++ )
		{
			$inputTag		= "";
			$inputName		= "tagMaker_${i}_${j}";

			$tagType[$i][$j]= explode("/",$tagType[$i][$j]);

			if ( $tagType[$i][$j][0] == "int" )
			{
				if ( is_array($tagValue[$i][$j]) )
				{
					echo "<font color='red'>Type이 INT형인곳에서는 배열을 사용하실수 없습니다. select로 변경해주세요.</font>";
					exit;
				}
				else
				{
					$inputTag	= "<input type='text' name='$inputName' size='4'  onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;' style='width:150px; padding:0 5px; text-align:right' value='". $tagValue[$i][$j] ."' onKeyUp=\"$startScript2\">";
					$tagAction	.= "	tags[$j]	= document.all.${inputName}.value; \n";
				}
			}
			else if ( $tagType[$i][$j][0] == "text" )
			{
				if ( is_array($tagValue[$i][$j]) )
				{
					echo "<font color='red'>Type이 TEXT형인곳에서는 배열을 사용하실수 없습니다. select로 변경해주세요.</font>";
					exit;
				}
				else
				{
					$inputTag	= "<input type='text' name='$inputName' size='10' style='width:150px; padding:0 5px' value='". $tagValue[$i][$j] ."'  onKeyUp=\"$startScript2\">";
					$tagAction	.= "	tags[$j]	= document.all.${inputName}.value; \n";
				}
			}
			else if ( $tagType[$i][$j][0] == "select" )
			{
				if ( !is_array($tagValue[$i][$j]) )
				{
					echo "<font color='red'>Type이 TEXT형인곳에서는 배열만 사용하실수 있습니다.</font>";
					exit;
				}
				else
				{
					$inputTag	= "<select name='$inputName' onChange=\"$startScript2\" style='width:150;'>";
					$inputTag	.= ( $tagType[$i][$j][1] != "" )?"	<option value='전체'>전체</option>":"";
					for ( $z=0, $maxz=sizeof($tagValue[$i][$j]) ; $z<$maxz ; $z++ )
					{
						$nowValue	= $tagValue[$i][$j][$z];
						$selected	= ( $_GET[$inputName] == $nowValue )?" selected ":"";

						$nowValue_val = str_replace("┖","", $nowValue); //게시판 추출명칭

						$inputTag	.= "<option value='$nowValue_val' $selected >$nowValue</option>";
					}
					$inputTag	.= "</select>";
					$tagAction	.= "	tags[$j]	= document.all.${inputName}.options[document.all.${inputName}.selectedIndex].value; \n";
				}
			}
			else if ( $tagType[$i][$j][0] == "none" )
			{
				$inputTag	= "없음";
			}

			echo "
					<tr>
						<th width='150' >". $tagName[$i][$j] ."</th>
						<td class='input_style_adm'>$inputTag</td>
					</tr>
			";
		}


		$tagViewFunc	= $tagViewFunction;
		$tagViewFunc	= str_replace("{{functionName}}", $funcName, $tagViewFunc);
		$tagViewFunc	= str_replace("{{i}}", $i, $tagViewFunc);
		$tagViewFunc	= str_replace("{{masTitle}}", $masValue[$i], $tagViewFunc);
		$tagViewFunc	= str_replace("{{tagAction}}", $tagAction, $tagViewFunc);




		echo "
		</table>
		</div>
		<div style='margin-bottom:50px'>
			<input type='button' value='태그미리보기' style='width:310px;  cursor:pointer;' onClick=\"$startScript;\" class='btn_big_round'><a href='#preview_tag'></a><div id='subPreview_${i}' style='display:none;'></div>
		</div>
			<!--
			<table cellspacing='0' cellpadding='0' border='0'>
			<tr>
				<td height='30' colspan='$colspan'>
					<table cellspacing='0' cellpadding='0' border='0' width='100%'>
						<tr>
							<td class='smfont' bgcolor='#f9f9f9' width='150' align='center' height='30'><b>생성된 태그</td>
							<td class='smfont' style='padding-left:5px;'><div id='subPreview_${i}'></div></td></td>
							<td class='smfont' style='padding-left:5px;' align='right'><input type='button' value='태그미리보기' class=btn1 onClick=\"$startScript\"></td>
						</tr>
						<tr>
							<td bgcolor='#dfdfdf' colspan='3' height='1'></td>
						</tr>
					</table>
				</td>
			</tr>
			</table>
			-->
		";

		echo $tagViewFunc;
		echo "</td>";

	}

	echo "</table>";

	# 공통변수출력 #########
	echo"<div id='box_style'>
				<div class='box_1'></div>
				<div class='box_2'></div>
				<div class='box_3'></div>
				<div class='box_4'></div>
				";
	echo "<table border='0' cellpadding='0' cellspacing='1' class='bg_style'>";
	echo "<tr><th  height='35' align='center'><b> 공통사용태그들</b></th></tr><tr><td bgcolor=#F8F8F8 height='35' class=smfont align=center style='color:#333'>";
	for ( $i=0 , $max=sizeof($gongTitle) ; $i<$max ; $i++ )
	{
		echo "<a href='#1' onClick=\"addTagOnly('{{".$gongTitle[$i]."}}')\" style='color:#333'>{{".$gongTitle[$i]."}}</a> ";
	}
	echo "</td></tr></table></div>";

	# 아래쪽 출력 ##########
	echo $lastFormAction;
	echo "<script> $mainStartFunc </script>";
####################################################################################################################################




?>

<?
include ("tpl_inc/bottom.php");
?>