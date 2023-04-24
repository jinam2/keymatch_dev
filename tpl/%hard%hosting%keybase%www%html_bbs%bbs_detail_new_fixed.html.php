<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 15:47:03 */
function SkyTpl_Func_52439777 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="width:<?=$_data['B_CONF']['table_size']?>;">

	<!-- 게시판상단 -->
	<div><?=$_data['게시판상단']?></div>
	<!-- 게시판상단 -->

	<!-- 제목 -->
	<div class="font_26 noto400" style="color:#222222; padding-top:30px; border-top:1px solid <?=$_data['B_CONF']['bar_color']?>;">
		<span class="bbs_cate"><?=$_data['BOARD']['b_category']?></span><span style="color:<?=$_data['B_CONF']['down_color']?>;"><?=$_data['BOARD']['bbs_title']?></span>
	</div>
	<!-- 제목 -->

	<!-- 글쓴이 날짜 -->
	<div class="noto400 font_15 bbs_rows_date" style="padding:30px 0px; border-bottom:1px solid <?=$_data['B_CONF']['body_color']?>;">
		<span class="bbs_rows_by">BY <?=$_data['BOARD']['bbs_name']?></span><span class="bbs_gubun_line"></span><span class="bbs_rows_date"><?=$_data['BOARD']['bbs_date']?></span>
	</div>
	<!-- 글쓴이 날짜 -->

	<!-- 상세카운트정보 sns 글자크기 -->
	<div style="margin-top:30px;">
		<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
		<tr>
			<td>
				<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><span class="bbs_cw_detail bbs_cw_detail_icon noto400" uk-icon="icon:heart; ratio:1" alt="추천수" title="추천수"><?=$_data['BOARD']['bbs_etc4']?></span><span class="bbs_cw_detail bbs_cw_detail_icon noto400" uk-icon="icon:eye; ratio:1" alt="조회수" title="조회수"><?=$_data['BOARD']['bbs_count']?></span><span class="bbs_cw_detail bbs_cw_detail_icon noto400" uk-icon="icon:more; ratio:1" alt="댓글수" title="댓글수"><?=$_data['BOARD']['bbs_etc2']?></span></td>
					<td>
						<span class="h_form"><a href="javascript:void(0);" uk-icon="icon:social; ratio:1" onClick="view_layer('bbs_sns_layer');" class="h_btn_circle" alt="공유하기" title="공유하기"></a></span>
						<?include_template('bbs_detail_sns_layer_fixed.html') ?>

					</td>
				</tr>
				</table>
			</td>
			<td align="right" class="h_form">
				<a href="javascript:changesize('-');" uk-icon="icon:minus; ratio:1" class="h_btn_circle" alt="글자작게" title="글자작게"></a><a href="javascript:changesize('+')" uk-icon="icon:plus; ratio:1" style="margin-left:10px;" class="h_btn_circle" alt="글자크게" title="글자크게"></a>
			</td>
		</tr>
		</table>
	</div>
	<!-- 상세카운트정보 sns 글자크기 -->

	<!-- 본문 -->
	<div style="background:<?=$_data['B_CONF']['detail_color']?>; margin-top:60px;">
		<div class="h_form bbs_attach_file"><?=$_data['BOARD']['attach']?></div>
		<div style="clear:both;"></div>
		<div><?=$_data['BOARD']['img_auto']?></div>
		<div id="ct"><?=$_data['BOARD']['bbs_review']?></div>
		<div style="padding-top:20px; text-align:left; color:#999999; line-height:19px;">
			Copyright(c) <strong><?=$_data['site_name']?></strong> 무단전재 및 재배포를 금지합니다.
		</div>
	</div>
	<!-- 본문 -->

	<!-- 댓글 -->
<div id='reply_table' style="<?=$_data['댓글_display']?> border-top:1px solid <?=$_data['B_CONF']['bar_color']?>; margin-top:60px;" class="bg_reply_list">
	<div id='reply_table' style="<?=$_data['댓글_display']?> background:#ffffff; border-bottom:1px solid #e1e1e1;">
		<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
		<tr>
			<td style="text-align:left; color:#222222; height:60px;" class="font_20 noto400">댓글 <span style="color:#<?=$_data['배경색']['게시판1']?>;"><?=$_data['BOARD']['bbs_etc2']?></span> 개</td>
			<td style="text-align:right;">
				<span id="reply_view_btn" class="sel_menu" onClick="view_layer_rotate('reply_view_bool',this); reply_view_text_change();">
					<span id="reply_view_text" class="font_20 noto400">보기</span>
					<span uk-icon="icon:chevron-down; ratio:1.5" class="sel_menu_hover"></span>
				</span>
			</td>
		</tr>
		</table>
	</div>
	<div id='reply_view_bool' style="display:none; padding:0px 20px">
		<?=$_data['댓글']?>

	</div>
	<div id='reply_write_bool' class="h_form" style="padding: 20px;"><?=$_data['댓글쓰기폼']?></div>
</div>

<script type='text/javascript'>

	var reply_count		= "<?=$_data['BOARD']['bbs_etc2']?>";
	var permission_reply_view = "<?=$_data['댓글보기권한']?>";

	if ( reply_count > 0 )
	{
		$("#reply_view_bool").show();
		$("#reply_view_btn").addClass("uk-open");

		reply_view_text_change();
	}
	else
	{
		$("#reply_view_btn").hide();
	}

	//console.log(permission_reply_view);
	//if ( $("#reply_view_bool").html() == "" && $("#reply_write_bool").html() )
	if ( permission_reply_view == "" )
	{
		$("#reply_table").hide();
	}

	function reply_view_text_change()
	{
		if ( $("#reply_view_bool").css("display") == "none" )
		{
			$("#reply_view_text").html("<span style='color:#999;'>보기</span>");
		}
		else
		{
			$("#reply_view_text").html("숨기기");
		}
	}
</script>
<!-- 댓글 -->

<!-- 게시판버튼 -->
<div class="h_form bbs_bottom_btn">
	<div class="bbs_bottom_btn_left"><?=$_data['추천']?><?=$_data['소스']?></div>
	<div class="bbs_bottom_btn_right"><?=$_data['수정']?><?=$_data['삭제']?><?=$_data['목록']?></div>
	<div style="clear:both;"></div>
</div>
<!-- 게시판버튼 -->

	<!-- 게시판하단 -->
	<div><?=$_data['게시판하단']?></div>
	<!-- 게시판하단 -->

</div>


<!--폰트사이즈 크게,작게 스크립트 id=ct 가 있어야 작동함-->
<script language="javascript">

document.getElementById('ct').style.fontSize=12 + "px";
document.getElementById('ct').style.lineHeight=1.5;

function changesize(flag)
{
 obj = document.getElementById('ct').style.fontSize;
 num = eval(obj.substring(0,obj.length-2)*1);
	if(!isNaN(num))
	{
		if(flag=='+')
		{
			document.getElementById('ct').style.fontSize = eval(num + 1) + "px";
		}
		else
		{
			if(num > 1)
			{
				document.getElementById('ct').style.fontSize = eval(num - 1) + "px";
			}
			else
			{
				alert('이미 폰트의 최소 사이즈입니다.');
			}

		}
	}
}
</script>

<? }
?>