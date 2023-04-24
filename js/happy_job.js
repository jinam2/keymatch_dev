	var html,total_area=0,wait_flag=true;
	var bMouseOver = 1;
	var scrollspeed =2;
	var scrollerheight=20;
	var waitingtime = 3000;
	var scroll_content = new Array();
	
	function startscroll(msg){
		scroll_content = msg.split("--");
		for(i in scroll_content)insert_area(total_area++); 
		window.setTimeout("scrolling()",waitingtime);
	}
	function scrolling(){
		if( bMouseOver && wait_flag ){ 
			for( i=0; i<total_area; i++){
				tmp = document.getElementById('scroll_area'+i).style;
				tmp.top = parseInt(tmp.top) - scrollspeed;
				if(parseInt(tmp.top) <= -scrollerheight){
					tmp.top = scrollerheight * (total_area-1);
					wait_flag = false;
					window.setTimeout("wait_flag=true;",waitingtime);
				}
			}
		}
		window.setTimeout("scrolling()",1);
		
	}
	function insert_area(n){
		html='<div style="font-size:11px;left: 0px; width: 100%; position: absolute; top: '+(scrollerheight*n)+'px" id="scroll_area'+n+'">';
			html+=scroll_content[n]+'';
			html+='</div>';
			document.write(html);
	}



// 우편번호 팝업창 : 이력서등록페이지
happyMemberSrc	= '';
function happy_member_post_finder( post, addr1, addr2 )
{
	//alert(post +" "+ addr);

	window.open(happyMemberSrc+"happy_zipcode.php?post="+post+"&addr1="+addr1+"&addr2="+addr2,"happy_zipcode","width=400,height=300,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes");
}








var bNetscape4plus = (navigator.appName == "Netscape" && navigator.appVersion.substring(0,1) >= "4"); 
var bExplorer4plus = (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.substring(0,1) >= "4"); 
function CheckUIElements(){ 
        var yMenuFrom, yMenuTo, yButtonFrom, yButtonTo, yOffset, timeoutNextCheck; 

        if ( bNetscape4plus ) { 
                yMenuFrom   = document["divMenu"].top; 
                yMenuTo     = top.pageYOffset + 71; 
				//415 숫자를 고치면 스크롤위치가 바뀝니다.
        } 
        else if ( bExplorer4plus ) { 
                yMenuFrom   = parseInt (divMenu.style.top, 10); 
                yMenuTo     = document.body.scrollTop + 71; 
				//415 숫자를 고치면 스크롤위치가 바뀝니다.

        } 

        timeoutNextCheck = 1; 

        if ( Math.abs (yButtonFrom - (yMenuTo + 152)) < 6 && yButtonTo < yButtonFrom ) { 
                setTimeout ("CheckUIElements()", timeoutNextCheck); 
                return; 
        } 

        if ( yButtonFrom != yButtonTo ) { 
                yOffset = Math.ceil( Math.abs( yButtonTo - yButtonFrom ) / 1 ); 
                if ( yButtonTo < yButtonFrom ) 
                        yOffset = -yOffset; 

                if ( bNetscape4plus ) 
                        document["divLinkButton"].top += yOffset; 
                else if ( bExplorer4plus ) 
                        divLinkButton.style.top = parseInt (divLinkButton.style.top, 10) + yOffset; 

                timeoutNextCheck = 10; 
        } 
        if ( yMenuFrom != yMenuTo ) { 
                yOffset = Math.ceil( Math.abs( yMenuTo - yMenuFrom ) / 1 ); 
                if ( yMenuTo < yMenuFrom ) 
                        yOffset = -yOffset; 

                if ( bNetscape4plus ) 
                        document["divMenu"].top += yOffset; 
                else if ( bExplorer4plus ) 
                        divMenu.style.top = parseInt (divMenu.style.top, 10) + yOffset; 

                timeoutNextCheck = 10; 
        } 

        setTimeout ("CheckUIElements()", timeoutNextCheck); 
} 

function OnLoad() 
{ 
        var y; 
        if ( top.frames.length ) 
        if ( bNetscape4plus ) { 
                document["divMenu"].top = top.pageYOffset + 27; 
                document["divMenu"].visibility = "visible"; 
        } 
        else if ( bExplorer4plus ) { 
                divMenu.style.top = document.body.scrollTop + 27; 
                divMenu.style.visibility = "visible"; 
        } 
        CheckUIElements(); 
        return true; 
} 


var offsetxpoint=-60 //Customize x offset of tooltip
var offsetypoint=20 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thecolor, thewidth){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.x+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.y+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
else
tipobj.style.top=curY+offsetypoint+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}
document.onmousemove=positiontip


//비밀번호찾기 부분
function open_window(name, url, left, top, width, height, toolbar, menubar, statusbar, scrollbar, resizable)
{
 toolbar_str = toolbar ? 'yes' : 'no';
 menubar_str = menubar ? 'yes' : 'no';
 statusbar_str = statusbar ? 'yes' : 'no';
 scrollbar_str = scrollbar ? 'yes' : 'no';
 resizable_str = resizable ? 'yes' : 'no';
 window.open(url, name, 'left='+left+',top='+top+',width='+width+',height='+height+',toolbar='+toolbar_str+',menubar='+menubar_str+',status='+statusbar_str+',scrollbars='+scrollbar_str+',resizable='+resizable_str);
}


//게시판스크롤 부분
function Marq(kind)
{
	switch(kind) {
	case 1:
	mq_notice.stop();
	break;
	}
	switch(kind) {
	case 2:
	mq_notice.start();
	break;
	}
}



//플래쉬 메뉴 링크
function mainmenu(menuName){
	var main_url = '';
	if(menuName=="m1"){ //플래쉬에서 입력된 변수값
		location.href="guin_list.php"; //이동할 페이지 주소
		}else if(menuName=="m1_1"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guin_tasklist.html"; //이동할 페이지 주소
		}else if(menuName=="m1_2"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guin_arealist.html"; //이동할 페이지 주소
		}else if(menuName=="m1_3"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guin_woodae.html"; //이동할 페이지 주소
		}else if(menuName=="m1_4"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guin_premium.html"; //이동할 페이지 주소
		}else if(menuName=="m1_5"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guin_speed.html"; //이동할 페이지 주소
		}else if(menuName=="m1_6"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guin_pick.html"; //이동할 페이지 주소
		}else if(menuName=="m1_7"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guin_special.html"; //이동할 페이지 주소
		}else if(menuName=="m1_8"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guin_underground.html&underground1=1"; //이동할 페이지 주소

	}else if(menuName=="m2"){ //플래쉬에서 입력된 변수값
		location.href= "guzic_list.php"; //이동할 페이지 주소
		}else if(menuName=="m2_1"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guzic_tasklist.html"; //이동할 페이지 주소
		}else if(menuName=="m2_2"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guzic_arealist.html"; //이동할 페이지 주소
		}else if(menuName=="m2_3"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guzic_special.html"; //이동할 페이지 주소
		}else if(menuName=="m2_4"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guzic_focus.html"; //이동할 페이지 주소
		}else if(menuName=="m2_5"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guzic_power.html"; //이동할 페이지 주소

	}else if(menuName=="m3"){ //플래쉬에서 입력된 변수값
		location.href= "guin_regist.php"; //이동할 페이지 주소


	}else if(menuName=="m4"){ //플래쉬에서 입력된 변수값
		location.href="document.php?mode=add"; //이동할 페이지 주소


	}else if(menuName=="m5"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=bbs_index.html&file2=bbs_default.html"; //이동할 페이지 주소
		}else if(menuName=="m5_1"){ //플래쉬에서 입력된 변수값
		location.href= "bbs_list.php?tb=board_news"; //이동할 페이지 주소
		}else if(menuName=="m5_2"){ //플래쉬에서 입력된 변수값
		location.href= "bbs_list.php?tb=board_photo"; //이동할 페이지 주소
		}else if(menuName=="m5_3"){ //플래쉬에서 입력된 변수값
		location.href= "bbs_list.php?tb=board_knowhow"; //이동할 페이지 주소
		}else if(menuName=="m5_4"){ //플래쉬에서 입력된 변수값
		location.href= "bbs_list.php?tb=board_ucc"; //이동할 페이지 주소

	}else{
		alert('페이지를 찾을 수 없습니다.'); //해당변수가 없을시 메시지출력
	}
}






function field_space_check( objId , fieldCheck , outText , outColor)
{
 var obj  = document.getElementById(objId);

 objValue = obj.value;

 if ( objValue == fieldCheck )
 {
  obj.value  = outText;
  obj.style.color = outColor;


 }
}





function FlashMainbody(Ftrans,wid,hei) {
	
	mainbody = "<embed src='"+ Ftrans +"' quality='high' align='middle' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='"+ wid +"' height='"+ hei +"' wmode='Transparent'></embed>"
	

	//document.body.innerHTML = mainbody;
	document.write(mainbody);
	return;
}


function FlashXmlbody(Ftrans,wid,hei) {
 
 mainbody = "<embed src='"+ Ftrans +"' quality='high' align='middle' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='"+ wid +"' height='"+ hei +"' wmode='Transparent'></embed>"


 document.write(mainbody);
 return;
}

//<SCRIPT LANGUAGE="JavaScript">FlashMainbody("img/banner.swf","680","140",'Transparent');</SCRIPT>


function albumopen(link){
	window.open(link,'minialbum','width=900,height=700');
}


//온라인입사지원 삭제함수

function OnlineDel(num)
{
	TmpUrl = '';
	if ( confirm("온라인입사지원건이 확인전이므로 취소하실수 있습니다.\n\n취소하시겠습니까?") )
	{
		TmpUrl = './guin_join_del.php?mode=del';
		TmpUrl += '&number='+num;

		document.location.href = TmpUrl;

	}
}




function change_stats(bNumber)
{
	//alert(bNumber);
	selName = "online_stats_"+bNumber;
	selObj = document.getElementById(selName);
	
	url = "./online_doc_change.php?";
	url+= "bNumber="+bNumber;
	url+= "&online_stats="+selObj.value;

	//window.open(url);
	document.getElementById('change_online').src = url;
}



//png
function setPng24(obj) {
    obj.width=obj.height=1;
    obj.className=obj.className.replace(/\bPng24\b/i,'');
    obj.style.filter =
    "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+ obj.src +"',sizingMethod='image');"
    obj.src='';
    return '';
}

// 2011-05-27 HYO 스크립트 추가 start
function ExecuteCommand( commandName, comment)
{
	// Get the editor instance that we want to interact with.
	var oEditor = FCKeditorAPI.GetInstance( comment ) ;

	// Execute the command.
	oEditor.Commands.GetCommand( commandName ).Execute() ;
}
// 2011-05-27 HYO 스크립트 추가 end


function startPopup( Obj_Name )
{
	Obj = document.getElementById(Obj_Name);

	if ( Obj.style.display == "none" )
	{
		Obj.style.display = "";
	}
	else
	{
		Obj.style.display = "none";
	}
}


function guin_jump(number)
{
	msg = "해당 구인정보를 점프하시겠습니까?";
	if ( confirm(msg) )
	{
		window.location.href = "guin_jump.php?guin_number="+number;
	}
}


function view(what) {
var imgwin = window.open("",'WIN','scrollbars=yes,status=no,toolbar=no,resizable=0,location=no,menu=no,width=30,height=30,scrollbars=no');
imgwin.focus();
imgwin.document.open();
imgwin.document.write("<html>\n");
imgwin.document.write("<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\n");

imgwin.document.write("<sc"+"ript>\n");

imgwin.document.write("function closeWin(){\n");
imgwin.document.write("window.close();\n");
imgwin.document.write("}\n");

imgwin.document.write("function resize() {\n");
imgwin.document.write("pic = document.il;\n");
//imgwin.document.write("alert(eval(pic).height);\n");
imgwin.document.write("if (eval(pic).height) { var name = navigator.appName\n");
imgwin.document.write("  if (name == 'Microsoft Internet Explorer') { myHeight = eval(pic).height + 50; myWidth = eval(pic).width + 12;\n");
imgwin.document.write("  } else { myHeight = eval(pic).height + 9; myWidth = eval(pic).width; }\n");
imgwin.document.write("   if( myHeight > 600 ){ \n");
imgwin.document.write("    kwak = myHeight/600; \n");
imgwin.document.write("    myWidth = myWidth / kwak \n");
imgwin.document.write("    myHeight=600;\n");
imgwin.document.write("    pic.style.height=myHeight-35; \n");
imgwin.document.write("    pic.style.width=myWidth-10; }\n");
imgwin.document.write("   if( myWidth > 800 ){ \n");
imgwin.document.write("    kwak = myWidth/800; \n");
imgwin.document.write("    myHeight = myHeight / kwak \n");
imgwin.document.write("    myWidth=800;\n");
imgwin.document.write("    pic.style.height=myHeight-35; ");
imgwin.document.write("    pic.style.width=myWidth-10; }\n");
imgwin.document.write("  clearTimeout();\n");
imgwin.document.write("  var height = screen.height;\n");
imgwin.document.write("  var width = screen.width;\n");
imgwin.document.write("  var leftpos = width / 2 - myWidth / 2;\n");
imgwin.document.write("  var toppos = height / 2 - myHeight / 2; \n");
imgwin.document.write("  self.moveTo(leftpos, toppos);\n");
imgwin.document.write("  self.resizeTo(myWidth, myHeight+60);\n");
imgwin.document.write("}else setTimeOut(resize(), 100);}\n");
imgwin.document.write("</sc"+"ript>\n");

imgwin.document.write("</head>\n");
imgwin.document.write('<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">\n');

imgwin.document.write("<a href='javascript:closeWin()' onfocus='this.blur()' title='이미지를 클릭하시면 창이 닫힙니다.'>\n");
imgwin.document.write("<img border=0 src="+what+" xwidth=100 xheight=9 name=il onload='resize();'>\n");
imgwin.document.write("</a>\n");
imgwin.document.write("<center><a href='#1' onClick=\"document.all.cooponimg.style.display='';print()\"><img id='cooponimg' src='img/print_button.gif' border='0' alt='print' style='margin-top:7px;'></div></a>\n");
imgwin.document.write("</body>\n");
imgwin.document.close();
}


//ajax 페이징할때 상단으로 바로 이동하는 anchor 자바스크립트 2013-12-23 ralear
function scrollToAnchor(where)
{
	if ( document.getElementById(where) != undefined )
	{
		scrollY = document.getElementById(where).offsetTop + 300;
		scrollTo(0, scrollY);
	}
}
 

function addLoadEvent(func)
{
	var oldonload = window.onload;

	if ( typeof window.onload != 'function' )
	{
		window.onload = func;
	}
	else
	{
		window.onload = function()
		{
			oldonload();
			func();
		}
	}
}



function guzicdel(url)
{
	if ( confirm('정말 삭제 하시겠습니까?') )
	{
		window.location.href = url;
	}
}

function add_bookmark_click()
{
	try
	{
		window.external.AddFavorite(parent.location.href, document.title);
	}
	catch (e)
	{
		alert("Ctrl+D 키를 누르면 즐겨찾기에 추가하실수 있습니다.");
	}
}


/* 날씨 */
var cValue	= '';
var gCount	= 0;
function happy_weather_area_selectbox_view(count)
{
	$("#wthr_area_opt__box_" + count).toggle();
}
function happy_weather_area_change_start(count)
{
	var cOpt	= document.getElementById("wthr_area_opt_" + count);
	var cName	= "wthr_city" + count;
	cValue	= cOpt.options[cOpt.options.selectedIndex].value;
	var cDay	= 30;

	var expire = new Date();
	expire.setDate(expire.getDate() + cDay);
	cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.
	if(typeof cDay != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
	document.cookie = cookies;

	gCount	= count;

	happy_weather_area_change_end();
}
function happy_weather_area_change_end()
{
	var file	= document.getElementById("happy_weather_template_" + gCount).value;
	var css		= document.getElementById("happy_weather_template_css_" + gCount).value;
	var count	= document.getElementById("happy_weather_template_count_" + gCount).value;
	var imc_c	= document.getElementById("happy_weather_template_img_c_" + gCount).value;
	var img_h	= document.getElementById("happy_weather_template_img_h_" + gCount).value;

	$.ajax({
		type: "GET",
		url: "./ajax_weather.php",
		data: {
			is_ajax		: "ajax",
			file		: file,
			city		: cValue,
			stylecss	: css,
			wthr_count	: count,
			img_c		: imc_c,
			img_h		: img_h
		},
		success:function( respons ) {
			var responses	= respons.split("___cut___");

			if ( responses[0] == "ok" )
			{
				$("#happy_weather_layer_" + gCount).html( responses[1] );
			}
		}
	});
}





function happy_scrap_change(userType,mode,cNumber,img_type,listNumber)
{
	$.ajax({
		type: "GET",
		url: "./scrap.php",
		data: {
			is_ajax		: "ajax",
			userType	: userType,
			mode		: mode,
			cNumber		: cNumber,
			img_type	: img_type,
			listNumber	: listNumber
		},
		success:function( respons ) {
			var responses	= respons.split("___cut___");

			var result_val		= responses[0];		//결과
			var img_val			= responses[1];		//변경할 이미지

			var scrap_msg		= "";

			switch(mode)
			{
				case "per":		scrap_msg	= "";break;
				case "per_del":	scrap_msg	= "";break;
			}

			if ( result_val == "ok" )
			{
				switch(userType)
				{
					case "per":	$("#per_scrap_img_" + listNumber + "_" + cNumber).html(img_val);
								$("#per_scrap_msg_" + listNumber + "_" + cNumber).html(scrap_msg);
								$("#per_scrap_msg_" + listNumber + "_" + cNumber).css('display','');
								$("#per_scrap_msg_" + listNumber + "_" + cNumber).fadeOut(2000);
								break;
				}
			}
		}
	});
}



function happy_app_im_change(userType,update_value,cNumber,pNumber)
{
	$.ajax({
		type: "GET",
		url: "./ajax_app_im.php",
		data: {
			is_ajax		: "ajax",
			userType	: userType,
			update_value: update_value,
			cNumber		: cNumber,
			pNumber		: pNumber
		},
		success:function( respons ) {
			var responses	= respons.split("___cut___");

			var result_val		= responses[0];		//결과
			var img_val			= responses[1];		//변경할 이미지

			if ( result_val == "ok" )
			{
				$("#app_im_img_" + pNumber).html(img_val);
			}
		}
	});
}