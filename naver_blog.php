<?
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");

	if( !admin_secure("슈퍼관리자전용") )
	{
		echo "관리자만 사용가능합니다.";
		exit;
	}

#############################################################################################################################

	include "./inc/xmlrpc.inc";

	$title			= base64_decode($_POST['title']);
	$description	= base64_decode($_POST['description']);
	$tb				= $_POST['tb'];
	$number			= $_POST['number'];
	$img_re			= $_POST['img_re'];
	$func_i			= $_POST['func_i'];

	if ( $demo_lock != '' )
	{
		msg('네이버 블로그로 성공적으로 전송 하였습니다.\\n(데모에선 실제 전송이 되지 않습니다.)');
	}

	if ( $HAPPY_CONFIG['naver_blog_user_id'] != '' && $HAPPY_CONFIG['naver_blog_blog_id'] != '' && $HAPPY_CONFIG['naver_blog_password'] != '' )
	{
		if ( $title != '' && $description != '' && $tb != '' && $number != '' )
		{
			$상세설명			= str_replace('"'.'/wys2/', '"'.$main_url.'/wys2/', $description);
			$상세설명			= str_replace("'/wys2/", "'".$main_url.'/wys2/', $상세설명);
			$상세설명			= str_replace('"'.$wys_url.'/wys2/', '"'.$main_url.$wys_url.'/wys2/', $상세설명);
			$상세설명			= str_replace("'$wys_url/wys2/", "'".$main_url.$wys_url.'/wys2/', $상세설명); $상세설명 = str_replace('./data/', '/data/', $상세설명); $상세설명 = str_replace('"'.'/data/', '"'.$main_url.'/data/', $상세설명); $상세설명 = str_replace("'/data/", "'".$main_url.'/data/', $상세설명); $상세설명 = str_replace('"'.$wys_url.'/data/', '"'.$main_url.$wys_url.'/data/', $상세설명); $상세설명 = str_replace("'$wys_url/data/", "'".$main_url.$wys_url.'/data/', $상세설명); $pattern = array('/<script[^>]*?>(.*?)<\/script>/is'); $상세설명 = preg_replace($pattern, '', $상세설명);

			$return				= BlogPostWrite($title,$상세설명);

			if ( $return->errno == 0 )
			{
				$sql				= "
										SELECT
												COUNT(*)
										FROM
												$happy_naver_blog_send
										WHERE
												tb				= '$tb'
										AND
												links_number	= '$number'
				";
				$cnt				= mysql_fetch_row(query($sql));

				if( $cnt[0] == 0 )
				{
					$message			= "네이버 블로그로 성공적으로 전송 하였습니다.";
					query("
							INSERT INTO
										$happy_naver_blog_send
							SET
										tb				= '$tb',
										links_number	= '$number'
					");
					echo "
							<script>
								parent.document.getElementById('naver_blog_send_img{$func_i}').src = '$img_re';
							</script>
					";
				}
				else
				{
					$message			= "네이버 블로그로 성공적으로 재전송 하였습니다.";
					echo "
							<script>
								parent.document.getElementById('naver_blog_send_img{$func_i}').src = '$img_re';
							</script>
					";
				}

				msg($message);
			}
			else if ( str_replace(' ','', $return->errstr) != '' )
			{
				if( $server_character == 'utf8' || $server_character == 'utf-8' )
				{
					msg($return->errstr);
				}
				else
				{
					msg(iconv("UTF-8","EUC-KR",$return->errstr));
				}
			}
			else
			{
				msg('알수없는 에러 발생');
			}
		}
		else
		{
			msg('제목과 본문내용이 충분하지 않습니다.');
		}
	}
	else
	{
		msg('관리자모드에서 네이버 블로그 API 정보를 입력 해주세요.');
	}
?>