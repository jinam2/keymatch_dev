<?

include ("./inc/Template.php");
$TPL = new Template;

include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");



#���̸�, ���̸� ������ ��Ƶα�
$Sql	= "SELECT * FROM $si_tb ";
$Record	= query($Sql);
while ( $Data = happy_mysql_fetch_array($Record) )
{
	$siSelect[$Data["number"]]	= $Data["si"];
	$siNumber[$Data["si"]]		= $Data["number"];
}

$Sql	= "SELECT * FROM $gu_tb ";
$Record	= query($Sql);
while ( $Data = happy_mysql_fetch_array($Record) )
{
	$guSelect[$Data["number"]]	= $Data["gu"];
	$guNumber[$Data["gu"]]		= $Data["number"];
}


$Sql	= "SELECT * FROM $per_document_tb WHERE number='$number' ";
$Data	= happy_mysql_fetch_array(query($Sql));

//�̷¼������ ȸ��
$User = happy_member_information($Data['user_id']);
$User['per_birth'] = $User['user_birth_year']."-".$User['user_birth_month']."-".$User['user_birth_day'];


//�α�����ȸ��
$MEM = happy_member_information(happy_member_login_check());
//�α�����ȸ���� ������ ����ɼ�
$tmp_array = array("guzic_view","guzic_view2","guin_docview","guin_docview2","sms_point");
$Tmem = happy_member_option_get_array($happy_member_option_type,$MEM['user_id'],$tmp_array);
$MEM = array_merge($MEM,$Tmem);
$userid = $MEM['user_id'];
$user_id = $userid;
$MEM['id'] = $user_id;
$MEM['guin_smspoint'] = $MEM['sms_point'];


#���Ⱑ���� ��¥
$guin_docview_p = $MEM["guin_docview"] - $real_gap;
if ($guin_docview_p > 0 ) {
	$guin_docview_p_date = date("Y-m-d",happy_mktime(0,0,0,date("m"),date("d")+$guin_docview_p,date("Y")));
} else {
	$guin_docview_p_date = "�Ⱓ����";
}

#���Ⱑ���� ȸ��
$guin_docview_c = $MEM["guin_docview2"];
#sms���ڹ߼۰��ɰǼ�
$smsPoint = $MEM["guin_smspoint"];

$Sql	= "SELECT count(*) as cnt FROM $job_com_doc_view_tb WHERE com_id='$user_id' AND doc_number='$number' ";
$Tmp	= happy_mysql_fetch_array(query($Sql));

#ȸ���� ����Ͽ� ���� ������
if ($Tmp["cnt"] != 0) {
	$com_id_secure		= "ok";
}

#�Ⱓ�� ����Ͽ� ���� ������
if ( $MEM["guin_docview"] > $real_gap ) {
	$com_id_secure		= "ok";
	#�Ⱓ�� �̷¼��� ���� �ִ� ������ �������
}


#echo $com_id_secure;


# �����ֳ� ���� ������ üũ���� #
if ( $com_id_secure == "ok" )
{
	$secure		= "ok";
}
else if ( $_COOKIE["ad_id"] != "" )
{
	$secure	= "ok";
	$a		= $Data["user_id"];
}
else if ( !happy_member_secure($happy_member_secure_text[0].'����') )
{
	$secure	= "no";
}





	$returnUrl	= $_SERVER["REQUEST_URI"];
	$returnUrl	= str_replace("&","??",$returnUrl);

	if ( happy_member_secure($happy_member_secure_text[0].'����') && $_COOKIE["ad_id"] == "" )
	{
		if ( !eregi($userid."," , $Data["viewList"] ) )
		{
			$Data["viewList"]	.= $userid.",";
		}

		$Sql	= "SELECT Count(*) FROM $per_noViewList WHERE per_id='$Data[user_id]' AND com_id='$userid' ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));

		if ( $Tmp[0] != 0 )
		{
			$secure	= "no";
			exit;
		}

		#���߿� ��ũ����ư ���̴� ������ Ʋ������ �Ʒ��� �Ẹ�ƿ� �Ѥ�
		#$Sql	= "SELECT Count(*) FROM $scrap_tb WHERE userid='$user_id' AND pNumber='$number' ";
		#$Tmp	= happy_mysql_fetch_array(query($Sql));

	}
	else if ( ( happy_member_login_check() !="" && $userid == $Data["user_id"] ) || $_COOKIE["ad_id"] != "" )
	{
		$secure	= "ok";

	}

	$search_user_id			= $Data["user_id"];

	$Data["email"]	= $Data["user_email1"];
	if ( $Data["user_email2"] != "" )
		$Data["email"]	.= ( $Data["email"] == "" )?$Data["user_email2"]:",".$Data["user_email2"];



	if ( str_replace("http://","",strtolower($Data["user_homepage"])) == "" )
	{
		$Data["user_homepage"]	= "��������";
	}

	if ( $secure == "guinView" )
	{
		if ( !eregi("Ȩ������",$viewUserState) )
		{
			$Data["user_homepage"]	= "�����";
		}
		if ( !eregi("��ȭ��ȣ",$viewUserState) )
		{
			$Data["user_phone"]		= "�����";
		}
		if ( !eregi("�ڵ���",$viewUserState) )
		{
			$Data["user_hphone"]	= "�����";
		}
		if ( !eregi("�ּ�",$viewUserState) )
		{
			$Data["user_zipcode"]	= "�����";
			$Data["user_addr1"]		= "�����";
			$Data["user_addr2"]		= "�����";
		}
		if ( !eregi("E-mail",$viewUserState) )
		{
			$Data["user_email1"]	= "�����";
			$Data["user_email2"]	= "�����";
			$Data["email"]			= "�����";
		}
	}
	else if ( $secure != "ok" )
	{
		#$Data["title"]			= "�����Ұ�";
		$Data["profile"]		= "�����Ұ�";
		$tmp					= strlen($Data["user_id"]);
		$Data["user_id"]		= substr($Data["user_id"],0,$tmp-3) . "***";
		$Data["user_name"]		= "�ۡۡ�";
		$Data["user_phone"]		= "�����Ұ�";
		$Data["user_hphone"]	= "�����Ұ�";
		$Data["user_email1"]	= "�����Ұ�";
		$Data["user_email2"]	= "�����Ұ�";
		$Data["user_homepage"]	= "�����Ұ�";
		$Data["user_zipcode"]	= "�����Ұ�";
		$Data["user_addr1"]		= "�����Ұ�";
		$Data["user_addr2"]		= "";
		$Data["email"]			= "�����Ұ�";

		for ( $i=1 ; $i<6 ; $i++ )
		{
			$tmp	= $Data["grade". $i ."_schoolName"];

			for ( $j=0,$max=strlen($tmp),$tmp2="" ; $j<$max ; $j++ )
				$tmp2	.= "��";

			$Data["grade". $i ."_schoolName"]	= $tmp2;
		}
	}



	# �⺻ �̷¼� ���̺� �� �����ϱ� #
	$Count2	= 0;
	for ( $i=1 ; $i<=5 ; $i++ )
		if ( $Data["file".$i] != "" )
			$Count2++;
	$���ϼ�	= $Count2;


	if ( $Data["user_image"] == "" )
	{
		$ū�̹���	= $main_url."/img/noimg.gif";
		$�����̹���	= $main_url."/img/noimg.gif";
	}
	else if ( !eregi($per_document_pic,$Data["user_image"]) )
	{
		$ū�̹���	= $main_url."/".$Data["user_image"];
		$�����̹���	= $main_url."/".$Data["user_image"];
	}
	else
	{
		$Tmp		= explode(".",$Data["user_image"]);
		if (preg_match("/jpg/i",$Tmp[sizeof($Tmp)-1])) {
			$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], "_thumb.".$Tmp[sizeof($Tmp)-1], $Data["user_image"]);
		} else {
			$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], ".".$Tmp[sizeof($Tmp)-1], $Data["user_image"]);
		}
		$ū�̹���	= $main_url."/".$Data["user_image"];
		$�����̹���	= $main_url."/".$Tmp2;
	}
	$�̹���	= $ū�̹���;

	for ( $i=0,$max=sizeof($skillArray) ; $i<$max ; $i++ )
	{
		switch ( $Data[$skillArray[$i]] )
		{
			case "3": $Data[$skillArray[$i]."_han"] = "��";break;
			case "2": $Data[$skillArray[$i]."_han"] = "��";break;
			case "1": $Data[$skillArray[$i]."_han"] = "��";break;
			default : $Data[$skillArray[$i]."_han"] = "";$Data[$skillArray[$i]] = "0";break;
		}
	}

	$Data["job_type1"]		= $TYPE[$Data["job_type1"]];
	$Data["job_type2"]		= $TYPE[$Data["job_type2"]];
	$Data["job_type3"]		= $TYPE[$Data["job_type3"]];

	$Data["job_type_sub1"]	= $TYPE_SUB[$Data["job_type_sub1"]];
	$Data["job_type_sub2"]	= $TYPE_SUB[$Data["job_type_sub2"]];
	$Data["job_type_sub3"]	= $TYPE_SUB[$Data["job_type_sub3"]];

	for ( $i=1, $Data["job_type"]="" ; $i<4 ; $i++ )
		if ( $Data["job_type_sub".$i] != "" )
		{
			$Data["job_type"]	.= ( $Data["job_type"] == "" )?"":"<br>";
			$Data["job_type"]	.= $Data["job_type".$i] ." > ". $Data["job_type_sub".$i];
		}

	$Data["job_type"]		= ( trim($Data["job_type"]) == "" )?"<font style=font-size:11px>��������</font>":$Data["job_type"];

	$Data["work_year"]		= ( $Data["work_year"] == "" )?"��¾���":$Data["work_year"]." ��";
	$Data["work_month"]		= ( $Data["work_month"] == "" )?"":$Data["work_month"]." ����";


	$Data["user_bohun"]		= ( $Data["user_bohun"] == "Y" )?"���":"����";
	$Data["user_jangae"]	= ( $Data["user_jangae"] != "" )?"��� ". $Data["user_jangae"]."��":"�����";
	switch ( $Data["user_army"] )
	{
		case "Y":	$Data["user_army"] = "����";break;
		case "N":	$Data["user_army"] = "����";break;
		case "G":	$Data["user_army"] = "����";break;
	}

	if ( $Data["user_army"] == "����" && $Data["user_army_start"] != "" && $Data["user_army_end"] != ""  )
	{
		$Data["user_army_status"]	= $Data["user_army_start"]." �Դ� ".$Data["user_army_end"]." ���� ".$Data["user_army_type"]." ".$Data["user_army_level"];
	}
	else
		$Data["user_army_status"]	= "����������";

	$Data["keyword"]	= ( $Data["keyword"] == "" )?"<font style=font-size:11px>��������</font>":$Data["keyword"];

	$Data["job_where1"]	= $siSelect[$Data["job_where1_0"]] ." ". $guSelect[$Data["job_where1_1"]];
	$Data["job_where2"]	= $siSelect[$Data["job_where2_0"]] ." ". $guSelect[$Data["job_where2_1"]];
	$Data["job_where3"]	= $siSelect[$Data["job_where3_0"]] ." ". $guSelect[$Data["job_where3_1"]];

	$Data_job_where		= array();
	array_push($Data_job_where, $Data["job_where1"]);
	array_push($Data_job_where, $Data["job_where2"]);
	array_push($Data_job_where, $Data["job_where3"]);

	for ( $i=0, $max=sizeof($Data_job_where), $Data["job_where"]="" ; $i<$max ; $i++ )
		if ( str_replace(" ","",$Data_job_where[$i]) != "" )
		{
			$Data["job_where"]	.= ( $Data["job_where"] == "" )?"":", ";
			$Data["job_where"]	.= $Data_job_where[$i];
		}

	$Data["job_where"]	= ( trim($Data["job_where"]) == "" )?"��������":$Data["job_where"];

	$Data["work_otherCountry"]	= ( $Data["work_otherCountry"] == "Y" )?"�ؿܱٹ��������":"";

//�ش� ����� �ҷ�����
	# �̹��� ���� ����
	$Sql			= "SELECT * FROM $per_file_tb where doc_number='$number' order by number asc";
	$imageRecord	= query($Sql);

	while ( $imageData = happy_mysql_fetch_array($imageRecord) )
	{
		$imageData['fileName_thumb']	= str_replace("((thumb_name))","_thumb",$imageData['fileName']);
		$imageData['fileName_big']		= str_replace("((thumb_name))","_big",$imageData['fileName']);
		$imageData['fileName']			= str_replace("((thumb_name))","",$imageData['fileName']);

		if( is_file($imageData['fileName_thumb']) ) {
			$outputList	.= "<List miniimg='$imageData[fileName_thumb]' orgimg='$imageData[fileName_big]' title='$xml_popup_names[$i]'/>\n";
		}

	}

if($Data[etc8] == '����'){
	$incom = $Data[etc9];
}else{
	$incom = "�Ҽӻ� ����";
}

$Data[work_list] = str_replace("\r","",$Data[work_list]);

$Data[title] = kstrcut($Data[title], 46, "...");

#Ȱ�����ɿ���
$TempDays = explode(" ",$Data['etc7']);
$Data['etc7'] = "";
foreach($TempDays as $k => $v)
{
	$Yicon = $TDayNames[$v];
	if ( $v != '' )
	{
		$Data['etc7'] .= $comma.$Yicon;
		$comma = ",";
	}
}
if ( $Data['etc7'] == '' )
{
	$Data['etc7'] = $HAPPY_CONFIG['MsgNoInputDay1'];
}
#Ȱ�����ɿ���


print <<<END
<?xml version="1.0" encoding="euc-kr"?>
<xmlstart>

<banner>

$outputList


</banner>

<galleryoption wcount="5" Width="70" Height="90" orgWidth="400" orgHeight="600" bgWidth="150" bgHeight="150" bgcount="6" bgrepeat="45" />
<speed infotext="&lt;font size='11'&gt;&lt;b&gt;&lt;font size='16' color='#bf2305'&gt;$Data[title]&lt;/font&gt;&lt;/b&gt;\n �̸� : $Data[user_name] ($Data[user_id])\n ����ó : $Data[user_hphone] \n ������� : $Data[job_where] \n ����޿� : $Data[grade_money_type] $Data[grade_money] \n Ȱ�����ɿ��� : $Data[etc7]"/>
<bgimage bgimage="img/logo/minialbumlogo.png"/>

<!--
\n&lt;b&gt;&lt;font size='12' color='#ff6e03'&gt;��»���&lt;/font&gt;&lt;/b&gt;\n$Data[work_list]

-->

</xmlstart>

END;
?>