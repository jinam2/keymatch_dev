// 학력
function academy_tr_row_add(num_id)
{
	var $clone = $('.academy_tr_clone').clone(true).removeClass('academy_tr_clone');

	var max = 0;
	var last_index = 0;
	$('#table_academy').find('tr').each(function(){
		var id = parseInt($(this).attr('id'));
		if (id >= max){
			max = id;
		}

		if( $(this).index() > 0 )
		{
			last_index = $(this).index();
		}
	});

	new_num		= parseInt(max)+1;
	new_new_id	= new_num;
	$clone.attr('id', parseInt(max)+1);
	$clone = str_replace('_0',"_" + new_num,$clone.html());
	if( new_num == 1 )
	{
		$clone = str_replace('%BTN_HTML%', "<input type=\"button\" value=\"+ 추가하기\" class=\"btn_academy_add\">",$clone);
	}
	else
	{
		$clone = str_replace('%BTN_HTML%', "<input type=\"button\" value=\"- 삭제하기\" class=\"btn_academy_del\">",$clone);
	}
	$('#table_academy').find('tr:last').after("<tr id=\"" + new_num + "\">" + $clone + "</tr>");
}

// 경력
function career_tr_row_add(num_id)
{
	var $clone = $('.career_tr_clone').clone(true).removeClass('career_tr_clone');

	var max = 0;
	var last_index = 0;
	$('#table_career').find('div').each(function(){
		var id = parseInt($(this).attr('id'));
		if (id >= max){
			max = id;
		}

		if( $(this).index() > 0 )
		{
			last_index = $(this).index();
		}
	});

	new_num		= parseInt(max)+1;
	new_new_id	= new_num;
	$clone.attr('id', parseInt(max)+1);
	$clone = str_replace('_0',"_" + new_num,$clone.html());
	if( new_num == 1 )
	{
		$clone = str_replace('%BTN_HTML%', "<a href=\"javascript:void(0);\" class=\"btn_career_add\">+ 추가하기</a>",$clone);
	}
	else
	{
		$clone = str_replace('%BTN_HTML%', "<a href=\"javascript:void(0);\" class=\"btn_career_del\">- 삭제하기</a>",$clone);
	}
	$('#table_career').find('div:last').after("<div id=\"" + new_num + "\">" + $clone + "</div>");
}

$(document).ready(function() {
	// 채용등록
	$("select[name^=type1]").change(function() {
		console.log($(this).val());
		var now_val = parseInt($(this).val());
		var vkey = type2_key[now_val];
		var vval = type2_val[now_val];

		var $out_cate2 = $("select[name^=type_sub1]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR1 + "</option>");

		var $out_cate3 = $("select[name^=type_sub_sub1]");
		$("option",$out_cate3).remove();
		$out_cate3.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});
	// 채용등록
	$("select[name^=type_sub1]").change(function() {
		//console.log($(this).val());
		var vkey = type3_key[now_val];
		var vval = type3_val[now_val];

		var $out_cate2 = $("select[name^=type_sub_sub1]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});
	// 채용등록
	$("select[name^=type2]").change(function() {
		//console.log($(this).val());
		var now_val = parseInt($(this).val());
		var vkey = type2_key[now_val];
		var vval = type2_val[now_val];

		var $out_cate2 = $("select[name^=type_sub2]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR1 + "</option>");

		var $out_cate3 = $("select[name^=type_sub_sub2]");
		$("option",$out_cate3).remove();
		$out_cate3.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});
	// 채용등록
	$("select[name^=type_sub2]").change(function() {
		//console.log($(this).val());
		var now_val = parseInt($(this).val());
		var vkey = type3_key[now_val];
		var vval = type3_val[now_val];

		var $out_cate2 = $("select[name^=type_sub_sub2]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});
	// 채용등록
	$("select[name^=type3]").change(function() {
		//console.log($(this).val());
		var now_val = parseInt($(this).val());
		var vkey = type2_key[now_val];
		var vval = type2_val[now_val];

		var $out_cate2 = $("select[name^=type_sub3]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR1 + "</option>");

		var $out_cate3 = $("select[name^=type_sub_sub3]");
		$("option",$out_cate3).remove();
		$out_cate3.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});
	// 채용등록
	$("select[name^=type_sub3]").change(function() {
		//console.log($(this).val());
		var now_val = parseInt($(this).val());
		var vkey = type3_key[now_val];
		var vval = type3_val[now_val];

		var $out_cate2 = $("select[name^=type_sub_sub3]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});

	// 이력서
	$("select[name^=type1]").change(function() {
		//console.log($(this).val());
		var now_val = parseInt($(this).val());
		var vkey = type2_key[now_val];
		var vval = type2_val[now_val];

		var $out_cate2 = $("select[name^=type_sub1]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR1 + "</option>");

		var $out_cate3 = $("select[name^=type_sub_sub1]");
		$("option",$out_cate3).remove();
		$out_cate3.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});

	// 이력서
	$("select[name^=type_sub1]").change(function() {
		//console.log($(this).val());
		var now_val = parseInt($(this).val());
		var vkey = type3_key[now_val];
		var vval = type3_val[now_val];

		var $out_cate2 = $("select[name^=type_sub_sub1]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});

	// 이력서
	$("select[name^=type2]").change(function() {
		//console.log($(this).val());
		var now_val = parseInt($(this).val());
		var vkey = type2_key[now_val];
		var vval = type2_val[now_val];

		var $out_cate2 = $("select[name^=type_sub2]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR1 + "</option>");

		var $out_cate3 = $("select[name^=type_sub_sub2]");
		$("option",$out_cate3).remove();
		$out_cate3.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});

	// 이력서
	$("select[name^=type_sub2]").change(function() {
		//console.log($(this).val());
		var now_val = parseInt($(this).val());
		var vkey = type3_key[now_val];
		var vval = type3_val[now_val];

		var $out_cate2 = $("select[name^=type_sub_sub2]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});

	// 이력서
	$("select[name^=type3]").change(function() {
		//console.log($(this).val());
		var now_val = parseInt($(this).val());
		var vkey = type2_key[now_val];
		var vval = type2_val[now_val];

		var $out_cate2 = $("select[name^=type_sub3]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR1 + "</option>");

		var $out_cate3 = $("select[name^=type_sub_sub3]");
		$("option",$out_cate3).remove();
		$out_cate3.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});

	// 이력서
	$("select[name^=type_sub3]").change(function() {
		//console.log($(this).val());
		var now_val = parseInt($(this).val());
		var vkey = type3_key[now_val];
		var vval = type3_val[now_val];

		var $out_cate2 = $("select[name^=type_sub_sub3]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});

	// 이력서
	$(document).on('change', 'select[name="career_type[]"]', function(e) {
		//console.log($(this).val());
		//console.log($(this).attr("id"));
		//console.log($(this).attr("id").replace("career_type_",""));
		var now_val = parseInt($(this).val());
		var now_id = $(this).attr("id").replace("career_type_","");
		var vkey = type2_key[now_val];
		var vval = type2_val[now_val];

		var $out_cate2 = $('select[id="career_type_sub_' + now_id + '"]');
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR1 + "</option>");

		var $out_cate3 = $('select[id="career_type_sub_sub_' + now_id + '"]');
		$("option",$out_cate3).remove();
		$out_cate3.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});

	// 이력서
	$(document).on('change', 'select[name="career_type_sub[]"]', function(e) {
		//console.log($(this).val());
		var now_val = parseInt($(this).val());
		var now_id = $(this).attr("id").replace("career_type_sub","");
		var vkey = type3_key[now_val];
		var vval = type3_val[now_val];

		var $out_cate2 = $('select[id="career_type_sub_sub_' + now_id + '"]');
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});

	// 검색
	$("select[name=search_type]").change(function() {
		//console.log($(this).val());
		var now_val = parseInt($(this).val());
		var vkey = type2_key[now_val];
		var vval = type2_val[now_val];

		var $out_cate2 = $("select[name^=search_type_sub]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR1 + "</option>");

		var $out_cate3 = $("select[name^=search_type_sub_sub]");
		$("option",$out_cate3).remove();
		$out_cate3.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});

	// 검색
	$("select[name=search_type_sub]").change(function() {
		//console.log($(this).val());
		var now_val = parseInt($(this).val());
		var vkey = type3_key[now_val];
		var vval = type3_val[now_val];

		var $out_cate2 = $("select[name^=search_type_sub_sub]");
		$("option",$out_cate2).remove();
		$out_cate2.append("<option value=''>" + TYPE_DEPTH_TXT_ARR2 + "</option>");

		if( vkey == undefined ) { return; }

		$.each(vkey, function(index) {
			//console.log(real_val[index]);
			$out_cate2.append("<option value='"+this+"'>"+vval[index]+"</option>");
		});
	});




	// 학력
	$(document).on('click', '.btn_academy_del', function(e) {
		e.preventDefault();
		var index = $(this).closest('tr').index();

		$(this).closest('table').find('tr').eq(index).remove();
	});

	$(document).on('click', '.btn_academy_add', function(e) {
		e.preventDefault();
		academy_tr_row_add(0);
	});

	// 경력
	$(document).on('click', '.btn_career_del', function(e) {
		e.preventDefault();
		var index = $(this).closest('div').index();

		$(this).closest('div').remove();
	});

	$(document).on('click', '.btn_career_add', function(e) {
		e.preventDefault();
		career_tr_row_add(0);
	});

	$(document).on('change', 'select[name="career_work_type[]"]', function(e) {
		e.preventDefault();
		var now_id = $(this).attr("id").replace("career_work_type_","");
		if( $(this).val() == '재직중' )
		{
			$("#career_out_" + now_id).attr("disabled", true);
		}
		else
		{
			$("#career_out_" + now_id).attr("disabled", false);
		}
	});
});