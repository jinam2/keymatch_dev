var xhrObject;
var word;
var search_word_label_number = 0;
var max_search_word = 0;
var event_number = 0;
var line_height = 25;

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
	return "word=" + word + "&timestamp=" + new Date().getTime();
}

function startMethod(key_code)
{
	//word = $( "search_word" );
	word = getID( "all_keyword" );

	if(key_code == 38 || key_code == 40)
	{
		moveLayer();
	}
	else
	{
		if( word.value.replace(/\s/g,'').length > 0  )
		{
			createXHR();
			var url = "ajax_search_word.php?" + getParameterValues( encodeURI(word.value) );

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
			getObject('all_keyword').value = getObject('search_word_'+search_word_label_number).innerText;
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

function clearMethod()
{
	getID( "autoSearchPart" ).style.display = "none";
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