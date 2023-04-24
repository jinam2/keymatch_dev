<?
include ("./inc/config.php");
include ("./inc/Template.php");
$t_start = array_sum(explode(' ', microtime()));
$TPL = new Template;
include ("./inc/function.php");
include ("./inc/lib.php");

$per_cell		= $_GET['per_cell'];

if ( $per_cell == "" )
{
	echo "핸드폰번호가 없습니다.";
	exit;
}

if( strlen( $per_cell ) < 10 )
{
	echo "휴대폰 번호가 너무 짧습니다.";
	exit;
}

if ( preg_match( "/[a-zA-Zㄱ-힝]/",$per_cell ) )
{
	echo "핸드폰 번호의 형식이 틀렸습니다.";
	exit;
}


#잘라놓자
$per_cell_a	= explode("-",$per_cell);
$per_cell	= preg_replace('/\D/', '', $per_cell);

$sql		= "SELECT * FROM  $happy_member_sms_confirm WHERE phone_number ='$per_cell' AND confirm_code = '$input_confirm_number' ";
$result		= query($sql);
$CHECK		= happy_mysql_fetch_array($result);

#합치자
$per_cell	= implode("-", (array) $per_cell_a);

if ($CHECK[number]) #인증이 되었으면
{
	echo "success___CUT___";
	/*
	echo "
			<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class='email_certification'>
			<tr>
				<td class='title_img_ok'></td>
			</tr>
			<tr>
				<td class='content'><label>$per_cell</label>  <br />인증이 성공하였습니다.<br /><br /> [핸드폰인증확인] 버튼을 <br />반드시 클릭하셔야</br> 회원가입이 진행됩니다.</td>
			</tr>
			<tr>
				<td class='button'><input type='submit' onclick='lastsetting(\"$per_cell\",\"$input_confirm_number\")' value='핸드폰인증확인'></td>
			</tr>
			</table>
	";
	*/
}
else {
	echo "인증번호가 일치하지 않습니다.";
	exit;
}
?>