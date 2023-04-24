<?php
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/Template.php");
	$TPL = new Template();
	include ("../inc/lib.php");

	if ( !admin_secure("슈퍼관리자전용") )
	{
		error("접속권한이 없습니다.");
		exit;
	}


	
	
	$content = "
		<link rel='stylesheet' href='./css/jquery.captcha.css' type='text/css'>

		<div style='text-align:center;'>
		<table width='99%'  height='37' border='0' cellpadding='0' cellspacing='0'>
			<tr>
				<td><img src='img/file_uncheck.gif' title='파일미삭제 로그' alt='파일미삭제 로그'></td>
				<td class='smfont' style='text-align:right; padding:0 10px 0px 0px;'>총 개수 <b><span id='init_del_false_total'></span></b> &nbsp;개</td>
			</tr>
		 </table>
		 </div>

		<div style='text-align:center;'>
		<table border='0' cellspacing='1' cellpadding='0' width='99%' bgcolor='#dedede'>
		<tr>
			<td bgcolor='#FFFFFF' height='30' style='padding:1;'>

				<table border='0' cellspacing='0' cellpadding='0' width='100%' height='30' bgcolor='#f7f7f7'>
					<tr>
						<td align='center' class='smfont' width='55'><font color='#1e6400'>번호</font></td>
						<td width='1' bgcolor='#FFFFFF'></td>
						<td width='1' bgcolor='#dedede'></td>
						<td align='center' class='smfont'><font color='#1e6400'>파일경로</font></td>
					</tr>
				</table>

			</td>
		</tr>
		<tr>
			<td bgcolor='#FFFFFF' height='30' align='center' class='smfont'>
	";

	$top_path = "../";
	$data_file = file("./log/init/$_GET[filename]");
	foreach($data_file AS $line_num => $filename_val)
	{
		$del_text = "";

		clearstatcache();
		$filename_val	= trim($filename_val);
		$filename_size	= "";
		if (file_exists($top_path.$filename_val))
		{
			$filename_size	= "(".number_format(filesize($top_path.$filename_val))." bytes)";
		}
		if (!file_exists($top_path.$filename_val))
		{
			$del_text = "<font color='red'>삭제됨</font>";
		}

		$line_num++;
		$content .= "
					<table width='100%' height='30'  border='0' cellpadding='0' cellspacing='0'>
					<tr align='center'>
					  <td width='52' align='center' style='padding:0 0 0 5' class='smfont'>$line_num</td>
					  <td align=left style='padding:0 10 0 0' class='smfont'>$filename_val $filename_size $del_text</td>
					</tr>
					<tr>
						<td bgcolor='#eeeeee' height='1' colspan='4'></td>
					</tr>
				</table>
		";
	}

	$line_num_comma = number_format($line_num);
	$content .= "</td>
			</tr>
		</table>

	<script>
		document.getElementById('init_del_false_total').innerHTML = '$line_num_comma';
	</script>
	";


	print $content;

?>