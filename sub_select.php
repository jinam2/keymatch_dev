<?php

$t_start = array_sum(explode(' ', microtime()));
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");


$trigger = $_GET['trigger'];
$target = $_GET['target'];
$form = $_GET['form'];
$size = $_GET['size'];

// 이쯤에서 db 처리해주고....
	$sql = "select * from $gu_tb where si = '$trigger' order by gu asc ";
	$result = query($sql);
	$numb = mysql_num_rows($result);
	if (!$numb){
		$numb = '1';
		//$etc_java = "document.forms['$form'].elements['$target'].options[0].text = '-세부지역선택-'; \n";
		//$etc_java .= "document.forms['$form'].elements['$target'].options[0].value = ''; \n";
		$etc_java .= "<option value=''>".$HAPPY_CONFIG['SelectAreaGuTitle1']."</option>\n";
	}
	else {
		$i = "1";
		//$etc_java = "document.forms['$form'].elements['$target'].options[0].text = '-세부지역선택-'; \n";
		//$etc_java .= "document.forms['$form'].elements['$target'].options[0].selected = true; \n";
		$etc_java .= "<option value=''>".$HAPPY_CONFIG['SelectAreaGuTitle1']."</option>\n";


		while ($SI = happy_mysql_fetch_array($result)){
			//$etc_java .= "document.forms['$form'].elements['$target'].options[$i].text = '$SI[gu] '; \n";
			//$etc_java .= "document.forms['$form'].elements['$target'].options[$i].value = '$SI[number]'; \n";
			$etc_java .= "<option value='$SI[number]'>$SI[gu]</option>\n";

			$i ++;
		}
		$numb = $numb + 1;
	}

if ($size){
$size = "width:".$size."px;";
}

if ( $_COOKIE['happy_mobile'] == "on" )
{
	//$size = str_replace("px","",$size);
}

header("Content-Type: text/html; charset=utf-8");
//echo "document.forms['$form'].elements['$target'].length = $numb; \n $etc_java";
print <<<END
$target$form---cut---<select name='$target' style="$size">
$etc_java
</select>
END;
?>