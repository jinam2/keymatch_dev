function PrintLoading(div_id) {

	loading = '<img src="img/ajax_loading.gif" align="center" valign="middle">';
	//loading = "<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,115,0' align='middle'><param name='allowScriptAccess' value='always' /><param name='allowFullScreen' value='true' /><param name='movie' value='flash_swf/preloader.swf'><param name='quality' value='high' /><param name='wmode' value='transparent' /><param name='bgcolor' value='#FFFFFF' /><embed src='flash_swf/preloader.swf' quality='high' wmode='transparent' bgcolor='#FFFFFF' id='happy_flash_10000' align='middle' allowScriptAccess='always' allowFullScreen='true' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' /></embed>";
	$(div_id).html(loading);

}



function init_file_del(layer_number,filename) {

	if (!confirm("정말 삭제하시겠습니까?"))
	{
		return;
	}

	//핸들링
	div_id = '#file_name_layer_'+layer_number;
	PrintLoading(div_id);

	setTimeout(function(){
	$.post("ajax_file_del_false.php",{
		filename:filename
	},function(data) {
		//alert(data);
		$(div_id).html(data);
	})}
	,300);
	document.getElementById('file_del_button_'+layer_number).style.display = 'none';
}

