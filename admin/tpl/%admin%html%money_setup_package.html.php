<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 17:39:13 */
function SkyTpl_Func_LOOP ($TPL,$DATA,$_index,$_size,$_col) { if (is_null($DATA) && $_size==1) $DATA=array($GLOBALS); $to=$_index+$_col; if ($to>$_size) $to=$_size; for (;$_index<$to;$_index++) { $_data=$DATA[$_index]; ?>


	<tr>
		<td style="text-align:center;"><?=$_data['auto_number']?></td>
		<td><?=$_data['title']?></td>
		<td style="text-align:right;"><b><?=$_data['price']?> 원</b></td>
		<td class="img_bottom" style="padding:20px 10px; line-height:22px"><?=$_data['uryo_detail']?></td>
		<td style="text-align:center;"><?=$_data['reg_date']?></td>
		<td style="text-align:center;"><?=$_data['stats_text']?></td>
		<td style="text-align:center;"><?=$_data['btn_mod']?><br><br> <?=$_data['btn_del']?></td>
	</tr>
	<? }
if (!$_size) { ?>

	<tr>
		<td colspan="7" style="text-align:center; padding:20px;">패키지유료옵션 설정이 없습니다.</td>
	</tr>
	
<? } }

function SkyTpl_Func_345561859 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<form name="search_online" method="get" action="money_setup_package.php" style="margin:0px;padding:0px;">
<input type="hidden" name="pay_type" value="<?=$_data['pay_type']?>">

<p class='main_title'><?=$_data['now_location_subtitle']?></p>

<div id='list_style'>
	<table cellspacing='0' cellpadding='0' border='0' class='bg_style table_line'>
	<tr>
		<th style="width:40px;">번호</th>
		<th>패키지제목</th>
		<th>결제금액</th>
		<th>패키지내용</th>
		<th style="width:150px;">등록일</th>
		<th style="width:100px;">상태</th>
		<th style="width:60px;">관리툴</th>
	</tr>
	<? if (is_array($_data['LOOP'])) $TPL->assign('LOOP',$_data['LOOP']); $TPL->tprint('LOOP'); $GLOBALS['LOOP']=''; ?>

	</table>
</div>


<div align="center" style="margin:20px 0 20px 0;"><?=$_data['page_print']?></div>
<div align="center" style="padding:20px 0 20px 0;"><a href="money_setup_package.php?mode=regist&pay_type=<?=$_data['pay_type']?>" alt="유료설정등록" title="유료설정등록" class="btn_big">유료설정등록</a></div>

<div align="right">
	<select name="search_type">
	<option value="" <?=$_data['search_type_0']?>>전체</option>
	<option value="title" <?=$_data['search_type_1']?>>패키지제목</option>
	<option value="price" <?=$_data['search_type_2']?>>패키지가격</option>
	</select>
	<input type="text" name="search_word" value="<?=$_data['_GET']['search_word']?>" class="input_type1">
	<input type="submit" value="검색하기" class="btn_small_dark">
</div>
</form>

<? }
?>