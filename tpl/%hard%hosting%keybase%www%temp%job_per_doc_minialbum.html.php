<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:49:15 */
function SkyTpl_Func_500283322 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="border:1px solid #dfdfdf; padding:20px">
	<h4 class="noto500 font_20" style="letter-spacing:-1px; padding-bottom:5px; margin:0; color:#333;">미니앨범 사진등록</h4>
	<div>
		<input type=hidden name='img0' value='' size=40>
		<input type=hidden name='img1' value='' size=40>
		<input type=hidden name='img2' value='' size=40>
		<input type=hidden name='img3' value='' size=40>
		<input type=hidden name='img4' value='' size=40>
		<input type=hidden name='img5' value='' size=40>
		<input type=hidden name='img6' value='' size=40>
		<input type=hidden name='img7' value='' size=40>
		<input type=hidden name='img8' value='' size=40>
		<input type=hidden name='img9' value='' size=40>

		<input type=hidden name='img10' value='' size=40>
		<input type=hidden name='img11' value='' size=40>
		<input type=hidden name='img12' value='' size=40>
		<input type=hidden name='img13' value='' size=40>
		<input type=hidden name='img14' value='' size=40>
		<input type=hidden name='img15' value='' size=40>
		<input type=hidden name='img16' value='' size=40>
		<input type=hidden name='img17' value='' size=40>
		<input type=hidden name='img18' value='' size=40>
		<input type=hidden name='img19' value='' size=40>

		<input type=hidden name='img20' value='' size=40>
		<input type=hidden name='img21' value='' size=40>
		<input type=hidden name='img22' value='' size=40>
		<input type=hidden name='img23' value='' size=40>
		<input type=hidden name='img24' value='' size=40>
		<input type=hidden name='img25' value='' size=40>
		<input type=hidden name='img26' value='' size=40>
		<input type=hidden name='img27' value='' size=40>
		<input type=hidden name='img28' value='' size=40>
		<input type=hidden name='img29' value='' size=40>

		<input type=hidden name='img30' value='' size=40>
		<input type=hidden name='img31' value='' size=40>
		<input type=hidden name='img32' value='' size=40>
		<input type=hidden name='img33' value='' size=40>
		<input type=hidden name='img34' value='' size=40>
		<input type=hidden name='img35' value='' size=40>
		<input type=hidden name='img36' value='' size=40>
		<input type=hidden name='img37' value='' size=40>
		<input type=hidden name='img38' value='' size=40>
		<input type=hidden name='img39' value='' size=40>


		<!-- 이미지 드래그 플래시파일이 출력되는 레이어  -->
		<!-- <script language='javascript' src='js/swf_upload_new.js'></script>
		<div id='swf_upload_layer' style='margin-bottom:5px;'>
			<div>
				<div id='swf_upload_drag_layer'></div>
				<div id='swf_upload_form_layer'></div>
				<script language="javascript">

				swf_upload_forder	= '';	// 관리자 페이지의 경우 ../ 로 지정
				swf_form_name = 'document_frm';	// img0, img1... field 가 소속된 폼 이름

				makeSwfMultiUpload(
					movie_id='img', //파일폼 고유ID
					flash_width='1050', //파일폼 너비 (기본값 400, 권장최소 300)
					list_rows='5', // 파일목록 행 (기본값:3)
					limit_size='240', // 업로드 제한용량 (기본값 10)
					file_type_name='이미지 파일 선택', // 파일선택창 파일형식명 (예: 그림파일, 엑셀파일, 모든파일 등)
					allow_filetype='*.jpg *.jpeg', // 파일선택창 파일형식 (예: *.jpg *.jpeg *.gif *.png)
					deny_filetype='*.php *.php3 *.php4 *.html *.inc *.js *.htm *.cgi *.pl *.doc *.jsp *.hwp *.zip *.rar *.tar', // 업로드 불가형식
					upload_exe='flash_upload.php', // 업로드 담당프로그램
					max_file_count='20', //업로드제한
					get_frameHeight = '500' // 드래그 플레쉬 호출할  iframe 세로크기 [여기부터 아래쪽변수 미사용시 아무값이나]
				);

				{ {makeDragImg}}
				{ {startScript}}
				</script>
			</div>
		</div> -->

		<?include_template('happy_multi_upload.html') ?>


	</div>
</div>

<? }
?>