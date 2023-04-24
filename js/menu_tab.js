 //메인메뉴에 관련된 텝메뉴
 var prevLayer = new Array();
 prevLayer[0] = "layer_1";
 prevLayer[1] = "layer_3";
 prevLayer[2] = "layer_6";
 prevLayer[3] = "layer_9";
 prevLayer[4] = "layer_11";

 var prevImg  = new Array();
 prevImg[0]  = "img_1";
 prevImg[1]  = "img_3";
 prevImg[2]  = "img_6";
 prevImg[3]  = "img_9";
 prevImg[4]  = "img_11";
 
function viewLayer(nowLayer,no)
{
	document.getElementById(prevLayer[no]).style.display = "none";
	document.getElementById(nowLayer).style.display = "";
	prevLayer[no] = nowLayer;
}

function changeImg(nowImg,no)
{
	if ( nowImg != prevImg[no] )
	{
		prevImgSrc = document.getElementById(prevImg[no]).src.replace("_on.gif",".gif");
		nowImgSrc = document.getElementById(nowImg).src.replace("_off.gif",".gif");
		document.getElementById(prevImg[no]).src = prevImgSrc.replace(".gif","_off.gif");
		document.getElementById(nowImg).src = nowImgSrc.replace(".gif","_on.gif");

		prevImg[no] = nowImg;
	}
}


 //sns연동에따른 로그인박스 전용 텝메뉴 
var prevImg4  = new Array();
prevImg4[0]  = "login_img_1";


var prevLayer4 = new Array();
prevLayer4[0] = "login_layer_1";


function login_viewLayer(nowLayer4,no)
{
	document.getElementById(prevLayer4[no]).style.display = "none";
	document.getElementById(nowLayer4).style.display = "";
	prevLayer4[no] = nowLayer4;
}

function login_changeImg(nowImg4,no)
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