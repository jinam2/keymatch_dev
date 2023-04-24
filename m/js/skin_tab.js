function tabDisplay(tab,content,num,chk,over,type)
{
	for (var i=0; i<content.length; i++)
	{
		tab[i].className = '';
		tab[num].className = chk;
		content[i].style.display = 'none';
		content[num].style.display = 'block';
	}

	//초기화
	Default_Arr = new Array('guin_pay','guin_pay2','guin_pay_type','grade_money','grade_money2','grade_money_type');
	for ( i = 0; i < Default_Arr.length; i++ )
	{
		if ( document.getElementsByName(Default_Arr[i])[0] != undefined && type != true )
		{
			document.getElementsByName(Default_Arr[i])[0].value = '';
		}
	}
}

function tabAct(tab,content,num,chk,over,type)
{
	tab[num].onclick = function()
	{
		tabDisplay(tab,content,num,chk);
		return false;
	}

	if (type == true)
	{
		tab[num].onmouseover = function()
		{
			if (this.className != chk)
			{
				this.className = over;
			}
		}

		tab[num].onmouseout = function()
		{
			if (this.className == over)
			{
				this.className = '';
			}
		}
	}
}

function tabMenu(guin_pay_type) {
	var tabs = document.getElementById('tabmenu');
	var tab = tabs.getElementsByTagName('a'); // 탭 요소
	var contents = document.getElementById('tabcontents');
	var content = getElementsByClassName('tabcontent',contents); // 컨텐츠 요소 class

	var chk = 'selected'; // 선택된 탭의 class
	var over = 'over'; // 롤오버된 탭의 class
	var type = true; // 롤오버의 true / false

	dis_num = guin_pay_type == '' ? 0 : 1;

	for (var i=0; i<tab.length; i++)
	{
		tabDisplay(tab,content,dis_num,chk,over,true);
		tabAct(tab,content,i,chk,over,type);
	}
}

function getElementsByClassName(chkName,parentNode)
{
	var arr = new Array();
	if (parentNode == null)
	{
		var elems = document.getElementsByTagName("*");
	}
	else
	{
		var elems = parentNode.getElementsByTagName("*");
	}

	for ( var chk, i = 0; ( elem = elems[i] ); i++ )
	{
		if ( elem.className == chkName )
		{
			arr[arr.length] = elem;
		}
	}

	return arr;
}


//채용정보 등록페이지 : 외국어능력 시험정보 팝업창 보이기/감추기
var flangNum = 0;
function foreignLangInfo(state){
	var foreign_lang_help = document.getElementById("foreign_lang_help");
	flangNum++;

	if(state == 'view'){
		if(flangNum % 2 == 1) {
			foreign_lang_help.style.display = "block";
		}else{
			foreign_lang_help.style.display = "none";
		}
	}else if (state == 'close'){
		foreign_lang_help.style.display = "none";
		flangNum = 0;
	}
}




//채용정보
var prevImg7  = new Array();
prevImg7[0]  = "guin_img_1";


var prevLayer7 = new Array();
prevLayer7[0] = "guin_layer_1";

function guin_viewLayer(nowLayer7,no)
{
	document.getElementById(prevLayer7[no]).style.display = "none";
	document.getElementById(nowLayer7).style.display = "";
	prevLayer7[no] = nowLayer7;
}

function guin_changeImg(nowImg7,no)
{
	if ( nowImg7 != prevImg7[no] )
	{
		prevImg7Src = document.getElementById(prevImg7[no]).src.replace("_on.gif",".gif");
		nowImg7Src = document.getElementById(nowImg7).src.replace("_off.gif",".gif");
		document.getElementById(prevImg7[no]).src = prevImg7Src.replace(".gif","_off.gif");
		document.getElementById(nowImg7).src = nowImg7Src.replace(".gif","_on.gif");

		prevImg7[no] = nowImg7;
	}
}





//이력서
var prevImg4  = new Array();
prevImg4[0]  = "guzic_img_1";


var prevLayer4 = new Array();
prevLayer4[0] = "guzic_layer_1";


function guzic_viewLayer(nowLayer4,no)
{
	document.getElementById(prevLayer4[no]).style.display = "none";
	document.getElementById(nowLayer4).style.display = "";
	prevLayer4[no] = nowLayer4;
}

function guzic_changeImg(nowImg4,no)
{
	if ( nowImg4 != prevImg4[no] )
	{
		prevImg4Src = document.getElementById(prevImg4[no]).src.replace("_on.gif",".gif");
		nowImg4Src = document.getElementById(nowImg4).src.replace("_off.gif",".gif");
		document.getElementById(prevImg4[no]).src = prevImg4Src.replace(".gif","_off.gif");
		document.getElementById(nowImg4).src = nowImg4Src.replace(".gif","_on.gif");

		prevImg4[no] = nowImg4;
	}
}