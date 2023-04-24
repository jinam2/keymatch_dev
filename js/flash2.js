function FlashMainbody(Ftrans,wid,hei) {
	
	mainbody = "<embed src='"+ Ftrans +"' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='"+ wid +"' height='"+ hei +"' wmode='Transparent'></embed>"
	

	//document.body.innerHTML = mainbody;
	document.write(mainbody);
	return;
}

function mapselect(menuName){
	var main_url = '';
	if(menuName=="m1"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=10"; //인천
	}else if(menuName=="m2"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guzic_arealist.html&guzic_si=28"; //강원
	}else if(menuName=="m3"){ //플래쉬에서 입력된 변수값
		location.href= "html_file.php?file=guzic_arealist.html&guzic_si=29"; //서울
	}else if(menuName=="m4"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=11"; //경기
	}else if(menuName=="m5"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=4"; //충북
	}else if(menuName=="m6"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=6"; //충남
	}else if(menuName=="m7"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=23"; //대전
	}else if(menuName=="m8"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=25"; //경북
	}else if(menuName=="m9"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=1"; //대구
	}else if(menuName=="m10"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=27"; //전북
	}else if(menuName=="m11"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=22"; //울산
	}else if(menuName=="m12"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=24"; //경남
	}else if(menuName=="m13"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=20"; //광주
	}else if(menuName=="m14"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=7"; //부산
	}else if(menuName=="m15"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=26"; //전남
	}else if(menuName=="m16"){ //플래쉬에서 입력된 변수값
		location.href="html_file.php?file=guzic_arealist.html&guzic_si=3"; //재주
	}else{
		alert('페이지를 찾을 수 없습니다.'); //해당변수가 없을시 메시지출력
	}
}