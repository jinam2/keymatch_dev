<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:57:24 */
function SkyTpl_Func_3951853468 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?
global $BOARD,$GU,$SI;
$array = array('일당','주당','월급','건당','시간당','추후협의');
$array2 = array('alba_1.png','alba_2.png','alba_3.png','alba_4.png','alba_5.png','alba_6.png');
if ($BOARD[text2] == '추후협의'){
	$BOARD[text2_info] = "<img src=img/albaimg/alba_6.png alt='추후협의' align=absmiddle>";
}
else {
	$BOARD[total_price_comma] = number_format($BOARD[total_price],0);
	$i = '0';
	foreach ($array as $list){
		if ($list == $BOARD[text2] ){
		$BOARD[text2_info] = "<img src=img/albaimg/$array2[$i] alt='$array[$i]' style='display:block; text-align:center; margin:auto;'><span style='color:#666; font-size:16px; class='noto400'><b class='font_tahoma'>$BOARD[total_price_comma]</b> 원</span> ";
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

<div>
	<ul>
		<li>
			<a href="bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&b_category=<?=$_data['_GET']['b_category']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['B_CONF']['tbname']?>" class="ellip noto500 font_17" >
				<b class="ellipsis_line1"><?=$_data['BOARD']['phone']?></b>
				<strong class="ellipsis_line_1">
					<?=$_data['BOARD']['bbs_title_none']?>

				</strong>
			</a>			
		</li>
		<li>
			<span><?=$_data['BOARD']['zip_info']?></span>
		</li>
		<li>
			<span><?=$_data['BOARD']['text2_info']?></span>			
		</li>
		<li>
			<span><?=$_data['BOARD']['bbs_date']?></span>
		</li>
	</ul>	
</div>


<!-- { {NEW.guin_end_date_dday} } -->

<? }
?>