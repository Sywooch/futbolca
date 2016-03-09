$.datepicker.setDefaults( $.datepicker.regional[ "ru" ] );

$(function(){
    $("#seach_text_id").autocomplete({
        source: function(request, response) {
            $.ajax({ url: CURRENT_DOMEN + 'search/autocomplete.html',
                data: { term: request.term, seach_text_go: 1 },
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }
            });
        },
        minLength: 2
    });
});
$(function(){
    $("#seach_text_id_full").autocomplete({
        source: function(request, response) {
            $.ajax({ url: CURRENT_DOMEN + 'search/autocomplete.html',
                data: { term: request.term, seach_text_go: 1 },
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }
            });
        },
        minLength: 2
    });
});
