<?

//�����ּҿ�
include "../sub_url.php";






echo <<<END

<?xml version="1.0" encoding="euc-kr"?>
<xmlstart>

<!--
url : ��ũ�ּ�
target : ��ũŸ��
boxtext : ���� �ش��ϴ� Ű����(�⺻ HTML��밡�� �� <�� >�� &lt; �� &gt; �� ���)
boxtexttwo : ���� �ش��ϴ� Ű����(�⺻ HTML��밡�� �� <�� >�� &lt; �� &gt; �� ��� �ٳ����� || �� ���)
simages : �����̹����� �ּ�
bimages : ū�̹����� �ּ�
bimgwidth : ū�̹����� �ʺ�
bimgheight : ū�̹����� ����
Xaxis : �����̹��� X�� ��ġ
Yaxis : �����̹��� Y�� ��ġ
gapspace : �̹����� Ŀ���� ���� ����� ������ �� �� �ֽ��ϴ�.(������ T�ϰ�쳪 L�ϰ�� ����ϸ� �̻��ϰ� ���� �� �ֽ��ϴ�.)
======================================================================
movemode : Ȯ�밡 �ɶ� �����ġ�� Ȯ�밡 ������ ���� �� �ֽ��ϴ�.
��) TL -> T(top���)L(left����)

T(TOP)
M(MIDDLE)
B(BOTTOM)

L(LEFT)
C(CENTER)
R(RIGHT)

TL
TC
TR

ML
MC
MR

BL
BC
BR
���¸� ����� �� �ֽ��ϴ�.
������ ���Ʒ� ������ �¿� �����̸� �빮�ڿ��� �մϴ�.
======================================================================
keyway : Ű������ �����ġ�� ���մϴ�.
top : ���
bottom: �ϴ�
-->

<banner>


<!-- ��� -->
<List url="" target="_parent" boxtext="���۳���" boxtexttwo="���۳��� ���������� �����ݴϴ�.(��ü����)" simages="img/shot/001s.png" bimages="img/shot/001.png" bimgwidth="110" bimgheight="30" Xaxis="220" Yaxis="0" gapspace="0" movemode="TC" keyway="bottom"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="��������(ƼĿ��)" boxtexttwo="ä������������ �̵��մϴ�." simages="img/shot/002s.png" bimages="img/shot/002.png" bimgwidth="342" bimgheight="30" Xaxis="310" Yaxis="0" gapspace="0" movemode="TC" keyway="bottom"/>

<List url="" target="_parent" boxtext="ȸ���α��� ������Ȳ" boxtexttwo="temp/logout_button(logon_button).html" simages="img/shot/003s.png" bimages="img/shot/003.png" bimgwidth="135" bimgheight="30" Xaxis="605" Yaxis="0" gapspace="0" movemode="TR" keyway="bottom"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="������" boxtexttwo="�Խ��ǰ��� �̵�" simages="img/shot/004s.png" bimages="img/shot/004.png" bimgwidth="65" bimgheight="30" Xaxis="720" Yaxis="0" gapspace="0" movemode="TR" keyway="bottom"/>

<List url="$sub_url/admin/main_logo_admin.php" target="_parent" boxtext="�ΰ����" boxtexttwo="�ΰ������ �̵��մϴ�." simages="img/shot/005s.png" bimages="img/shot/005.png" bimgwidth="399" bimgheight="50" Xaxis="20" Yaxis="40" gapspace="0" movemode="TL" keyway="bottom"/>

<List url="$sub_url/admin/banner_admin.php" target="_parent" boxtext="��ʱ���" boxtexttwo="��ʰ����� �̵��մϴ�." simages="img/shot/006s.png" bimages="img/shot/006.png" bimgwidth="171" bimgheight="50" Xaxis="630" Yaxis="40" gapspace="0" movemode="TR" keyway="bottom"/>

<List url="$sub_url/admin/happy_icon_admin.php?type=add&group=&number=256&start=180&search_order=&keyword=" target="_parent" boxtext="����̹���(�������)" boxtexttwo="���ø��̹��� �� ��������� �̵��մϴ�." simages="img/shot/044s.png" bimages="img/shot/044.png" bimgwidth="169" bimgheight="50" Xaxis="20" Yaxis="90" gapspace="0" movemode="TL" keyway="bottom"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="ä������(����,������)" boxtexttwo="ä������������ �̵��մϴ�." simages="img/shot/007s.png" bimages="img/shot/007.png" bimgwidth="169" bimgheight="45" Xaxis="20" Yaxis="140" gapspace="0" movemode="TL" keyway="bottom"/>

<List url="$sub_url/admin/happy_config_view.php?number=16" target="_parent" boxtext="��õŰ����" boxtexttwo="��õŰ���� �ܾ� �������� �̵��մϴ�." simages="img/shot/008s.png" bimages="img/shot/008.png" bimgwidth="550" bimgheight="30" Xaxis="180" Yaxis="100" gapspace="0" movemode="MC" keyway="bottom"/>

<List url="" target="_parent" boxtext="�÷��ø޴�" boxtexttwo="xml/xml_menu.php ���Ͽ��� �����˴ϴ�.." simages="img/shot/009s.png" bimages="img/shot/009.png" bimgwidth="550" bimgheight="34" Xaxis="180" Yaxis="130" gapspace="0" movemode="MC" keyway="bottom"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="ä���������" boxtexttwo="�������� ä������������ �̵��մϴ�." simages="img/shot/010s.png" bimages="img/shot/010.png" bimgwidth="160" bimgheight="50" Xaxis="640" Yaxis="90" gapspace="0" movemode="TR" keyway="bottom"/>

<List url="$sub_url/admin/guin.php?a=guzic&mode=list" target="_parent" boxtext="�̷¼����" boxtexttwo="�������� �̷¼������� �̵��մϴ�." simages="img/shot/011s.png" bimages="img/shot/011.png" bimgwidth="160" bimgheight="50" Xaxis="640" Yaxis="140" gapspace="0" movemode="TR" keyway="bottom"/>



<!-- ���κ��� -->
<List url="" target="_parent" boxtext="ȸ���α���" boxtexttwo="logon_per(logoff,logon_com).html ��������" simages="img/shot/012s.png" bimages="img/shot/012.png" bimgwidth="185" bimgheight="126" Xaxis="20" Yaxis="190" gapspace="0" movemode="TL" keyway="bottom"/>

<List url="$sub_url/admin/banner_admin.php" target="_parent" boxtext="��ʱ���" boxtexttwo="��ʰ����� �̵��մϴ�." simages="img/shot/013s.png" bimages="img/shot/013.png" bimgwidth="185" bimgheight="104" Xaxis="20" Yaxis="295" gapspace="0" movemode="TL" keyway="bottom"/>

<List url="$sub_url/admin/main_banner.php" target="_parent" boxtext="�÷��ù��" boxtexttwo="�÷��ù�ʷ� �̵��մϴ�." simages="img/shot/014s.png" bimages="img/shot/014.png" bimgwidth="550" bimgheight="222" Xaxis="180" Yaxis="200" gapspace="0" movemode="MC" keyway="bottom"/>

<List url="$sub_url/admin/best_keyword.php" target="_parent" boxtext="�÷��ýǽð� �α�˻���" boxtexttwo="�÷��ù�ʷ� �̵��մϴ�." simages="img/shot/015s.png" bimages="img/shot/015.png" bimgwidth="186" bimgheight="222" Xaxis="630" Yaxis="200" gapspace="0" movemode="TR" keyway="bottom"/>



<!-- ���� 1 -->
<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="����� ä������" boxtexttwo="ä������������ �̵��մϴ�." simages="img/shot/016s.png" bimages="img/shot/016.png" bimgwidth="950" bimgheight="407" Xaxis="20" Yaxis="380" gapspace="0" movemode="TL" keyway="top"/>


<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="�����̾� ä������" boxtexttwo="ä������������ �̵��մϴ�." simages="img/shot/017s.png" bimages="img/shot/017.png" bimgwidth="950" bimgheight="185" Xaxis="20" Yaxis="710" gapspace="0" movemode="TL" keyway="top"/>


<!-- ���� 2 ���� -->
<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="�ޱ�ä������" boxtexttwo="ä������������ �̵��մϴ�." simages="img/shot/018s.png" bimages="img/shot/018.png" bimgwidth="204" bimgheight="125" Xaxis="20" Yaxis="870" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/happy_icon_admin.php" target="_parent" boxtext="�÷�������" boxtexttwo="���󺯰���� ���ø��̹��� �� ��������� �̵��մϴ�. " simages="img/shot/019s.png" bimages="img/shot/019.png" bimgwidth="204" bimgheight="310" Xaxis="20" Yaxis="970" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/best_keyword.php" target="_parent" boxtext="�����±�" boxtexttwo="�������� �ǽð��α�˻���� �̵��մϴ�. " simages="img/shot/020s.png" bimages="img/shot/020.png" bimgwidth="204" bimgheight="170" Xaxis="20" Yaxis="1225" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/poll_admin.php" target="_parent" boxtext="��������" boxtexttwo="��ǥ������ �̵��մϴ�." simages="img/shot/021s.png" bimages="img/shot/021.png" bimgwidth="204" bimgheight="265" Xaxis="20" Yaxis="1365" gapspace="0" movemode="TL" keyway="top"/>

<List url="" target="_parent" boxtext="�Աݰ��¾ȳ�" boxtexttwo="img/table_siteinbank.gif �����Դϴ�." simages="img/shot/022s.png" bimages="img/shot/022.png" bimgwidth="204" bimgheight="175" Xaxis="20" Yaxis="1580" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="��������" boxtexttwo="�Խ��ǰ����� �̵��մϴ�." simages="img/shot/023s.png" bimages="img/shot/023.png" bimgwidth="204" bimgheight="126" Xaxis="20" Yaxis="1730" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="������" boxtexttwo="img/table_customer2.gif �����Դϴ�." simages="img/shot/024s.png" bimages="img/shot/024.png" bimgwidth="204" bimgheight="184" Xaxis="20" Yaxis="1830" gapspace="0" movemode="TL" keyway="top"/>




<!-- ����2 ���� -->
<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="��õä������" boxtexttwo="ä������������ �̵��մϴ�." simages="img/shot/025s.png" bimages="img/shot/025.png" bimgwidth="736" bimgheight="170" Xaxis="190" Yaxis="870" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="�����ä������" boxtexttwo="ä������������ �̵��մϴ�." simages="img/shot/026s.png" bimages="img/shot/026.png" bimgwidth="736" bimgheight="135" Xaxis="190" Yaxis="1015" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guzic&mode=list" target="_parent" boxtext="�Ŀ���ũ��������" boxtexttwo="�̷¼������� �̵��մϴ�." simages="img/shot/027s.png" bimages="img/shot/027.png" bimgwidth="736" bimgheight="270" Xaxis="190" Yaxis="1125" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guzic&mode=list" target="_parent" boxtext="��������(��Ŀ��/�����)" boxtexttwo="�̷¼������� �̵��մϴ�." simages="img/shot/028s.png" bimages="img/shot/028.png" bimgwidth="736" bimgheight="150" Xaxis="190" Yaxis="1365" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="�ֱ�ä������" boxtexttwo="ä������������ �̵��մϴ�." simages="img/shot/029s.png" bimages="img/shot/029.png" bimgwidth="366" bimgheight="175" Xaxis="190" Yaxis="1495" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guzic&mode=list" target="_parent" boxtext="�ֱ���������" boxtexttwo="�̷¼����� �̵��մϴ�." simages="img/shot/030s.png" bimages="img/shot/030.png" bimgwidth="366" bimgheight="175" Xaxis="490" Yaxis="1495" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="�˹�ä������" boxtexttwo="ä������������ �̵��մϴ�." simages="img/shot/031s.png" bimages="img/shot/031.png" bimgwidth="366" bimgheight="165" Xaxis="190" Yaxis="1640" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guzic&mode=list" target="_parent" boxtext="�˹ٱ�������" boxtexttwo="�̷¼������� �̵��մϴ�." simages="img/shot/032s.png" bimages="img/shot/032.png" bimgwidth="366" bimgheight="165" Xaxis="490" Yaxis="1640" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="���α�������" boxtexttwo="�Խ��ǰ����� �̵��մϴ�." simages="img/shot/033s.png" bimages="img/shot/033.png" bimgwidth="366" bimgheight="135" Xaxis="190" Yaxis="1770" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="���α�������" boxtexttwo="�Խ��ǰ����� �̵��մϴ�." simages="img/shot/034s.png" bimages="img/shot/034.png" bimgwidth="366" bimgheight="135" Xaxis="490" Yaxis="1770" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="���䰶����" boxtexttwo="�Խ��ǰ����� �̵��մϴ�." simages="img/shot/035s.png" bimages="img/shot/035.png" bimgwidth="736" bimgheight="165" Xaxis="190" Yaxis="1870" gapspace="0" movemode="TL" keyway="top"/>




<!-- �ϴ� -->
<List url="" target="_parent" boxtext="ȸ��Ұ�" boxtexttwo="html_file/site_compnay.html ����" simages="img/shot/036s.png" bimages="img/shot/036.png" bimgwidth="139" bimgheight="35" Xaxis="20" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/bbs_regist.php?id=&b_category=&tb=board_bannerreg" target="_parent" boxtext="������" boxtexttwo="�Խ��ǰ��� �κ��Դϴ�." simages="img/shot/037s.png" bimages="img/shot/037.png" bimgwidth="120" bimgheight="35" Xaxis="130" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="" target="_parent" boxtext="����������ȣ��å" boxtexttwo="html_file/site_rule.html ����" simages="img/shot/038s.png" bimages="img/shot/038.png" bimgwidth="140" bimgheight="35" Xaxis="230" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="" target="_parent" boxtext="�̿���" boxtexttwo="html_file/site_rule2.html ����" simages="img/shot/039s.png" bimages="img/shot/039.png" bimgwidth="130" bimgheight="35" Xaxis="340" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="��������" boxtexttwo="�Խ��ǰ����� �̵��մϴ�." simages="img/shot/040s.png" bimages="img/shot/040.png" bimgwidth="125" bimgheight="35" Xaxis="445" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="Ŀ�´�Ƽ" boxtexttwo="�������� �Խ��ǰ����� �̵��մϴ�." simages="img/shot/041s.png" bimages="img/shot/041.png" bimgwidth="125" bimgheight="35" Xaxis="550" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="�������Խ���" boxtexttwo="�Խ��ǰ����� �̵��մϴ�." simages="img/shot/042s.png" bimages="img/shot/042.png" bimgwidth="171" bimgheight="35" Xaxis="650" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/main_logo_admin.php" target="_parent" boxtext="�ϴ�����" boxtexttwo="�������� �ΰ������ �̵��մϴ�." simages="img/shot/043s.png" bimages="img/shot/043.png" bimgwidth="950" bimgheight="94" Xaxis="20" Yaxis="2055" gapspace="0" movemode="BL" keyway="top"/>

</banner>

<!--
keycolor : ���� �ش��ϴ� Ű������ �⺻����
keycolortwo : ���� �ش��ϴ� Ű������ �⺻����
bgimg : ������� ���� ����Ʈ ��ü �̹����ּ�
-->
<speed keycolor="FF7202" keycolortwo="EEEEEE" bgimg="img/shot/shot01_800.png"/>
</xmlstart>
END;

?>