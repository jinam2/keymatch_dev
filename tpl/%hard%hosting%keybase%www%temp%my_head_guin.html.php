<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 16:53:16 */
function SkyTpl_Func_520251560 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellspacing="0" style="width:100%; border-collapse: collapse; border:3px solid #ececec">
	<tr>
		<td style="width:190px; border-right:1px solid #ececec; padding-left:30px; line-height:22px" >
			<strong class="font_16 noto500" style="display:block">
				<span style="color:#<?=$_data['배경색']['서브색상']?>">HEAD</span> HUNTING
			</strong>
			<span class="font_11 font_dotum" style="display:block; color:#999999; letter-spacing:-1px">
				등록한 기관별 검색이 가능합니다.
			</span>
		</td>
		<td>
			<?company_search_box('가로6개','채용') ?>

		</td>
	</tr>
</table>

<? }
?>