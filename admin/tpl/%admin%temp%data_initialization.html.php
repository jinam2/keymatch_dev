<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 09:59:26 */
function SkyTpl_Func_1338316684 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<p class="main_title">자료초기화</p>

<link rel="stylesheet" type="text/css" href="./css/jquery.captcha.css" />
<script type="text/javascript" language="javascript" src="../../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" language="javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.captcha.js"></script>
<style type="text/css" media="screen">
    body { background-color: white; }
</style>


<script type="text/javascript" charset="euc-kr">
    $(function() {
        $(".ajax-fc-container").captcha({
            howmany:7,
            imageDir: "img/captcha",
            url: "captcha.php",
            formId: "myForm",
            text: "현재페이지는 자료를 <font color=red>초기화</font> 할 수 있는 페이지입니다. <br>계속 진행하시려면 <span></span>을(를) 드래그해서 동그라미 안으로 올려놓으십시오.",
            items: Array(
                {key:"bird", text:"새"},
                {key:"calendar", text:"달력"},
                {key:"cd", text:"CD"},
                {key:"film", text:"필름"},
                {key:"heart", text:"하트"},
                {key:"home", text:"집"},
                {key:"key", text:"열쇠"},
                {key:"mobile", text:"휴대폰"},
                {key:"music", text:"음표"},
                {key:"pencil", text:"연필"},
                {key:"people", text:"사람"},
                {key:"photo", text:"사진"},
                {key:"barchart", text:"막대그래프"},
                {key:"piechart", text:"원그래프"},
                {key:"printer", text:"프린터"},
                {key:"spanner", text:"스패너"},
                {key:"star", text:"별"},
                {key:"tag", text:"태그"},
                {key:"egg", text:"계란후라이"}
            ),
            callback:function(param){
                alert("설정페이지로 이동합니다");
				location.replace('data_initialization.php?mode=conf');
            }
        });
    });
</script>



<table width="100%" cellspacing='0' cellpadding='0' border="0">
<tr>
	<td align="center">

		<!-- Begin of captcha -->
		<div class="ajax-fc-container" style="text-align:left;">잠시만 기다려 주세요!</div>
		<!-- End of captcha -->

		<!-- Just an example of your form -->
		<!--
<form action="./captcha.php" method="post" id="myForm">
	<p><input type="text" name="myField1" value=""></p>
	<p><input type="text" name="myField2" value=""></p>
	<p><input type="submit" name="submit" value="Do something!"></p>
</form>
-->
		<!-- End of form example -->

		<!--div id="debug"></div-->

		<table width='100%' cellspacing='0' cellpadding='0' border='0' style="border:0px solid red;">
		<tr>
			<td align="center">
				<table width='100%' cellspacing='0' cellpadding='0' border='0'>
				<tr>
					<td style="padding-left:20px;">
						<div style="margin:60px 0 0 0px; text-align:left;">
							<font style='font-size:12px; color:red;'>※ 한 번 삭제가 되면 자료복구가 불가능하므로 초기화를 하시기 전 신중히 판단하셔야 합니다. </font>
							<div style="padding-top:5px; margin:0px 0 0 15px;">

								자료초기화는 솔루션 최초 구매시에 사용하시길 권장하며,
								<br>사이트가 운영중에 초기화 하길 원하신다면 DB와 파일은 반드시 백업해 놓으시기 바랍니다.
							</div>
						</div>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>


	</td>
</tr>
</table>

<? }
?>