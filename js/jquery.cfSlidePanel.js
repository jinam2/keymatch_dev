// 紐⑤컮\xEC씪 湲곌린\xEC뿉\xEC꽌 \xED꽣移\x98 swipe(\xED뵆由ы궧)濡\x9C, PC\xEC뿉\xEC꽌\xEB뒗 mousemove濡\x9C \xED뙣\xEB꼸\xEC쓣 醫뚯슦 \xEC뒳\xEB씪\xEC씠\xEB뵫 \xED븷 \xEC닔 \xEC엳寃\x8C \xED빐二쇰뒗 plugin \xEC엯\xEB땲\xEB떎.

;(function($, window, document, undefined) {
	
	// plugin \xEC씠由\x84, default option \xEC꽕\xEC젙
	var pluginName = 'cfSlidePanel',
		defaults = {
			speed: 400,				// \xEC뒳\xEB씪\xEC씠\xEB뵫 \xEC냽\xEB룄, 諛由ъ꽭而⑤뱶 \xEB떒\xEC쐞\xEC쓽 \xEC닽\xEC옄 \xEB삉\xEB뒗 jQuery.animate()\xEC뿉 \xEC궗\xEC슜媛\xEB뒫\xED븳 'slow', 'fast' \xEB벑 臾몄옄\xEC뿴
			touchMoveLength: 60,	// px\xEB떒\xEC쐞, 理쒖냼 \xEC뼹留덈쭔\xED겮 touchmove瑜\xBC \xED빐\xEC빞 \xED뙣\xEB꼸\xEC쓣 \xEC\x9B吏곸씪吏 湲곗\xA4\xEC씠 \xEB릺\xEB뒗 湲몄씠
			getIndex: null,			// navigator瑜\xBC 留뚮뱾 \xEB븣 \xEC궗\xEC슜\xED븷 \xEC닔 \xEC엳\xEB뒗 index瑜\xBC \xEC뼸\xEC뼱\xEB궡\xEB뒗 callback
									// function(index) { alert(index); } \xEC\x99 媛숈씠 \xEB벑濡앺븯硫\xB4 \xEC뒳\xEB씪\xEC씠\xEB뱶 \xEC븷\xEB땲硫붿씠\xEC뀡\xEC뿉 \xEB\x8C\xED븳 callback\xEC쑝濡\x9C \xED뙣\xEB꼸\xEC쓽 index瑜\xBC \xEC뼸\xEC쓣 \xEC닔 \xEC엳\xEC쓬(zero based index),
			prevBtn: '.prev',
			nextBtn: '.next'
		};
		
	// \xED꽣移\x98 愿\xEB젴 蹂\xEC닔
	var onTouching = false, startMarginLeft = 0, startX = 0, curX = 0, prevCurX = 0;
		
	// plugin constructor
	function Plugin(element, options) {
		this.element = element;
		this.options = $.extend({}, defaults, options);
		
		this._defaults = defaults;
		this._name = pluginName;
		
		this.init();
	}
	
	// initialization logic
	Plugin.prototype.init = function() {
		
		var $this = $(this.element),
			options = this.options,
			panels = $this.find('.panel'),
			panelLength = panels.length,
			panelWidth = $this.width();
			
		// \xEC씪\xEB떒 媛由ш퀬 ul \xEC깮\xEC꽦 \xED썑 li\xEC뿉 \xEB꽔\xEC쓬
		panels.hide();
		
		// ul \xEC깮\xEC꽦 \xED썑 container\xEC뿉 append
		var ul = $('<ul />', {
						'class': 'cf-slide-panel-ul'
					}).css({
						listStyle: 'none',
						margin: 0,
						padding: 0,
						width: panelWidth * panelLength
					}).appendTo(this.element);
		
		// 媛\x81 \xED럹\xEC씠吏\xEB뱾\xEC쓣 li\xEC뿉 append
		panels.each(function(index) {
			$('<li />', {
				'class': 'cf-slide-panel-item',
				html: this,
				'data-index': index
			}).css({
				'float': 'left',
				width: panelWidth
			}).appendTo(ul);
		});
		
		// ul, li \xEC옉\xEC뾽\xEC씠 \xEB떎 \xEB걹\xEB굹硫\xB4 \xEB떎\xEC떆 蹂댁씠寃\x8C \xED븿
		panels.show();
		
		sessionStorage['cfSlidePanel' + $this.attr('id') + 'CurrentIndex'] = undefined;
		
		// cfSlider
		makeCfSlider($this, options, panelWidth);
		
		
		// \xED룿\xEC쓣 媛濡\x9C/\xEC꽭濡\x9C \xEC쟾\xED솚\xED뻽\xEC쓣 寃쎌슦  panel \xEB꼫踰꾩쓽 px 媛믪씠 諛붾뚮\xAF濡\x9C 怨꾩궛\xEC쓣 \xEC깉濡\x9C \xED빐\xEC꽌 cfSlider瑜\xBC \xEB떎\xEC떆 留뚮뱾\xEC뼱以\x8C - pc\xEC뿉\xEC꽌\xEC쓽 \xED샇\xED솚\xEC쓣 \xEC쐞\xED빐 orientationchange \xEC씠踰ㅽ듃 \xEB\x8C\xEC떊 resize \xEC씠踰ㅽ듃 \xEC궗\xEC슜
		$(window).bind('resize', function() {
			
			setTimeout(function() {
				
				var panelWidth = $this.width();
					
				$this.find('div.cf-slide-panel-container').css({
					width: panelWidth
				});
				
				$this.find('li.cf-slide-panel-item').css({
					width: panelWidth
				});
				
				// cfSlider - orientation\xEC씠 諛붾뚮㈃ panelWidth媛 諛붾뚭린 \xEB븣臾몄뿉 cfSlider瑜\xBC \xEB떎\xEC떆 留뚮뱾\xEC뼱以\x8C
				makeCfSlider($this, options, panelWidth);
				
			}, 100);	// orientation\xEC씠 諛붾뚭퀬 \xEB궃 \xED썑 \xEC빟媛꾩쓽 \xEC떆媛꾩뿬\xEC쑀瑜\xBC \xEB몢怨\xA0 \xEC떎\xED뻾
			
		});
		
	};
	
	// cfSlider 留뚮뱾湲\xB0
	function makeCfSlider($this, options, panelWidth) {
		
		$this.data('plugin_cfSlider', '');		// 珥덇린\xED솕
		$this.cfSlider({
			speed: options.speed,
			container: '.cf-slide-panel-ul',
			item: '.cf-slide-panel-item',
			prevEventType: 'cf-slide-panel-prev',
			nextEventType: 'cf-slide-panel-next',
			prevBtn: options.prevBtn,
			nextBtn: options.nextBtn,
			callback: function(item) {
				sessionStorage['cfSlidePanel' + $this.attr('id') + 'CurrentIndex'] = $(item).data('index');
				
				if (typeof options.getIndex === 'function') {
					options.getIndex($(item).data('index'));
				}
			}
		}).each(function() {
			if (sessionStorage['cfSlidePanel' + $this.attr('id') + 'CurrentIndex'] != undefined) {
				$this.find('.cf-slide-panel-ul').css({
					marginLeft: -(panelWidth * (parseInt(sessionStorage['cfSlidePanel' + $this.attr('id') + 'CurrentIndex']) + 1)) + 'px'
				});
			}
			
			// cfSlider \xEC깮\xEC꽦 \xED썑 touchmove listener \xEB벑濡\x9D
			var cfSlider = $this.data('plugin_cfSlider');
			
			$this.unbind('.cfSlidePanel');	// cfSlidePanel 愿\xEB젴 \xEC씠踰ㅽ듃瑜\xBC \xEB벑濡앺븯湲\xB0 \xEC쐞\xED빐 湲곗〈 \xEC씠踰ㅽ듃 珥덇린\xED솕
			$this.bind('mousedown.cfSlidePanel touchstart.cfSlidePanel', function(e) {
				if (onTouching) {
          return;
        }
        
				if (cfSlider.container.is(':animated')) {
					return;
				}
				
				onTouching = true;
				startMarginLeft = parseInt(cfSlider.container.css('marginLeft'));
				startX = curX = (e.originalEvent && e.originalEvent.touches) ? e.originalEvent.touches[0].pageX : e.pageX;
				
				$this.bind('mousemove.cfSlidePanel touchmove.cfSlidePanel', {options: options}, onTouchMove);
				$this.bind('mouseup.cfSlidePanel touchend.cfSlidePanel', {cfSlider: cfSlider, options: options, elem: $this}, onTouchEnd);
			});
			
		});
		
	}
	
	// \xED꽣移\x98 swipe\xED븯怨\xA0 \xEC엳\xEB뒗 \xEB룞\xEC븞
	function onTouchMove(e) {
	  if ( ! onTouching) {
      return;
    }
    
		prevCurX = curX;
		curX = (e.originalEvent && e.originalEvent.touches) ? e.originalEvent.touches[0].pageX : e.pageX;
		
		if (Math.abs(curX - startX) > 10) {		// 10px \xEC씠\xEC긽 \xEC\x9B吏곸씠硫\xB4 onTouchMove \xEB룞\xEC옉\xEC쓣 \xED븯怨\xA0 洹몃젃吏 \xEC븡\xEC쑝硫\xB4 釉뚮씪\xEC슦\xEC\xA0 湲곕낯 \xEB룞\xEC옉
			e.preventDefault();
			
			if ($(this).find('ul.cf-slide-panel-ul').is(':animated')) {
				return;
			}
			
			var ul = $(this).find('ul.cf-slide-panel-ul'),
				marginLeft = parseInt(ul.css('marginLeft'));
			
			ul.css('marginLeft', marginLeft - (prevCurX - (curX ? curX : e.pageX)));
		} else {
			return;
		}
		
			
	}
	
	// \xED꽣移\x98 swipe \xEB걹\xEB궗\xEC쓣 \xEB븣
	function onTouchEnd(e) {
		var cfSlider = e.data.cfSlider,
			options = e.data.options,
			$this = e.data.elem;
		
		if (cfSlider.container.is(':animated')) {
			return;
		}
		
		if (Math.abs(curX - startX) < options.touchMoveLength) {
			cfSlider.container.animate({
				marginLeft: startMarginLeft
			}, 'fast');
		} else if (curX > startX) {
			cfSlider.go('prev', cfSlider.container, cfSlider.marginType, cfSlider.itemSize, cfSlider.itemLength, cfSlider.options, startMarginLeft);
		} else {
			cfSlider.go('next', cfSlider.container, cfSlider.marginType, cfSlider.itemSize, cfSlider.itemLength, cfSlider.options, startMarginLeft);
		}
		$this.unbind('mousemove.cfSlidePanel touchmove.cfSlidePanel mouseup.cfSlidePanel touchend.cfSlidePanel');
		
		onTouching = false;
	}
	
	// jQuery 媛앹껜\xEC\x99 element\xEC쓽 data\xEC뿉 plugin\xEC쓣 \xEB꽔\xEC쓬
	$.fn[pluginName] = function(options) {
		
		return this.each(function() {
			
			if ( ! $.data(this, 'plugin_' + pluginName)) {
				$.data(this, 'plugin_' + pluginName, new Plugin(this, options));
			}
			
		});
		
	};
	
})(jQuery, window, document);

