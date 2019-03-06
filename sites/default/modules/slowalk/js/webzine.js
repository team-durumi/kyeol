(function ($) {
    $(document).ready(function () {
        //Vol select change 이벤트
        $('#edit-wz-main-vol').change(function () {
            reset();
        });

        //첫 로딩시 저정된 값이 있을 때
        if($('input[name=wz_main_first_feature]').val()) {
            let val = $('input[name=wz_main_first_feature]').val();
            let Label = $('<h1 />').text($('#edit-wz-main-features-'+val).parent().text());
            generateFirstFeature($('input[name=wz_main_features]['+val+']'), Label, val);
        }

        if($('input[name=wz_main_second_feature]').val()) {
            let val = $('input[name=wz_main_second_feature]').val();
            let Label = $('<h1 />').text($('#edit-wz-main-features-'+val).parent().text());
            generateSecondFeature($('input[name=wz_main_features]['+val+']'), Label, val);
        }

        //기사분류 클릭 이벤트
        $('.form-item-wz-main-features input[type=checkbox]').click(function () {
            let $this = $(this);
            let val = $this.val();
            if($('#edit-wz-main-vol').val() === '_none_') {
                alert('먼저 Vol. 을 선택해 주세요.');
                $('#edit-wz-main-vol').focus();
                return false;
            }

            let totalChk =  $('.form-item-wz-main-features input[type=checkbox]:checked').length;
            let thisTxt = $(this).parent().text();

            if($(this).attr('checked')) {
                if(totalChk === 1) {
                    let firstLabel = $('<h1 />').text(thisTxt);
                    generateFirstFeature($this, firstLabel, val);
                }
                else if(totalChk === 2) {
                    let secondLabel = $('<h1 />').text(thisTxt);
                    generateSecondFeature($this, secondLabel, val);
                }
                else if(totalChk === 3) {
                    alert('2개까지 선택이 가능합니다.');
                    $(this).attr("checked", false);
                }
            } else {
                $('#lists').empty();
                $('#edit-grid .item').empty();
                $('input[name=wz_main_first_feature]').val('');
                $('input[name=wz_main_second_feature]').val('');
                if(totalChk === 1) {
                    let $chk = $('.form-item-wz-main-features input[type=checkbox]:checked');
                    let chkText = $chk.parent().text();
                    let firstLabel = $('<h1 />').text(chkText);
                    let chkVal = $chk.val();
                    generateFirstFeature($chk, firstLabel, chkVal);
                }
            }
        });

        function generateFirstFeature($this, label, category)
        {
            $.post(Drupal.settings.Webzine.ajaxUrl, {vol: $('#edit-wz-main-vol').val(), category:category, type:'features'}, function(res) {
                if(res.length === 0) {
                    alert('해당하는 콘텐츠가 존재하지 않습니다.');
                    $this.attr('checked', false);
                } else {
                    let nodeUrl = $('<a />').attr('href', res.url).attr('data-nid', res.nid);
                    let title = $('<h2 />').text(res.title);
                    let img = $('<img />').attr('src', res.img);
                    let desc = $('<span />').text(res.body);
                    let box = $('<div />').addClass('text');
                    box.append(title).append(desc);
                    nodeUrl.append(img).append(box);
                    $('#edit-grid #first').append(label);
                    $('#edit-grid #first').append(nodeUrl);
                    $('input[name=wz_main_first_feature]').val(category);
                }
            });
        }

        function generateSecondFeature($this, label, category)
        {
            $.post(Drupal.settings.Webzine.ajaxUrl, {vol: $('#edit-wz-main-vol').val(), category:category, type:'features'}, function(res) {
                if(res.length === 0) {
                    alert('해당하는 콘텐츠가 존재하지 않습니다.');
                    $this.attr('checked', false);
                } else {
                    let nodeUrl = $('<a />').attr('href', res.url).attr('data-nid', res.nid);
                    let title = $('<h2 />').text(res.title);
                    let img = $('<img />').attr('src', res.img);
                    let desc = $('<span />').text(res.body);
                    let box = $('<div />').addClass('text');
                    box.append(title).append(desc);
                    nodeUrl.append(img).append(box);
                    $('#edit-grid #second').append(label);
                    $('#edit-grid #second').append(nodeUrl);
                    $('input[name=wz_main_second_feature]').val(category);
                    generateList();
                }
            });
        }

        function generateList()
        {
            let nid = [];
            $.each($('#edit-grid a'), function(i, v) {
                nid.push($(v).data('nid'));
            });
            $.post(Drupal.settings.Webzine.ajaxUrl, {vol:$('#edit-wz-main-vol').val(), nid:nid, type:'articles'}, function(res) {
               $.each(res, function(i, v) {
                   let item = $('<div />').addClass('list-item');
                   let nodeUrl = $('<a />').attr('href', v.url).attr('data-nid', v.nid);
                   let title = $('<h2 />').text(v.title);
                   let category = $('<span />').addClass('category').text(v.category);
                   let img = $('<img />').attr('src', v.img);
                   let desc = $('<span />').text(v.body);
                   let box = $('<div />').addClass('text');
                   box.append(title).append(desc);
                   nodeUrl.append(img).append(category).append(box);
                   item.append(nodeUrl);
                   $('#lists').append(item);
               });
            });
        }

        function reset()
        {
            $('.form-item-wz-main-features input[type=checkbox]').attr('checked', false);
            $('#edit-grid #first').empty();
            $('#edit-grid #second').empty();
            $('input[name=wz_main_first_feature]').val('');
            $('input[name=wz_main_second_feature]').val('');
            $('#lists').empty();
        }
    });
})(jQuery);