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
$main_woodae = "<table width=100% cellspacing=0><tr>";
$woodae_co = count($woodae_arr);

for ( $k=0; $k<$woodae_co; $k++ ) {
	if($k%$mod==0 && $k!=0 ) { $main_woodae .= "</tr><tr>"; }
	$main_woodae .= "<td style='line-height:22px; height:22px; padding-bottom:10px' class='h_form'>
	<label for='woodae_{$k}' class='h-check'><input type=\"checkbox\" value=\"$k\" name=\"p_value\" onclick=\"javascript:happy_set('$woodae_arr[$k]')\" style=\"height:13px; width:13px; vertical-align:middle; cursor:pointer\" id='woodae_{$k}'><span class='noto400 font_13' id='woodae_text_{$k}'>$woodae_arr[$k]</span></label>
	</td>";
}
$main_woodae .= "</table>";
$우대옵션 = $main_woodae;

//2018-07-27 모바일등록 추가 hun
$template_file			= "guin_woodae.html";
if( $_COOKIE['happy_mobile'] == 'on' )
{
	$template_file			= "guin_woodae_mobile.html";
}

$TPL->define("구인리스트", "./$skin_folder/$template_file");
$TPL->assign("구인리스트");
echo $TPL->fetch();

exit;





?>