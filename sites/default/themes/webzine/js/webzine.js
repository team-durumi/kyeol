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
		speed:1000,
		autoplaySpeed:8000,
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

});

//PC버젼 초기화
function init_pc(){

}
//모바일 버젼 초기화
function init_mobile(){
	

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
