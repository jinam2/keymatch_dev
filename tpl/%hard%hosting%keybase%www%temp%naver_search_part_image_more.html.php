<? /* Created by SkyTemplate v1.1.0 on 2023/04/20 17:35:45 */
function SkyTpl_Func_2596125714 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script>
function view(what) {
var imgwin = window.open("",'WIN','scrollbars=yes,status=no,toolbar=no,resizable=0,location=no,menu=no,width=10,height=10,scrollbars=no');
imgwin.focus();
imgwin.document.open();
imgwin.document.write("<html>\n");
imgwin.document.write("<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\n");

imgwin.document.write("<sc"+"ript>\n");

imgwin.document.write("function closeWin(){\n");
imgwin.document.write("window.close();\n");
imgwin.document.write("}\n");

imgwin.document.write("function resize() {\n");
imgwin.document.write("pic = document.il;\n");
//imgwin.document.write("alert(eval(pic).height);\n");
imgwin.document.write("if (eval(pic).height) { var name = navigator.appName\n");
imgwin.document.write("  if (name == 'Microsoft Internet Explorer') { myHeight = eval(pic).height ; myWidth = eval(pic).width \n");
imgwin.document.write("  } else { myHeight = eval(pic).height + 9; myWidth = eval(pic).width; }\n");
imgwin.document.write("   if( myHeight > 600 ){ \n");
imgwin.document.write("    kwak = myHeight/600; \n");
imgwin.document.write("    myWidth = myWidth / kwak \n");
imgwin.document.write("    myHeight=600;\n");
imgwin.document.write("    pic.style.height=myHeight-35; \n");
imgwin.document.write("    pic.style.width=myWidth-10; }\n");
imgwin.document.write("   if( myWidth > 800 ){ \n");
imgwin.document.write("    kwak = myWidth/800; \n");
imgwin.document.write("    myHeight = myHeight / kwak \n");
imgwin.document.write("    myWidth=800;\n");
imgwin.document.write("    pic.style.height=myHeight-35; ");
imgwin.document.write("    pic.style.width=myWidth-10; }\n");
imgwin.document.write("  clearTimeout();\n");
imgwin.document.write("  var height = screen.height;\n");
imgwin.document.write("  var width = screen.width;\n");
imgwin.document.write("  var leftpos = width / 2 - myWidth / 2;\n");
imgwin.document.write("  var toppos = height / 2 - myHeight / 2; \n");
imgwin.document.write("  self.moveTo(leftpos, toppos);\n");
imgwin.document.write("  self.resizeTo(myWidth+10, myHeight+60);\n");
imgwin.document.write("}else setTimeOut(resize(), 100);}\n");
imgwin.document.write("</sc"+"ript>\n");

imgwin.document.write("</head>\n");
imgwin.document.write('<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">\n');

imgwin.document.write("<a href='javascript:closeWin()' onfocus='this.blur()' title='이미지를 클릭하시면 창이 닫힙니다.'>\n");
imgwin.document.write("<table width='100%' height='100%' cellspacing='0' cellpadding='0' border='0'><tr><td align='center'><img border=0 src="+what+" xwidth=100 xheight=9 name=il onload='resize();'></td></tr></table>\n");
imgwin.document.write("</a>\n");
//imgwin.document.write("<center><a href='javascript:self.close()'><img src='img/coupon_pop_btn_close.gif' border='0'></a>\n");
imgwin.document.write("</body>\n");
imgwin.document.close();
}
</script>

<div style="margin-top:10px; border-bottom:1px solid #dcdfe5;" title="현재 사이트에 등록된 모든 정보의 통합검색결과 입니다.
클릭하시면 본문 내용을 보실 수 있습니다.">
	<img src="img/sub_banner_allsearch.jpg" alt="통합검색결과">
</div>

<div class="scrollMoveBox3">
	<div class="Movebox_hidden" style="display:none; border-bottom:1px solid #f3f5f9; background:#fcfcfc">
		<div style="width:1200px; margin:0 auto; padding:15px 0; background:#fcfcfc; text-align:left">
			<a href="./"><img src="<?=$_data['main_logo']?>" title="<?=$_data['site_name']?>"></a>
		</div>
	</div>
	<div class="scrollMoveBox3_inner">
		<div style="position:relative; background:url('./img/all_sch_bgline.gif') 0 0 repeat-x" >
			<table cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<a href="all_search.php?all_keyword=<?=$_data['_GET']['all_keyword']?>&file=all_search.html" title="전체검색">
					<img src="img/all_search_tab_01_off.jpg" alt="전체검색">
					</a>
				</td>
				<td>
					<a href="all_search.php?all_keyword=<?=$_data['_GET']['all_keyword']?>&file=all_search2.html" title="구인/구직검색">
					<img src="img/all_search_tab_02_off.jpg" alt="구인/구직검색">
					</a>
				</td>
				<td >
					<a href="all_search.php?all_keyword=<?=$_data['_GET']['all_keyword']?>&file=all_search3.html" title="게시판검색">
					<img src="img/all_search_tab_03_off.jpg" alt="게시판검색">
					</a>
				</td>
				<td >
					<a href="all_search.php?all_keyword=<?=$_data['_GET']['all_keyword']?>&file=all_search4.html" title="네이버검색">
					<img src="img/all_search_tab_04_on.jpg" alt="네이버검색">
					</a>
				</td>
			</tr>
			</table>
			<div style="position:absolute; top:12px; right:0px">
				<?include_template('search_part2.html') ?>

			</div>
		</div>
	</div>
</div>

<div style="width:940px; float:left; padding-top:30px">
	<?echo naver_search_api('세로10개','가로5개','naver_search_part2.html','naver_search_image_rows.html','자동','페이징사용') ?>

</div>

<div style="width:230px; float:right; margin-top:30px;">
	<?include_template('aside_normal.html') ?>

</div>
<div style="clear:both;"></div>


<? }
?>