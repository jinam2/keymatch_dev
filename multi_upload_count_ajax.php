<?


	include "./inc/config.php";
	include "./inc/function.php";
	include "./inc/Template.php";
	$TPL	= new Template;
	include "./inc/lib.php";

	if(!session_id()) session_start();
	$folder_name = "upload/tmp/".session_id();

	$count			= preg_replace('/\D/', '', $_GET['count']);
	$realCount		= 0;

	if(is_dir($folder_name)) {
		$dir_obj=opendir($folder_name);
		while(($file_str = readdir($dir_obj))!==false){
			if($file_str!="." && $file_str!=".." && !(preg_match("/_thumb/i",$file_str)) )
			{
				$realCount++;
			}
		}
		closedir($dir_obj);
	}


	$count			= $count - $realCount;

	echo $count;

?>