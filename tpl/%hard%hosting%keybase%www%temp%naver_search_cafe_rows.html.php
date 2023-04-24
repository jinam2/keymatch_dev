<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:07 */
function SkyTpl_Func_2945522567 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<table width='100%' style="border:0px solid red;">
<tr>
	<td valign='top' align="left">
		<a href='<?=$_data['Data']['link']?>' target='_blank'><b><font color="#444444"><?=$_data['Data']['title']?></font></b></a>
		<div style="padding-top:5px;"></div>
		<font color="#5E5E5E"> &nbsp; <img src="img/cafe_content_line.gif" align="absmiddle"> <?=$_data['Data']['description']?></font>
		<div style="padding-top:10px;"></div>
		<img src="img/cafe_ranking.gif" align="absmiddle" alt="카페랭킹"> <?=$_data['Data']['ranking']?> &nbsp;<font color="#E6E6E5">|</font>&nbsp;
		<img src="img/cafe_total_member.gif" align="absmiddle" alt="회원수"> <font color="#0246ab"><?=$_data['Data']['member_comma']?></font>명 &nbsp;<font color="#E6E6E5">|</font>&nbsp;
		<img src="img/cafe_write.gif" align="absmiddle" alt="게시글 수"> <font color="#0246ab"><?=$_data['Data']['totalarticles_comma']?></font>개 &nbsp;<font color="#E6E6E5">|</font>&nbsp;
		<img src="img/cafe_new_write.gif" align="absmiddle" alt="새로운 글"> <font color="#0246ab"><?=$_data['Data']['newarticles_comma']?></font>개
	</td>
</tr>
</table>


<div style="padding-top:20px;"></div>


<? }
?>