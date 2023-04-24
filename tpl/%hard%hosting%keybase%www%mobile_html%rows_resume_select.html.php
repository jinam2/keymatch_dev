<? /* Created by SkyTemplate v1.1.0 on 2023/03/28 09:37:39 */
function SkyTpl_Func_55017478 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="margin-bottom:10px">
	<div style="border:1px solid #ddd; padding:10px 15px; position:relative">
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
				<td style="width:13px; padding-right:15px">
					<input type="radio" name="pNumber" value="<?=$_data['Data']['number']?>" style='cursor:pointer' id="<?=$_data['Data']['number']?>">
				</td>
				<td style="text-align:left">
					<table cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
							<td>
								<div class="ellipsis_line1">
									<label for="<?=$_data['Data']['number']?>" class="noto400 font_18" style="cursor:pointer; letter-spacing:-1px; color:#2c2c2c" >
										 <?=$_data['Data']['title']?>

									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td class="noto400 font_14" style="letter-spacing:-1px; color:#939393; line-height:20px; padding-top:7px">
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
							<img src="mobile_img/bt_phview.gif" border="0" align="absmiddle">
						</a>
					</span>
				</td>
			</tr>
		</table>
	</div>
</div>
<? }
?>