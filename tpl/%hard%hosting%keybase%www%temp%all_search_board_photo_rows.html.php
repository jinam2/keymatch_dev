<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:06 */
function SkyTpl_Func_1617104641 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="padding:5px 0;">
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style="padding:3px; border:1px solid #e9e9e9;">
				<a href="bbs_detail.php?bbs_num=<?=$_data['Data']['number']?>&tb=<?=$_data['B_CONF']['tbname']?>">
					<img src='<?=$_data['Data']['thumb']?>' width="120" height="110" border=0 style="border-color:#CCCCCC;" onError="this.src='img/noimg_4.gif'">
				</a>
			</td>
			<td align="left" style="vertical-align:top; padding-left:10px;">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<div class="font_15 noto500 ellip" style="width:790px;">
								<a href="bbs_detail.php?bbs_num=<?=$_data['Data']['number']?>&tb=<?=$_data['B_CONF']['tbname']?>" style="color:#333;"><?=$_data['제목']?></a>
							</div>
						</td>
					</tr>
					<tr>
						<td style="padding-top:5px; color:#a3a3a3;">
							<div class="ellipsis_line_3 noto400 font_13" style="width:790px; height:62px; line-height:1.6;">
								<a href="bbs_detail.php?bbs_num=<?=$_data['Data']['number']?>&tb=<?=$_data['B_CONF']['tbname']?>"><?=$_data['Data']['bbs_review']?></a>
							</div>
						</td>
					</tr>
					<tr>
						<td class="font_tahoma font_13" style="padding-top:10px">
							<?=$_data['Data']['bbs_date']?>

						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

<script>all_search_result = 'ok'; // 검색결과 나왔다는 확인용 변수값에 ok값 넣기</script>
<? }
?>