<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:06 */
function SkyTpl_Func_1332683127 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?
global $Data,$GU,$SI;
$array = array('일당','주당','월급','건당','시간당','추후협의');
$array2 = array('alba_1.gif','alba_2.gif','alba_3.gif','alba_4.gif','alba_5.gif','alba_6.gif');
if ($Data[text2] == '추후협의'){
	$Data[text2_info] = "<img src=img/albaimg/alba_6.gif alt='추후협의' align=absmiddle>";
}
else {
	$Data[total_price_comma] = number_format($Data[total_price],0);
	$i = '0';
	foreach ($array as $list){
		if ($list == $Data[text2] ){
		$Data[text2_info] = "<span style='font-weight:bold; color:#666' class='font_tahoma'>$Data[total_price_comma]</span> 원 <img src=img/albaimg/$array2[$i] alt='$array[$i]' style='vertical-align:middle'>";
		break;
		}
		$i ++;
	}
}

#글자 자르자
$Data[phone] = kstrcut($Data[phone], 16, "...");

if ($SI{$Data[zip]} == ''){
$Data[zip_info]= '전체';
}
else  {
$Data[zip_info] = $SI{$Data[zip]};
}

if ($Data[money_in]){
	$Data[money_in_info] = '<img src=img/skin_icon/make_icon/skin_icon_100.jpg align=absmiddle>';
}
else {
	$Data[money_in_info] = $Data[text3];
}

$array = array('남자','여자','무관');
$array2 = array('man_want.gif','woman_want.gif','mw_want.gif');
	$i = '0';
	foreach ($array as $list){
		if ($list == $Data[radio2] ){
		$Data[radio2_info] = "<img src=img/albaimg/$array2[$i] alt='$array[$i]' align=absmiddle>";
		break;
		}
		$i ++;
	}


// 지역부터 작업해야함.
?>
<div>
	<ul>
		<li>
			<a href="bbs_detail.php?bbs_num=<?=$_data['Data']['number']?>&b_category=<?=$_data['_GET']['b_category']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['B_CONF']['tbname']?>" class="ellip noto500 font_17" >
				<b class="ellipsis_line1"><?=$_data['Data']['phone']?></b>
				<strong class="ellipsis_line_1">
					<?=$_data['Data']['bbs_title_none']?>

				</strong>
			</a>			
		</li>
		<li>
			<span><?=$_data['Data']['zip_info']?></span>
		</li>
		<li>
			<span><?=$_data['Data']['text2_info']?></span>			
		</li>
		<li>
			<span><?=$_data['Data']['bbs_date']?></span>
		</li>
	</ul>	
</div>

<!-- { {NEW.guin_end_date_dday} } -->
<? }
?>