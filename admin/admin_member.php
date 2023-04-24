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


//	include ("./html/header.html");
	echo "<link rel='stylesheet' href='/html/style.css'  type='text/css'>";

	$mode	= $_GET["mode"];



	if ( $mode == "" || $mode == "list" )
	{
		member_list();
	}
	else if ( $mode == "write" )
	{
		member_write();
		echo member_formPrint();
	}
	else if ( $mode == "writeok" )
	{
		member_writeok();
	}
	else if ( $mode == "edit" )
	{
		member_edit();
		echo member_formPrint();
	}
	else if ( $mode == "editok" )
	{
		member_writeok();
	}
	else if ( $mode == "del" )
	{
		member_delete();
	}

//	include ("./html/foot.html");


###############################################################################################################################


	function member_list()
	{
		global $_GET, $_POST, $admin_member, $now_location_subtitle;

		$search_order	= $_GET["search_order"];
		$keyword		= $_GET["keyword"];
		if ( $keyword != "" )
		{
			$WHERE	= " AND $search_order like '%".$keyword."%' ";
		}

		####################### 페이징처리 ########################
		$start			= $_GET["start"];
		$scale			= 15;

		$Sql	= "select count(*) from $admin_member WHERE 1=1 $WHERE ";
		$Temp	= happy_mysql_fetch_array(query($Sql));
		$Total	= $Count	= $Temp[0];

		if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
		$pageScale		= 6;

		$searchMethod	= "";
			#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
				$searchMethod	.= "&search_order=$search_order&keyword=$keyword";
			#검색값 입력완료

		$order_query	= "number desc";

		$paging		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		###################### 페이징처리 끝 #######################

		$Sql	= "SELECT * FROM $admin_member WHERE 1=1 $WHERE ORDER BY $order_query LIMIT $start,$scale ";
		$Record	= query($Sql);

		$content	= "
			<script>
				function delis( urls )
				{
					if ( confirm('정말 삭제하시겠습니까?') )
					{
						window.location.href = urls;
					}
				}
			</script>
			<div class='main_title'>$now_location_subtitle [총 <b><font style='color:#17a7e3;'>$Total</font></b> 명]
				<span class='small_btn'>
					<a href='admin_member.php?mode=write' class='btn_small_green'>부관리자 등록</a>
				</span>
			</div>

			<div id='search_frm_onoff'>

			<form name='search_frm' style='margin:0;'>
				<div class='help_style'>
					<div class='box_1'></div>
					<div class='box_2'></div>
					<div class='box_3'></div>
					<div class='box_4'></div>
					<span class='help'>검색</span>
					<p>
					<table cellspacing='0' cellpadding='0' style='width:100%;'>
					<tr>
						<td style='width:150px; height:34px;'><strong>키워드</strong></td>
						<td>
							<table cellspacing='0' cellpadding='0'>
							<tr>
								<td class='input_style_adm'>
									<select name='search_order'>
									<option value='id'>아이디</option>
									<option value='name'>이름</option>
									</select>
									<script>document.search_frm.value = '$search_order';</script>
								</td>
								<td class='input_style_adm' style='padding-left:3px;'><input type='text' name='keyword' value='$keyword' id='search_word' style='width:300px;  padding-left:3px; border:1px solid #ccc;'></td>
								<td style='padding-left:3px;'><input type='submit' value='검색' id='search_btn' class='btn_small_blue3'></td>
							</tr>
							</table>

						</td>
					</tr>
					</table>
					</p>
				</div>
			</form>

			<div class='help_style'>
				<div class='box_1'></div>
				<div class='box_2'></div>
				<div class='box_3'></div>
				<div class='box_4'></div>
				<p class='help'>도움말</p>
				<p>
				부관리자 설정기능은 슈퍼관리자 혼자서 사이트의 관리가 어려울 경우 부관리자를 만들어 함께 관리할 수 있는 권한을 부여하는 부가기능입니다.<br/>
				부관리자로 설정한 아이디,비밀번호는 관리자로그인시 사용합니다.<br/>
				슈퍼관리자는 부관리자에게 관리할 영역을 별도로 지정할 수 있습니다.<br/>
				</p>
			</div>

			<div id='list_style'>
				<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
				<colgroup>
					<col style='width:5%;'></col>
					<col></col>
					<col style='width:15%;'></col>
					<col style='width:15%;'></col>
					<col style='width:10%;'></col>
					<col style='width:10%;'></col>
					<col style='width:5%;'></col>
					<col style='width:10%;'></col>
					<col style='width:10%;'></col>
				</colgroup>
				<tr>
					<th>번호</th>
					<th>아이디</th>
					<th>이름</th>
					<th>연락처</th>
					<th>등록일</th>
					<th>최종로그인</th>
					<th>접속수</th>
					<th>유효권한</th>
					<th class='last'>관리</th>
				</tr>


		";
$Count	= 0;
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$tableColor	= ( $Count++ % 2 == 0 )?"white":"#F8F8F8";

			$regDate	= substr($Data["date"],0,10);
			$lastDate	= substr($Data["lastlogin"],0,10);

			$content	.= "
				<tr>
					<td style='text-align:center;'>$listNo</td>
					<td class='bg_green'>$Data[id]</td>
					<td>$Data[name]</td>
					<td>$Data[phone]</td>
					<td style='text-align:center;'>$regDate</td>
					<td style='text-align:center;'>$lastDate</td>
					<td style='text-align:center;'>$Data[login_count]</td>
					<td style='text-align:center;'>[$Data[menu_sum]]가지 메뉴</td>
					<td style='padding:10px'><a href='admin_member.php?mode=edit&number=$Data[number]&userid=$Data[id]' class='btn_small_red2'>수정</a> <a href=\"javascript:delis('admin_member.php?mode=del&number=$Data[number]&userid=$Data[id]')\" class='btn_small_dark3' style='margin-top:5px'>삭제</a></td>
				</tr>

					";
			$listNo--;
		}

		$content	.= "
			</table>
		</div>
		<div style='position:relative; padding:20px 0 20px 0;' align='center'>
			$paging
			<div style='position:absolute; right:0; top:0px;'><a href='?mode=write' class='btn_small_dark'>등록하기</a></div>
		</div>


			";
		echo $content;
	}


	#=============================================================================================================


	function member_write()
	{
		global $adminMenuNames, $chmod_nval, $chmod_yval, $chmod_y, $chmod_n;
		for ( $i=0, $max=sizeof($adminMenuNames), $chmod_n="", $chmod_nval="", $chmod_yval="" ; $i<$max ; $i++ )
		{
			$q	= $i+1;
			$chmod_n	.= "<option value='menu".$q."'>$adminMenuNames[$i]</option>\n";
			$chmod_nval	.= "menu".$q.",";
		}
	}


	#=============================================================================================================


	function member_edit()
	{
		global $adminMenuNames, $chmod_nval, $chmod_yval, $chmod_y, $chmod_n, $Data, $_GET, $admin_member;

		$number		= $_GET["number"];
		$userid		= $_GET["userid"];
		if ( $number == "" || $userid == "" )
		{
			error("잘못된 경로로 접근하셨습니다.");
			exit;
		}

		$Sql	= "SELECT * FROM $admin_member WHERE id='$userid' AND number='$number' ";
		$Data	= happy_mysql_fetch_array(query($Sql));

		for ( $i=0, $max=sizeof($adminMenuNames), $chmod_n="", $chmod_nval="", $chmod_yval="" ; $i<$max ; $i++ )
		{
			$q		= $i+1;
			$colum	= "menu".$q;

			if ( $Data[$colum] == "Y" )
			{
				$chmod_y	.= "<option value='$colum'>$adminMenuNames[$i]</option>\n";
				$chmod_yval	.= $colum;
			}
			else
			{
				$chmod_n	.= "<option value='$colum'>$adminMenuNames[$i]</option>\n";
				$chmod_nval	.= $colum;
			}
		}

	}


	#=============================================================================================================


	function member_writeok()
	{
		global $_POST, $admin_member;

		$number		= $_POST["number"];
		$id			= $_POST["id"];
		$pass		= $_POST["pass"];
		$name		= $_POST["name"];
		$phone		= $_POST["phone"];
		$chmod_yval	= $_POST["chmod_yval"];
		$chmod_nval	= $_POST["chmod_nval"];

		$tmp_y	= explode(",",$chmod_yval);
		$tmp_n	= explode(",",$chmod_nval);

		$chmod_query	= "";
		for ( $i=0,$menu_sum=0,$max=sizeof($tmp_y) ; $i<$max ; $i++ )
		{
			if ( $tmp_y[$i] != "" )
			{
				$chmod_query	.= $tmp_y[$i] ."='Y', ";
				$menu_sum++;
			}
		}
		for ( $i=0,$max=sizeof($tmp_n) ; $i<$max ; $i++ )
		{
			if ( $tmp_n[$i] != "" )
				$chmod_query	.= $tmp_n[$i] ."='N', ";
		}
		$chmod_query	= " menu_sum = '$menu_sum', ". $chmod_query;

		$SetSql	 = "	id = '$id',						";
		$SetSql	.= "	pass = '$pass',					";
		$SetSql	.= $chmod_query;
		$SetSql	.= "	name = '$name',					";
		$SetSql	.= "	phone = '$phone'				";

		if ( $number == "" )
		{
			$Sql	= "SELECT count(*) FROM $admin_member WHERE id='$id' ";
			$Temp	= happy_mysql_fetch_array(query($Sql));

			if ( $Temp[0] == 0 )
			{
				$Sql	 = "	INSERT INTO										";
				$Sql	.= "			$admin_member							";
				$Sql	.= "	SET												";
				$Sql	.= $SetSql;
				$Sql	.= "			, date=now(),							";
				$Sql	.= "			login_count = 0							";

				$Msg	= "등록되었습니다.";
			}
			else
			{
				error("이미 등록된 아이디입니다.");
				exit;
			}
		}
		else
		{
			$Sql	= "SELECT count(*) FROM $admin_member WHERE id='$id' AND number!='$number' ";
			$Temp	= happy_mysql_fetch_array(query($Sql));

			if ( $Temp[0] == 0 )
			{
				$Sql	 = "	UPDATE											";
				$Sql	.= "			$admin_member							";
				$Sql	.= "	SET												";
				$Sql	.= $SetSql;
				$Sql	.= "	WHERE											";
				$Sql	.= "			number='$number'						";

				$Msg	= "수정되었습니다.";
			}
			else
			{
				error("이미 등록된 아이디입니다.");
				exit;
			}
		}

		#echo $Sql."<br><br>";
		#exit;

		query($Sql);
		gomsg($Msg,"admin_member.php");

	}


	#=============================================================================================================


	function member_formPrint()
	{

		global $Data,$chmod_nval,$chmod_yval,$chmod_y,$chmod_n,$_GET;

		$submit_value	= ( $_GET["number"] == "" )?"등록하기":"수정하기";
		$submit_icon	= ( $_GET["number"] == "" )?"ico_sendit":"ico_sendit2";

		$content	= "
<script>
	function move(No)
	{
		if ( No == 1 )
		{
			var CopySel	= document.forms[0].chmod_n;
			var MoveSel	= document.forms[0].chmod_y;
		}
		else if ( No == 2 )
		{
			var CopySel	= document.forms[0].chmod_y;
			var MoveSel	= document.forms[0].chmod_n;
		}
		else
			return;

		sNo	= CopySel.selectedIndex;
		while ( sNo != -1 )
		{
			tmp_value	= CopySel.options[sNo].value;
			tmp_text	= CopySel.options[sNo].text;

			MoveSel.options[MoveSel.length]	= new Option(tmp_text,tmp_value,false);
			CopySel.options[sNo]			= null;

			sNo	= CopySel.selectedIndex;
		}
	}

	function submit_chk()
	{
		var frm		= document.forms[0];
		var Sel_y	= frm.chmod_y;
		var Sel_n	= frm.chmod_n;

		var Size_y	= Sel_y.length;
		var Size_n	= Sel_n.length;

		var Sel_value_y	= '';
		var Sel_value_n	= '';

		for ( i=0 ; i<Size_y ; i++ )
		{
			Sel_value_y	+= ( i!=0 )?',':'';
			Sel_value_y	+= Sel_y.options[i].value;
		}

		for ( i=0,Sel_value_n='' ; i<Size_n ; i++ )
		{
			Sel_value_n	+= ( i!=0 )?',':'';
			Sel_value_n	+= Sel_n.options[i].value;
		}

		frm.chmod_yval.value	= Sel_value_y;
		frm.chmod_nval.value	= Sel_value_n;


		if ( frm.id.value == '' )
		{
			alert('아이디를 입력하세요');
			frm.id.style.background = '#FFFF99';
			frm.id.focus();
			return false;
		}
		else if ( frm.pass.value == '' )
		{
			alert('비밀번호를 입력하세요');
			frm.pass.style.background = '#FFFF99';
			frm.pass.focus();
			return false;
		}
		else if ( frm.name.value == '' )
		{
			alert('이름을 입력하세요');
			frm.name.style.background = '#FFFF99';
			frm.name.focus();
			return false;
		}
		else
			return true;

	}
</script>
";

if($_GET['mode'] == write){
	$mode_text = "등록";
}else{
	$mode_text = "수정";
}

$content .= <<<END

<p class='main_title'>부관리자 $mode_text</p>

<form name='admin_member_frm' action='?mode=writeok' method='post' onSubmit='return submit_chk()' style='margin:0;'>
<input type='hidden' name='chmod_nval' value='$chmod_nval'>
<input type='hidden' name='chmod_yval' value='$chmod_yval'>
<input type='hidden' name='number' value='$_GET[number]'>

<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>


	<table cellspacing='1' cellpadding='0' class='bg_style box_height'>
	<tr>
		<th>아이디</th>
		<td>
			<p class='short'>아이디를 입력 하세요.</p>
			<input type='text' name='id' value='$Data[id]'>
		</td>
	</tr>
	<tr>
		<th>비밀번호</th>
		<td>
			<p class='short'>비밀번호를 입력 하세요.</p>
			<input type='text' name='pass' value='$Data[pass]'>
		</td>
	</tr>
	<tr>
		<th>이름</th>
		<td>
			<p class='short'>부관리자의 이름을 입력 하세요.</p>
			<input type='text' name='name' value='$Data[name]'>
		</td>
	</tr>
	<tr>
		<th>연락처</th>
		<td>
			<p class='short'>부관리자의 연락처를 입력 하세요.</p>
			<input type='text' name='phone' value='$Data[phone]'>
		</td>
	</tr>
	<tr>
		<th>권한설정</th>
		<td>
			<p class='short'>부관리자에게 부여할 권한을 설정하세요..</p>

			<table cellspacing='0' cellpadding='0'>
			<colspan>
			<col style='width:45%;'></col>
			<col></col>
			<col style='width:45%;'></col>
			</colspan>
			<tr>
				<td>
					<div class='btn_small_stand' style='display:block !important;'>사용가능 목록</div>
					<select name='chmod_y' size=10 style='width:100%; background:#a2e3fe; border:1px solid #333; padding:5px; height:200px' multiple>
					$chmod_y
					</select>
				</td>
				<td style="text-align:center;"><a href='#1' onClick='move(1)' class='btn_small_stand'>← 이동</a><br><br><a href='#1' onClick='move(2)' class='btn_small_gray'>→ 이동</a></td>
				<td>
					<div class='btn_small_stand' style='display:block !important;'>사용 불가능 목록</div>
					<select name='chmod_n' size=10 style='width:100%; background:#fea2a2; border:1px solid #333; padding:5px; height:200px' multiple>
					$chmod_n
					</select>
				</td>
			</tr>
			</table>

		</td>
	</tr>
	</table>

</div>

<div style="text-align:center;"><input type='submit' value='저장하기' class='btn_big'></div>
</form>

END;

		return $content;
	}


	#==============================================================================================================
include ("tpl_inc/bottom.php");


	function member_delete()
	{
		global $_GET, $admin_member;

		$number	= $_GET["number"];
		$userid	= $_GET["userid"];

		if ( $number == "" || $userid == "" )
		{
			error("잘못된 경로로 접근하셨습니다.");
			exit;
		}
		else
		{
			$Sql	= "DELETE FROM $admin_member WHERE number='$number' AND id='$userid' ";
			query($Sql);
			gomsg("삭제되었습니다.","admin_member.php");
		}
	}

###############################################################################################################################
?>