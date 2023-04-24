<?php
$t_start = array_sum(explode(' ', microtime()));
include ("../inc/Template.php");
$TPL = new Template;

include ("../inc/config.php");
include ("../inc/function.php");
include ("../inc/lib.php");


if ( !admin_secure("구인구직옵션설정") ) {
		error("접속권한이 없습니다.");
		exit;
}

################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################


if ($action == 'option'){
	option();
}
elseif($action == 'option_reg'){
	option_reg();
}

else if ( $action == 'option_multi' )
{
	option_multi();
}
else if ( $action == 'option_multi_reg' )
{
	option_multi_reg();
}

else {


}

function option_multi()
{
	global $real_gap;
	global $CONF;
	global $per_document_tb;
	global $PER_ARRAY_NAME;
	global $links_number;
	global $PER_ARRAY_NAME2;
	global $PER_ARRAY;
	global $id;
	global $pg;
	global $jangboo;
	global $_GET;
	global $skin_folder;
	global $PER_ARRAY_DB;

	$i_array	= array(2,1,0,4,5,6,3,7,8,9,10,11,12,13);
	/*
	$number = $_GET['number'];

	$i_array	= array(2,1,0,4,5,6,3,7,8,9,10,11,12,13);
	for( $x=0 ; $x<14 ; $x++ ){
		$i	= $i_array[$x];
		$query_name .= "$PER_ARRAY[$i],";
	}
	$query_name .= " freeicon ";
	$query_name	= ereg_replace(",$", "", $query_name);
	$Sql		= "select $query_name , skin_html from $per_document_tb where number='$number'";

	//echo $Sql;

	$Record		= query($Sql);
	$Data		= happy_mysql_fetch_assoc($Record);
	*/

	$freeicon_selectbox = "";
	$FREEICON_ARRAY = array();

	for ( $x=0, $r_content="" ; $x<14 ; $x++ )
	{


		$i	= $i_array[$x];
		list($Data[$PER_ARRAY[$i]])	= explode(" ",$Data[$PER_ARRAY[$i]]);

		#자유아이콘인경우
		$freeicon_selectbox = "";
		$freeicon_selectbox_preview = "";
		if ($i == "7") {

			for ( $f = 1; $f<=15; $f++) {
				$array_key = $f - 1;
				$FREEICON_ARRAY[$array_key] = "freeicon".$f.".gif";
			}

			$freeicon_selectbox = make_selectbox($FREEICON_ARRAY,"아이콘선택",'freeicon',$Data['freeicon']);
			$freeicon_selectbox_preview = "<br><img src='img/freeico_preview.jpg' border='0' style='border:2px solid #EEE;'>";

		}

		if ( $Data[$PER_ARRAY[$i]] == "" )
		{
			$Data[$PER_ARRAY[$i]] = date("Y-m-d");
		}

		$r_content	.= "
			<tr bgcolor='#ffffff'>
				<td class='cfg_tbl_box2_title3a' nowrap='nowrap'>
					<font class='item_txt'>
					<p class='part_title'>$PER_ARRAY_NAME[$i] 기간별</p>
					</font>
				</td>
				<td class='tbl_box2_padding_cfg3'>
					$freeicon_selectbox
					<input type='text' name='$PER_ARRAY[$i]' value='".$Data[$PER_ARRAY[$i]]."' size=10> 일까지
					<a href='javascript:void(0)' onclick='if(self.gfPop)gfPop.fPopCalendar(document.fForm.$PER_ARRAY[$i]);return false;' HIDEFOCUS>

					<img src='../img/btn_calender.gif'  align=absmiddle border=0></a>
					<br>

					$freeicon_selectbox_preview
				</td>
			</tr>
		";



	}


	$loading_files	= filelist("../$skin_folder","doc_skin","_sms|_basic");
	$inputTag		= "<select name='skin_html' >";
	$inputTag		.= "	<option value=''>스킨파일선택</option>";
	for ( $z=0, $maxz=sizeof($loading_files) ; $z<$maxz ; $z++ )
	{
		$nowValue	= $loading_files[$z];
		$selected	= ( $Data['skin_html'] == $nowValue )?" selected ":"";
		$inputTag	.= "<option value='$nowValue' $selected >$nowValue</option>";
	}
	$inputTag	.= "</select>";


	$r_content	.= "
		<tr bgcolor='#ffffff'>
			<td class='cfg_tbl_box2_title3a' nowrap='nowrap'>
				<font class='item_txt'>
				<p class='part_title'>이력서 스킨</p>
				</font>
			</td>
			<td class='tbl_box2_padding_cfg3'>
				$inputTag
				<div style='margin:5 0 5 0;'>
					<img src='img/doc_skin_preview.jpg' border=0 style='border:2px solid #EEE; margin-bottom:5;'><br>
					※ doc_skin 으로 시작하는 템플릿파일 리스트<br>※ 파일명에 _sms가 포함된 파일 제외
				</div>
			</td>
		</tr>
	";


	$wait_temp =<<<END
			<table class="tbl_box2" style="margin-bottom: 25px; background-color: #e7eaef" cellspacing="0" cellpadding="0" width="100%" border="0">
				$r_content
			</table>
END;






print <<<END

	<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="{{main_url}}/js/calendar_google/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
	<p class="main_title">유료옵션변경 [<a href='#' onclick='history.go(-1);'>뒤로</a>]</p>



	<!-- RND-TBL -->
	<form action=guzic_option.php?action=option_multi_reg method=post name=fForm>
	<input type=hidden name=numbers value=$_GET[numbers]>
	<input type=hidden name=pg value=$_GET[pg]>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class=tbl_box_rnd>
	<tr>
		<td width=4 height=4 background="img/bgbox_rnd3_trans01a.gif" nowrap></td>
		<td background="img/bgbox_rnd3_trans01b.gif"></td>
		<td width=4 background="img/bgbox_rnd3_trans01c.gif" nowrap></td>
	</tr>
	<tr>
		<td background="img/bgbox_rnd3_trans01d.gif"></td>
		<td bgcolor=white>



			<!-- TBL -->
			<table width="100%" border="0" cellspacing="1" cellpadding="0" class=tbl_box2>

			<!-- 유료옵션변경 -->
			<tr bgcolor=white>
				<td width=140  align=center class='tbl_box2_item1' nowrap style='padding:10;' valign='top'>
					<font class=item_txt>유료광고상태</font>
					<div style="width:130; margin:5 0 5 0; text-align:left;">
						결제없이 유료광고상태를<br>변경하는 부분은 관리자의<br>고유기능입니다.
					</div>
				</td>
				<td class=tbl_box2_padding>
					$wait_temp
				</td>
			</tr>
			</table>


		</td>
		<td background="img/bgbox_rnd3_trans01e.gif"></td>
	</tr>
	<tr>
		<td height=4 background="img/bgbox_rnd3_trans01f.gif"></td>
		<td background="img/bgbox_rnd3_trans01g.gif"></td>
		<td background="img/bgbox_rnd3_trans01h.gif"></td>
	</tr>
	</table>


	<!-- 저장 버튼 -->
	<table border="0" cellspacing="0" cellpadding="0" id=cfg_admin_tool_btn_tbl align=center>
	<tr>
		<td align=center style="padding-left:20;">
			<input type='submit' value='설정을 변경합니다'>
		</td>
	</tr>
	</table>
	</form>
	<!-- 본문내용 [ end ] -->
END;
}

function option_multi_reg()
{
	global $real_gap;
	global $CONF;
	global $PER_ARRAY;
	global $demo;
	global $_POST;
	global $per_document_tb;
	global $jangboo;
	global $pg;

	if ($demo == "1") {	#데모이면 삭제안됨
		error("데모버젼은 작동하지 않습니다");
		exit;
	}

	$TmpNumbers = explode("|",$_POST['numbers']);

	if ( is_array($TmpNumbers) )
	{
		foreach ( $TmpNumbers as $k => $v )
		{
			for( $i=0, $SetSql="" ; $i<14 ; $i++ ){
				$query_name = $PER_ARRAY[$i];

				$SetSql	.= " $query_name = '".$_POST[$query_name]."', ";
			}
			$SetSql .= " skin_html = '$_POST[skin_html]' ";
			$SetSql .= " , freeicon = '$_POST[freeicon]' ";
			$SetSql .= ", bgcolorDate = '$_POST[bgcolorDate]' ";

			#업데이트
			$sql = "update $per_document_tb set $SetSql where number='$v' ";
			//echo $sql."<br><br>";
			$result = query($sql);
		}

	}

	gomsg("\\n일괄 업데이트가 완료되었습니다 ","guin.php?a=guzic&mode=list&pg=$_POST[pg]");
	//gomsg("\\n업데이트가 완료되었습니다 ","guzic_option.php?action=option&number=$_POST[number]&pg=$_POST[pg]");
	exit;



}



function option()
{

	global $real_gap;
	global $CONF;
	global $per_document_tb;
	global $PER_ARRAY_NAME;
	global $links_number;
	global $PER_ARRAY_NAME2;
	global $PER_ARRAY;
	global $id;
	global $pg;
	global $jangboo;
	global $_GET;
	global $skin_folder;
	global $PER_ARRAY_DB;

	$number = $_GET['number'];

	$i_array	= array(2,1,0,4,5,6,3,7,8,9,10,11,12,13);
	for( $x=0 ; $x<14 ; $x++ ){
		$i	= $i_array[$x];
		$query_name .= "$PER_ARRAY[$i],";
	}
	$query_name .= " freeicon ";
	$query_name	= ereg_replace(",$", "", $query_name);
	$Sql		= "select $query_name , skin_html from $per_document_tb where number='$number'";

	//echo $Sql;

	$Record		= query($Sql);
	$Data		= happy_mysql_fetch_assoc($Record);

	$freeicon_selectbox = "";
	$FREEICON_ARRAY = array();

	for ( $x=0, $r_content="" ; $x<14 ; $x++ )
	{
		$i	= $i_array[$x];
		list($Data[$PER_ARRAY[$i]])	= explode(" ",$Data[$PER_ARRAY[$i]]);

		#자유아이콘인경우
		$freeicon_selectbox = "";
		$freeicon_selectbox_preview = "";
		if ($i == "7") {

			for ( $f = 1; $f<=15; $f++) {
				$array_key = $f - 1;
				$FREEICON_ARRAY[$array_key] = "freeicon".$f.".gif";
			}

			$freeicon_selectbox = make_selectbox($FREEICON_ARRAY,"아이콘선택",'freeicon',$Data['freeicon']);
			$freeicon_selectbox_preview = "<br><img src='img/freeico_preview.jpg' border='0' style='border:2px solid #EEE;'>";

		}

		$r_content	.= "
			<tr bgcolor='#ffffff'>
				<td class='cfg_tbl_box2_title3a' nowrap='nowrap'>
					<font class='item_txt'>
					<p class='part_title'>$PER_ARRAY_NAME[$i] 기간별</p>
					</font>
				</td>
				<td class='input_style_adm'>$freeicon_selectbox <input type='text' name='$PER_ARRAY[$i]' value='".$Data[$PER_ARRAY[$i]]."' style='width:120px'> 일까지
				<a href='javascript:void(0)' onclick='if(self.gfPop)gfPop.fPopCalendar(document.fForm.$PER_ARRAY[$i]);return false;' HIDEFOCUS><img src='../img/btn_calender.gif'  align=absmiddle border=0></a>
				<br>
				$freeicon_selectbox_preview
				</td>
			</tr>
		";


	}


	$loading_files	= filelist("../$skin_folder","doc_skin","_sms|_basic|_job");
	$inputTag		= "<select name='skin_html' >";
	$inputTag		.= "	<option value=''>스킨파일선택</option>";
	for ( $z=0, $maxz=sizeof($loading_files) ; $z<$maxz ; $z++ )
	{
		$nowValue	= $loading_files[$z];
		$selected	= ( $Data['skin_html'] == $nowValue )?" selected ":"";
		$inputTag	.= "<option value='$nowValue' $selected >$nowValue</option>";
	}
	$inputTag	.= "</select>";


	$r_content	.= "
		<tr bgcolor='#ffffff'>
			<td class='cfg_tbl_box2_title3a' nowrap='nowrap'>
				<font class='item_txt'>
				<p class='part_title'>이력서 스킨</p>
				</font>
			</td>
			<td class='input_style_adm'>
				$inputTag
				<div style='margin:5px 0 5px 0;'>
					<img src='img/doc_skin_preview.jpg' border=0 style='border:2px solid #EEE; margin-bottom:5;'>
					<div class='help_style' style='margin-top:15px'>
						<div class='box_1'></div>
						<div class='box_2'></div>
						<div class='box_3'></div>
						<div class='box_4'></div>
						<span class='help'>도움말</span>
						<p>
							doc_skin 으로 시작하는 템플릿파일 리스트<br>※ 파일명에 _sms가 포함된 파일 제외
						</p>
					</div>
				</div>
			</td>
		</tr>
	";



	$wait_temp =<<<END
			<table class="tbl_box2" style="margin-bottom: 25px; background-color: #e7eaef" cellspacing="1" cellpadding="0" width="100%" border="0">
				$r_content
			</table>
END;





#이력서리스트 : 유료옵션변경
print <<<END

	<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../js/calendar_google/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>


	<p class='main_title'>유료옵션변경 </p>

	<div class="help_style" style="margin-top:15px">
	<div class="box_1"></div>
		<div class="box_2"></div>
		<div class="box_3"></div>
		<div class="box_4"></div>
		<span class="help">도움말</span>
		<p>
			결제없이 유료광고상태를 변경하는 부분은 관리자의 고유기능입니다
		</p>
	</div>
	<!-- RND-TBL -->
	<form action=guzic_option.php?action=option_reg method=post name=fForm>
	<input type=hidden name=number value=$number>
	<input type=hidden name=pg value=$pg>

	<div id='box_style'>
		<div class='box_1'></div>
		<div class='box_2'></div>
		<div class='box_3'></div>
		<div class='box_4'></div>
		<table cellspacing='1' cellpadding='0' class='bg_style box_height'>
		<tr>
			<th>유료광고상태</th>
			<td>$wait_temp</td>
		</tr>
		</table>
	</div>
	<div align='center'><input type='submit' value='저장하기' class='btn_big'></div>
	</form>


END;


}

function option_reg() {

	global $real_gap;
	global $CONF;
	global $PER_ARRAY;
	global $demo;
	global $_POST;
	global $per_document_tb;
	global $jangboo;
	global $pg;

	if ($demo == "1") {	#데모이면 삭제안됨
		error("데모버젼은 작동하지 않습니다");
		exit;
	}


	for( $i=0, $SetSql="" ; $i<14 ; $i++ ){
		$query_name = $PER_ARRAY[$i];

		$SetSql	.= " $query_name = '".$_POST[$query_name]."', ";
	}
	$SetSql .= " skin_html = '$_POST[skin_html]' ";
	$SetSql .= " , freeicon = '$_POST[freeicon]' ";
	$SetSql .= ", bgcolorDate = '$_POST[bgcolorDate]' ";




	#업데이트
	$sql = "update $per_document_tb set $SetSql where number='$_POST[number]' ";
	//echo $sql;exit;
	$result = query($sql);


	gomsg("\\n업데이트가 완료되었습니다 ","guzic_option.php?action=option&number=$_POST[number]&pg=$_POST[pg]");
	exit;

}


include ("tpl_inc/bottom.php");

if ($demo){
	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	print   "<center><font color=gray size=1>Query Time : $exec_time sec";
}
exit;

?>