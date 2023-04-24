<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 13:37:37 */
function SkyTpl_Func_LOOP ($TPL,$DATA,$_index,$_size,$_col) { if (is_null($DATA) && $_size==1) $DATA=array($GLOBALS); $to=$_index+$_col; if ($to>$_size) $to=$_size; for (;$_index<$to;$_index++) { $_data=$DATA[$_index]; ?>


	<tr>
		<td class="b_border_td" style="text-align:center; height:35px"><?=$_data['auto_number']?></td>
		<td class="b_border_td"><a href="happy_member.php?type=add&number=<?=$_data['id_number']?>" style='color:#676565;'><?=$_data['id']?></a></td>
		<td class="b_border_td"><a href="../guin_detail.php?num=<?=$_data['guin_number']?>" target="_BLANK" style='color:#676565;'>[<?=$_data['guin_number']?>] <?=$_data['guin_title_cut']?></a></td>
		<td class="b_border_td" style="text-align:center;"><?=$_data['reg_date']?></td>
		<td class="b_border_td" style="text-align:center;"><?=$_data['guin_date']?></td>
		<td class="b_border_td" style="text-align:center; padding:10px 0 8px 0;"><a href="guin_jump.php?mode=del&number=<?=$_data['number']?>" class="btn_small_red">삭제</a></td>
	</tr>
	<? }
if (!$_size) { ?>

	<tr>
		<td colspan="6" style="text-align:center; padding:20px;">점프 사용내역이 없습니다.</td>
	</tr>
	
<? } }

function SkyTpl_Func_3370073345 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<p class="main_title"><?=$_data['now_location_subtitle']?></p>

<div class="help_style">
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<span class="help">도움말</span>
	<p>
		자신이 등록한 채용정보를 리스트상에서 최상단으로 위치를 변경시키는 유료옵션입니다.<br>
		점프기능을 사용할때는 {{구인추출 , {{구인리스트 추출태그에서 사용한 정렬순서태그가 무시되고, 최근등록순으로 변경됩니다.<br>
		점프기능을 사용하지 않을때는 기존처럼 추출태그에서 입력받은 정렬순서를 이용합니다.<br>
	</p>
</div>

<form name="search_online" method="get" action="guin_jump.php" style="margin:0px;padding:0px;">

<div id='list_style'>
	<table cellspacing='0' cellpadding='0' border='0' class='bg_style b_border'>
	<tr>
		<th style="width:40px;">번호</th>
		<th>아이디</th>
		<th>채용정보</th>
		<th style="width:130px;">점프 사용일</th>
		<th style="width:130px;">점프전 등록일</th>
		<th style="width:70px;">관리툴</th>
	</tr>
	<? if (is_array($_data['LOOP'])) $TPL->assign('LOOP',$_data['LOOP']); $TPL->tprint('LOOP'); $GLOBALS['LOOP']=''; ?>

	</table>
</div>
<div align="center" style="padding:20px 0 20px 0;"><?=$_data['page_print']?></div>

<table cellpadding="0" cellspacing="0" style='margin:10px auto'>
	<tr>
		<td class='input_style_adm'>
		<select name="search_type">
			<option value="guin_id" <?=$_data['search_type_0']?>>구인회원아이디</option>
			<option value="guin_number" <?=$_data['search_type_1']?>>구인정보번호</option>
			<option value="guin_title" <?=$_data['search_type_2']?>>구인정보제목</option>
		</select>
		<input type="text" name="search_word" value="<?=$_data['_GET']['search_word']?>" style='vertical-align:middle'>
		<input type="submit" value="검색하기" class="btn_small_dark" style='height:29px'>
		</td>
	</tr>
</table>

</form>

<? }
?>