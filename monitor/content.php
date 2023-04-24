<?php

	//관리자모드에서 include 로만 호출
	if ( !$monitor_include_check )
	{
		exit;
	}

	$t_start = array_sum(explode(' ', microtime()));
	include("inc/monitor_config.php");
	include("inc/monitor_lib.php");
	include("inc/Snoopy.class.php");

	$monitor_snoopy			= new Snoopy;

	$happy_monitor_folder	= "../".$happy_monitor_folder;

	happy_monitor_config_create();
	happy_monitor_config_load();

	$mode					= $_GET['mode'];

	if ( $mode == "send_mail" )
	{
		$to_mail				= $_POST['to_mail'];

		if ( $to_mail == "" )
		{
			error("받을 메일주소가 없습니다.");
			exit;
		}

		//메일주소 저장
		happy_monitor_config_save('check_send_mail_addr',$to_mail);

		$is_ok					= happy_monitor_check_send_mail($to_mail);
		$alerMgs				= ( $is_ok ) ? "성공" : "실패";

		gomsg("메일 발송에 ".$alerMgs."했습니다.",$_SERVER['PHP_SELF']);
		exit;
	}

	if ( $MONITOR_CONFIG['check_send_mail_addr'] == "" )
	{
		$MONITOR_CONFIG['check_send_mail_addr']		= $admin_email;
	}

	//용량 체크 자동 업데이트
	$check_volume_script	= "";

	if ( $MONITOR_CONFIG['volume_check_auto_update_use'] == "y" )
	{
		list($tmp_day,$tmp_time)	= explode(" ",$MONITOR_CONFIG['check_volume_last_update']);
		list($tmp_y,$tmp_m,$tmp_d)	= explode("-",$tmp_day);
		list($tmp_h,$tmp_i,$tmp_s)	= explode(":",$tmp_time);

		$tmp_mktime					= happy_mktime($tmp_h + intval($MONITOR_CONFIG['volume_check_auto_update_term']),$tmp_i,$tmp_s,$tmp_m,$tmp_d,$tmp_y);

		if ( $tmp_mktime <= happy_mktime() )
		{
			$check_volume_script		= "check_volume_reload();";
		}
	}
?>

<!-- 자바스크립트 파일 링크처리 -->
<script language="JavaScript" type="text/javascript" src="<?php echo $happy_monitor_folder; ?>/js/jquery.js"></script>

<SCRIPT type="text/javascript">

var monitor_path			= "<?php echo $happy_monitor_folder; ?>";

var ajax_loading_image		= "<img src='" + monitor_path + "/img/ajax_loading.gif' border='0'>";
var ajax_loading_image_2	= "<img src='" + monitor_path + "/img/ajax_loading.gif' border='0' style='margin:20px 0;'>";

var check_image_green		= "<img src='" + monitor_path + "/img/check_icon_green_big.jpg' border='0'>";
var check_image_red			= "<img src='" + monitor_path + "/img/check_icon_red_big.jpg' border='0'>";

var check_image_green_small	= "<img src='" + monitor_path + "/img/check_icon_green.jpg' border='0'>";
var check_image_red_small	= "<img src='" + monitor_path + "/img/check_icon_red.jpg' border='0'>";

$(document).ready(function(){

	$.ajax({
		url		: monitor_path + "/check_permission.php",
		data	: { mode : 'get_count' },
		success	: function(respons){

			var responses		= respons.split("___CUT___");
			var check_count		= parseInt(responses[1]);

			if ( responses[0] == "ok" )
			{
				var check_image		= ( check_count == 0 ) ? check_image_green : check_image_red;

				$("#permission_check_layer").html(check_image);
			}
		},
		error	: function(respons){
			//alert(respons);
		}
	});

	//용량 가져오기
	<?php echo $check_volume_script; ?>

	$("#solution_volume_btn").click(function(){

		$("#solution_volume_layer").html(ajax_loading_image);
		$("#empty_volume_layer1").html(ajax_loading_image);
		$("#empty_volume_layer2").html(ajax_loading_image);

		check_volume_reload();
	});

	//서버 부하 체크하기
	check_load_time_reload();

	$("#load_time_check_btn").click(function(){

		$("#load_time_check_layer").html(ajax_loading_image);

		check_load_time_reload();
	});

	//솔루션 기능 체크
	$("#solution_check_btn").click(function(){

		$("#solution_check_btn").hide();
		$("#solution_check_layer").html(ajax_loading_image_2);

		$.ajax({
			url		: monitor_path + "/ajax_check_solution.php",
			success	: function(respons){

				var responses	= respons.split("___CUT___");

				if ( responses[0] == "ok" )
				{
					var check_array	= responses[2].split("||");
					var print_html	= "<table cellspacing='0' cellpadding='0' style='width:100%;'>";

					for ( var i = 0 ; i < check_array.length ; i++ )
					{
						var now_conf	= check_array[i].split(",");
						var check_image	= ( now_conf[2] ) ? check_image_green_small : check_image_red_small;

						print_html		+= "<tr>";
						print_html		+= "<td class='info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim' style='text-align:left;'><strong>" + now_conf[0] + "</strong>";
						print_html		+= "<br><span class='font_11 font_dotum' style='color:#a0a0a0;'>" + now_conf[1] + "</span>";
						print_html		+= "</td>";
						print_html		+= "<td class='info_td_content line-bottom_st_02' style='text-align:center; width:170px;'>" + check_image + "</td>";
						print_html		+= "</tr>";
					}

					print_html		+= "</table>";

					$("#solution_check_layer").html(print_html);
				}
				else
				{
					$("#solution_check_layer").html("테스트에 실패했습니다. 재시도해주세요.");
				}

				$("#solution_check_date").html(responses[1]);
				$("#solution_check_btn").show();
			},
			error	: function(respons){
				//alert(respons);
			}
		});
	});
});

function check_volume_reload()
{
	$.ajax({
		url		: monitor_path + "/ajax_check_volume.php",
		success	: function(respons){

			var responses	= respons.split("___CUT___");

			if ( responses[0] == "ok" )
			{
				$("#solution_volume_layer").html(responses[1]);

				if ( responses[2] )
				{
					var print_html1	= "";
					var print_html2	= "";
					var print_html3	= "";

					if ( responses[2] == "y" )
					{
						print_html1		+= check_image_green;
						print_html2		+= "<span style='color:#ff0000;'><?php echo $MONITOR_CONFIG['volume_check_limit_byte']; ?> MB</span> 이상";
						print_html3		+= responses[3];
					}
					else if ( responses[2] == "n" && responses[3] )
					{
						print_html1		+= check_image_red;
						print_html2		+= "<span style='color:#ff0000;'>" + responses[3] + " MB</span> 남음";
						print_html3		+= responses[4];
					}
					else
					{
						print_html1		+= check_image_red;
						print_html2		+= "<span style='color:#ff0000;'>오류</span>";
						print_html3		+= "<span style='color:#ff0000;'>오류</span>";
					}

					$("#empty_volume_layer1").html(print_html1);
					$("#empty_volume_layer2").html(print_html2);
					$("#check_volume_last_update_layer").html(print_html3);
				}
			}
		},
		error	: function(respons){
			//alert(respons);
		}
	});
}

function check_load_time_reload()
{
	$.ajax({
		url		: monitor_path + "/ajax_check_load_time.php",
		success	: function(score){

			if ( score )
			{
				//score = 0 ~ 10
				var score_image		= "<img src='" + monitor_path + "/img/score_icon_" + score + ".jpg' border='0'>";

				$("#load_time_check_layer").html(score_image);
			}
		},
		error	: function(respons){
			//alert(respons);
		}
	});
}
</SCRIPT>

<style type="text/css">
.font_11 { font-size:11px;}
.font_12 { font-size:12px;}
.font_16 { font-size:16px;}


.font_dotum{font-family:'돋움',Dotum,'맑은고딕','굴림',Gulim,tahoma,NanumGothic,Helvetica,'Apple SD Gothic Neo',Sans-serif;}
.font_gulim{font-family:'굴림',Gulim,'돋움',Dotum,'맑은고딕',tahoma,NanumGothic,Helvetica,'Apple SD Gothic Neo',Sans-serif;}
.font_malgun{font-family:'맑은고딕','돋움',Dotum,'굴림',Gulim,tahoma,NanumGothic,Helvetica,'Apple SD Gothic Neo',Sans-serif !important;}

.info_td_title{
padding:12px 0;
background:#f7f7f7;
color:#20232c;
line-height:18px;
letter-spacing:0px;
text-align:center;
}


.info_td_content{
padding:15px 10px;
background:#ffffff;
color:#20232c;
line-height:18px;
letter-spacing:0px;
}


.line-bottom_st_01{border-bottom:1px solid #dddde1;}
.line-bottom_st_02{border-bottom:1px solid #eeeef0;}
.line-right_st_01{border-right:1px solid #eeeef0;}

</style>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_box_title">
<tr>
	<td width="27" style="padding:0 0 0 2px;"><img src="img/ico_arrow_01.gif" border="0"></td>
	<td class="item_title">사이트 모니터링</td>
</tr>
</table>


<table cellspacing="0" cellpadding="0" style="width:1000px; background:#fdfdfd; border:1px solid #f0f0f0; margin-top:20px;">
<tr>
	<td align="center" valign="top" style="padding:20px 0; border-right:1px solid #f0f0f0; width:280px;">
		<div class="font_16 font_malgun" align="center" style="height:25px;"><strong>솔루션 기본 데모락</strong></div>
		<div style="margin:15px 0; height:50px;">
			<?php $demo_lock_data	= happy_monitor_check_demo_lock(); ?>
			<?php if ( $demo_lock_data['lock_count'] == 0 ) : ?>
			<img src="<?php echo $happy_monitor_folder; ?>/img/check_icon_green_big.jpg" alt="정상" title="정상">
			<?php else : ?>
			<img src="<?php echo $happy_monitor_folder; ?>/img/check_icon_red_big.jpg" alt="비정상" title="비정상">
			<?php endif; ?>
		</div>

		<div><img src="<?php echo $happy_monitor_folder; ?>/img/btn_monitor_01.jpg" alt="자세히보기" title="자세히보기" border="0" onClick="window.open('<?php echo $happy_monitor_folder; ?>/check_demo_lock_popup.php','popup_demo_lock_list','width=500,height=400,scrollbars=yes');" style="cursor:pointer;"></div>
	</td>


	<td align="center" valign="top" style="padding:20px 0; border-right:1px solid #f0f0f0; width:280px;">
		<div class="font_16 font_malgun" align="center" style="height:25px;"><strong>파일 및 폴더쓰기 권한</strong></div>
		<div style="margin:15px 0; height:50px;">
			<table cellspacing="0" cellpadding="0" style="height:46px;">
				<tr>
					<td align="center"><span id="permission_check_layer"><img src="<?php echo $happy_monitor_folder; ?>/img/ajax_loading.gif" border="0" ></span></td>
				</tr>
			</table>
		</div>
		<div><img src="<?php echo $happy_monitor_folder; ?>/img/btn_monitor_01.jpg" alt="자세히보기" title="자세히보기" border="0" onClick="window.open('<?php echo $happy_monitor_folder; ?>/check_permission.php?mode=get_list','popup_permission_list','width=510,height=700,scrollbars=yes');" style="cursor:pointer;"></div>
	</td>

	<td align="center" valign="top" style="padding:20px 0;">
		<div class="font_16 font_malgun" align="center" style="height:25px;"><strong>서버부하</strong></div>
		<div style="margin:15px 0; height:50px;">
			<table cellspacing="0" cellpadding="0" style="height:46px;">
				<tr>
					<td class="font_gulim font_12" ><strong>정<br/>체</strong></td>
					<td style="width:215px; padding:0 3px;" align="center"><span id="load_time_check_layer"><img src="<?php echo $happy_monitor_folder; ?>/img/ajax_loading.gif" border="0"></span></td>
					<td class="font_gulim font_12"><strong>원<br/>활</strong></td>
				</tr>
			</table>
		</div>
		<div><img src="<?php echo $happy_monitor_folder; ?>/img/btn_monitor_01.jpg" alt="자세히보기" title="자세히보기" border="0" onClick="window.open('<?php echo $happy_monitor_folder; ?>/check_load_time_popup.php','popup_load_time','width=600,height=400,scrollbars=yes');" style="cursor:pointer;"><img src="<?php echo $happy_monitor_folder; ?>/img/btn_monitor_03.jpg" alt="재점검하기" title="재점검하기" id="load_time_check_btn" style="cursor:pointer; margin-left:3px;"></div>
	</td>
</tr>
</table>


<table cellspacing="0" cellpadding="0" style="width:1000px; background:#fdfdfd; border:1px solid #f0f0f0; margin-top:20px;">
<tr>
	<td align="center" valign="top" style="padding:20px 0; border-right:1px solid #f0f0f0; width:280px;">
		<div>
			<table cellspacing="0" cellpadding="0">
			<tr>
				<td class="font_16 font_malgun" align="center" style="height:25px;"><strong>솔루션 용량</strong></td>
				<td><img src="<?php echo $happy_monitor_folder; ?>/img/btn_monitor_09.jpg" alt="자세히보기" title="자세히보기" border="0" onClick="window.open('<?php echo $happy_monitor_folder; ?>/check_volume_popup.php','popup_volume','width=580,height=700,scrollbars=yes');" style="cursor:pointer; margin-left:10px;"><img src="<?php echo $happy_monitor_folder; ?>/img/btn_monitor_02.jpg" alt="재점검" title="재점검" id="solution_volume_btn" style="cursor:pointer; margin-left:3px;"></td>
			</tr>
			</table>
		</div>
		<div style="margin:15px 0; height:50px;">
			<table cellspacing="0" cellpadding="0">
			<tr>
				<td align="center">
					<span id="empty_volume_layer1">
					<?php if ( $MONITOR_CONFIG['check_volume_is_empty'] == "y" ) : ?>
					<img src="<?php echo $happy_monitor_folder; ?>/img/check_icon_green_big.jpg" alt="정상" title="정상">
					<?php else : ?>
					<img src="<?php echo $happy_monitor_folder; ?>/img/check_icon_red_big.jpg" alt="비정상" title="비정상">
					<?php endif; ?>
					</span>
				</td>
			</tr>
			</table>
		</div>

		<div style="margin-left:20px;">
			<p class="font_11 font_dotum" align="left" style="margin:3px 0;">현재용량 : <strong><span id="solution_volume_layer"><?php echo $MONITOR_CONFIG['check_volume_last_value']; ?></span></strong></p>
			<p class="font_11 font_dotum" align="left" style="margin:3px 0;">여유공간 :
			<strong>
			<span id="empty_volume_layer2">
			<?php if ( $MONITOR_CONFIG['check_volume_is_empty'] == "y" ) : ?>
			<span style='color:#ff0000;'><?php echo $MONITOR_CONFIG['volume_check_limit_byte']; ?> MB</span> 이상
			<?php else : ?>
			<span style='color:#ff0000;'><?php echo number_format($MONITOR_CONFIG['check_volume_empty_size']); ?> MB</span> 남음
			<?php endif; ?>
			</span>
			</strong>
			</p>
			<p class="font_11 font_dotum" align="left" style="margin:3px 0;">점검일시 : <strong><span id="check_volume_last_update_layer"><?php echo $MONITOR_CONFIG['check_volume_last_update']; ?></span></strong></p>
		</div>
	</td>

	<td align="center" valign="top" style="padding:20px 0; border-right:1px solid #f0f0f0; width:280px;">
		<div class="font_16 font_malgun" align="center" style="height:25px; padding-top:4px;"><strong>메일 발송기능 점검결과</strong></div>
		<div style="margin:15px 0; height:50px;">

			<?php if ( $MONITOR_CONFIG['check_send_mail'] == "ok" ) : ?>
			<img src="<?php echo $happy_monitor_folder; ?>/img/check_icon_green_big.jpg" alt="정상" title="정상">
			<?php else : ?>
			<img src="<?php echo $happy_monitor_folder; ?>/img/check_icon_red_big.jpg" alt="비정상" title="비정상">
			<?php endif; ?>

		</div>
		<div class="font_11 font_dotum">점검일시 : <strong><?php echo $MONITOR_CONFIG['check_send_mail_date']; ?></strong></div>
	</td>



	<td align="center" valign="top" style="padding:20px 0;">
		<div class="font_16 font_malgun" align="center" style="height:25px;  padding-top:4px;"><strong>메일 발송기능 점검</strong></div>
		<div style="margin:23px 0 22px 0; ">
			<form action="?mode=send_mail" method="post" onSubmit="if ( !confirm('테스트 메일을 발송하시겠습니까?') ) { return false; }" style="padding:0px; margin:0px;">
			<table cellspacing="0" cellpadding="0">
			<tr>
				<td><input type="text" name="to_mail" value="<?php echo $MONITOR_CONFIG['check_send_mail_addr']; ?>" style="border:1px solid #d1d1d1; height:33px; line-height:31px; width:230px; padding-left:4px;"></td>
				<td style="padding-left:4px;"><input type="image" src="<?php echo $happy_monitor_folder; ?>/img/btn_monitor_04.jpg" value="메일 발송"></td>
			</tr>
			</table>
			</form>
		</div>
		<div class="font_11 font_dotum"style="color:#9c9c9c;">발송점검에 사용할 수신용 메일주소를 입력 후 발송버튼을 클릭하세요.</div>
	</td>
</tr>
</table>



<table cellspacing="0" cellpadding="0" style="width:1000px; margin-top:50px;">
<tr>
	<td style="border-bottom:2px solid #383d4a; padding-bottom:10px;">
		<table cellspacing="0" cellpadding="0" style="width:100%; height:25px;">
		<tr>
			<td class="font_16 font_malgun" style="width:140px;"><strong>솔루션 기능점검</strong></td>
			<td><img src="<?php echo $happy_monitor_folder; ?>/img/btn_monitor_03.jpg" alt="재점검하기" title="재점검하기" id="solution_check_btn" style="cursor:pointer;"></td>
			<td align="right"class="font_11 font_dotum">점검일시 : <strong><span id="solution_check_date"><?php echo $MONITOR_CONFIG['check_solution_date']; ?></strong></td>
		</tr>
		</table>
	</td>
</tr>


<tr>
	<td style="padding-top:10px;">
		<table cellspacing="0" cellpadding="0" style="width:100%; border-top:1px solid #dddde1;">
		<tr>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim"><strong>점검 항목</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:190px;"><strong>점검결과</strong></td>
		</tr>
		</table>

		<div id="solution_check_layer" align="center">
			<table cellspacing="0" cellpadding="0" style="width:100%;">
			<?php foreach ( $CHECK_API_CONFIG as $type => $conf_array ) : ?>
				<?php if ( isset($MONITOR_CONFIG['check_'.$type]) ) : ?>
				<tr>
					<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" style="text-align:left;">
						<strong><?php echo $conf_array['title']; ?></strong>
						<br>
						<span class="font_11 font_dotum" style="color:#a0a0a0;"><?php echo $conf_array['explain']; ?></span>
					</td>
					<td class="info_td_content line-bottom_st_02" style="text-align:center; width:170px;">

						<?php if ( $MONITOR_CONFIG['check_'.$type] == "ok" ) : ?>
						<img src="<?php echo $happy_monitor_folder; ?>/img/check_icon_green.jpg" alt="정상" title="정상">
						<?php else : ?>
						<img src="<?php echo $happy_monitor_folder; ?>/img/check_icon_red.jpg" alt="비정상" title="비정상">
						<?php endif; ?>

					</td>
				</tr>
				<?php endif; ?>
			<?php endforeach; ?>
			</table>
		</div>
	</td>
</tr>
</table>



<?php $condition_data	= happy_condition_data(); ?>

<table cellspacing="0" cellpadding="0" style="width:1000px; margin-top:50px;">
<tr>
	<td style="border-bottom:2px solid #383d4a; padding-bottom:10px;">
		<table cellspacing="0" cellpadding="0" style="width:100%;">
			<tr>
				<td class="font_16 font_malgun"><strong>사이트 운영현황</strong></td>
				<td align="right"><a href="<?php echo $happy_monitor_folder; ?>/check_image_print.php" target="_blank"><img src="<?php echo $happy_monitor_folder; ?>/img/btn_monitor_05.jpg" alt="이미지출력테스트" title="이미지출력테스트" border="0"></a></td>
			</tr>
		</table>
	</td>
</tr>


<tr>
	<td style="padding-top:10px;">
		<table cellspacing="0" cellpadding="0" style="width:100%; border-top:1px solid #dddde1;">
		<tr>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" align="center"><strong>운영 항목</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:240px;" align="center"><strong>달성 / 목표</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:90px;" align="center"><strong>달성률</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:160px;" align="center"><strong>조회기간</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:190px;" align="center"><strong>운영현황</strong></td>
		</tr>

		<?php foreach ( $condition_data as $now_data ) : ?>
		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" >
				<strong><?php echo $now_data['title']; ?></strong>
			</td>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" align="center">
				<strong><?php echo number_format($now_data['check_value']).$now_data['unit']; ?> / <?php echo number_format($now_data['target']).$now_data['unit']; ?></strong>
			</td>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" align="center">
				<strong style="color:#ff0000;"><?php echo round($now_data['check_percent']); ?>%</strong>
			</td>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" align="center" style="line-height:19px;">
				<p style="margin:0px; padding:0px;"><strong><?php echo $now_data['check_day']; ?> 일</strong></p>
				<p style="line-height:13px; color:#a1a1a1; margin:10px 0 0 0; padding:0px;" class="font_11 font_dotum"><?php echo $now_data['start_date']; ?><br/>~<br/><?php echo date("Y-m-d H:i:s"); ?></p>
			</td>

			<td class="info_td_content line-bottom_st_02" align="center">
				<img src="../<?php echo $now_data['level']['icon']; ?>" title="<?php echo $now_data['level']['title']; ?>" alt="<?php echo $now_data['level']['title']; ?>" border="0">
			</td>
		</tr>
		<?php endforeach; ?>
		</table>
	</td>
</tr>
</table>


<table cellspacing="0" cellpadding="0" style="width:1000px; margin:20px 0 30px 0;">
	<tr>
		<td align="center" style="padding-bottom:20px;"><img src="<?php echo $happy_monitor_folder; ?>/img/btn_monitor_06.jpg" alt="사이트 모니터링 설정페이지로" title="트 모니터링 설정페이지로" onClick="window.location.href='?type=setting';" style="cursor:pointer;"></td>
	</tr>
	<!--<tr>
		<td align="center" class="font_12 font_gulim">Query Time : <?php echo round(array_sum(explode(' ', microtime())) - $t_start,2); ?> sec</td>
	</tr>-->
</table>
