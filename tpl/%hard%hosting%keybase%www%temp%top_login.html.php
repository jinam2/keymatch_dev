<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 15:09:49 */
function SkyTpl_Func_3189305213 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<ul>
	<li style="display:inline-block; border:1px solid #ddd; border-radius:15px; height:30px; text-align:center; padding:3px 10px; box-sizing:border-box;">
		<a href="happy_member_login.php?mode=logout" class="noto400 font_14" style="color:#999">로그아웃</a>
	</li>
	<li style="display:inline-block; border:1px solid #ddd; border-radius:15px; height:30px; text-align:center; padding:3px 10px; box-sizing:border-box; margin-left:10px; <?=$_data['SELLER_TYPE_STYLE']['upche']?>">
		<a href="happy_member.php?mode=mypage" class="noto400 font_14" style="color:#999">내 초빙공고관리</a>
	</li>
	<li style="display:inline-block; border:1px solid #ddd; border-radius:15px; height:30px; text-align:center; padding:3px 10px; box-sizing:border-box; margin-left:10px; <?=$_data['SELLER_TYPE_STYLE']['normal']?>">
		<a href="happy_member.php?mode=mypage" class="noto400 font_14" style="color:#999">마이페이지</a>
	</li>
	<li style="display:inline-block; margin-left:10px; position:relative; top:3px;">
		<a href="javascript:void(0);" onClick="slideToggle_event();" class="all_menu_btn"><span>전체메뉴</span></a>
	</li>
</ul>

<? }
?>