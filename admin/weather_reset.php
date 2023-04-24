<?

include ("../inc/config.php");
include ("../inc/function.php");
include ("../inc/lib.php");

//$sql_list = "title ,sorting_number ,display ,product_count ,display_number ,display_width ,template ,pick_width ,pick_display_number ,pick_template ,speed_width ,speed_display_number ,speed_template ,pop_width ,pop_display_number ,pop_template";
//$sql_values = "$title ,$sorting_number ,$display ,$product_count ,$display_number ,$display_width ,$template ,$pick_width ,$pick_display_number ,$pick_template ,$speed_width ,$speed_display_number ,$speed_template ,$pop_width ,$pop_display_number ,$pop_template";

if ( !admin_secure("투표관리") ) {
		error("접속권한이 없습니다.");
		exit;
}


if ($action == "") {
	reset_weather();
}
else {
	print "<center><br><br>허용되지 않은 액션입니다.";
	exit;
}
################################################################

function reset_weather() {
	global $auction_weather_info ,$cookie_url;
	
	setcookie("g_city","",happy_mktime() - 3600,"/","$cookie_url");
	$sql4 = "delete from $auction_weather_info";
	$result4 = query($sql4);
	error("날씨정보가 초기화 되었습니다.");
	exit;

}


?>