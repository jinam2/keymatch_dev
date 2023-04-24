<?
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;

	$fit_always			= 0;
	$get_width			= 0;
	$get_height			= 0;

	if ( preg_match("/MSIE 6.0/",$_SERVER['HTTP_USER_AGENT']) )
	{
		$fit_always			= 1;
		$get_width			= $_GET['width'];
		$get_height			= $_GET['height'];
	}

	$_GET['speed']			= intval($_GET['speed']);
	$_GET['interval']		= intval($_GET['interval']);
	$_GET['link_target']	= intval($_GET['link_target']);
	$_GET['auto_play']		= intval($_GET['auto_play']);

	#추가설정
	$stop_loop			= 0;	// 무한반복 0 / 한번만 1
	$transition			= 6;	// 방향 : 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left

	$output				= "
		<script type='text/javascript'>

			jQuery(function($){

				$.supersized({

					// Functionality
					slideshow               :   1,				// Slideshow on/off
					autoplay				:	$_GET[auto_play],// Slideshow starts playing automatically
					start_slide             :   1,				// Start slide (0 is random)
					stop_loop				:	$stop_loop,		// Pauses slideshow on last slide
					random					: 	0,				// Randomize slide order (Ignores start slide)
					slide_interval          :   $_GET[interval],		// Length between transitions
					transition              :   $transition, // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
					transition_speed		:	$_GET[speed],			// Speed of transition
					new_window				:	$_GET[link_target],	// Image links open in new window/tab
					pause_hover             :   1,				// Pause slideshow on hover
					keyboard_nav            :   1,				// Keyboard navigation on/off
					performance				:	3,				// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
					image_protect			:	1,				// Disables image dragging and right click with Javascript

					// Size & Position
					min_width		        :   $get_width,		// Min width allowed (in pixels)
					min_height		        :   $get_height,	// Min height allowed (in pixels)
					vertical_center         :   1,				// Vertically center background
					horizontal_center       :   1,				// Horizontally center background
					fit_always				:	$fit_always,	// Image will never exceed browser width or height (Ignores min. dimensions)
					fit_portrait         	:   1,				// Portrait images will not exceed browser height
					fit_landscape			:   0,				// Landscape images will not exceed browser width

					// Components
					slide_links				:	'blank',		// Individual links for each slide (Options: false, 'num', 'name', 'blank')
					thumb_links				:	1,				// Individual thumb links for each slide
					thumbnail_navigation    :   0,				// Thumbnail navigation
					slides 					:  	[				// Slideshow Images
	";

	$Arr_domain_ext		= Array(".com",".kr",".co.kr",".net",".org",".or.kr",".biz",".info",".tv",".co",".cc",".asia",".cn",".tw",".in",".pe.kr",".me",".name",".so ");

	$group_name			= urldecode($_GET['group_name']);

	switch ( $_GET['orderby'] )
	{
		case 'rand'		: $ORDER_BY		= "ORDER BY rand()";		break;
		case 'asc'		: $ORDER_BY		= "ORDER BY number ASC";	break;
		case 'desc'		: $ORDER_BY		= "ORDER BY number DESC";	break;
		default			: $ORDER_BY		= "";						break;
	}

	$Sql				= "
							SELECT
									*
							FROM
									$happy_banner_tb
							WHERE
									groupid		= '$group_name'
									AND
									mode		= 'image'
									AND
									display		= 'Y'
									AND
									( now() between startdate AND enddate )
							$ORDER_BY
						";
	$Result				= query($Sql);
	$TotalCount			= mysql_num_rows($Result);

	$BannerCount		= 1;

	$date			= date("Y-m-d");
	$nTime			= date("H");
	$dates			= explode("-",$date);

	while ( $BANNER = happy_mysql_fetch_array($Result) )
	{
		if($TotalCount > $BannerCount)
		{
			$comma			= ",";
		}
		else
		{
			$comma			= "";
		}

		$BANNER['link']		= trim($BANNER['link']);

		if ( $BANNER["link"] != "" )
		{
			$BANNER["link"]  = "banner_link.php?number=".$BANNER['number'];
		}

		$output			.= "{image : '$BANNER[img]', title : '$BANNER[title]', thumb : '$BANNER[img]', url : '$BANNER[link]'}$comma";

		#로그쌓기
		$number			= $BANNER['number'];
		$group			= $BANNER['groupid'];

		$Sql			= "SELECT count(number) FROM $happy_banner_log_tb WHERE regdate='$date' AND nTime='$nTime' AND bannerID = '$number'";
		$Tmp			= happy_mysql_fetch_array(query($Sql));

		if ( $Tmp[0] == 0 )
		{
			$Sql	= "
						INSERT INTO
								$happy_banner_log_tb
						SET
								bannerID	= '$number',
								groupID		= '$group',
								regdate		= '$date',
								year		= '$dates[0]',
								month		= '$dates[1]',
								day			= '$dates[2]',
								nTime		= '$nTime',
								viewcount	= '1',
								linkcount	= '0'
			";
		}
		else
		{
			$Sql	= "
						UPDATE
								$happy_banner_log_tb
						SET
								viewcount	= viewcount + 1
						WHERE
								regdate		= '$date'
								AND
								nTime		= '$nTime'
								AND
								bannerID	= '$number'
			";
		}
		query($Sql);

		#해당배너 정보 업그레이드
		query("UPDATE $happy_banner_tb SET viewcount=viewcount+1, viewdate=now() WHERE number='$number'");

		$BannerCount++;
	}

	$output			.= "
					],

					// Theme Options
					progress_bar			:	1,			// Timer for each slide
					mouse_scrub				:	0
				});
			});

		</script>

		<!--Arrow Navigation-->
		<a id='prevslide' class='load-item' style='cursor:pointer;'><img src='img/banner_scroll/back.png' class='png24' height='33' width='22'></a>
		<a id='nextslide' class='load-item' style='cursor:pointer;'><img src='img/banner_scroll/forward.png' class='png24' height='33' width='22'></a>

		<div id='thumb-tray' class='load-item'>
			<div id='thumb-back'></div>
			<div id='thumb-forward'></div>
		</div>

		<!--Control Bar-->
		<div id='controls-wrapper' class='load-item'>
			<div id='controls'>

				<!--Navigation-->
				<ul id='slide-list'></ul>

			</div>
		</div>
	";

	if( $TotalCount == 0 )
	{
		$output			= "";
	}

	$배너출력부분	= $output;

	if( !(is_file("$skin_folder/happy_banner_scroll.html")) ) {
		print "배너스크롤출력 $skin_folder/happy_banner_scroll.html 파일이 존재하지 않습니다. <br>";
		return;
	}

	$TPL->define("배너스크롤출력", "$skin_folder/happy_banner_scroll.html");
	$content = &$TPL->fetch();

	echo $content;

?>