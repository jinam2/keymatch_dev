<?php
$t_start = array_sum(explode(' ', microtime()));
include ("../inc/Template.php");
$TPL = new Template;

include ("../inc/config.php");
include ("../inc/function.php");
include ("../inc/lib.php");


################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################

if ( !admin_secure("구인구직옵션설정") ) {
		error("접속권한이 없습니다.");
		exit;
}

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
	global $real_gap,$CONF,$guin_tb,$ARRAY_NAME,$links_number,$ARRAY_NAME2,$ARRAY,$id,$pg,$jangboo;

	//$number = $_GET[number];

	$i_array	= array(0,1,2,5,4,6,3,10,11,12,13,14,15,16);
	//echo count($i_array);


	for($x =0;$x<=13;$x++)
	{
		$i	= $i_array[$x];
		$query_name .= "$ARRAY[$i],";
	}
	//echo $query_name;

	/*
	$query_name = ereg_replace(",$", "", $query_name);
	$query_name .= ", freeicon_com ";
	$sql = "select $query_name from $guin_tb where number='$number'";
	#print $sql;
	$result = query($sql);
	$BD = happy_mysql_fetch_array($result);
	*/

	for($x =0;$x<=13;$x++)
	{
		$i	= $i_array[$x];
		$tmp_option = $ARRAY[$i] . "_option";
		list($tmp_day,$tmp_price) = split(":",$PAY[$i]);

		if ($CONF[$tmp_option] == '기간별')
		{
			$now_end_date = $BD{$ARRAY[$i]} - $real_gap;

			if ( $now_end_date < 0 )
			{
				$now_end_date = 0;
			}

			$msg = "일 남음" ;
		}
		else
		{
			$now_end_date = $BD{$ARRAY[$i]};
			$msg = "회 남음" ;
		}

		#자유아이콘인경우
		$freeicon_selectbox = "";
		$FREEICON_ARRAY = array();

		if ($x == "8")
		{
			for ( $f = 1; $f<=10; $f++)
			{
				$array_key = $f - 1;
				$FREEICON_ARRAY[$array_key] = "btn_com_icon".$f.".gif";
			}

			$freeicon_selectbox = make_selectbox($FREEICON_ARRAY,"아이콘선택",' freeicon_com',$BD['freeicon_com']);
		}

		//배경색상
		if ( $x == "7" )
		{
			global $HAPPY_CONFIG;
			//echo $BD['guin_bgcolor_select'];
			$guin_title_bgcolors	= explode(",",strtoupper($HAPPY_CONFIG['guin_title_bgcolors']));
			$freeicon_selectbox = make_selectbox($guin_title_bgcolors,"배경색선택",' guin_bgcolor_select',$BD['guin_bgcolor_select']);
		}
		//배경색상

		$r_content .= "
		<tr>
			<th style='width:15%;'>$ARRAY_NAME[$i] $CONF[$tmp_option]</th>
			<td>
				<p class='short'>남은 기간을 입력한후 저장하면 바로 적용 됩니다.</p>
				<input name=\"$ARRAY[$i]\" type=\"text\"  size=\"5\" maxlength=\"5\" value='$now_end_date' > $msg $msg2  $freeicon_selectbox
			</td>
		</tr>
		";
	}

	$wait_temp = "<table cellspacing='1' cellpadding='0' border='0' class='bg_style box_height'>$r_content</table>";

	#구매내역 정리끝


print <<<END

<p class="main_title">유료옵션 변경</p>
<form action=guin_option.php?action=option_multi_reg method=post name=fForm style='margin:0;'>
<input type=hidden name=numbers value=$_GET[numbers]>
<input type=hidden name=pg value=$_GET[pg]>
<div id="box_style">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>
	$wait_temp
</div>
<div style="text-align:center;"><input type='submit' value='설정을 저장합니다' class='btn_big'></div>
</form>


END;

}

function option_multi_reg()
{
	global $real_gap,$CONF,$ARRAY,$demo,$guin_tb,$jangboo,$pg;

	if ($demo == "1")
	{
		#데모이면 삭제안됨
		error("데모버젼은 작동하지 않습니다");
		exit;
	}

	$TmpNumbers = explode("|",$_POST['numbers']);

	if ( is_array($TmpNumbers) )
	{
		foreach ( $TmpNumbers as $k => $v )
		{
			$query_name = "";
			$tmp_v = "";

			for($i =0;$i<=6;$i++){
				$tmp_option = $ARRAY[$i] . "_option";

				if ($CONF[$tmp_option] == '기간별'){
				$_POST2{$ARRAY[$i]} = $_POST{$ARRAY[$i]} + $real_gap;
				}
				else{
					$_POST2{$ARRAY[$i]} = $_POST{$ARRAY[$i]};
				}
				$query_name .= "$ARRAY[$i] = '".$_POST2{$ARRAY[$i]}."',";
			}

			for($i =10;$i<=16;$i++){
				$tmp_option = $ARRAY[$i] . "_option";
				if ($CONF[$tmp_option] == '기간별'){
				$_POST2{$ARRAY[$i]} = $_POST{$ARRAY[$i]} + $real_gap;
				}
				else{
					$_POST2{$ARRAY[$i]} = $_POST{$ARRAY[$i]};
				}
				$query_name .= "$ARRAY[$i] = '".$_POST2{$ARRAY[$i]}."',";
			}

			$query_name = preg_replace ("/,$/", "", $query_name);

			$query_name .= " ,  freeicon_com = '$_POST[freeicon_com]' ";
			//배경색상
			$query_name .= " ,  guin_bgcolor_select = '$_POST[guin_bgcolor_select]' ";

			#업데이트
			$sql = "update $guin_tb set $query_name	where number='$v' ";
			//echo $sql."<br><br>";
			//exit;
			$result = query($sql);
		}
	}

		gomsg("\\n일괄 업데이트가 완료되었습니다 ","guin.php?a=guin&mode=list&pg=$_POST[pg]");
		exit;


}



function option() {

	global $real_gap,$CONF,$guin_tb,$ARRAY_NAME,$links_number,$ARRAY_NAME2,$ARRAY,$id,$pg,$jangboo;

	$number = $_GET[number];

	$i_array	= array(0,1,2,5,4,6,3,10,11,12,13,14,15,16);
	//echo count($i_array);


	for($x =0;$x<=13;$x++)
	{
		$i	= $i_array[$x];
		$query_name .= "$ARRAY[$i],";
	}
	//echo $query_name;

	$query_name = ereg_replace(",$", "", $query_name);
	//배경색상
	$query_name .= ", freeicon_com, guin_bgcolor_select ";
	$sql = "select $query_name from $guin_tb where number='$number'";
	#print $sql;
	$result = query($sql);
	$BD = happy_mysql_fetch_array($result);

	for($x =0;$x<=13;$x++)
	{
		$i	= $i_array[$x];
		$tmp_option = $ARRAY[$i] . "_option";
		list($tmp_day,$tmp_price) = split(":",$PAY[$i]);

		if ($CONF[$tmp_option] == '기간별')
		{
			$now_end_date = $BD{$ARRAY[$i]} - $real_gap;

			if ( $now_end_date < 0 )
			{
				$now_end_date = 0;
			}

			$msg = "일 남음" ;
		}
		else
		{
			$now_end_date = $BD{$ARRAY[$i]};
			$msg = "회 남음" ;
		}

		#자유아이콘인경우
		$freeicon_selectbox = "";
		$FREEICON_ARRAY = array();

		if ($x == "8")
		{
			for ( $f = 1; $f<=10; $f++)
			{
				$array_key = $f - 1;
				$FREEICON_ARRAY[$array_key] = "btn_com_icon".$f.".gif";
			}

			$freeicon_selectbox = make_selectbox($FREEICON_ARRAY,"아이콘선택",' freeicon_com',$BD['freeicon_com']);
		}

		//배경색상
		if ( $x == "7" )
		{
			global $HAPPY_CONFIG;
			//echo $BD['guin_bgcolor_select'];
			$guin_title_bgcolors	= explode(",",strtoupper($HAPPY_CONFIG['guin_title_bgcolors']));
			$freeicon_selectbox = make_selectbox($guin_title_bgcolors,"배경색선택",' guin_bgcolor_select',$BD['guin_bgcolor_select']);
		}
		//배경색상

		$r_content .= "
		<tr>
			<th style='width:15%;'>$ARRAY_NAME[$i] $CONF[$tmp_option]</th>
			<td>
				<p class='short'>남은 기간을 입력한후 저장하면 바로 적용 됩니다.</p>
				<input name=\"$ARRAY[$i]\" type=\"text\"  size=\"5\" maxlength=\"5\" value='$now_end_date' > $msg $msg2  $freeicon_selectbox
			</td>
		</tr>
		";
	}

	$wait_temp = "<table cellspacing='1' cellpadding='0' border='0' class='bg_style box_height'>$r_content</table>";

	#구매내역 정리끝


print <<<END
<p class="main_title">유료옵션 변경</p>
<form action=guin_option.php?action=option_reg method=post name=fForm style='margin:0;'>
<input type=hidden name=number value=$number>
<input type=hidden name=pg value=$pg>
<div id="box_style">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>
	$wait_temp
</div>
<div style='text-align:center;'><input type='submit' value='저장하기' class='btn_big'></div>
</form>



END;


}

function option_reg() {
global $real_gap,$CONF,$ARRAY,$demo,$guin_tb,$jangboo,$pg;

	if ($demo == "1") {	#데모이면 삭제안됨
	error("데모버젼은 작동하지 않습니다");
	exit;
	}

	for($i =0;$i<=6;$i++){
		$tmp_option = $ARRAY[$i] . "_option";
		if ($CONF[$tmp_option] == '기간별'){
		$_POST{$ARRAY[$i]} = $_POST{$ARRAY[$i]} + $real_gap;
		}
		$query_name .= "$ARRAY[$i] = '".$_POST{$ARRAY[$i]}."',";
	}

	for($i =10;$i<=16;$i++){
		$tmp_option = $ARRAY[$i] . "_option";
		if ($CONF[$tmp_option] == '기간별'){
		$_POST{$ARRAY[$i]} = $_POST{$ARRAY[$i]} + $real_gap;
		}
		$query_name .= "$ARRAY[$i] = '".$_POST{$ARRAY[$i]}."',";
	}

	$query_name = preg_replace ("/,$/", "", $query_name);

	$query_name .= " ,  freeicon_com = '$_POST[freeicon_com]' ";
	//배경색상
	$query_name .= " ,  guin_bgcolor_select = '$_POST[guin_bgcolor_select]' ";

	#업데이트
	$sql = "update $guin_tb set $query_name	where number='$_POST[number]' ";
	//echo $sql;
	//exit;
	$result = query($sql);


gomsg("\\n업데이트가 완료되었습니다 ","guin_option.php?action=option&number=$_POST[number]&pg=$_POST[pg]");
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