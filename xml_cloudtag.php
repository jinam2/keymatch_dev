<?php

	include ("./inc/config.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	echo "<?xml version=\"1.0\" encoding=\"euc-kr\"?>";

	# selectCOLOR = $cloudtag_selectCOLOR 이 원래 변수
	# 그룹 default 변수는 $배경색상 그외 그룹들의 색상은 $배경색[그룹명]
?>


<xmlstart>

<keyword>

<?php
	$ReturnRank = keyword_rank_read('14개출력' , 'keyword_flash.html' , 'rows_cloudtag.html', "", 'return');

	if ( is_array($ReturnRank) )
	{
		foreach($ReturnRank as $v)
		{
			echo $v;
		}
	}?>

</keyword>

<option Wgap="<?=$cloudtag_Wgap?>" Hgap="<?=$cloudtag_Hgap?>" Width="<?=$cloudtag_Width?>" selectCOLOR="<?=$cloudtag_selectCOLOR?>" selectBG="<?=$cloudtag_selectBG?>" cutlineCOLOR="<?=$cloudtag_cutlineCOLOR?>"/>

</xmlstart>