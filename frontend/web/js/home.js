jQuery.datepicker.setDefaults( jQuery.datepicker.regional[ "ru" ] );

$('.logoutLink').click(function(){
    if(confirm('Вы уверенны, что хотите выйти?')){
        $('#logout-form').submit();
    }
});

jQuery('#cartClear').click(function(){
    if(confirm('Уверены, что нужно удалить все товары с корзины?')){
        jQuery.ajax({ url: RegData.ajaxCart,
            data: {clear : 1},
            dataType: "json",
            cache: false,
            type: "POST",
            error:function(){
                alert('Ошибка запроса, обновите страницу и попробуйте еще раз');
            },
            success: function(data){
                window.location.href = window.location.href;
            }
        });
    }

});

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
$(function(){
    jQuery("#signupform-country, #userdescription-country").autocomplete({
        source: function(request, response) {
            jQuery.ajax({ url: RegData.ajaxUrlRegion,
                data: { term: request.term },
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
    jQuery("#signupform-city").autocomplete({
        source: function(request, response) {
            var region = jQuery("#signupform-country").val();
            jQuery.ajax({ url: RegData.ajaxUrlCity,
                data: { term: request.term, region:region },
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
    jQuery("#userdescription-city").autocomplete({
        source: function(request, response) {
            var region = jQuery("#userdescription-country").val();
            jQuery.ajax({ url: RegData.ajaxUrlCity,
                data: { term: request.term, region:region },
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
    jQuery("#order-city").autocomplete({
        source: function(request, response) {
            var region = jQuery("#order-country").val();
            jQuery.ajax({ url: RegData.ajaxUrlCity,
                data: { term: request.term, region:region },
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

function toCartClick(){
    jQuery('#inCartClick').click(function(){
        cart.click();
    });
}


var cart = {

    idBottomCart: '#inCartClick',

    click: function(){
        if(!typeof window.ItemData){
            this.dialog('dialog-error-any');
            return false;
        }
        ItemData.setPriceFull();
        if(ItemData.count <= 0){
            this.dialog('dialog-error-count');
            return false;
        }
        if(ItemData.size <= 0){
            this.dialog('dialog-error-size');
            return false;
        }
        this.addCart();
    },
    addCart: function(){
        var self = this;
        jQuery.ajax({ url: ItemData.ajaxCart,
            data: ItemData,
            dataType: "json",
            cache: false,
            type: "POST",
            error:function(){
                alert('Ошибка запроса, обновите страницу и попробуйте еще раз');
            },
            success: function(data){
                if(data.e){
                    self.dialogAddError(data.msg);
                }else{
                    $('#cartCount').html(data.counts);
                    $('#cartSum').html(data.price);
                    self.dialogAdd(data.msg);
                }
            }
        });
    },
    dialog: function(id){
        jQuery( "#" + id ).dialog({
            closeOnEscape: true,
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    },
    dialogAddError: function(text){
        var idDom = '#dialog-add-error';
        jQuery(idDom + '-span').html(text);
        jQuery(idDom).dialog({
            closeOnEscape: false,
            height:250,
            width:400,
            modal: true,
            buttons: {
                'Закрыть': function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    },
    dialogAdd: function(text){
        var idDom = '#dialog-add';
        jQuery(idDom + '-span').html(text);
        jQuery(idDom).dialog({
            closeOnEscape: false,
            height:250,
            width:400,
            modal: true,
            buttons: {
                'Продолжить покупки': function() {
                    $( this ).dialog( "close" );
                },
                'Оформить заказ': function() {
                    window.location.href = ItemData.hrefCart;
                }
            }
        });
    }
};

toCartClick();

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
                toCartClick();
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
