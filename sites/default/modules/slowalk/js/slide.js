(function ($) {
    $(document).ready(function () {
        let slideCount = $('#edit-wz-slide-count').val();
        changeFieldset(slideCount);

        $('#edit-wz-slide-count').change(function () {
            let val = $(this).val();
           changeFieldset(val);
        });

        function changeFieldset(val)
        {
            for(let i=1; i<= 5; i++) {
                if(i > val) {
                    $('#edit-fieldset-'+i+'-slide').hide();
                } else {
                    $('#edit-fieldset-'+i+'-slide').show();
                }
            }
        }
    });
})(jQuery);