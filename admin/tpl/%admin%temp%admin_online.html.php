<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 08:59:29 */
function SkyTpl_Func_LOOP ($TPL,$DATA,$_index,$_size,$_col) { if (is_null($DATA) && $_size==1) $DATA=array($GLOBALS); $to=$_index+$_col; if ($to>$_size) $to=$_size; for (;$_index<$to;$_index++) { $_data=$DATA[$_index]; ?>


	<tr>
		<td style="text-align:center; height:35px"><?=$_data['auto_number']?></td>
		<td style="text-align:center;" class="bg_green"><font color="#559900"><?=$_data['p_id']?></font></td>
		<td><a href="../document_view.php?number=<?=$_data['number']?>" target='_blank' style="color:#676565;"><?=$_data['doc_title']?></a></td>
		<td style="text-align:center;" class="bg_sky"><font color="#0099ff"><?=$_data['c_id']?></a></td>
		<td><a href="../guin_detail.php?num=<?=$_data['guin_number']?>" target='_blank' style='color:#676565;'><?=$_data['guin_title']?></a></td>
		<td style="text-align:center;"><?=$_data['OnlineCancelBtn']?></td>
	</tr>
	<? }
if (!$_size) { ?>

	<tr>
		<td colspan="6" align="center" style='padding:20px 0 20px 0;'>온라인 입사지원건이 없습니다.</td>
	</tr>
	
<? } }

function SkyTpl_Func_4116793435 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script>
function OnlineDel(num)
{
	TmpUrl = '';
	if ( confirm("온라인입사지원건이 확인전이므로 취소하실수 있습니다.\n\n취소하시겠습니까?") )
	{
		TmpUrl = './admin_online.php?mode=del';
		TmpUrl += '&number='+num;
		TmpUrl += '&pg=<?=$_data['_GET']['pg']?>';

		document.location.href = TmpUrl;

	}
}
</script>

<p class="main_title"><?=$_data['now_location_subtitle']?></p>

<form name="search_online" method="get" action="admin_online.php" style="margin:0px;padding:0px;">
<div id="list_style">

	<table cellspacing="0" cellpadding="0" class="bg_style table_line">
	<colgroup>
		<col style="width:5%;"></col>
		<col style="width:10%;"></col>
		<col></col>
		<col style="width:10%;"></col>
		<col></col>
		<col style="width:7%;"></col>
	</colgroup>
	<tr>
		<th>번호</th>
		<th>구직회원아이디</th>
		<th>이력서명</th>
		<th>구인회원아이디</th>
		<th>채용정보명</th>
		<th>취소하기</th>
	</tr>
	<? if (is_array($_data['LOOP'])) $TPL->assign('LOOP',$_data['LOOP']); $TPL->tprint('LOOP'); $GLOBALS['LOOP']=''; ?>

	</table>
</div>
<div align="center" style="padding:20px 0 20px 0;"><?=$_data['page_print']?></div>


<table width=100% cellpadding="0" cellspacing="0" border="0">
<tr>
	<td align="center" style="padding:20px 0 20px;"></td>
</tr>
<tr>
	<td align="center" class='input_style_adm'>
	<select name="search_type">
		<option value="" <?=$_data['search_type_0']?>>전체</option>
		<option value="id" <?=$_data['search_type_1']?>>구직회원아이디</option>
		<option value="title" <?=$_data['search_type_2']?>>이력서제목</option>
		<option value="guin_id" <?=$_data['search_type_3']?>>구인회원아이디</option>
		<option value="guin_title" <?=$_data['search_type_4']?>>채용정보제목</option>
	</select>
	<input type="text" name="search_word" value="<?=$_data['_GET']['search_word']?>"> <input type="submit" value="검색하기" class="btn_small_dark" style="height:30px; margin-bottom:2px">
	</td>
</tr>
</table>

</form>

<? }
?>