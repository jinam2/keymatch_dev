;(function( $ ){
	$.fn.captcha = function(options){

		var defaults = {
			howmany:5,
			borderColor: "",
			captchaDir: "",
			imageDir: "img/captcha",
			url: "captcha.php",
			formId: "myForm",
			text: "Verify that you are a human,<br />drag <span>scissors</span> into the circle.",
			items: Array(
				{key:"bird", text:"Bird"},
				{key:"calendar", text:"Calendar"},
				{key:"cd", text:"CD"},
				{key:"film", text:"Film"},
				{key:"heart", text:"Heart"},
				{key:"home", text:"Home"},
				{key:"key", text:"Key"},
				{key:"mobile", text:"Mobile phone"},
				{key:"music", text:"Phonetic alphabet"},
				{key:"pencil", text:"Pencil"},
				{key:"people", text:"Person"},
				{key:"photo", text:"Photo"},
				{key:"barchart", text:"Bar chart"},
				{key:"piechart", text:"Pie chart"},
				{key:"printer", text:"Printer"},
				{key:"spanner", text:"Spanner"},
				{key:"star", text:"Star"},
				{key:"tag", text:"Tag"},
				{key:"egg", text:"Egg"},
				{key:"folder", text:"Folder"},
				{key:"mail", text:"Envelope"}
			),/*
			items: Array(
				{key:"pencil", text:"pencil"},
				{key:"calendar", text:"달력"},
				{key:"scissors", text:"scissors"},
				{key:"clock", text:"clock"},
				{key:"heart", text:"heart"},
				{key:"note", text:"note"}
			),*/
			callback:function(){}
		};

		var options = $.extend(defaults, options); 

		var $html = "";
		$html += "<img class='ajax-fc-border' id='ajax-fc-left' src='" + options.imageDir + "/border-left.png' />";
		$html += "<img class='ajax-fc-border' id='ajax-fc-right' src='" + options.imageDir + "/border-right.png' />";
		$html += "<div id='ajax-fc-content'>";
		$html += "	<div id='ajax-fc-left'>";
		$html += "		<p id='ajax-fc-task'>" + options.text + "</p>";
		$html += "		<ul id='ajax-fc-task'>";
		for(var idx = 0 ; idx<options.howmany ; idx++){
			$html += "			<li class='ajax-fc-"+idx+"'><img src='" + options.imageDir + "/blank.gif' alt='' /></li>";
		}
		$html += "		</ul>";
		$html += "	</div>";
		$html += "	<div id='ajax-fc-right'>";
	//	$html += "		<a target='_blank' href='http://www.webdesignbeach.com'><img id='ajax-fc-backlink' src='" + options.imageDir + "/wdb.png' alt='Web Design Beach' /></a>";
		$html += "		<p id='ajax-fc-circle'></p>";
		$html += "	</div>";
		$html += "</div>";
		$html += "<div id='ajax-fc-corner-spacer'></div>";

		$(this).html($html);
		var picidx = Math.floor(Math.random()*options.items.length);
		var viewidx = Math.floor(Math.random()*options.howmany);

		var used = Array();
		for(var idx = 0 ; idx<options.howmany ; idx++){
			if(idx == viewidx){
				$(".ajax-fc-" + idx).html("<img src=\"" + options.imageDir + "/item-" + options.items[picidx].key + ".png\" alt=\"\" />");
				$(".ajax-fc-" + idx).addClass('ajax-fc-highlighted');
				$(".ajax-fc-" + idx).draggable({ containment: '#ajax-fc-content' });
				$("p#ajax-fc-task span").html(options.items[picidx].text);
			}
			else{
				$(".ajax-fc-" +idx).html( "<img src=\"" + options.imageDir + "/item-" + options.items[(idx+picidx+1)%options.items.length].key + ".png\" alt=\"\" />");
				used[idx] = options.items[(idx+picidx+1)%options.items.length].key;
			}
		}

		$(".ajax-fc-container, .ajax-fc-rtop *, .ajax-fc-rbottom *").css("background-color", options.borderColor);
		$("#ajax-fc-circle").droppable({
			drop: function(event, ui) {
				$(".ajax-fc-" + viewidx).draggable("disable");
				var rand = $.ajax({ url: options.url,async: false }).responseText;
				if(rand.indexOf(":")>0){
					var key = rand.substr(0, rand.indexOf(":"));
					var value = rand.substr(rand.indexOf(":")+1);
					$("#" + options.formId).append("<input type=\"hidden\" style=\"display: none;\" name=\""+key+"\" value=\"" + value + "\">");
				} else {
					$("#" + options.formId).append("<input type=\"hidden\" style=\"display: none;\" name=\"captcha\" value=\"" + rand + "\">");
				}
				options.callback(rand);
			},
			tolerance: 'touch'
		});
	};

})( jQuery );






var tab = ""; 
function print_r(arr)
{

 var str = "<pre>";

 //key 와 value를 끝까지 뽑기
 for(var i in arr)
 {
  str += tab + "["+i+"]"; //key값 번호

  if(typeof(arr[i])!="object" || (!arr[i])) //object 가 아니거나, 0 또는 false 인녀석(undefined 가 아닌 공백리턴)
  {
   if(arr[i] == 0)
   {
    str+= "0 "; 
   }
   else
   {
    str += (!arr[i]) ? "null " : arr[i] + " "; 
   }
  }
  else //object 처리,상위배열
  {
   oldtab2 = tab;
   tab += " ";
   str += "array( "; 
   str += print_r(arr[i]);  //배열키값알았으니 재귀함수로 한번더 알아본다
   str += tab + ") ";
   tab = oldtab2;
  }

 }
 str += "</pre>";

 return str;
}


