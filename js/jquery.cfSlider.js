

// cfSlider\xEC쓽 \xEC옉\xEB룞 諛⑹떇\xEC쓣 direction\xEC씠 horizontal\xEC씤 寃쎌슦\xEC뿉 \xEB\x8C\xED빐 \xEC꽕紐낅뱶由щ㈃(媛濡\x9C \xEC뒳\xEB씪\xEC씠\xEB뱶, direction\xEC씠 vertical\xEC씠硫\xB4 \xEC꽭濡\x9C \xEC뒳\xEB씪\xEC씠\xEB뱶)
// \xEC븘\xEC씠\xED뀥\xEB뱾\xEC쓣 媛먯떥怨\xA0 \xEC엳\xEB뒗 container\xEC쓽 margin-left 媛믪쓣 議곗젅\xED빐\xEC꽌
// margin-left瑜\xBC \xEC옉寃뚰븯硫\xB4 \xEC븘\xEC씠\xED뀥\xEB뱾\xEC씠 \xEC쇊履쎌쑝濡\x9C \xEC\x9B吏곸씠怨\xA0, margin-left瑜\xBC \xED겕寃뚰븯硫\xB4 \xEC븘\xEC씠\xED뀥\xEB뱾\xEC씠 \xEC삤瑜몄そ\xEC쑝濡\x9C \xEC\x9B吏곸씠\xEB뒗 \xEC썝由щ\xA5\xBC \xEC궗\xEC슜\xED빀\xEB땲\xEB떎.
// margin-left 媛믪쓣 議곗젅\xED븷 \xEB븣 jQuery\xEC쓽 animate 硫붿꽌\xEB뱶瑜\xBC \xEC궗\xEC슜\xED빐\xEC꽌 container媛 \xEC뒳\xEB씪\xEC씠\xEB뵫\xED븯\xEB뒗 寃껋쿂\xEB읆 蹂댁씠寃\x8C \xED빀\xEB땲\xEB떎.
// 洹몃━怨\xA0 \xEC쐞 諛⑹떇\xEC쓽 寃쎌슦 \xED쁽\xEC옱 泥\xAB 踰덉㎏ \xEC븘\xEC씠\xED뀥\xEC쓣 蹂닿퀬 \xEC엳\xEB뒗\xEB뜲 margin-left瑜\xBC \xED겕寃뚰븯嫄곕굹, 留덉\xA7留\x89 \xEC븘\xEC씠\xED뀥\xEC쓣 蹂닿퀬 \xEC엳\xEB뒗\xEB뜲 margin-left瑜\xBC \xEC옉寃뚰븯硫\xB4
// 蹂댁뿬以\x84 \xEC븘\xEC씠\xED뀥\xEC씠 \xEC뾾寃\x8C \xEB릺\xEB뒗 \xED쁽\xEC긽\xEC씠 諛쒖깮\xED븯誘濡\x9C, html肄붾뱶\xEC뿉 \xEC엳\xEB뒗 \xEC썝蹂\xB8 \xEC븘\xEC씠\xED뀥 紐⑸줉 以\x91 \xEB뮘履쎄낵 \xEC븵履쎌뿉 \xEC엳\xEB뒗 \xEC븘\xEC씠\xED뀥\xEB뱾\xEC쓣 蹂듭궗\xED븯\xEC뿬
// \xEC썝蹂\xB8 \xEC븘\xEC씠\xED뀥 紐⑸줉\xEC쓽 \xEC븵怨\xBC \xEB뮘\xEC뿉 遺숈뿬\xEB꽔\xEC뼱\xEC꽌 \xEC깉濡쒖슫 \xEC븘\xEC씠\xED뀥 紐⑸줉\xEC쓣 留뚮뱶\xEB뒗 諛⑸쾿\xEC쓣 \xEC궗\xEC슜\xED빀\xEB땲\xEB떎. \xEC씠\xEB븣 \xEC븵\xEB뮘\xEC뿉 蹂듭궗\xED빐\xEC꽌 遺숈뿬\xEB꽔\xEB뒗 \xEC븘\xEC씠\xED뀥\xEC쓽 媛\x81 媛쒖닔\xEB뒗
// \xED솕硫댁뿉 蹂댁뿬吏\x88 \xEC븘\xEC씠\xED뀥\xEC쓽 \xEC닔\xEC\x99 媛숆쾶 \xED빐以띾땲\xEB떎.(options\xEC뿉\xEC꽌 display \xED빆紐⑹엯\xEB땲\xEB떎.)

;(function($, window, document, undefined) {
	
	// plugin \xEC씠由\x84, default option \xEC꽕\xEC젙
	var pluginName = 'cfSlider',
		defaults = {
			container: '.container',	// \xEC븘\xEC씠\xED뀥\xEB뱾\xEC쓣 媛吏怨\xA0 \xEC엳\xEB뒗 \xEC뿕由щ㉫\xED듃\xEC쓽 jQuery \xEC\x85\xEB젆\xED꽣
			item: '.item',				// \xEC븘\xEC씠\xED뀥 \xEC뿕由щ㉫\xED듃\xEC쓽 jQuery \xEC\x85\xEB젆\xED꽣
			display: 1,					// \xED솕硫댁뿉 蹂댁뿬吏\xEB뒗 \xEC븘\xEC씠\xED뀥\xEC쓽 \xEC닔
			move: 1,					// \xED븳 踰덉뿉 \xEC뒳\xEB씪\xEC씠\xEB뱶\xEB맆(\xEC씠\xEB룞\xED븷) \xEC븘\xEC씠\xED뀥\xEC쓽 \xEC닔
			direction: 'horizontal',	// 媛濡쒖뒳\xEB씪\xEC씠\xEB뱶: horizontal, \xEC꽭濡쒖뒳\xEB씪\xEC씠\xEB뱶: vertical
			speed: 400,					// \xEC뒳\xEB씪\xEC씠\xEB뵫 \xEC냽\xEB룄, 諛由ъ꽭而⑤뱶 \xEB떒\xEC쐞\xEC쓽 \xEC닽\xEC옄 \xEB삉\xEB뒗 jQuery.animate()\xEC뿉 \xEC궗\xEC슜媛\xEB뒫\xED븳 'slow', 'fast' \xEB벑 臾몄옄\xEC뿴
			prevBtn: '.prev',			// \xEC씠\xEC쟾 踰꾪듉\xEC쓽 jQuery \xEC\x85\xEB젆\xED꽣(瑗\xAD 踰꾪듉 \xED삎\xED깭\xEC씪 \xED븘\xEC슂 \xEC뾾\xEC쓬)
			nextBtn: '.next',			// \xEB떎\xEC쓬 踰꾪듉\xEC쓽 jQuery \xEC\x85\xEB젆\xED꽣(瑗\xAD 踰꾪듉 \xED삎\xED깭\xEC씪 \xED븘\xEC슂 \xEC뾾\xEC쓬)
			eventType: 'click',			// slider瑜\xBC \xEC옉\xEB룞\xEC떆\xED궗 \xEB븣 \xED븘\xEC슂\xED븳 \xEC씠踰ㅽ듃. 利\x89, \xEC씠\xEC쟾/\xEB떎\xEC쓬 踰꾪듉\xEC뿉 \xEC씠 \xEC씠踰ㅽ듃媛 諛쒖깮\xED븯硫\xB4 slider \xEC옉\xEB룞
			prevEventType: null,		// prev, next濡\x9C \xEC씠\xEB룞\xED븷 \xEB븣 \xEC궗\xEC슜\xED븷 \xED듅蹂꾪븳 \xEC씠踰ㅽ듃 \xED\x83\xEC엯 \xEB벑濡\x9D
			nextEventType: null,		// \xED솢\xEC슜\xEC삁) 紐⑤컮\xEC씪\xEC쎒 媛쒕컻\xED븷 \xEB븣 \xED꽣移\x98 swipe(\xED뵆由ы궧)\xEC쑝濡\x9C slider瑜\xBC \xEC옉\xEB룞\xEC떆\xED궎怨\xA0 \xEC떢\xEC쑝硫\xB4 \xEC씠 \xEC옄由ъ뿉 \xEC쟻\xEC젅\xED븳
										// 而ㅼ뒪\xED\x85 \xEC씠踰ㅽ듃 \xED\x83\xEC엯\xEC쓣 \xEB벑濡앺븯怨\xA0, \xED꽣移섎\xA5\xBC \xED븷 \xEB븣 洹\xB8 而ㅼ뒪\xED\x85 \xEC씠踰ㅽ듃瑜\xBC cfSlider瑜\xBC \xEC떎\xED뻾\xEC떆\xED궗 \xEC뿕由щ㉫\xED듃\xEC뿉\xEC꽌 諛쒖깮\xEC떆\xED궎硫\xB4 \xEB맖
			callback: null				// \xEC뒳\xEB씪\xEC씠\xEB뱶 \xEC븷\xEB땲硫붿씠\xEC뀡\xEC씠 \xEB걹\xEB굹怨\xA0 \xEC떎\xED뻾\xEB맆 肄쒕갚\xED븿\xEC닔, \xEC씤\xEC옄濡\x9C \xED쁽\xEC옱 \xED솕硫댁뿉 蹂댁씠怨\xA0 \xEC엳\xEB뒗 \xEC븘\xEC씠\xED뀥\xEB뱾\xEC쓽 DOM媛앹껜瑜\xBC 諛쏄쾶 \xEB맖
			// callback: function(items) {
				// console.log(items);	// \xEC씠\xEB윴 \xEC떇\xEC쑝濡\x9C \xEC궗\xEC슜\xED븯\xEC떆硫\xB4 \xEB맗\xEB땲\xEB떎.
			// }
		};
	
	
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
		
		var slider = $(this.element),
			options = this.options,
			$container = slider.find(options.container),
			$items = $container.find(options.item).not('.cfslider_clone'),
			itemLength = $items.length,
			$afterItems = $items.slice(0, options.display).clone(),		// \xEC븘\xEC씠\xED뀥\xEB뱾 以묒뿉\xEC꽌 \xEC븵\xEC뿉\xEC꽌 遺\xED꽣 options.display 留뚰겮 蹂듭궗
			$beforeItems = $items.slice(itemLength - options.display, itemLength).clone(),	// \xEC븘\xEC씠\xED뀥\xEB뱾 以묒뿉\xEC꽌 \xEB뮘\xEC뿉\xEC꽌 遺\xED꽣 options.display 留뚰겮 蹂듭궗
			itemSize = options.direction === 'horizontal' ? $items.first().width() : $items.first().height(),		// \xEC븘\xEC씠\xED뀥 \xED븯\xEB굹\xEC쓽 \xEB꼫鍮\x84 \xEB삉\xEB뒗 \xEB넂\xEC씠瑜\xBC 援ы븿
			marginType = options.direction === 'horizontal' ? 'marginLeft' : 'marginTop',	// \xEC뒳\xEB씪\xEC씠\xEB뵫 \xED슚怨쇱뿉 \xEC궗\xEC슜\xED븷 margin\xEC쓽 醫낅쪟
			$prevBtn = $(options.prevBtn),
			$nextBtn = $(options.nextBtn);
			
		this.container = $container;
		this.marginType = marginType;
		this.itemSize = itemSize;
		this.itemLength = itemLength;
		
		$beforeItems.each(function() {
			$(this).addClass('cfslider_clone');
		});
		
		$afterItems.each(function() {
			$(this).addClass('cfslider_clone');
		});
			
		slider.css('overflow', 'hidden');	// \xED븘\xEC닔 css \xEC냽\xEC꽦, css履쎌뿉\xEC꽌 \xEC젙\xEC쓽\xEC븞\xED븯\xEB뒗 寃쎌슦瑜\xBC \xEB\x8C鍮꾪빐 \xEC꽕\xEC젙, \xEC떎\xEC젣 \xEC\x9B吏곸씠\xEB뒗 $container瑜\xBC \xEC떥怨\xA0 \xEC엳\xEB뒗 slider媛 overflow:hidden \xEC냽\xEC꽦\xEC쓣 媛吏怨\xA0 \xEC엳\xEC뼱\xEC빞 \xEC옄\xEC떊\xEC쓽 \xED겕湲곕쭔\xED겮留\x8C \xEC궗\xEC슜\xEC옄\xEC뿉寃\x8C 蹂댁뿬以꾩닔 \xEC엳湲\xB0 \xEB븣臾\xB8
		
		$container.empty();
		$container.append($beforeItems, $items, $afterItems);	// 湲곗〈 \xEC븘\xEC씠\xED뀥\xEB뱾\xEC쓽 \xEC븵\xEC뿉\xEB뒗 beforeItems瑜\xBC 異붽\xB0\xED븯怨\xA0 \xEB뮘\xEC뿉\xEB뒗 afterItems瑜\xBC 異붽\xB0\xED븿
																// 利\x89, \xEC썝\xEB옒 \xEC븘\xEC씠\xED뀥 紐⑸줉\xEC씠 '1-媛','2-\xEB굹','3-\xEB떎','4-\xEB씪','5-留\x88' \xEC씠怨\xA0 move媛 3\xEC씠\xEB씪硫\xB4 \xEC븘\xEB옒\xEC\x99 媛숈씠\xEB맖
																// ==> '1-\xEB떎','2-\xEB씪','3-留\x88','4-媛','5-\xEB굹','6-\xEB떎','7-\xEB씪','8-留\x88','9-媛','10-\xEB굹','11-\xEB떎'
																// 醫뚯슦 \xEC씠\xEB룞\xEC쓣 \xEC쐞\xED빐\xEC꽌 \xEC썝\xEB옒 html肄붾뱶\xEC뿉 \xEC엳\xEB뜕 \xEC븘\xEC씠\xED뀥 紐⑸줉\xEC쓽 \xEC븵\xEB뮘\xEC뿉 蹂듭궗(clone)\xED븳 \xEC븘\xEC씠\xED뀥\xEB뱾\xEC쓣 \xEB뜑 遺숈뿬 二쇰뒗 寃\x83
		
		
		// 洹몃━怨\xA0 \xEB굹\xEC꽌 $container\xEC쓽 width瑜\xBC \xEC깉濡\x9C 蹂듭궗\xED빐\xEB꽔\xEC\x9D \xEC븘\xEC씠\xED뀥\xEB뱾源뚯\xA7 \xED룷\xED븿\xED븳 width濡\x9C 留뚮뱾\xEC뼱二쇨퀬
		// \xEC썝\xEB옒 html肄붾뱶\xEC뿉 \xEC엳\xEB뜕 泥\xAB 踰덉㎏ \xEC븘\xEC씠\xED뀥\xEC씠 蹂댁씠寃\x8C \xED븯湲곗쐞\xED빐 $container\xEC쓽 marginLeft 媛믪쓣 議곗젙\xED븿
		// \xEC삁) itemLength = 5, itemSize = 100, move = 3 \xEC씤 \xEC긽\xED솴\xEC씠\xEC뿀\xEB떎硫\xB4
		// 		$container\xEC쓽 width\xEB뒗 \xEC븵\xEC뿉 3媛\x9C, \xEC썝\xEB옒 5媛\x9C, \xEB뮘\xEC뿉 3媛\x9C \xEC씠\xEB젃寃\x8C 11媛쒖쓽 \xEC븘\xEC씠\xED뀥\xEC씠\xEB씪 1100\xEC씠 \xEB릺怨\xA0
		//		\xEC썝\xEB옒 5媛\x9C 以\x91 泥\xAB 踰덉㎏媛 \xEC젣\xEC씪 泥섏쓬\xEC뿉 蹂댁씠寃\x8C \xED븯湲곗쐞\xED빐 \xEC븵\xEC뿉 3媛\x9C width 留뚰겮\xEC쓣 -marginLeft 泥섎━\xED븿
		// * \xEC쐞 \xEC꽕紐낆\x9D direction\xEC씠 horizontal\xEC씪 寃쎌슦\xEC뿉 \xED빐\xEB떦\xED빀\xEB땲\xEB떎. vertical\xEC씪 寃쎌슦\xEC뿉\xEB뒗 $container\xEC쓽 width\xEB뒗 itemSize\xEC씠怨\xA0 marginLeft\xEB\x8C\xEC떊 marginTop\xEC쓣 \xEC궗\xEC슜\xED빀\xEB땲\xEB떎.
		var containerCss = {};
		containerCss['width'] = options.direction === 'horizontal' ? itemSize * (itemLength + options.display * 2) : itemSize;
		containerCss[marginType] = -(itemSize * options.display);
		
		$container.css(containerCss);
		
		// \xEC씠\xEC쟾 踰꾪듉\xEC뿉 \xEC씠踰ㅽ듃 諛쒖깮\xEC떆 \xEC떎\xED뻾
		$prevBtn
			.unbind(options.eventType + '.cfSlider')
			.bind(options.eventType + '.cfSlider', function() {
				go('prev', $container, marginType, itemSize, itemLength, options);
			});
	
		// \xEB떎\xEC쓬 踰꾪듉\xEC뿉 \xEC씠踰ㅽ듃 諛쒖깮\xEC떆 \xEC떎\xED뻾
		$nextBtn
			.unbind(options.eventType + '.cfSlider')
			.bind(options.eventType + '.cfSlider', function() {
				go('next', $container, marginType, itemSize, itemLength, options);
			});
		
		// 而ㅼ뒪\xED\x85 \xEC씠踰ㅽ듃 \xED\x83\xEC엯\xEC씠 \xEB벑濡앸릺\xEC뿀\xEC쓣 寃쎌슦
		if (options.prevEventType) {
			slider
				.unbind(options.prevEventType + '.cfSlider')
				.bind(options.prevEventType + '.cfSlider', function() {
					go('prev', $container, marginType, itemSize, itemLength, options);
				});
		}
		
		if (options.nextEventType) {
			slider
				.unbind(options.nextEventType + '.cfSlider')
				.bind(options.nextEventType + '.cfSlider', function() {
					go('next', $container, marginType, itemSize, itemLength, options);
				});
		}
		
	};
	
	
	// \xEC뒳\xEB씪\xEC씠\xEB뱶 \xED븿\xEC닔
	function go(direction, $container, marginType, itemSize, itemLength, options, currentMargin) {
		
		if ($container.is(':animated')) {		// \xEC븷\xEB땲硫붿씠\xEC뀡 吏꾪뻾以묒씪 \xEB븣 \xEB늻瑜대㈃ 諛섏쓳 \xEC뾾\xEB룄濡\x9D 泥섎━
			return;
		}
		
		var obj = {},	// animate\xEC뿉 \xEB꽆湲\xB8 parameter瑜\xBC 留뚮뱾湲\xB0 \xEC쐞\xED븳 \xEC엫\xEC떆 媛앹껜
			currentMargin = currentMargin === undefined ? parseInt($container.css(marginType)) : currentMargin;	// $container\xEC쓽 \xED쁽\xEC옱 margin
		
		if (direction === 'prev') {
			
			var targetMargin = currentMargin + itemSize * options.move;		// \xEC씠\xEB룞\xED븷 margin
			
			obj[marginType] = targetMargin;
			
			// \xEC뒳\xEB씪\xEC씠\xEB뱶 \xEC떎\xED뻾
			$container.animate(obj, options.speed, function() {
				if ((Math.abs(currentMargin) / itemSize) <= (options.move > options.display ? options.move : options.display)) {	// \xEB떎\xEC쓬 \xEC쐞移섏뿉 \xEC븘\xEC씠\xED뀥\xEC씠 move\xED븷 \xEC븘\xEC씠\xED뀥蹂대떎 \xEC쟻寃\x8C \xEB궓\xEC븘\xEC엳\xEC쓣 寃쎌슦
					targetMargin = targetMargin - (itemSize * itemLength);	// \xEC씠\xEB룞\xED븷 margin \xEC옱\xEC꽕\xEC젙
					$container.css(marginType, targetMargin);	// itemSize * itemLength 留뚰겮 margin\xEC쓣 議곗젙 -> \xEC씠\xEB젃寃\x8C \xED븯湲\xB0 \xEC쐞\xED빐 \xEC븘\xEC씠\xED뀥\xEB뱾\xEC쓣 clone()\xED빐\xEC꽌 \xEC썝蹂몄쓽 \xEC븵\xEB뮘\xEC뿉 遺숈뿬\xEB넧\xEB뜕 寃\x83 -> \xEC닚媛꾩쟻\xEC쑝濡\x9C margin\xEC씠 議곗젙\xEB릺怨\xA0 蹂댁씠\xEB뒗 \xEC븘\xEC씠\xED뀥 \xED빆紐⑹\x9D 媛숆린 \xEB븣臾몄뿉 \xEC궗\xEC슜\xEC옄\xEB뒗 \xEC씤吏\xED븯吏 紐삵븿
				}
				
				if (options.callback != null) {
					var list = $container.find(options.item);
					options.callback(list.slice(Math.abs(targetMargin) / itemSize, Math.abs(targetMargin) / itemSize + options.display));
				}
			});
			
		} else if (direction === 'next') {
			
			var targetMargin = currentMargin - itemSize * options.move;		// \xEC씠\xEB룞\xED븷 margin
			
			obj[marginType] = targetMargin;
			
			// \xEC뒳\xEB씪\xEC씠\xEB뱶 \xEC떎\xED뻾
			$container.animate(obj, options.speed, function() {
				if (itemLength + options.display * 2 - (Math.abs(currentMargin) / itemSize + options.display) <= (options.move > options.display ? options.move : options.display)) {	// \xEB떎\xEC쓬 \xEC쐞移섏뿉 \xEC븘\xEC씠\xED뀥\xEC씠 move\xED븷 \xEC븘\xEC씠\xED뀥蹂대떎 \xEC쟻寃\x8C \xEB궓\xEC븘\xEC엳\xEC쓣 寃쎌슦
					targetMargin = targetMargin + (itemSize * itemLength);	// \xEC씠\xEB룞\xED븷 margin \xEC옱\xEC꽕\xEC젙
					$container.css(marginType, targetMargin);	// itemSize * itemLength 留뚰겮 margin\xEC쓣 議곗젙 -> \xEC씠\xEB젃寃\x8C \xED븯湲\xB0 \xEC쐞\xED빐 \xEC븘\xEC씠\xED뀥\xEB뱾\xEC쓣 clone()\xED빐\xEC꽌 \xEC썝蹂몄쓽 \xEC븵\xEB뮘\xEC뿉 遺숈뿬\xEB넧\xEB뜕 寃\x83 -> \xEC닚媛꾩쟻\xEC쑝濡\x9C margin\xEC씠 議곗젙\xEB릺怨\xA0 蹂댁씠\xEB뒗 \xEC븘\xEC씠\xED뀥 \xED빆紐⑹\x9D 媛숆린 \xEB븣臾몄뿉 \xEC궗\xEC슜\xEC옄\xEB뒗 \xEC씤吏\xED븯吏 紐삵븿
				}
				
				if (options.callback != null) {
					var list = $container.find(options.item);
					options.callback(list.slice(Math.abs(targetMargin) / itemSize, Math.abs(targetMargin) / itemSize + options.display));
				}
			});
			
		}
		
	}
	
	// go \xED븿\xEC닔瑜\xBC cfSlider \xEC씤\xEC뒪\xED꽩\xEC뒪\xEC쓽 硫붿꽌\xEB뱶濡\x9C 留뚮벉
	Plugin.prototype.go = go;
	
	// jQuery 媛앹껜\xEC\x99 element\xEC쓽 data\xEC뿉 plugin\xEC쓣 \xEB꽔\xEC쓬
	$.fn[pluginName] = function(options) {
		
		return this.each(function() {
			
			if ( ! $.data(this, 'plugin_' + pluginName)) {
				$.data(this, 'plugin_' + pluginName, new Plugin(this, options));
			}
			
		});
		
	};
	
})(jQuery, window, document);