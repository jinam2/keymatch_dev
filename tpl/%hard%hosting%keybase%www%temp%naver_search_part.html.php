<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:07 */
function SkyTpl_Func_1964921126 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="search_title">
<tr>
	<td style="letter-spacing:-1.2px"><strong class="font_20 noto500" style="color:#333;"><span style="color:#<?=$_data['배경색']['서브색상']?>"><?=$_data['검색분야']?></span> 검색결과</strong></td>
</tr>
<tr>
	<td height="5px"></td>
</tr>
<tr>
	<td colspan="2" style="background-color:#D9D9D9;" height="1px" width="100%"></td>
</tr>
</table>

<div style="padding:10px"></div>

<!-- 타이틀 : <?=$_data['Default']['title']?>

<br>
링크 : <a href='<?=$_data['Default']['link']?>' target='_blank'><?=$_data['Default']['link']?></a>
<br>
<?=$_data['Default']['description']?>

<br> -->

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td align="center"><?=$_data['내용']?></td>
</tr>
</table>

<script>all_search_result = 'ok'; // 검색결과 나왔다는 확인용 변수값에 ok값 넣기</script>

<div style="text-align:right; padding:10px 0; border-top:1px solid #eaeaea">
	<a href="<?=$_data['더보기링크']?>" style="color:#666666">
	검색결과 더보기 <img src="img/search_plus_03.png" align="absmiddle" alt="더많은검색결과" style="vertical-align:middle">
	</a>
</div>

<div style="padding-top:30px;"></div>
<? }
?>