<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:06 */
function SkyTpl_Func_1347315553 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="all_saerch_rows2">
	<table cellpadding="0" cellspacing="0" border="0" style="100%; border-collapse: collapse;">
		<tr>
			<td align="center">
				<a href="bbs_detail.php?bbs_num=<?=$_data['Data']['number']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['B_CONF']['tbname']?>">
					<img src='<?=$_data['Data']['thumb']?>' width="304" height="150" border="0">
				</a>
			</td>
		</tr>
		<tr>
			<td style="padding:14px; border:1px solid #eaeaea">
				<table cellpadding="0" cellspacing="0" style="width:100%">
					<tr>
						<td>
							<div class="font_15 noto500 ellip" style="width:275px; height:22px;">
							<a href="bbs_detail.php?bbs_num=<?=$_data['Data']['number']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['B_CONF']['tbname']?>" style="color:#333;"><?=$_data['제목']?></a>
							</div>
						</td>
					</tr>
					<tr>
						<td style="padding-top:5px">
							<div class="ellipsis_line_2 noto400 font_13" style="width:275px; height:42px; line-height:1.6;">
								<a href="bbs_detail.php?bbs_num=<?=$_data['Data']['number']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['B_CONF']['tbname']?>" style="color:#666" >
									<?=$_data['Data']['bbs_review']?>

								</a>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="noto400 font_13" style="padding:10px 14px; border:1px solid #eaeaea; background:#fafafa; color:#666666">
				<span class="font_tahoma"><?=$_data['Data']['bbs_date']?></span>
				<span class="font_tahoma" style="color:#999999">|</span>
				<?=$_data['Data']['bbs_name']?>

				<span class="font_tahoma" style="color:#999999">|</span>
				<span style="color:#999999">조회</span>  <span class="font_tahoma"><?=$_data['Data']['bbs_count']?></span>
			</td>
		</tr>
	</table>
</div>

<script>all_search_result = 'ok'; // 검색결과 나왔다는 확인용 변수값에 ok값 넣기</script>
<? }
?>