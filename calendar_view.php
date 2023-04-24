<?

	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");
	include ("./inc/lib_calendar.php");


#	print $calendar_dojang_point;


	if ( !admin_secure("관리자냐") ) {
		$master_check = '1';
	}
	else {
		$master_check = '';
	}


	#댓글등록하기
	if ($_GET[action] == 'add_reg'){

		if (!$happy_member_login_value){
			//error('회원전용서비스입니다. 로그인후 이용하실 수 있습니다.');
			gomsg('회원전용서비스입니다. 로그인후 이용하실 수 있습니다.', 'happy_member_login.php');
			exit;
		}


		$sql = "insert into $calendar_view_tb set id = '$happy_member_login_value' , comment = '$_POST[short_comment]' , reg_date = now()  ";
		$result = query($sql);
		gomsg('댓글이 등록 되었습니다.','calendar_view.php');
		exit;
	
	}
	#출석도장찍기
	if ($_GET[action] == 'dojang_reg'){

		if (!$happy_member_login_value){
			//error('회원전용서비스입니다. 로그인후 이용하실 수 있습니다.');
			gomsg('회원전용서비스입니다. 로그인후 이용하실 수 있습니다.', 'happy_member_login.php');
			exit;
		}

		#오늘 도장찍었는지 보고 메세지 출력
		$sql = "select * from  $calendar_dojang_tb where id = '$happy_member_login_value' and left(reg_date,10) = curdate()   ";
		$result = query($sql);
		$TC = happy_mysql_fetch_array($result);
		$dojang_check = number_format($TC[0]);

		if ($dojang_check){
			error("$happy_member_login_value 회원님은 이미 출석도장을 찍었습니다. ^^");
			exit;
		}
		else {

			$get_ip = $_SERVER["REMOTE_ADDR"];
			$sql = "insert into $calendar_dojang_tb set id = '$happy_member_login_value' , comment = '$get_ip' , reg_date = now()  ";
			$result = query($sql);
			

			$time = $happy_member_login_value."-".happy_mktime();
			#포인트장부
			$sql_auction = "insert $point_jangboo  set
			id = '$happy_member_login_value',
			point = '$calendar_dojang_point',
			pay_type = '출근도장',
			in_check = '1',
			or_no = '$time',
			reg_date = now()
			";
			$result_auction = query($sql_auction);

			#업체회원정보에 포인트 up
			$sql = "update $happy_member set point = point + $calendar_dojang_point where user_id = '$happy_member_login_value' ";
			$result = query($sql);

			gomsg('출석도장을 찍었습니다.','calendar_view.php');
		}
		exit;
	
	}


	#로그인안한 회원의 댓글박스 메세지
	if (!$happy_member_login_value){
		$no_login_message_box = "회원전용서비스입니다. 로그인후 이용하실 수 있습니다.";
	}
	else {
		$javascript_check = <<<END
		<SCRIPT language="JavaScript">
		function CheckForm(theForm)
		{
			if (theForm.short_comment.value.length == 0	)
			{
				 alert("댓글 내용을 입력하세요");
				 theForm.short_comment.focus();
				 return (false);
			  }
		}
		function bbsdel(strURL) {
			var msg = '댓글을 삭제하시겠습니까?';

			if (confirm(msg)){
				window.location.href= strURL;
			}
		}
		</SCRIPT>	
END;
	}

	$array_name		= array("---전체---","아이디검색","댓글내용검색");
	$array_value	= array("","id",'comment');
	$mod			= "";
	$var_name		= "search_type";
	$select_name	= $_GET[search_type];
	$width			= "90";
	$달력검색종류	= make_selectbox2($array_name,$array_value,$mod,$var_name,$select_name,$width);


	#오늘 등록한 댓글갯수 카운팅
	$sql = "select count(*) from $calendar_view_tb where left(reg_date,10) = curdate()";
	$result = query($sql);
	$TC = happy_mysql_fetch_array($result);
	$Now_num = number_format($TC[0]);


	#오늘 출석도장 카운팅
	$sql = "select count(*) from $calendar_dojang_tb where left(reg_date,10) = curdate()";
	$result = query($sql);
	$TC = happy_mysql_fetch_array($result);
	$Today_num = number_format($TC[0]);

	#어제 출석도장 카운팅
	$sql = "select count(*) from $calendar_dojang_tb where left(reg_date ,10) =  left(DATE_SUB(curdate() , interval 1 day),10) ";
	$result = query($sql);
	$TC = happy_mysql_fetch_array($result);
	$Yesday_num = number_format($TC[0]);

	#댓글읽어 출력하기
	$댓글총출력갯수 = '총15개';
	$댓글가로갯수 = '가로1개';
	$댓글자름 = '20자자름';
	$댓글호출명 = '현재';
	$댓글템플릿파일 = 'cal_comment_rows.html';
	$댓글AJAX형식 = 'ajax';
	$댓글AJAX이름 = 'ajax_name';

	$댓글총출력갯수 = preg_replace('/\D/', '', $댓글총출력갯수);
	$댓글가로갯수 = preg_replace('/\D/', '', $댓글가로갯수);
	$댓글자름 = preg_replace('/\D/', '', $댓글자름);
	$댓글호출명  = preg_replace('/\n/', '', $댓글호출명);
	$댓글호출명  = urlencode($댓글호출명);
	$댓글템플릿파일  = preg_replace('/\n/', '', $댓글템플릿파일);



	$달력댓글리스트 = calendar_extraction_list("$댓글총출력갯수","$댓글가로갯수","$댓글자름","$댓글호출명","$댓글템플릿파일","$댓글AJAX형식","$댓글AJAX이름" );

	#달력읽어오기
	//$출석체크용달력 = happy_schedule_calrendar('cal_default.html','cal_rows.html','#ffffff','#000000');
	$내용 = happy_schedule_calrendar('cal_default.html','cal_rows.html','#ffffff','#000000');

	$TPL->define("껍데기", "$skin_folder/default.html");
	$content = &$TPL->fetch();
	print $content;




?>