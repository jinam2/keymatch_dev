<?
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$arr	= Array(29,10,11,28,6,23,4,25,1,22,27,24,7,20,26,3,34);

	for ( $i=0,$max=sizeof($arr) ; $i<$max ; $i++ )
	{
		$ex_area1	= $arr[$i];
		$Sql	= "SELECT COUNT(*) FROM $per_document_tb WHERE display = 'Y' AND ( job_where1_0 = '$ex_area1' OR job_where2_0 = '$ex_area1' OR job_where3_0 = '$ex_area1' OR job_where1_0 = '$SI_NUMBER[전국]' OR job_where2_0 = '$SI_NUMBER[전국]' OR job_where3_0 = '$SI_NUMBER[전국]' )  ORDER BY number desc LIMIT 0, 9 ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));
		$Val[$i]	= $Tmp[0];
	}

print <<<END
<?xml version="1.0" encoding="euc-kr"?>

<xmlstart>

<banner>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=29" target="" areaname="서울" count="$Val[0]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=10" target="" areaname="인천" count="$Val[1]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=11" target="" areaname="경기도" count="$Val[2]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=28" target="" areaname="강원도" count="$Val[3]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=6" target="" areaname="충남" count="$Val[4]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=23" target="" areaname="대전" count="$Val[5]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=4" target="" areaname="충북" count="$Val[6]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=25" target="" areaname="경북" count="$Val[7]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=1" target="" areaname="대구" count="$Val[8]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=22" target="" areaname="울산" count="$Val[9]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=27" target="" areaname="전북" count="$Val[10]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=24" target="" areaname="경남" count="$Val[11]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=7" target="" areaname="부산" count="$Val[12]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=20" target="" areaname="광주" count="$Val[13]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=26" target="" areaname="전남" count="$Val[14]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=3" target="" areaname="제주도" count="$Val[15]"/>
<List url="html_file.php?file=guzic_arealist.html&file2=default_guzic.html&guzic_si=34" target="" areaname="세종시" count="$Val[16]"/>
</banner>

<ProductNum NcontA='5' NcontB='10' NcontC='15' NcontC='20' CcontA='facdb1' CcontB='fab68c' CcontC='fd9759' CcontD='ff6000'/>
<color mapbg='facdb1' ovcolor='F56236' linecolor='FFFFFF'/>
<speed speed="1000"/>

</xmlstart>
END;
?>