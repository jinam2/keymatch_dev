<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 11:07:58 */
function SkyTpl_Func_1419585790 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td>


		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="14" height="14" background="<?=$_data['main_url']?>/img/mail/bg_mailbox01a.gif"></td>
			<td background="<?=$_data['main_url']?>/img/mail/bg_mailbox01b.gif"><img src="blank.gif" width=0 height=0 border=0></td>
			<td width="14" background="<?=$_data['main_url']?>/img/mail/bg_mailbox01c.gif"></td>
		</tr>
		</table>


		<!-- 타이틀 -->
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td bgcolor="#274C7F" style="padding:15 25 12 25; color:#DDD; font-size:17px; font-weight:bold;">


				<img src="<?=$_data['main_url']?>/img/mail/txt_notify_guin.gif" border=0 style="margin-bottom:6px;"><BR>

				<FONT COLOR="white"><?=$_data['com_name']?></FONT>님 <?=$_data['site_name']?>에 채용정보를 등록하셨습니다.


			</td>
		</tr>
		</table>
		<!-- 타이틀 -->


		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="14" background="<?=$_data['main_url']?>/img/mail/bg_mailbox01d.gif"></td>
			<td bgcolor="#F3F3F3" style="padding:25 0 10 0; font-size:13px; font-weight:bold;">


				<?=$_data['site_name']?>에 <?=$_data['com_name']?>님이 등록하신 채용정보는 아래와 같습니다.

			</td>
			<td width="14" background="<?=$_data['main_url']?>/img/mail/bg_mailbox01e.gif"></td>
		</tr>
		</table>




		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="14" background="<?=$_data['main_url']?>/img/mail/bg_mailbox01d.gif"></td>
			<td bgcolor="#FFFFFF" style="padding:25px; border-width:1px; border-style:solid; border-color:#CCC;">


				<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
				<tr bgcolor="#FFFFFF">
					<td width="160" style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#C5ECB5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 채용정보 제목</td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['guin_title']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#FDF5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 등록시간</td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['regdate']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#FDF5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 담당업무</td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['guin_work_content']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#FDF5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 1차업직종 </td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['type1_title']?><?=$_data['type1_sub_title']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#FDF5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 2차업직종 </td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['type2_title']?><?=$_data['type2_sub_title']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#FDF5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 3차업직종 </td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['type3_title']?><?=$_data['type3_sub_title']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#FDF5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 학력 </td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['guin_edu']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#FDF5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 경력</td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['guin_career']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#FDF5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 고용형태</td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['guin_type']?> </td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#FDF5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 1차희망지역 </td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['si1_title']?><?=$_data['gu1_title']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#FDF5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 2차희망지역 </td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['si2_title']?><?=$_data['gu2_title']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#FDF5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 3차희망지역 </td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['si3_title']?><?=$_data['gu3_title']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#FDF5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 접수방법</td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['howjoin']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#FDF5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 마감일</td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['guin_end_date']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#C5F5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 담당자 이름</td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['guin_name']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#C5F5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 담당자 이메일</td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['guin_email']?></td>
				</tr>

				<tr bgcolor="#FFFFFF">
					<td style="padding:8px; font-weight:bold; font-size:13px;" bgcolor="#C5F5B5"><img src="<?=$_data['main_url']?>/img/mail/arrow_rect.gif" border=0> 담당자 연락처</td>
					<td style="padding:8px; font-weight:bold; font-size:13px;" ><?=$_data['guin_phone']?></td>
				</tr>
				</table>


			</td>
			<td background="<?=$_data['main_url']?>/img/mail/bg_mailbox01e.gif"></td>
		</tr>

		<tr>
			<td height="14" background="<?=$_data['main_url']?>/img/mail/bg_mailbox01f.gif"></td>
			<td background="<?=$_data['main_url']?>/img/mail/bg_mailbox01g.gif"></td>
			<td width="14" background="<?=$_data['main_url']?>/img/mail/bg_mailbox01h.gif"></td>
		</tr>
		</table>


	</td>
</tr>
</table>
<? }
?>