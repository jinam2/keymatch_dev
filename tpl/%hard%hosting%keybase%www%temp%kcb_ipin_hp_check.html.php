<? /* Created by SkyTemplate v1.1.0 on 2023/03/20 10:10:14 */
function SkyTpl_Func_1024559510 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="margin-top:20px;">

	<table cellspacing="0" style="width:100%;" border="0" >
		<tr>
			<td style="background:url(img/imgpart_table_logincheck_01.gif); width:3px; height:41px;"></td>
			<td style="background:url(img/imgpart_table_logincheck_02.gif);">
				<table cellspacing="0" style="width:100%;">
				<tr>
					<td align="left"><img src="img/title_check_login.gif" style="margin-left:10px;"></td>
					<td align="right" class="smfont3" style="color:#aeaeae; padding-right:10px;">
						아이핀/핸드폰 실명인증 방법중 한가지로 실명인증을 해주세요.
					</td>
				</tr>
				</table>
			</td>
			<td style="background:url(img/imgpart_table_logincheck_03.gif); width:3px; height:41px;"></td>
		</tr>
		<tr>
			<td style="background:url(img/imgpart_table_logincheck_08.gif);"></td>
			<td style="padding:19px 15px 16px 15px;" align="center">

				<table cellspacing="0" border="0">
					<tr>
						<td>
							<!-- 아이핀 실명인증 -->
							<img src="img/btn_ipin_check_big.gif" alt="아이핀연동" id="kcb_ipin_btn" onclick="window.open( 'kcb_ipin.php?select=ipin', 'kcbPop', 'left=200, top=100, status=0, width=450, height=550' )" style="cursor:pointer;" align="absmiddle">
						</td>
						<td width="40"></td>
						<td>
							<!-- 휴대폰 실명인증 -->
							<img src="img/btn_handphone_check_big.gif" alt="휴대폰인증" id="kcb_hp_btn" onclick="window.open( 'kcb_ipin.php?select=hp', 'kcbPop', 'left=200, top=100, status=0, width=430, height=590,scrollbar=yes' )" style="cursor:pointer;" align="absmiddle">
						</td>
						<td></td>
					</tr>
				</table>


			</td>
			<td style="background:url(img/imgpart_table_logincheck_04.gif);"></td>
		</tr>
		<tr>
			<td style="background:url(img/imgpart_table_logincheck_07.gif); width:3px; height:3px;"></td>
			<td style="background:url(img/imgpart_table_logincheck_06.gif);"></td>
			<td style="background:url(img/imgpart_table_logincheck_05.gif); width:3px; height:3px;"></td>
		</tr>
	</table>
	<!-- document.getElementById('kcb_ipin').src=kcb_ipin.php  -->

		
</div>





<? }
?>