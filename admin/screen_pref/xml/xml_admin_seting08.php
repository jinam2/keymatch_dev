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







<!-- ���� -->
<List url="" target="_parent" boxtext="ī�װ��޴�" boxtexttwo="temp/default_guin.html ���ϳ��뿡 ����" simages="img/shot/045s.png" bimages="img/shot/045.png" bimgwidth="180" bimgheight="652" Xaxis="20" Yaxis="200" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/happy_icon_admin.php" target="_parent" boxtext="�÷�������" boxtexttwo="���󺯰���� ���ø��̹��� �� ��������� �̵��մϴ�." simages="img/shot/046s.png" bimages="img/shot/046.png" bimgwidth="180" bimgheight="279" Xaxis="20" Yaxis="727" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/best_keyword.php" target="_parent" boxtext="�����±�" boxtexttwo="�������� �ǽð��α�˻���� �̵��մϴ�." simages="img/shot/047s.png" bimages="img/shot/047.png" bimgwidth="180" bimgheight="164" Xaxis="20" Yaxis="955" gapspace="0" movemode="TL" keyway="top"/>

<List url="" target="_parent" boxtext="�Աݰ��¾ȳ�" boxtexttwo="img/table_siteinbank.gif �����Դϴ�." simages="img/shot/048s.png" bimages="img/shot/048.png" bimgwidth="180" bimgheight="174" Xaxis="20" Yaxis="1090" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="��������" boxtexttwo="�Խ��ǰ����� �̵��մϴ�." simages="img/shot/049s.png" bimages="img/shot/049.png" bimgwidth="180" bimgheight="124" Xaxis="20" Yaxis="1235" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/banner_admin.php" target="_parent" boxtext="��ʱ���" boxtexttwo="��ʰ����� �̵��մϴ�." simages="img/shot/050s.png" bimages="img/shot/050.png" bimgwidth="180" bimgheight="76" Xaxis="20" Yaxis="1340" gapspace="0" movemode="TL" keyway="top"/>





<!-- ���� -->
<List url="$sub_url/admin/admin.php?area=mod" target="_parent" boxtext="ä������ �˻��ϱ�(ä������)" boxtexttwo="ä��/�̷¼� ��Ͽɼ� �������� �̵��մϴ�." simages="img/shot/096s.png" bimages="img/shot/096.png" bimgwidth="246" bimgheight="59" Xaxis="170" Yaxis="235" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/type_setting.php" target="_parent" boxtext="ä������ �˻��ϱ�(��������)" boxtexttwo="������������ �̵��մϴ�." simages="img/shot/097s.png" bimages="img/shot/097.png" bimgwidth="514" bimgheight="59" Xaxis="370" Yaxis="235" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/admin.php?area=mod" target="_parent" boxtext="ä������ �˻��ϱ�(��¼���)" boxtexttwo="ä��/�̷¼� ��Ͽɼ� �������� �̵��մϴ�." simages="img/shot/098s.png" bimages="img/shot/098.png" bimgwidth="246" bimgheight="32" Xaxis="170" Yaxis="285" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/area_setting.php" target="_parent" boxtext="ä������ �˻��ϱ�(��������)" boxtexttwo="������������ �̵��մϴ�." simages="img/shot/099s.png" bimages="img/shot/099.png" bimgwidth="514" bimgheight="32" Xaxis="370" Yaxis="285" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/admin.php?area=mod" target="_parent" boxtext="ä������ ī�װ�" boxtexttwo="����(ī�װ�)�������� �̵��մϴ�." simages="img/shot/100s.png" bimages="img/shot/100.png" bimgwidth="760" bimgheight="111" Xaxis="170" Yaxis="360" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="ä������" boxtexttwo="ä������������ �̵��մϴ�." simages="img/shot/101s.png" bimages="img/shot/101.png" bimgwidth="760" bimgheight="138" Xaxis="170" Yaxis="450" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/happy_icon_admin.php" target="_parent" boxtext="�÷�����������ǥ��" boxtexttwo="���󺯰���� �̹�������/���󺯰����� �̵��մϴ�." simages="img/shot/102s.png" bimages="img/shot/102.png" bimgwidth="553" bimgheight="433" Xaxis="170" Yaxis="570" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="��õĳ��������" boxtexttwo="ä������������ �̵��մϴ�." simages="img/shot/103s.png" bimages="img/shot/103.png" bimgwidth="207" bimgheight="433" Xaxis="615" Yaxis="570" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="ä������ ����Ʈ" boxtexttwo="ä������������ �̵��մϴ�." simages="img/shot/104s.png" bimages="img/shot/104.png" bimgwidth="760" bimgheight="694" Xaxis="170" Yaxis="920" gapspace="0" movemode="TL" keyway="top"/>






<!-- �ϴ� -->
<List url="" target="_parent" boxtext="ȸ��Ұ�" boxtexttwo="html_file/site_compnay.html ����" simages="img/shot/036s.png" bimages="img/shot/036.png" bimgwidth="139" bimgheight="35" Xaxis="20" Yaxis="1523" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/bbs_regist.php?id=&b_category=&tb=board_bannerreg" target="_parent" boxtext="������" boxtexttwo="�Խ��ǰ��� �κ��Դϴ�." simages="img/shot/037s.png" bimages="img/shot/037.png" bimgwidth="120" bimgheight="35" Xaxis="130" Yaxis="1523" gapspace="0" movemode="TC" keyway="top"/>

<List url="" target="_parent" boxtext="����������ȣ��å" boxtexttwo="html_file/site_rule.html ����" simages="img/shot/038s.png" bimages="img/shot/038.png" bimgwidth="140" bimgheight="35" Xaxis="230" Yaxis="1523" gapspace="0" movemode="TC" keyway="top"/>

<List url="" target="_parent" boxtext="�̿���" boxtexttwo="html_file/site_rule2.html ����" simages="img/shot/039s.png" bimages="img/shot/039.png" bimgwidth="130" bimgheight="35" Xaxis="340" Yaxis="1523" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="��������" boxtexttwo="�Խ��ǰ����� �̵��մϴ�." simages="img/shot/040s.png" bimages="img/shot/040.png" bimgwidth="125" bimgheight="35" Xaxis="445" Yaxis="1523" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="Ŀ�´�Ƽ" boxtexttwo="�������� �Խ��ǰ����� �̵��մϴ�." simages="img/shot/041s.png" bimages="img/shot/041.png" bimgwidth="125" bimgheight="35" Xaxis="550" Yaxis="1523" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="�������Խ���" boxtexttwo="�Խ��ǰ����� �̵��մϴ�." simages="img/shot/042s.png" bimages="img/shot/042.png" bimgwidth="171" bimgheight="35" Xaxis="650" Yaxis="1523" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/main_logo_admin.php" target="_parent" boxtext="�ϴ�����" boxtexttwo="�������� �ΰ������ �̵��մϴ�." simages="img/shot/043s.png" bimages="img/shot/043.png" bimgwidth="950" bimgheight="94" Xaxis="20" Yaxis="1559" gapspace="0" movemode="BL" keyway="top"/>

</banner>

<!--
keycolor : ���� �ش��ϴ� Ű������ �⺻����
keycolortwo : ���� �ش��ϴ� Ű������ �⺻����
bgimg : ������� ���� ����Ʈ ��ü �̹����ּ�
-->
<speed keycolor="FF7202" keycolortwo="EEEEEE" bgimg="img/shot/shot08_800.png"/>
</xmlstart>
END;

?>