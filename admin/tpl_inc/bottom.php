<!-- -----------------------------------------------------------------------

	###[ YOON : 2009-10-22 작성됨 ]###

	## 안내설명 ##

	관리자 관련 프로그램파일 추가시 현재 하단정보에 해당하는
	디자인 소스코드 관련 파일이며, 아래 소스코드를 복사해서 넣어주면 됩니다.


	[ 해당 파일에 넣을 복사용 소스코드 ]
	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################

----------------------------------------------------------------------- -->

<!-- 매물폼디자인 관리메뉴일 경우 좌측메뉴 없앤형태로 출력 -->
<?
		if ( $left_menu_display == 'none' )
		{
?>
			</td>
			<td style="background:url('img/bgbox_02_v3_b.gif')"></td>
		</tr>


		<!-- BOTTOM -->
		<tr>
			<!-- 좌측  -->
			<td height=36 style="background:url('img/bgbox_02r_v1_c2.gif') no-repeat 0 0;"></td>

			<!-- 우측 -->
			<td style="background:url('img/bgbox_02_v2_c.gif');"></td>
			<td style="background:url('img/bgbox_02_v3_c.gif') no-repeat 0 0;"></td>
		</tr>
		</table>

	</td>
</tr>
</table>

<?
		}
		else
		{
?>

			</td>
			<td style="background:url('img/bgbox_02_v3_b.gif')"></td>
		</tr>



		<!-- BOTTOM -->
		<tr>
			<!-- 좌측  -->
			<td height=36 style="background:url('img/bgbox_02_v1_c2.gif') no-repeat 0 0;">
			</td>

			<!-- 우측 -->
			<td style="background:url('img/bgbox_02_v2_c.gif');"></td>
			<td style="background:url('img/bgbox_02_v3_c.gif') no-repeat 0 0;"></td>
		</tr>
		</table>

<?
		}
?>


<? include ("./html/foot.html"); ?>
