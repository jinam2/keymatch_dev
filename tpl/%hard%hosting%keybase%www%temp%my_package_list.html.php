<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 16:22:11 */
function SkyTpl_Func_601545981 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('패키지 결제/사용내역') ?>


<script>
var pay_type = '<?=$_data['pay_type']?>';
function use_package_member(pack_number,str,url)
{
	if ( pack_number == "" )
	{
		alert("사용하실 패키지권을 선택하세요");
		sel_obj.focus();
	}
	else
	{
		if ( confirm(str) )
		{
			document.location.href = "my_package_use.php?mode=use&prev_url="+url+"&pack_number="+pack_number+"&pay_type="+pay_type;
		}
	}
}
</script>

<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	유료서비스
</div>

<?include_template('member_count_com.html') ?>


<div style="border:2px solid #666666; margin-top:20px;">
	<p style="overflow:hidden; background:#f8f8f8; border-bottom:1px solid #ccc; padding:15px 20px">
		<strong class="font_18 noto500" style="display:block; float:left; width:60%; letter-spacing:-1px;">유료옵션별 채용공고</strong>
		<span class="font_14 noto400" style="display:block; float:right; width:40%; text-align:right; letter-spacing:-1px;">내가 등록한 채용공고 중 옵션이 적용된 채용공고의 개수입니다.</span>
	</p>
	<div style=" padding:20px;">
		<table cellspacing="0" cellpadding="0" style="width:100%" class="my_tablecell">
		<?=$_data['서비스이용항목']?>

		</table>
	</div>	
</div>

<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>패키지 결제/사용내역
</h3>

<form name="package_search" id="package_search" method="get" action="<?=$_data['PHP_SELF']?>" style="margin0px;padding:0px;">
	<input type="hidden" name="mode" value="list">
	<input type="hidden" name="pay_type" value="<?=$_data['pay_type']?>">
	<div style="border-top:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf;  background-color:#fafafa; padding:30px; margin-bottom:20px;">
		<table cellspacing="0">
			<tr>
				<td style="width:77px; text-align:left; color:#666666" align="center" class="font_14 noto400">
					SEARCH
				</td>
				<td style="padding-right:5px;" class="h_form">
					<span style="display:inline-block; width:100px;"><?=$_data['search_sangtae_info']?></span>
					<span style="display:inline-block; width:150px;"><?=$_data['search_option_info']?></span>
					<input type="text" name="pack_title" id="pack_title" value="<?=$_data['_GET']['pack_title']?>" style="width:650px;">
					<button class="h_btn_st1 icon_m uk-icon search_color" uk-icon="icon:search; ratio:0.8">검색</button>
				</td>
			</tr>
		</table>
	</div>
</form>

<table cellspacing="0" style="width:100%; background:#fafafa; border-top:1px solid #d5d5d5; border-bottom:1px solid #dfdfdf">
	<tr>
		<td class="font_16 noto400" style="width:50px; color:#999999; letter-spacing:-1px; height:40px;" align="center">번호</td>
		<td class="font_16 noto400" style="width:240px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #ccc;" align="center">패키지명</td>
		<td class="font_16 noto400" style="color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #ccc;" align="center">패키지내용</td>
		<td class="font_16 noto400" style="width:130px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #ccc;" align="center">등록일</td>
		<td class="font_16 noto400" style="width:130px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #ccc;" align="center">마감일</td>
		<td class="font_16 noto400" style="width:100px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #ccc;" align="center">사용일</td>
	</tr>
</table>
<div>
	<?package_list('페이지당20개','가로1개','rows_package_list.html','자동','마감일역순') ?>

</div>

<table cellspacing="0" cellpadding="0" style="width:100%;">
	<tr>
		<td align="center"><?=$_data['패키지페이징']?></td>
	</tr>
</table>
<? }
?>