<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 17:39:57 */
function SkyTpl_Func_LOOP ($TPL,$DATA,$_index,$_size,$_col) { if (is_null($DATA) && $_size==1) $DATA=array($GLOBALS); $to=$_index+$_col; if ($to>$_size) $to=$_size; for (;$_index<$to;$_index++) { $_data=$DATA[$_index]; ?>


	<tr>
		<td style="text-align:center;"><?=$_data['auto_number']?></td>
		<td><?=$_data['title']?></td>
		<td class="img_bottom" style="padding:20px 10px; line-height:22px"><?=$_data['uryo_detail']?></td>
		<td style="text-align:center;"><?=$_data['reg_date']?></td>
		<td style="text-align:center;"><?=$_data['stats_text']?></td>
		<td style="text-align:center;"><?=$_data['btn_mod']?><br><br> <?=$_data['btn_del']?></td>
	</tr>
	<? }
if (!$_size) { ?>

	<tr>
		<td colspan="7" style="text-align:center; padding:20px;">패키지유료옵션 설정이 없습니다.</td>
	</tr>
	
<? } }

function SkyTpl_Func_12680142 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<form name="search_online" method="get" action="money_setup_package2.php" style="margin:0px;padding:0px;">
<input type="hidden" name="pay_type" value="<?=$_data['pay_type']?>">

<p class='main_title'><?=$_data['now_location_subtitle']?></p>

<div class="help_style">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>
	<span class="help">도움말</span>
	<p>
	- 채용정보 등록시 결제부분에서 이용할 수 있습니다. <br>
	- 이곳에서 패키지 등록시 관리자가 원하는 유료부분을 묶어 보여줄수있으며 추가옵션 부분에서는 임의로 새로운 유료부분을 추가하여 관리자가 직접 관리할 수 있습니다.<br>
	- 위치 및 효과보기 링크는 결제된 광고가 어디에 노출될것인지 위치를 안내해주는 팝업창형태이며, 파일명을 넣지않을시 아이콘이 출력되지 않습니다.<br><br>
	<img src='../img/pack_info.jpg'>
	</p>
</div>


<div id='list_style'>
	<table cellspacing='0' cellpadding='0' border='0' class='bg_style table_line'>
	<tr>
		<th style="width:40px;">번호</th>
		<th>패키지제목</th>
		<th>패키지내용</th>
		<th style="width:150px;">등록일</th>
		<th style="width:100px;">상태</th>
		<th style="width:60px;">관리툴</th>
	</tr>
	<? if (is_array($_data['LOOP'])) $TPL->assign('LOOP',$_data['LOOP']); $TPL->tprint('LOOP'); $GLOBALS['LOOP']=''; ?>

	</table>
</div>

<div align="center" style="margin:20px 0 20px 0;"><?=$_data['page_print']?></div>
<div align="center" style="padding:20px 0 20px 0;"><a href="money_setup_package2.php?mode=regist&pay_type=<?=$_data['pay_type']?>" alt="유료설정등록" title="유료설정등록" class="btn_big">유료설정등록</a></div>

<div align="center" class="input_style_adm" style="margin-top:10px">
	<select name="search_type">
		<option value="" <?=$_data['search_type_0']?>>전체</option>
		<option value="title" <?=$_data['search_type_1']?>>패키지제목</option>
	</select>
	<input type="text" name="search_word" value="<?=$_data['_GET']['search_word']?>" style="vertical-align:middle">
	<input type="submit" value="검색하기" class="btn_small_dark" style="height:29px">
</div>
</form>
<? }
?>