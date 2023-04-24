<? /* Created by SkyTemplate v1.1.0 on 2023/03/29 17:30:04 */
function SkyTpl_Func_2821498547 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<style type="text/css">
	/* 모바일입사지원 관련 css*/
	.mobile_send_btn{display:block; padding:10px 0; text-align:center;  border:2px solid #dd3200; color:#fff; letter-spacing:-1.5px; font-weight:bold; font-size: 1.714em; line-height: 1.714em; background:#FF6600}
</style>
<script type="text/javascript">
<!--
function Sendit()
{
	doc_check = false;

	if ( document.guin_join_frm.pNumber == undefined )
	{
		alert("등록하신 이력서가 없습니다");
		return false;
	}
	else if ( document.guin_join_frm.pNumber.length == 0 )
	{
		alert("등록하신 이력서가 없습니다.");
		return false;
	}
	else
	{
		cnt = document.guin_join_frm.pNumber.length;
		if ( cnt == undefined )
		{
			if ( document.guin_join_frm.pNumber.checked )
			{
				doc_check = true;
			}
		}
		else
		{
			for( i=0; i<cnt; i++ )
			{
				if (document.guin_join_frm.pNumber[i].checked)
				{
					doc_check = true;
					break;
				}
			}
		}
	}

	if (doc_check == false)
	{
		alert("입사지원 하실 이력서를 선택하세요");
		return false;
	}

	return true;
}
//-->
</script>
<style type="text/css">
	h5.front_bar_st_tlt:before{background:#<?=$_data['배경색']['모바일_기본색상']?>;}
	.mobile_send_btn{background:#<?=$_data['배경색']['모바일_기본색상']?> !important; border:1px solid #<?=$_data['배경색']['모바일_기본색상']?> !important;}
</style>

	<div class="sub_wrap">
		<form name="guin_join_frm" onSubmit="return Sendit()" method="post">
			<input type="hidden" name="mode" value="action">
			<input type='hidden' name='cNumber' value='<?=$_data['_POST']['cNumber']?>'>
			<input type='hidden' name='com_id' value='<?=$_data['_POST']['com_id']?>'>
			<input type='hidden' name='com_name' value='<?=$_data['_POST']['com_name']?>'>
			<input type='hidden' name='per_id' value='<?=$_data['user_id']?>'>

			<h3 class="sub_tlt_st01">
				<span>온라인 입사지원</span>
			</h3>
			<div style="padding:10px">
				<h3 class="guin_d_tlt_st02" style="position:relative;">
					 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>이력서 선택
					 <p style="position:absolute; text-align:right; right:0; top:10px; font-size:14px; font-weight:400; color:#999">온라인 지원에 사용할 이력서를 선택하세요.</p>
				</h3>
				<div style="margin-top:20px;">
					<?document_extraction_list('가로1개','세로15개','옵션1','옵션2','옵션3','내가등록한공개중인이력서','최근등록일순','90글자짜름','누락0개','rows_resume_select.html','페이징사용안함') ?>

				</div>
			</div>
			<div <?=$_data['display_secure']?>>
				<div style="padding:10px; margin-top:40px;">
					<h3 class="guin_d_tlt_st02" style="position:relative;">
						 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>연락처 선택
						 <p style="position:absolute; text-align:right; right:0; top:10px; font-size:14px; font-weight:400; color:#999">공개할 연락처를 선택하세요.</p>
					</h3>
					<div style="margin-top:20px; padding:15px; border-top:1px solid #d8d8d8; border-bottom:1px solid #d8d8d8; background:#f8f8f8">
						<table cellpadding="0" cellspacing="0" style="width:100%; line-height:150%" class="tb_st_04_in_tb">
							<tbody>
								<tr>
									<td style="text-align:left">
										<span style="display:block">
											<input type="checkbox" name="secure[]" id="홈페이지" value="홈페이지" style="vertical-align:middle; cursor:pointer; margin-bottom:2px">
											<label for="홈페이지" style="cursor:pointer; letter-spacing:-1px" class="noto400 font_15">홈페이지</label>
										</span>
									</td>
									<td>
										<span style="display:block">
											<input type="checkbox" name="secure[]" value="전화번호" id="전화번호" style="vertical-align:middle; cursor:pointer; margin-bottom:2px">
											<label for="전화번호" style="cursor:pointer; letter-spacing:-1px" class="noto400 font_15">
												전화번호
											</label>
										</span>
									</td>
								</tr>
								<tr>
									<td>
										<span style="display:block">
											<input type="checkbox" name="secure[]" value="핸드폰" id="핸드폰" style="vertical-align:middle; cursor:pointer; margin-bottom:2px">
											<label for="핸드폰" style="cursor:pointer; letter-spacing:-1px" class="noto400 font_15">
												핸드폰
											</label>
										</span>
									</td>
									<td>
										<span style="display:block">
											<input type="checkbox" name="secure[]" value="주소" id="주소" style="vertical-align:middle; cursor:pointer; margin-bottom:2px">
											<label for="주소" style="cursor:pointer; letter-spacing:-1px" class="noto400 font_15">
												주소
											</label>
										</span>
									</td>
								</tr>
								<tr>
									<td>
										<span style="display:block">
											<input type="checkbox" name="secure[]" value="E-mail" id="E-mail" style="vertical-align:middle; cursor:pointer; margin-bottom:2px">
											<label for="E-mail" style="cursor:pointer; letter-spacing:-1px" class="noto400 font_15">
												E-mail
											</label>
										</span>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<span style="display:block; border-top:1px solid #d8d8d8; padding-top:10px; margin-top:10px; text-align:center; letter-spacing:-1px; line-height:18px; color:#8b8b8b;">항목을 선택하지 않으셔도, 이력서 열람하기 권한(옵션)이 있는 기업회원은 열람이 가능합니다.</span>
									</td>
								</tr>
							</tbody>				
						</table>
					</div>
				</div>				
			</div>
			<div style="margin-top:40px; padding:10px;">
				<?=$_data['인터뷰']?>

			</div>
			<input type="submit" value="온라인이력서 접수" class="mobile_send_btn" style="width:200px; margin:20px auto 0 ;border-radius:5px; font-size:22px; font-weight:500;">
		</div>
	</form>
</div>




<? }
?>