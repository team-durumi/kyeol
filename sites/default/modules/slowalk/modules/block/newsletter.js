(function ($) {
    $(document).ready(function () {
        $('#newsletter-form').ajaxForm({
           beforeSubmit: showRequest,
           success: showResponse
        });
    });

    function showRequest (formData, jqForm, options) {
        let form = jqForm[0];
        return $(form).valid();
    }

    function showResponse(responseText, statusText, xhr, $form) {
        let newsletterDiv = $('<div />');
        newsletterDiv.append(responseText);
        newsletterDiv.dialog({
            height:300,
            width:500,
            title:"뉴스레터 신청",
            close:function(event,ui) {
                $('#newsletter-form input[type=text]').val('');
            }
        });
    }
})(jQuery);