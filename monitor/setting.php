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

	$mode					= $_POST['mode'];

	if ( $mode == "setting_ok" )
	{
		if ( !$_POST )
		{
			error("설정 저장 오류!");
			exit;
		}

		foreach ( $_POST as $post_key => $post_value )
		{
			if ( $post_key == "x" || $post_key == "y" || $post_key == "mode" )
			{
				continue;
			}

			happy_monitor_config_save($post_key,trim($post_value));
		}

		go("?type=setting");
		exit;
	}
?>

<!-- 자바스크립트 파일 링크처리 -->
<script language="JavaScript" type="text/javascript" src="<?php echo $happy_monitor_folder; ?>/js/jquery.js"></script>


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

.input_st{border:1px solid #d1d1d1; height:33px; line-height:31px; padding-left:4px;}

</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_box_title">
<tr>
	<td width="27" style="padding:0 0 0 2px;"><img src="img/ico_arrow_01.gif" border="0"></td>
	<td class="item_title">사이트 모니터링 관련설정</td>
</tr>
</table>



<form method="post" id="conf_form">
<input type="hidden" name="mode" value="setting_ok">


<table cellspacing="0" cellpadding="0" style="width:1000px; background:#fdfdfd; border:1px solid #f0f0f0; margin-top:20px;">
<tr>
	<td align="left" valign="top" style="padding:20px 30px; width:300px;  border-right:1px solid #f0f0f0;">
		<div class="font_16 font_malgun" style="height:25px;"><strong>솔루션 용량 자동 업데이트 설정</strong></div>

		<div style="margin:15px 0; " >
			<table cellspacing="0" cellpadding="0">
			<tr>
				<td style="padding-right:15px;" class="font_12 font_gulim"><strong>사용여부</strong></td>
				<td>
					<input type="radio" name="volume_check_auto_update_use" id="volume_check_auto_update_use_y" value="y" <?php if ( $MONITOR_CONFIG['volume_check_auto_update_use'] == "y" ) { echo "checked"; } ?> style="vertical-align:middle; margin:-2px 0 1px;  cursor:pointer;"><label for="volume_check_auto_update_use_y" style="line-height:14px; height:14px;  cursor:pointer; color:#272727; letter-spacing:-1px;">사용함</label>
					<input type="radio" name="volume_check_auto_update_use" id="volume_check_auto_update_use_n" value="n" <?php if ( $MONITOR_CONFIG['volume_check_auto_update_use'] != "y" ) { echo "checked"; } ?> style="vertical-align:middle; margin:-2px 0 1px 20px;  cursor:pointer;"><label for="volume_check_auto_update_use_n" style="line-height:14px; height:14px;  cursor:pointer; color:#272727; letter-spacing:-1px;">사용안함</label>
				</td>
			</tr>
			</table>
		</div>

		<div style="margin:15px 0; " >
			<table cellspacing="0" cellpadding="0">

			<tr>
				<td style="padding-right:15px;" class="font_12 font_gulim"><strong>시간설정</strong></td>
				<td>
					<table cellspacing="0" cellpadding="0">
					<tr>
						<td><input type="text" name="volume_check_auto_update_term" value="<?php echo $MONITOR_CONFIG['volume_check_auto_update_term']; ?>" style="border:1px solid #d1d1d1; height:33px; line-height:31px; width:60px; padding-left:4px;"></td>
						<td class="font_12 font_gulim" style="padding-left:5px;">시간 (업데이트 주기)</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</div>
	</td>

	<td align="left" valign="top" style="padding:20px 30px;">
		<div class="font_16 font_malgun"style="height:25px;"><strong>웹하드 여유공간 체크 설정</strong></div>
		<div style="margin:15px 0; " >
			<table cellspacing="0" cellpadding="0">
			<tr>
				<td><input type="text" name="volume_check_limit_byte" value="<?php echo $MONITOR_CONFIG['volume_check_limit_byte']; ?>" style="border:1px solid #d1d1d1; height:33px; line-height:31px; width:180px; padding-left:4px;"></td>
				<td style="padding-left:5px;" class="font_12 font_gulim">MB / (기본값 50MB)</td>
			</tr>
			</table>
		</div>
		<div >
			<table cellspacing="0" cellpadding="0" style="width:100%;">
				<tr>
					<td class="font_11 font_dotum" style="color:#9c9c9c; line-height:16px;">* 설정한 용량만큼 임시파일을 생성하여 여유공간이 있는지 확인합니다.</td>
				</tr>
				<tr>
					<td class="font_11 font_dotum" style="color:#9c9c9c; padding-top:10px; line-height:16px;">* 체크 용량을 과도하게 설정할 경우 소요시간이 길어지거나, 해당 기능이 작동하지 않을 수 있습니다.</td>
				</tr>
			</table>
		</div>
	</td>



</tr>
</table>






<table cellspacing="0" cellpadding="0" style="width:1000px; margin-top:50px;">
<tr>
	<td style="border-bottom:2px solid #383d4a; padding-bottom:10px;" class="font_16 font_malgun"><strong>사이트 운영현황 설정</strong></td>
</tr>
<tr>
	<td style="padding-top:10px;">
		<table cellspacing="0" cellpadding="0" style="width:100%; border-top:1px solid #dddde1;">
		<tr>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" align="center"><strong>운영 항목</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:250px;" align="center"><strong>조회기간(금일기준)</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:250px;" align="center"><strong>목표값</strong></td>
		</tr>

		<?php foreach ( $CHECK_CONDITION_CONF['check_table'] as $now_conf ) : ?>
		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" >
				<strong><?php echo $now_conf['title']; ?></strong>
			</td>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" align="center">
				<table cellspacing="0" cellpadding="0" >
				<tr>
					<td><input type="text" name="<?php echo $now_conf['conf_name']; ?>_check_day" value="<?php echo $MONITOR_CONFIG[$now_conf['conf_name'].'_check_day']; ?>" class="input_st" style="width:100px"></td>
					<td style="padding-left:5px;" class="font_12 font_gulim">일</td>
				</tr>

				<tr>
					<td colspan="2" class="font_11 font_dotum" align="left" style="color:#9c9c9c; padding-top:5px;">기본값 : <strong><?php echo $now_conf['default_check_day']; ?>일</strong></td>
				</tr>
				</table>
			</td>


			<td class="info_td_content line-bottom_st_02" align="center">

				<table cellspacing="0" cellpadding="0" >
				<tr>
					<td><input type="text" name="<?php echo $now_conf['conf_name']; ?>_target" value="<?php echo $MONITOR_CONFIG[$now_conf['conf_name'].'_target']; ?>" class="input_st" style="width:150px"></td>
					<td style="padding-left:5px;" class="font_12 font_gulim"><?php echo $now_conf['unit']; ?></td>
				</tr>

				<tr>
					<td colspan="2" class="font_11 font_dotum" align="left" style="color:#9c9c9c; padding-top:5px;">기본값 : <strong style="color:#0f70e9;"><?php echo number_format($now_conf['default_target']); ?><?php echo $now_conf['unit']; ?></strong></td>
				</tr>
				</table>

			</td>
		</tr>
		<?php endforeach; ?>

		</table>
	</td>
</tr>
</table>





<table cellspacing="0" cellpadding="0" style="width:1000px; margin-top:50px;">
<tr>
	<td style="border-bottom:2px solid #383d4a; padding-bottom:10px;" class="font_16 font_malgun"><strong>서버부하 체크 설정</strong></td>
</tr>
<tr>
	<td style="padding-top:10px;">
		<table cellspacing="0" cellpadding="0" style="width:100%; border-top:1px solid #dddde1;">
		<tr>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" align="center"><strong>CPU 체크 항목</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:250px;" align="center"><strong>설정값</strong></td>
		</tr>

		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" >
				<strong>1회 반복시 연산 횟수</strong>
			</td>
			<td class="info_td_content line-bottom_st_02" align="center">
				<table cellspacing="0" cellpadding="0" >
				<tr>
					<td><input type="text" name="load_time_check_limit" value="<?php echo $MONITOR_CONFIG['load_time_check_limit']; ?>" class="input_st" style="width:150px"></td>
					<td style="padding-left:5px;" class="font_12 font_gulim">회</td>
				</tr>
				<tr>
					<td colspan="2" class="font_11 font_dotum" align="left" style="color:#9c9c9c; padding-top:5px;">기본값 : <strong style="color:#0f70e9;"><?php echo number_format($DEFAULT_SETTING_VALUE['load_time_check_limit']); ?>회</strong></td>
				</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" >
				<strong>연산 반복 횟수</strong>
			</td>
			<td class="info_td_content line-bottom_st_02" align="center">
				<table cellspacing="0" cellpadding="0" >
				<tr>
					<td><input type="text" name="load_time_check_repeat" value="<?php echo $MONITOR_CONFIG['load_time_check_repeat']; ?>" class="input_st" style="width:150px"></td>
					<td style="padding-left:5px;" class="font_12 font_gulim">회</td>
				</tr>
				<tr>
					<td colspan="2" class="font_11 font_dotum" align="left" style="color:#9c9c9c; padding-top:5px;">기본값 : <strong style="color:#0f70e9;"><?php echo number_format($DEFAULT_SETTING_VALUE['load_time_check_repeat']); ?>회</strong></td>
				</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" >
				<strong>체크 범위 시작<br>(가장 빠른 속도)</strong>
			</td>
			<td class="info_td_content line-bottom_st_02" align="center">
				<table cellspacing="0" cellpadding="0" >
				<tr>
					<td><input type="text" name="load_time_average_start" value="<?php echo $MONITOR_CONFIG['load_time_average_start']; ?>" class="input_st" style="width:150px"></td>
					<td style="padding-left:5px;" class="font_12 font_gulim">초</td>
				</tr>
				<tr>
					<td colspan="2" class="font_11 font_dotum" align="left" style="color:#9c9c9c; padding-top:5px;">기본값 : <strong style="color:#0f70e9;"><?php echo $DEFAULT_SETTING_VALUE['load_time_average_start']; ?>초</strong></td>
				</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" >
				<strong>체크 범위 끝<br>(가장 느린 속도)</strong>
			</td>
			<td class="info_td_content line-bottom_st_02" align="center">
				<table cellspacing="0" cellpadding="0" >
				<tr>
					<td><input type="text" name="load_time_average_end" value="<?php echo $MONITOR_CONFIG['load_time_average_end']; ?>" class="input_st" style="width:150px"></td>
					<td style="padding-left:5px;" class="font_12 font_gulim">초</td>
				</tr>
				<tr>
					<td colspan="2" class="font_11 font_dotum" align="left" style="color:#9c9c9c; padding-top:5px;">기본값 : <strong style="color:#0f70e9;"><?php echo $DEFAULT_SETTING_VALUE['load_time_average_end']; ?>초</strong></td>
				</tr>
				</table>
			</td>
		</tr>

		</table>

		<table cellspacing="0" cellpadding="0" style="width:100%; border-top:1px solid #dddde1; margin-top:10px;">
		<tr>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" align="center"><strong>MySQL 접속 체크 항목</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:250px;" align="center"><strong>설정값</strong></td>
		</tr>

		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim">
				<strong>접속 반복 횟수</strong>
			</td>
			<td class="info_td_content line-bottom_st_02" align="center">
				<table cellspacing="0" cellpadding="0" >
				<tr>
					<td><input type="text" name="load_time_check_repeat_db" value="<?php echo $MONITOR_CONFIG['load_time_check_repeat_db']; ?>" class="input_st" style="width:150px"></td>
					<td style="padding-left:5px;" class="font_12 font_gulim">회</td>
				</tr>
				<tr>
					<td colspan="2" class="font_11 font_dotum" align="left" style="color:#9c9c9c; padding-top:5px;">기본값 : <strong style="color:#0f70e9;"><?php echo number_format($DEFAULT_SETTING_VALUE['load_time_check_repeat_db']); ?>회</strong></td>
				</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" >
				<strong>체크 범위 시작<br>(가장 빠른 속도)</strong>
			</td>
			<td class="info_td_content line-bottom_st_02" align="center">
				<table cellspacing="0" cellpadding="0" >
				<tr>
					<td><input type="text" name="load_time_average_start_db" value="<?php echo $MONITOR_CONFIG['load_time_average_start_db']; ?>" class="input_st" style="width:150px"></td>
					<td style="padding-left:5px;" class="font_12 font_gulim">초</td>
				</tr>
				<tr>
					<td colspan="2" class="font_11 font_dotum" align="left" style="color:#9c9c9c; padding-top:5px;">기본값 : <strong style="color:#0f70e9;"><?php echo $DEFAULT_SETTING_VALUE['load_time_average_start_db']; ?>초</strong></td>
				</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" >
				<strong>체크 범위 끝<br>(가장 느린 속도)</strong>
			</td>
			<td class="info_td_content line-bottom_st_02" align="center">
				<table cellspacing="0" cellpadding="0" >
				<tr>
					<td><input type="text" name="load_time_average_end_db" value="<?php echo $MONITOR_CONFIG['load_time_average_end_db']; ?>" class="input_st" style="width:150px"></td>
					<td style="padding-left:5px;" class="font_12 font_gulim">초</td>
				</tr>
				<tr>
					<td colspan="2" class="font_11 font_dotum" align="left" style="color:#9c9c9c; padding-top:5px;">기본값 : <strong style="color:#0f70e9;"><?php echo $DEFAULT_SETTING_VALUE['load_time_average_end_db']; ?>초</strong></td>
				</tr>
				</table>
			</td>
		</tr>


		</table>
	</td>
</tr>
</table>


<table cellspacing="0" cellpadding="0" style="width:1000px; margin-top:10px; background:#f1f7fd; border-top:1px solid #c9d1da; border-bottom:1px solid #c9d1da; ">
<tr>
	<td style="color:#576484; padding:15px;" class="font_12 font_gulim">
		<p style="padding:0px; margin:0 0 10px 0;"><strong style="color:#576484;">서버부하 체크 안내</strong></p>
		<p style="padding:0px; margin:0 0 7px 0; color:#576484;">CPU 평균 속도 = (1회 반복시 연산 횟수)의 소요시간 x (연산 반복 횟수) / (연산 반복 횟수)</p>
		<p style="padding:0px; margin:0 0 7px 0; color:#576484;">CPU 평균 속도는 임의의 연산을 실행한 후 평균적인 속도를 계산합니다.</p>
		<p style="padding:0px; margin:0 0 7px 0; color:#576484;">MySQL 접속 평균 속도 = MySQL 접속 소요시간 x (접속 반복 횟수) / (접속 반복 횟수)</p>
		<p style="padding:0px; margin:0; color:#576484;">계산된 평균 속도를 이용하여 속도 체크 범위내에서 현재 서버의 속도를 비교합니다.</p>

	</td>
</tr>
</table>



<table cellspacing="0" cellpadding="0" style="width:1000px; margin:20px 0 30px 0;">
<tr>
	<td align="center">
		<table cellspacing="0" cellpadding="0">
		<tr>
			<td><input type="image" src="<?php echo $happy_monitor_folder; ?>/img/btn_monitor_08.jpg" value="설정저장"></td>
			<td style="padding-left:3px;"><img src="<?php echo $happy_monitor_folder; ?>/img/btn_monitor_07.jpg" alt="사이트 모니터링 페이지로" title="사이트 모니터링 페이지로" onClick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>';" style="cursor:pointer;"></td>
		</tr>
		</table>
	</td>
</tr>
</table>






</form>