if(typeof document.compatMode!='undefined'&&document.compatMode!='BackCompat'){
	cot_t1_DOCtp="_top:expression(document.documentElement.scrollTop+document.documentElement.clientHeight-this.clientHeight);_left:expression(document.documentElement.scrollLeft + document.documentElement.clientWidth - offsetWidth);}";
}
else{
	cot_t1_DOCtp="_top:expression(document.body.scrollTop+document.body.clientHeight-this.clientHeight);_left:expression(document.body.scrollLeft + document.body.clientWidth - offsetWidth);}";
}
var menu_bodyCSS='* html {background:#fff1b8;}';
var menu_fixedCSS='#menu_fixed{position:fixed;';
var menu_fixedCSS=menu_fixedCSS+'_position:absolute;';
var menu_fixedCSS=menu_fixedCSS+'z-index:999;';
var menu_fixedCSS=menu_fixedCSS+'width:100%;';
var menu_fixedCSS=menu_fixedCSS+'bottom:-1px;';
var menu_fixedCSS=menu_fixedCSS+'right:0px;';
var menu_fixedCSS=menu_fixedCSS+'clip:rect(0 100% 100% 0);';
var menu_fixedCSS=menu_fixedCSS+cot_t1_DOCtp;
document.write('<style type="text/css">'+menu_bodyCSS+menu_fixedCSS+'</style>');