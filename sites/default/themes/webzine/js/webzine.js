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
	$('#user-login input').blur(function() {
		$(this).siblings('.description').show();
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
            let title = res.name + ' ( ' + res.lifetime +' )';
            box.dialog({
            	modal: true,
                title:title,
                minWidth:500
            });
        });
    });
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
