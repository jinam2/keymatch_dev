<?php

include ("./inc/config.php");
include ("./inc/function.php");



$CONF[banner_round_color] = str_replace('#','',$CONF[banner_round_color]);

if ( $CONF['banner_round_color_type'] == 'on' )
{
	$CONF['banner_round_color']	= $������;
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
<!--�÷����϶� 0 �ƴҶ� 1-->
<!--�巡�� �ӵ� mspeed -->
<!--�����̼Ǽӵ�  speed -->
<!--����ĥ��?  round -->
<!--
btnalpha	=	��ư ���İ�(����)
btnalign		=	��ư ��ġ
					���� �ѱ�¥ T = TOP(���) B = Bottom(�ϴ�)
					���� �ѱ�¥ L = Left(����) R = Right(������)

					�� �빮�ڷ� �̿��Ͽ��� �մϴ�.

					��) TL (��� ����) / TR(��ܿ���) / BL(�ϴ�����) / BR(�ϴܿ���)

numcolor	=	��ư Ȱ��ȭ ����
spaceX		=	��ư ����
-->
