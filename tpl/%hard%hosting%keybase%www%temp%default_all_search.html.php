<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:13 */
function SkyTpl_Func_518853792 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

<!-- 사이트 타이틀 -->
<title><?=$_data['site_name2']?> <?=$_data['master_msg']?></title>

<meta name="Generator" content="EditPlus">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">

<?=$_data['webfont_js']?>


<!-- 파비콘 지정-->
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/common.css?ver=<?=$_data['css_make_date']?>">
<link rel="stylesheet" type="text/css" href="css/style.css?ver=<?=$_data['css_make_date']?>">

<script src="js/happy_job.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script src="js/flash.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script src="js/skin_tab.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script src="js/default.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script language='JavaScript' src='js/glm-ajax.js?ver=<?=$_data['js_make_date']?>'></SCRIPT>
<script language='JavaScript' src='js/select_ajax.js?ver=<?=$_data['js_make_date']?>'></script>
<script language='JavaScript' src='js/jquery-1.9.1.min.js?ver=<?=$_data['js_make_date']?>'></script>
<script language="javascript" type="text/javascript" src="js/happy_function.js?ver=<?=$_data['js_make_date']?>"></script>

<?call_popup('서브페이지','#F1F1F1','랜덤') ?>


<!--구글통계-->
<?=$_data['google_login_track']?>


<!--상단메뉴 스크롤고정 스크립트 시작-->
<script>
$(function(){
	$(window).scroll(function(e) {
        var sctop = $(window).scrollTop();
		var topHDbanner = $("#display_n").css?ver=<?=$_data['css_make_date']?>("margin-top");

		/*if(topHDbanner == "100px"){
			var hdtopbannerok = "no";
		}else*/

		{
			var hdtopbannerok = "ok";
		}

		if(sctop>230 && hdtopbannerok == "ok"){
			$(".scrollMoveBox3").css({
				"position":"fixed",
				"top":"100px",
				"left":"0",
				"width":"100%",
				"height":"53px",
				"z-index":"260",
				"background":"#fcfcfc",
				"overflowh":"hidden"
				}
			);
			$(".scrollMoveBox3 .scrollMoveBox3_inner").css({
				"margin":"0 auto",
				"width":"1200px"
				}
			);
			$(".scrollMoveBox3 .Movebox_hidden").css({
				"display":"block"
				}
			);
			$(".scrollMoveBox_top").css({
				"display":"none"
				}
			);

		}else{
			$(".scrollMoveBox3").css({
				"position":"relative",
				"top":"0",
				"width":"100%",
				"height":"",
				"z-index":"100",
				"background":"#fcfcfc",
				"border-top":"1px solid #ddd",
				"border-bottom":"1px solid #ddd"
				}
			);
			$(".scrollMoveBox3 .Movebox_hidden").css({
				"display":"none"
				}
			);
			$(".scrollMoveBox_top").css({
				"display":"block"
				}
			);
		}
    });
});

$(document).ready(function(){

	var bottomBox			= $('#rank_container');

	$( window ).scroll( function() {

		var nowScrollHeight		= $(window).scrollTop() + $(window).height();
		var stopPosition		= $(document).height() - $('#footer').height();

		if ( nowScrollHeight >= stopPosition )
		{
			bottomBox.fadeOut(500);
		}
		else
		{
			bottomBox.fadeIn(500);
		}
	});
});
</script>
<!--상단메뉴 스크롤고정 스크립트 끝-->

<!-- 텝메뉴 고정 스크립트 -->
<script>
   $( document ).ready( function() {
        var jbOffset = $( '.scrollMoveBox2' ).offset();
        $( window ).scroll( function() {
          if ( $( document ).scrollTop() > jbOffset.top ) {
            $( '.scrollMoveBox2' ).addClass( 'all_sch_scrollfixed' );
			$( '.info_area' ).addClass( 'area_fixed' );
          }
          else {
            $( '.scrollMoveBox2' ).removeClass( 'all_sch_scrollfixed' );
			$( '.info_area' ).removeClass( 'area_fixed' );
          }
        });
      } );


</script>

<style>

/* 통합검색 스크롤 기본위치 선점 - js 소스 영향을 주기위한 소스 */
.all_sch_scrollfixed {width:230px; position:fixed !important; top:155px; z-index:280}
.area_fixed{margin-top:54px}
</style>

</head>

<body>
	<div id="wrap">
		<?include_template('my_view_right_scroll.html') ?>

		<div id="header">
			<?include_template('header.html') ?>

		</div>
		<div id="container">
			<div class="container_c" style="margin-top:20px">
				<div class="locate"><?=$_data['현재위치']?></div>
				<?=$_data['내용']?>

			</div>
		</div>
		<footer id="footer">
			<?include_template('in_bottom_copyright.html') ?>

		</footer>
	</div>
</body>
</html>
<?=$_data['cgialert']?><!--데모용소스-->
<?=$_data['쪽지레이어']?><!--쪽지레이어-->
<? }
?>