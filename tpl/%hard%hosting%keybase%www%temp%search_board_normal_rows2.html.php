<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:06 */
function SkyTpl_Func_249676429 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="padding:10px 10px; border-top:1px solid #eaeaea">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<div class="ellip font_15 noto500" style="width:916px; height:22px;">
					<a href="bbs_detail.php?bbs_num=<?=$_data['Data']['number']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['B_CONF']['tbname']?>" style="font-weight:bold; color:#333">
						<?=$_data['제목']?> <?=$_data['Data']['댓글']?>

					</a>
				</div>
			</td>
		</tr>
		<tr>
			<td style="padding:5px 0 5px 0">
				<div class="ellipsis_line_2 font_13 noto400" style="width:916px; height:42px; color:#666; line-height:1.6">
					<a href="bbs_detail.php?bbs_num=<?=$_data['Data']['number']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['B_CONF']['tbname']?>" style="color:#666"><?=$_data['Data']['bbs_review']?></a>
				</div>
			</td>
		</tr>
		<tr>
			<td class="noto400 font13" style="color:#999999">
				등록일 <span class="font_tahoma" style="color:#666"><?=$_data['Data']['bbs_date']?></span> <span class="font_tahoma">|</span> 작성자 <span style="color:#666"><?=$_data['Data']['bbs_name']?></span> <span class="font_tahoma">|</span> 조회 <span class="font_tahoma" style="color:#666"><?=$_data['Data']['bbs_count']?></span>
			</td>
		</tr>
	</table>
</div>


<script>all_search_result = 'ok'; // 검색결과 나왔다는 확인용 변수값에 ok값 넣기</script>
<? }
?>