<?php

	include ("./inc/config.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	echo "<?xml version=\"1.0\" encoding=\"euc-kr\"?>";

	# selectCOLOR = $cloudtag_selectCOLOR �� ���� ����
	# �׷� default ������ $������ �׿� �׷���� ������ $����[�׷��]
?>


<xmlstart>

<keyword>

<?php
	$ReturnRank = keyword_rank_read('14�����' , 'keyword_flash.html' , 'rows_cloudtag.html', "", 'return');

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