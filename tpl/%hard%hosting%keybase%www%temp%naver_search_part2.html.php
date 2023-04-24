<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 07:59:05 */
function SkyTpl_Func_1269049603 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<table width="100%" style="border:0px solid red;">
	<tr>
		<td style="letter-spacing:-1px"><span class="font_18 noto500" style="color:#333;">네이버<span style="color:#<?=$_data['배경색']['서브색상']?>"><?=$_data['검색분야']?></span> 검색결과</span> <font color="#777777"> (<?=$_data['Default']['total_comma']?>건)</font></td>
		</td>
		<td align="right"><a href="http://developer.naver.com/wiki/pages/OpenAPI" target="_blank"><img src="img/powered_naver_api.gif" alt="NAVER OpenAPI" border="0"/></a></td>
	</tr>
</table>


<table width="100%">
<tr>
	<td height="2px" bgcolor="#8b8b8b"></td>
</tr>
<tr>
	<td height="10px"></td>
</tr>
</table>





<!-- 타이틀 : <?=$_data['Default']['title']?>

<br>
링크 : <a href='<?=$_data['Default']['link']?>' target='_blank'><?=$_data['Default']['link']?></a>
<br>
<?=$_data['Default']['description']?>

<br> -->

<?=$_data['내용']?>


<div style="margin:20px 0 30px 0;" align="center"><?=$_data['페이징']?></div>



<script>all_search_result = 'ok'; // 검색결과 나왔다는 확인용 변수값에 ok값 넣기</script>
<? }
?>