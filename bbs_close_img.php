<?php
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/Template.php");

print <<<END
<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<meta http-equiv='imagetoolbar' CONTENT='no'>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<title>이미지확대보기</title>
<script language='JavaScript1.2'>
<!--
var ie=document.all;
var nn6=document.getElementById&&!document.all;
var isdrag=false;
var x,y;
var dobj;

function movemouse(e)
{
	if (isdrag)
	{
		dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x;
		dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y;
		return false;
	}
}
function selectmouse(e)
{
	var fobj      = nn6 ? e.target : event.srcElement;
	var topelement = nn6 ? 'HTML' : 'BODY';
	while (fobj.tagName != topelement && fobj.className != 'dragme')
	{
		fobj = nn6 ? fobj.parentNode : fobj.parentElement;
	}
	if (fobj.className=='dragme')
	{
		isdrag = true;
		dobj = fobj;
		tx = parseInt(dobj.style.left+0);
		ty = parseInt(dobj.style.top+0);
		x = nn6 ? e.clientX : event.clientX;
		y = nn6 ? e.clientY : event.clientY;
		document.onmousemove=movemouse;
		return false;
	}
}
document.onmousedown=selectmouse;
document.onmouseup=new Function('isdrag=false');
//-->
</script>
<style>.dragme{position:relative;}</style>
</head>

<body leftmargin=0 topmargin=0 bgcolor='white' style='cursor:arrow; overflow:hidden'>


<table cellpadding=0 cellspacing=0>
<tr>
	<td><a href='javascript:self.close();'><img src='$file_name' border=0 class='dragme' ondblclick='window.close();' style='cursor:move' title='더블클릭하면 화면이 닫힙니다'></a></td>
</tr>
</table>





</body>

</html>
END;


?>