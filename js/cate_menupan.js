
//카테고리 전체 메뉴판 (토글메뉴)
var countFirst = 0;
function toggleMenuView( ){
	var category_menu_button = document.getElementById("btn_menupan");
	var toggleBtn = document.getElementById("toggleBtn");
	var toggleBtnIE6 = document.getElementById("toggleBtnIE6");
	var category_menupan = document.getElementById("category_menupan");

	countFirst++;
	//alert(countFirst);

	if(countFirst % 2 == 1){
		category_menupan.style.display = "";
		toggleBtn.src = "img/catemenu/btn_memu_on.png";
		toggleBtnIE6.src = "img/catemenu/btn_memu_on.gif";
	}else{
		category_menupan.style.display = "none";
		toggleBtn.src = "img/catemenu/btn_memu_off.png";
		toggleBtnIE6.src = "img/catemenu/btn_memu_off.gif";
	}

}



function toggleMenuClose( ){
	count = 0;
	var toggleBtn = document.getElementById("toggleBtn");
	var toggleBtnIE6 = document.getElementById("toggleBtnIE6");
	var category_menupan = document.getElementById("category_menupan");

	category_menupan.style.display = "none";
	toggleBtn.src = "img/catemenu/btn_memu_off.png";

	countFirst = 0;
}



var FF = (document.layers) ? 1 : 0; // FF?
var IE = (document.all) ? 1 : 0; // 익스플로러?

function cntTableSize(){
	var menupanTable = document.getElementById("menupanTable");
	var category_menupanObj = document.getElementById("category_menupan");
	var btnClose = document.getElementById("btnClose");
	var cntTableHeight	= "";

	if(category_menupanObj.style.display == ""){
		cntTableHeight = menupanTable.clientHeight;
		btnClose.style.top = cntTableHeight - 45;
		//alert(cntTableHeight);
	}
}