<? /* Created by SkyTemplate v1.1.0 on 2023/03/30 15:28:47 */
function SkyTpl_Func_1155562052 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div id="in_bottom_copyright" >
	<div class="f_menu" style="background:#<?=$_data['배경색']['카피라이터']?>">
		<p class="container_c">

		<a href="https://www.keymedi.net" target="_blank" title="회사소개">회사소개</a>
<a href="https://www.keymedi.com/service"  target="_blank"title="회사소개">서비스소개</a>






<a href="/bbs_list.php?tb=board_notice">공지사항</a>
<a href="html_file.php?file=site_rule2.html&file2=default_blank.html" title="이용약관">이용약관</a>
<a href="html_file.php?file=site_rule.html&file2=default_blank.html" title="개인정보 처리방침">개인정보 처리방침</a>
<a href="/bbs_list.php?tb=board_qna">1:1문의</a>
<a href="/bbs_list.php?tb=board_bannerreg" title="광고문의">광고문의</a>
		</p>
	</div>
	<div class="f_copy container_c">
<!-- 		<a href="/"><?=$_data['아이콘']['푸터로고']?></a> -->				
<a href="/" ><img src="<?=$_data['HAPPY_CONFIG']['main_logo']?>"></a>




		<div class="f_info">
			<?=$_data['footer_html_wys']?> 
			<p class="copyright">Copyright(c) <?=$_data['now_year']?> <?=$_data['site_name']?> All rights reserved.</p>
<!-- 			<a href="http://www.cgimall.co.kr/" target="_blank"><img src="img/powered_by_cgimall.gif" alt="CGIMALL" title="CGIMALL"></a> -->
		</div>
		<!-- <div class="f_cscenter">
			<b>고객센터</b>
			<strong style="color:#<?=$_data['배경색']['기타페이지']?>">1400-1621</strong>
			<p>USUALLY : AM 10:00 ~ PM 17:00<br>
			LUNCH : PM 12:00 ~ PM 13:00<br>
			주말 및 공휴일은 휴무입니다.</p>
		</div> -->
	</div>
</div>


<script>
var TYPE_DEPTH_TXT_ARR1	= "<?=$_data['_TYPE_DEPTH_TXT_ARR']['1']?>";
var TYPE_DEPTH_TXT_ARR2	= "<?=$_data['_TYPE_DEPTH_TXT_ARR']['2']?>";
<?=$_data['type2_key_js']?>

<?=$_data['type2_val_js']?>


<?=$_data['type3_key_js']?>

<?=$_data['type3_val_js']?>

$(document).ready(function() {

});
</script>
<script src="./js/default_foot.js"></script>
<? }
?>