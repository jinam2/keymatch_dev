<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 13:38:47 */
function SkyTpl_Func_1821750003 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<? global $img_src;
	$img_src = "img/google_stats";
?>


<script type="text/javascript" src="../js/charts/loader.js?c=<?=$_data['js_make_date']?>"></script>
<?=$_data['happy_analytics_graph_js']?>



<script>
function change_search_date(startDate)
{
	document.getElementById('s_date').value	= startDate;
	document.getElementById('e_date').value	= '<?=$_data['today']?>';
}

//add
function get_google_data()
{
	var google_popup	= window.open("about:blank","google_popup","top=300,left=400,width=300,height=200,toolbar=no");

	var popup_design	= document.getElementById('google_popup_design').innerHTML;
	google_popup.window.document.write(popup_design);
	document.search_a.target	= "google_popup";
	document.search_a.submit();
}
//
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


<!--
<div id='google_popup_design' style='display:none'>
	구글통계정보를 받는 중...
</div>
 -->



<p class="main_title">
	<?=$_data['now_location_subtitle']?>

	<span class="happy_analytics_tab">
		<a href="happy_analytics.php" class="on">통계메인</a>
		<a href="happy_analytics.php?action=happy_analytics_keyword">키워드검색</a>
		<a href="happy_analytics.php?action=happy_analytics_refer">이전접속경로</a>
		<a href="happy_analytics.php?action=happy_analytics_bestview">가장많이본페이지</a>
		<a href="happy_analytics.php?action=happy_analytics_return">가장많이떠난페이지</a>
	</span>
</p>


<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="<?=$_data['main_url']?>/admin/js/calendar_google/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>

<script language="javascript" src="./js/happy_analytics.js"></script>
<form name=search_a style='margin:0px' onsubmit="return happy_analytics_form_submit(this);">
<input type="hidden" name="profile_id" value="<?=$_data['google_login_profile']?>">
<input type="hidden" name="demo_lock" value="<?=$_data['demo_lock']?>">

<div class="search_style" style="margin-top:20px;">
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

<div class="happy_analytics_box">
	<div class="happy_analytics_box_head">
		<div class="happy_analytics_box_title">총 방문자 수</div>
	</div>
	<div class="happy_analytics_box_inner">
		<div id="my_chart1" style="height:400px;"></div>
	</div>
</div>

<div class="happy_analytics_box_clear">
	<div class="happy_analytics_box float_box_left">
		<div class="happy_analytics_box_head">
			<div class="happy_analytics_box_title">브라우저별</div>
		</div>
		<div class="happy_analytics_box_inner">
			<div id="my_chart4" style="height:300px;"></div>
		</div>
	</div>
	<div class="happy_analytics_box float_box_right">
		<div class="happy_analytics_box_head">
			<div class="happy_analytics_box_title">해상도별</div>
		</div>
		<div class="happy_analytics_box_inner">
			<div id="my_chart5" style="height:300px;"></div>
		</div>
	</div>
</div>

<div class="happy_analytics_box">
	<div class="happy_analytics_box_head">
		<div class="happy_analytics_box_title">총 페이지뷰 수</div>
	</div>
	<div class="happy_analytics_box_inner">
		<div id="my_chart2"></div>
	</div>
</div>

<div class="happy_analytics_box">
	<div class="happy_analytics_box_head">
		<div class="happy_analytics_box_title">시간대별 접속수</div>
	</div>
	<div class="happy_analytics_box_inner">
		<div id="my_chart3"></div>
	</div>
</div>

<div class="happy_analytics_box">
	<div class="happy_analytics_box_head">
		<div class="happy_analytics_box_title">이전 접속 경로별</div>
	</div>
	<div class="happy_analytics_box_inner">
		<div id="my_chart7"></div>
	</div>
</div>


<? }
?>