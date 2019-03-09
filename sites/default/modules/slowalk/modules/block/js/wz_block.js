(function ($) {
    $(document).ready(function () {
        let options = {
            beforeSubmit: showRequest,
            success: showResponse,
            dataType: 'json'
        };
        $('#newsletter-form').ajaxForm(options);
    });

    function showRequest() {
        return $('.cf02').valid();
    }

    function showResponse(responseText, statusText, xhr, $form) {
        if(responseText.error) {
            alert(responseText.error);
            $form[0].email.focus();
        } else {
            alert('정상적으로 신청이 완료되었습니다.');
        }
    }
})(jQuery);