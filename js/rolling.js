var RollingList = function (id, tagType, liHeight, gabSpeed, rollSpeed, startspeed)
{

	var listObj		= document.getElementById(id);
	var nowCnt		= 0;
	var movingCnt	= 0;
	var maxCnt		= 10; 

	this.init = function ()
	{
		try
		{
			listObj.className = "rolling_list_area";
		}
		catch (e)
		{
			alert("'" +  id + "' is not elements");
			return;
		}

		listObj.style.height = liHeight + "px";
		var t = setTimeout(listObj.id + ".seting()", startspeed);
	}

	this.seting = function ()
	{
		var ulObj = listObj.getElementsByTagName(tagType)[0];
		var liObj = ulObj.getElementsByTagName("LI");
		maxCnt = liObj.length;
		ulObj.insertBefore(liObj[0].cloneNode(true), liObj[maxCnt-1].nextSibling);

		if(maxCnt>0)
		{
			this.show();
		}
	}

	this.show = function ()
	{
		if ( maxCnt == nowCnt )
		{
			nowCnt		= 0;
			movingCnt	= 0;
			listObj.getElementsByTagName(tagType)[0].style.top = "0px";
		}

		nowCnt++;
		var t = setTimeout(listObj.id + ".motion()", gabSpeed);
	}

	this.motion = function ()
	{
		//movingCnt = movingCnt + 4;
		movingCnt = movingCnt + 1;
		if (movingCnt > (liHeight * nowCnt))
		{
			movingCnt = liHeight * nowCnt;
			this.show();
		}
		else
		{
			listObj.getElementsByTagName(tagType)[0].style.top= "-" + movingCnt + "px";
			var t = setTimeout(listObj.id + ".motion()", rollSpeed);
		}
	}	
}