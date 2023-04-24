<?php
	include ("../inc/config.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/function.php");
	include ("../inc/lib.php");

	if ( !admin_secure("구직리스트") )
	{
		error("접속권한이 없습니다.   ");
		exit;
	}

	################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################

	//alter table job_com_guin_per add online_stats int(1) not null default '0';


	if ( $_GET['mode'] == "" )
	{
		$ex_limit = 15;

		if ( $_GET['search_word'] != '' )
		{
			$WHERE2 = " AND ";
			$search_type_0 = "";
			$search_type_1 = "";
			$search_type_2 = "";
			$search_type_3 = "";
			$search_type_4 = "";

			$_GET['search_type'] = "guin_id";

			if ( $_GET['search_type'] == "" )
			{
				$WHERE2 .= " ( A.title like '%".$_GET['search_word']."%' OR A.user_id like '%".$_GET['search_word']."%' ) ";
				$search_type_0 = " selected ";
			}
			else if ( $_GET['search_type'] == 'id' )
			{
				$WHERE2 .= " A.user_id like '%".$_GET['search_word']."%' ";
				$search_type_1 = " selected ";
			}
			else if ( $_GET['search_type'] == 'title' )
			{
				$WHERE2 .= " A.title like '%".$_GET['search_word']."%' ";
				$search_type_2 = " selected ";
			}
			else if ( $_GET['search_type'] == 'guin_id' )
			{
				$WHERE2 .= " C.guin_id = '".$_GET['search_word']."' ";
				$search_type_3 = " selected ";
			}
			else if ( $_GET['search_type'] == 'guin_title' )
			{
				$WHERE2 .= " C.guin_title like '%".$_GET['search_word']."%' ";
				$search_type_4 = " selected ";
			}

			$plus .= "&search_type=".urlencode($_GET['search_type']);
			$plus .= "&search_word=".urlencode($_GET['search_word']);
		}


		if ( $_GET['guin_number'] != "" )
		{
			//채용정보에 온라인입사지원한 이력서리스트
			$TemplateFile = "admin_online_doc.html";

			$WHERE2 .= " AND C.number = '".$_GET['guin_number']."' ";
			$plus .= "&guin_number=".urlencode($_GET['guin_number']);
		}
		else if ( $_GET['guzic_number'] != "" )
		{
			//이력서로 온라인입사지원 채용정보리스트
			$TemplateFile = "admin_online_doc_guzic.html";

			$WHERE2 .= " AND A.number = '".$_GET['guzic_number']."' ";
			$plus .= "&guzic_number=".urlencode($_GET['guzic_number']);

			$sql = "select * from $per_document_tb where number = '".$_GET['guzic_number']."'";
			$result = query($sql);
			$Doc = happy_mysql_fetch_assoc($result);



		}


		#A:이력서
		#B:온라인입사지원
		#C:채용정보
		$sql = "select A.*, ";
		$sql.= " B.number as bNumber, ";
		$sql.= " B.pNumber as pNumber, ";
		$sql.= " B.cNumber as cNumber, ";
		$sql.= " B.com_id as c_id, ";
		$sql.= " B.per_id as p_id, ";
		$sql.= " B.com_name as c_name, ";
		$sql.= " B.interview as interview, ";
		$sql.= " B.read_ok as read_ok, ";
		$sql.= " B.doc_ok as doc_ok, ";
		$sql.= " B.regdate as o_regdate, ";
		$sql.= " B.secure as secure, ";
		$sql.= " C.number as guin_number, ";
		$sql.= " C.guin_title as guin_title, ";
		$sql.= " C.guin_id as guin_id, ";
		$sql.= " C.guin_title as guin_title ";

		$sql.= " from ".$per_document_tb." AS A ";
		$sql.= " INNER JOIN ".$com_guin_per_tb." AS B ";
		$sql.= " ON A.number = B.pNumber ";
		$sql.= " INNER JOIN ".$guin_tb." AS C ";
		$sql.= " ON B.cNumber = C.number ";
		$sql.= " WHERE ";
		$sql.= " 1=1 ";
		$sql.= $WHERE2;
		$sql.= " order by o_regdate desc";
		$result = query($sql);
		//echo $sql;

		$numb = mysql_num_rows($result);

		$pg = $_GET[pg];
		if($pg==0 || $pg=="")
		{
			$pg=1;
		}

		//페이지 나누기
		$total_page = ( $numb - 1 ) / $ex_limit+1; //총페이지수
		$total_page = floor($total_page);
		$view_rows = ($pg - 1) * $ex_limit;
		$co  =  $numb  -  $ex_limit  *  ( $pg - 1 );

		$sql = "select A.*, ";
		$sql.= " B.number as bNumber, ";
		$sql.= " B.pNumber as pNumber, ";
		$sql.= " B.cNumber as cNumber, ";
		$sql.= " B.com_id as c_id, ";
		$sql.= " B.per_id as p_id, ";
		$sql.= " B.com_name as c_name, ";
		$sql.= " B.interview as interview, ";
		$sql.= " B.read_ok as read_ok, ";
		$sql.= " B.doc_ok as doc_ok, ";
		$sql.= " B.regdate as o_regdate, ";
		$sql.= " B.secure as secure, ";
		$sql.= " B.online_stats as online_stats, ";
		$sql.= " C.number as guin_number, ";
		$sql.= " C.guin_title as guin_title, ";
		$sql.= " C.guin_id as guin_id, ";
		$sql.= " C.guin_title as guin_title ";

		$sql.= " from ".$per_document_tb." AS A ";
		$sql.= " INNER JOIN ".$com_guin_per_tb." AS B ";
		$sql.= " ON A.number = B.pNumber ";
		$sql.= " INNER JOIN ".$guin_tb." AS C ";
		$sql.= " ON B.cNumber = C.number ";
		$sql.= " WHERE ";
		$sql.= " 1=1 ";
		$sql.= $WHERE2;
		$sql.= " order by o_regdate desc";
		$sql.= " LIMIT ".$view_rows.",".$ex_limit;
		//echo $sql;

		$result = query($sql);

		$Datas = array();
		$auto_number = $co;
		while($Data = happy_mysql_fetch_assoc($result))
		{

			$OutData = output_doc_array($Data);
			$OutData['auto_number'] = $auto_number;

			array_push($Datas,$OutData);
			$auto_number--;
		}
		//print_r2($Datas);
		if ( $numb > 0 )
		include ("./page.php");

		//unset($Datas);

		$select_stats_all = make_selectbox2(array_values($online_stats),array_keys($online_stats),'---선택---',"online_stats_all",$Data['online_stats'],$select_width="150");
		$btn_change_all = '<input type="button" value="변경" onclick="change_stats_all();" class="btn_small_gray" style="height:29px; vertical-align:middle">';

		$TPL->define("결과물", "./$skin_folder/$TemplateFile");
		$TPL->assign("LOOP", $Datas);
		$TPL->assign("결과물");
		$TPL->tprint();

	}
	else if ( $_GET['mode'] == "view" )
	{
		$TemplateFile = "admin_online_detail.html";
	}
	else if ( $_GET['mode'] == "del" )
	{
		//echo "삭제하자";
		$sql = "delete from ".$com_guin_per_tb." where number = '".$_GET['number']."'";
		//echo $sql."<br>";
		query($sql);
		msg("온라인입사지원건이 취소되었습니다.");
		go("admin_online_doc.php?pg=".$_GET['pg']);
		exit;
	}


	include ("tpl_inc/bottom.php");



	function output_doc_array($Data)
	{
		global $TYPE_SUB_NUMBER,$TYPE,$siSelect,$guSelect,$Data_job_where,$HAPPY_CONFIG;
		global $online_stats;

		$Data['doc_title'] = utfstrcut($Data["title"],40,"...");
		$Data['guin_title'] = utfstrcut($Data["guin_title"],40,"...");

		$Data["job_type1_original"]	= $Data["job_type1"];
		$Data["job_type2_original"]	= $Data["job_type2"];
		$Data["job_type3_original"]	= $Data["job_type3"];

		$Data["job_type1_top"]		= $TYPE_SUB_NUMBER[$Data["job_type1"]];
		$Data["job_type2_top"]		= $TYPE_SUB_NUMBER[$Data["job_type2"]];
		$Data["job_type3_top"]		= $TYPE_SUB_NUMBER[$Data["job_type3"]];

		$Data["job_type1"]	= $TYPE[$Data["job_type1"]];
		$Data["job_type2"]	= $TYPE[$Data["job_type2"]];
		$Data["job_type3"]	= $TYPE[$Data["job_type3"]];

		for ( $i=1, $Data["job_type"]="" ; $i<=3 ; $i++ )
		{
			if ( $Data["job_type".$i] != "" )
			{
				$Data["job_type"]	.= ( $Data["job_type"] == "" )?"":", ";
				$Data["job_type"]	.= $Data["job_type".$i];
			}
		}
		$Data["job_type"]	= ( trim($Data["job_type"]) == "" )?"<font style=font-size:11px>".$HAPPY_CONFIG['MsgNoInputType1']."</font>":$Data["job_type"];

		$Data["job_where1"]	= $siSelect[$Data["job_where1_0"]] ." ". $guSelect[$Data["job_where1_1"]];
		$Data["job_where2"]	= $siSelect[$Data["job_where2_0"]] ." ". $guSelect[$Data["job_where2_1"]];
		$Data["job_where3"]	= $siSelect[$Data["job_where3_0"]] ." ". $guSelect[$Data["job_where3_1"]];

		$Data_job_where		= array();
		array_push($Data_job_where, $Data["job_where1"]);
		array_push($Data_job_where, $Data["job_where2"]);
		array_push($Data_job_where, $Data["job_where3"]);

		for ( $i=0, $max=sizeof($Data_job_where), $Data["job_where"]="" ; $i<$max ; $i++ )
		{
			if ( str_replace(" ","",$Data_job_where[$i]) != "" )
			{
				$Data["job_where"]	.= ( $Data["job_where"] == "" )?"":" / ";
				$Data["job_where"]	.= $Data_job_where[$i];
			}
		}

		#$Data["job_where"]	= ( trim($Data["job_where"]) == "" )?"<font style=font-size:11px>정보없음</font>":$Data["job_where"];
		$Data["job_where"]	= ( trim($Data["job_where"]) == "" )?"<font style=font-size:11px>".$HAPPY_CONFIG['MsgNoInputArea1']."</font>":$Data["job_where"];

		#온라인입사지원의 취소
		if ( $Data['read_ok'] == 'N' )
		{
			#$Data['read_ok_info'] = '확인전';
			$Data['read_ok_info'] = $HAPPY_CONFIG['OnlineDontCheckText'];
		}
		else
		{
			#$Data['read_ok_info'] = '확인함';
			$Data['read_ok_info'] = $HAPPY_CONFIG['OnlineCheckedText'];
		}


		$Data['OnlineCancelBtn'] = "";
		if ( $HAPPY_CONFIG['OnlineCancelAble'] == 'Y' )
		{
			if ( $Data['read_ok'] == 'N' )
			{
				$Data['OnlineCancelBtn'] = '<a href="javascript:OnlineDel(\''.$Data['bNumber'].'\');"><img src="img/cancel_btn.gif" border="0" align="absmiddle" alt="기업회원이 확인전이기때문에 취소할 수 있습니다."></a>';
			}
			else
			{
				$Data['OnlineCancelBtn'] = '<img src="img/cancel_btn_non.gif" border="0" align="absmiddle" alt="기업회원이 확인을 하였기에 취소할 수 없습니다.">';
			}
		}

		//커스트마이징 2010-11-26 kad
		$Data['checkbox'] = '<input type="checkbox" id="sel_online[]" name="sel_online[]" style="width:13px; height:13px; vertical-align:middle;" value="'.$Data['bNumber'].'">';
		//echo $Data['online_stats'];


		$Data['select_stats'] = make_selectbox2(array_values($online_stats),array_keys($online_stats),'---선택---',"online_stats_".$Data['bNumber'],$Data['online_stats'],$select_width="150");
		$Data['btn_change'] = '<input type="button" value="변경" class="btn_small_stand" onclick="change_stats(\''.$Data['bNumber'].'\');" style="display:block !important; width:100%; margin-top:5px">';
		//$Data['btn_log'] =


		return $Data;
	}

?>