<?

//서브주소용
include "../sub_url.php";






echo <<<END

<?xml version="1.0" encoding="euc-kr"?>
<xmlstart>

<!--
url : 링크주소
target : 링크타겟
boxtext : 제목에 해당하는 키워드(기본 HTML사용가능 단 <와 >는 &lt; 와 &gt; 로 사용)
boxtexttwo : 설명에 해당하는 키워드(기본 HTML사용가능 단 <와 >는 &lt; 와 &gt; 로 사용 줄내림은 || 을 사용)
simages : 작은이미지의 주소
bimages : 큰이미지의 주소
bimgwidth : 큰이미지의 너비
bimgheight : 큰이미지의 높이
Xaxis : 작은이미지 X축 위치
Yaxis : 작은이미지 Y축 위치
gapspace : 이미지가 커질대 좌측 상단의 여백을 줄 수 있습니다.(여백은 T일경우나 L일경우 사용하면 이상하게 보일 수 있습니다.)
======================================================================
movemode : 확대가 될때 어느위치로 확대가 될지를 정할 수 있습니다.
예) TL -> T(top상단)L(left좌측)

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
형태를 사용할 수 있습니다.
앞쪽이 위아래 뒷쪽이 좌우 설정이며 대문자여야 합니다.
======================================================================
keyway : 키워드의 출력위치를 정합니다.
top : 상단
bottom: 하단
-->

<banner>



<List url="$sub_url/admin/happy_config_view.php?number=17" target="_parent" boxtext="성인인증" boxtexttwo="실명인증 및 성인인증 설정으로 이동합니다." simages="img/shot/087s.png" bimages="img/shot/087.png" bimgwidth="365" bimgheight="215" Xaxis="400" Yaxis="265" gapspace="0" movemode="TR" keyway="top"/>



</banner>

<!--
keycolor : 제목에 해당하는 키워드의 기본색상
keycolortwo : 설명에 해당하는 키워드의 기본색상
bgimg : 배경으로 들어가는 사이트 전체 이미지주소
-->
<speed keycolor="FF7202" keycolortwo="EEEEEE" bgimg="img/shot/shot06_800.png"/>
</xmlstart>
END;

?>