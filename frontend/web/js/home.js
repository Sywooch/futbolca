jQuery.datepicker.setDefaults( jQuery.datepicker.regional[ "ru" ] );

$(function(){
    jQuery("#seach_text_id").autocomplete({
        source: function(request, response) {
            jQuery.ajax({ url: SearchData.ajaxUrl,
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
    jQuery("#seach_text_id_full").autocomplete({
        source: function(request, response) {
            jQuery.ajax({ url: SearchData.ajaxUrl,
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

var changes = {

    idPriceElement: '#price_tovar',
    classUpdate: '.product-block',
    ajax: function(){
        var self = this;
        jQuery.ajax({ url: ItemData.ajaxUrl,
            data: ItemData,
            dataType: "html",
            cache: false,
            type: "POST",
            error:function(){
                alert('Ошибка запроса, обновите страницу и попробуйте еще раз');
            },
            success: function(data){
                jQuery(self.classUpdate).html(data);
                ItemData.element = (jQuery('#currentElementId').val() * 1);
                ItemData.setPriceFull(jQuery('#price_tovar').html());
                self.showNewPrice();
                console.log(ItemData);
            }
        });
    },
    watermark: function(watermarkId){
        ItemData.watermark = (watermarkId * 1);
        this.ajax();
    },
    element: function(elementId){
        ItemData.element = (elementId * 1);
        this.ajax();
    },
    fashion: function(fashionId){
        ItemData.fashion = (fashionId * 1);
        this.ajax();
    },
    size: function(sizeId){
        ItemData.size = (sizeId * 1);
    },
    count: function(d){
        var self = this;
        ItemData.count = (jQuery(d).val() * 1);
        if(!ItemData.count || ItemData.count <= 0){
            ItemData.count = 1;
            jQuery(d).val(ItemData.count);
        }
        ItemData.setPriceFull();
        self.showNewPrice();
    },
    showNewPrice: function(){
        var self = this;
        jQuery(self.idPriceElement).html(ItemData.priceFull);
    }
};
