<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 15:09:49 */
function SkyTpl_Func_3392748608 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<style type="text/css">
/* 하부레이어 메뉴 보더색상 및 디자인 */
.submenu_inner{top:2px; position:relative; z-index:999;}
.submenu_inner:before{content:''; position:absolute; top:-8px; left:20px; width:15px; height:15px; border-radius:3px 0 0 0; border-left:1px solid #ddd; border-top:1px solid #ddd; transform:rotate(45deg); background:#fff;}
.submenu_inner table{background:#fff; border:1px solid #ddd; border-radius:10px;}
.submenu_inner table tr:first-child td .sub_menu_padding{padding-top:15px;}
.submenu_inner table a:hover{color:#<?=$_data['배경색']['서브색상']?>;}
.un_use{display:none;}
.un_use:before{display:none;}

/* 메인메뉴 강조색상 */
.menu_color_3{color:#<?=$_data['배경색']['기본색상']?> !important;}

/* 전체메뉴레이어 패턴 */
.total_menu_box{padding:15px 20px 20px 20px; border-top:1px solid #c5c5c5;}
.total_menu_box.border{border-top:none;}
.total_menu_box .total_menu_title{font-size:16px; color:#212121; letter-spacing:-1px; font-family: 'Noto Sans KR' !important; font-weight:400 !important;}
.total_menu_box .total_menu_title.guin span{color:#<?=$_data['배경색']['기본색상']?>;}
.total_menu_box .total_menu_title.guzic span{color:#<?=$_data['배경색']['서브색상']?>;}
.total_menu_box .total_menu_sub a{display:inline-block; padding-top:8px; font-size:14px; color:#8a8a8a; letter-spacing:-1px; font-family: 'Noto Sans KR' !important; font-weight:400 !important;}
</style>
<div>
	<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>			
			<td style="padding-left:15px" class="main_menu">
				<div style="position:relative">
					<!-- 초빙정보 카운팅-->
					<span class="menu_count_box" style="position:absolute; top:-17px; left:28px; display:inline-block; background:#<?=$_data['배경색']['기본색상']?>; border-radius:50px;">
						<a href="guin_list.php" class="font_tahoma font_11" style="display:block; padding:2px 10px; color:#fff; font-weight:bold;"><?=$_data['전체채용']?></a>
					</span>
					<!-- 인재정보 카운팅-->
					<span class="menu_count_box" style="position:absolute; top:-17px; left:113px; display:inline-block; background:#<?=$_data['배경색']['서브색상']?>; border-radius:50px;">
						<a href="guzic_list.php" class="font_tahoma font_11" style="display:block; color:#fff; font-weight:bold; padding:2px 10px; "><?=$_data['전체인재']?></a>
					</span>

					<?happy_menu_list('세로1개','가로10개','대메뉴','100%','happy_menu_rows.html') ?>


					<div style="position:absolute; top:40px; left:15px; clear:both; z-index:1000">
						<div id="top_layer1" class="submenu_inner" onMouseOver="change_main_top(1);" onMouseOut="change_main_top_close(1)" style="display:none;  ">
							<?happy_menu_list('세로10개','가로1개','자동서브메뉴','150','happy_menu_rows_sub.html') ?>


						</div>
						<div id="top_layer2" class="submenu_inner" onMouseOver="change_main_top(2);" onMouseOut="change_main_top_close(2)" style="left:85px; display:none">
							<?happy_menu_list('세로10개','가로1개','자동서브메뉴','150','happy_menu_rows_sub.html') ?>

						</div>
						<div id="top_layer3"  class="submenu_inner un_use" onMouseOver="change_main_top(3);" onMouseOut="change_main_top_close(3)" style="display:none">
							<?happy_menu_list('세로10개','가로1개','자동서브메뉴','150','happy_menu_rows_sub.html') ?>

						</div>
						<div id="top_layer4"  class="submenu_inner " onMouseOver="change_main_top(4);" onMouseOut="change_main_top_close(4)" style="left:265px; display:none">
							<?happy_menu_list('세로10개','가로1개','자동서브메뉴','150','happy_menu_rows_sub.html') ?>

						</div>
						<div id="top_layer5"  class="submenu_inner" onMouseOver="change_main_top(5);" onMouseOut="change_main_top_close(5)" style="left:375px; display:none">
							<?happy_menu_list('세로10개','가로1개','자동서브메뉴','150','happy_menu_rows_sub.html') ?>

						</div>
						<div id="top_layer6"  class="submenu_inner un_use" onMouseOver="change_main_top(6);" onMouseOut="change_main_top_close(6)" style=" display:none">
							<?happy_menu_list('세로10개','가로1개','자동서브메뉴','150','happy_menu_rows_sub.html') ?>

						</div>
						<div id="top_layer7"  class="submenu_inner" onMouseOver="change_main_top(7);" onMouseOut="change_main_top_close(7)" style="left:550px; display:none">
							<?happy_menu_list('세로10개','가로1개','자동서브메뉴','150','happy_menu_rows_sub.html') ?>

						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>


<? }
?>