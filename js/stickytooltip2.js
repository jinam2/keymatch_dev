/* Sticky Tooltip script (v1.0)
* Created: Nov 25th, 2009. This notice must stay intact for usage 
* Author: Dynamic Drive at http://www.dynamicdrive.com/
* Visit http://www.dynamicdrive.com/ for full source code
*/

//http://www.dynamicdrive.com/dynamicindex5/stickytooltip2.htm


var stickytooltip2={
	tooltipoffsets: [20, -30], //additional x and y offset from mouse cursor for tooltips
	fadeinspeed: 200, //duration of fade effect in milliseconds
	rightclickstick: true, //sticky tooltip when user right clicks over the triggering element (apart from pressing "s" key) ?
	stickybordercolors: ["black", "darkred"], //border color of tooltip depending on sticky state
	stickynotice1: ["정지시 \"S키\"", "나 오른쪽마우스를", "클릭하세요"], //customize tooltip status message
	stickynotice2: "툴팁을 숨기려면 상자밖을 클릭하세요.", //customize tooltip status message

	//***** NO NEED TO EDIT BEYOND HERE

	isdocked: false,

	positiontooltip:function($, $tooltip, e){
		var x=e.pageX+this.tooltipoffsets[0], y=e.pageY+this.tooltipoffsets[1]
		var tipw=$tooltip.outerWidth(), tiph=$tooltip.outerHeight(), 
		x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(stickytooltip2.tooltipoffsets[0]*2) : x
		y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
		$tooltip.css({left:x, top:y})
	},
	
	showbox:function($, $tooltip, e){
		$tooltip.fadeIn(this.fadeinspeed)
		this.positiontooltip($, $tooltip, e)
	},

	hidebox:function($, $tooltip){
		if (!this.isdocked){
			$tooltip.stop(false, true).hide()
			$tooltip.css({borderColor:'black'}).find('.stickystatus2:eq(0)').css({background:this.stickybordercolors[0]})
		}
	},

	docktooltip:function($, $tooltip, e){
		this.isdocked=true
		$tooltip.css({borderColor:'darkred'}).find('.stickystatus2:eq(0)').css({background:this.stickybordercolors[1]})
	},


	init:function(targetselector, tipid){
		jQuery(document).ready(function($){
			var $targets=$(targetselector)
			var $tooltip=$('#'+tipid).appendTo(document.body)
			if ($targets.length==0)
				return
			var $alltips=$tooltip.find('div.atip')
			if (!stickytooltip2.rightclickstick)
				stickytooltip2.stickynotice1[1]=''
			stickytooltip2.stickynotice1=stickytooltip2.stickynotice1.join(' ')
			stickytooltip2.hidebox($, $tooltip)
			$targets.bind('mouseenter', function(e){
				$alltips.hide().filter('#'+$(this).attr('data-tooltip')).show()
				stickytooltip2.showbox($, $tooltip, e)
			})
			$targets.bind('mouseleave', function(e){
				stickytooltip2.hidebox($, $tooltip)
			})
			$targets.bind('mousemove', function(e){
				if (!stickytooltip2.isdocked){
					stickytooltip2.positiontooltip($, $tooltip, e)
				}
			})
			$tooltip.bind("mouseenter", function(){
				stickytooltip2.hidebox($, $tooltip)
			})
			$tooltip.bind("click", function(e){
				e.stopPropagation()
			})
			$(this).bind("click", function(e){
				if (e.button==0){
					stickytooltip2.isdocked=false
					stickytooltip2.hidebox($, $tooltip)
				}
			})
			$(this).bind("contextmenu", function(e){
				if (stickytooltip2.rightclickstick && $(e.target).parents().andSelf().filter(targetselector).length==1){ //if oncontextmenu over a target element
					stickytooltip2.docktooltip($, $tooltip, e)
					return false
				}
			})
			$(this).bind('keypress', function(e){
				var keyunicode=e.charCode || e.keyCode
				if (keyunicode==115){ //if "s" key was pressed
					stickytooltip2.docktooltip($, $tooltip, e)
				}
			})
		}) //end dom ready
	}
}

//stickytooltip2.init("targetElementSelector", "tooltipcontainer")
stickytooltip2.init("*[data-tooltip]", "mystickytooltip2")