<? /* Created by SkyTemplate v1.1.0 on 2023/03/29 17:23:29 */
function SkyTpl_Func_1841886286 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!-- 카카오스토리 링크 -->
<script type="text/javascript" src="js/kakao.link.js"></script>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script type="text/javascript">
function executeKakaoStoryLink()
{
    kakao.link("story").send({
        post : "<?=$_data['main_url']?>/guin_detail.php?num=<?=$_data['DETAIL']['number']?>",
        appid : document.domain,
        appver : "1.0",
        appname : "<?=$_data['site_name1']?>",
        urlinfo : JSON.stringify({title:"<?=$_data['DETAIL']['guin_title']?>", desc:"<?=$_data['상세설명_카카오스토리']?>", imageurl:["<?=$_data['kakao_story_img']?>"], type:"article"})
    });
}
</script>
<!-- 카카오스토리 링크 -->
<script>
	$(document).ready(function(){

		var bottomBox			= $('#guin_detail_view_container');

		$( window ).scroll( function() {

			if ( $("#guin_detail_view_close_val").val() == "close" )
			{
				return;
			}

			var nowScrollHeight		= $(window).scrollTop() + $(window).height();
			var stopPosition		= $(document).height() - $('#in_bottom_copyright').height();

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

	function guin_detail_view_close()
	{
		var bottomBox			= $('#guin_detail_view_container');
		bottomBox.fadeOut(500);

		$("#guin_detail_view_close_val").val("close");
	}
</script>
<style type="text/css">
	.sub_tab_menu03 > ul > li.tab_on1{border-top:4px solid #<?=$_data['배경색']['모바일_기본색상']?>;}
	.guin_d_top_info_wrap > a{background:#<?=$_data['배경색']['모바일_기본색상']?>;}
	.info_txt_box > li > .list_type01 > span{color:inherit !important;}
</style>
<div id="guin_detail_view_container" style=" width:100%; left:0; bottom:0; position:fixed;  z-index:999; background:#<?=$_data['배경색']['모바일_상단메뉴']?>">
	<div style="margin:0 auto; height:75px; position:relative; text-align:center">
		<span class="font_16 noto500" style="letter-spacing:-1.5px; color:#fff">
			최근 <strong style="font-weight:400;line-height:75px; "><?=$_data['HAPPY_CONFIG']['guin_detail_view_time']?></strong>시간 동안 <strong style="font-weight:400;"><?=$_data['DETAIL']['guin_detail_view']?></strong>명이 초빙정보를 열람했습니다.
		</span>
		<span style="position:absolute; right:10px; top:-20px">
			<a href="javascript:void(0);" onClick="guin_detail_view_close()" title="창닫기">
				<img src="./img/close_ico2.png"  alt="닫기" style="width:15px; height:15px;">
			</a>
		</span>
		<input type="hidden" id="guin_detail_view_close_val" value="">
	</div>
</div>
<div class="sub_wrap">
	<h3 class="sub_tlt_st01">
		<span>초빙정보 상세보기</span>
	</h3>
	<div class="guin_d_top_info_wrap">
		<div class="guin_d_top_info">
			<div>
				<span style="color:#<?=$_data['배경색']['모바일_기본색상']?>;"><?=$_data['DETAIL']['guin_com_name']?></span>
					<!-- ul>
				<li>
						<a href="javascript:void(0);" onclick="executeKakaoStoryLink()"><img src="mobile_img/icon_kakaostory.png" alt="카카오스토리" title="카카오스토리" style="cursor:pointer; width:20px; height:20px; vertical-align:middle"></a>
					</li>
					<li><?=$_data['tweeter_url']?></li>
					<li><?=$_data['facebook_url']?></li>
					<li><?echo kakaotalk_link('mobile_img/icon_kakaotalk.png','20','20') ?></li>
					<li><?=$_data['naverBand']?></li>
					<li class="guin_d_top_scrap"><?=$_data['스크랩버튼']?></li>
				</ul>			 -->	
			</div>
			<h4><?=$_data['DETAIL']['guin_title']?></h4>			
			<p>
				<strong class="dating_for_dday" style="border:1px solid #<?=$_data['배경색']['모바일_서브색상']?>; "><?=$_data['접수마감카운터2']?></strong>
				<?=$_data['DETAIL']['area']?>

				<span><?=$_data['DETAIL']['guin_career_temp']?></span>
				<span><?=$_data['DETAIL']['guin_edu']?></span>
				<span><?=$_data['DETAIL']['guin_type']?></span>
			</p>			
		</div>
		<?=$_data['온라인입사지원버튼_모바일']?>

	</div>
	<div class="sub_tab_menu03">
		<ul>
			<li class="tab_on1" id="class_div1" onclick="TabChange_class('class','class_div','1','1');">초빙 정보</li>
			<li class="tab_off1" id="class_div2" onclick="TabChange_class('class','class_div','2','1');">기관 정보</li>
		</ul>
	</div>
	<div class="guin_d_content_wrap">		
		<?include_template('guin_detail_info1.html') ?> 
		<?include_template('guin_detail_info2.html') ?>

	</div>
</div>
	
<div><?=$_data['온라인입사지원폼']?></div>

<? }
?>