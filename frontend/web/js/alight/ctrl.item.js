
alight.ctrl.item = function(scope) {

    var priceOne = ItemData.price;
    scope.count = ItemData.count;
    scope.price = priceOne *  scope.count;
    scope.selectedCount = function (){
        return (priceOne *  scope.count);
    };
    scope.elementClick = function(elementId){
        ItemData.element = ItemData.listElements[elementId];
        working.changeElement();
    };
};

var working = {

    idFullImg: '#fullImage',
    except: '.jpg',
    changeElement: function(){
        var self = this;
        var imgScr = '/img/full/';
        imgScr +=  self.explode(ItemData.element.photo);
        imgScr += '/';
        imgScr +=  self.explode(ItemData.watermark.name);
        imgScr += '/';
        imgScr +=  self.explode((ItemData.element.toppx * 1) + (ItemData.item.toppx * 1));
        imgScr += '/';
        imgScr +=  self.explode((ItemData.element.leftpx * 1) + (ItemData.item.leftpx * 1));
        imgScr += self.except;
        jQuery(self.idFullImg).attr('src', imgScr);
    },
    explode: function(str){
        str = str + '';
        str = str.split('.');
        str = str[0];
        return str;
    }
};
