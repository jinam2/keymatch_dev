<? /* Created by SkyTemplate v1.1.0 on 2023/03/14 16:42:42 */
function SkyTpl_Func_3606874303 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('<a href="html_file.php?file=bbs_index_customer.html&file2=bbs_default_customer.html">고객센터</a>') ?>

<div class="noto400 font_40" style="color:#333333; letter-spacing:-1px; padding-bottom:10px;">
	CUSTOMER CENTER <span class="noto400 font_14" style="color:#aaa">고객을 위한 고객지원문의</span>
</div>
<table cellspacing="0" width="100%" style="table-layout:fixed;">
	<tr>
		<td><a href="bbs_list.php?tb=board_notice"><img src="img/skin_icon/make_icon/skin_icon_680.jpg"></a></td>
		<td align="center"><a href="bbs_list.php?tb=board_faq"><img src="img/skin_icon/make_icon/skin_icon_681.jpg"></a></td>
		<td align="right"><a href="bbs_list.php?tb=board_qna"><img src="img/skin_icon/make_icon/skin_icon_682.jpg"></a></td>
	</tr>
</table>
<div style="margin-top:30px">
	<table cellpadding="0" cellspacing="0" style="width:100%; ">
		<tr>
			<td style="">
				<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
					<tr>
						<td style="padding-right:20px; border-right:1px solid #dfdfdf; vertical-align:top">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td>
										<h4 style="position:relative; letter-spacing:-1.2px; color:#333; padding-bottom:15px; border-bottom:1px solid #dfdfdf; margin-bottom:0;" class="font_20 noto500">
											<?board_name_out('게시판영역_02','텍스트') ?>

											<span style="position:absolute; top:0; right:0">
												<a href="<?board_link('게시판영역_02') ?>" title="<?board_name_out('게시판영역_02','텍스트') ?>"><span uk-icon="icon:more; ratio:1.0"></span></a>
											</span>
										</h4>
										<div>
											<?board_extraction_list('총5개','가로1개','제목길이999자','본문길이0자','게시판영역_02','bbs_index_rows_text_01.html','누락0개') ?>

										</div>
									</td>
								</tr>
								<tr>
									<td style="padding-top:30px">
										<h4 style="position:relative; letter-spacing:-1.2px; color:#333; padding-bottom:15px; border-bottom:1px solid #dfdfdf; margin-bottom:0;" class="font_20 noto500">
											<?board_name_out('게시판영역_08','텍스트') ?>

											<span style="position:absolute; top:0; right:0">
												<a href="<?board_link('게시판영역_08') ?>" title="<?board_name_out('게시판영역_08','텍스트') ?>"><span uk-icon="icon:more; ratio:1.0"></span></a>
											</span>
										</h4>
										<div>
											<?board_extraction_list('총10개','가로1개','제목길이999자','본문길이0자','게시판영역_08','bbs_index_rows_text_01.html','누락0개') ?>

										</div>
									</td>
								</tr>
							</table>
						</td>
						<td style="padding-left:20px; vertical-align:top">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td>
										<h4 style="position:relative; letter-spacing:-1.2px; color:#333; padding-bottom:15px; border-bottom:1px solid #dfdfdf; margin-bottom:0;" class="font_20 noto500">
											<?board_name_out('게시판영역_09','텍스트') ?>

											<span style="position:absolute; top:0; right:0">
												<a href="<?board_link('게시판영역_09') ?>" title="<?board_name_out('게시판영역_09','텍스트') ?>"><span uk-icon="icon:more; ratio:1.0"></span></a>
											</span>
										</h4>
										<div>
											<?board_extraction_list('총5개','가로1개','제목길이999자','본문길이0자','게시판영역_09','bbs_index_rows_text_01.html','누락0개') ?>

										</div>
									</td>
								</tr>
								<tr>
									<td style="padding-top:30px">
										<h4 style="position:relative; letter-spacing:-1.2px; color:#333; padding-bottom:15px; border-bottom:1px solid #dfdfdf; margin-bottom:0;" class="font_20 noto500">
											<?board_name_out('게시판영역_10','텍스트') ?>

											<span style="position:absolute; top:0; right:0">
												<a href="<?board_link('게시판영역_10') ?>" title="<?board_name_out('게시판영역_10','텍스트') ?>"><span uk-icon="icon:more; ratio:1.0"></span></a>
											</span>
										</h4>
										<div>
											<?board_extraction_list('총10개','가로1개','제목길이40자','본문길이0자','게시판영역_10','bbs_index_rows_text_01.html','누락0개') ?>

										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
<? }
?>