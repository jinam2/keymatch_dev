//검색레이어
var category_layer_count = 0;
function Category_Layer()
{
	if (category_layer_count > 0)
	{
		category_layer_count--;
		document.getElementById('category_layer').style.display = 'none';
	}
	else
	{
		category_layer_count++;
		document.getElementById('category_layer').style.display = '';
	}
}

//전체보기레이어
var date_layer_count = 0;
function Date_Layer()
{
	if (date_layer_count > 0)
	{
		date_layer_count--;
		document.getElementById('date_layer').style.display = 'none';
	}
	else
	{
		date_layer_count++;
		document.getElementById('date_layer').style.display = '';
	}
}


function show_leemocon(size){ //show_leemocon를 선언
  var d1 = document.getElementById("size1"); // 탭1
  var d2 = document.getElementById("size2"); // 탭2
  d1.style.display = "none";
  d2.style.display = "none";

  switch(size){
   case 1:
    d1.style.display = "";
    break;
   case 2:
    d2.style.display = "";
    break;
  }
}

//메인메뉴에 관련된 텝메뉴
var prevLayer = new Array();
prevLayer[0] = "layer_1";

var prevImg  = new Array();
prevImg[0]  = "layerTab_1";


function viewLayer(nowLayer,no)
{
	document.getElementById(prevLayer[no]).style.display = "none";
	document.getElementById(nowLayer).style.display = "";

	prevLayer[no] = nowLayer;

	//tab1();
}


//우대등록리스트 레이어 자바스트립트
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


//상세검색 레이어 자바스트립트
function change20_text(name10 , name20, name30, num, mode)
{
	//name10 = "room20_text_10"
	//name20 = "category10_on"
	//name30 = "category10_off"

	document.getElementById(name10).style.display = "none";
	document.getElementById(name10).style.display = "block";

	if ( mode == "off" )
	{
		document.getElementById(name20).style.display	= "block";
		document.getElementById(name30).style.display	= "none";
	}
	else
	{
		document.getElementById(name20).style.display	= "none";
		document.getElementById(name30).style.display	= "block";

		document.getElementById(name10).style.display = "none";
	}
}
