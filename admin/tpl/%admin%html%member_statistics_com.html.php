<? /* Created by SkyTemplate v1.1.0 on 2023/04/10 10:38:47 */
function SkyTpl_Func_2688986815 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?
	global $img_src;
	$img_src = "img/google_stats";

	if($_GET)
	{
		$s_date = $_GET[s_date];
		$e_date = $_GET[e_date];
	}
	else
	{
		$s_date = "2000-01-01";
		$e_date = "";
	}


?>

<!-- Google 플래시차트 -->
<script type="text/javascript" src="<?=$_data['main_url']?>/open_flash/js/swfobject.js"></script>


<!-- 총 방문자수(UNIQUE) [1번] -->
<script type="text/javascript">
var no_stats = "<?=$_data['no_stats']?>";
swfobject.embedSWF(
"<?=$_data['main_url']?>/open_flash/open-flash-chart.swf", "my_chart1",
"100%", "200", "9.0.0", "<?=$_data['main_url']?>/open_flash/expressInstall.swf",
{"data-file":"<?=$_data['main_url']?>/open_flash/statistics_area.php?info=Month|big|green|<?=$_data['s_date_info']?>|<?=$_data['e_date_info']?>|com","loading":"로딩중..."},{"wmode":"transparent"});
</script>

<!-- 총 방문자수(UNIQUE) [3번] -->
<script type="text/javascript">
swfobject.embedSWF(
"<?=$_data['main_url']?>/open_flash/open-flash-chart.swf", "my_chart3",
"100%", "200", "9.0.0", "<?=$_data['main_url']?>/open_flash/expressInstall.swf",
{"data-file":"<?=$_data['main_url']?>/open_flash/statistics_area.php?info=Month|big|green|<?=$_data['s_date_info']?>|<?=$_data['e_date_info']?>|com","loading":"로딩중..."},{"wmode":"transparent"});
</script>



<!-- 총 페이지뷰(UNIQUE) [2번] -->
<script type="text/javascript">
swfobject.embedSWF(
"<?=$_data['main_url']?>/open_flash/open-flash-chart.swf", "my_chart2",
"90%", "200", "9.0.0", "<?=$_data['main_url']?>/open_flash/expressInstall.swf",
{"data-file":"<?=$_data['main_url']?>/open_flash/statistics_area.php?info=week|small|yellow|<?=$_data['s_date_info']?>|<?=$_data['e_date_info']?>|com","loading":"로딩중..."},{"wmode":"transparent"});
</script>


<!-- 시간대별 사용자접속수 [3번]-->
<!--
<script type="text/javascript">
swfobject.embedSWF(
"<?=$_data['main_url']?>//open_flash/open-flash-chart.swf", "my_chart3",
"100%", "200", "9.0.0", "<?=$_data['main_url']?>/open_flash/expressInstall.swf",
{"data-file":"<?=$_data['main_url']?>/open_flash/area.php?info=getVisitsPerHour||small||yellow","loading":"로딩중..."} );
</script>
-->



<!-- 시간별 회원가입 현황 [5번] -->
<script type="text/javascript">
if ( no_stats == "" )
{
 swfobject.embedSWF(
"<?=$_data['main_url']?>//open_flash/open-flash-chart.swf", "my_chart4",
"100%", "400", "9.0.0", "<?=$_data['main_url']?>/open_flash/expressInstall.swf",
{"data-file":"<?=$_data['main_url']?>/open_flash/statistics_pie_time.php?info=time|big| |<?=$_data['s_date_info']?>|<?=$_data['e_date_info']?>|com","loading":"구글에서 통계를 수집중입니다 . . . "},{"wmode":"transparent"});
}
</script>

<!-- 지역별 회원가입 현황 [5번] -->
<script type="text/javascript">
if ( no_stats == "" )
{
 swfobject.embedSWF(
"<?=$_data['main_url']?>//open_flash/open-flash-chart.swf", "my_chart5",
"100%", "300", "9.0.0", "<?=$_data['main_url']?>/open_flash/expressInstall.swf",
{"data-file":"<?=$_data['main_url']?>/open_flash/statistics_pie_local.php?info=local|big| |<?=$_data['s_date_info']?>|<?=$_data['e_date_info']?>|com","loading":"구글에서 통계를 수집중입니다 . . . "},{"wmode":"transparent"});
}
</script>



<!-- 검색엔진검색어 점유별 [6번] -->
<!--
<script type="text/javascript">
 swfobject.embedSWF(
"<?=$_data['main_url']?>//open_flash/open-flash-chart.swf", "my_chart6",
"100%", "1600", "9.0.0", "<?=$_data['main_url']?>/open_flash/expressInstall.swf",
{"data-file":"<?=$_data['main_url']?>/open_flash/hbar.php?info=getSearchWords|top_remove|big||","loading":"구글에서 통계를 수집중입니다 . . . "} );
</script>
-->


<!-- 회원가입한 년령대 [7번] -->
<script type="text/javascript">
if ( no_stats == "" )
{
swfobject.embedSWF(
"<?=$_data['main_url']?>//open_flash/open-flash-chart.swf", "my_chart7",
"96%", "300", "9.0.0", "<?=$_data['main_url']?>/open_flash/expressInstall.swf",
{"data-file":"<?=$_data['main_url']?>/open_flash/statistics_pie_year.php?info=year|big|green|<?=$_data['s_date_info']?>|<?=$_data['e_date_info']?>|com","loading":"로딩중..."},{"wmode":"transparent"});
}
</script>




<script>
function change_search_date(startDate)
{
	document.getElementById('s_date').value	= startDate;
	document.getElementById('e_date').value	= '<?=$_data['today']?>';
}
</script>


<STYLE TYPE="text/css">
	/* 구글통계정보 */
	#btn_google_stats{width:228; height:37; color:white; font-size:8pt; font-family:맑은 고딕,돋움; font-weight:bold;  border:0px solid; background:url('img/google_stats/btn_bg04.gif') no-repeat center 0;}
	#google_stats_date1,#google_stats_date2{width:190;}
	#google_stats_date1 div,#google_stats_date2 div{float:left;}
	#google_stats_date1 div input,#google_stats_date2 div input{font:10pt arial;}
	#google_stats_date1 .google_date_input1, #google_stats_date2 .google_date_input1{
		height:24; background:transparent url('img/google_stats/bg_date_input01a.gif') no-repeat 0 0; padding:2 0 0 5;}
	#google_stats_date1 .google_date_input1 input, #google_stats_date2 .google_date_input1 input{width:100;}
	#google_stats_date1 .google_date_input2, #google_stats_date2 .google_date_input2{width:40;height:24;}
	#google_stats_date1 .google_date_input3, #google_stats_date2 .google_date_input3{width:35; height:24; font-family:맑은 고딕,돋움; padding:6 5 0 4;}
</STYLE>


<!-- 접속통계요약정보 [ start ] -->
<p class="main_title"><?=$_data['now_location_subtitle']?></p>

<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="<?=$_data['main_url']?>/admin/js/calendar_google/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>

<form name=search_a action=? method=GET style='margin:0px'>
<div class="search_style">
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<table cellspacing="0" cellpadding="0" style="width:100%;">
	<tr>
		<td style="padding-top:3px; width:280px;">
			<a onClick="change_search_date('<?=$_data['dayChk']['30']?>')" alt='30일간' title="30일간" class="btn_small_navy">30 일간</a>
			<a onClick="change_search_date('<?=$_data['dayChk']['60']?>')" alt='60일간' title="60일간" class="btn_small_blue">60 일간</a>
			<a onClick="change_search_date('<?=$_data['dayChk']['90']?>')" alt='90일간' title="90일간" class="btn_small_green">90 일간</a>
			<a onClick="change_search_date('<?=$_data['dayChk']['182']?>')" alt='6개월' title="6개월" class="btn_small_orange">6 개월</a>
			<a onClick="change_search_date('<?=$_data['dayChk']['365']?>')" alt='12개월' title="12개월" class="btn_small_red">12 개월</a>
		</td>
		<td>
			<input type=text name=s_date id=s_date value='<?=$_data['s_date_info']?>' style="border:1px solid #dbdbdb; border-right:none; height:22px; line-height:22px; padding-left:5px; vertical-align:middle;"><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.search_a.s_date);return false;" HIDEFOCUS><img class="PopcalTrigger"  src="img/google_stats/bg_date_input01b.gif" border="0" alt=""></a> 부터
		</td>
		<td >
			<input type=text name=e_date id=e_date value='<?=$_data['e_date_info']?>' style="border:1px solid #dbdbdb; border-right:none; height:22px; line-height:22px; padding-left:5px; vertical-align:middle;"><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.search_a.e_date);return false;" HIDEFOCUS><img class="PopcalTrigger" align="absmiddle" src="img/google_stats/bg_date_input01b.gif" border="0" alt=""></a> 까지
		</td>
		<td align="right"><input type=submit  value='구글로부터 통계정보를 갱신합니다.' class="btn_small_dark"></td>
	</tr>
	</table>
</div>
</form>



<!-- 총방문자수 -->
<div style="text-align:center; margin:50px 0 40px 0;">
	<table width="99%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><div id="my_chart1"></div>&nbsp;</td>
		<td width=320 align=center><img src="<?=$img_src?>/member_statistics.gif" border="0" alt="회원가입통계"></td>
	</tr>
	</table>
</div>


<!-- Line -->
<div style="height:2px; border-top:1px solid #dedede; font-size:1px; margin:50px 0 60px 0;"><div></div></div>



<!-- 총페이지뷰 -->
<div style="text-align:center; margin:50px 0 40px 0;">
	<table width="99%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width=320 align=center><img src="<?=$img_src?>/member_week_statistics.gif" border="0" alt="요일별 회원가입 통계"></td>
		<td style="padding-left:15;"><div id="my_chart2"></div>&nbsp;</td>
	</tr>
	</table>
</div>




<!-- Line -->
<div style="height:2px; border-top:1px solid #dedede; font-size:1px; margin:50px 0 60px 0;"><div></div></div>


<!-- 브라우저별사용자접속율 | 사용자PC모니터해상도비율 -->
<div style="text-align:center; margin:50px 0 40px 0;">
	<table width="98%" border="0" cellspacing="0" cellpadding="0">
	<tr align=center>
		<td width="50%"><img src="<?=$img_src?>/member_pie_year.gif" border="0" alt="회원가입한 년령대"></td>
		<td><img src="<?=$img_src?>/member_local_statistics.gif" border="0" alt="지역별 회원가입현황"></td>
	</tr>
	<tr height=40>
		<td></td>
		<td></td>
	</tr>
	<tr align=center>
		<td><div id="my_chart7"></div></td>
		<td><div id="my_chart5"></div></td>
	</tr>
	</table>
</div>


<!-- Line -->
<div style="height:2px; border-top:1px solid #dedede; font-size:1px; margin:50px 0 60px 0;"><div></div></div>


<!-- 이전 접속사이트 TOP20 -->
<div style="text-align:center; margin:0 0 40px 0; border:0px solid;">
	<div style="margin-bottom:35px;"><img src="<?=$img_src?>/statistics_time_tit.gif" border="0" alt="시간별 회원가입현황"></div>
	<div id="my_chart4"></div>
</div>


<!-- Line -->
<div style="height:2px; border-top:1px solid #dedede; font-size:1px; margin:50px 0 60px 0;"><div></div></div>


<!-- 시간대별 사용자접속수 -->
<!--
<div style="text-align:center; margin:50 0 40 0;">
	<table width="99%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width=320 align=center><img src="<?=$img_src?>/title_all_time_guest.gif" border="0"></td>
		<td style="padding-left:15;"><div id="my_chart3"></div>&nbsp;</td>
	</tr>
	</table>
</div>
-->

<? }
?>