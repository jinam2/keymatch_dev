<?php
include ("./inc/Template.php");
$TPL = new Template;

include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");

#<input type="checkbox" value="1" name="p_value" onclick="javascript:p_set('국가유공자')">국가유공자
#우대조건

$mod = "4";
//2018-07-27 모바일등록 추가 hun
if( $_COOKIE['happy_mobile'] == 'on' )
{
	$mod = "2";
}

$main_woodae = "<table width=100%><tr>";
$guin_license_co = count($guin_license_arr);

for ( $k=0; $k<$guin_license_co; $k++ ) {
	if($k%$mod==0 && $k!=0 ) { $main_woodae .= "</tr><tr>"; }
	$main_woodae .= "<td style='line-height:22px; height:22px; padding-bottom:10px' class='h_form'>
	<label for='license_{$k}' class='h-check'><input type=\"checkbox\" value=\"$k\" name=\"p_value\" id=\"license_{$k}\" style=\"width:13px; height:13px; vertical-align:middle; cursor:pointer\"onclick=\"javascript:happy_set('$guin_license_arr[$k]')\"><span class='noto400 font_13' id='license_text_{$k}'>$guin_license_arr[$k]</span></label>
	</td>";
}
$main_woodae .= "</table>";
$자격증옵션 = $main_woodae;

$TPL->define("자격증리스트", "./$skin_folder/guin_license.html");
$TPL->assign("자격증리스트");
echo $TPL->fetch();


exit;





?>