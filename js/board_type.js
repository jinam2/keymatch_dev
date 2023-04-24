// 셋팅 관련 변수 시작 //

var boardStyleTitle	= new Array();
var boardStyleValue	= new Array();

// 폼입력
var frmname			= "regiform";
var x = 0;

// input name 입력
var boardInputName	=
					new Array (
						"board_temp",
						"board_temp_list",
						"board_temp_detail",
						"board_temp_modify",
						"board_temp_regist",
						"board_temp_reply",
						"img_width",
						"mini_thumb",
						"bar_color",
						"body_color",
						"up_color",
						"down_color",
						"detail_color",
						"table_size",
						"write_point",
						"comment_point"
					);

var boardInputType	=
					new Array (
						"text",
						"text",
						"text",
						"text",
						"text",
						"text",
						"text",
						"text",
						"text",
						"text",
						"text",
						"text",
						"text",
						"text",
						"text",
						"text"
					);

boardStyleTitle[x]	= "텍스트형";
boardStyleValue[x++]	=
					new Array (
						"bbs_default.html",
						"bbs_list_text_fixed.html",
						"bbs_detail_fixed.html",
						"bbs_modify_fixed.html",
						"bbs_regist_fixed.html",
						"bbs_reply_fixed.html",
						600,
						200,
						"#222222",
						"#eaeaea",
						"#fafafa",
						"#222222",
						"#ffffff",
						"100%",
						0,
						0
					);

boardStyleTitle[x]	= "이미지+텍스트형";
boardStyleValue[x++]	=
					new Array (
						"bbs_default.html",
						"bbs_list_img_text_fixed.html",
						"bbs_detail_fixed.html",
						"bbs_modify_fixed.html",
						"bbs_regist_fixed.html",
						"bbs_reply_fixed.html",
						600,
						200,
						"#222222",
						"#eaeaea",
						"#fafafa",
						"#222222",
						"#ffffff",
						"100%",
						0,
						0
					);

boardStyleTitle[x]	= "뉴스형";
boardStyleValue[x++]	=
					new Array (
						"bbs_default.html",
						"bbs_list_img_news_fixed.html",
						"bbs_detail_new_fixed.html",
						"bbs_modify_new_fixed.html",
						"bbs_regist_new_fixed.html",
						"bbs_reply_new_fixed.html",
						600,
						200,
						"#222222",
						"#eaeaea",
						"#fafafa",
						"#222222",
						"#ffffff",
						"100%",
						0,
						0
					);

boardStyleTitle[x]	= "갤러리_대형";
boardStyleValue[x++]	=
					new Array (
						"bbs_default.html",
						"bbs_list_gall_big_fixed.html",
						"bbs_detail_fixed.html",
						"bbs_modify_fixed.html",
						"bbs_regist_fixed.html",
						"bbs_reply_fixed.html",
						600,
						200,
						"#222222",
						"#eaeaea",
						"#fafafa",
						"#222222",
						"#ffffff",
						"100%",
						0,
						0
					);

boardStyleTitle[x]	= "갤러리_중형";
boardStyleValue[x++]	=
					new Array (
						"bbs_default.html",
						"bbs_list_gall_midd_fixed.html",
						"bbs_detail_fixed.html",
						"bbs_modify_fixed.html",
						"bbs_regist_fixed.html",
						"bbs_reply_fixed.html",
						600,
						200,
						"#222222",
						"#eaeaea",
						"#fafafa",
						"#222222",
						"#ffffff",
						"100%",
						0,
						0
					);


boardStyleTitle[x]	= "갤러리_소형";
boardStyleValue[x++]	=
					new Array (
						"bbs_default.html",
						"bbs_list_gall_small_fixed.html",
						"bbs_detail_fixed.html",
						"bbs_modify_fixed.html",
						"bbs_regist_fixed.html",
						"bbs_reply_fixed.html",
						600,
						200,
						"#222222",
						"#eaeaea",
						"#fafafa",
						"#222222",
						"#ffffff",
						"100%",
						0,
						0
					);

boardStyleTitle[x]	= "자료실형";
boardStyleValue[x++]	=
					new Array (
						"bbs_default.html",
						"bbs_list_data_fixed.html",
						"bbs_detail_fixed.html",
						"bbs_modify_fixed.html",
						"bbs_regist_fixed.html",
						"bbs_reply_fixed.html",
						600,
						200,
						"#222222",
						"#eaeaea",
						"#fafafa",
						"#222222",
						"#ffffff",
						"100%",
						0,
						0
					);

boardStyleTitle[x]	= "비밀형";
boardStyleValue[x++]	=
					new Array (
						"bbs_default.html",
						"bbs_list_secret_fixed.html",
						"bbs_detail_fixed.html",
						"bbs_modify_secret_fixed.html",
						"bbs_regist_secret_fixed.html",
						"bbs_reply_secret_fixed.html",
						600,
						200,
						"#222222",
						"#eaeaea",
						"#fafafa",
						"#222222",
						"#ffffff",
						"100%",
						0,
						0
					);

boardStyleTitle[x]	= "질문과답변형";
boardStyleValue[x++]	=
					new Array (
						"bbs_default.html",
						"bbs_list_qna_fixed.html",
						"bbs_detail_fixed.html",
						"bbs_modify_qna_fixed.html",
						"bbs_regist_fixed.html",
						"bbs_reply_fixed.html",
						600,
						200,
						"#222222",
						"#eaeaea",
						"#fafafa",
						"#222222",
						"#ffffff",
						"100%",
						0,
						0
					);

boardStyleTitle[x]	= "자주하는질문형";
boardStyleValue[x++]	=
					new Array (
						"bbs_default.html",
						"bbs_list_faq_fixed.html",
						"bbs_detail_faq_fixed.html",
						"bbs_modify_faq_fixed.html",
						"bbs_regist_faq_fixed.html",
						"bbs_reply_fixed.html",
						600,
						200,
						"#222222",
						"#eaeaea",
						"#fafafa",
						"#222222",
						"#ffffff",
						"100%",
						0,
						0
					);

boardStyleTitle[x]	= "텍스트+베스트출력형";
boardStyleValue[x++]	=
					new Array (
						"bbs_default.html",
						"bbs_list_best_text_fixed.html",
						"bbs_detail_fixed.html",
						"bbs_modify_fixed.html",
						"bbs_regist_fixed.html",
						"bbs_reply_fixed.html",
						600,
						200,
						"#222222",
						"#eaeaea",
						"#fafafa",
						"#222222",
						"#ffffff",
						"100%",
						0,
						0
					);

boardStyleTitle[x]	= "갤러리+베스트출력형";
boardStyleValue[x++]	=
					new Array (
						"bbs_default.html",
						"bbs_list_best_gall_fixed.html",
						"bbs_detail_fixed.html",
						"bbs_modify_fixed.html",
						"bbs_regist_fixed.html",
						"bbs_reply_fixed.html",
						600,
						200,
						"#222222",
						"#eaeaea",
						"#fafafa",
						"#222222",
						"#ffffff",
						"100%",
						0,
						0
					);

/*
명칭을 변경하여 저장할 경우 기존게시판의 
게시판성격(B_CONF.admin_etc6) 업데이트와 기타프로그램 수정필요 - ranksa
*/


function load_boardStyle()
{
	var frm			= eval("document."+frmname+"");
	var maxLength	= boardStyleTitle.length;

	for ( i=0 ; i<maxLength ; i++ )
	{
		frm.board_type.options[frm.board_type.length]	= new Option(boardStyleTitle[i],boardStyleTitle[i],false);
	}
}


function call_boardStyle()
{
	var frm			= eval( "document."+ frmname +"" );
	var maxLength	= boardInputName.length;
	var no			= frm.board_type.selectedIndex;

	if ( no != 0)
	{
		no--;
		for ( i=0 ; i<maxLength ; i++ )
		{
			if ( boardInputType[i] == "text" )
			{
				obj						= eval( "document.getElementsByName('"+ boardInputName[i]+"')[0]" );
				if( obj != undefined )
				{
	 				obj.value			= boardStyleValue[no][i];
				}
			}

			else if ( boardInputType[i] == "select" )
			{
				obj					= eval( "frm."+ boardInputName[i] +"" );
				obj.selectedIndex	= boardStyleValue[no][i];
			}
		}
	}
}


