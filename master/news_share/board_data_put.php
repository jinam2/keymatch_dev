<?php
	//게시글 데이터 저장
	include ("../../inc/config.php");
	include("inc/function.php");
	include("../../inc/ns_lib_encode.php");
	include("inc/lib.php");
	include("../../inc/ns_Template.php");
	$TPL = new Template;
	include("../../inc/ns_Template_make.php");
	Header("Content-type: text/html; charset=utf-8");

	//print_r($_POST);
	$news_site = get_news_store_info();

	//일단 클라이이언트 로그인설정 체크
	if ( news_store_login_check() != true )
	{
		$rows_str = '<?xml version="1.0" encoding="UTF-8"?>';
		$rows_str.= '<news_list>';
		$rows_str.= '<status>error01</status>';
		$rows_str.= '</news_list>';
		//exit;
	}
	//뉴스상점에서 받은 값이 제대로 된건지 체크
	else if ( $_POST['store_id'] != $news_site['id'] || $_POST['store_pass'] != $news_site['pass'] )
	{
		$rows_str = '<?xml version="1.0" encoding="UTF-8"?>';
		$rows_str.= '<news_list>';
		$rows_str.= '<status>error02</status>';
		$rows_str.= '</news_list>';
		//exit;
	}
	else
	{
		foreach($_POST as $k => $v)
		{
			$_POST[$k] = urldecode($v);
		}

		if ( $magic_quotes_gpc == "off" )
		{
			foreach($_POST as $k => $v)
			{
				$_POST[$k] = addslashes($v);
			}
		}

		//뉴스데이터는 항상 ut-f8 로 전송되어 온다
		//뉴스사이트가 eu-ckr 이면 변환해서 DB에 넣자
		if ( $news_encoding == "e" )
		{
			foreach($_POST as $k => $v)
			{
				$_POST[$k] = iconv("utf-8","euc-kr",$v);
			}
		}
		//echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaa";
		
		//게시판 테이블명
		$board_tb = $_POST['category'];

		//게시판DB 필드 체크
		board_db_setting($board_tb);



		//뉴스 위지윅내 첨부이미지 뉴스솔루션에 저장
		$imgs = upload_file_search(stripslashes($_POST['comment']));
		$happy_member_login_id = $_POST['store_id'];
		if ( count($imgs) > 0 )
		{
			foreach($imgs as $k => $v)
			{
				$org_file = $v;
				$org_url = $news_store_url.$v;

				$file_paths = explode("/",$org_file);
				$file_name = $file_paths[count($file_paths)-1];
				$file_arr = explode(".",$file_name);
				$file_ext = strtolower($file_arr[count($file_arr)-1]);
				array_pop($file_paths);


				if ( $file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "gif" || $file_ext == "png" || $file_ext == "bmp" )
				{
					$dir = "../..";
					$dir2 = "../..";
					for($ii=0; $ii<count($file_paths);$ii++)
					{
						$dir.= $file_paths[$ii].'/';
						if ( !is_dir($dir) )
						{
							//echo $dir."만들자<br>";
							@mkdir($dir,0777);
							@chmod($dir,0777);
						}
						
						//본문내 이미지라서 file_attach_thumb 를 만들어주고,
						//file_attach_thumb
						$dir2.= str_replace("file_attach","file_attach_thumb",$file_paths[$ii]).'/';
						if ( !is_dir($dir2) )
						{
							//echo $dir."만들자<br>";
							@mkdir($dir2,0777);
							@chmod($dir2,0777);
						}
					}

					//뉴스솔루션에 저장될 파일경로
					$save_name = "../..".implode("/", (array) $file_paths).'/'.$file_name;
					//위지윅은 절대경로로 저장된다
					$save_name2 = $news_site_wys_url.implode("/", (array) $file_paths).'/'.$file_name;

					//echo "<font color='red'>".$save_name."</font><br>";

					//이미지파일 저장
					socket_img_get($org_url,$save_name);

					//위지윅으로 업로드 된 파일내역에 써주자
					if ( $_POST['mode'] == "update" )
					{
						if ( $happy_upload_files_use == "1" )
						{
							$update_number = intval($_POST['update_number']);
							query("delete from $happy_upload_files where using_key = '$update_number'");
						}
					}
					if ( $happy_upload_files_use == "1" )
					{
						upload_file_insert($save_name2);
					}
					//위지윅으로 업로드 된 파일내역에 써주자

					//썸네일이미지 저장
					$org_url_thumb = str_replace("/file_attach/","/file_attach_thumb/",$org_url);
					$save_name_thumb = str_replace("/file_attach/","/file_attach_thumb/",$save_name);
					socket_img_get($org_url_thumb,$save_name_thumb);
					//썸네일이미지 저장


					$_POST['comment'] = addslashes(str_replace($org_file,$save_name2,stripslashes($_POST['comment'])));
				}
				else
				{
					//echo $file_name." 은 이미지파일이 아닙니다.<br>";
					$_POST['comment'] = addslashes(str_replace($org_file,$org_url,stripslashes($_POST['comment'])));
				}
			}
		}

		//echo $_POST['comment'];exit;
		//뉴스 위지윅내 첨부이미지 뉴스솔루션에 저장




		$detail_url		= "";

		//뉴스 등록
		if ( $_POST['mode'] == "" )
		{
			$sql = "select MAX(groups) AS number from $board_tb";
			$result = query ($sql);
			$row = mysql_fetch_row($result);
			$groups = $row[0];
			if ( $groups == null ) { $groups=0; }
			else { $groups++; }

			$bbs_name = "";
			if ( $_POST['reporter'] != "" )
			{
				$bbs_name = $_POST['reporter'];
			}
			else
			{
				$bbs_name = $bbs_name_default;
			}

			$sql = "INSERT INTO $board_tb SET ";
			$sql.= $BOARD_FIELD['title']." = '".$_POST['title']."',";
			$sql.= $BOARD_FIELD['comment']." = '".$_POST['comment']."',";
			$sql.= $BOARD_FIELD['date']." = now(),";
			$sql.= $BOARD_FIELD['reporter']." = '".$bbs_name."',";
			$sql.= $BOARD_FIELD['reporter_email']." = '".$_POST['reporter_email']."',";
			//$sql.= $BOARD_FIELD['id']." = '".$_POST['id']."',";

			//공유한 사이트(원본사이트도메인)
			$sql.= "sharing_site = '".$_POST['sharing_site']."',";
			//공유받은 사이트(받은사이트도메인)
			$sql.= "shared_site = '".$_POST['shared_site']."',";
			//자동업데이트 여부 필드
			$sql.= "shared_auto_update = '".$_POST['auto_update']."',";
			//정기구독 고유번호 필드
			$sql.= "shared_gudoc = '".$_POST['shared_gudoc']."',";

			//공유받은 뉴스
			$sql.= " news_gongu = '1', ";

			$sql.= "groups = '".$groups."',";
			$sql.= "seq = '1',";
			$sql.= "depth = '0' ";


			//echo $sql;exit;
			query($sql);
			$sql = "SELECT LAST_INSERT_ID();";
			$result = query($sql);
			list($links_number)= mysql_fetch_row($result);

			$status = "ok";

			//위지윅첨부파일관리를 사용하면
			if ( $happy_upload_files_use == "1" )
			{
				$html_code = $_POST['comment'];
				$using_table = $board_tb;
				$using_number = $links_number;
				$file_stats = "insert";

				upload_file_update($html_code,$using_table,$using_number,$file_stats);
			}
			//위지윅첨부파일관리를 사용하면

			//공유받은 뉴스상세 페이지 주소
			$shared_detail_url		= $news_site_bbs_detail_url.'?bbs_num='.$links_number.'&tb='.preg_replace("/^$db_prefix/i","",$_POST['category']);
			//공유받은 뉴스상세 페이지 주소


			//뉴스의 본문은 공유한 내용 그대로 나오도록 본문을 파일로 저장
			$contents_file_path = "/upload/news_data/bbs_contents/".$board_tb."/".$_POST['sharing_site']."_".$_POST['shared_site']."/";
			$contents_file_name = "bbs_".$links_number.".html";

			$file_paths = explode("/",$contents_file_path);
			$dir = "../..";
			for($ii=0; $ii<count($file_paths);$ii++)
			{
				$dir.= $file_paths[$ii].'/';
				if ( !is_dir($dir) )
				{
					//echo $dir."만들자<br>";
					@mkdir($dir,0777);
					@chmod($dir,0777);
				}
			}

			file_put_contents("../..".$contents_file_path.$contents_file_name,stripslashes($_POST['comment']));
			//뉴스의 본문은 공유한 내용 그대로 나오도록 본문을 파일로 저장


			//happy_board_key 를 쓰면 최초 공유받을때 최소 기본정보만 넣도록
			//공유받은 게시글을 변경하거나, 할때는 솔루션의 프로그램에 의해서 조절이 되도록
			if ( $use_happy_board_key == "1" )
			{
				$sql2 = "insert into $happy_board_key set ";
				if ( $prefix_type == "1" )
				{
					$sql2.= "board_tb = '".$board_tb."', ";
				}
				else
				{
					$sql2.= "board_tb = '".preg_replace("/^$db_prefix/i","",$board_tb)."', ";
				}
				$sql2.= "board_number = '".$links_number."',";
				$sql2.= "board_name = '".$bbs_name_default."',";
				$sql2.= "board_title = '".$_POST['title']."' ";
				query($sql2);
			}

			//exit;

		}
		//뉴스 수정
		else if ( $_POST['mode'] == "update" )
		{
			$update_number = intval($_POST['update_number']);

			$sql = "select * from $board_tb where number = '".$update_number."'";
			$result = query($sql);
			$Data = happy_mysql_fetch_assoc($result);
			
			if ( $Data['number'] == $update_number )
			{
				$sql = "UPDATE $board_tb SET ";
				$sql.= $BOARD_FIELD['title']." = '".$_POST['title']."',";
				$sql.= $BOARD_FIELD['comment']." = '".$_POST['comment']."',";
				$sql.= $BOARD_FIELD['date']." = now(),";
				$sql.= $BOARD_FIELD['reporter']." = '".$bbs_name."',";
				$sql.= $BOARD_FIELD['reporter_email']." = '".$_POST['reporter_email']."',";

				//공유한 사이트(원본사이트도메인)
				$sql.= "sharing_site = '".$_POST['sharing_site']."',";
				//공유받은 사이트(받은사이트도메인)
				$sql.= "shared_site = '".$_POST['shared_site']."',";
				//자동업데이트 여부 필드
				$sql.= "shared_auto_update = '".$_POST['auto_update']."',";
				//정기구독 고유번호 필드
				$sql.= "shared_gudoc = '".$_POST['shared_gudoc']."', ";

				//공유받은 뉴스
				$sql.= " news_gongu = '1' ";

				$sql.= " WHERE number = '".$update_number."' ";
				//echo $sql;
				query($sql);
				$links_number = $update_number;

				$status = "ok";

				//위지윅첨부파일관리를 사용하면
				if ( $happy_upload_files_use == "1" )
				{
					$html_code = $_POST['comment'];
					$using_table = $board_tb;
					$using_number = $links_number;
					$file_stats = "update";

					upload_file_update($html_code,$using_table,$using_number,$file_stats);
				}
				//위지윅첨부파일관리를 사용하면

				//공유받은 뉴스상세 페이지 주소
				$shared_detail_url		= $news_site_detail_url.'?number='.$links_number.'&thread='.$_POST['category'];
				//공유받은 뉴스상세 페이지 주소



				//뉴스의 본문은 공유한 내용 그대로 나오도록 본문을 파일로 저장
				$contents_file_path = "/upload/news_data/bbs_contents/".$board_tb."/".$_POST['sharing_site']."_".$_POST['shared_site']."/";
				$contents_file_name = "bbs_".$links_number.".html";

				$file_paths = explode("/",$contents_file_path);
				$dir = "../..";
				for($ii=0; $ii<count($file_paths);$ii++)
				{
					$dir.= $file_paths[$ii].'/';
					if ( !is_dir($dir) )
					{
						//echo $dir."만들자<br>";
						@mkdir($dir,0777);
						@chmod($dir,0777);
					}
				}

				file_put_contents("../..".$contents_file_path.$contents_file_name,stripslashes($_POST['comment']));
				//뉴스의 본문은 공유한 내용 그대로 나오도록 본문을 파일로 저장
			}
			else
			{
				$status = "no";
			}

		}
		//뉴스 삭제
		else if ( $_POST['mode'] == "delete" )
		{
			$update_number = intval($_POST['update_number']);

			//print_r($_POST);exit;

			$sql = "select * from $board_tb where number = '".$update_number."'";
			$result = query($sql);
			$Data = happy_mysql_fetch_assoc($result);

			if ( $Data['number'] == $update_number )
			{
				$sql = "delete from $board_tb where number = '".intval($_POST['update_number'])."'";
				//echo $sql;
				query($sql);
				$links_number = intval($_POST['update_number']);

				$status = "ok";


				//위지윅첨부파일관리를 사용하면
				if ( $happy_upload_files_use == "1" )
				{
					$html_code = $_POST['comment'];
					$using_table = $board_tb;
					$using_number = $links_number;
					$file_stats = "delete";

					upload_file_update($html_code,$using_table,$using_number,$file_stats);
				}
				//위지윅첨부파일관리를 사용하면

				//뉴스의 본문은 공유한 내용 그대로 나오도록 본문을 파일로 저장
				$contents_file_path = "/upload/news_data/bbs_contents/".$board_tb."/".$Data['sharing_site']."_".$Data['shared_site']."/";
				$contents_file_name = "bbs_".$links_number.".html";

				@unlink("../..".$contents_file_path.$contents_file_name);
				//뉴스의 본문은 공유한 내용 그대로 나오도록 본문을 파일로 저장

				//happy_board_key 도 같이 제거
				if ( $use_happy_board_key == "1" )
				{
					$sql2 = "delete from $happy_board_key where ";
					if ( $prefix_type == "1" )
					{
						$sql2.= "board_tb = '".$board_tb."' ";
					}
					else
					{
						$sql2.= "board_tb = '".preg_replace("/^$db_prefix/i","",$board_tb)."' ";
					}
					$sql2.= " and board_number = '".intval($_POST['update_number'])."' ";
					query($sql2);
				}

			}
			else
			{
				$status = "no";
			}
		}






		$rows_str = '<?xml version="1.0" encoding="UTF-8"?>';
		$rows_str.= '<news_list>';
		$rows_str.= '<status>'.$status.'</status>';
		//공유받은 고유번호
		//$PUT_XML[0][1][value]
		$rows_str.= '<links_number>'.$links_number.'</links_number>';
		//공유받은 카테고리이름
		//$PUT_XML[0][2][value]
		$rows_str.= '<category_name>'.$category_name.'</category_name>';

		if ( $_POST['debug'] == 1 )
		{
			//$PUT_XML[0][3][value]
			$rows_str.= '<news_sql><![CDATA['.$sql.']]></news_sql>';
			//$rows_str.= '<news_sql>'.$sql.'</news_sql>';
		}
		
		//공유받은 뉴스상세 url
		//$PUT_XML[0][4][value]
		$rows_str.= '<shared_detail_url><![CDATA['.$shared_detail_url.']]></shared_detail_url>';

		$rows_str.= '</news_list>';
	}


	//뉴스상점에 전달하는 데이터는 항상 ut-f8
	if ( $news_encoding == "e" )
	{
		$return_xml2 = iconv("euc-kr","utf-8//IGNORE",$rows_str);
	}
	else
	{
		$return_xml2 = $rows_str;
	}


	echo $return_xml2;

?>