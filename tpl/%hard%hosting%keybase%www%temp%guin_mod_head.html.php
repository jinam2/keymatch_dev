<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:51:45 */
function SkyTpl_Func_4156531378 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<tr style="display:<?=$_data['hunting_use_dis']?>">
	<th class="title">
		기업선택 <img src="img/form_icon1.gif" style="vertical-align:middle; margin-left:5px;">
	</th>
	<td class="sub">
		<span class="h_form" style="display:inline-block; width:200px;"><?company_select_box('DETAIL','company_number') ?></span> <span class="font_11 font_dotum font_tahoma" style="color:#999; letter-spacing:-1px"><a href="company.php" target="_blank" style="color:#3a6ab2;">[헤드헌팅 기업정보 설정]</a>에서 등록된 기업을 선택합니다.</span>
	</td>
</tr>
<? }
?>