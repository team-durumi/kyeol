(function ($) {
    $(document).ready(function () {
        $('.form-item-features input[type=checkbox]').click(function () {
           let totalChk =  $('.form-item-features input[type=checkbox]:checked').length;
           let thisTxt = $(this).parent().text();
           if(totalChk === 0) {
               $('#edit-grid #first span').remove();
           }

           if(totalChk === 1) {
               let firstLabel = $('<span />').text(thisTxt);
               if($(this).attr('checked')) {
                   $('#edit-grid #first').append(firstLabel);
               } else {
                   $('#edit-grid #second span').remove();
               }
           }

           if(totalChk === 2) {
               let secondLabel = $('<span />').text(thisTxt);
               if($(this).attr('checked')) {
                   $('#edit-grid #second').append(secondLabel);
               }
           }

           if(totalChk === 3) {
               alert('2개까지 선택이 가능합니다.');
               $(this).attr("checked", false);
           }
        });
    });
})(jQuery);