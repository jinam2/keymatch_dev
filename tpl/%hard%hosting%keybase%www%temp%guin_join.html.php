<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:49:01 */
function SkyTpl_Func_3721709272 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script>
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

		if ( doc_check == false)
		{
			alert("입사지원 하실 이력서를 선택하세요");
			return false;
		}

		return true;
	}
</script>
<h3 class="sub_tlt_st01">
	<span style="color:#<?=$_data['배경색']['기본색상']?>">온라인</span>
	<b>입사지원</b>	
</h3>
<div class="container_c" style="margin-top:50px; border-top:1px solid #ddd;">
	<form name="guin_join_frm" onSubmit="return Sendit()" method="post">
		<input type="hidden" name="mode" value="action">
		<input type='hidden' name='cNumber' value='<?=$_data['_POST']['cNumber']?>'>
		<input type='hidden' name='com_id' value='<?=$_data['_POST']['com_id']?>'>
		<input type='hidden' name='com_name' value='<?=$_data['_POST']['com_name']?>'>
		<input type='hidden' name='per_id' value='<?=$_data['user_id']?>'>
		<ul style="border-bottom:1px solid #ddd;">
			<li style="padding-bottom:40px;">
				<h3 class="guin_d_tlt_st02" style="position:relative;">
					<span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>;  margin:0 10px 3px 0;"></span>이력서 선택
					<p class="noto400 font_15" style="color:#777777; letter-spacing:-1px; position:absolute; display:inline-block; right:0; top:50px;">온라인 지원에 사용할 이력서를 선택하세요.</p>
				</h3>
				<div class="doc_list">
					<?document_extraction_list_main('가로3개','세로9개','옵션1','옵션2','옵션3','내가등록한공개중인이력서','최근등록일순','50글자짜름','누락0개','doc_rows_short.html','doc_list_nouse.html') ?>

				</div>
			</li>
			<li style="padding-bottom:40px;">
				<h3 class="guin_d_tlt_st02" style="position:relative;">
					<span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>;  margin:0 10px 3px 0;"></span>연락처 선택
					<p class="noto400 font_15" style="color:#777777; letter-spacing:-1px; position:absolute; display:inline-block; right:0; top:50px;">공개할 연락처를 선택하세요.</p>
				</h3>
				<table cellpadding="0" cellspacing="0" style="width:100%; border-top:1px solid #d8d8d8; border-bottom:1px solid #d8d8d8; background:#f8f8f8">
					<tbody>
						<tr>
							<td style=" text-align:center">
								<div style="padding:15px 0;">
									<span class="h_form" style="display:inline-block; _display:inline; *zoom:1; margin-right:40px">
										<label class="h-check" for="홈페이지"><input type="checkbox" name="secure[]" id="홈페이지" value="홈페이지" ><span class="noto400 font_15">홈페이지</span></label>
									</span>
									<span class="h_form" style="display:inline-block; _display:inline; *zoom:1; margin-right:40px">
										<label class="h-check" for="전화번호" ><input type="checkbox" name="secure[]" value="전화번호" id="전화번호" ><span class="noto400 font_15">전화번호</span></label>
									</span>
									<span class="h_form" style="display:inline-block; _display:inline; *zoom:1; margin-right:40px">
										<label class="h-check" for="핸드폰" ><input type="checkbox" name="secure[]" value="핸드폰" id="핸드폰" ><span class="noto400 font_15">핸드폰</span></label>
									</span>
									<span class="h_form" style="display:inline-block; _display:inline; *zoom:1; margin-right:40px">
										<label class="h-check" for="주소" ><input type="checkbox" name="secure[]" value="주소" id="주소"><span class="noto400 font_15">주소</span></label>
									</span>
									<span class="h_form" style="display:inline-block; _display:inline; *zoom:1">
										<label class="h-check" for="E-mail" ><input type="checkbox" name="secure[]" value="E-mail" id="E-mail" ><span class="noto400 font_15">E-mail</span></label>
									</span>
								</div>
								<span class="noto400 font_14" style="display:block; border-top:1px solid #d8d8d8; padding:15px; text-align:center; letter-spacing:-1px; line-height:18px; color:#8b8b8b; background:#fcfcfc;">항목을 선택하지 않으셔도, 이력서 열람하기 권한(옵션)이 있는 기업회원은 열람이 가능합니다.</span>
							</td>
						</tr>
					</tbody>
				</table>
			</li>
			<li>
				<?=$_data['인터뷰']?>				
			</li>
		</ul>
		<div style="margin-top:50px;" align="center">
			<input type="submit" style="width:200px; height:54px; background:url('img/skin_icon/make_icon/skin_icon_732.jpg') 0 0 no-repeat; text-indent:-1000px; cursor:pointer; border-radius:3px;" value=" 온라인이력서 접수 ">
		</div>
	</form>	
</div>
<? }
?>