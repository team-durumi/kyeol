/*
Theme Name: webzine
Author: css3studio
Version:1.0
*/
var device_status = "";
var $ = jQuery;
$(window).resize(function() {
	var dw = viewport().width;
	if(dw <= 768 && device_status == "pc"){	//PC에서 모바일로 변경시
		$("body").removeClass('pc');
		$("body").addClass('mobile');
		init_mobile();
		device_status = "mobile";
	}else if(dw > 768 && device_status == "mobile"){	//모바일에서 PC로 변경시
		$("body").removeClass('mobile');
		$("body").addClass('pc');
		init_pc();
		device_status = "pc";
	}
});

/* 메뉴고정 */
$(window).scroll(function(e){
	if ($(window).scrollTop() > 0) {         
		$("body.pc").addClass("scrolling");
	} else {
		$("body.pc").removeClass("scrolling");
	}
});
function viewport() {
    var e = window, a = 'inner';
    if (!('innerWidth' in window )) {
        a = 'client';
        e = document.documentElement || document.body;
    }
    return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
}

$(document).ready(function() {
	
	var dw = viewport().width;
	if(dw <= 768){	//모바일
		$("body").removeClass('pc');
		$("body").addClass('mobile');
		init_mobile();
		device_status = "mobile";
	}else{	//PC
		$("body").removeClass('mobile');
		$("body").addClass('pc');
		init_pc();
		device_status = "pc";
	}
  	//메인슬라이더
	$('.ib01 .slide li').each(function(){
		$(this).css({'background-image':'url('+$('img',$(this)).attr('src')+')'});
		//$('img',$(this)).remove();
	});
	$('.ib01 .slide').slick({
		autoplay:true,
		fade:true,
		speed:1400,
		autoplaySpeed:6000,
		arrows:false,
		dots:true
	});
	//검색창 열기/닫기
	$('header .ng01 .search a').click(function(){
		$('header').addClass('searchOpened');
		return false;
	});
	$('header .cf01 a.btn_icon01').click(function(){
		$('header').removeClass('searchOpened');
		return false;
	});
	//menu 열기/닫기
	$('header .ng01 .menu a').click(function(){
		$('header').addClass('menuOpened');
		return false;
	});
	$('header nav a.btn_icon01').click(function(){
		$('header').removeClass('menuOpened');
		return false;
	});
	//뷰화면 툴팁 오브제 효과
	$(".tt01").click(function(){
		$(".tooltip",$(this)).toggle();
		return false;
	});
	$(".tt01 .tooltip a.close").click(function(){
		$(this).parent().hide();
		return false;
	});
	$(document).mouseup(function(e) {
        var container = $('.tt01');
        if(container.has(e.target).length === 0) {
            $(".tooltip",container).hide();
        }
    });
	//뷰화면 공유기능
	$(".ng03 .share").click(function(){
		$(this).siblings('dl').toggle();
		return false;
	});
	$(document).mouseup(function(e) {
        var container = $('.ng03');
        if(container.has(e.target).length === 0) {
            $("dl",container).hide();
            $("button",container).text('링크복사');
        }
    });
	$(".ng03 dl dd button").click(function(){
		$(this).siblings('input').select(); 
		document.execCommand('copy'); 
		$(this).text('완료');
		$(this).append($('<i class="xi-check-min"></i>'));

	});

	form_validation();

	//cavac note
	$("span.cavacnote").cavacnote();

	//검색 사이드바 클릭시 검색어와 함께 redirect
    $("div.menu-name-menu-search ul.menu li a").click(function (e) {
        e.preventDefault();
        let thisURL = $(this).attr('href');
        let searchParam = new URLSearchParams(window.location.search);
        if(searchParam.has('key')) {
            location.replace(thisURL+'?key='+searchParam.get('key'));
        } else {
            location.replace(thisURL);
        }
    });

    //검색 페이지 접근시 검색 결과 Ajax
	if($('body').hasClass('page-search')) {
		let status = (window.location.pathname === '/search') ? 'keyword' : 'term';
		let searchParam = new URLSearchParams(window.location.search);
		let key = searchParam.get('key');
		$.post('/ajax/webzine', {type:'search', status:status, key:key}).done(function (res) {
			$("div.menu-name-menu-search ul.menu li a:eq(0)").append(' ('+res.keyword+')');
			$("div.menu-name-menu-search ul.menu li a:eq(1)").append(' ('+res.term+')');
		});
	}

	//기사페이지 이미지 슬라이드
	$('.ng04.slide ul.slider').slick({
		autoplay:true,
		speed:500,
		adaptiveHeight: true,
		autoplaySpeed:6000,
		arrows:true,
		dots:false,
		asNavFor: '.ng04.slide ul.slider-nav'
	});
	$('.ng04.slide ul.slider-nav').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		asNavFor: '.ng04.slide ul.slider',
		arrows:true,
		dots: true,
		focusOnSelect: true
	});

	//로그인페이지
	$('#user-login input').focus(function() {
		$(this).siblings('.description').hide();
	});
	$('#user-login input').change(function () {
		if($(this).val().length === 0) {
			$(this).siblings('.description').show();
		} else {
			$(this).siblings('.description').hide();
		}
	});
	$('#user-login .description').click(function() {
		$(this).hide();
		$(this).siblings('input').focus();
	});

    //상단 Vol 링크
	$('#main_wrap>header .lg01 em b').mouseover(function () {
		$(this).css('cursor', 'pointer');
	}).click(function () {
		location.replace(Drupal.settings.Webzine.vol);
	});

	//모아보기 - 인물 "인물 정보" 클릭 이벤트
    $('a.person').click(function(e) {
        e.preventDefault();
        $.post('/ajax/webzine', {type:'person', search:$('.td01.leftF b').text()}).done(function(res){
            let box = $('<div />').addClass('person-info-box').append(res.description);
            let title = res.name + ' ('+ res.lifetime +')';
            box.dialog({
            	modal: true,
                title:title,
			    width: 'auto', // overcomes width:'auto' and maxWidth bug
			    maxWidth: 600,
			    height: 'auto',
			    modal: true,
			    clickOut: true,
			    fluid: true, //new option
				position: { my: "center", at: "center", of: window }
            });
        });
    });
	// on window resize run function
	$(window).resize(function () {
	    fluidDialog();
	    console.log('resized');
	});

	// catch dialog if opened within a viewport smaller than the dialog width
	$(document).on("dialogopen", ".ui-dialog", function (event, ui) {
	    fluidDialog();
	});

	function fluidDialog() {
	    var $visible = $(".ui-dialog:visible");
	    // each open dialog
	    $visible.each(function () {
	        var $this = $(this);
	        var dialog = $this.find(".ui-dialog-content").data("ui-dialog");
	        // if fluid option == true
	        if (dialog.options.fluid) {
	            var wWidth = $(window).width();
	            // check window width against dialog width
	            if (wWidth < (parseInt(dialog.options.maxWidth) + 50))  {
	                // keep dialog from filling entire screen
	                $this.css("max-width", "90%");
	            } else {
	                // fix maxWidth bug
	                $this.css("max-width", dialog.options.maxWidth + "px");
	            }
	            //reposition dialog
	            dialog.option("position", dialog.options.position);
	        }
	    });
	}
});

//PC버젼 초기화
function init_pc(){

}
//모바일 버젼 초기화
function init_mobile(){
	//모바일용 사이드 메뉴
	$(".sidebar ul.menu li.active a").click(function(){
		$(this).parents('ul.menu').toggleClass('opened');
		return false;
	});
	$(document).mouseup(function(e) {
        var container = $('.sidebar ul.menu');
        if(container.has(e.target).length === 0) {
            container.removeClass('opened');
        }
    });

}
//폼 유효성 검사
function form_validation(){
	//검색창
	$(".cf01").on('submit', function() {
		var input = $("input",$(this));
		if(input.val().trim() == ""){
			alert("검색어를 입력해 주세요");
			input.focus();
			return false;
		}
		else
			return true;
	});	
	//뉴스레터
	$(".cf02").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
         },
        messages: {
            email: "올바른 이메일 주소를 입력하세요"
         }
    });



}

/*
 * jQuery UI dialogOptions v1.0
 * @desc extending jQuery Ui Dialog - Responsive, click outside, class handling
 * @author Jason Day
 *
 * Dependencies:
 *		jQuery: http://jquery.com/
 *		jQuery UI: http://jqueryui.com/
 *		Modernizr: http://modernizr.com/    Modernizr adds feature detection. dialogOptions optionally checks for html.touch for scrolling
 *
 * MIT license:
 *              http://www.opensource.org/licenses/mit-license.php
 *
 * (c) Jason Day 2014
 *
 * New Options:
 *  clickOut: true          // closes dialog when clicked outside
 *  responsive: true        // fluid width & height based on viewport
 *                          // true: always responsive
 *                          // false: never responsive
 *                          // "touch": only responsive on touch device
 *  scaleH: 0.8             // responsive scale height percentage, 0.8 = 80% of viewport
 *  scaleW: 0.8             // responsive scale width percentage, 0.8 = 80% of viewport
 *  showTitleBar: true      // false: hide titlebar
 *  showCloseButton: true   // false: hide close button
 *
 * Added functionality:
 *  add & remove dialogClass to .ui-widget-overlay for scoping styles
 *	patch for: http://bugs.jqueryui.com/ticket/4671
 *	recenter dialog - ajax loaded content
 */

// add new options with default values
$.ui.dialog.prototype.options.clickOut = true;
$.ui.dialog.prototype.options.responsive = true;
$.ui.dialog.prototype.options.scaleH = 0.8;
$.ui.dialog.prototype.options.scaleW = 0.8;
$.ui.dialog.prototype.options.showTitleBar = true;
$.ui.dialog.prototype.options.showCloseButton = true;


// extend _init
var _init = $.ui.dialog.prototype._init;
$.ui.dialog.prototype._init = function () {
    var self = this;

    // apply original arguments
    _init.apply(this, arguments);

    //patch
    if ($.ui && $.ui.dialog && $.ui.dialog.overlay) {
        $.ui.dialog.overlay.events = $.map('focus,keydown,keypress'.split(','), function (event) {
           return event + '.dialog-overlay';
       }).join(' ');
    }
};
// end _init


// extend open function
var _open = $.ui.dialog.prototype.open;
$.ui.dialog.prototype.open = function () {
    var self = this;

    // apply original arguments
    _open.apply(this, arguments);

    // get dialog original size on open
    var oHeight = self.element.parent().outerHeight(),
        oWidth = self.element.parent().outerWidth(),
        isTouch = $("html").hasClass("touch");

    // responsive width & height
    var resize = function () {

        // check if responsive
        // dependent on modernizr for device detection / html.touch
        if (self.options.responsive === true || (self.options.responsive === "touch" && isTouch)) {
            var elem = self.element,
                wHeight = $(window).height(),
                wWidth = $(window).width(),
                dHeight = elem.parent().outerHeight(),
                dWidth = elem.parent().outerWidth(),
                setHeight = Math.min(wHeight * self.options.scaleH, oHeight),
                setWidth = Math.min(wWidth * self.options.scaleW, oWidth);

            // check & set height
            if ((oHeight + 100) > wHeight || elem.hasClass("resizedH")) {
                elem.dialog("option", "height", setHeight).parent().css("max-height", setHeight);
                elem.addClass("resizedH");
            }

            // check & set width
            if ((oWidth + 100) > wWidth || elem.hasClass("resizedW")) {
                elem.dialog("option", "width", setWidth).parent().css("max-width", setWidth);
                elem.addClass("resizedW");
            }

            // only recenter & add overflow if dialog has been resized
            if (elem.hasClass("resizedH") || elem.hasClass("resizedW")) {
                elem.dialog("option", "position", "center");
                elem.css("overflow", "auto");
            }
        }

        // add webkit scrolling to all dialogs for touch devices
        if (isTouch) {
            elem.css("-webkit-overflow-scrolling", "touch");
        }
    };

    // call resize()
    resize();

    // resize on window resize
    $(window).on("resize", function () {
        resize();
    });

    // resize on orientation change
     if (window.addEventListener) {  // Add extra condition because IE8 doesn't support addEventListener (or orientationchange)
        window.addEventListener("orientationchange", function () {
            resize();
        });
    }

    // hide titlebar
    if (!self.options.showTitleBar) {
        self.uiDialogTitlebar.css({
            "height": 0,
            "padding": 0,
            "background": "none",
            "border": 0
        });
        self.uiDialogTitlebar.find(".ui-dialog-title").css("display", "none");
    }

    //hide close button
    if (!self.options.showCloseButton) {
        self.uiDialogTitlebar.find(".ui-dialog-titlebar-close").css("display", "none");
    }

    // close on clickOut
    if (self.options.clickOut && !self.options.modal) {
        // use transparent div - simplest approach (rework)
        $('<div id="dialog-overlay"></div>').insertBefore(self.element.parent());
        $('#dialog-overlay').css({
            "position": "fixed",
            "top": 0,
            "right": 0,
            "bottom": 0,
            "left": 0,
            "background-color": "transparent"
        });
        $('#dialog-overlay').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            self.close();
        });
        // else close on modal click
    } else if (self.options.clickOut && self.options.modal) {
        $('.ui-widget-overlay').click(function (e) {
            self.close();
        });
    }

    // add dialogClass to overlay
    if (self.options.dialogClass) {
        $('.ui-widget-overlay').addClass(self.options.dialogClass);
    }
};
//end open


// extend close function
var _close = $.ui.dialog.prototype.close;
$.ui.dialog.prototype.close = function () {
    var self = this;
    // apply original arguments
    _close.apply(this, arguments);

    // remove dialogClass to overlay
    if (self.options.dialogClass) {
        $('.ui-widget-overlay').removeClass(self.options.dialogClass);
    }
    //remove clickOut overlay
    if ($("#dialog-overlay").length) {
        $("#dialog-overlay").remove();
    }
};
//end close
