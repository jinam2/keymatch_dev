<?php
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");

$sql = "select * from $guin_tb where number='$num'";
$result = query($sql);
$DETAIL = happy_mysql_fetch_array($result);




$j ='0'; #type
$this_bold = "";
$DETAIL[icon] = "";
foreach ($ARRAY as $list){
	$list_option = $list . "_option";

	if ($CONF[$list_option] == '기간별') {
	$DETAIL[$list] = $DETAIL[$list] - $real_gap; #날짜가 마이너스인 사람은 광고가 끝인사람임
	}
	if ($DETAIL[$list] > 0 ){ #볼드는 아이콘을 안보여준다 : detail에서는 다 보여주자
	$DETAIL[icon] .= "<img src=img/$ARRAY_NAME2[$j] border=0 align=absmiddle> ";
	}
$j++;
}

/////////////////상시채용인지 확인
if ( $DETAIL[guin_choongwon] ) {
	$DETAIL[guin_end_temp] = "충원시";
}
else {
	$DETAIL[guin_end_temp] = "$DETAIL[guin_end_date]";
}

for ( $i=1 ; $i<=5 ; $i++ )
{
	$Happy_Img_Name = array();

	if ( $DETAIL["img".$i] != "" )
	{
		$tmp		= explode(".",$DETAIL["img".$i]);
		$image_ext	= $tmp[sizeof($tmp)-1];

		/*
		if ( eregi("jp",$image_ext) )
			$image_name	= str_replace( ".".$image_ext , "_thumb.".$image_ext , $DETAIL["img".$i]);
		else
			$image_name	= $DETAIL["img".$i];
		#$image_name	= str_replace( ".".$image_ext , "_thumb.".$image_ext , $DETAIL["img".$i]);
		*/

		$Happy_Img_Name[0] = $DETAIL["img".$i];
		$image_name			= happy_image("자동",$guin_pic_width[1],$guin_pic_height[1],"로고사용안함","로고위치7번","100","gif원본출력","./img/guin_noimg.gif",$guin_pic_thumb_type,"");
		$image_name_big		= happy_image("자동",$guin_pic_width[0],$guin_pic_height[0],"로고사용함","로고위치7번","100","gif원본출력","./img/guin_noimg.gif",$guin_pic_thumb_type,"");

		${"이미지".$i}		= "<img src='". $image_name ."' width='$guin_pic_width[1]' height='$guin_pic_height[1]' align='absmiddle' onMouseOver=\"document.all.img_view.src='". $image_name_big ."'\">";
		${"이미지설명".$i}	= $DETAIL["img_text".$i];
	}
	else
	{
		${"이미지".$i}		= "<img src='img/guin_noimg.gif' align='absmiddle'>";
		${"이미지설명".$i}	= "";
		$DETAIL["img".$i]	= "img/no_guin_img.gif";
	}

	if ( $i == $_GET["nowImage"] || $i == 1 )
	{
		if ( $DETAIL["img".$i] != "" )
		{
			$Happy_Img_Name[0] = $DETAIL["img".$i];
			//$image_name = happy_image("자동","790","510","로고사용안함","로고위치7번","100","gif원본출력","./img/guin_noimg.gif","비율대로확대","2");
			$image_name		= happy_image("자동",$guin_pic_width[0],$guin_pic_height[0],"로고사용함","로고위치7번","100","gif원본출력","./img/guin_noimg.gif",$guin_pic_thumb_type,"");

			${"큰이미지"}		= "<img src='". $image_name ."' align='absmiddle' id='img_view' width='".$guin_pic_width_0."'>";
			//${"큰이미지"}		= "<img src='happy_image('".$DETAIL[img.$i]."' ,'가로600','세로450','로고사용안함','로고위치7번','퀄리티100','gif원본출력','img/document_no_img.jpg','비율대로확대')' id='img_view'>";
		}
		else
		{
			${"큰이미지"}		= "<img src='img/guin_noimg.gif' align='absmiddle' id='img_view'>";
		}
	}
}



/////////////////나이제한
if ( $DETAIL[guin_age] == "0" ) {
	$DETAIL[guin_age_temp] = "제한 없음";
}
else {
	$DETAIL[guin_age_temp] = "$DETAIL[guin_age] 년 이후 출생자";
}

//////////////////경력 여부
if ( $DETAIL[guin_career] == "경력" ) {
	$DETAIL[guin_career_temp] = "경력 $DETAIL[guin_career_year] 이상";
}
else {
	$DETAIL[guin_career_temp] = "$DETAIL[guin_career]";
}

#근무지역
if ($DETAIL[si1]){
	if ($GU{$DETAIL[gu1]} == ''){
	$GU{$DETAIL[gu1]} = '전체';
	}
$DETAIL[area] .= "&nbsp;&nbsp;".$SI{$DETAIL[si1]} . " - " . $GU{$DETAIL[gu1]} ;
}
if ($DETAIL[si2]){
	if ($GU{$DETAIL[gu2]} == ''){
	$GU{$DETAIL[gu2]} = '전체';
	}
$DETAIL[area] .= "<br>&nbsp;&nbsp;" . $SI{$DETAIL[si2]} . " - " . $GU{$DETAIL[gu2]} ;
}
if ($DETAIL[si3]){
	if ($GU{$DETAIL[gu3]} == ''){
	$GU{$DETAIL[gu3]} = '전체';
	}
$DETAIL[area] .= "<br>&nbsp;&nbsp;" . $SI{$DETAIL[si3]} . " - " . $GU{$DETAIL[gu3]} ;
}

#채용분야
if ($DETAIL[type1]){
$DETAIL[type] .= "&nbsp;&nbsp;".$TYPE{$DETAIL[type1]} . " - " . $TYPE_SUB{$DETAIL[type_sub1]} ;
}
if ($DETAIL[type2]){
$DETAIL[type] .= "<br>&nbsp;&nbsp;".$TYPE{$DETAIL[type2]} . " - " . $TYPE_SUB{$DETAIL[type_sub2]} ;
}
if ($DETAIL[type3]){
$DETAIL[type] .= "<br>&nbsp;&nbsp;".$TYPE{$DETAIL[type3]} . " - " . $TYPE_SUB{$DETAIL[type_sub3]} ;
}

#외국어능력
list($DETAIL[lang_title1],$DETAIL[lang_type1],$DETAIL[lang_point1],$DETAIL[lang_title2],$DETAIL[lang_type2],$DETAIL[lang_point2]) = split(",",$DETAIL[guin_lang]);
#인터뷰정리 , 내용
$DETAIL[guin_interview] = ereg_replace ("\n", "<br>", $DETAIL[guin_interview]);
$DETAIL[guin_main] = ereg_replace ("\n", "<br>", $DETAIL[guin_main]);
#복리후생
$DETAIL[guin_bokri] = ereg_replace (">", ",", $DETAIL[guin_bokri]);

#회사정보뽑기
$sql = "select * from $happy_member where user_id='$DETAIL[guin_id]'";
$result = query($sql);
$COM = happy_mysql_fetch_array($result);

$naver_get_addr	= $COM['user_addr1'] ." ". $COM['user_addr2'];


if ($master_check == '1'){
$admin_action = <<<END
<script language="javascript">
<!--
	function bbsdel(strURL) {
		var msg = "삭제하시겠습니까?";
		if (confirm(msg)){
			window.location.href= strURL;

		}
	}
	-->
</script>
&nbsp; &nbsp;<font size=1></b><a href=guin_mod.php?mode=mod&num=$DETAIL[number]&own=admin>MOD</a> |
<a href="javascript:bbsdel('./del.php?mode=guin&num=$DETAIL[number]&own=admin');">DEL</a>
END;
}


$DETAIL[guin_title] .= $admin_action;

$현재위치 = "$prev_stand > <a href=./guin_list.php>구인정보</a> > 상세보기";


if (  file_exists ("./upload/$COM[etc1]") && $COM[etc1] != ""  ) {
	$COM[logo_temp] = "<img src='./upload/$COM[etc1]' width='150' align='absmiddle'>";
}
else {
	$COM[logo_temp] = "<img src='./img/logo_img.gif' align='absmiddle'>";
}


$TPL->define("구인상세", "./$skin_folder/guin_detail_img.html");
$TPL->assign("구인상세");

echo $TPL->fetch();
exit;


?>