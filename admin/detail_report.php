<?
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/Template.php");
	$TPL = new Template;

	include ("../inc/lib.php");



if ( !admin_secure("구인리스트") ) {
		error("접속권한이 없습니다.");
		exit;
}


	//관리자메뉴 [ YOON :2009-10-07 ]
	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################

	$mode		= $_GET['mode'];
	$return_url	= $_GET['return_url'];
	$number		= $_GET['number'];

	if ( $mode == 'confirm_ok' )
	{
		$Sql		= "UPDATE $message_tb SET readok = 'y' WHERE number = '$number'";
		query($Sql);

		error("확인처리 되었습니다.");
		exit;
	}
	else if ( $mode == 'del' )
	{
		$Sql		= "UPDATE $message_tb SET del_receive = 'y' WHERE number = '$number'";
		query($Sql);

		error("삭제되었습니다.");
		exit;
	}
?>
	<!--//쪽지신고하기-->


	<script type='text/javascript'>

		function go_page(report_get, report_post)
		{
			//alert(report_post);
			if ( report_post != '' )
			{
				OpenLink		= '';
				Hidden_Val		= '';

				Temp			= report_post.split('_CUT_');
				for ( i = 0; i < Temp.length; i++  )
				{
					Temp2			= Temp[i].split("=");
					Hidden_Val		+= "<input type='hidden' name='"+Temp2[0]+"' value='"+Temp2[1]+"' />";
				}

				submit_form		= "<form name='report_go' action='" + report_get + "' method='post' target='POPUP'>";
				submit_form		+= Hidden_Val;
				submit_form		+= "</form>";

				document.getElementById('go_div').innerHTML = submit_form;
			}
			else
			{
				OpenLink		= report_get;
			}

			POPUP			= window.open(OpenLink,'POPUP','fullscreen=no,menubar=yes,status=yes,toolbar=yes,titlebar=yes,location=yes,scrollbars=yes,resizable=yes');
			POPUP.focus();
			document.report_go.submit();
		}

		before_num = '';
		function show_msg(number, msg, obj)
		{
			if ( obj.value == '상세보기' )
			{
				Temp = document.getElementById('content_design').innerHTML;
				Temp = Temp.replace(/%내용%/gi, msg);
				//Temp = Temp.replace(/%고유넘버%/gi, number);
				//Temp = Temp.replace(/%현재주소%/gi, encodeURIComponent("<?=$_SERVER['HTTP_REFERER']?>"));

				obj.value = '상세닫기';
			}
			else
			{
				Temp = '';
				obj.value = '상세보기';
			}

			//alert(Temp);



			if ( before_num != '' )
			{
				document.getElementById('msg_contents_' + before_num).innerHTML = '';
				document.getElementById('btn_' + before_num).value = '상세보기';
			}

			if ( number == before_num )
			{
				before_num	= '';
			}
			else
			{
				document.getElementById('msg_contents_' + number).innerHTML = Temp;
				before_num	= number;
			}
		}

	</script>

	<!--폼관련 div 삭제금지-->
	<div id="go_div"></div>

	<!--상세내용 div 삭제금지-->
	<div id="content_design" style="display:none;">
		<table width='100%' border='0' style="border:1px solid #dedede; border-top:none; background:#f1f1f1;">
		<tr>
			<td style="padding:10px;line-height:20px;">%내용%</td>
		</tr>
		</table>
	</div>


	<p class="main_title">쪽지 신고 리스트</p>

	<div id="list_style" >
		<table cellspacing="0" cellpadding="0" border="0" class='bg_style b_border' style="width:100%; table-layouf:fixed">
		<colgroup>
		<col style='width:5%;'>
		<col style='width:12%;'>
		<col>
		<col style='width:15%;'>
		<col style='width:8%;'>
		<col style='width:10%;'>
		</colgroup>
		<tr>
			<th>번호</th>
			<th>신고자</th>
			<th>신고 URL</th>
			<th>신고날짜</th>
			<th>확인유무</th>
			<th class="last">관리자툴</th>
		</tr>
<?
	####################### 페이징처리 ########################
	$start			= $_GET["start"];
	$scale			= 20; //페이지당 개수


	$Sql			= "
						SELECT
								COUNT(*)
						FROM
								$message_tb
						WHERE
								report_get	!= ''
								AND
								del_receive	= 'n'
	";
	$Temp			= happy_mysql_fetch_array(query($Sql));
	$Total			= $Count = $Temp[0];

	if ( $start ) { $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
	$pageScale		= 10;

	$searchMethod	= "";

	$페이징			= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
	###################### 페이징처리 끝 #######################

	$Detail_Table	= ${$Report_Var['Links_Table']};

	$Sql			= "
						SELECT
								*
						FROM
								$message_tb
						WHERE
								report_get != ''
								AND
								del_receive	= 'n'
						ORDER BY
								number DESC
						LIMIT
								$start, $scale
	";
	$Record			= query($Sql);
	$Count			= 0;
	while ( $rows = happy_mysql_fetch_assoc($Record) )
	{
		$rows['message']	= str_replace("\r\n","<br />",$rows['message']);

		$confirm_bool	= $rows['readok'] == 'y' ? '<b style="color:blue;">확인함</b>' : '<b style="color:red;">미확인</b>';

		//$rows_color 는 top.php 에서 설정 [ YOON : 2010-03-23 ]
		$bgcolor		= ( $Count % 2 == 0 )? "white" : $rows_color;

		$temp			= explode('.', $rows['sender_id']);
		$send_msg_spt	= "";
		if ( sizeof($temp) == 4 && preg_replace("/\D/", "", $temp[0]) == $temp[0] ) //비회원이 신고한 쪽지
		{
			$send_msg_spt	= "";
		}
		else
		{
			$send_msg_spt	= "window.open('../happy_message.php?mode=send&receiveid=".$rows['sender_id']."&senderAdmin=y&file=message_send_form_simple.html&endMode=close','happy_message','width=500,height=480,toolbar=no,scrollbars=no')";
		}

		//도메인이 변경되었을 경우를 위한 처리
		$temp				= preg_replace("/htt(ps|p):\/\/|www./", "", $rows['report_get']);
		$temp				= explode("/", $temp);
		$rows['report_get']	= $main_url.'/'.$temp[1];
?>
		<tr onMouseOut="this.style.backgroundColor=''" bgcolor=<?=$bgcolor?>>
			<td class='b_border_td' style="text-align:center; height:35px"><?=$listNo?></td>
			<td class='b_border_td'><a href="javascript:void(0);" onclick="<?=$send_msg_spt?>" style="color:#333"><?=$rows['sender_id']?></a></td>
			<td class='b_border_td'><a href="javascript:go_page('<?=urlencode($rows['report_get'])?>','<?=urlencode($rows['report_post'])?>');" style="color:#333"><?=kstrcut($rows['report_get'],'70','...')?></a></td>
			<td class='b_border_td' style="text-align:center;"><?=$rows['regdate']?></td>
			<td class='b_border_td' style="text-align:center;"><?=$confirm_bool?></td>
			<td class='b_border_td' style="text-align:center;">

				<input type="button" value="상세보기" onclick="show_msg('<?=$rows['number']?>','<?=$rows['message']?>', this);" id="btn_<?=$rows['number']?>" class="btn_small_dark"/>
				<input type='button' value='확인완료' onclick="if ( confirm('확인하셨습니까?') ) { location.href='?mode=confirm_ok&number=<?=$rows['number']?>'; }" class="btn_small_blue" style='margin-top:3px'/>
				<input type="button" value="쪽지삭제" onclick="if ( confirm('신고된 쪽지를 삭제하시겠습니까?') ) { location.href='?mode=del&number=<?=$rows['number']?>'; }" class="btn_small_red" style='margin-top:3px'/>
			</td>
		</tr>
		<tr>
			<td colspan='24'><div id="msg_contents_<?=$rows['number']?>" style="background-color:#ffffcc"></div></td>
		</tr>

<?
		$Count++;
		$listNo--;
	}
?>

		</table>
	</div>
	<div align="center" style="padding:20px 0 20px 0;"><?=$페이징?></div>

<?
	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################
?>

