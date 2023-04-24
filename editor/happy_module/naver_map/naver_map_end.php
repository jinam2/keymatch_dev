<?PHP
require_once('../secure_config.php') ;												//보안설정
require_once('../config.php') ;																	//에디터 모듈 통합설정

//<div style="background:url(http://companya.cgimall.co.kr/upload/happy_config/info_logo.png) no-repeat;width:300px;height:200px"><div style="display:none">{naver_map_value}</div></div>		이런형식으로 넣어서 사용하면 ... 에디터에서 지도 지운다고 하여 문제되지 않는다. 스크립트를 바로 넣는 방식은 되도록이면 사용하지 말자!!
$map_content		= "<div style='background:url(".$relative_path."images/naver_map_intro.jpg) no-repeat;width:800px;height:600px'><div id='naver_map_contents'>";
foreach( $_POST as $key => $value )
{

}
?>