function FlashMinialbum(Ftrans,wid,hei) {
	
	mainbody = "<embed src='"+ Ftrans +"' quality='high' scale='noscale' salign='lt' align='top' align='middle' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='"+ wid +"' height='"+ hei +"'></embed>"
	
	//document.body.innerHTML = mainbody;
	document.write(mainbody);
	return;
}

function FlashMainNon(Ftrans,wid,hei) {
	
	mainbody = "<embed src='"+ Ftrans +"' quality='high' salign='lt' align='top' wmode='Transparent' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='"+ wid +"' height='"+ hei +"'></embed>"
	

	//document.body.innerHTML = mainbody;
	document.write(mainbody);
	return;
}

function FlashMainbody(Ftrans,wid,hei) {
	
	mainbody = "<embed src='"+ Ftrans +"' quality='high' scale='noscale' salign='lt' align='top' wmode='Transparent' align='middle' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='"+ wid +"' height='"+ hei +"'></embed>"
	

	//document.body.innerHTML = mainbody;
	document.write(mainbody);
	return;
}


function call_subflash(Ftrans,wid,hei) {

	mainbody = "<embed src='"+ Ftrans +"' quality='high' scale='noscale' salign='lt' align='top' wmode='Transparent' align='middle' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='"+ wid +"' height='"+ hei +"'></embed>"


	document.getElementById('subflash_layer').innerHTML	= mainbody;
	return;
}

function printSWF( id, flashUri, vWidth, vHeight, winMode, bgColor) {
	var _obj_ = "";
	
	if ( id == '' )
	{
		tmp = "happy_flash_";
		rand = Math.round(( Math.random()*100000 ));
		
		id = tmp + rand;
	}

	if ( winMode == '' )
	{
		winMode = 'transparent';
	}
	if ( bgColor == '' )
	{
		bgColor = '#FFFFFF';
	}

	//alert(id);
	
	_obj_ = '<embed src="' + flashUri + '" quality="high" wmode="' + winMode + '" bgcolor="' + bgColor + '" width="' + vWidth +'" height="' + vHeight + '" id="' + id + '" align="middle" allowScriptAccess="always" allowFullScreen="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></embed>    ';
	
	document.writeln( _obj_ );

	eval("window." + id + " = document.getElementById('" + id + "');");
}

//날씨 쿠키
function setCookie( name, value, expiredays ) 
{ 
var todayDate = new Date(); 
todayDate.setDate( todayDate.getDate() + expiredays ); 
document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
}

function weather_change(str)
{
	name = 'g_city';
	value = str;
	expiredays = 365;

	setCookie( name, value, expiredays );
}
//날씨 쿠키

function flash_movie_add(Ftrans,wid,hei,uid) {
mainbody = "<embed src='"+ Ftrans +"' quality='high' scale='noscale' salign='lt' align='top' wmode='Transparent' align='middle' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='"+ wid +"' height='"+ hei +"'></embed>"
document.getElementById(uid).innerHTML = mainbody;
return;
} 