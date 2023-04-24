<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 17:39:19 */
function SkyTpl_Func_Uryos ($TPL,$DATA,$_index,$_size,$_col) { if (is_null($DATA) && $_size==1) $DATA=array($GLOBALS); $to=$_index+$_col; if ($to>$_size) $to=$_size; for (;$_index<$to;$_index++) { $_data=$DATA[$_index]; ?>


			<tr>
				<th style="width:150px; text-align:left">
					<strong><?=$_data['uryo_icon']?> <?=$_data['uryo_name']?></strong>
				</th>
				<td><input type="text" id="<?=$_data['form_name']?>" name="<?=$_data['form_name']?>" value="<?=$_data['form_value']?>" style="width:50px; background:#f1f1f1;"><?=$_data['uryo_danwi']?> X <input type="text" id="<?=$_data['cnt_form_name']?>" name="<?=$_data['cnt_form_name']?>" value="<?=$_data['cnt_uryo_value']?>" style="width:50px; background:#f1f1f1;">회 이용</td>
			</tr>
			<? }
if (!$_size) { ?>

			<tr>
				<td align="center">유료옵션이 없습니다.</td>
			</tr>
			
<? } }

function SkyTpl_Func_364884513 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script>
function check_valid(regiform)
{
	if ( regiform.pack_title.value == "" )
	{
		alert("패키지상품의 제목을 입력하세요");
		regiform.pack_title.focus();
		return false;
	}
	if ( regiform.pack_price.value == "" )
	{
		alert("패키지상품의 금액을 입력하세요");
		regiform.pack_price.focus();
		return false;
	}
	return true;
}
</script>

<form name="regiform" method="post" action="money_setup_package.php?mode=mod&pay_type=<?=$_data['pay_type']?>" style="margin:0px;padding:0px;" onsubmit="return check_valid(this);">
<input type="hidden" id="number" name="number" value="<?=$_data['Package']['number']?>">

<p class="main_title">패키지유료설정 수정하기</p>

<div id="box_style">
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<table cellspacing="1" cellpadding="0" class="bg_style box_height">
	<tr>
		<th>패키지제목</th>
		<td><input type="text" name="pack_title" id="pack_title" value="<?=$_data['Package']['title']?>" style="width:350px;"></td>
	</tr>

	<tr>
		<th>패키지설명</th>
		<td><input type="text" name="pack_comment" id="pack_comment" value="<?=$_data['Package']['comment']?>" style="width:99%"></td>
	</tr>
	<tr>
		<th>패키지가격</th>
		<td><input type="text" name="pack_price" id="pack_price" value="<?=$_data['Package']['price']?>" style="width:110px;"> 원</td>
	</tr>
	<tr>
		<th>패키지사용여부</th>
		<td><input type="radio" name="pack_is_use" id="pack_is_use" style='width:13px; height:13ppx; vertical-align:middle;' value="1" <?=$_data['checked_is_use_1']?>> 사용함&nbsp;&nbsp;<input type="radio" name="pack_is_use"  style='width:13px; height:13ppx; vertical-align:middle;' id="pack_is_use" value="0" <?=$_data['checked_is_use_0']?>> 사용안함</td>
	</tr>
	<tr>
		<th>패키지구성</th>
		<td>
			<table border="0" cellpadding="0" cellspacing="1" class="bg_style">
			<? if (is_array($_data['Uryos'])) $TPL->assign('Uryos',$_data['Uryos']); $TPL->tprint('Uryos'); $GLOBALS['Uryos']=''; ?>

			</table>
		</td>
	</tr>
	<tr>
		<th>패키지상품권만료일</th>
		<td><input type="text" name="end_day" id="end_day" value="<?=$_data['Package']['end_day']?>"></td>
	</tr>
	</table>
</div>
<div align="center"><input type="submit" alt="수정하기" title="수정하기" value="수정하기" class="btn_big"> <a href="money_setup_package.php?pay_type=<?=$_data['pay_type']?>" class="btn_big_gray">목록으로</a></div>

</form>

<? }
?>