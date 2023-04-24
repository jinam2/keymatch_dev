<?

	include ("./inc/config.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	echo "<?xml version='1.0' encoding='euc-kr'?>\n";
?>
<xmlstart>

<banner>
<?
	keyword_rank_read('10개출력' , 'keyword_flash.html' , 'keyword_flash_sub.html', "")
?>
</banner>

<speed Width="180" Xaxis="0" Yaxis="0" Yspace="2" openspeed="200" outtime="10000" setrank="<?=$setRank-1?>"/>
<size numcolor="FFFFFF" keycolor="676767" boxcolor="dbdbdb"/>

</xmlstart>

<!-- <?=$배경색상?> -->