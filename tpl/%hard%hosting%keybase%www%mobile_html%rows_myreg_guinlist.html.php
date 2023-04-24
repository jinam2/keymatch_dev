<? /* Created by SkyTemplate v1.1.0 on 2023/03/24 20:23:40 */
function SkyTpl_Func_3613884590 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="margin-bottom:20px">
	<table cellpadding="0" cellspacing="0" style="width:100%" class="tb_st_04">
		<tbody>
			<tr>
				<th class="h_form" style="text-align:left; position:relative; padding-left:55px; box-sizing:border-box;">
					<?=$_data['checked_info_bgcolor']?>

					<label class="h-radio" style="display:block; position:absolute; left:15px; top:12px;">
						<input type="radio" name="guin_number" id="guin_number" value="<?=$_data['Data']['number']?>" <?=$_data['checked_info']?>><span></span>
					</label>
					<a href="./guin_detail.php?num=<?=$_data['Data']['number']?>" style="border:none; padding:0; font-weight:bold; letter-spacing:-1.5px; font-size:1.1em; text-align:left;">
						<strong class="font_tahoma">[ <?=$_data['Data']['number']?> ] </strong>				
						<b><?=$_data['Data']['guin_title']?></b>
					</a>
				</th>
			</tr>				
			<tr>
				<td>
					<table class="tb_st_04_in_tb" style="width:100%;">
						<colgroup>
							<col width="25%;" />
							<col width="75%;" />
						</colgroup>
						<tbody>
							<tr>
								<td style="color:#B8B8B8; letter-spacing:-1px" class="noto400 font_15">
									담당업무
								</td>
								<td class="noto400 font_15" style="color:#666; letter-spacing:-1px; line-height:160%;">
									<?=$_data['Data']['guin_work_content']?>

								</td>
							</tr>
							<tr>
								<td style="color:#B8B8B8; letter-spacing:-1px; padding-top:10px" class="noto400 font_15">
									직종
								</td>
								<td class="noto400 font_15" style="color:#666; letter-spacing:-1px; line-height:160%;">
									<?=$_data['Data']['guin_job']?>

								</td>
							</tr>
							<tr>
								<td style="color:#B8B8B8; letter-spacing:-1px; padding-top:10px" class="noto400 font_15">
									키워드
								</td>
								<td class="noto400 font_15" style="color:#666; letter-spacing:-1px; line-height:160%;">
									<?=$_data['Data']['keyword']?>

								</td>
							</tr>
						</tbody>
					</table>
				</td>	
			</tr>
		</tbody>		
	</table>				
</div>

<? }
?>