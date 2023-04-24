<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 15:47:03 */
function SkyTpl_Func_1975373154 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellspacing="0" style="width:100%; border-top:2px solid #333">
	<tr>
		<td style="letter-spacing:-1.2px; padding:10px 0" class="font_24 noto500">
			<a href="html_file.php?file=bbs_index.html&file2=bbs_default_community.html" title="커뮤니티" style="color:#333;">커뮤니티</a>
		</td>
	</tr>
	<tr>
		<td class="aside_list_area">
			<?board_keyword_extraction('총99개','가로1개','24자자름','커뮤니티','sub_rows_board_list_01.html','누락0개') ?>

		</td>
	</tr>
</table>
<table cellspacing="0" style="width:100%; margin-top:20px">
	<tr>
		<td><?echo happy_banner('문의배너2','배너제목','랜덤') ?></td>
	</tr>
	
</table>


<? }
?>