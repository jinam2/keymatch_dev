<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:49:01 */
function SkyTpl_Func_112909084 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="width:390px; margin-right:15px; margin-bottom:15px">
	<div style="border:1px solid #ddd; padding:10px 15px; position:relative">
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
				<td class="h_form" style="width:28px; padding-right:10px;">
					<label for="<?=$_data['Data']['number']?>" class="h-radio"><input type="radio" name="pNumber" value="<?=$_data['Data']['number']?>" id="<?=$_data['Data']['number']?>"><span></span></label>
				</td>
				<td style="text-align:left">
					<table cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
							<td>
								<div style="width:310px;" class="ellipsis_line_1">
									<label for="<?=$_data['Data']['number']?>" class="noto400 font_16" style="cursor:pointer; letter-spacing:-1px; color:#2c2c2c" >
										 <?=$_data['Data']['title']?>

									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td class="noto400 font_14" style="letter-spacing:-1px; color:#939393; line-height:20px; padding-top:5px">
								등록일 <span class="font_tahoma" style="letter-spacing:0"><?=$_data['Data']['regdate_cut']?></span>
							</td>
						</tr>
						<tr>
							<td class="noto400 font_14" style="letter-spacing:-1px; color:#2c2c2c; line-height:20px">
								수정일 <span class="font_tahoma" style="letter-spacing:0"><?=$_data['Data']['modifydate_cut']?></span>
							</td>
						</tr>
					</table>
					<span style="position:absolute; right:-1px; bottom:-1px">
						 <a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>" target="_blank">
							<img src="img/bt_phview.gif" border="0" align="absmiddle">
						</a>
					</span>
				</td>
			</tr>
		</table>
	</div>
</div>
<? }
?>