var jquery_cavacnote_count = 0;

(function($){  
    $.fn.cavacnote = function(options) {
        /*
        var defaults = {
            'image_checked':   '/pics/checkbox_classic_ON.png',
            'image_unchecked': '/pics/checkbox_classic_OFF.png',
            'image_checked_delete': '/pics/checkbox_classic_DELETE.png'
        };
        
        options = $.extend({}, defaults, options);
        */
        
        return this.each(function() {
            var obj = $(this);
            var popuptitle = $(this).attr("popuptitle");
            var popuptext = $(this).attr("popuptext");
            popuptext = popuptext.replace(/#BR#/gm,"<br/>");
            
            var dialogid = 'cavacnote' + jquery_cavacnote_count;
            jquery_cavacnote_count = jquery_cavacnote_count + 1;
            
            $("<div id='" + dialogid + "' title='" + popuptitle + "'><p>" + popuptext + "</p></div>").insertAfter(obj);
            $('#' + dialogid).dialog({
                        autoOpen: false,
                        resizable: false,
                        modal: false
            });
            
            $(obj).click(function(e) {
                $('#' + dialogid).dialog("option", "position", {
                    my: "left top",
                    at: "left bottom",
                    of: button,
                    offset: "5 30"
                });
                $('#' + dialogid).dialog('open');
                //return false;
            });

        });  
    };  
})(jQuery);

