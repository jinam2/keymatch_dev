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

function embedTAG() {

}

function appletTAG() {

}