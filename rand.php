<?php
	include ("inc/config.php");
	include ("inc/function.php");
	#include ("inc/lib.php");


$local_array = Array("서울","인천","경기도","강원도","충청남도","대전","충청북도","경상북도","대구","울산","전라북도","경상남도","부산","광주","전라남도","제주도");

for($i = 500 ; $i < 600 ; $i++){
	$jumin1_1 = rand(20,99);
	$jumin1_2 = rand(1,12);
	$jumin1_3 = rand(1,30);

	$jumin2_1 = rand(1,2);
	if($jumin2_1 == "1")
		$per_gender = "1";
	else
		$per_gender = "0";

	$per_cell1 = rand(1000,9999);
	$per_cell2 = rand(1000,9999);

	if($jumin1_1 <10)
		$jumin1_1 = "0".$jumin1_1;
	if($jumin1_2 <10)
		$jumin1_2 = "0".$jumin1_2;
	if($jumin1_3 <10)
		$jumin1_3 = "0".$jumin1_3;

	$addr_rand = rand(0,15);

	do{
		$per_date1 = rand(2009,2010);
		if($per_date1 == 2010)
			$per_date2 = rand(1,8);
		else
			$per_date2 = rand(8,12);

		$per_date3 = rand(1,28);

		if($per_date2 <10)
			$per_date2 = "0".$per_date2;
		if($per_date3 <10)
			$per_date3 = "0".$per_date3;

		$per_date		= $per_date1."-".$per_date2."-".$per_date3;
	}while("2009-09-10" > $per_date || "2010-09-10" < $per_date);


	$per_date_time1 = rand(0,24);
	if($per_date_time1 < 10)
		$per_date_time1 = "0".$per_date_time1;

	$id				= "happy".$i;
	$pass			= "happy".$i;
	$name			= "happy".$i;
	$ju1			= $jumin1_1.$jumin1_2.$jumin1_3;
	$ju2			= $jumin2_1."726374";
	$per_birth		= "";
	$per_phone		= "123-1234-5678";
	$per_cell		= "010-".$per_cell1."-".$per_cell2;
	$per_email		= "hun@happycgi.com";
	$per_homepage	= "http://cgimall.co.kr";
	$zip			= "";
	$addr1			= $local_array[$addr_rand];
	$addr2			= "";
	$view_end_date	= "0000-00-00";
	$reg_end_date	= "0000-00-00";
	$dealer_want	= "0";
	$per_date = $per_date." $per_date_time1".":00:00";



	$sql = "insert into $com_tb set
				com_wait = '0',
				id = '$id',
				pass = '$pass',
				com_name = '$per_name',
				jumin = '$ju1',
				jumin2 = '$ju2',
				com_birth = '$per_birth',
				com_gender = '$per_gender',
				com_phone = '$per_phone',
				com_cell = '$per_cell',
				com_email = '$per_email',
				com_homepage = '$per_homepage',
				com_zip = '$zip',
				com_addr1 = '$addr1',
				com_addr2 = '$addr2',
				com_date = '$per_date'";


	#query($sql);
}
echo $sql."<br>";

exit;

$or_no = happy_mktime();

for($i = 0 ; $i < 300 ; $i++){
	do{
		$per_date1 = rand(2009,2010);
		if($per_date1 == 2010)
			$per_date2 = rand(1,8);
		else
			$per_date2 = rand(8,12);

		$per_date3 = rand(1,28);

		if($per_date2 <10)
			$per_date2 = "0".$per_date2;
		if($per_date3 <10)
			$per_date3 = "0".$per_date3;

		$per_date		= $per_date1."-".$per_date2."-".$per_date3;
	}while("2009-08-09" > $per_date || "2010-08-09" < $per_date);

	$temp_num = rand(1,6);

	$temp_num2 = rand(1,5);

	$temp_in_check = rand(1,2);
	if($temp_in_check == 2)
		$temp_in_check = 0;

	$temp_member_type = rand(1,3);
	if($temp_member_type == 3)
		$temp_member_type = 0;

	if($temp_num == 1){
			$goods_name = ",,,,,,,,30|500,,,,,";
			$goods_price = "500";
	}
	else if($temp_num == 2){
		$goods_name = ",,,,,,,,90|1100,,,,,";
		$goods_price = "1100";
	}
	else if($temp_num == 3){
		$goods_name = ",,,,,,,,500|5100,,,,,";
		$goods_price = "5100";
	}
	else if($temp_num == 4){
		$goods_name = ",,,,,,,,1100|11000,,,,,";
		$goods_price = "11000";
	}
	else if($temp_num == 5){
		$goods_name = ",,,,,,,,3500|31000,,,,,";
		$goods_price = "31000";
	}
	else if($temp_num == 6){
		$goods_name = ",,,,,,,,10000|55000,,,,,";
		$goods_price = "55000";
	}

	if($temp_num2 == 1){
		$or_method = "핸드폰결제";
	}
	else if($temp_num2 == 2){
		$or_method = "계좌이체";
	}
	else if($temp_num2 == 3){
		$or_method = "카드결제";
	}
	else if($temp_num2 == 4){
		$or_method = "실시간계좌이체";
	}
	else if($temp_num2 == 5){
		$or_method = "포인트결제";
	}

	$or_no = $or_no + 1;

	$sql = "
		INSERT INTO $jangboo SET
			or_id			= 'happy0',
			or_phone		= '011-011-0011',
			goods_name		= '$goods_name',
			goods_price		= '$goods_price',
			or_method		= '$or_method',
			or_no			= 'happy0-$or_no',
			links_number	= '1',
			jangboo_date	= '$per_date 12:12:12',
			in_check		= '$temp_in_check',
			member_type		= '$temp_member_type'
	";

	#echo $sql."<br>";
	#query($sql);

}




?>