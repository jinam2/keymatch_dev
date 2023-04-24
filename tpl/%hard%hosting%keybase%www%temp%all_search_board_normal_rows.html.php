<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:06 */
function SkyTpl_Func_1225552726 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="padding:10px 15px;">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="font_16 noto400" style="text-align:left;">
				<a href="bbs_detail.php?bbs_num=<?=$_data['Data']['number']?>&tb=<?=$_data['Data']['tbname']?>" style="color:#333">
					<?=$_data['제목']?>

				</a>
			</td>
			<td class="font-tahoma" style="text-align:right;">
				<?=$_data['Data']['bbs_date']?>

			</td>
		</tr>
	</table>
</div>

<script>all_search_result = 'ok'; // 검색결과 나왔다는 확인용 변수값에 ok값 넣기</script>

<? }
?>