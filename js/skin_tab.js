
//메인상단탭
function tab_change(Img,ev)
{
	main_tabs = Array(
						'menumain_Atab1',
						'menumain_Atab2',
						'menumain_Atab3',
						'menumain_Atab4',
						'menumain_Atab5',
						'menumain_Atab6'
						);
	out_img = Array(
					'img/skin_icon/make_icon/skin_icon_620.jpg',
					'img/skin_icon/make_icon/skin_icon_622.jpg',
					'img/skin_icon/make_icon/skin_icon_624.jpg',
					'img/skin_icon/make_icon/skin_icon_626.jpg',
					'img/skin_icon/make_icon/skin_icon_628.jpg',
					'img/skin_icon/make_icon/skin_icon_630.jpg'
					);
	over_img = Array(
					'img/skin_icon/make_icon/skin_icon_621.jpg',
					'img/skin_icon/make_icon/skin_icon_623.jpg',
					'img/skin_icon/make_icon/skin_icon_625.jpg',
					'img/skin_icon/make_icon/skin_icon_627.jpg',
					'img/skin_icon/make_icon/skin_icon_629.jpg',
					'img/skin_icon/make_icon/skin_icon_631.jpg'

					);
	title_imgs = Array(
						'main_Atab1',
						'main_Atab2',
						'main_Atab3',
						'main_Atab4',
						'main_Atab5',
						'main_Atab6'
					);


	CurTab = 'menu'+Img.id;

	if ( ev == 'over' )
	{
		for ( i = 0; i<main_tabs.length ;i++ )
		{
			main_tab = document.getElementById(main_tabs[i]);
			TitleImgs = document.getElementById(title_imgs[i]);
			TitleImgs.src = out_img[i];

			if ( CurTab == main_tabs[i] )
			{
				main_tab.style.display = '';
				Img.src = over_img[i];
			}
			else
			{
				main_tab.style.display = 'none';
			}
		}
	}
}


//guin_list탭
function tab_change_sub01(Img,ev)
{
	main_tabs = Array(
						'menumain_Stab1',
						'menumain_Stab2'
						);
	out_img = Array(
					'img/skin_icon/make_icon/skin_icon_650.jpg',
					'img/skin_icon/make_icon/skin_icon_652.jpg'
					);
	over_img = Array(
					'img/skin_icon/make_icon/skin_icon_651.jpg',
					'img/skin_icon/make_icon/skin_icon_653.jpg'

					);
	title_imgs = Array(
						'main_Stab1',
						'main_Stab2'
					);


	CurTab = 'menu'+Img.id;

	if ( ev == 'over' )
	{
		for ( i = 0; i<main_tabs.length ;i++ )
		{
			main_tab = document.getElementById(main_tabs[i]);
			TitleImgs = document.getElementById(title_imgs[i]);
			TitleImgs.src = out_img[i];

			if ( CurTab == main_tabs[i] )
			{
				main_tab.style.display = '';
				Img.src = over_img[i];
			}
			else
			{
				main_tab.style.display = 'none';
			}
		}
	}
}


//guzic_list탭
function tab_change_sub02(Img,ev)
{
	main_tabs = Array(
						'menumain_Stab3',
						'menumain_Stab4'
						);
	out_img = Array(
					'img/skin_icon/make_icon/skin_icon_656.jpg',
					'img/skin_icon/make_icon/skin_icon_657.jpg'
					);
	over_img = Array(
					'img/skin_icon/make_icon/skin_icon_655.jpg',
					'img/skin_icon/make_icon/skin_icon_658.jpg'

					);
	title_imgs = Array(
						'main_Stab3',
						'main_Stab4'
					);


	CurTab = 'menu'+Img.id;

	if ( ev == 'over' )
	{
		for ( i = 0; i<main_tabs.length ;i++ )
		{
			main_tab = document.getElementById(main_tabs[i]);
			TitleImgs = document.getElementById(title_imgs[i]);
			TitleImgs.src = out_img[i];

			if ( CurTab == main_tabs[i] )
			{
				main_tab.style.display = '';
				Img.src = over_img[i];
			}
			else
			{
				main_tab.style.display = 'none';
			}
		}
	}
}











//메인 신규상품 텝소스
// getElementsByClassName
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

//메인메뉴 전체보기 텝소스
function change2_text(name1 , name2, name3, num, mode)
{
	//name1 = "room2_text_1"
	//name2 = "category1_on"
	//name3 = "category1_off"

	document.getElementById(name1).style.display = "none";
	document.getElementById(name1).style.display = "block";

	if ( mode == "off" )
	{
		document.getElementById(name2).style.display	= "block";
		document.getElementById(name3).style.display	= "none";
	}
	else
	{
		document.getElementById(name2).style.display	= "none";
		document.getElementById(name3).style.display	= "block";

		document.getElementById(name1).style.display = "none";
	}
}


//메인메뉴 전체보기 텝소스
function change3_text(name1 , name2, name3, num, mode)
{
	//name1 = "room2_text_1"
	//name2 = "category1_on"
	//name3 = "category1_off"

	document.getElementById(name1).style.display = "none";
	document.getElementById(name1).style.display = "";

	if ( mode == "off" )
	{
		document.getElementById(name2).style.display	= "";
		document.getElementById(name3).style.display	= "none";
	}
	else
	{
		document.getElementById(name2).style.display	= "none";
		document.getElementById(name3).style.display	= "";

		document.getElementById(name1).style.display = "none";
	}
}

 //sns연동에따른 로그인박스 전용 텝메뉴
var prevImg9  = new Array();
prevImg9[0]  = "login_img_1";


var prevLayer9 = new Array();
prevLayer9[0] = "login_layer_1";


function login_viewLayer(nowLayer9,no)
{
	document.getElementById(prevLayer9[no]).style.display = "none";
	document.getElementById(nowLayer9).style.display = "";
	prevLayer9[no] = nowLayer9;
}

function login_changeImg(nowImg9,no)
{
	if ( nowImg9 != prevImg9[no] )
	{
		prevImg9Src = document.getElementById(prevImg9[no]).src.replace("_on.gif",".gif");
		nowImg9Src = document.getElementById(nowImg9).src.replace("_off.gif",".gif");
		document.getElementById(prevImg9[no]).src = prevImg9Src.replace(".gif","_off.gif");
		document.getElementById(nowImg9).src = nowImg9Src.replace(".gif","_on.gif");

		prevImg9[no] = nowImg9;
	}
}



//서브카테고리탭
var prevImg6  = new Array();
prevImg6[0]  = "category_img_1";


var prevLayer6 = new Array();
prevLayer6[0] = "category_layer_1";


function category_viewLayer(nowLayer6,no)
{
	document.getElementById(prevLayer6[no]).style.display = "none";
	document.getElementById(nowLayer6).style.display = "";
	prevLayer6[no] = nowLayer6;
}

function category_changeImg(nowImg6,no)
{
	if ( nowImg6 != prevImg6[no] )
	{
		prevImg6Src = document.getElementById(prevImg6[no]).src.replace("_on.gif",".gif");
		nowImg6Src = document.getElementById(nowImg6).src.replace("_off.gif",".gif");
		document.getElementById(prevImg6[no]).src = prevImg6Src.replace(".gif","_off.gif");
		document.getElementById(nowImg6).src = nowImg6Src.replace(".gif","_on.gif");

		prevImg6[no] = nowImg6;
	}
}


//서브카테고리탭
var prevImg5  = new Array();
prevImg5[0]  = "new_img_1";


var prevLayer5 = new Array();
prevLayer5[0] = "new_layer_1";


function new_viewLayer(nowLayer5,no)
{
	document.getElementById(prevLayer5[no]).style.display = "none";
	document.getElementById(nowLayer5).style.display = "";
	prevLayer5[no] = nowLayer5;
}

function new_changeImg(nowImg5,no)
{
	if ( nowImg5 != prevImg5[no] )
	{
		prevImg5Src = document.getElementById(prevImg5[no]).src.replace("_on.gif",".gif");
		nowImg5Src = document.getElementById(nowImg5).src.replace("_off.gif",".gif");
		document.getElementById(prevImg5[no]).src = prevImg5Src.replace(".gif","_off.gif");
		document.getElementById(nowImg5).src = nowImg5Src.replace(".gif","_on.gif");

		prevImg5[no] = nowImg5;
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



// 탭메뉴 사용되는 카운트(카운트값과 텝 갯수가 동일하도록 처리하는것을 권장)
TabCount   = 6;
FirstViewNumArr  = new Array();
for ( i = 1; i <= TabCount; i++ )
{
 FirstViewNumArr['TabCount' + i] = 1;
}

function TabChange( idName, imgIdName, number, TabNumber )
{
 FirstViewNum  = FirstViewNumArr['TabCount' + TabNumber];

 Obj     = document.getElementById(idName + number);
 ImgObj    = document.getElementById(imgIdName + number);

 if ( FirstViewNum != '' )
 {
  document.getElementById(idName + FirstViewNum).style.display = 'none';
  document.getElementById(imgIdName + FirstViewNum).src   = 'img/' + imgIdName + FirstViewNum + '_off.gif';
 }

 Obj.style.display = '';
 ImgObj.src   = 'img/' + imgIdName + number + '_on.gif';

 if ( number != FirstViewNum )
 {
  FirstViewNumArr['TabCount' + TabNumber] = number;
 }
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

