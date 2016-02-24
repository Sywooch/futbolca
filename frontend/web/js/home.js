
lightgallery.init();

$.datepicker.setDefaults( $.datepicker.regional[ "ru" ] );

$( "#book-date" ).datepicker({
    dateFormat : "yy-mm-dd"
});

$('input[name=BookSearch\\[date\\]], input[name=BookSearch\\[created_at\\]]').datepicker({
    dateFormat : "yy-mm-dd"
});

$('#book-author').change(function(){
    var current = $('#book-author').val();
    if($.isNumeric(current) && current == 0){
        $('#newAuthor').css('display', 'block');
    }else{
        $('#newAuthor').css('display', 'none');
    }
});