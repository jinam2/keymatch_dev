<?php
$t_start = array_sum(explode(' ', microtime()));
include ("../inc/Template.php");
$TPL = new Template;

include ("../inc/config.php");

include ("../inc/function.php");
include ("../inc/lib.php");

if ( !admin_secure("구인리스트") ) {
		error("접속권한이 없습니다.");
		exit;
}

	function happy_config_query_make($title, $value,$out)
	{
		global $happy_config;
		$Sql	= "select count(*) from $happy_config WHERE conf_name='$title' ";
		$Temp	= happy_mysql_fetch_array(query($Sql));

		if ( $Temp[0] == 0 )
		{
			$Sql	= "
						INSERT INTO
								$happy_config
						SET
								conf_name		= '$title',
								conf_value		= '$value',
								conf_out_type	= '$out',
								reg_date		= now(),
								mod_date		= now()
			";
		}
		else
		{
			$Sql	= "
						UPDATE
								$happy_config
						SET
								conf_name		= '$title',
								conf_value		= '$value',
								conf_out_type	= '$out',
								mod_date		= now()
						WHERE
								conf_name		= '$title'
			";
		}
		return $Sql;
	}

if($_POST)
{
	$company_member_group_cfg	= $_POST['company_member_group_cfg'];
	$company_member_id_cfg		= $_POST['company_member_id_cfg'];

	if($company_member_group_cfg != '')
	{
		query(happy_config_query_make('company_member_group_cfg', $company_member_group_cfg,''));
	}

	if($company_member_id_cfg != '')
	{
		query(happy_config_query_make('company_member_id_cfg', $company_member_id_cfg,''));
	}

	gomsg("저장되었습니다.",$_SERVER['PHP_SELF']);
	exit;
}

################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################

$sql	= "
			SELECT
				number, group_name
			FROM
				$happy_member_group
			ORDER BY
				number
			ASC
";
$recode	= query($sql);
$option_group	= "<option value=\"\">회원그룹을 선택해주세요.</option>\r\n";
while($data = happy_mysql_fetch_assoc($recode))
{
	if( $data[group_name] == '' ) continue;
	$selected		= ($data['number'] == $HAPPY_CONFIG['company_member_group_cfg']) ? ' selected ' : '';
	$option_group	.= "<option value=\"$data[number]\" $selected>$data[group_name]</option>\r\n";
}

if($HAPPY_CONFIG['company_member_group_cfg'] != '')
{
	$sql	= "
				SELECT
					user_id,com_name
				FROM
					$happy_member
				WHERE
					`group` = '$HAPPY_CONFIG[company_member_group_cfg]'
				ORDER BY
					number
				ASC
	";
	$recode			= query($sql);
	$option_member	= "<option value=\"\">회원ID을 선택해주세요.</option>\r\n";
	while($data = happy_mysql_fetch_assoc($recode))
	{
		$selected		= ($data['user_id'] == $HAPPY_CONFIG['company_member_id_cfg']) ? ' selected ' : '';
		$data[com_name]	= ($data[com_name] == '') ? '' : "[$data[com_name]] ";
		$option_member	.= "<option value=\"$data[user_id]\" $selected>$data[com_name]$data[user_id]</option>\r\n";
	}
}
else
{
	$option_member	= "<option value=\"\">1. 기업회원그룹을 설정해주세요.</option>\r\n";
}

if( $HAPPY_CONFIG['company_member_group_cfg'] != '' && $HAPPY_CONFIG['company_member_id_cfg'] != '')
{
	$admin_url	= "guin_regist.php";
	$result_str	= "<a href=\"../happy_member_login.php?mode=admin_login_reg&member_login_id=$HAPPY_CONFIG[company_member_id_cfg]&admin_url=$admin_url\" class='btn_small_red'><strong>[$HAPPY_CONFIG[company_member_id_cfg]]</strong> 아이디로 채용정보 등록</a>";
}
else
{
	$result_str	= "<span class='btn_small'>아래의 설정을 모두 완료 하셔야 채용정보 등록이 가능합니다.</span>";
}

echo "
<p class='main_title'>관리자 채용등록 설정 <span class='small_btn'>$result_str</span></p>

<form method=\"post\">

<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>

	<table cellspacing='1' cellpadding='0' border='0' class='bg_style size_stand'>
	<tr>
		<th style='width:150px;'>기업회원 그룹설정</th>
		<td>
			<p class='short'>기업회원그룹을 설정하세요.</p>
			<div class='input_style_adm'>
				<select name=\"company_member_group_cfg\" id=\"company_member_group_cfg\">
				$option_group
				</select>
			</div<
		</td>
	</tr>
	</table>
</div>
<div style='text-align:center;margin: 20px 0;'><input type='submit' value='저장하기' class='btn_big_round'></div>
</form>
<form method=\"post\">
<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>

	<table cellspacing='1' cellpadding='0' border='0' class='bg_style size_stand'>

	<tr>
		<th style='width:150px;'>기업회원 ID 지정</th>
		<td>
			<p class='short'>해당 아이디로 채용등록이 진행됩니다.</p>
				<div class='input_style_adm'>
					<select name=\"company_member_id_cfg\" id=\"company_member_id_cfg\">
					$option_member
					</select>
				</div>
		</td>
	</tr>
	</table>
</div>
<div style='text-align:center;margin: 20px 0;'><input type='submit' value='저장하기' class='btn_big_round'></div>


</form>";

include ("tpl_inc/bottom.php");

if ($demo){
$exec_time = array_sum(explode(' ', microtime())) - $t_start;
$exec_time = round ($exec_time, 2);
print   "<center><font color=gray size=1>Query Time : $exec_time sec";
}
exit;

?>