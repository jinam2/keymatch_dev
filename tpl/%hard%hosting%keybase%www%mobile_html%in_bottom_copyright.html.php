<? /* Created by SkyTemplate v1.1.0 on 2023/03/30 17:30:50 */
function SkyTpl_Func_2740646932 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="f_menu" >
	<p>		
<!-- 		<a href="html_file.php?file=company.html">회사소개</a>
		<a href="html_file.php?file=stipulation.html">이용약관</a>
		<a href="bbs_list.php?tb=board_bannerreg">광고문의</a>
		<a href="html_file.php?file=bbs_index_customer.html&file2=bbs_default_customer.html">고객센터</a> -->
<!-- 새로추가 -->
		<a href="https://www.keymedi.net" target="_blank" title="회사소개" target="_blank">회사소개</a>
<a href="https://www.keymedi.com/service"  target="_blank"title="회사소개">서비스소개</a>
<a href="/bbs_list.php?tb=board_notice">공지사항</a>
<a href="html_file.php?file=site_rule2.html" title="이용약관">이용약관</a>
<a href="html_file.php?file=site_rule.html" title="개인정보 처리방침">개인정보 처리방침</a>
<a href="/bbs_list.php?tb=board_qna">1:1문의</a>
<a href="/bbs_list.php?tb=board_bannerreg" title="광고문의">광고문의</a>
<a href="index.php?mobile=off">PC버전</a>
<!-- //새로추가 -->




	</p>
</div>
<div style="padding:30px 0;">		
	<?=$_data['footer_html_wys_mobile']?>				
	<a href="http://www.cgimall.co.kr/" target="_blank" style="display:block; text-align:center;"><img src="img/powered_by_cgimall.gif" alt="CGIMALL" title="CGIMALL"></a>
	
</div>



<? }
?>