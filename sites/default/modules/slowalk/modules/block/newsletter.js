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
            modal: true,
            title:"뉴스레터 신청",
            width: 'auto', // overcomes width:'auto' and maxWidth bug
            maxWidth: 600,
            height: 'auto',
            modal: true,
            clickOut: true,
            fluid: true, //new option
            position: { my: "center", at: "center", of: window },
            close:function(event,ui) {
                $('#newsletter-form input[type=text]').val('');
            }
        });
    }
})(jQuery);