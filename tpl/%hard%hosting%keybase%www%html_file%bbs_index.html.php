<? /* Created by SkyTemplate v1.1.0 on 2023/04/21 09:21:50 */
function SkyTpl_Func_2280506595 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('<a href="html_file.php?file=bbs_index.html&file2=bbs_default_community.html">커뮤니티</a>') ?>

<div class="noto400 font_40" style="color:#333333; letter-spacing:-1px; border-bottom:1px solid #dfdfdf; padding-bottom:10px;">
	COMMUNITY <span class="noto400 font_14" style="color:#aaa">당신의 이야기를 들려주세요.</span>
</div>
<div style="margin-bottom:30px">
	<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td style="padding:20px 0 0 0; text-align:left">
				<h4 style="position:relative; letter-spacing:-1.2px; padding-bottom:15px;" class="font_20 noto500">
					<a href="<?board_link('게시판영역_05') ?>" title="<?board_name_out('게시판영역_05','텍스트') ?>" style="color:#333;"><?board_name_out('게시판영역_05','텍스트') ?></a>
					<span style="position:absolute; top:0; right:0">
						<a href="<?board_link('게시판영역_05') ?>" title="<?board_name_out('게시판영역_05','텍스트') ?>"><span uk-icon="icon:more; ratio:1.0"></span></a>
					</span>
				</h4>
				<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
					<tr>
						<td style="padding-right:20px; vertical-align:top">
							<?board_extraction_list('총1개','가로1개','제목길이999자','본문길이999자','게시판영역_05','bbs_index_rows_photo_text_01.html','누락0개') ?>

						</td>
						<td style="text-align:right; width:475px">
							<?board_extraction_list('총3개','가로1개','제목길이999자','본문길이999자','게시판영역_05','bbs_index_rows_photo_text_02.html','누락1개') ?>

						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="padding:20px 0; border-top:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf">
				<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
					<tr>
						<td style="padding-right:20px; border-right:1px solid #dfdfdf">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td>
										<h4 style="position:relative; letter-spacing:-1.2px; color:#333; padding-bottom:15px;" class="font_20 noto500">
											<a href="<?board_link('게시판영역_01') ?>" title="<?board_name_out('게시판영역_01','텍스트') ?>" style="color:#333;"><?board_name_out('게시판영역_01','텍스트') ?></a>
											<span style="position:absolute; top:0; right:0">
												<a href="<?board_link('게시판영역_01') ?>" title="<?board_name_out('게시판영역_01','텍스트') ?>"><span uk-icon="icon:more; ratio:1.0"></span></a>
											</span>
										</h4>
										<div>
											<table cellpadding="0" cellspacing="0">
												<tr>
													<td style="padding-right:15px; vertical-align:top">
														<?board_extraction_list('총1개','가로1개','제목길이999자','본문길이0자','게시판영역_01','bbs_index_rows_photo_text_03.html','누락0개') ?>

													</td>
													<td style="vertical-align:top">
														<?board_extraction_list('총6개','가로1개','제목길이999자','본문길이0자','게시판영역_01','bbs_index_rows_text_02.html','누락1개') ?>

													</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
							</table>
						</td>
						<td style="padding-left:20px; vertical-align:top">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td>
										<h4 style="position:relative; letter-spacing:-1.2px; color:#333; padding-bottom:15px;" class="font_20 noto500">
											<a href="<?board_link('게시판영역_11') ?>" title="<?board_name_out('게시판영역_11','텍스트') ?>" style="color:#333;"><?board_name_out('게시판영역_11','텍스트') ?></a>
											<span style="position:absolute; top:0; right:0">
												<a href="<?board_link('게시판영역_11') ?>" title="<?board_name_out('게시판영역_11','텍스트') ?>"><span uk-icon="icon:more; ratio:1.0"></span></a>
											</span>
										</h4>
										<div>
											<table cellpadding="0" cellspacing="0">
												<tr>
													<td style="vertical-align:top">
														<?board_extraction_list('총6개','가로1개','제목길이999자','본문길이0자','게시판영역_11','bbs_index_rows_text_02.html','누락0개') ?>

													</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="padding:20px 0;">
				<h4 style="position:relative; letter-spacing:-1.2px; color:#333; padding-bottom:15px;" class="font_20 noto500">
					<a href="<?board_link('게시판영역_03') ?>" title="<?board_name_out('게시판영역_03','텍스트') ?>" style="color:#333;"><?board_name_out('게시판영역_03','텍스트') ?></a>
					<span style="position:absolute; top:0; right:0">
						<a href="<?board_link('게시판영역_03') ?>" title="<?board_name_out('게시판영역_03','텍스트') ?>"><span uk-icon="icon:more; ratio:1.0"></span></a>
					</span>
				</h4>
				<table cellpadding="0" cellspacing="0" style="width:100%">
					<tr>
						<td class="bbs_float_area">
							<?board_extraction_list('총3개','가로3개','제목길이999자','본문길이999자','게시판영역_03','bbs_index_rows_photo_text_04.html','누락0개') ?>

						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="padding:20px 0">
				<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
					<tr>
						<td style="padding-right:15px; vertical-align:top">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td>
										<h4 style="position:relative; letter-spacing:-1.2px; color:#333; padding:10px; border:1px solid #e3e3e3; background:#fafafa; margin-bottom:0; padding-bottom:15px;" class="font_20 noto500">
											<?board_name_out('게시판영역_13','텍스트') ?>

											<span style="position:absolute; top:15px; right:10px">
												<a href="<?board_link('게시판영역_13') ?>" title="<?board_name_out('게시판영역_13','텍스트') ?>"><span uk-icon="icon:more; ratio:1.0"></span></a>
											<span>
										</h4>
										<div>
											<?board_extraction_list('총5개','가로1개','제목길이999자','본문길이0자','게시판영역_13','bbs_index_rows_text_03.html','누락0개') ?>

										</div>
									</td>
								</tr>
							</table>
						</td>
						<td style="padding-left:15px; vertical-align:top">
							<table cellpadding="0" cellspacing="0" style="width:100%">
								<tr>
									<td>
										<h4 style="position:relative; letter-spacing:-1.2px; color:#333; padding:10px; border:1px solid #e3e3e3; background:#fafafa; margin-bottom:0; padding-bottom:15px;" class="font_20 noto500">
											<?board_name_out('게시판영역_12','텍스트') ?>

											<span style="position:absolute; top:15px; right:10px">
												<a href="<?board_link('게시판영역_12') ?>" title="<?board_name_out('게시판영역_12','텍스트') ?>"><span uk-icon="icon:more; ratio:1.0"></span></a>
											</span>
										</h4>
										<div>
											<?board_extraction_list('총5개','가로1개','제목길이999자','본문길이0자','게시판영역_12','bbs_index_rows_text_03.html','누락0개') ?>

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