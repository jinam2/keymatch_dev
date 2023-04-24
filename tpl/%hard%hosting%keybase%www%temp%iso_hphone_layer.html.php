<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 10:01:17 */
function SkyTpl_Func_2459305874 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script type="text/javascript">
<!--
var ajax			= new GLM.AJAX();
function check_phone_ajax(per_cell)
{
	iso_hphone_Obj		= document.getElementById("iso_hphone_layer");


	if ( navigator.userAgent.indexOf('MSIE') != -1 || navigator.userAgent.indexOf('Firefox') != -1 )
	{
		Height_Tmp	= document.documentElement.scrollTop;
		Left_Tmp	= document.documentElement.scrollWidth;
	}
	else
	{
		Height_Tmp	= document.body.scrollTop + 50;
		Left_Tmp	= document.body.scrollWidth;
	}

	Height_Box	= iso_hphone_Obj.style.height;
	Height_Box	= Height_Box.replace("px","");
	Height_Box	= parseInt(Height_Box);

	Width_Box	= iso_hphone_Obj.style.width;
	Width_Box	= Width_Box.replace("px","");
	Width_Box	= parseInt(Width_Box);

	// 현재 박스창 구하기
	if ( window.innerHeight == undefined )
	{
		Now_Window_Height = document.documentElement.offsetHeight;
	}
	else
	{
		Now_Window_Height = window.innerHeight;
	}

	Height_Tmp	= Height_Tmp + ( Now_Window_Height / 1.1 ) - ( Height_Box / 1.1 );
	Left_Tmp	= (Left_Tmp / 2) - (Width_Box / 2);

	//alert(Height_Tmp);
	//alert(Left_Tmp);

	iso_hphone_Obj.style.top	= Height_Tmp + "px";
	iso_hphone_Obj.style.left	= Left_Tmp + "px";

	if( iso_hphone_Obj.style.display == 'none' )
	{
		if( document.happy_member_reg.iso_hphone.value == '' || document.happy_member_reg.iso_hphone.value == 'n' || document.happy_member_reg.user_hphone_original.value != per_cell )
		{
			ajax.callPage(
				'happy_member_ajax_check_phone.php?&per_cell='+per_cell,
				function(response)
				{
					//alert(response);
					ajax_receive_message = response.split("___CUT___");

					if(ajax_receive_message[0] == 'success')
					{
						iso_hphone_Obj.style.display = "";
						document.getElementById("iso_hphone_layer").innerHTML = ajax_receive_message[1];
						iso_hphone_Obj.style.display = '';
					}
					else												//동일한 휴대폰 번호가 존재하는 경우.
					{
						alert(ajax_receive_message[0]);
						document.happy_member_reg.user_hphone.focus();
						return false;
					}
				}
			);
		}
	}
	else
	{
		iso_hphone_Obj.style.display = "none";
	}
}


function check_phone_confirm()
{
	per_cell				= document.iso_check_form.per_cell.value;
	mode					= document.iso_check_form.mode.value;
	input_confirm_number	= document.iso_check_form.input_confirm_number.value;

	// document.documentElement.scrollTop

	ajax.callPage(
		'happy_member_ajax_check_phone_confirm.php?&per_cell='+per_cell+'&mode='+mode+'&input_confirm_number='+input_confirm_number,
		function(response)
		{
			//alert(response);
			ajax_receive_message = response.split("___CUT___");

			if(ajax_receive_message[0] == 'success')
			{
				iso_hphone_Obj.style.display = "none";
				alert("휴대폰 인증에 성공 하였습니다. ^^");

				document.happy_member_reg.iso_hphone.value					= 'y';
				document.happy_member_reg.user_hphone_check.value			= input_confirm_number;
				document.happy_member_reg.user_hphone_original.value			= per_cell;
				document.getElementById('iso_button_hphone').style.display	= 'none';
			}
			else												//동일한 휴대폰 번호가 존재하는 경우.
			{
				alert(ajax_receive_message[0]);
				document.iso_check_form.input_confirm_number.focus();
				return false;
			}
		}
	);
}
//-->
</script>


<div  id="iso_hphone_layer" style="display:none; position:absolute;  width:350px;height:250px; z-index:100; ;border:2px solid #747474; background:#ffffff;"></div>
<? }
?>