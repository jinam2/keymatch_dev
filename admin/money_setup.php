<?php
include ("../inc/config.php");
include ("../inc/Template.php");
$TPL = new Template;

include ("../inc/function.php");
include ("../inc/lib.php");


//$_GET
//$_POST
//$_COOKIE

if ( !admin_secure("유료옵션설정") ) {
		error("접속권한이 없습니다.");
		exit;
}

if ($demo == "1") {	#데모이면 삭제안됨
$message ="<br><br><font color=blue> - 핸드폰 결제 및 카드결제는 어떤PG사를
<br> - 사용하시던지 해피CGI에서 무료제작,연동 해드립니다<br><br>";
}

include ("tpl_inc/top_new.php");



$action = $_POST[action];
if ($action == ''){
	$action = $_GET[action];
}

if ($action == "") {
	option();
}
elseif ($action == "main_reg") {
	main_reg();
}

#이력서 유료설정
elseif ($action == "member") {
	member();
}
elseif ($action == "member_reg") {
	member_reg();
}
#개인회원 유료설정
elseif ($action == "member2") {
	member2();
}
elseif ($action == "member2_reg") {
	member2_reg();
}
#채용정보 유료설정
elseif ($action == "option") {
	option();
}
elseif ($action == "option_reg") {
	option_reg();
}
#기업회원 유료설정
elseif ( $action == "option2" ) {
	option2();
}
elseif ( $action == "option2_reg" ) {
	option2_reg();
}
elseif ($action == "common") {
	#공통설정 분리해냄 2009-12-07 kad
	common();
}
elseif ($action == "common_reg") {
	#공통설정 분리해냄 2009-12-07 kad
	common_reg();
}

else {
	option();
}



include ("tpl_inc/bottom.php");

###############################################################################

function member() {
	global $CONF,$message;
	global $PER_ARRAY,$PER_ARRAY_NAME,$now_location_subtitle;

	$necessary_check = array("필수결제","필수결제아님");
	$select_width = "283";

	#5개 추가옵션
	$use_array = array( "사용함" ,"사용안함" );
	$GuzicUryoDate1_use_out = make_radiobox2($use_array,$use_array,3,GuzicUryoDate1_use,area_chk1,$CONF['GuzicUryoDate1_use'],$select_width);
	$GuzicUryoDate2_use_out = make_radiobox2($use_array,$use_array,3,GuzicUryoDate2_use,area_chk2,$CONF['GuzicUryoDate2_use'],$select_width);
	$GuzicUryoDate3_use_out = make_radiobox2($use_array,$use_array,3,GuzicUryoDate3_use,area_chk3,$CONF['GuzicUryoDate3_use'],$select_width);
	$GuzicUryoDate4_use_out = make_radiobox2($use_array,$use_array,3,GuzicUryoDate4_use,area_chk4,$CONF['GuzicUryoDate4_use'],$select_width);
	$GuzicUryoDate5_use_out = make_radiobox2($use_array,$use_array,3,GuzicUryoDate5_use,area_chk5,$CONF['GuzicUryoDate5_use'],$select_width);
	#5개 추가옵션
	//print_R2($CONF);

	$option_form = "";
	if ( is_array($PER_ARRAY) )
	{
		$select_width = "300";
		foreach( $PER_ARRAY as $k => $v )
		{
			$uryo_title = '';
			$uryo_use = '';
			$uryo_necessary = '';

			if ( $k >= 14 && $k <= 16 )
			{
				continue;
			}

			#채용정보와 이력서는 이름이 틀림
			switch($v)
			{
				case "specialDate":
					$option_name = 'guin_special';
					$option_value = $CONF['guin_special'];
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,guin_special_necessary,area_chk6,$CONF['guin_special_necessary'],$select_width);
					break;
				case "focusDate":
					$option_name = 'guin_focus';
					$option_value = $CONF['guin_focus'];
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,guin_focus_necessary,area_chk7,$CONF['guin_focus_necessary'],$select_width);
					break;
				case "powerlinkDate":
					$option_name = 'guin_powerlink';
					$option_value = $CONF['guin_powerlink'];
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,guin_powerlink_necessary,area_chk8,$CONF['guin_powerlink_necessary'],$select_width);
					break;
				case "skin_date":
					$option_name = 'guin_docskin';
					$option_value = $CONF['guin_docskin'];
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,guin_docskin_necessary,area_chk9,$CONF['guin_docskin_necessary'],$select_width);
					break;
				case "iconDate":
					$option_name = 'guin_icon';
					$option_value = $CONF['guin_icon'];
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,guin_icon_necessary,area_chk10,$CONF['guin_icon_necessary'],$select_width);
					break;
				case "bolderDate":
					$option_name = 'guin_bolder';
					$option_value = $CONF['guin_bolder'];
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,guin_bolder_necessary,area_chk11,$CONF['guin_bolder_necessary'],$select_width);
					break;
				case "colorDate":
					$option_name = 'guin_color';
					$option_value = $CONF['guin_color'];
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,guin_color_necessary,area_chk12,$CONF['guin_color_necessary'],$select_width);
					break;
				case "freeiconDate":
					$option_name = 'guin_freeicon';
					$option_value = $CONF['guin_freeicon'];
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,guin_freeicon_necessary,area_chk13,$CONF['guin_freeicon_necessary'],$select_width);
					break;
				case "bgcolorDate":
					$option_name = 'guin_bgcolor';
					$option_value = $CONF['guin_bgcolor'];
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,guin_bgcolor_necessary,area_chk14,$CONF['guin_bgcolor_necessary'],$select_width);
					break;
				case "GuzicUryoDate1":
					$option_name = 'GuzicUryoDate1';
					$option_value = $CONF['GuzicUryoDate1'];
					$uryo_title = '옵션이름 : <input type="text" name="GuzicUryoDate1_title" value="'.$CONF['GuzicUryoDate1_title'].'"><br><br>';
					$uryo_use = $GuzicUryoDate1_use_out;
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,GuzicUryoDate1_necessary,area_chk15,$CONF['GuzicUryoDate1_necessary'],$select_width);
					break;
				case "GuzicUryoDate2":
					$option_name = 'GuzicUryoDate2';
					$option_value = $CONF['GuzicUryoDate2'];
					$uryo_title = '옵션이름 : <input type="text" name="GuzicUryoDate2_title" value="'.$CONF['GuzicUryoDate2_title'].'"><br><br>';
					$uryo_use = $GuzicUryoDate2_use_out;
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,GuzicUryoDate2_necessary,area_chk16,$CONF['GuzicUryoDate2_necessary'],$select_width);
					break;
				case "GuzicUryoDate3":
					$option_name = 'GuzicUryoDate3';
					$option_value = $CONF['GuzicUryoDate3'];
					$uryo_title = '옵션이름 : <input type="text" name="GuzicUryoDate3_title" value="'.$CONF['GuzicUryoDate3_title'].'"><br><br>';
					$uryo_use = $GuzicUryoDate3_use_out;
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,GuzicUryoDate3_necessary,area_chk17,$CONF['GuzicUryoDate3_necessary'],$select_width);
					break;
				case "GuzicUryoDate4":
					$option_name = 'GuzicUryoDate4';
					$option_value = $CONF['GuzicUryoDate4'];
					$uryo_title = '옵션이름 : <input type="text" name="GuzicUryoDate4_title" value="'.$CONF['GuzicUryoDate4_title'].'"><br><br>';
					$uryo_use = $GuzicUryoDate4_use_out;
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,GuzicUryoDate4_necessary,area_chk18,$CONF['GuzicUryoDate4_necessary'],$select_width);
					break;
				case "GuzicUryoDate5":
					$option_name = 'GuzicUryoDate5';
					$option_value = $CONF['GuzicUryoDate5'];
					$uryo_title = '옵션이름 : <input type="text" name="GuzicUryoDate5_title" value="'.$CONF['GuzicUryoDate5_title'].'"><br><br>';
					$uryo_use = $GuzicUryoDate5_use_out;
					$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,GuzicUryoDate5_necessary,area_chk19,$CONF['GuzicUryoDate5_necessary'],$select_width);
					break;
			}
			#채용정보와 이력서는 이름이 틀림


			$option_form .= '
			<tr>
				<th>'.$PER_ARRAY_NAME[$k].' 유료화</th>
				<td>
					<p class="short">구분은 엔터(줄내림)으로 하고, 무료화 하고 싶은 경우 옵션을 모두 삭제하시면 됩니다.</p>
					<table border="0" cellpadding="0" cellspacing="1" class="bg_style">
						<tr>
							<th style="width:150px;">
								<strong>필수결제여부</strong>
							</th>
							<td>'.$uryo_title.$uryo_use.$uryo_necessary.'</td>
						</tr>
						<tr>
							<th style="width:150px;">
								<strong>금액설정</strong>
							</th>
							<td>
								<p class="short">횟수또는기간 : 금액형태입니다</p>
								<textarea name="'.$option_name.'" cols="30" rows="4" style="width:400px; height:100px;">'.$option_value.'</textarea>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			';
		}
	}

	//echo $option_form;


print <<<END

<p class='main_title'>$now_location_subtitle</p>

$message

<form method='POST' action='$PHP_SELF' style='margin:0;'>
<input type='hidden' name='action' value='member_reg'>

<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<table cellspacing='1' cellpadding='0' border='0' class='bg_style box_height'>
	$option_form
	</table>
</div>

<div align='center'><input type='submit' value='저장하기' class='btn_big'></div>

</form>


END;

}



function member2() {
	global $CONF,$message;
	global $PER_ARRAY,$PER_ARRAY_NAME,$now_location_subtitle;

	$necessary_check = array("필수결제","필수결제아님");
	$select_width = "283";
	#5개 추가옵션
	//print_R2($CONF);

	$option_form = "";
	if ( is_array($PER_ARRAY) )
	{
		$select_width = "300";
		$i = 0;
		foreach( $PER_ARRAY as $k => $v )
		{
			$uryo_title = '';
			$uryo_use = '';
			$uryo_necessary = '';
			$guzic_view_option_out = '';


			if ( $k < 14 || $k > 16 )
			{
				continue;
			}

			#채용정보와 이력서는 이름이 틀림
			switch($v)
			{
				case "guzic_view":
					$option_name = 'guzic_view';
					$option_value = $CONF['guzic_view'];
					//$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,guin_special_necessary,area_chk,$CONF['guzic_view_necessary'],$select_width);
					$guzic_view_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guzic_view_option,area_chk,$CONF['guzic_view_option'],$select_width);
					//$guin_docview_necessary_out = make_radiobox($necessary_check,3,guin_docview_necessary,area_chk,$CONF['guin_docview_necessary']);
					break;
				case "guzic_view2":
					$option_name = 'guzic_view2';
					$option_value = $CONF['guzic_view2'];
					//$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,guin_special_necessary,area_chk,$CONF['guzic_view_necessary'],$select_width);
					$guzic_view_option_out = make_radiobox2(array("회수별"),array("회수별"),3,guzic_view2_option,area_chk,$CONF['guzic_view2_option'],$select_width);
					//$guin_docview_necessary_out = make_radiobox($necessary_check,3,guin_docview_necessary,area_chk,$CONF['guin_docview_necessary']);
					break;
				case "guzic_smspoint":
					$option_name = 'guzic_smspoint';
					$option_value = $CONF['guzic_smspoint'];
					//$uryo_necessary = make_radiobox2($necessary_check,$necessary_check,3,guin_special_necessary,area_chk,$CONF['guzic_view_necessary'],$select_width);
					$guzic_view_option_out = make_radiobox2(array("회수별"),array("회수별"),3,guzic_smspoint_option,area_chk,$CONF['guzic_smspoint_option'],$select_width);
					//$guin_docview_necessary_out = make_radiobox($necessary_check,3,guin_docview_necessary,area_chk,$CONF['guin_docview_necessary']);
					break;
			}



			$option_form .= '
			<tr>
				<th>'.$PER_ARRAY_NAME[$k].' 유료화</th>
				<td>
					<p class="short">구분은 엔터(줄내림)으로 하고, 무료화 하고 싶은 경우 옵션을 모두 삭제하시면 됩니다.</p>
					'.$uryo_title.$uryo_use.$uryo_necessary.$guzic_view_option_out.'<br>
					<textarea name="'.$option_name.'" cols="30" rows="4" style="width:400px; height:100px;">'.$option_value.'</textarea>
				</td>
			</tr>
			';
		}
	}

	//echo $option_form;


print <<<END
<p class='main_title'>$now_location_subtitle</p>

$message

<form method='POST' action='$PHP_SELF' style='margin:0;'>
<input type='hidden' name='action' value='member2_reg'>

<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<table cellspacing='1' cellpadding='0' border='0' class='bg_style box_height'>
	$option_form
	</table>
</div>

<div align='center'><input type='submit' value='저장하기' class='btn_big'></div>

</form>


END;

}




	function query_make($title, $value,$subject="",$pay_use="",$necessary="")
	{
		global $conf_table;
		$Sql	= "select count(*) from $conf_table WHERE title='$title' ";
		$Temp	= happy_mysql_fetch_array(query($Sql));

		if ( $Temp[0] == 0 )
		{
			$Sql	 = "	INSERT INTO									";
			$Sql	.= "			$conf_table							";
			$Sql	.= "	SET											";
			$Sql	.= "			title='$title',						";
			$Sql	.= "			value='$value'						";
			if ( $subject != "" )
			{
				$Sql.= " , subject = '".$subject."' ";
			}
			if ( $pay_use != "" )
			{
				$Sql.= " , pay_use = '".$pay_use."' ";
			}
			if ( $necessary != "" )
			{
				$Sql.= " , pay_necessary = '".$necessary."' ";
			}
		}
		else
		{
			$Sql	 = "	UPDATE										";
			$Sql	.= "			$conf_table							";
			$Sql	.= "	SET											";
			$Sql	.= "			title='$title',						";
			$Sql	.= "			value='$value'						";

			if ( $subject != "" )
			{
				$Sql.= " , subject = '".$subject."' ";
			}
			if ( $pay_use != "" )
			{
				$Sql.= " , pay_use = '".$pay_use."' ";
			}
			if ( $necessary != "" )
			{
				$Sql.= " , pay_necessary = '".$necessary."' ";
			}

			$Sql	.= "	WHERE										";
			$Sql	.= "			title='$title'						";
		}
		//echo $Sql."<br>";
		return $Sql;
	}


function member_reg() {
	global $conf_table,$CONF,$message;

	$guin_reg		= $_POST["guin_reg"];
	$guzic_view		= $_POST["guzic_view"];

	$guin_special	= $_POST["guin_special"];
	$guin_special_necessary = $_POST["guin_special_necessary"];

	$guin_focus		= $_POST["guin_focus"];
	$guin_focus_necessary = $_POST["guin_focus_necessary"];

	$guin_powerlink	= $_POST["guin_powerlink"];
	$guin_powerlink_necessary	= $_POST["guin_powerlink_necessary"];

	$guin_docskin	= $_POST["guin_docskin"];
	$guin_docskin_necessary	= $_POST["guin_docskin_necessary"];

	$guin_icon		= $_POST["guin_icon"];
	$guin_icon_necessary		= $_POST["guin_icon_necessary"];

	$guin_bolder	= $_POST["guin_bolder"];
	$guin_bolder_necessary	= $_POST["guin_bolder_necessary"];

	$guin_color		= $_POST["guin_color"];
	$guin_color_necessary		= $_POST["guin_color_necessary"];

	$guin_freeicon	= $_POST["guin_freeicon"];
	$guin_freeicon_necessary	= $_POST["guin_freeicon_necessary"];

	$guin_bgcolor	= $_POST["guin_bgcolor"];
	$guin_bgcolor_necessary	= $_POST["guin_bgcolor_necessary"];

	#추가옵션 5개
	$GuzicUryoDate1 = $_POST['GuzicUryoDate1'];
	$GuzicUryoDate1_title = $_POST['GuzicUryoDate1_title'];
	$GuzicUryoDate1_use = $_POST['GuzicUryoDate1_use'];
	$GuzicUryoDate1_necessary = $_POST['GuzicUryoDate1_necessary'];

	$GuzicUryoDate2 = $_POST['GuzicUryoDate2'];
	$GuzicUryoDate2_title = $_POST['GuzicUryoDate2_title'];
	$GuzicUryoDate2_use = $_POST['GuzicUryoDate2_use'];
	$GuzicUryoDate2_necessary = $_POST['GuzicUryoDate2_necessary'];

	$GuzicUryoDate3 = $_POST['GuzicUryoDate3'];
	$GuzicUryoDate3_title = $_POST['GuzicUryoDate3_title'];
	$GuzicUryoDate3_use = $_POST['GuzicUryoDate3_use'];
	$GuzicUryoDate3_necessary = $_POST['GuzicUryoDate3_necessary'];

	$GuzicUryoDate4 = $_POST['GuzicUryoDate4'];
	$GuzicUryoDate4_title = $_POST['GuzicUryoDate4_title'];
	$GuzicUryoDate4_use = $_POST['GuzicUryoDate4_use'];
	$GuzicUryoDate4_necessary = $_POST['GuzicUryoDate4_necessary'];

	$GuzicUryoDate5 = $_POST['GuzicUryoDate5'];
	$GuzicUryoDate5_title = $_POST['GuzicUryoDate5_title'];
	$GuzicUryoDate5_use = $_POST['GuzicUryoDate5_use'];
	$GuzicUryoDate5_necessary = $_POST['GuzicUryoDate5_necessary'];
	#추가옵션 5개


	//query( query_make("guin_reg",$guin_reg) );
	//query( query_make("guzic_view",$guzic_view) );

	query( query_make("guin_special",$guin_special,"","",$guin_special_necessary) );
	query( query_make("guin_focus",$guin_focus,"","",$guin_focus_necessary) );
	query( query_make("guin_powerlink",$guin_powerlink,"","",$guin_powerlink_necessary) );
	query( query_make("guin_docskin",$guin_docskin,"","",$guin_docskin_necessary) );
	query( query_make("guin_icon",$guin_icon,"","",$guin_icon_necessary) );
	query( query_make("guin_bolder",$guin_bolder,"","",$guin_bolder_necessary) );
	query( query_make("guin_color",$guin_color,"","",$guin_color_necessary) );
	query( query_make("guin_freeicon",$guin_freeicon,"","",$guin_freeicon_necessary) );
	query( query_make("guin_bgcolor",$guin_bgcolor,"","",$guin_bgcolor_necessary) );

	#5개추가 title,옵션,옵션제목,옵션사용여부
	query( query_make("GuzicUryoDate1",$GuzicUryoDate1,$GuzicUryoDate1_title,$GuzicUryoDate1_use,$GuzicUryoDate1_necessary) );
	query( query_make("GuzicUryoDate2",$GuzicUryoDate2,$GuzicUryoDate2_title,$GuzicUryoDate2_use,$GuzicUryoDate2_necessary) );
	query( query_make("GuzicUryoDate3",$GuzicUryoDate3,$GuzicUryoDate3_title,$GuzicUryoDate3_use,$GuzicUryoDate3_necessary) );
	query( query_make("GuzicUryoDate4",$GuzicUryoDate4,$GuzicUryoDate4_title,$GuzicUryoDate4_use,$GuzicUryoDate4_necessary) );
	query( query_make("GuzicUryoDate5",$GuzicUryoDate5,$GuzicUryoDate5_title,$GuzicUryoDate5_use,$GuzicUryoDate5_necessary) );

	go('money_setup.php?action=member');
	exit;
}


#채용정보보기등의 옵션
function member2_reg() {
	global $conf_table,$CONF,$message;

	$guzic_view		= $_POST["guzic_view"];
	$guzic_view2		= $_POST["guzic_view2"];
	$guzic_smspoint		= $_POST["guzic_smspoint"];

	query( query_make("guzic_view",$guzic_view,"","") );
	query( query_make("guzic_view2",$guzic_view2,"","") );
	query( query_make("guzic_smspoint",$guzic_smspoint,"","") );

	go('money_setup.php?action=member2');
	exit;
}



#기업회원 유료화
function option() {
	global $CONF,$message;
	global $ARRAY,$ARRAY_NAME,$now_location_subtitle;


	#유료화 방법에는 기간별/노출별/클릭별로 구분된다.
	$option_check = array("기간별","노출별","클릭별");
	$necessary_check = array("필수결제","필수결제아님");
	$select_width = "300";
	$select_width2 = "330";
	$select_width3 = "318";

	$guin_banner1_option_out = make_radiobox2($option_check,$option_check,3,guin_banner1_option,area_chk1,$CONF['guin_banner1_option'],$select_width);
	$guin_banner1_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_banner1_necessary,area_chk2,$CONF['guin_banner1_necessary'],$select_width2);

	$guin_banner2_option_out = make_radiobox2($option_check,$option_check,3,guin_banner2_option,area_chk3,$CONF['guin_banner2_option'],$select_width);
	$guin_banner2_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_banner2_necessary,area_chk4,$CONF['guin_banner2_necessary'],$select_width2);

	$guin_banner3_option_out = make_radiobox2($option_check,$option_check,3,guin_banner3_option,area_chk5,$CONF['guin_banner3_option'],$select_width);
	$guin_banner3_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_banner3_necessary,area_chk6,$CONF['guin_banner3_necessary'],$select_width2);

	$guin_bold_option_out = make_radiobox2($option_check,$option_check,3,guin_bold_option,area_chk7,$CONF['guin_bold_option'],$select_width);
	$guin_bold_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_bold_necessary,area_chk8,$CONF['guin_bold_necessary'],$select_width2);

	$guin_list_hyung_option_out = make_radiobox2($option_check,$option_check,3,guin_list_hyung_option,area_chk9,$CONF['guin_list_hyung_option'],$select_width);
	$guin_list_hyung_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_list_hyung_necessary,area_chk10,$CONF['guin_list_hyung_necessary'],$select_width2);

	$guin_pick_option_out = make_radiobox2($option_check,$option_check,3,guin_pick_option,area_chk11,$CONF['guin_pick_option'],$select_width);
	$guin_pick_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_pick_necessary,area_chk12,$CONF['guin_pick_necessary'],$select_width2);

	$guin_ticker_option_out = make_radiobox2($option_check,$option_check,3,guin_ticker_option,area_chk13,$CONF['guin_ticker_option'],$select_width);
	$guin_ticker_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_ticker_necessary,area_chk14,$CONF['guin_ticker_necessary'],$select_width2);

	$guin_docview_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_docview_option,area_chk15,$CONF['guin_docview_option'],$select_width);
	//$guin_docview_necessary_out = make_radiobox($necessary_check,3,guin_docview_necessary,area_chk,$CONF['guin_docview_necessary']);

	$guin_docview2_option_out = make_radiobox2(array("이력서수"),array("이력서수"),3,guin_docview2_option,area_chk16,$CONF['guin_docview2_option'],$select_width);
	//$guin_docview2_necessary_out = make_radiobox($necessary_check,3,guin_docview2_necessary,area_chk,$CONF['guin_docview2_necessary']);

	$guin_smspoint_option_out = make_radiobox2(array("횟수별"),array("횟수별"),3,guin_smspoint_option,area_chk17,$CONF['guin_smspoint_option'],$select_width);
	//$guin_smspoint_necessary_out = make_radiobox($necessary_check,3,guin_smspoint_necessary,area_chk,$CONF['guin_smspoint_necessary']);

	#배경색 옵션
	$guin_bgcolor_com_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_bgcolor_com_option,area_chk18,$CONF['guin_bgcolor_com_option'],$select_width);
	$guin_bgcolor_com_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_bgcolor_com_necessary,area_chk19,$CONF['guin_bgcolor_com_necessary'],$select_width2);

	#아이콘 옵션
	$freeicon_comDate_option_out = make_radiobox2(array("기간별"),array("기간별"),3,freeicon_comDate_option,area_chk20,$CONF[freeicon_comDate_option],$select_width);
	$freeicon_comDate_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,freeicon_comDate_necessary,area_chk21,$CONF['freeicon_comDate_necessary'],$select_width2);

	#추가옵션5개
	$use_array = array( "사용함" ,"사용안함" );
	$guin_uryo1_title_out = '<input type="text" name="guin_uryo1_title" value="'.$CONF['guin_uryo1_title'].'">';
	$guin_uryo1_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_uryo1_option,area_chk22,$CONF['guin_uryo1_option']);
	$guin_uryo1_use_out = make_radiobox2($use_array,$use_array,3,guin_uryo1_use,area_chk23,$CONF['guin_uryo1_use'],$select_width3);
	$guin_uryo1_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_uryo1_necessary,area_chk24,$CONF['guin_uryo1_necessary'],$select_width2);

	$guin_uryo2_title_out = '<input type="text" name="guin_uryo2_title" value="'.$CONF['guin_uryo2_title'].'">';
	$guin_uryo2_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_uryo2_option,area_chk25,$CONF['guin_uryo2_option']);
	$guin_uryo2_use_out = make_radiobox2($use_array,$use_array,3,guin_uryo2_use,area_chk26,$CONF['guin_uryo2_use'],$select_width3);
	$guin_uryo2_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_uryo2_necessary,area_chk27,$CONF['guin_uryo2_necessary'],$select_width2);

	$guin_uryo3_title_out = '<input type="text" name="guin_uryo3_title" value="'.$CONF['guin_uryo3_title'].'">';
	$guin_uryo3_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_uryo3_option,area_chk28,$CONF['guin_uryo3_option']);
	$guin_uryo3_use_out = make_radiobox2($use_array,$use_array,3,guin_uryo3_use,area_chk29,$CONF['guin_uryo3_use'],$select_width3);
	$guin_uryo3_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_uryo3_necessary,area_chk30,$CONF['guin_uryo3_necessary'],$select_width2);

	$guin_uryo4_title_out = '<input type="text" name="guin_uryo4_title" value="'.$CONF['guin_uryo4_title'].'">';
	$guin_uryo4_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_uryo4_option,area_chk31,$CONF['guin_uryo4_option']);
	$guin_uryo4_use_out = make_radiobox2($use_array,$use_array,3,guin_uryo4_use,area_chk32,$CONF['guin_uryo4_use'],$select_width3);
	$guin_uryo4_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_uryo4_necessary,area_chk33,$CONF['guin_uryo4_necessary'],$select_width2);

	$guin_uryo5_title_out = '<input type="text" name="guin_uryo5_title" value="'.$CONF['guin_uryo5_title'].'">';
	$guin_uryo5_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_uryo5_option,area_chk34,$CONF['guin_uryo5_option']);
	$guin_uryo5_use_out = make_radiobox2($use_array,$use_array,3,guin_uryo5_use,area_chk35,$CONF['guin_uryo5_use'],$select_width3);
	$guin_uryo5_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_uryo5_necessary,area_chk36,$CONF['guin_uryo5_necessary'],$select_width2);
	//print_r2($CONF);

	for ($i=0; $i<=16;$i++)
	{

		if ( $i >= 7 && $i <= 9 )
		{
			continue;
		}

		$tmp_name = $ARRAY[$i];
		$tmp_option = $ARRAY[$i] . "_option";
		$tmp_max_number = $ARRAY[$i] . "_max";
		$tmp_max_number_print = $CONF[$tmp_max_number];
		$tmp_option_print = $CONF[$tmp_option];
		$tmp_option_out = $ARRAY[$i] . "_option_out";
		$tmp_use_out = $ARRAY[$i]."_use_out";
		$tmp_necessary_out = $ARRAY[$i]."_necessary_out";

		#제목
		$out_title = "";
		$out_pay_use = "";
		$tmp_title = $ARRAY[$i]."_title";
		$tmp_title_option_out = $tmp_title."_out";

		if ( isset($$tmp_title_option_out) )
		{
			//echo $$tmp_title_option_out."<br>";
			$out_title = "옵션명 : ".$$tmp_title_option_out;
			$out_pay_use = $$tmp_use_out;
		}
		$tmp_option_out_print = $$tmp_option_out;
		$tmp_necessary_out_print = $$tmp_necessary_out;


		$option_info .= <<<END
		<tr>
			<th>$ARRAY_NAME[$i]광고 설정</th>
			<td>
				<p class='short'>구분은 [엔터](줄내림)로 사용할 수 있습니다.</p>
				<table border="0" cellpadding="0" cellspacing="1" class="bg_style">
					<tbody>
						<tr>
							<th style="width:150px;">
								결제필수여부
							</th>
							<td>$out_pay_use $tmp_necessary_out_print</td>
						</tr>
						<tr>
							<th style="width:150px;">
								노출형식
							</th>
							<td>$tmp_option_out_print $out_title</td>
						</tr>
						<tr>
							<th style="width:150px;">
								금액설정
							</th>
							<td>
								<p class='short'>횟수또는기간 : 금액형태입니다</p>
								<textarea name='$tmp_name' rows='5' style='width:400px;height:100px;'>$CONF[$tmp_name]</textarea>
							</td>
						</tr>
						<tr>
							<th style="width:150px;">
								최대광고수
							</th>
							<td>
								<input type=text size=10 name=$tmp_max_number value=$tmp_max_number_print> 개
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
END;
	}

	print <<<END

<p class="main_title">$now_location_subtitle</p>

<form method='POST' action='$PHP_SELF' style='margin:0;'>
<input type='hidden' name='action' value='option_reg'>
$message

<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<table cellspacing='1' cellpadding='0' border='0' class='bg_style box_height'>
	$option_info
	</table>
</div>

<div align='center'><input type='submit' value='저장하기' class='btn_big'></div>

</form>


END;

}

#기업회원 유료화
function option2() {
	global $CONF,$message;
	global $ARRAY,$ARRAY_NAME,$now_location_subtitle;


	#유료화 방법에는 기간별/노출별/클릭별로 구분된다.
	$option_check = array("기간별","노출별","클릭별");
	$necessary_check = array("필수결제","필수결제아님");
	$select_width = "200";
	$select_width2 = "230";
	$select_width3 = "218";

	$guin_banner1_option_out = make_radiobox2($option_check,$option_check,3,guin_banner1_option,area_chk1,$CONF['guin_banner1_option'],$select_width);
	$guin_banner1_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_banner1_necessary,area_chk2,$CONF['guin_banner1_necessary'],$select_width2);

	$guin_banner2_option_out = make_radiobox2($option_check,$option_check,3,guin_banner2_option,area_chk3,$CONF['guin_banner2_option'],$select_width);
	$guin_banner2_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_banner2_necessary,area_chk4,$CONF['guin_banner2_necessary'],$select_width2);

	$guin_banner3_option_out = make_radiobox2($option_check,$option_check,3,guin_banner3_option,area_chk5,$CONF['guin_banner3_option'],$select_width);
	$guin_banner3_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_banner3_necessary,area_chk6,$CONF['guin_banner3_necessary'],$select_width2);

	$guin_bold_option_out = make_radiobox2($option_check,$option_check,3,guin_bold_option,area_chk7,$CONF['guin_bold_option'],$select_width);
	$guin_bold_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_bold_necessary,area_chk8,$CONF['guin_bold_necessary'],$select_width2);

	$guin_list_hyung_option_out = make_radiobox2($option_check,$option_check,3,guin_list_hyung_option,area_chk9,$CONF['guin_list_hyung_option'],$select_width);
	$guin_list_hyung_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_list_hyung_necessary,area_chk10,$CONF['guin_list_hyung_necessary'],$select_width2);

	$guin_pick_option_out = make_radiobox2($option_check,$option_check,3,guin_pick_option,area_chk11,$CONF['guin_pick_option'],$select_width);
	$guin_pick_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_pick_necessary,area_chk12,$CONF['guin_pick_necessary'],$select_width2);

	$guin_ticker_option_out = make_radiobox2($option_check,$option_check,3,guin_ticker_option,area_chk13,$CONF['guin_ticker_option'],$select_width);
	$guin_ticker_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_ticker_necessary,area_chk14,$CONF['guin_ticker_necessary'],$select_width2);

	$guin_docview_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_docview_option,area_chk15,$CONF['guin_docview_option'],$select_width);
	//$guin_docview_necessary_out = make_radiobox($necessary_check,3,guin_docview_necessary,area_chk,$CONF['guin_docview_necessary']);

	$guin_docview2_option_out = make_radiobox2(array("이력서수"),array("이력서수"),3,guin_docview2_option,area_chk16,$CONF['guin_docview2_option'],$select_width);
	//$guin_docview2_necessary_out = make_radiobox($necessary_check,3,guin_docview2_necessary,area_chk,$CONF['guin_docview2_necessary']);

	$guin_smspoint_option_out = make_radiobox2(array("횟수별"),array("횟수별"),3,guin_smspoint_option,area_chk17,$CONF['guin_smspoint_option'],$select_width);
	//$guin_smspoint_necessary_out = make_radiobox($necessary_check,3,guin_smspoint_necessary,area_chk,$CONF['guin_smspoint_necessary']);

	#배경색 옵션
	$guin_bgcolor_com_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_bgcolor_com_option,area_chk18,$CONF['guin_bgcolor_com_option'],$select_width);
	$guin_bgcolor_com_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_bgcolor_com_necessary,area_chk19,$CONF['guin_bgcolor_com_necessary'],$select_width2);

	#아이콘 옵션
	$freeicon_comDate_option_out = make_radiobox2(array("기간별"),array("기간별"),3,freeicon_comDate_option,area_chk20,$CONF[freeicon_comDate_option],$select_width);
	$freeicon_comDate_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,freeicon_comDate_necessary,area_chk21,$CONF['freeicon_comDate_necessary'],$select_width2);

	#추가옵션5개
	$use_array = array( "사용함" ,"사용안함" );
	$guin_uryo1_title_out = '<input type="text" name="guin_uryo1_title" value="'.$CONF['guin_uryo1_title'].'">';
	$guin_uryo1_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_uryo1_option,area_chk22,$CONF['guin_uryo1_option']);
	$guin_uryo1_use_out = make_radiobox2($use_array,$use_array,3,guin_uryo1_use,area_chk23,$CONF['guin_uryo1_use'],$select_width3);
	$guin_uryo1_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_uryo1_necessary,area_chk24,$CONF['guin_uryo1_necessary'],$select_width2);

	$guin_uryo2_title_out = '<input type="text" name="guin_uryo2_title" value="'.$CONF['guin_uryo2_title'].'">';
	$guin_uryo2_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_uryo2_option,area_chk25,$CONF['guin_uryo2_option']);
	$guin_uryo2_use_out = make_radiobox2($use_array,$use_array,3,guin_uryo2_use,area_chk26,$CONF['guin_uryo2_use'],$select_width3);
	$guin_uryo2_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_uryo2_necessary,area_chk27,$CONF['guin_uryo2_necessary'],$select_width2);

	$guin_uryo3_title_out = '<input type="text" name="guin_uryo3_title" value="'.$CONF['guin_uryo3_title'].'">';
	$guin_uryo3_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_uryo3_option,area_chk28,$CONF['guin_uryo3_option']);
	$guin_uryo3_use_out = make_radiobox2($use_array,$use_array,3,guin_uryo3_use,area_chk29,$CONF['guin_uryo3_use'],$select_width3);
	$guin_uryo3_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_uryo3_necessary,area_chk30,$CONF['guin_uryo3_necessary'],$select_width2);

	$guin_uryo4_title_out = '<input type="text" name="guin_uryo4_title" value="'.$CONF['guin_uryo4_title'].'">';
	$guin_uryo4_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_uryo4_option,area_chk31,$CONF['guin_uryo4_option']);
	$guin_uryo4_use_out = make_radiobox2($use_array,$use_array,3,guin_uryo4_use,area_chk32,$CONF['guin_uryo4_use'],$select_width3);
	$guin_uryo4_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_uryo4_necessary,area_chk33,$CONF['guin_uryo4_necessary'],$select_width2);

	$guin_uryo5_title_out = '<input type="text" name="guin_uryo5_title" value="'.$CONF['guin_uryo5_title'].'">';
	$guin_uryo5_option_out = make_radiobox2(array("기간별"),array("기간별"),3,guin_uryo5_option,area_chk34,$CONF['guin_uryo5_option']);
	$guin_uryo5_use_out = make_radiobox2($use_array,$use_array,3,guin_uryo5_use,area_chk35,$CONF['guin_uryo5_use'],$select_width3);
	$guin_uryo5_necessary_out = make_radiobox2($necessary_check,$necessary_check,3,guin_uryo5_necessary,area_chk36,$CONF['guin_uryo5_necessary'],$select_width2);
	//print_r2($CONF);

	for ($i=7; $i<=9;$i++)
	{

		$tmp_name = $ARRAY[$i];
		$tmp_option = $ARRAY[$i] . "_option";
		$tmp_max_number = $ARRAY[$i] . "_max";
		$tmp_max_number_print = $CONF[$tmp_max_number];
		$tmp_option_print = $CONF[$tmp_option];
		$tmp_option_out = $ARRAY[$i] . "_option_out";
		$tmp_use_out = $ARRAY[$i]."_use_out";
		$tmp_necessary_out = $ARRAY[$i]."_necessary_out";

		#제목
		$out_title = "";
		$out_pay_use = "";
		$tmp_title = $ARRAY[$i]."_title";
		$tmp_title_option_out = $tmp_title."_out";

		if ( isset($$tmp_title_option_out) )
		{
			//echo $$tmp_title_option_out."<br>";
			$out_title = "옵션명 : ".$$tmp_title_option_out;
			$out_pay_use = $$tmp_use_out;
		}
		$tmp_option_out_print = $$tmp_option_out;
		$tmp_necessary_out_print = $$tmp_necessary_out;


		$option_info .= <<<END
		<tr>
			<th>$ARRAY_NAME[$i]광고 설정</th>
			<td>
				<p class='short'>구분은 [엔터](줄내림)로 사용할 수 있습니다.</p>
				$out_pay_use
				$tmp_necessary_out_print
				$tmp_option_out_print $out_title
				<textarea name='$tmp_name' rows='5' style='width:400px; height:100px;'>$CONF[$tmp_name]</textarea><br>
				<input type=hidden size=10 name=$tmp_max_number value="99999999">
			</td>
		</tr>
END;
	}


	//채용정보 점프기능
	global $HAPPY_CONFIG;
	//echo $HAPPY_CONFIG['guin_jump_use'];
	$guin_jump_option_out = make_radiobox2(array("횟수별"),array("횟수별"),3,guin_jump_option,area_chk,$CONF['guin_jump_option'],$select_width);
	if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
	{
		$i = array_search("guin_jump",$ARRAY);

		$tmp_name = $ARRAY[$i];
		$tmp_option = $ARRAY[$i] . "_option";
		$tmp_max_number = $ARRAY[$i] . "_max";
		$tmp_max_number_print = $CONF[$tmp_max_number];
		$tmp_option_print = $CONF[$tmp_option];
		$tmp_option_out = $ARRAY[$i] . "_option_out";
		$tmp_use_out = $ARRAY[$i]."_use_out";
		$tmp_necessary_out = $ARRAY[$i]."_necessary_out";


		#제목
		$out_title = "";
		$out_pay_use = "";
		$tmp_title = $ARRAY[$i]."_title";
		$tmp_title_option_out = $tmp_title."_out";

		if ( isset($$tmp_title_option_out) )
		{
			//echo $$tmp_title_option_out."<br>";
			$out_title = "옵션명 : ".$$tmp_title_option_out;
			$out_pay_use = $$tmp_use_out;
		}
		$tmp_option_out_print = $$tmp_option_out;
		$tmp_necessary_out_print = $$tmp_necessary_out;


		$option_info .= <<<END
		<tr>
			<th>$ARRAY_NAME[$i]광고 설정</th>
			<td>
				<p class='short'>구분은 [엔터](줄내림)로 사용할 수 있습니다.</p>
				$out_pay_use <br>
				$tmp_necessary_out_print<br>
				$tmp_option_out_print $out_title<br>
				<textarea name='$tmp_name' rows='5' style='width:400px; height:100px;'>$CONF[$tmp_name]</textarea><br>
				<input type=hidden size=10 name=$tmp_max_number value="99999999">
			</td>
		</tr>
END;
	}
	//채용정보 점프기능



	print <<<END

<p class='main_title'>$now_location_subtitle</p>

<form method='POST' action='$PHP_SELF' style='margin:0;'>
<input type='hidden' name='action' value='option2_reg'>
$message

<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<table cellspacing='1' cellpadding='0' border='0' class='bg_style box_height'>
	$option_info
	</table>
</div>

<div align='center'><input type='submit' value='저장하기' class='btn_big'></div>

</form>


END;

}



function option_reg() {
	global $ARRAY,$ARRAY_NAME,$CONF,$message,$conf_table,$CONF,$message;

	//print_r2($_POST);



	for ($i = 0 ; $i <=16 ; $i++)
	{

		if ( $i >= 7 && $i <= 9 )
		{
			continue;
		}

		$tmp_name = $ARRAY[$i];
		$tmp_option = $ARRAY[$i] . "_option";
		$tmp_subject = $ARRAY[$i]."_title";			#제목추가
		$tmp_max_number = $ARRAY[$i] . "_max";
		$tmp_use = $ARRAY[$i]."_use";
		$tmp_necessary = $ARRAY[$i]."_necessary";

		$real_option = $_POST[$tmp_option];
		$real_max_number = $_POST[$tmp_max_number];
		$real_subject = $_POST[$tmp_subject];
		$real_value = $_POST{$ARRAY[$i]};
		$real_use = $_POST[$tmp_use];
		$real_necessary = $_POST[$tmp_necessary];

		$sql = "update ".$conf_table." set ";
		$sql.= "value = '".$real_value."' , ";
		$sql.= "`option` = '".$real_option."' ,";
		$sql.= "max_number = '".$real_max_number."' ,";
		$sql.= "subject = '".$real_subject."' , ";
		$sql.= "pay_use = '".$real_use."', ";
		$sql.= "pay_necessary = '".$real_necessary."' ";
		$sql.= "where title = '".$tmp_name."' ";

		//print $sql . "<br>";
		$result = query($sql);
	}



	//query("update job_conf set value = '$_POST[paid_conf]' where title = 'paid_conf' ");
	go('money_setup.php?action=option');
	exit;
}



function option2_reg() {
	global $ARRAY,$ARRAY_NAME,$CONF,$message,$conf_table,$CONF,$message;

	//print_r2($_POST);



	for ($i = 7 ; $i <=9 ; $i++)
	{

		$tmp_name = $ARRAY[$i];
		$tmp_option = $ARRAY[$i] . "_option";
		$tmp_subject = $ARRAY[$i]."_title";			#제목추가
		$tmp_max_number = $ARRAY[$i] . "_max";
		$tmp_use = $ARRAY[$i]."_use";
		$tmp_necessary = $ARRAY[$i]."_necessary";

		$real_option = $_POST[$tmp_option];
		$real_max_number = $_POST[$tmp_max_number];
		$real_subject = $_POST[$tmp_subject];
		$real_value = $_POST{$ARRAY[$i]};
		$real_use = $_POST[$tmp_use];
		$real_necessary = $_POST[$tmp_necessary];

		$sql = "update ".$conf_table." set ";
		$sql.= "value = '".$real_value."' , ";
		$sql.= "`option` = '".$real_option."' ,";
		$sql.= "max_number = '".$real_max_number."' ,";
		$sql.= "subject = '".$real_subject."' , ";
		$sql.= "pay_use = '".$real_use."', ";
		$sql.= "pay_necessary = '".$real_necessary."' ";
		$sql.= "where title = '".$tmp_name."' ";

		//print $sql . "<br>";
		$result = query($sql);
	}


	//채용정보 점프기능
	global $HAPPY_CONFIG;

	if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
	{
		//insert into job_conf set title = 'guin_jump';
		$i = array_search("guin_jump",$ARRAY);

		$tmp_name = $ARRAY[$i];
		$tmp_option = $ARRAY[$i] . "_option";
		$tmp_subject = $ARRAY[$i]."_title";			#제목추가
		$tmp_max_number = $ARRAY[$i] . "_max";
		$tmp_use = $ARRAY[$i]."_use";
		$tmp_necessary = $ARRAY[$i]."_necessary";

		$real_option = $_POST[$tmp_option];
		$real_max_number = $_POST[$tmp_max_number];
		$real_subject = $_POST[$tmp_subject];
		$real_value = $_POST{$ARRAY[$i]};
		$real_use = $_POST[$tmp_use];
		$real_necessary = $_POST[$tmp_necessary];


		$sql = "update ".$conf_table." set ";
		$sql.= "value = '".$real_value."' , ";
		$sql.= "`option` = '".$real_option."' ,";
		$sql.= "max_number = '".$real_max_number."' ,";
		$sql.= "subject = '".$real_subject."' , ";
		$sql.= "pay_use = '".$real_use."', ";
		$sql.= "pay_necessary = '".$real_necessary."' ";
		$sql.= "where title = '".$tmp_name."' ";

		query($sql);
		//echo $sql; exit;
	}
	//채용정보 점프기능

	//query("update job_conf set value = '$_POST[paid_conf]' where title = 'paid_conf' ");
	go('money_setup.php?action=option2');
	exit;
}


#공통설정 분리됨 / 포인트 등
function common()
{
	global $CONF,$message;
	global $ARRAY,$ARRAY_NAME,$CONF,$message;

	#전체유료화
	if ($CONF[paid_conf])
	{
		$paid_conf_1 = "checked";
	}
	else
	{
		$paid_conf_0 = "checked";
	}

	print <<<END

<p class='main_title'>공통 유료 설정</p>


<form method='POST' action='$PHP_SELF' style='margin:0;'>
<input type='hidden' name='action' value='common_reg'>
$message

<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<table cellspacing='1' cellpadding='0' border='0' class='bg_style box_height'>
	<tr>
		<th>유료화 여부</th>
		<td>
			<p class='short'>무료화를 할 경우 모든 결제관련기능을 사용할 수 없습니다.</p>
			<input type=radio name=paid_conf value='1' $paid_conf_1> 유료화 &nbsp;&nbsp; <input type=radio name=paid_conf value='0' $paid_conf_0> 무료화
		</td>
	</tr>
	<tr>
		<th>포인트 유료화</th>
		<td>
			<p class='short'>구분은 엔터(줄내림)으로 하고, 포인트:결제금액 으로 설정하세요.</p>
			<textarea name='money_point' cols='30' rows='6' style='width:400px; height:100px;'>$CONF[money_point]</textarea>
		</td>
	</tr>
	</table>
</div>

<div align='center'><input type='submit' value='저장하기' class='btn_big'></div>

</form>
END;
}

function common_reg()
{
	global $conf_table;

	query("update job_conf set value = '$_POST[paid_conf]' where title = 'paid_conf' ");
	query("update job_conf set value = '$_POST[money_point]' where title = 'money_point'");

	go('money_setup.php?action=common');
	exit;
}

?>