<?

	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");
	include ("../inc/Template.php");
	$TPL = new Template;

	if ( !admin_secure("회원관리") )
	{
		error("접속권한이 없습니다.");
		exit;
	}
/*
CREATE TABLE happy_member_secure (
 number int not null auto_increment primary key,
 group_number int not null default '0',
 user_id varchar(50) not null default '',
 menu_title varchar(100) not null default '',
 menu_use enum('y', 'n') not null default 'n',
 key(group_number),
 key(user_id),
 key(menu_title),
 key(menu_use)
);

*/
	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################



	$mode			= $_GET['mode'];
	if ( $_GET['group_number'] == $happy_member_secure_noMember_code ) //비회원그룹일 경우 , 권한설정제거 ralear 2014-02-13
	{
		foreach ( $happy_member_secure_page as $key => $val )
		{
			if ( in_array($val, $no_member_not_arr) )
			{
				unset($happy_member_secure_page[$key]);
			}
		}
	}

	array_multisort($happy_member_secure_page);
	if ( $mode == 'writeok' )
	{
		#echo "<pre>";print_r($_POST);echo "</pre>";

		$group_number	= $_POST['group_number'];
		$chmod_yval		= explode(',', $_POST['chmod_yval']);
		$chmod_nval		= explode(',', $_POST['chmod_nval']);

		for ( $i=0, $max=sizeof($happy_member_secure_page) ; $i<$max ; $i++ )
		{
			$menu_title	= $happy_member_secure_page[$i];
			if ( array_search( $menu_title, $chmod_yval ) !== false )
			{
				# 사용 불가능한 메뉴임
				$menu_use	= 'y';
			}
			else
			{
				# 사용 가능한 메뉴임
				$menu_use	= 'n';
			}

			$Sql	= "
						SELECT
								Count(*)
						FROM
								$happy_member_secure
						WHERE
								group_number	= '$group_number'
								AND
								menu_title		= '$menu_title'
			";
			list($nowCnt)	= happy_mysql_fetch_array(query($Sql));

			if ( $nowCnt > 0 )
			{
				$Sql	= "
							UPDATE
									$happy_member_secure
							SET
									menu_use		= '$menu_use'
							WHERE
									group_number	= '$group_number'
									AND
									menu_title		= '$menu_title'
				";
			}
			else
			{
				$Sql	= "
							INSERT INTO
									$happy_member_secure
							SET
									group_number	= '$group_number',
									user_id			= '',
									menu_title		= '$menu_title',
									menu_use		= '$menu_use'
				";
			}
			query($Sql);
		}

		#업데이트 도중 테이블깨짐 방지 위해 추가
		echo "
					</td>
					<td style=\"background:url('img/bgbox_02_v3_b.gif')\"></td>
				</tr>
				<!-- BOTTOM -->
				<tr>
					<!-- 좌측  -->
					<td height=36 style=\"background:url('img/bgbox_02r_v1_c2.gif') no-repeat 0 0;\"></td>

					<!-- 우측 -->
					<td style=\"background:url('img/bgbox_02_v2_c.gif');\">&nbsp;</td>
					<td style=\"background:url('img/bgbox_02_v3_c.gif') no-repeat 0 0;\"></td>
				</tr>
				</table>

			</td>
		</tr>
		</table>";

		go("happy_member_secure.php?group_number=$group_number");
		exit;
	}
	else
	{

		$group_number	= $_GET['group_number'];
		$chmod_y		= '';
		$chmod_n		= '';

		$chmod_yval		= '';
		$chmod_nval		= '';

		for ( $i=0, $max=sizeof($happy_member_secure_page) ; $i<$max ; $i++ )
		{
			$menu_title		= $happy_member_secure_page[$i];

			$Sql			= "SELECT * FROM $happy_member_secure WHERE group_number='$group_number' AND menu_title='$menu_title' ";
			$Data			= happy_mysql_fetch_array(query($Sql));

			if ( $Data['menu_use'] == 'y' )
			{
				$chmod_y	.= "<option value='$menu_title'>$menu_title</option>\n";
				$chmod_yval	.= $menu_title.',';
			}
			else
			{
				$chmod_n	.= "<option value='$menu_title'>$menu_title</option>\n";
				$chmod_nval	.= $menu_title.',';
			}
		}


		$Sql		= "SELECT * FROM $happy_member_group WHERE number = '$_GET[group_number]'";
		$Record		= query($Sql);
		$groupMemberTitle = "비";
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$groupMemberTitle =  $Data[group_name];
		}




		echo "

			<style type='text/css'>
				select option{color:white;}
			</style>

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

					return true;

				}
			</script>


			<!-- 메뉴권한 등록 [ start ] -->
			<form name='happy_member_secure_frm' action='?mode=writeok' method='post' onSubmit='return submit_chk()'>
			<input type='hidden' name='chmod_nval' value='$chmod_nval'>
			<input type='hidden' name='chmod_yval' value='$chmod_yval'>
			<input type='hidden' name='group_number' value='$_GET[group_number]'>

			<p class='main_title'><span style='color:#0088ff;'>$groupMemberTitle</span> 회원그룹 메뉴권한 설정</p>
			<div id='box_style'>
				<div class='box_1'></div>
				<div class='box_2'></div>
				<div class='box_3'></div>
				<div class='box_4'></div>
				<table cellspacing='1' cellpadding='0' class='bg_style box_height'>
				<tr>
					<th>메뉴<br>접속권한설정</th>
					<td>
						<table cellspacing='0' cellpadding='0' style='width:100%;'>
						<colspan>
						<col style='width:45%;'></col>
						<col></col>
						<col style='width:45%;'></col>
						</colspan>
						<tr>
							<td>
								<div class='btn_small_stand' style='display:block !important;'>사용가능 메뉴목록</div>
								<select name='chmod_y' size=25 style='width:100%; background:#0080FF; border:1px solid #333; padding:5px; height:300px' multiple>
								$chmod_y
								</select>
							</td>
							<td style='text-align:center;'><a href='#1' onClick='move(1)' class='btn_small_stand'>← 이동</a><br><br><a href='#1' onClick='move(2)' class='btn_small_gray'>→ 이동</a></td>
							<td>
								<div class='btn_small_stand' style='display:block !important;'>사용불가능 메뉴목록</div>
								<select name='chmod_n' size=25 style='width:100%; background:#FD7439; border:1px solid #333; padding:5px; height:300px' multiple>
								$chmod_n
								</select>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
			<div align='center'>
				<input type='submit' value='등록하기' class='btn_big'>
				<input type='button' value='목록보기' onclick=location.href='happy_member_group.php' class='btn_big_gray'>
			</div>
			</form>
		";


	}





	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################

?>