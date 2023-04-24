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

function Marq(kind){ 
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


var prev_divid		= "";
var prev_formCount	= "";
var prev_mode		= "";

function GoWrite( divid, mode, name, title, content, Count, Msg )
{

	chk	= mode +"_"+ Count;
	if ( prev_divid != "" && prev_mode != chk )
	{
		document.all[prev_divid].style.display = "none";
		var prev_frm = document.forms["reply_frm_"+prev_formCount];
		prev_frm.mode.value		= "";
		prev_frm.name.value		= "";
		prev_frm.content.value	= "";
	}
	prev_divid			= divid;
	prev_formCount		= Count;
	prev_mode			= mode +"_"+ Count;



	var chk = document.all[divid].style.display; 
	chk = ( chk == '' )?'none':'';
	document.all[divid].style.display = chk; 

	var frm =document.forms["reply_frm_"+Count];
	frm.mode.value		= mode;
	frm.name.value		= name;
	frm.content.value	= content;
	frm.sendit.value	= Msg;

	
}

var prev_replyDiv	= "";
function ShowReply( replyDiv )
{
	if ( prev_replyDiv != replyDiv && prev_replyDiv != "" )
	{
		document.all[prev_replyDiv].style.display = "none";
	}
	prev_replyDiv	= replyDiv;

	var chk	= document.all[replyDiv].style.display;
	chk = ( chk == '' )?'none':'';
	document.all[replyDiv].style.display = chk;
}

function ReplyDelete(number)
{
	if ( confirm("정말 삭제하시겠습니까?" ) )
	{
		alert("알겟다");
	}
}

function login()
{
	link	= window.location.href;

	window.location.href = "/new_login.php?returnUrl="+link;
}

function underFindObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=underFindObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}



function underShowHideLayer() { // MM_showHideLayers v6.0 함수 이름만 변경 (충돌방지)
	var i,p,v,obj,args=underShowHideLayer.arguments;
	for (i=0; i<(args.length-2); i+=3)
	{
		if ((obj=underFindObj(args[i]))!=null) {
			v=args[i+2];
			if (obj.style) {
				obj=obj.style;
				v=(v=='show')?'visible':(v=='hide')?'hidden':v;
			}
	
			obj.visibility=v;
			if ( v == 'hide' || v == 'hidden' )
			{
				obj.left	= -555;
				obj.top		= -555;
			}
			else
			{
				obj.left	= event.x + ietruebody().scrollLeft - 0 ;
				obj.top		= event.y + ietruebody().scrollTop - 0;
			}
		}
	}
}

function objectTAG(name,file,width,height,wmode,bgcolor) {
	document.write('\
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="'+width+'" height="'+height+'" id="'+name+'" align="middle">\
<param name="allowScriptAccess" value="sameDomain">\
<param name="movie" value="'+file+'">\
<param name="quality" value="high">\
<param name="wmode" value="'+wmode+'">\
<param name="bgcolor" value="'+bgcolor+'">\
<embed src="'+file+'" quality="high" wmode="'+wmode+'" bgcolor="'+bgcolor+'" width="'+width+'" height="'+height+'" name="'+name+'" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">\
</object>\
	');
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



// 카카오 알림톡 템플릿찾기 버튼 스크립트 - hong
function kakao_template_find(url,msg_name,code_name,var_type)
{
	if ( !url )
	{
		alert('URL 누락');
		return;
	}

	if ( !msg_name )
	{
		alert('SMS 발송내용 입력부분 NAME 누락');
		return;
	}

	if ( !code_name )
	{
		alert('카카오 알림톡 템플릿코드 입력부분 NAME 누락');
		return;
	}

	var_type	= ( var_type ) ? var_type : "type1";

	url			+= "&msg_name=" + encodeURIComponent(msg_name);
	url			+= "&code_name=" + encodeURIComponent(code_name);
	url			+= "&var_type=" + var_type;

	var name	= "popup_kakao_template_list";
	var opt		= "width=700,height=800,scrollbars=yes";

	var obj		= window.open(url,name,opt);

	if ( obj )
	{
		obj.focus();
	}
}