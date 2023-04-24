/// 에러메시지 포멧 정의 ///
var NO_BLANK = "{name+을를} 입력하세요";
var NO_BLANK_RADIO = "{name+을를} 선택하세요";
var NOT_VALID = "{name+이가} 올바르지 않습니다";
var TOO_LONG = "{name}의 길이가 초과되었습니다 (최대 {maxbyte}바이트)";

/// 스트링 객체에 메소드 추가 ///
String.prototype.trim = function(str) { 
	str = this != window ? this : str; 
	return str.replace(/^\s+/g,'').replace(/\s+$/g,''); 
}

String.prototype.hasFinalConsonant = function(str) {
	str = this != window ? this : str; 
	var strTemp = str.substr(str.length-1);
	return ((strTemp.charCodeAt(0)-16)%28!=0);
}

function josa(str,tail) {
	return (str.hasFinalConsonant()) ? tail.substring(0,1) : tail.substring(1,2);
}

function validate(form) {
	for (i = 0; i < form.elements.length; i++ ) {
		var el = form.elements[i];
			
		//el.value = el.value.trim();

		if (el.getAttribute("HNAME") != null && el.style.display != "none" ) {
			if (el.value == null || el.value == "") {
				return doError(el,NO_BLANK);
			}

			//라디오버튼 일때 폼 체크 하는 부분
			if ( el.getAttribute("type") == "radio" || el.getAttribute("type") == "checkbox" ) {
				obj	= form[el.name];
				len	= obj.length;
				//alert(len);

				chk	= '';

				if ( len == undefined )
				{
					if ( form[el.name].checked == true )
					{
						chk	= 'ok';
					}
				}
				else
				{
					for ( z=0 ; z<len ; z++ )
					{
						if ( form[el.name][z].checked == true )
						{
							chk	= 'ok';
							break;
						}
					}
				}
				if ( chk == '' )
				{
					return doError(el,NO_BLANK_RADIO);
				}
			}
			//라디오버튼 일때 폼 체크 하는 부분
		}

		if (el.getAttribute("MAXBYTE") != null && el.value != "") {
			var len = 0;
			for(j=0; j<el.value.length; j++) {
				var str = el.value.charAt(j);
				len += (str.charCodeAt() > 128) ? 2 : 1
			}
			if (len > parseInt(el.getAttribute("MAXBYTE"))) {
				maxbyte = el.getAttribute("MAXBYTE");
				return doError(el,TOO_LONG);
			}
		}

		if (el.getAttribute("OPTION") != null && el.value != "") {
			if (!funcs[el.getAttribute("OPTION")](el)) return false;
		}
	}

	return true;
}

function doError(el,type,action) {
	var pattern = /{([a-zA-Z0-9_]+)\+?([가-힣]{2})?}/;
	var name = (hname = el.getAttribute("HNAME")) ? hname : el.getAttribute("NAME");
	pattern.exec(type);
	var tail = (RegExp.$2) ? josa(eval(RegExp.$1),RegExp.$2) : "";
	alert(type.replace(pattern,eval(RegExp.$1) + tail));
	if (action == "sel") {
		el.select();
	} else if (action == "del") {
		el.value = "";
	}
	el.focus();
	return false;
} 

/// 특수 패턴 검사 함수 매핑 ///
var funcs = new Array();
funcs['email'] = isValidEmail;
funcs['phone'] = isValidPhone;
funcs['userid'] = isValidUserid;
funcs['hangul'] = hasHangul;
funcs['number'] = isNumeric;
funcs['engonly'] = alphaOnly;
funcs['jumin'] = isValidJumin;
funcs['bizno'] = isValidBizNo;

/// 패턴 검사 함수들 ///
function isValidEmail(el) {
	var pattern = /^[_a-zA-Z0-9-\.]+@[\.a-zA-Z0-9-]+\.[a-zA-Z]+$/;
	return (pattern.test(el.value)) ? true : doError(el,NOT_VALID);
}

function isValidUserid(el) {
	var pattern = /^[a-zA-Z]{1}[a-zA-Z0-9_]{4,11}$/;
	return (pattern.test(el.value)) ? true : doError(el,"{name+은는} 5자이상 12자 미만이어야 하고,\n 영문,숫자, _ 문자만 사용할 수 있습니다");
}

function hasHangul(el) {
	var pattern = /[가-힣]/;
	return (pattern.test(el.value)) ? true : doError(el,"{name+은는} 반드시 한글을 포함해야 합니다");
}

function alphaOnly(el) {
	var pattern = /^[a-zA-Z]+$/;
	return (pattern.test(el.value)) ? true : doError(el,NOT_VALID);
}

function isNumeric(el) {
	var pattern = /^[0-9]+$/;
	return (pattern.test(el.value)) ? true : doError(el,"{name+은는} 반드시 숫자로만 입력해야 합니다");
}

function isValidJumin(el) {
	var pattern = /^([0-9]{6})-?([0-9]{7})$/; 
	var num = el.value;
	if (!pattern.test(num)) return doError(el,NOT_VALID); 
	num = RegExp.$1 + RegExp.$2;

	var sum = 0;
	var last = num.charCodeAt(12) - 0x30;
	var bases = "234567892345";
	for (i=0; i<12; i++) {
	if (isNaN(num.substring(i,i+1))) return doError(el,NOT_VALID);
		sum += (num.charCodeAt(i) - 0x30) * (bases.charCodeAt(i) - 0x30);
	}
	var mod = sum % 11;
	return ((11 - mod) % 10 == last) ? true : doError(el,NOT_VALID);
}

function isValidBizNo(el) { 
	var pattern = /([0-9]{3})-?([0-9]{2})-?([0-9]{5})/; 
	var num = el.value;
	if (!pattern.test(num)) return doError(el,NOT_VALID); 
		num = RegExp.$1 + RegExp.$2 + RegExp.$3;
		var cVal = 0; 
	for (var i=0; i<8; i++) { 
		var cKeyNum = parseInt(((_tmp = i % 3) == 0) ? 1 : ( _tmp  == 1 ) ? 3 : 7); 
		cVal += (parseFloat(num.substring(i,i+1)) * cKeyNum) % 10; 
	} 
	var li_temp = parseFloat(num.substring(i,i+1)) * 5 + '0'; 
	cVal += parseFloat(li_temp.substring(0,1)) + parseFloat(li_temp.substring(1,2)); 
	return (parseInt(num.substring(9,10)) == 10-(cVal % 10)%10) ? true : doError(el,NOT_VALID); 
}

function isValidPhone(el) {
	var pattern = /^([0]{1}[0-9]{1,2})-?([1-9]{1}[0-9]{2,3})-?([0-9]{4})$/;
	if (pattern.exec(el.value)) {
		if(RegExp.$1 == "011" || RegExp.$1 == "016" || RegExp.$1 == "017" || RegExp.$1 == "018" || RegExp.$1 == "019") {
			el.value = RegExp.$1 + "-" + RegExp.$2 + "-" + RegExp.$3;
		}
		return true;
	} else {
		return doError(el,NOT_VALID);
	}
} 