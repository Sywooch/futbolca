$.datepicker.setDefaults( $.datepicker.regional[ "ru" ] );

$(function(){
    $("#seach_text_id").autocomplete({
        source: function(request, response) {
            $.ajax({ url: CURRENT_DOMEN + 'ajax.html',
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
