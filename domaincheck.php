<?

include ("./inc/config.php");
$main_url = $_SERVER["HTTP_HOST"];
$main_url = str_replace("http://","",$main_url);

echo "&vardomain=".$main_url;

?>