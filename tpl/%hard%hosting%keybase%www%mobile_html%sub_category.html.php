<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 15:20:36 */
function SkyTpl_Func_1646077860 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="" class="upcate">
	<div style="padding-right:10px; padding-bottom:10px">
		<table style="width:100%; border:2px solid #bfbfbf" class="tbl" >
			<tr>
				<td style="padding:10px 10px"  onclick="location.href='<?=$_data['SUB_CATE']['link']?>'">
					<table style="width:100%;" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td class="font_16 font_malgun" style="letter-spacing:-1.2px; padding:10px 0 10px 8px 0"><span class="ellipsis_line1"><?=$_data['SUB_CATE']['title']?></span></td>
						<td align="right" style="width:20%; text-align:right">
							<strong class="font_tahoma font_20" style="color:#5a5959;"><?=$_data['SUB_CATE']['count']?></strong>
						</td>
					</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>
<? }
?>