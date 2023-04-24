<?php

include ("./inc/config.php");
include ("./inc/function.php");



$CONF[banner_round_color] = str_replace('#','',$CONF[banner_round_color]);

if ( $CONF['banner_round_color_type'] == 'on' )
{
	$CONF['banner_round_color']	= $배경색상;
}

$sql		= "SELECT * FROM $main_banner_tb order by number asc limit $CONF[banner_total_use]  ";
$result = query($sql);
while ($BANNER = happy_mysql_fetch_array($result)){

	if (preg_match("/\.swf/i",$BANNER[file])){
		$exp = '0';
	}
	else {
		$exp = '1';
	}
	$List_banner .= "<List banner='flash_banner/$BANNER[file]' url='$BANNER[value]' target='$BANNER[name_on]' exp=\"$exp\"/>\n";
}


print <<<END
<?xml version="1.0" encoding="euc-kr"?>

<xmlstart>

<banner>
$List_banner
</banner>

<speed speed='$CONF[banner_rotation]' mspeed="$CONF[banner_move]" spaceX="$CONF[banner_spaceX]" btnalpha="$CONF[banner_btnalpha]" btnalign="$CONF[banner_btnalign]" btnstyle="$HAPPY_CONFIG[banner_btnstyle]"/>
<size width="$CONF[banner_size_width]" height="$CONF[banner_size_height]" round="$CONF[banner_round]" roundcolor="$CONF[banner_round_color]" numcolor="$CONF[banner_numcolor]" />
</xmlstart>
END;

?>
<!--플래쉬일때 0 아닐때 1-->
<!--드래그 속도 mspeed -->
<!--로테이션속도  speed -->
<!--라운드칠까?  round -->
<!--
btnalpha	=	버튼 알파값(투명도)
btnalign		=	버튼 위치
					앞쪽 한글짜 T = TOP(상단) B = Bottom(하단)
					뒤쪽 한글짜 L = Left(왼쪽) R = Right(오른쪽)

					※ 대문자로 이용하여야 합니다.

					예) TL (상단 좌측) / TR(상단우측) / BL(하단좌측) / BR(하단우측)

numcolor	=	버튼 활성화 색상
spaceX		=	버튼 간격
-->
