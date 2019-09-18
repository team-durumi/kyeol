let jquery_term_count = 0;
(function($) {
  $(document).ready(function() {
    $.each($("a.term"), function(i,v) {
      let obj = $(v);
      let href = $(v).attr("href");
      let dialogid = 'term' + jquery_term_count;
      jquery_term_count += 1;
      $.post("/ajax/webzine", {type: "term", href: href}).done(function (response) {
        console.log(response);
        let popuptitle = response.name;
        let popuptext = response.description;
        $("<div id='" + dialogid + "' title='" + popuptitle + "'><p>" + popuptext + "</p></div>").insertAfter(obj);
        $('#' + dialogid).dialog({
          autoOpen: false,
          resizable: false,
          modal: false
        });
        $(obj).click(function(e) {
          e.preventDefault();
          $('#' + dialogid).dialog("option", "position", {
            my: "left top",
            at: "left bottom",
            of: e,
            offset: "5 30"
          });
          $('#' + dialogid).dialog('open');
        });
      });
    });
  });
})(jQuery);
