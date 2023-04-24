
function change_sig1() {
	
	this.myform.msend_signature.value = this.sighidden.sig1.value;
}

function change_sig2() {
	
	this.myform.msend_signature.value = this.sighidden.sig2.value;
}

function change_sig3() {
	
	this.myform.msend_signature.value = this.sighidden.sig3.value;
}

function init(){
myEditor.document.designMode = "On";
//document.myform.msend_to.focus();
//return;
} 


function EditExec(cmd) {
 if (document.all['myEditor'].style.display == "block")
 {
 myEditor.focus();
 edRange = myEditor.document.selection.createRange();
 edRange.execCommand(cmd);
 return;
 }
}

function EditExec2(cmd, value) {
 if (document.all['myEditor'].style.display == "block")
 {
   myEditor.focus();
   edRange = myEditor.document.selection.createRange();
   edRange.execCommand(cmd,false,value);
   return;
   }
}

function EditExec3(cmd, value) {
var index = value.selectedIndex;
var argv2 = value.options[index].value;
EditExec2(cmd, argv2);
return;
}
// 텍스트 편집
function viewhtml() {
document.myform.msend_content.value = myEditor.document.body.innerHTML;
document.all['msend_content'].style.display = "block";
document.all['myEditor'].style.display = "none";
}
//브라우져로 보기
function viewtext() {
myEditor.document.body.innerHTML= document.myform.msend_content.value;
document.all['msend_content'].style.display = "none";
document.all['myEditor'].style.display = "block";
return;
}

function SendForm() {
	if (document.myform.msend_content.value == ""){
		document.myform.msend_content.value = myEditor.document.body.innerHTML;
		document.myform.submit();
	}
	else {
	document.myform.submit();
	}
return;
}

function pastereplay() {

	if (confirm('원본 메세지의 내용을 인용하겠습니까?')) {
	document.myform.msend_content.value = document.sighidden.sig4.value;
	myEditor.document.body.innerHTML= document.myform.msend_content.value;
	}
return;
}
function copytext() {

	if (confirm('원본 템플릿 내용을 가져오시겠습니까?')) {
	document.myform.msend_content.value = document.myform.content.value;
	myEditor.document.body.innerHTML= document.myform.msend_content.value;
	}
return;
}



