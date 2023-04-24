
//select 자동생성 함수
function make_underground_search( nowNum, nowNum2 )
{
	var under1_maxlen	= under1_title.length;
	var sel	= "<select name='underground1_search' id='underground1_search' onChange=\"underground_search_change('');\">";
	sel	+= "<option value=''>역세권선택</option>";
	for ( i=0 ; i<under1_maxlen ; i++ )
	{
		selected	= nowNum == under1_numbe[i] ?'selected':'';
		sel	+= "<option value='"+ under1_numbe[i] +"' "+selected+">"+ under1_title[i] +"</option>";
	}
	sel	+= '</select>';

	sel	+= " <select name='underground2_search' id='underground2_search' onChange=\"underground_search_text_change();\"><option value=''>지하철역 선택</option></select>";

	document.write(sel);
	if ( nowNum != '0' && nowNum != '' )
		underground_search_change( nowNum2 );
}

//역세권 선택시 지하철 역 출력함수
function underground_search_change( nowNum2 )
{
	var obj_under1	= document.getElementById('underground1_search');
	var obj_under2	= document.getElementById('underground2_search');
	var nowSelect	= obj_under1.selectedIndex;
	var nowNumber	= obj_under1.options[nowSelect].value;
	var nowText		= obj_under1.options[nowSelect].text;

	var under2_max	= obj_under2.length;
	for ( i=under2_max ; i>0 ; i-- )
	{
		obj_under2.options[i] = null;
	}

	if ( nowSelect > 0 )
	{
		var maxLen		= under2_numbe[nowNumber].length;
		var selected	= 0;

		obj_under2.options[0]	= new Option(nowText+' 지하철역 선택','',true);
		
		for ( i=0,j=1 ; i<maxLen ; i++,j++ )
		{
			selected	= nowNum2 == under2_numbe[nowNumber][i] ?j:selected;
			obj_under2.options[j]	= new Option(under2_title[nowNumber][i],under2_numbe[nowNumber][i]);
		}

		obj_under2.selectedIndex	= selected;
	}
	else
	{
		obj_under2.options[0]	= new Option('지하철역 선택','',true);
	}

	underground_search_text_change();
}

//역세권 선택시 TEXT 입력 함수
function underground_search_text_change()
{
	var obj		= document.getElementById('underground_search_text');

	if ( obj == undefined )
	{
		return;
	}
	
	var obj_under1			= document.getElementById('underground1_search');
	var obj_under2			= document.getElementById('underground2_search');

	var obj_under1_value	= obj_under1.options[obj_under1.selectedIndex].value;
	var obj_under1_text		= obj_under1.options[obj_under1.selectedIndex].text;

	var obj_under2_value	= obj_under2.options[obj_under2.selectedIndex].value;
	var obj_under2_text		= obj_under2.options[obj_under2.selectedIndex].text;

	if ( obj_under1_value != "" )
	{
		obj.value				= obj_under1_text;
	}
	else
	{
		obj.value				= "";
	}

	if ( obj_under2_value != "" )
	{
		obj.value				= obj.value + " > " + obj_under2_text;
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

var xhrObjectUnder;
var wordUnder;
var under_search_word_label_number = 0;
var under_max_search_word = 0;
var under_event_number = 0;
var under_line_nums = 8;
var under_line_height = 25;

var under_autoArea_height = under_line_nums * under_line_height;  //자동완성단어영역높이

function getID(object){
	return document.getElementById(object);
}

function createXHR_Under()
{
	if( window.ActiveXObject )
	{
		xhrObjectUnder = new ActiveXObject( "Microsoft.XMLHTTP" );
	}
	else if( window.XMLHttpRequest )
	{
		xhrObjectUnder = new XMLHttpRequest();
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

function getParameterValuesUnder( word )
{
	return "word=" + word + "&timestamp=" + new Date().getTime();
}

function startMethodUnder(key_code,is_submit)
{
	if ( is_submit == undefined )
	{
		is_submit	= '';
	}

	wordUnder = getID( "underground_search_text" );

	if(key_code == 38 || key_code == 40)
	{
		moveLayerUnder();
	}
	else if (key_code == 13)
	{
		if ( under_search_word_label_number == 0 )
		{
			under_search_word_label_number = 1;
		}

		if ( getID("under_search_word_td_" + under_search_word_label_number) != undefined )
		{
			under_val	= getID('h_underground_'+under_search_word_label_number).value;
			under_vals	= under_val.split("__");
			
			under1		= under_vals[0];
			under2		= under_vals[1];
			under_text	= under_vals[2];
			
			underground_select(under1,under2,under_text);
		}

		clearMethodUnder();
	}
	else if (key_code == 27)
	{
		clearMethodUnder();
	}
	else
	{
		if( wordUnder.value.replace(/\s/g,'').length > 0  )
		{
			createXHR_Under();
			var url = "ajax_underground_search.php?" + getParameterValuesUnder( encodeURI(wordUnder.value) ) + "&is_submit=" + is_submit;

			xhrObjectUnder.onreadystatechange = resultProcessUnder;
			xhrObjectUnder.open( "Get", url, "true" );
			xhrObjectUnder.send( null );

			under_Now_Layer_Top = 0;
			under_search_word_label_number = 0;
			getID("autoSearchPartUnder").scrollTop = 0;
		}
		else
		{
			clearMethodUnder();
		}
	}

}

function moveLayerUnder(key_value)
{
	under_event_number = key_value;

	if((under_event_number == 40 || under_event_number == 38) && getID( "autoSearchPartUnder" ).style.display == "block")
	{
		if(under_event_number == 40)
		{
			under_search_word_label_number_old = under_search_word_label_number;
			under_search_word_label_number++;
		}
		else if(under_event_number == 38)
		{
			if(under_search_word_label_number > 1)
			{
				under_search_word_label_number_old = under_search_word_label_number;
				under_search_word_label_number--;
			}
		}

		if(under_search_word_label_number <= 0)
		{
			under_search_word_label_number = 0;
		}
		else if(under_search_word_label_number > under_max_search_word)
		{
			under_search_word_label_number = under_max_search_word;
		}
		else
		{
			if(under_search_word_label_number >= 1)
			{
				getObject('under_search_word_td_'+under_search_word_label_number_old).className = "listOutUnder";
			}
			getObject('under_search_word_td_'+under_search_word_label_number).className = "listInUnder";
			//getObject('underground_search_text').value = getObject('under_search_word_'+under_search_word_label_number).innerText;
		}


		//레이어보다 단어수가 많을때 키보드 이동에 맞춰 스크롤이동


		under_Now_Layer_Top = under_search_word_label_number * under_line_height;

		if(under_event_number == 40)
		{
			if(under_Now_Layer_Top > under_autoArea_height)
			{
				getID("autoSearchPartUnder").scrollTop += under_line_height;
			}
		}
		else if(under_event_number == 38)
		{
			if(under_max_search_word - under_line_nums >= under_search_word_label_number )
			{
				getID("autoSearchPartUnder").scrollTop -= under_line_height;
			}
		}
	}

}

function searchWordProcessUnder()
{
	var respons = xhrObjectUnder.responseText.split("___cut___");
	var result = respons[0];

	if( result )
	{
		getID( "autoSearchPartUnder" ).style.display = "block";
		getID( "autoSearchPartUnder" ).style.backgroundCoor = "#ffffff";
		//getID( "autoSearchPartUnder" ).style.width = ( wordUnder.offsetWidth - 10 ) + "px";
		getID( "autoSearchPartUnder" ).style.left = wordUnder.offsetLeft + "px";
		getID( "autoSearchPartUnder" ).style.top = wordUnder.offsetTop + wordUnder.offsetHeight + "px";
		getID( "autoSearchPartUnder" ).innerHTML = result;

		var table = getID( "autoSearchPartUnder" ).getElementsByTagName( "table" )[0];
		//table.setAttribute( "width", wordUnder.offsetWidth - 2 );

		var tds = getID( "autoSearchPartUnder" ).getElementsByTagName( "td" );

		for( var i = 0; i < tds.length; i++ )
		{
			tds[i].onmouseover = function()
			{
				for( var j = 0; j < tds.length; j++ )
				{
					tds[j].className = "listOutUnder";
				}
				wordUnder.focus();
				this.className = "listInUnder";
			};
			tds[i].onmouseout = function(){
				this.className = "listOutUnder";
			};
		}
		under_max_search_word = respons[1];

		if( i > under_line_nums )
		{
			getID( "autoSearchPartUnder" ).style.height = under_autoArea_height+5+"px";
		}
		else
		{
			getID( "autoSearchPartUnder" ).style.height = table.offsetHeight+5+"px";
		}
	}
	else
	{
		getID( "autoSearchPartUnder" ).innerHTML = "";
		clearMethodUnder();
	}
}

function clearMethodUnder()
{
	getID( "autoSearchPartUnder" ).style.display = "none";
	/*
	getID( "autoSearchPartUnder" ).style.backgroundColor = "";
	getID( "autoSearchPartUnder" ).style.border = "none";
	getID( "autoSearchPartUnder" ).style.innerHTML = "";
	*/
}

function resultProcessUnder()
{
	if( xhrObjectUnder.readyState == 4 )
	{
		if( xhrObjectUnder.status == 200 )
		{
			searchWordProcessUnder();
		}
		else if( xhrObjectUnder.status == 204 )
		{
			clearMethodUnder();
		}
	}
}


function returnValueUnder()
{
	underground_search_text_change();

	clearMethodUnder();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function underground_search_setting()
{
	underground1_val		= document.getElementById('underground1_search').value;
	underground2_val		= document.getElementById('underground2_search').value;
	underground_text		= document.getElementById('underground_search_text').value;
	
	if ( document.a_f_guin.underground1 != undefined )
	{
		document.a_f_guin.underground1.value		= underground1_val;
	}
	if ( document.a_f_guin.underground2 != undefined )
	{
		document.a_f_guin.underground2.value		= underground2_val;
	}
	if ( document.a_f_guin.underground_text != undefined )
	{
		document.a_f_guin.underground_text.value	= underground_text;
	}
}

function underground_select(under1,under2,under_text)
{
	var obj_under1			= document.getElementById('underground1_search');
	var obj_under2			= document.getElementById('underground2_search');
	var obj_under_text		= document.getElementById('underground_search_text');
	
	obj_under1.value		= under1;

	underground_search_change('');

	obj_under2.value		= under2;
	obj_under_text.value	= under_text;
	
	underground_search_setting();

	clearMethodUnder();
}

function underground_search()
{
	underground_search_setting();

	document.a_f_guin.submit();
}

function underground_search2()
{
	underground_search_setting();
}