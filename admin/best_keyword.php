<?
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/lib.php");


	if ( !admin_secure("추천키워드") ) {
			error("접속권한이 없습니다.");
			exit;
	}

	include ("tpl_inc/top_new.php");


###########################################
############# Table #######################
$createTable	= "
CREATE TABLE upso2_keyword (
 number int not null auto_increment primary key,
 year varchar(4) not null default '0000',
 mon varchar(2) not null default '01',
 day varchar(2) not null default '01',
 count int not null default '0',
 keyword varchar(50) not null default '',
 regdate datetime not null default '0000-00-00 00:00:00',
 key regd(regdate),
 key keyw(keyword)
)
";
###########################################




	$key_size	= ( $_GET["key_size"]== "" )?15:$_GET["key_size"];
	$cdate		= $keyword_rank_day;


	$year		= ( $_GET["key_year"]== "" )?date("Y"):$_GET["key_year"];
	$mon		= ( $_GET["key_mon"] == "" )?date("m"):$_GET["key_mon"];
	$day		= ( $_GET["key_day"] == "" )?date("d"):$_GET["key_day"];


	$nowDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day+1,$year));
	$firstDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day-$cdate+1,$year));
	$lastDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day-($cdate*2)+1,$year));


	$yearSelect		= dateSelectBox( "key_year", 2007, date("Y"), $year, "년", "선택", "onChange='this.form.submit()'" );
	$monSelect		= dateSelectBox( "key_mon", 1, 12, $mon, "월", "선택", "onChange='this.form.submit()'" );
	$daySelect		= dateSelectBox( "key_day", 1, 31, $day, "일", "선택", "onChange='this.form.submit()'" );
	$scaleSelect	= dateSelectBox( "key_size", 5, 100, $key_size, "개", "선택", "onChange='this.form.submit()'" , 5);

	$Sql	 = "	SELECT											";
	$Sql	.= "			keyword,								";
	$Sql	.= "			sum(count) AS cnt						";
	$Sql	.= "	FROM											";
	$Sql	.= "			$keyword_tb								";
	$Sql	.= "	WHERE											";
	$Sql	.= "			regdate < '$firstDate'					";
	$Sql	.= "			AND										";
	$Sql	.= "			regdate > '$lastDate'					";
	$Sql	.= "	GROUP BY										";
	$Sql	.= "			keyword									";
	$Sql	.= "	ORDER BY										";
	$Sql	.= "			cnt desc								";
	$Sql	.= "	LIMIT	0,50									";


	$Rs2	= query($Sql);

	$rank	= 1;
	while ( $Hash = happy_mysql_fetch_array($Rs2) )
	{
		$pRank[$Hash["keyword"]]	= $rank;
		$rank++;
	}



	$Sql	 = "	SELECT											";
	$Sql	.= "			*,										";
	$Sql	.= "			sum(count) AS cnt						";
	$Sql	.= "	FROM											";
	$Sql	.= "			$keyword_tb								";
	$Sql	.= "	WHERE											";
	$Sql	.= "			regdate > '$firstDate'					";
	$Sql	.= "			AND										";
	$Sql	.= "			regdate < '$nowDate'					";
	$Sql	.= "	GROUP BY										";
	$Sql	.= "			keyword									";
	$Sql	.= "	ORDER BY										";
	$Sql	.= "			cnt desc								";
	$Sql	.= "	LIMIT											";
	$Sql	.= "			0,$key_size								";

	$Record	= query($Sql);



?>

<script>

	function sendit(no,frm)
	{


		if ( no == 0 )
		{
			keyword	= frm.keyword.value;
			count	= frm.count.value;

			if ( keyword == "" )
			{
				alert("검색어를 입력해주세요.");
				frm.keyword.focus();
			}
			else if ( count == "" )
			{
				alert("검색횟수를 입력해주세요.");
				frm.count.focus();
			}
			else
			{
				frm.mode.value	= "add";
				frm.submit();
			}

		}
		else if ( no == 1 )
		{
			for ( var i = 0; i < frm.elements["delch[]"].length; i++ ) {
				str	= eval( frm.elements["delch[]"][i] );
				if( frm.delchall.checked == false )
				{
					str.checked		= false;
				}
				else if( frm.delchall.checked == true )
				{
					str.checked	= true;
				}
			}

		}
		else if ( no == 2 )
		{
			rank_max			= frm.elements["keyword[]"].length;

			for(i = 1; i < rank_max; i++)
			{
				if( ( frm.elements["keyword[]"][i].value == "" || frm.elements["count[]"][i].value == "" ) && frm.elements["delch[]"][i].checked == false )
				{
					if( frm.elements["keyword[]"][i].value == "" )
					{
						alert("검색어를 입력하거나 삭제에 체크해주세요.");
						frm.elements["keyword[]"][i].focus();
					}
					else
					{
						alert("검색횟수를 입력하거나 삭제에 체크해주세요.");
						frm.elements["count[]"][i].focus();
					}
					return false;
				}
			}
			if ( confirm( "   수정하시겠습니까?   ") )
			{
				frm.mode.value	= "modify";
				frm.submit();
			}
		}
		else
		{
			alert('ERROR');
		}
	}

</script>

<form name="form" method="get" action="best_keyword.php" style="margin:0;">
<style>
	select {border:1px solid #dbdbdb; height:29px; line-height:28px; padding:4px; background:#ffffff}
</style>

<p class="main_title">
	<?=$now_location_subtitle?>
	<span class="small_btn" style="top:-5px">
		<a href="http://cgimall.co.kr/xml_manual/manual_main.php?db_name=manual_adultjob&number=12" target="_blank" class="btn_small_yellow">
			도움말
		</a>
		<span id='search_frm_onoff' style="margin-left:10px"><?=$yearSelect?> <?=$monSelect?> <?=$daySelect?> <?=$scaleSelect?>
		</span>
	</span>
</p>

</form>


	<form name="rank_<?=$rank?>" action="best_keyword_reg.php" method="post" style="margin:0px; padding:0px;">
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="key_year" value="<?=$year?>">
	<input type="hidden" name="key_mon" value="<?=$mon?>">
	<input type="hidden" name="key_day" value="<?=$day?>">
	<input type="hidden" name="key_size" value="<?=$key_size?>">


	<div id="list_style" style="margin-top:20px;">
		<table cellspacing="0" cellpadding="0" border="0" class="bg_style table_line">
			<tr>
				<th style='width:50px;'>순위</th>
				<th style='width:100px;'>순위변동</th>
				<th style='width:100px;'>날짜</th>
				<th>검색어</th>
				<th style='width:130px;'>검색횟수</th>
				<th style='width:80px;'><label><input type="checkbox" name="delchall" id="delchall" value="Y"  onClick="sendit(1,this.form)"> 전체</label></th>
			</tr>
	<?


		$rank	= 1;
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$rankChk	= $pRank[$Data["keyword"]];

			$rank_word	= $Data["keyword"];
			$rank_num	= $rank;
			$rank_cnt	= $Data["cnt"];

			if ( $rankChk == "" ) {
				$rank_icon		= $rankIcon_new;
				$rank_change	= "";
			}
			else if ( $rankChk > $rank ) {
				$tmp	= $rankChk - $rank;
				$rank_icon		= $rankIcon_up;
				$rank_change	= $tmp;
			}
			else if ( $rankChk < $rank ) {
				$tmp	= $rank - $rankChk;
				$rank_icon		= $rankIcon_down;
				$rank_change	= $tmp;
			}
			else if ( $rankChk == $rank ) {
				$rank_icon		= $rankIcon_equal;
				$rank_change	= "";
			}


			?>
				<tr>
					<td style="height:35px;" align="center">
						<input type="hidden" id="prev_keyword[]" name="prev_keyword[<?=$rank?>]" value="<?=$rank_word?>">
						<input type="hidden" id="prev_count[]" name="prev_count[<?=$rank?>]" value="<?=$rank_cnt?>">
						<?=$rank?>등
					</td>
					<td align="center">
						<img src="../<?=$rank_icon?>"> <?=$rank_change?>
					</td>
					<td style="text-align:center;"><?=substr($Data["regdate"],0,10)?></td>
					<td align="center">
						<input type="text" id="keyword[]" name="keyword[<?=$rank?>]" value="<?=$rank_word?>" style='color:#173fb8;font-weight:bold;width:98%;'>
					</td>
					<td>
						<input type="text" id="count[]" name="count[<?=$rank?>]" value="<?=$rank_cnt?>" style="width:90%;  text-align:right; padding-right:5px; font-weight:bold; color:#c63710;" onKeyPress="if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;" >
					</td>
					<td style="text-align:center;"><input type="checkbox" id="delch[]" name="delch[<?=$rank?>]" value="Y" style='vertical-align:middle;'> 삭제</td>
				</tr>
			<?

			$rank++;
		}

		if ( $rank == 1 )
		{
			echo "<tr><td height='100' align='center' colspan='6'>등록된 검색어가 없습니다.</td></tr>";
		}

	?>
		</table>
	</div>
	<div style="text-align:center; margin-bottom:30px;"><input type="button" value="수정하기" onClick="sendit(2,this.form)" class="btn_big"></div>
	</form>

	<div class="main_title" style="margin-top:50px;">
		실시간 인기검색어 추가
		<span class="small_btn">
			<a href="happy_config_view.php?number=7" class="btn_small_orange">
				실시간검색어 환경설정
			</a>
		</span>
	</div>

	<div class="help_style">
		<div class="box_1"></div>
		<div class="box_2"></div>
		<div class="box_3"></div>
		<div class="box_4"></div>
		<span class="help">도움말</span>
		<p style="color:#606060; text-align:left; line-height:18px; font-size:11px; font-family:'돋움'; letter-spacing:-1px">
		- 검색횟수 조절시 정확한 숫자로 업데이트 되지 않을수 있습니다.<br>
		- 만약 실시간검색어 출력 기간설정에서 3일로 설정이 되어있는데 7건으로 어떤 검색어를 변경했을경우...<br>
		- 7 / 3 -> 2.3333 으로 반올림하여 3건씩 균등 업그레이드되어 3건씩 3일은 9건으로 저장됩니다.
		</p>
	</div>


	<div id="box_style">
	<form method="post" action="best_keyword_reg.php" style="margin:0;">
	<input type="hidden" name="mode" value="add">
	<input type="hidden" name="key_year" value="<?=$year?>">
	<input type="hidden" name="key_mon" value="<?=$mon?>">
	<input type="hidden" name="key_day" value="<?=$day?>">
	<input type="hidden" name="key_size" value="<?=$key_size?>">


		<table cellspacing="1" cellpadding="0" border="0" class='bg_style box_height'>
		<tr>
			<th>검색어</th>
			<td>
				<p class="short">새로운 키워드를 입력합니다.</p>
				<input type="text" name="keyword" style="width:250px;">
			</td>
		</tr>
		<tr>
			<th>검색횟수</th>
			<td>
				<p class="short">키워드의 검색횟수를 임의 지정 합니다.</p>
				<Input type="text" name="count" style="width:250px;" onKeyPress="if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;">
			</td>
		</tr>
		</table>
	</div>
	<div style="text-align:center; margin-bottom:30px;"><input type="submit" value="저장하기" onClick="sendit(2,this.form)" class="btn_big"></div>
	</form>



<?
include ("tpl_inc/bottom.php");
?>