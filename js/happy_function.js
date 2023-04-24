//등록버튼 여러번 클릭으로 중복등록 방지
function btn_change(btn1,btn2)
{
	if (btn1 != undefined && btn1 != "")
	{
		if (document.getElementsByName(btn1) != undefined)
		{
			var al_langth	= document.getElementsByName(btn1).length;
			for (var i=0; i<al_langth; i++)
			{
				document.getElementsByName(btn1)[i].style.display='none';
				if (btn2 != undefined && btn2 != "")
				{
					if (document.getElementsByName(btn2) != undefined)
					{
						document.getElementsByName(btn2)[i].style.display='';
					}
				}
			}
		}
	}
}

// 클립보드로 문자열 복사하기
// ex1) happy_clipboard_copy_str('복사할문자열');
// ex2) happy_clipboard_copy_str(document.getElementById('txt_area').value);
function happy_clipboard_copy_str(str)
{
	try
	{
		if ( document.getElementById('happy_copy_input_area') == undefined )
		{
			var obj		= document.createElement('input');
			obj.setAttribute('type','text');
			obj.setAttribute('id','happy_copy_input_area');
			obj.setAttribute('value','');
			obj.style.position='absolute';
			obj.style.top='-2000px';

			document.body.appendChild(obj);
		}


		document.getElementById('happy_copy_input_area').value	= str;
		document.getElementById('happy_copy_input_area').select();

		document.execCommand('copy');
		alert("클립보드에 복사되었습니다.\n붙여넣기 혹은 단축키(Ctrl+V) 를 이용하세요.");
	}
	catch(e)
	{
		alert('클립보드로 복사를 실패 하였습니다.');
	}
}