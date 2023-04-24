<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 13:51:50 */
function SkyTpl_Func_4147601330 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="javascript" text="text/javascript">
function toggle_sch_box(){
	$('.search_box').slideToggle();
}
function toggle_all_menu_box(){
	$('.all_cate_wrap').slideToggle();
}
$(document).ready(function() {
	
	
});

</script>
<div class="top_menu">
	<h1>
		<a href="./"><img src="<?=$_data['HAPPY_CONFIG']['m_main_logo']?>" alt="<?=$_data['site_name']?>"></a>
	</h1>
	<a href="javascript:toggle_all_menu_box();" class="all_menu_btn"><span>전체메뉴</span></a>
	<a href="javascript:toggle_sch_box();" class="m_main_sch_btn"><img src="mobile_img/main_search_icon.png" alt="검색하기" /></a>
</div>
<div class="search_box">
	<?include_template('search_form.html') ?>

</div>
<div class="all_cate_wrap">
	<div>
		<p style="background:#<?=$_data['배경색']['모바일_기타페이지']?>; "><?happy_member_login_form('happy_member_login_top.html','happy_member_logout_top.html') ?></p>
		<?happy_menu_list('세로10개','가로1개','전체','100%','happy_menu_rows.html','서브세로20개','서브가로1개','happy_menu_rows_sub.html','게시물개수추출안함') ?> 	
		<a href="javascript:toggle_all_menu_box();" class="cat_close_btn"><img src="mobile_img/close_ico2.png" alt="닫기" /></a>
	</div>	
</div>
 <div class="main_menu" style="background:#<?=$_data['배경색']['모바일_기본색상']?>;">
	<?happy_menu_list('세로1개','가로10개','대메뉴','100%','happy_menu_rows_sub.html') ?>

</div> 

<? }
?>