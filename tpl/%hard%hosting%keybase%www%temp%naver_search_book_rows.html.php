<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:07 */
function SkyTpl_Func_837763931 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<table width='100%'>
<tr>
	<td width='80' align='center' valign='top'>
		<a href='<?=$_data['Data']['link']?>' target='_blank'><img src='<?=$_data['Data']['image']?>' width='80' height='110' border='0' onError="this.src='img/img_noimage.jpg';" style="border:1px solid #d1cdc2;"></a>
	</td>
	<td valign='top' style="padding:5px 0 0 10px;" align="left">
		<a href='<?=$_data['Data']['link']?>' target='_blank'><u><font color="#0246ab"><?=$_data['Data']['title']?></font></u></a>
		<div style="padding-top:5px;"></div>
		<?=$_data['Data']['author']?><font color="#777777"> 저 </font> <font color="#D8D8D8"> | </font> <?=$_data['Data']['publisher']?> <font color="#D8D8D8"> | </font><font color="#777777"> <?=$_data['Data']['pubdate']?> </font>
		<div style="padding-top:5px;"></div>
		<font color="#777777"><strike><?=$_data['Data']['price_comma']?>원</strike></font> → <font color="#FF3E00"> <?=$_data['Data']['discount_comma']?>원</font>
		<div style="padding-top:5px;"></div>
		<font color="#777777">소개</font> <font style="line-height:16px;"><?=$_data['Data']['description']?></font>
		<div style="padding-top:5px;"></div>
		</font><font color="#777777">국제표준 도서번호(ISBN) : <font style="letter-spacing:0px;"><?=$_data['Data']['isbn']?></font></font>
	</td>
</tr>
</table>


<div style="padding-top:10px;"></div>

<? }
?>