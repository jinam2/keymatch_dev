<?php
	include ("./inc/Template.php");
	$TPL = new Template;

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	if ( !admin_secure("슈퍼관리자전용") ) {
	 error("접속권한이 없습니다.");
	 exit;
	}

	if ( $_POST["mainViewTag"] != "" )
	{
		### 추출태그내 사용 불가능 태그들 처리 보안패치 #2023-01-02 ###
			$_POST["mainViewTag"]	= str_replace("<?","&lt;?",$_POST["mainViewTag"]);

			#치환해야 될 단어 (추출태그내)
			$Strings				= Array(
												'$',
												'PHPCODE',
												'PHP',
												'=',
												'EXPRESSION',
												'EXP',
			);
			preg_match_all("/{{(.*?)}}/",$_POST["mainViewTag"],$matches);
			//print_r($matches[0]);

			if ( is_array($matches[0]) && count($matches[0]) >= 1 )
			{
				foreach( $matches[0] as $tag )
				{
					$change_tag				= $tag;
					foreach ( $Strings AS $Str )
					{
						$change_tag				= str_replace($Str, '', $change_tag);
					}

					$_POST["mainViewTag"]	= str_replace($tag, $change_tag, $_POST["mainViewTag"]);
				}
			}
		### 추출태그내 사용 불가능 태그들 처리 보안패치 #2023-01-02 ###

		$file=@fopen("$skin_folder/tagview.html","w") or Error("$skin_folder/tagview.html 파일을 열 수 없습니다..\\n \\n디렉토리의 퍼미션을 707로 주십시오");
		@fwrite($file,"$_POST[mainViewTag]\n") or Error("$skin_folder/tagview.html 수정 실패 \\n \\n파일의 퍼미션을 707로 주십시오");
		@fclose($file);

		$all_keyword	= " ";
		$_GET["all_keyword"]	= " ";
	}

	$TPL->define("상세", "$skin_folder/tagview.html");
	$TPL->assign("상세");
	$내용 = $TPL->fetch();

	$TPL->define("껍데기", "$skin_folder/default.html");
	$TPL->assign("껍데기");
	echo $TPL->fetch();

	exit;

?>