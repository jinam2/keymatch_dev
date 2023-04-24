<?php
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/Template.php");
	$TPL = new Template();
	include ("../inc/lib.php");
	include ("../inc/happy_initialization.php");

	if ( !admin_secure("슈퍼관리자전용") )
	{
		error("접속권한이 없습니다.");
		exit;
	}


	include ("tpl_inc/top_new.php");

	//$skin_folder				= $skin_folder_org;


	function init_del_false_log($init_type,$init_del_false_value='')
	{
		clearstatcache();
		if ($init_type == "write")
		{
			if (sizeof($init_del_false_value) > 0)
			{
				$init_date = happy_mktime();
				for ($ii=0;$ii<sizeof($init_del_false_value);$ii++)
				{
					$file = "./log/init/init_del_false_$init_date.txt";
					$fp = fopen($file, "a+");
					fwrite($fp, $init_del_false_value[$ii]."\n");
					fclose($fp);
				}
			}
		}
		else if ($init_type == "view")
		{
			$file_info = "
							&lt;안내사항&gt;
							<br>
							파일명을 확인하여 직접 FTP로 접근하여 삭제를 하셔야 합니다<br>
							파일미삭제에 기록된 파일명은 DB ROWS와 매치되지 않는 파일이거나 삭제권한이 없는 파일입니다<br><br>
			";
			$view_count = 0;
			foreach(glob("./log/init/*.txt") AS $filename)
			{
				$filename_explode		= explode("/",$filename);
				$filename_explode_date	= explode("_",$filename_explode[3]);
				$filename_explode_date2	= explode(".",$filename_explode_date[3]);
				$filename_date_result	= date("Y년 m월 d일 H시 i분 s초",$filename_explode_date2[0]);
				$filename_size			= number_format(filesize("./log/init/".$filename_explode[3]));
				$file_info .= "
								<span id='file_name_layer_$view_count'><a href='./data_initialization_del_false.php?filename=$filename_explode[3]' rel='lyteframe' rev='width:840;height:600;scrolling:no;'><font color='red'>".$filename_date_result." (".$filename_size." bytes)"."</font></a></span> <span id='file_del_button_$view_count'><a href=\"javascript:init_file_del('$view_count','$filename_explode[3]')\"><img src='img/file_del_btn.gif'  border='0' align='absmiddle' title='파일삭제' alt='파일삭제'></a></span> <br>
				";
				$view_count++;
			}

			if ($view_count == 0)
			{
				$file_info = "파일미삭제 기록이 없습니다";
			}
			return $file_info;
		}
	}


	if ( $_REQUEST['mode'] == "" )
	{



		$TPL->define("인증", "$skin_folder/data_initialization.html");
		$TPL->assign("인증");
		$TPL->fetch("인증");
		$TPL->tprint("인증");
	}
	else if ($_REQUEST['mode'] == "conf")
	{
		$자료초기화폼	= data_initialization();
		$파일미삭제폼	= init_del_false_log("view");
		$TPL->define("설정", "$skin_folder/data_initialization_conf.html");
		$TPL->assign("설정");
		$TPL->fetch("설정");
		$TPL->tprint("설정");
	}
	else if ($_REQUEST['mode'] == "conf_reg") //초기화진행
	{
		if ($demo_lock == 1)
		{
			error("데모버전에서는 이용하실 수 없습니다^^");
			exit;
		}

		unset($_POST['mode']);



		function exists_value($var)
		{
			return($var != 'n');
		}
		$_POST = array_filter($_POST,"exists_value");
//print_r2($_POST);

		$init_now_path		= "../";
		$POST_ARRAY			= Array();
		$POST_ARRAY			= array_keys($_POST);

		$INIT_ARRAY			= Array();
		$INIT_ARRAY			= array_keys($HAPPY_INITIALIZATION_ARRAY);

		$DEL_FALSE_ARRAY	= Array();

		for ($pp=0;$pp<sizeof($POST_ARRAY);$pp++)
		{
			clearstatcache();
			//echo "$pp 번째 시작<br>"; //디버깅 시작주석
			if (in_array($POST_ARRAY[$pp],$INIT_ARRAY))
			{
				$main_name = $POST_ARRAY[$pp];
				//HAPPY_INITIALIZATION_ARRAY DELETE 접근
				if ($_POST[$POST_ARRAY[$pp]] == "y") //삭제요청시
				{
					foreach($HAPPY_INITIALIZATION_ARRAY[$main_name]['delete'] AS $INIT_DEL => $INIT_DEL_VAL) //if 2 depth exist
					{
						//print_r2($INIT_DEL_VAL);

						//truncate,unlink excute
						if ($INIT_DEL_VAL['field'] != "")
						{
							$field_implode = implode(",", (array) $INIT_DEL_VAL['field']);


							/*
							#DB필드값이 FULL URL이 들어가지 않아 URL붙여줌(url_add_attach)
							#DB필드값의 썸네일이 다른폴더에 있는경우(url_add_attach_thumb)
							$url_add_attach				= "";
							$url_add_attach_thumb		= "";
							if ($INIT_DEL_VAL['table'] == "auction_product")
							{
								$url_add_attach			= "wys2/file_attach/";
								$url_add_attach_thumb	= "wys2/file_attach_thumb/";
							}
							#DB필드값이 FULL URL이 들어가지 않아 URL붙여줌 END(url_add_attach)
							#DB필드값의 썸네일이 다른폴더에 있는경우 END(url_add_attach_thumb)
							*/


							$Sql_field_init	= "SELECT $field_implode FROM $INIT_DEL_VAL[table] ";
							$Rec_field_init	= query($Sql_field_init);
							while($DATA_FIELD	= happy_mysql_fetch_assoc($Rec_field_init))
							{
								$DATA_FIELD	= array_filter($DATA_FIELD);
								//print_r2($DATA_FIELD); //첨부파일 필드명을 보여준다

								foreach($DATA_FIELD AS $INIT_FIELD => $INIT_FIELD_VAL)
								{
									//job_per_file DB의 필드(fileName) 의 값은 replace 해줘야함
									if (preg_match("/((thumb_name))/",$INIT_FIELD_VAL))
									{
										$INIT_FIELD_VAL = str_replace("((thumb_name))","",$INIT_FIELD_VAL);
									}

									//원본파일삭제
									if (file_exists($init_now_path.$url_add_attach.$INIT_FIELD_VAL))
									{
										//echo "$INIT_DEL_VAL[table] 원본파일 : ".$init_now_path.$url_add_attach.$INIT_FIELD_VAL."<br>";
										$unlink_excute = unlink($init_now_path.$url_add_attach.$INIT_FIELD_VAL);
										if ($unlink_excute != 1)
										{
											$DEL_FALSE_ARRAY[] = $INIT_FIELD_VAL;
										}
										unset($unlink_excute);
									}
									//원본파일삭제 END


									/*
									//썸네일 파일이 다른폴더에 있는경우
									if ($url_add_attach_thumb != "")
									{
										if(is_file($init_now_path.$url_add_attach_thumb.$INIT_FIELD_VAL))
										{
											$thumb_explode	= explode(".",$INIT_FIELD_VAL);

											if ($thumb_explode[0] != "")
											{
												foreach (glob($init_now_path.$url_add_attach_thumb.$thumb_explode[0]."*") AS $filename_thumb)
												{
													if (file_exists($filename_thumb))
													{
														echo "$INIT_DEL_VAL[table] 다른폴더 썸네일파일존재 : ".$filename_thumb."<br>";
														//$unlink_excute = unlink($filename_thumb);
														if ($unlink_excute != 1)
														{
															$filename_thumb_replace	= str_replace("../","",$filename_thumb);
															$DEL_FALSE_ARRAY[] = $filename_thumb_replace;
														}
														unset($unlink_excute);
													}
												}
												unset($filename_thumb);
											}
										}
									}
									//썸네일 파일이 다른폴더에 있는경우 END
									*/


									//썸네일삭제
									if ($INIT_DEL_VAL['thumb'] != "")
									{
										$field_explode = explode(".",$INIT_FIELD_VAL);
										foreach($INIT_DEL_VAL['thumb'] AS $INIT_THUMB)
										{
											if (file_exists($init_now_path.$field_explode[0].$INIT_THUMB.".".$field_explode[1]))
											{
												//echo "$INIT_DEL_VAL[table] 썸네일파일 : ".$init_now_path.$field_explode[0].$INIT_THUMB.".".$field_explode[1]."<br>";
												$unlink_excute = unlink($init_now_path.$field_explode[0].$INIT_THUMB.".".$field_explode[1]);
												if ($unlink_excute != 1)
												{
													$DEL_FALSE_ARRAY[] = $field_explode[0].$INIT_THUMB.".".$field_explode[1];
												}
												unset($unlink_excute);
											}
										}
										unset($INIT_THUMB);
									}
									//썸네일삭제 END


									//happy_image 생성이미지 삭제
									$thumb_explode			= explode(".",$INIT_FIELD_VAL);

									if ($thumb_explode[0] != "")
									{
										if(is_file($init_now_path.$INIT_FIELD_VAL))
										{
											foreach (glob($init_now_path.$thumb_explode[0]."*") AS $filename_thumb)
											{
												if (file_exists($filename_thumb))
												{
													//echo "$INIT_DEL_VAL[table] 모든썸네일파일 : ".$filename_thumb."<br>";
													$unlink_excute = unlink($filename_thumb);
													if ($unlink_excute != 1)
													{
														$filename_thumb_replace	= str_replace("../","",$filename_thumb);
														$DEL_FALSE_ARRAY[] = $filename_thumb_replace;
													}
													unset($unlink_excute);
												}
											}
											unset($thumb_explode,$filename_thumb);
										}
									}
									//happy_image 생성이미지 삭제 END

								}
								unset($INIT_FIELD,$INIT_FIELD_VAL);
							}
						}


						#내용첨부파일 삭제
						if ($INIT_DEL_VAL['contents'] != "")
						{
							$contents_implode		= implode(",", (array) $INIT_DEL_VAL['contents']);

							$Sql_content			= "SELECT $contents_implode FROM $INIT_DEL_VAL[table]";
							$Rec_content			= query($Sql_content);
							while($DATA_CONTENTS	= happy_mysql_fetch_assoc($Rec_content))
							{
								$DATA_CONTENTS		= array_filter($DATA_CONTENTS);
								//print_r2($DATA_CONTENTS); //첨부파일 필드명을 보여준다

								foreach($DATA_CONTENTS AS $INIT_CONTENTS => $INIT_CONTENTS_VAL)
								{
									//echo $INIT_CONTENTS_VAL."<br>";
									preg_match_all("/<img[^>]*src=[\"\"]?([^>\"\"]+)[\"\"]?[^>]*>/i",$INIT_CONTENTS_VAL,$IMG_RESULT);
									$img_path_result = array_pop($IMG_RESULT);

									if ($img_path_result != "")
									{
										foreach($img_path_result AS $img_path_index => $img_path_one_row)
										{
											//원본파일삭제
											if (file_exists($init_now_path.$img_path_one_row))
											{
												//echo "$INIT_DEL_VAL[table] 내용필드 원본파일 : ".$init_now_path.$img_path_one_row."<br>";
												$unlink_excute = unlink($init_now_path.$img_path_one_row);
												if ($unlink_excute != 1)
												{
													$init_now_replace	= str_replace("../","",$init_now_path);
													$DEL_FALSE_ARRAY[] = $init_now_replace.$img_path_one_row;
												}
												unset($unlink_excute);
											}
											//원본파일삭제 END


											//썸네일파일삭제
											$img_path_one_row_thumb = str_replace("file_attach","file_attach_thumb",$img_path_one_row);
											$thumb_explode			= explode(".",$img_path_one_row_thumb);

											if(is_file($init_now_path.$img_path_one_row_thumb))
											{
												if ($thumb_explode[0] != "")
												{
													foreach (glob($init_now_path.$thumb_explode[0]."*") AS $filename_thumb)
													{
														if (file_exists($filename_thumb))
														{
															//echo "$INIT_DEL_VAL[table] 내용필드 썸네일파일 : ".$filename_thumb."<br>";
															$unlink_excute = unlink($filename_thumb);
															if ($unlink_excute != 1)
															{
																$filename_thumb_replace	= str_replace("../","",$filename_thumb);
																$DEL_FALSE_ARRAY[] = $filename_thumb_replace;
															}
															unset($unlink_excute);
														}
													}
													unset($filename_thumb);
												}
												//썸네일파일삭제 END
											}
										}
										unset($img_path_index,$img_path_one_row);
									}
								}
								unset($INIT_CONTENTS,$INIT_CONTENTS_VAL);
							}


						}
						#내용첨부파일 삭제 END


						#테이블 비우기
						$Sql_table_del = "TRUNCATE $INIT_DEL_VAL[table] ";
						query($Sql_table_del);
						//truncate,unlink excute END
						//echo "<br>".$Sql_table_del."<br>";
						#테이블 비우기 END
					}
					unset($INIT_DEL,$INIT_DEL_VAL);
				}
			}
			else #게시판#
			{
				//게시판일 경우 게시판 테이블명을 넘겨준다
				//echo $POST_ARRAY[$pp]."/<br>";
				//echo $_POST[$POST_ARRAY[$pp]]."/<br>";

				$init_now_path_board = "../data/".$POST_ARRAY[$pp]."/";
				//HAPPY_INITIALIZATION_ARRAY DELETE 접근
				if ($_POST[$POST_ARRAY[$pp]] == "y") //삭제요청시
				{
					foreach($HAPPY_INITIALIZATION_ARRAY['게시글']['delete'] AS $INIT_DEL => $INIT_DEL_VAL) //if 2 depth exist
					{
						//print_r2($INIT_DEL_VAL);

						//print_r2($INIT_DEL_VAL['table'][0])."<br>";
						//truncate,unlink excute
						//게시판 DB 뽑기
						if ($INIT_DEL_VAL['field'] != "")
						{
							$field_implode	= implode(",", (array) $INIT_DEL_VAL['field']);

							$Sql_field_init	= "SELECT $field_implode FROM $POST_ARRAY[$pp] ";
							$Rec_field_init	= query($Sql_field_init);
							while($DATA_FIELD	= happy_mysql_fetch_assoc($Rec_field_init))
							{
								$DATA_FIELD	= array_filter($DATA_FIELD);
								//print_r2($DATA_FIELD); //첨부파일 필드명을 보여준다

								foreach($DATA_FIELD AS $INIT_FIELD => $INIT_FIELD_VAL)
								{
									//원본파일삭제
									if (file_exists($init_now_path_board.$INIT_FIELD_VAL))
									{
										//echo "$POST_ARRAY[$pp] 게시글 원본파일 : ".$init_now_path_board.$INIT_FIELD_VAL."<br>";
										$unlink_excute = unlink($init_now_path_board.$INIT_FIELD_VAL);
										if ($unlink_excute != 1)
										{
											$init_now_replace	= str_replace("../","",$init_now_path_board);
											$DEL_FALSE_ARRAY[] = $init_now_replace.$INIT_FIELD_VAL;
										}
										unset($unlink_excute);
									}
									//원본파일삭제 END


									//썸네일삭제
									if ($INIT_DEL_VAL['thumb'] != "")
									{
										$field_explode = explode(".",$DATA_FIELD[$INIT_FIELD]);
										foreach($INIT_DEL_VAL['thumb'] AS $INIT_THUMB)
										{
											if (file_exists($init_now_path_board.$field_explode[0].$INIT_THUMB.".".$field_explode[1]))
											{
												//echo "$POST_ARRAY[$pp] 게시글 썸네일파일".$init_now_path_board.$field_explode[0].$INIT_THUMB.".".$field_explode[1]."<br>";
												$unlink_excute = unlink($init_now_path_board.$field_explode[0].$INIT_THUMB.".".$field_explode[1]);
												if ($unlink_excute != 1)
												{
													$init_now_replace	= str_replace("../","",$init_now_path_board);
													$DEL_FALSE_ARRAY[]	= $init_now_replace.$field_explode[0].$INIT_THUMB.".".$field_explode[1];
												}
												unset($unlink_excute);
											}
										}
										unset($INIT_THUMB);
									}
									//썸네일삭제 END


									//happy_image 생성이미지 삭제
									$thumb_explode			= explode(".",$INIT_FIELD_VAL);

									if(is_file($init_now_path_board.$INIT_FIELD_VAL))
									{
										if ($thumb_explode[0] != "")
										{
											foreach (glob($init_now_path_board.$thumb_explode[0]."*") AS $filename_thumb)
											{
												if (file_exists($filename_thumb))
												{
													//echo "$POST_ARRAY[$pp] 게시글 모든썸네일파일 : ".$filename_thumb."<br>";
													$unlink_excute = unlink($filename_thumb);
													if ($unlink_excute != 1)
													{
														$filename_thumb_replace	= str_replace("../","",$filename_thumb);
														$DEL_FALSE_ARRAY[] = $filename_thumb_replace;
													}
													unset($unlink_excute);
												}
											}
											unset($thumb_explode,$filename_thumb);
										}
										//happy_image 생성이미지 삭제 END
									}


								}
								unset($INIT_FIELD,$INIT_FIELD_VAL);
							}
						}


						#내용첨부파일 삭제
						if ($INIT_DEL_VAL['contents'] != "")
						{
							$contents_implode		= implode(",", (array) $INIT_DEL_VAL['contents']);

							$Sql_content			= "SELECT $contents_implode FROM $POST_ARRAY[$pp]";
							$Rec_content			= query($Sql_content);
							while($DATA_CONTENTS	= happy_mysql_fetch_assoc($Rec_content))
							{
								$DATA_CONTENTS		= array_filter($DATA_CONTENTS);
								//print_r2($DATA_CONTENTS); //첨부파일 필드명을 보여준다

								foreach($DATA_CONTENTS AS $INIT_CONTENTS => $INIT_CONTENTS_VAL)
								{
									//echo $INIT_CONTENTS_VAL."<br>";
									preg_match_all("/<img[^>]*src=[\"\"]?([^>\"\"]+)[\"\"]?[^>]*>/i",$INIT_CONTENTS_VAL,$IMG_RESULT);
									$img_path_result = array_pop($IMG_RESULT);

									if ($img_path_result != "")
									{
										foreach($img_path_result AS $img_path_index => $img_path_one_row)
										{
											//원본파일삭제
											if (file_exists($init_now_path.$img_path_one_row))
											{
												//echo "$POST_ARRAY[$pp] 내용필드 원본파일 : ".$init_now_path.$img_path_one_row."<br>";
												$unlink_excute = unlink($init_now_path.$img_path_one_row);
												if ($unlink_excute != 1)
												{
													$init_now_replace	= str_replace("../","",$init_now_path);
													$DEL_FALSE_ARRAY[] = $init_now_replace.$img_path_one_row;
												}
												unset($unlink_excute);
											}
											//원본파일삭제 END

											//썸네일파일삭제
											$img_path_one_row_thumb = str_replace("file_attach","file_attach_thumb",$img_path_one_row);
											$thumb_explode			= explode(".",$img_path_one_row_thumb);

											if(is_file($init_now_path.$img_path_one_row_thumb))
											{
												if ($thumb_explode[0] != "")
												{
													foreach (glob($init_now_path.$thumb_explode[0]."*") AS $filename_thumb)
													{
														if (file_exists($filename_thumb))
														{
															//echo "$POST_ARRAY[$pp] 내용필드 썸네일파일 : ".$filename_thumb."<br>";
															$unlink_excute = unlink($filename_thumb);
															if ($unlink_excute != 1)
															{
																$filename_thumb_replace	= str_replace("../","",$filename_thumb);
																$DEL_FALSE_ARRAY[] = $filename_thumb_replace;
															}
															unset($unlink_excute);
														}
													}
													unset($filename_thumb);
												}
												//썸네일파일삭제 END
											}
										}
										unset($img_path_index,$img_path_one_row);
									}
									unset($img_path_index,$filename_thumb);
								}
								unset($INIT_CONTENTS,$INIT_CONTENTS_VAL);
							}


						}
						#내용첨부파일 삭제 END


						#DB 테이블비우기
						if ($INIT_DEL_VAL['table'] != "") //게시판의 경우 table 값은 Array 이다
						{
							if ($INIT_DEL_VAL['table'] == "board_short_comment")
							{
								$Sql_table_del = "DELETE FROM $INIT_DEL_VAL[table] WHERE tbname='$POST_ARRAY[$pp]' ";
							}
							else
							{
								$Sql_table_del = "TRUNCATE $POST_ARRAY[$pp] ";
							}
							//echo "<hr>".$Sql_table_del."<br>";
						}
						query($Sql_table_del);
						#DB 테이블비우기 END
						//truncate,unlink excute END


					}
					unset($INIT_DEL,$INIT_DEL_VAL);



					#wys2/file_attach_thumb/board_thumb/게시판폴더 파일삭제
					//echo "<hr>";
					if (is_dir($init_now_path."wys2/file_attach_thumb/board_thumb/".$POST_ARRAY[$pp]))
					{
						$board_thumb_dir = opendir($init_now_path."wys2/file_attach_thumb/board_thumb/".$POST_ARRAY[$pp]);
						while($board_thumb_file = readdir($board_thumb_dir))
						{
							if ($board_thumb_file == '.' || $board_thumb_file == '..')
							{
								continue;
							}
							else
							{
								$unlink_url = $init_now_path."wys2/file_attach_thumb/board_thumb/".$POST_ARRAY[$pp]."/".$board_thumb_file;
								//echo "wys2/file_attach_thumb/board_thumb/ 파일 : ".$unlink_url."<br>";
								$unlink_excute = unlink($unlink_url);
								if ($unlink_excute != 1)
								{
									$init_now_replace	= str_replace("../","",$unlink_url);
									$DEL_FALSE_ARRAY[] = $init_now_replace;
								}
								unset($unlink_url,$unlink_excute,$init_now_replace);
							}
						}
						closedir($board_thumb_dir);
					}
					#wys2/file_attach_thumb/board_thumb/게시판폴더 파일삭제END



				}
			}
			//echo "<br><br>";
			//echo "$pp 번째 끝<br><hr>"; //디버깅 끝주석
		}
		//print_r2($_POST);exit;


		//미삭제파일 뽑기
		init_del_false_log('write',$DEL_FALSE_ARRAY);
exit;
		gomsg("삭제가 완료되었습니다","data_initialization.php?mode=conf");
	}

	include ("tpl_inc/bottom.php");



?>
