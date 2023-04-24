<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 15:09:48 */
function SkyTpl_Func_2706598402 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="JavaScript">
function top_click() {
	$('html, body').animate({ scrollTop : 0},400);
	return false;
}
$(document).ready(function(){
	$('.quick_scroll > ul > li').hover(function(){
		$(this).find('i').addClass('on');
	},function(){
		$(this).find('i').removeClass('on');
	});
});
</script>
<STYLE type="text/css">
	/*모바일에서 PC보기로 들어왔을경우 오른쪽바 none*/
	@media all and (max-width:1500px){
	.quick_scroll { display:none; }
	}

	@media all and (min-width:1500px){
	.quick_scroll { display:block; }
	}
</STYLE>

<div class="quick_scroll">
	<ul>
		<li style="<?=$_data['SELLER_TYPE_STYLE']['upche']?><?=$_data['비회원일때숨김']?>">
			<a href="happy_member.php?mode=mypage">				
				<i></i>
				<span>내 초빙공고관리</span>
			</a>
		</li>
		<li style=" <?=$_data['SELLER_TYPE_STYLE']['normal']?>">
			<a href="happy_member.php?mode=mypage">				
				<i></i>
				<span>마이페이지</span>
			</a>
		</li>		
		<li style="<?=$_data['SELLER_TYPE_STYLE']['upche']?>">
			<a href="/member_guin.php?type=scrap" title="스크랩목록">				
				<i></i>
				<span class="text">스크랩목록</span>
			</a>
		</li>
		<li style=" <?=$_data['SELLER_TYPE_STYLE']['normal']?>">
			<a href="/guin_scrap.php" title="스크랩목록">				
				<i></i>
				<span class="text">스크랩목록</span>
			</a>
		</li>
		<li>
			<a href="/all_search.php?search_action=search&search_word=">				
				<i></i>
				<span>상세검색</span>
			</a>
		</li>
		<li>
			<a href="/happy_inquiry.php">				
				<i></i>
				<span class="text">문의하기</span>
			</a>
		</li>
		<li class="rb_naver_talk">			
			<?echo naver_talktalk_btn('style=""') ?>			
		</li>
		<li>
			<a href="/?mobile=on" title="모바일모드">
				<i></i>
				<span>모바일모드</span>
			</a>
		</li>
		<li>
			<a href="javascript:void(0)" onClick="top_click()" class="main_background_10" title="맨위로" style="color:#fff !important;">
				<i></i>
				<span>TOP</span>
			</a>
		</li>
	</ul>
</div>
<? }
?>