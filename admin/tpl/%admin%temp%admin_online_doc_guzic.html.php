<? /* Created by SkyTemplate v1.1.0 on 2023/03/17 09:37:41 */
function SkyTpl_Func_LOOP ($TPL,$DATA,$_index,$_size,$_col) { if (is_null($DATA) && $_size==1) $DATA=array($GLOBALS); $to=$_index+$_col; if ($to>$_size) $to=$_size; for (;$_index<$to;$_index++) { $_data=$DATA[$_index]; ?>


	<tr>
		<td style="text-align:center;"><?=$_data['checkbox']?> <?=$_data['auto_number']?></td>
		<td style="text-align:center;" class="bg_green"><font color="#559900"><?=$_data['p_id']?></font></td>
		<td><a href="../document_view.php?number=<?=$_data['number']?>" style="color:#676565;"><?=$_data['doc_title']?></a></td>
		<td style="text-align:center;" class="bg_sky"><font color="#0099ff"><?=$_data['c_id']?></a></td>
		<td><a href="../guin_detail.php?num=<?=$_data['guin_number']?>" style='color:#676565;'><?=$_data['guin_title']?></a></td>
		<td style="text-align:center;"><?=$_data['select_stats']?> <?=$_data['btn_change']?></td>
	</tr>
	<? }
if (!$_size) { ?>

	<tr>
		<td colspan="6" align="center" style='padding:20px 0 20px 0;'><?=$_data['search_word']?> 회원의 온라인 입사지원건이 없습니다.</td>
	</tr>
	
<? } }

function SkyTpl_Func_2892158064 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script>
function OnlineDel(num)
{
	TmpUrl = '';
	if ( confirm("온라인입사지원건이 확인전이므로 취소하실수 있습니다.\n\n취소하시겠습니까?") )
	{
		TmpUrl = './admin_online_doc.php?mode=del';
		TmpUrl += '&number='+num;
		TmpUrl += '&pg=<?=$_data['_GET']['pg']?>';

		document.location.href = TmpUrl;

	}
}

function change_stats(bNumber)
{
	//alert(bNumber);
	selName = "online_stats_"+bNumber;
	selObj = document.getElementById(selName);

	url = "admin_online_doc_change.php?";
	url+= "bNumber="+bNumber;
	url+= "&online_stats="+selObj.value;

	//window.open(url);
	document.getElementById('change_online').src = url;
}

function change_stats_all()
{
	msg = "선택한 온라인 이력서 신청을 모두 변경하시겠습니까?";

	obj = document.getElementsByName("sel_online[]");
	cnt = obj.length;
	bNumbers = new Array();
	for( i=0;i<cnt;i++ )
	{
		if ( obj[i].checked == true )
		{
			bNumbers.push(obj[i].value);
		}
	}

	if ( bNumbers.length == 0 )
	{
		alert("하나라도 선택하셔야 합니다.");
		return;
	}

	if ( confirm(msg) )
	{
		selName = "online_stats_all";
		selObj = document.getElementById(selName);

		url = "admin_online_doc_change.php?";
		url+= "mode=multi";
		url+= "&bNumber="+bNumbers.join("_cut_");
		url+= "&online_stats="+selObj.value;

		//alert(url);

		document.getElementById('change_online').src = url;
	}
}


</script>

<p class="main_title"><?=$_data['Doc']['user_id']?> 회원의 온라인입사지원 관리</p>

<iframe id="change_online" width="400" height="100" style="display:none;"></iframe>
<form name="search_online" method="get" action="admin_online_doc.php" style="margin:0px;padding:0px;">
<input type="hidden" name="guin_number" value="<?=$_data['_GET']['guin_number']?>">

<div id="list_style">
	<table cellspacing="0" cellpadding="0" style="width:100%;" class="bg_style table_line">
	<colgroup>
		<col style="width:5%;"></col>
		<col style="width:10%;"></col>
		<col></col>
		<col style="width:10%;"></col>
		<col></col>
		<col style="width:12%;"></col>
	</colgroup>
	<tr>
		<th>번호</th>
		<th>구직회원아이디</th>
		<th>이력서명</th>
		<th>구인회원아이디</th>
		<th>채용정보명</th>
		<th>상태변경</th>
	</tr>
	<? if (is_array($_data['LOOP'])) $TPL->assign('LOOP',$_data['LOOP']); $TPL->tprint('LOOP'); $GLOBALS['LOOP']=''; ?>

	</table>
</div>
<div align="center" style="padding:20px 0 20px 0;"><?=$_data['page_print']?></div>
<div align="center" class="input_style_adm">선택한 이력서의 상태를 모두 <?=$_data['select_stats_all']?> <?=$_data['btn_change_all']?></div>

</form>
<? }
?>