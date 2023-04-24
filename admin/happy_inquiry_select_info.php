<?
	$t_start = array_sum(explode(' ', microtime()));

	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/lib.php");


	if ( !admin_secure("직종설정") ) {
			error("접속권한이 없습니다.");
			exit;
	}

	$inquiry_number		= ( $_GET['number'] != "" ) ? $_GET['number'] : $_POST['number'];

	if ( $inquiry_number == "" )
	{
		msgclose("문의 고유번호가 없습니다.");
		exit;
	}

	$search_field_title	= Array("회사명","담담자이름","등록인아이디");
	$search_field_value	= Array("com_name","guin_name","guin_id");

	$검색필드선택		= make_selectbox2($search_field_title,$search_field_value,"",'search_type',$_GET['search_type'],'150');

	$WHERE				= "";

	if ( $_GET['search_type'] != "" && $_GET['search_keyword'] != "" )
	{
		$WHERE				.= " AND $_GET[search_type] like '%$_GET[search_keyword]%' ";
	}

	####################### 페이징처리 ########################
	$start				= $_GET["start"];
	$scale				= ( $_GET["scale"] == "" )?10:$_GET["scale"]; //업체출력개수 수정 - 13.03.06 hong

	$Sql	= "select count(*) from $happy_inquiry_links WHERE 1=1 $WHERE ";
	$Temp	= happy_mysql_fetch_array(query($Sql));
	$Total	= $Count	= $Temp[0];

	if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
	$pageScale			= 6;

	$searchMethod		= "";
	$searchMethod		.= "&number=$_GET[number]";
	$searchMethod		.= "&search_type=$_GET[search_type]";
	$searchMethod		.= "&search_keyword=".urlencode($_GET[search_keyword]);

	$paging				= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
	$페이징출력			= $paging;
	###################### 페이징처리 끝 #######################

	$Sql				= "SELECT * FROM $happy_inquiry_links WHERE 1=1 $WHERE ORDER BY number desc LIMIT $start,$scale";
	$Result				= query($Sql);

	$Happy_Img_Name		= Array();
	$TPL->define("업체정보선택출력", "html/happy_inquiry_select_info_rows.html");

	while ( $Data = happy_mysql_fetch_array($Result) )
	{
		$Happy_Img_Name[0] = "../".$Data['photo2'];
		$Happy_Img_Name[1] = "../".$Data['photo3'];

		$img1_info = happy_image("자동","가로85","세로45","로고사용안함","로고위치7번","퀄리티100","gif원본출력","../img/noimage.jpg","가로기준세로자름");

		$업체정보이미지 = "<img src=\"".$img1_info."\" width=\"120\" height=\"90\" border=\"0\">";

		#채용분야
		$Data[type]	= '';
		$Data[type_short]	= '';
		if ($Data[type1])
		{
			$TYPE_SUB{$Data[type_sub1]}	= ( $TYPE_SUB{$Data[type_sub1]} == '' )?"":$TYPE_SUB{$Data[type_sub1]};
			$Data[type]	.= $Data[type] == '' ? '' : ', ';
			$Data[type]	.= "".$TYPE{$Data[type1]} ;
			$Data[type]	.= $Data[type] != '' && $TYPE_SUB{$Data[type_sub1]} != '' ? "-" . $TYPE_SUB{$Data[type_sub1]} : '';

			$Data[type_short]	.= $Data[type_short] == '' ? '' : ', ';
			$Data[type_short]	.= "".$TYPE{$Data[type1]} ;
		}

		$카테고리정보 = $Data[type];


		$content	= &$TPL->fetch();
		$print_out	.= $content;
	}

	if ( $Total == 0 )
	{
		$업체정보선택출력			= "출력할 채용정보가 없습니다.";
	}
	else
	{
		$업체정보선택출력			= $print_out;
	}

	if( !(is_file("html/happy_inquiry_select_info.html")) ) {
		print "html/happy_inquiry_select_info.html 파일이 존재하지 않습니다. ";
		exit;
	}

	$TPL->define("리스트", "html/happy_inquiry_select_info.html");
	$TPL->assign("리스트");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "Query Time : $exec_time sec";
	$TPL->tprint();

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<br><center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";

	if ( $demo_lock=='1' )
	{
		print $쿼리시간;
	}

?>