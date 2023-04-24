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



<!-- 메인본문 -->
<List url="" target="_parent" boxtext="회원로그인" boxtexttwo="logon_per(logoff,logon_com).html 관련파일" simages="img/shot/012s.png" bimages="img/shot/012.png" bimgwidth="185" bimgheight="126" Xaxis="20" Yaxis="190" gapspace="0" movemode="TL" keyway="bottom"/>

<List url="$sub_url/admin/banner_admin.php" target="_parent" boxtext="배너광고" boxtexttwo="배너관리로 이동합니다." simages="img/shot/013s.png" bimages="img/shot/013.png" bimgwidth="185" bimgheight="104" Xaxis="20" Yaxis="295" gapspace="0" movemode="TL" keyway="bottom"/>

<List url="$sub_url/admin/main_banner.php" target="_parent" boxtext="플래시배너" boxtexttwo="플래시배너로 이동합니다." simages="img/shot/014s.png" bimages="img/shot/014.png" bimgwidth="550" bimgheight="222" Xaxis="180" Yaxis="200" gapspace="0" movemode="MC" keyway="bottom"/>

<List url="$sub_url/admin/best_keyword.php" target="_parent" boxtext="플래시실시간 인기검색어" boxtexttwo="플래시배너로 이동합니다." simages="img/shot/015s.png" bimages="img/shot/015.png" bimgwidth="186" bimgheight="222" Xaxis="630" Yaxis="200" gapspace="0" movemode="TR" keyway="bottom"/>



<!-- 본문 1 -->
<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="우대등록 채용정보" boxtexttwo="채용정보관리로 이동합니다." simages="img/shot/016s.png" bimages="img/shot/016.png" bimgwidth="950" bimgheight="407" Xaxis="20" Yaxis="380" gapspace="0" movemode="TL" keyway="top"/>


<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="프리미엄 채용정보" boxtexttwo="채용정보관리로 이동합니다." simages="img/shot/017s.png" bimages="img/shot/017.png" bimgwidth="950" bimgheight="185" Xaxis="20" Yaxis="710" gapspace="0" movemode="TL" keyway="top"/>


<!-- 본문 2 좌측 -->
<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="급구채용정보" boxtexttwo="채용정보관리로 이동합니다." simages="img/shot/018s.png" bimages="img/shot/018.png" bimgwidth="204" bimgheight="125" Xaxis="20" Yaxis="870" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/happy_icon_admin.php" target="_parent" boxtext="플래시지도" boxtexttwo="색상변경관련 템플릿이미지 및 색상관리로 이동합니다. " simages="img/shot/019s.png" bimages="img/shot/019.png" bimgwidth="204" bimgheight="310" Xaxis="20" Yaxis="970" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/best_keyword.php" target="_parent" boxtext="구름태그" boxtexttwo="관련정보 실시간인기검색어로 이동합니다. " simages="img/shot/020s.png" bimages="img/shot/020.png" bimgwidth="204" bimgheight="170" Xaxis="20" Yaxis="1225" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/poll_admin.php" target="_parent" boxtext="설문조사" boxtexttwo="투표관리로 이동합니다." simages="img/shot/021s.png" bimages="img/shot/021.png" bimgwidth="204" bimgheight="265" Xaxis="20" Yaxis="1365" gapspace="0" movemode="TL" keyway="top"/>

<List url="" target="_parent" boxtext="입금계좌안내" boxtexttwo="img/table_siteinbank.gif 파일입니다." simages="img/shot/022s.png" bimages="img/shot/022.png" bimgwidth="204" bimgheight="175" Xaxis="20" Yaxis="1580" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="공지사항" boxtexttwo="게시판관리로 이동합니다." simages="img/shot/023s.png" bimages="img/shot/023.png" bimgwidth="204" bimgheight="126" Xaxis="20" Yaxis="1730" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="고객지원" boxtexttwo="img/table_customer2.gif 파일입니다." simages="img/shot/024s.png" bimages="img/shot/024.png" bimgwidth="204" bimgheight="184" Xaxis="20" Yaxis="1830" gapspace="0" movemode="TL" keyway="top"/>




<!-- 본문2 우측 -->
<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="추천채용정보" boxtexttwo="채용정보관리로 이동합니다." simages="img/shot/025s.png" bimages="img/shot/025.png" bimgwidth="736" bimgheight="170" Xaxis="190" Yaxis="870" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="스페셜채용정보" boxtexttwo="채용정보관리로 이동합니다." simages="img/shot/026s.png" bimages="img/shot/026.png" bimgwidth="736" bimgheight="135" Xaxis="190" Yaxis="1015" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guzic&mode=list" target="_parent" boxtext="파워링크인재정보" boxtexttwo="이력서관리로 이동합니다." simages="img/shot/027s.png" bimages="img/shot/027.png" bimgwidth="736" bimgheight="270" Xaxis="190" Yaxis="1125" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guzic&mode=list" target="_parent" boxtext="인재정보(포커스/스페셜)" boxtexttwo="이력서관리로 이동합니다." simages="img/shot/028s.png" bimages="img/shot/028.png" bimgwidth="736" bimgheight="150" Xaxis="190" Yaxis="1365" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="최근채용정보" boxtexttwo="채용정보관리로 이동합니다." simages="img/shot/029s.png" bimages="img/shot/029.png" bimgwidth="366" bimgheight="175" Xaxis="190" Yaxis="1495" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guzic&mode=list" target="_parent" boxtext="최근인재정보" boxtexttwo="이력서관리 이동합니다." simages="img/shot/030s.png" bimages="img/shot/030.png" bimgwidth="366" bimgheight="175" Xaxis="490" Yaxis="1495" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guin&mode=list" target="_parent" boxtext="알바채용정보" boxtexttwo="채용정보관리로 이동합니다." simages="img/shot/031s.png" bimages="img/shot/031.png" bimgwidth="366" bimgheight="165" Xaxis="190" Yaxis="1640" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/guin.php?a=guzic&mode=list" target="_parent" boxtext="알바구직정보" boxtexttwo="이력서관리로 이동합니다." simages="img/shot/032s.png" bimages="img/shot/032.png" bimgwidth="366" bimgheight="165" Xaxis="490" Yaxis="1640" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="구인구직뉴스" boxtexttwo="게시판관리로 이동합니다." simages="img/shot/033s.png" bimages="img/shot/033.png" bimgwidth="366" bimgheight="135" Xaxis="190" Yaxis="1770" gapspace="0" movemode="TL" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="구인구직정보" boxtexttwo="게시판관리로 이동합니다." simages="img/shot/034s.png" bimages="img/shot/034.png" bimgwidth="366" bimgheight="135" Xaxis="490" Yaxis="1770" gapspace="0" movemode="TR" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="포토갤러리" boxtexttwo="게시판관리로 이동합니다." simages="img/shot/035s.png" bimages="img/shot/035.png" bimgwidth="736" bimgheight="165" Xaxis="190" Yaxis="1870" gapspace="0" movemode="TL" keyway="top"/>




<!-- 하단 -->
<List url="" target="_parent" boxtext="회사소개" boxtexttwo="html_file/site_compnay.html 파일" simages="img/shot/036s.png" bimages="img/shot/036.png" bimgwidth="139" bimgheight="35" Xaxis="20" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/bbs_regist.php?id=&b_category=&tb=board_bannerreg" target="_parent" boxtext="광고문의" boxtexttwo="게시판관련 부분입니다." simages="img/shot/037s.png" bimages="img/shot/037.png" bimgwidth="120" bimgheight="35" Xaxis="130" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="" target="_parent" boxtext="개인정보보호정책" boxtexttwo="html_file/site_rule.html 파일" simages="img/shot/038s.png" bimages="img/shot/038.png" bimgwidth="140" bimgheight="35" Xaxis="230" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="" target="_parent" boxtext="이용약관" boxtexttwo="html_file/site_rule2.html 파일" simages="img/shot/039s.png" bimages="img/shot/039.png" bimgwidth="130" bimgheight="35" Xaxis="340" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="공지사항" boxtexttwo="게시판관리로 이동합니다." simages="img/shot/040s.png" bimages="img/shot/040.png" bimgwidth="125" bimgheight="35" Xaxis="445" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="커뮤니티" boxtexttwo="관련정보 게시판관리로 이동합니다." simages="img/shot/041s.png" bimages="img/shot/041.png" bimgwidth="125" bimgheight="35" Xaxis="550" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/bbs.php?mode=list" target="_parent" boxtext="고객지원게시판" boxtexttwo="게시판관리로 이동합니다." simages="img/shot/042s.png" bimages="img/shot/042.png" bimgwidth="171" bimgheight="35" Xaxis="650" Yaxis="2022" gapspace="0" movemode="TC" keyway="top"/>

<List url="$sub_url/admin/main_logo_admin.php" target="_parent" boxtext="하단정보" boxtexttwo="관련정보 로고관리로 이동합니다." simages="img/shot/043s.png" bimages="img/shot/043.png" bimgwidth="950" bimgheight="94" Xaxis="20" Yaxis="2055" gapspace="0" movemode="BL" keyway="top"/>

</banner>

<!--
keycolor : 제목에 해당하는 키워드의 기본색상
keycolortwo : 설명에 해당하는 키워드의 기본색상
bgimg : 배경으로 들어가는 사이트 전체 이미지주소
-->
<speed keycolor="FF7202" keycolortwo="EEEEEE" bgimg="img/shot/shot01_800.png"/>
</xmlstart>
END;

?>