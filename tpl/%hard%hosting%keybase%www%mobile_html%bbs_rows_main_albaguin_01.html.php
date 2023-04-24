<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 13:51:50 */
function SkyTpl_Func_773238821 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?
global $BOARD,$GU,$SI;
$array = array('일당','주당','월급','건당','시간당','추후협의');
$array2 = array('alba_1.gif','alba_2.gif','alba_3.gif','alba_4.gif','alba_5.gif','alba_6.gif');
if ($BOARD[text2] == '추후협의'){
	$BOARD[text2_info] = "<img src=img/albaimg/alba_6.gif alt='추후협의' align=absmiddle>";
}
else {
	$BOARD[total_price_comma] = number_format($BOARD[total_price],0);
	$i = '0';
	foreach ($array as $list){
		if ($list == $BOARD[text2] ){
		$BOARD[text2_info] = "<img src=img/albaimg/$array2[$i] alt='$array[$i]' style='vertical-align:middle'> <span class='font_tahoma font_13'>$BOARD[total_price_comma]</span>원";
		break;
		}
		$i ++;
	}
}

#글자 자르자
$BOARD[phone] = kstrcut($BOARD[phone], 16, "...");

if ($SI{$BOARD[zip]} == ''){
$BOARD[zip_info]= '전체';
}
else  {
$BOARD[zip_info] = $SI{$BOARD[zip]};
}

if ($BOARD[money_in]){
	$BOARD[money_in_info] = '<img src=img/skin_icon/make_icon/skin_icon_100.jpg align=absmiddle>';
}
else {
	$BOARD[money_in_info] = $BOARD[text3];
}

$array = array('남자','여자','무관');
$array2 = array('man_want.gif','woman_want.gif','mw_want.gif');
	$i = '0';
	foreach ($array as $list){
		if ($list == $BOARD[radio2] ){
		$BOARD[radio2_info] = "<img src=img/albaimg/$array2[$i] alt='$array[$i]' align=absmiddle>";
		break;
		}
		$i ++;
	}


// 지역부터 작업해야함.
?>

<div class="alba_list_01">
	<a href="bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&b_category=<?=$_data['_GET']['b_category']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['B_CONF']['tbname']?>">
		<span><?=$_data['BOARD']['phone']?></span>
		<strong class="ellipsis_line2"><?=$_data['BOARD']['bbs_title_none']?></strong>
		<p>
			<span><?=$_data['BOARD']['zip_info']?></span>
			<span>~<?=$_data['BOARD']['money_in_info']?></span>
		</p>
	</a>
</div>
<? }
?>