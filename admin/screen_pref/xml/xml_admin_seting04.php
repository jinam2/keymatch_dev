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
boxtexttwo : ������ �ش��ϴ� Ű����(�⺻ HTML��밡�� �� <�� >�� &lt; �� &gt; �� ��� �ٳ����� || �� ���)
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

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="��������" boxtexttwo="�Խ��ǰ��� �̵�" simages="img/shot/004s.png" bimages="img/shot/004.png" bimgwidth="65" bimgheight="30" Xaxis="720" Yaxis="0" gapspace="0" movemode="TR" keyway="bottom"/>

<List url="$sub_url/admin/main_logo_admin.php" target="_parent" boxtext="�ΰ�����" boxtexttwo="�ΰ������� �̵��մϴ�." simages="img/shot/005s.png" bimages="img/shot/005.png" bimgwidth="399" bimgheight="50" Xaxis="20" Yaxis="40" gapspace="0" movemode="TL" keyway="bottom"/>

<List url="$sub_url/admin/banner_admin.php" target="_parent" boxtext="��ʱ���" boxtexttwo="��ʰ����� �̵��մϴ�." simages="img/shot/006s.png" bimages="img/shot/006.png" bimgwidth="171" bimgheight="50" Xaxis="630" Yaxis="40" gapspace="0" movemode="TR" keyway="bottom"/>

<List url="$sub_url/admin/happy_icon_admin.php?type=add&group=&number=256&start=180&search_order=&keyword=" target="_parent" boxtext="����̹���(�������)" boxtexttwo="���ø��̹��� �� ��������� �̵��մϴ�." simages="img/shot/044s.png" bimages="img/shot/044.png" bimgwidth="169" bimgheight="50" Xaxis="20" Yaxis="90" gapspace="0" movemode="TL" keyway="bottom"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="ä������(����,������)" boxtexttwo="ä������������ �̵��մϴ�." simages="img/shot/007s.png" bimages="img/shot/007.png" bimgwidth="169" bimgheight="45" Xaxis="20" Yaxis="140" gapspace="0" movemode="TL" keyway="bottom"/>

<List url="$sub_url/admin/happy_config_view.php?number=16" target="_parent" boxtext="��õŰ����" boxtexttwo="��õŰ���� �ܾ� �������� �̵��մϴ�." simages="img/shot/008s.png" bimages="img/shot/008.png" bimgwidth="550" bimgheight="30" Xaxis="180" Yaxis="100" gapspace="0" movemode="MC" keyway="bottom"/>

<List url="" target="_parent" boxtext="�÷��ø޴�" boxtexttwo="xml/xml_menu.php ���Ͽ��� �����˴ϴ�.." simages="img/shot/009s.png" bimages="img/shot/009.png" bimgwidth="550" bimgheight="34" Xaxis="180" Yaxis="130" gapspace="0" movemode="MC" keyway="bottom"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="ä���������" boxtexttwo="�������� ä������������ �̵��մϴ�." simages="img/shot/010s.png" bimages="img/shot/010.png" bimgwidth="160" bimgheight="50" Xaxis="640" Yaxis="90" gapspace="0" movemode="TR" keyway="bottom"/>

<List url="$sub_url/admin/guin.php?a=guzic&mode=list" target="_parent" boxtext="�̷¼����" boxtexttwo="�������� �̷¼������� �̵��մϴ�." simages="img/shot/011s.png" bimages="img/shot/011.png" bimgwidth="160" bimgheight="50" Xaxis="640" Yaxis="140" gapspace="0" movemode="TR" keyway="bottom"/>







<!-- ���� -->
<List url="" target="_parent" boxtext="�����������޴�" boxtexttwo="temp/default_com.html ���ϳ��뿡 ����" simages="img/shot/068s.png" bimages="img/shot/068.png" bimgwidth="180" bimgheight="647" Xaxis="20" Yaxis="200" gapspace="0" movemode="TL" keyway="top"/>

<List url="" target="_parent" boxtext="�Աݰ��¾ȳ�" boxtexttwo="img/table_siteinbank.gif �����Դϴ�." simages="img/shot/048s.png" bimages="img/shot/048.png" bimgwidth="180" bimgheight="174" Xaxis="20" Yaxis="725" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/happy_config_view.php?number=24" target="_parent" boxtext="���۱���" boxtexttwo="�ܺα��������� �̵��մϴ�." simages="img/shot/051s.png" bimages="img/shot/051.png" bimgwidth="180" bimgheight="148" Xaxis="20" Yaxis="870" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/banner_admin.php" target="_parent" boxtext="��ʱ���" boxtexttwo="��ʰ����� �̵��մϴ�." simages="img/shot/052s.png" bimages="img/shot/052.png" bimgwidth="180" bimgheight="76" Xaxis="20" Yaxis="1000" gapspace="0" movemode="TL" keyway="top"/>





<!-- ���� -->
<List url="$sub_url/admin/admin.php?a=com&mode=list" target="_parent" boxtext="ä����������" boxtexttwo="����ȸ�������� �̵��մϴ�." simages="img/shot/069s.png" bimages="img/shot/069.png" bimgwidth="760" bimgheight="125" Xaxis="170" Yaxis="265" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/admin.php?area=mod" target="_parent" boxtext="�⺻����" boxtexttwo="ä��/�̷¼���Ͽɼ� ������ �̵��մϴ�." simages="img/shot/070s.png" bimages="img/shot/070.png" bimgwidth="760" bimgheight="400" Xaxis="170" Yaxis="365" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/area_setting.php" target="_parent" boxtext="�ٹ�����" boxtexttwo="�������� �������������� �̵��մϴ�." simages="img/shot/071s.png" bimages="img/shot/071.png" bimgwidth="760" bimgheight="125" Xaxis="170" Yaxis="680" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/area_setting.php" target="_parent" boxtext="����/����" boxtexttwo="�������� ���������� �̵��մϴ�." simages="img/shot/072s.png" bimages="img/shot/072.png" bimgwidth="760" bimgheight="125" Xaxis="170" Yaxis="785" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/admin.php?area=mod" target="_parent" boxtext="�����Ļ�" boxtexttwo="ä��/�̷¼���Ͽɼ� ������ �̵��մϴ�." simages="img/shot/073s.png" bimages="img/shot/073.png" bimgwidth="760" bimgheight="125" Xaxis="170" Yaxis="960" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/admin.php?area=mod" target="_parent" boxtext="Ű����" boxtexttwo="ä��/�̷¼���Ͽɼ� ������ �̵��մϴ�." simages="img/shot/074s.png" bimages="img/shot/074.png" bimgwidth="760" bimgheight="105" Xaxis="170" Yaxis="1170" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/money_setup.php?action=option" target="_parent" boxtext="����ɼ�" boxtexttwo="����ȸ�� ��������ȭ�������� �̵��մϴ�." simages="img/shot/075s.png" bimages="img/shot/075.png" bimgwidth="760" bimgheight="395" Xaxis="170" Yaxis="1410" gapspace="0" movemode="TR" keyway="top"/>






<!-- �ϴ� -->
<List url="" target="_parent" boxtext="ȸ��Ұ�" boxtexttwo="html_file/site_compnay.html ����" simages="img/shot/036s.png" bimages="img/shot/036.png" bimgwidth="139" bimgheight="35" Xaxis="20" Yaxis="1893" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/bbs_regist.php?id=&b_category=&tb=board_bannerreg" target="_parent" boxtext="��������" boxtexttwo="�Խ��ǰ��� �κ��Դϴ�." simages="img/shot/037s.png" bimages="img/shot/037.png" bimgwidth="120" bimgheight="35" Xaxis="130" Yaxis="1893" gapspace="0" movemode="TC" keyway="top"/>

<List url="" target="_parent" boxtext="����������ȣ��å" boxtexttwo="html_file/site_rule.html ����" simages="img/shot/038s.png" bimages="img/shot/038.png" bimgwidth="140" bimgheight="35" Xaxis="230" Yaxis="1893" gapspace="0" movemode="TC" keyway="top"/>

<List url="" target="_parent" boxtext="�̿���" boxtexttwo="html_file/site_rule2.html ����" simages="img/shot/039s.png" bimages="img/shot/039.png" bimgwidth="130" bimgheight="35" Xaxis="340" Yaxis="1893" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="��������" boxtexttwo="�Խ��ǰ����� �̵��մϴ�." simages="img/shot/040s.png" bimages="img/shot/040.png" bimgwidth="125" bimgheight="35" Xaxis="445" Yaxis="1893" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="Ŀ�´�Ƽ" boxtexttwo="�������� �Խ��ǰ����� �̵��մϴ�." simages="img/shot/041s.png" bimages="img/shot/041.png" bimgwidth="125" bimgheight="35" Xaxis="550" Yaxis="1893" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="���������Խ���" boxtexttwo="�Խ��ǰ����� �̵��մϴ�." simages="img/shot/042s.png" bimages="img/shot/042.png" bimgwidth="171" bimgheight="35" Xaxis="650" Yaxis="1893" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/main_logo_admin.php" target="_parent" boxtext="�ϴ�����" boxtexttwo="�������� �ΰ������� �̵��մϴ�." simages="img/shot/043s.png" bimages="img/shot/043.png" bimgwidth="950" bimgheight="94" Xaxis="20" Yaxis="1930" gapspace="0" movemode="BL" keyway="top"/>

</banner>

<!--
keycolor : ���� �ش��ϴ� Ű������ �⺻����
keycolortwo : ������ �ش��ϴ� Ű������ �⺻����
bgimg : ������� ���� ����Ʈ ��ü �̹����ּ�
-->
<speed keycolor="FF7202" keycolortwo="EEEEEE" bgimg="img/shot/shot04_800.png"/>
</xmlstart>
END;

?>