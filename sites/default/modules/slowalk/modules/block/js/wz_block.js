(function ($) {
    $(document).ready(function () {
        let options = {
            beforeSubmit: showRequest,
            success: showResponse,
            dataType: 'json'
        };
        $('#newsletter-form').ajaxForm(options);
    });

    function showRequest(formData, jqForm, options) {
        let form = jqForm[0];
        if(!form.email.value) {
            alert('이메일을 입력하세요.');
            return false;
        }
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