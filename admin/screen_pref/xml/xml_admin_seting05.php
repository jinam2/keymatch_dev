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


<!-- 상단 -->
<List url="" target="_parent" boxtext="구글날씨" boxtexttwo="구글날씨 지역정보를 보여줍니다.(자체설정)" simages="img/shot/001s.png" bimages="img/shot/001.png" bimgwidth="110" bimgheight="30" Xaxis="220" Yaxis="0" gapspace="0" movemode="TC" keyway="bottom"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="구인정보(티커형)" boxtexttwo="채용정보관리로 이동합니다." simages="img/shot/002s.png" bimages="img/shot/002.png" bimgwidth="342" bimgheight="30" Xaxis="310" Yaxis="0" gapspace="0" movemode="TC" keyway="bottom"/>

<List url="" target="_parent" boxtext="회원로그인 정보상황" boxtexttwo="temp/logout_button(logon_button).html" simages="img/shot/003s.png" bimages="img/shot/003.png" bimgwidth="135" bimgheight="30" Xaxis="605" Yaxis="0" gapspace="0" movemode="TR" keyway="bottom"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="고객센터" boxtexttwo="게시판관리 이동" simages="img/shot/004s.png" bimages="img/shot/004.png" bimgwidth="65" bimgheight="30" Xaxis="720" Yaxis="0" gapspace="0" movemode="TR" keyway="bottom"/>

<List url="$sub_url/admin/main_logo_admin.php" target="_parent" boxtext="로고수정" boxtexttwo="로고관리로 이동합니다." simages="img/shot/005s.png" bimages="img/shot/005.png" bimgwidth="399" bimgheight="50" Xaxis="20" Yaxis="40" gapspace="0" movemode="TL" keyway="bottom"/>

<List url="$sub_url/admin/banner_admin.php" target="_parent" boxtext="배너광고" boxtexttwo="배너관리로 이동합니다." simages="img/shot/006s.png" bimages="img/shot/006.png" bimgwidth="171" bimgheight="50" Xaxis="630" Yaxis="40" gapspace="0" movemode="TR" keyway="bottom"/>

<List url="$sub_url/admin/happy_icon_admin.php?type=add&group=&number=256&start=180&search_order=&keyword=" target="_parent" boxtext="등록이미지(데모기준)" boxtexttwo="템플릿이미지 및 색상관리로 이동합니다." simages="img/shot/044s.png" bimages="img/shot/044.png" bimgwidth="169" bimgheight="50" Xaxis="20" Yaxis="90" gapspace="0" movemode="TL" keyway="bottom"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="채용정보(지역,역세권)" boxtexttwo="채용정보관리로 이동합니다." simages="img/shot/007s.png" bimages="img/shot/007.png" bimgwidth="169" bimgheight="45" Xaxis="20" Yaxis="140" gapspace="0" movemode="TL" keyway="bottom"/>

<List url="$sub_url/admin/happy_config_view.php?number=16" target="_parent" boxtext="추천키워드" boxtexttwo="추천키워드 단어 설정으로 이동합니다." simages="img/shot/008s.png" bimages="img/shot/008.png" bimgwidth="550" bimgheight="30" Xaxis="180" Yaxis="100" gapspace="0" movemode="MC" keyway="bottom"/>

<List url="" target="_parent" boxtext="플래시메뉴" boxtexttwo="xml/xml_menu.php 파일에서 관리됩니다.." simages="img/shot/009s.png" bimages="img/shot/009.png" bimgwidth="550" bimgheight="34" Xaxis="180" Yaxis="130" gapspace="0" movemode="MC" keyway="bottom"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="채용정보등록" boxtexttwo="관련정보 채용정보관리로 이동합니다." simages="img/shot/010s.png" bimages="img/shot/010.png" bimgwidth="160" bimgheight="50" Xaxis="640" Yaxis="90" gapspace="0" movemode="TR" keyway="bottom"/>

<List url="$sub_url/admin/guin.php?a=guzic&mode=list" target="_parent" boxtext="이력서등록" boxtexttwo="관련정보 이력서관리로 이동합니다." simages="img/shot/011s.png" bimages="img/shot/011.png" bimgwidth="160" bimgheight="50" Xaxis="640" Yaxis="140" gapspace="0" movemode="TR" keyway="bottom"/>







<!-- 좌측 -->
<List url="" target="_parent" boxtext="카테고리메뉴" boxtexttwo="temp/default_guin.html 파일내용에 포함" simages="img/shot/045s.png" bimages="img/shot/045.png" bimgwidth="180" bimgheight="652" Xaxis="20" Yaxis="200" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/happy_icon_admin.php" target="_parent" boxtext="플래시지도" boxtexttwo="색상변경관련 템플릿이미지 및 색상관리로 이동합니다." simages="img/shot/046s.png" bimages="img/shot/046.png" bimgwidth="180" bimgheight="279" Xaxis="20" Yaxis="727" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/best_keyword.php" target="_parent" boxtext="구름태그" boxtexttwo="관련정보 실시간인기검색어로 이동합니다." simages="img/shot/047s.png" bimages="img/shot/047.png" bimgwidth="180" bimgheight="164" Xaxis="20" Yaxis="955" gapspace="0" movemode="TL" keyway="top"/>

<List url="" target="_parent" boxtext="입금계좌안내" boxtexttwo="img/table_siteinbank.gif 파일입니다." simages="img/shot/048s.png" bimages="img/shot/048.png" bimgwidth="180" bimgheight="174" Xaxis="20" Yaxis="1090" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="공지사항" boxtexttwo="게시판관리로 이동합니다." simages="img/shot/049s.png" bimages="img/shot/049.png" bimgwidth="180" bimgheight="124" Xaxis="20" Yaxis="1235" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/banner_admin.php" target="_parent" boxtext="배너광고" boxtexttwo="배너관리로 이동합니다." simages="img/shot/050s.png" bimages="img/shot/050.png" bimgwidth="180" bimgheight="76" Xaxis="20" Yaxis="1340" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/happy_config_view.php?number=24" target="_parent" boxtext="구글광고" boxtexttwo="외부광고관리로 이동합니다." simages="img/shot/051s.png" bimages="img/shot/051.png" bimgwidth="180" bimgheight="148" Xaxis="20" Yaxis="1410" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/banner_admin.php" target="_parent" boxtext="배너광고" boxtexttwo="배너관리로 이동합니다." simages="img/shot/052s.png" bimages="img/shot/052.png" bimgwidth="180" bimgheight="76" Xaxis="20" Yaxis="1540" gapspace="0" movemode="TL" keyway="top"/>





<!-- 우측 -->
<List url="$sub_url/admin/admin.php?a=com&mode=list" target="_parent" boxtext="업소회원정보" boxtexttwo="업소회원관리로 이동합니다." simages="img/shot/076s.png" bimages="img/shot/076.png" bimgwidth="645" bimgheight="453" Xaxis="170" Yaxis="235" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/admin.php?area=mod" target="_parent" boxtext="기본정보" boxtexttwo="관련설정 채용/이력서설정으로 이동합니다. " simages="img/shot/077s.png" bimages="img/shot/077.png" bimgwidth="645" bimgheight="340" Xaxis="170" Yaxis="600" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="자격요건" boxtexttwo="채용정보등록시 설정합니다. " simages="img/shot/078s.png" bimages="img/shot/078.png" bimgwidth="645" bimgheight="186" Xaxis="170" Yaxis="875" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="상세요강" boxtexttwo="채용정보등록시 설정합니다. " simages="img/shot/079s.png" bimages="img/shot/079.png" bimgwidth="645" bimgheight="200" Xaxis="170" Yaxis="1030" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/admin.php?area=mod" target="_parent" boxtext="복리후생" boxtexttwo="관련설정 채용/이력서설정으로 이동합니다. " simages="img/shot/080s.png" bimages="img/shot/080.png" bimgwidth="645" bimgheight="134" Xaxis="170" Yaxis="1190" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/area_setting.php" target="_parent" boxtext="근무지역" boxtexttwo="지역설정으로 이동합니다." simages="img/shot/081s.png" bimages="img/shot/081.png" bimgwidth="645" bimgheight="134" Xaxis="170" Yaxis="1295" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="관련이미지" boxtexttwo="채용정보등록시 설정합니다. " simages="img/shot/082s.png" bimages="img/shot/082.png" bimgwidth="645" bimgheight="127" Xaxis="170" Yaxis="1400" gapspace="0" movemode="TR" keyway="top"/>

<List url="" target="_parent" boxtext="문자발송" boxtexttwo="temp/guin_detail_sms.html 파일입니다." simages="img/shot/083s.png" bimages="img/shot/083.png" bimgwidth="645" bimgheight="172" Xaxis="170" Yaxis="1510" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="접수방법" boxtexttwo="채용정보등록시 설정합니다. " simages="img/shot/084s.png" bimages="img/shot/084.png" bimgwidth="645" bimgheight="112" Xaxis="170" Yaxis="1655" gapspace="0" movemode="TR" keyway="top"/>




<!-- 맨우측  -->
<List url="$sub_url/admin/banner_admin.php" target="_parent" boxtext="배너광고" boxtexttwo="통합배너관리 이동" simages="img/shot/085s.png" bimages="img/shot/085.png" bimgwidth="110" bimgheight="300" Xaxis="690" Yaxis="235" gapspace="0" movemode="TR" keyway="top"/>








<!-- 하단 -->
<List url="" target="_parent" boxtext="회사소개" boxtexttwo="html_file/site_compnay.html 파일" simages="img/shot/036s.png" bimages="img/shot/036.png" bimgwidth="139" bimgheight="35" Xaxis="20" Yaxis="1752" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/bbs_regist.php?id=&b_category=&tb=board_bannerreg" target="_parent" boxtext="광고문의" boxtexttwo="게시판관련 부분입니다." simages="img/shot/037s.png" bimages="img/shot/037.png" bimgwidth="120" bimgheight="35" Xaxis="130" Yaxis="1752" gapspace="0" movemode="TC" keyway="top"/>

<List url="" target="_parent" boxtext="개인정보보호정책" boxtexttwo="html_file/site_rule.html 파일" simages="img/shot/038s.png" bimages="img/shot/038.png" bimgwidth="140" bimgheight="35" Xaxis="230" Yaxis="1752" gapspace="0" movemode="TC" keyway="top"/>

<List url="" target="_parent" boxtext="이용약관" boxtexttwo="html_file/site_rule2.html 파일" simages="img/shot/039s.png" bimages="img/shot/039.png" bimgwidth="130" bimgheight="35" Xaxis="340" Yaxis="1752" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="공지사항" boxtexttwo="게시판관리로 이동합니다." simages="img/shot/040s.png" bimages="img/shot/040.png" bimgwidth="125" bimgheight="35" Xaxis="445" Yaxis="1752" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="커뮤니티" boxtexttwo="관련정보 게시판관리로 이동합니다." simages="img/shot/041s.png" bimages="img/shot/041.png" bimgwidth="125" bimgheight="35" Xaxis="550" Yaxis="1752" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="고객지원게시판" boxtexttwo="게시판관리로 이동합니다." simages="img/shot/042s.png" bimages="img/shot/042.png" bimgwidth="171" bimgheight="35" Xaxis="650" Yaxis="1752" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/main_logo_admin.php" target="_parent" boxtext="하단정보" boxtexttwo="관련정보 로고관리로 이동합니다." simages="img/shot/043s.png" bimages="img/shot/043.png" bimgwidth="950" bimgheight="94" Xaxis="20" Yaxis="1788" gapspace="0" movemode="BL" keyway="top"/>

</banner>

<!--
keycolor : 제목에 해당하는 키워드의 기본색상
keycolortwo : 설명에 해당하는 키워드의 기본색상
bgimg : 배경으로 들어가는 사이트 전체 이미지주소
-->
<speed keycolor="FF7202" keycolortwo="EEEEEE" bgimg="img/shot/shot05_800.png"/>
</xmlstart>
END;

?>