<? /* Created by SkyTemplate v1.1.0 on 2023/03/29 16:11:06 */
function SkyTpl_Func_3866543382 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script type="text/javascript">
<!--
	var request;
	function createXMLHttpRequest()
	{
		if (window.XMLHttpRequest) {
			request = new XMLHttpRequest();
		}
		else {
			request = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}

	function startRequest(sel,target,size)
	{
		var trigger = sel.options[sel.selectedIndex].value;
		var form = sel.form.name;
			createXMLHttpRequest();
		request.open("GET", "sub_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
		request.onreadystatechange = handleStateChange;
		request.send(null);
	}

	function startRequest2(sel,target,size)
	{
		var trigger = sel.options[sel.selectedIndex].value;
		var form = sel.form.name;
			createXMLHttpRequest();
		request.open("GET", "sub_type_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
		request.onreadystatechange = handleStateChange;
		request.send(null);
	}

	function handleStateChange() {
		if (request.readyState == 4) {
			if (request.status == 200) {
				var response = request.responseText.split("---cut---");
				eval(response[0]+ '.innerHTML=response[1]');
				window.status="완료"
			}
		}
		if (request.readyState == 1)  {
			window.status="로딩중....."
		}
	}

	function searchbox(){
		for(i=1;i<=2;i++){
			if(document.getElementById(i).style.display == 'none'){
				document.getElementById(i).style.display='';
			}
			else{
				document.getElementById(i).style.display='none';
			}
		}
	}
//-->
</script>
<script language="javascript" src="./js/underground.js"></script>

<div style="position:relative; background:#f6f6f6" class="">
	<form  method="get" action="guin_list.php" name="a_f_guin">
	<input type="hidden" name="action" value="search">
	<input type="hidden" name="file" value="guin_list_after.html">
	<div style="padding:10px 10px 25px 10px; border-bottom:2px solid #878787">
		<table class="tbl guin_search_form" style="width:100%; table-layout:fixed">
			<tr>
				<td  class="input_style sel"><?=$_data['확장업종검색']?></td>
			</tr>
			<tr>
				<td class="font_20 font_malgun" style="color: #424242; padding: 12px 0; letter-spacing: -1.5px;">
					지역
				</td>
			</tr>
			<tr>
				<td class="area input_style" style=""><?=$_data['확장지역검색']?></td>
			</tr>
			<tr>
				<td class="font_20 font_malgun" style="color: #424242; padding:12px 0; letter-spacing: -1.5px;">
					역세권
				</td>
			</tr>
			<tr>
				<td class="area input_style" style="">
					<SCRIPT language="javascript" src="./js/underground.js"></SCRIPT><script>make_underground('<?=$_data['_GET']['underground1']?>','<?=$_data['_GET']['underground2']?>')</script>
				</td>
			</tr>
		</table>
		<table class="tbl guin_search_form" style="width:100%; table-layout:fixed">
			<tr>
				<td class="font_20 font_malgun" style="width:50%; color: #424242; padding:12px 0; letter-spacing: -1.5px;">
					학력
				</td>
				<td class="font_20 font_malgun" style="width:50%; color: #424242; padding:12px 0 12px 12px; letter-spacing: -1.5px;">
					초빙종류
				</td>
			</tr>
			<tr>
				<td class="input_style sel2_l" style="">
					<?=$_data['학력검색_구인']?>

				</td>
				<td class="input_style sel2_r" style="">
					<?=$_data['구인타입']?>

				</td>
			</tr>
			<tr>
				<td class="font_20 font_malgun" style="width:50%; color: #424242; padding:12px 0; letter-spacing: -1.5px;">
					직급
				</td>
				<td class="font_20 font_malgun" style="width:50%; color: #424242; padding:12px 0 12px 12px; letter-spacing: -1.5px;">
					연봉
				</td>
			</tr>
			<tr>
				<td class="input_style sel2_l" style="">
					<?=$_data['직급선택']?>

				</td>
				<td class="input_style sel2_r" style="">
					<?=$_data['연봉검색']?>

				</td>
			</tr>
		</table>
		<table class="tbl guin_search_form" style="width:100%; table-layout:fixed">
			<tr>
				<td class="font_20 font_malgun" style="color: #424242; padding: 12px 0; letter-spacing: -1.5px;">
					경력/나이
				</td>
			</tr>
			<tr>
				<td class="input_style sel2_l" style="">
					<?=$_data['경력검색']?>

				</td>
				<td class="input_style sel2_r" style="">
					<?=$_data['연령검색박스']?>

				</td>
			</tr>
			<tr>
				<td class="input_style" style="padding-top:30px" colspan="2">
					<span style="display:block; position:relative">
						<input type="text" name="guzic_keyword" id="guzic_keyword" value="<?=$_data['guzic_keyword']?>"  style="width:100%; padding-right:90px; border:1px solid #707070"><input type="submit" value="검색" style="color:#fff; position:absolute; right:0; top:0; letter-spacing:-1.2px; padding:0 20px; text-align:center; background:#707070; height:34px; line-height:32px; cursor:pointer" class="font_18 font_malgun">
					</span>
				</td>
			</tr>
		</table>
	</div>
	</form>
</div>

<? }
?>