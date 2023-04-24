<? /* Created by SkyTemplate v1.1.0 on 2023/03/22 15:39:33 */
function SkyTpl_Func_3758140227 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="JavaScript"> 

function bluring(){
if(event.srcElement.tagName=="A"||event.srcElement.tagName=="IMG") document.body.focus();
}
document.onfocusin=bluring;
</script>

<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center>
	<TR>
		<TD width=6><IMG height=30 src="img/table_log_1.gif" width=6 border=0></TD>
		<TD background="img/table_log_2.gif"><?=$_data['현재위치']?></TD>
		<TD width=6><IMG height=30 src="img/table_log_3.gif" width=6 border=0></TD>
	</TR>
</TABLE>
<div style="padding:2;"></div>
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" width="108"><a href="document.php?mode=<?=$_data['_GET']['mode']?>&number=<?=$_data['number']?>&subMode=type1"><img align="absmiddle" src="img/tit_reg_step_1<?=$_data['imgCheck1']?>.gif" width="108" height="108" border="0"></a></td>
        <td align="center"><img align="absmiddle" src="img/tit_reg_step_center.gif" width="18" height="20" border="0"></td>
        <td align="center" width="108"><a href="document.php?mode=<?=$_data['_GET']['mode']?>&number=<?=$_data['number']?>&subMode=type2"><img align="absmiddle" src="img/tit_reg_step_2<?=$_data['imgCheck2']?>.gif" width="108" height="108" border="0"></a></td>
        <td align="center"><img align="absmiddle" src="img/tit_reg_step_center.gif" width="18" height="20" border="0"></td>
        <td align="center" width="108"><a href="document.php?mode=<?=$_data['_GET']['mode']?>&number=<?=$_data['number']?>&subMode=type3"><img align="absmiddle" src="img/tit_reg_step_3<?=$_data['imgCheck3']?>.gif" width="108" height="108" border="0"></a></td>
        <td align="center"><img align="absmiddle" src="img/tit_reg_step_center.gif" width="18" height="20" border="0"></td>
        <td align="center" width="108"><a href="document.php?mode=<?=$_data['_GET']['mode']?>&number=<?=$_data['number']?>&subMode=type4"><img align="absmiddle" src="img/tit_reg_step_4<?=$_data['imgCheck4']?>.gif" width="108" height="108" border="0"></a></td>
        <td align="center"><img align="absmiddle" src="img/tit_reg_step_center.gif" width="18" height="20" border="0"></td>
        <td align="center" width="108"><a href="document.php?mode=<?=$_data['_GET']['mode']?>&number=<?=$_data['number']?>&subMode=type5"><img align="absmiddle" src="img/tit_reg_step_5<?=$_data['imgCheck5']?>.gif" width="108" height="108" border="0"></a></td>
        <td align="center"><img align="absmiddle" src="img/tit_reg_step_center.gif" width="18" height="20" border="0"></td>
        <td align="center" width="108"><a href="document.php?mode=<?=$_data['_GET']['mode']?>&number=<?=$_data['number']?>&subMode=type6"><img align="absmiddle" src="img/tit_reg_step_6<?=$_data['imgCheck6']?>.gif" width="108" height="108" border="0"></a></td>
        <td align="center"><img align="absmiddle" src="img/tit_reg_step_center.gif" width="18" height="20" border="0"></td>
        <td align="center" width="108"><a href="document.php?mode=<?=$_data['_GET']['mode']?>&number=<?=$_data['number']?>&subMode=type7"><img align="absmiddle" src="img/tit_reg_step_7<?=$_data['imgCheck7']?>.gif" width="108" height="108" border="0"></a></td>
    </tr>
</table>
<div style="padding:5;"></div>
<div align="right"><img src="img/tit_gujik_reg_helper.gif" align="absmiddle" border="0"></div>
<!--
<table width="100%" height="50" bgcolor="#FFF0FE">
<tr>
	<td colspan="7">이파일은 job_per_doc_top.html 입니다.</td>
</tr>
<tr>
	<td align="center"><a href="document.php?mode=<?=$_data['_GET']['mode']?>&number=<?=$_data['number']?>&subMode=type1"><?=$_data['Color1']?>기본정보</font></td>
	<td align="center"><?=$_data['Color2']?>개인부가정보</font></td>
	<td align="center"><?=$_data['Color3']?>키워드</font></td>
	<td align="center"><?=$_data['Color4']?>취업희망/학력정보</font></td>
	<td align="center"><?=$_data['Color5']?>경력정보</font></td>
	<td align="center"><?=$_data['Color6']?>첨부파일</font></td>
	<td align="center"><?=$_data['Color7']?>OA능력 및 보유기술</font></td>
</tr>
</table><br>
-->
<? }
?>