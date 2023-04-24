var xhrObject;
var word;
var search_word_label_number = 0;
var max_search_word = 0;
var event_number = 0;

var line_nums = 8;  //표시될 단어(줄)수
var line_height = 25;  //한(단어)줄의 높이
var autoArea_height = line_nums * line_height;  //자동완성단어영역높이

function getID(object){
	return document.getElementById(object);
}

function createXHR()
{
	if( window.ActiveXObject )
	{
		xhrObject = new ActiveXObject( "Microsoft.XMLHTTP" );
	}
	else if( window.XMLHttpRequest )
	{
		xhrObject = new XMLHttpRequest();
	}
}

function getObject(objectId)
{
	//checkW3C DOM, then MSIE4, then NN 4
	if(document.getElementById && document.getElementById(objectId))
	{
		return document.getElementById(objectId);
	}
	else if(document.all && document.all(objectId))
	{
		return document.all(objectId);
	}
	else if(document.layers && document.layers(objectId))
	{
		return document.layers(objectId);
	}
	else
	{
		return false;
	}
}

function getParameterValues( word )
{
	return "word=" + encodeURI(word) + "&timestamp=" + new Date().getTime();
}

function startMethod(key_code)
{
	//alert(key_code);
	//word = $( "search_word" );
	word = getID( "menu_search" );


	if(key_code == 38 || key_code == 40)
	{
		moveLayer();
	}
	else
	{

		if( word.value.replace(/\s/g,'').length > 0  )
		{
			createXHR();
			var url = "./ajax_search_word.php?" + getParameterValues( word.value );

			xhrObject.onreadystatechange = resultProcess;
			xhrObject.open( "Get", url, "true" );
			xhrObject.send( null );

			Now_Layer_Top = 0;
			search_word_label_number = 0;
			getID("autoSearchPart").scrollTop = 0;
		}
		else
		{
			clearMethod();
		}
	}

}

function startMethod2(key_code)
{
	//word = $( "search_word" );
	word = getID( "search_word2" );

	if(key_code == 38 || key_code == 40)
	{
		moveLayer2();
	}
	else
	{
		if( word.value.replace(/\s/g,'').length > 0  )
		{
			createXHR();
			var url = "/ajax_search_word.php?" + getParameterValues( word.value );

			xhrObject.onreadystatechange = resultProcess2;
			xhrObject.open( "Get", url, "true" );
			xhrObject.send( null );

			Now_Layer_Top = 0;
			search_word_label_number = 0;
			getID("autoSearchPart2").scrollTop = 0;
		}
		else
		{
			clearMethod2();
		}
	}

}

function moveLayer(key_value)
{
	event_number = key_value;

	if((event_number == 40 || event_number == 38) && getID( "autoSearchPart" ).style.display == "block")
	{
		if(event_number == 40)
		{
			search_word_label_number_old = search_word_label_number;
			search_word_label_number++;
		}
		else if(event_number == 38)
		{
			if(search_word_label_number > 1)
			{
				search_word_label_number_old = search_word_label_number;
				search_word_label_number--;
			}
		}

		if(search_word_label_number <= 0)
		{
			search_word_label_number = 0;
		}
		else if(search_word_label_number > max_search_word)
		{
			search_word_label_number = max_search_word;
		}
		else
		{
			if(search_word_label_number >= 1)
			{
				getObject('search_word_td_'+search_word_label_number_old).className = "listOut";
			}
			getObject('search_word_td_'+search_word_label_number).className = "listIn";
			
			if ( getObject('search_word_'+search_word_label_number).textContent == undefined )
			{
				getObject('menu_search').value = getObject('search_word_'+search_word_label_number).innerText;
			}
			else
			{
				getObject('menu_search').value = getObject('search_word_'+search_word_label_number).textContent;
			}
		}


		//레이어보다 단어수가 많을때 키보드 이동에 맞춰 스크롤이동


		Now_Layer_Top = search_word_label_number * line_height;

		if(event_number == 40)
		{
			if(Now_Layer_Top > autoArea_height)
			{
				getID("autoSearchPart").scrollTop += line_height;
			}
		}
		else if(event_number == 38)
		{
			if(max_search_word - line_nums >= search_word_label_number )
			{
				getID("autoSearchPart").scrollTop -= line_height;
			}

		}
	}
}

function moveLayer2(key_value)
{
	event_number = key_value;

	if((event_number == 40 || event_number == 38) && getID( "autoSearchPart2" ).style.display == "block")
	{
		if(event_number == 40)
		{
			search_word_label_number_old = search_word_label_number;
			search_word_label_number++;
		}
		else if(event_number == 38)
		{
			if(search_word_label_number > 1)
			{
				search_word_label_number_old = search_word_label_number;
				search_word_label_number--;
			}
		}

		if(search_word_label_number <= 0)
		{
			search_word_label_number = 0;
		}
		else if(search_word_label_number > max_search_word)
		{
			search_word_label_number = max_search_word;
		}
		else
		{
			if(search_word_label_number >= 1)
			{
				getObject('search_word_td_'+search_word_label_number_old).className = "listOut";
			}
			getObject('search_word_td_'+search_word_label_number).className = "listIn";
			getObject('search_word2').innerText = getObject('search_word_'+search_word_label_number).innerText;
		}


		//레이어보다 단어수가 많을때 키보드 이동에 맞춰 스크롤이동


		Now_Layer_Top = search_word_label_number * line_height;

		if(event_number == 40)
		{
			if(Now_Layer_Top > autoArea_height)
			{
				getID("autoSearchPart2").scrollTop += line_height;
			}
		}
		else if(event_number == 38)
		{
			if(max_search_word - line_nums >= search_word_label_number )
			{
				getID("autoSearchPart2").scrollTop -= line_height;
			}

		}
	}

}

function searchWordProcess()
{
	var respons = xhrObject.responseText.split("___cut___");
	var result = respons[0];

	if( result )
	{
		getID( "autoSearchPart" ).style.display = "block";
		getID( "autoSearchPart" ).style.backgroundCoor = "#ffffff";
		//getID( "autoSearchPart" ).style.width = ( word.offsetWidth - 10 ) + "px";
		getID( "autoSearchPart" ).style.left = word.offsetLeft + "px";
		getID( "autoSearchPart" ).style.top = word.offsetTop + word.offsetHeight + "px";
		getID( "autoSearchPart" ).innerHTML = result;

		var table = getID( "autoSearchPart" ).getElementsByTagName( "table" )[0];
		//table.setAttribute( "width", word.offsetWidth - 2 );

		var tds = getID( "autoSearchPart" ).getElementsByTagName( "td" );

		for( var i = 0; i < tds.length; i++ )
		{
			tds[i].onmouseover = function()
			{
				for( var j = 0; j < tds.length; j++ )
				{
					tds[j].className = "listOut";
				}
				word.focus();
				this.className = "listIn";
			};
			tds[i].onmouseout = function(){
				this.className = "listOut";
			};
		}
		max_search_word = respons[1];

		if( i > line_nums )
		{
			getID( "autoSearchPart" ).style.height = autoArea_height+5+"px";
		}
		else
		{
			getID( "autoSearchPart" ).style.height = table.offsetHeight+5+"px";
		}
	}
	else
	{
		clearMethod();
	}
}

function searchWordProcess2()
{
	var respons = xhrObject.responseText.split("___cut___");
	var result = respons[0];

	if( result )
	{
		getID( "autoSearchPart2" ).style.display = "block";
		getID( "autoSearchPart2" ).style.backgroundCoor = "#ffffff";
		//getID( "autoSearchPart" ).style.width = ( word.offsetWidth - 10 ) + "px";
		getID( "autoSearchPart2" ).style.left = word.offsetLeft + "px";
		getID( "autoSearchPart2" ).style.top = word.offsetTop + word.offsetHeight + "px";
		getID( "autoSearchPart2" ).innerHTML = result;

		var table = getID( "autoSearchPart2" ).getElementsByTagName( "table" )[0];
		//table.setAttribute( "width", word.offsetWidth - 2 );

		var tds = getID( "autoSearchPart2" ).getElementsByTagName( "td" );

		for( var i = 0; i < tds.length; i++ )
		{
			tds[i].onmouseover = function()
			{
				for( var j = 0; j < tds.length; j++ )
				{
					tds[j].className = "listOut";
				}
				word.focus();
				this.className = "listIn";
			};
			tds[i].onmouseout = function(){
				this.className = "listOut";
			};
		}
		max_search_word = respons[1];

		if( i > line_nums )
		{
			getID( "autoSearchPart2" ).style.height = autoArea_height+5+"px";
		}
		else
		{
			getID( "autoSearchPart2" ).style.height = table.offsetHeight+5+"px";
		}
	}
	else
	{
		clearMethod2();
	}
}

function clearMethod()
{
	getID( "autoSearchPart" ).style.display = "none";
	/*
	getID( "autoSearchPart" ).style.backgroundColor = "";
	getID( "autoSearchPart" ).style.border = "none";
	getID( "autoSearchPart" ).style.innerHTML = "";
	*/
}

function clearMethod2()
{
	getID( "autoSearchPart2" ).style.display = "none";
	/*
	getID( "autoSearchPart" ).style.backgroundColor = "";
	getID( "autoSearchPart" ).style.border = "none";
	getID( "autoSearchPart" ).style.innerHTML = "";
	*/
}

function resultProcess()
{
	if( xhrObject.readyState == 4 )
	{
		if( xhrObject.status == 200 )
		{
			searchWordProcess();
		}
		else if( xhrObject.status == 204 )
		{
			clearMethod();
		}
	}
}

function resultProcess2()
{
	if( xhrObject.readyState == 4 )
	{
		if( xhrObject.status == 200 )
		{
			searchWordProcess2();
		}
		else if( xhrObject.status == 204 )
		{
			clearMethod2();
		}
	}
}







function go_search(word)
{

	if ( word != undefined )
	{
		document.getElementById('menu_search').value = word;
	}

	//admin_menu_search();
	//searchform.submit();
	getID( "autoSearchPart" ).style.display = "none";
}

function go_search2(word)
{

	if ( word != undefined )
	{
		searchform2.search_word2.value = word;
	}

	searchform.submit();
}

function test()
{
	document.getElementById("autoSearchPart").style.display = "none";
}

function die_search()
{
	var get_att =  document.getElementsByTagName("body")[0];
	get_att.setAttribute("onmousedown","");
}

function open_search()
{
	var get_att =  document.getElementsByTagName("body")[0];
	get_att.setAttribute("onmousedown","alter('111')");
}


function live_search()
{
	document.getElementById("autoSearchPart").style.display = "block";
}

function live_search_check()
{
	var check = document.getElementById("autoSearchPart").style.display;
	if( check == "block" )
	{
		document.getElementById("autoSearchPart").style.display = "none";
		return false;
	}
	else
	{
		document.getElementById("autoSearchPart").style.display = "block";
		return false;
	}
}
/*
function go_search()
{
var names = new Array("category1", "category2", "category3", "si", "gu", "search_dong");
for ( i=0, max=names.length ; i<max ; i++ )
	{
		now_name = names[i];
		if ( document.searchform[now_name] )
			{
				if ( document.searchform[now_name].selectedIndex != 0 ){
				document.searchform.action = "search.php";
			}
		}
	}
}
*/


function autoPartClose()
{
	if(document.getElementById('autoSearchPart') != undefined)
		document.getElementById('autoSearchPart').style.display='none';
}