$(document).ready(function(){

    for(var nch = 1; nch <= TV_IN_P; nch++)
    {
       if($('#opub' + nch).html() == 1)
       {
           $('#opub' + nch).html('Да');
       }
       else
       {
           $('#opub' + nch).html('<p style="color:#FF3366">Нет</p>');
        }
    }

    $('input[name=vidr_vse]').click(function(){
        var checs =  $('input[name=vidr_vse]').attr('checked');
        if(checs == 'checked')
        {
             $('input[name=id_tovara\\[\\]]').attr('checked', 'checked');
        }
        else
        {
             $('input[name=id_tovara\\[\\]]').removeAttr('checked');
        }
    });

    var current_fason =  $('input[name=current_fason]').val();
    $('input[type=radio][value='+current_fason+']').attr('checked', 'checked');

});

function sptovarorder(idorder, texttitle)
{
        $("#ord_" + idorder).dialog({
            width: 650,
            resizable: false,
            draggable: true,
            modal : true,
            title: texttitle,
            overlay: {
             backgroundColor: '#000',
             opacity: 0.5
           },
        });
}

function smena_razmera(bs_id, b_top_px, b_left_px)
{

     $.ajax({
           url: CURRENT_DOMEN + 'ajax.html',
           type: "POST",
           dataType : "html",
           cache: false,
           data: ({prodsize : 1, bs_id:bs_id, b_top_px:b_top_px, b_left_px:b_left_px}),
           beforeSend : function(){
               $('.prodsize').html('Идет загрузка');
           },
           erorre: function(){
               $('.prodsize').html('Ошибка, попробуйте еще');
           },
           success: function (data) {
              $('.prodsize').html(data);
           }
    });
}

function wt_click(im)
{
      $('input[name=wt]').val(im);
      img_retry();
}
function ph_click(im, bs_id, b_top_px, b_left_px, price)
{
      $('input[name=ph]').val(im);
      $('input[name=b_top_px]').val(b_top_px);
      $('input[name=b_left_px]').val(b_left_px);
      $('input[name=bs_id]').val(bs_id);

      if(bs_id > 0)
      {
           smena_razmera(bs_id, b_top_px, b_left_px);
      }

    if(price){
        $('#price_tovar').html(price);
        $("input[name=pr_price]").val(price);
    }

      img_retry();
}

function img_retry()
{
      var k1 = $('input[name=ph]').val();
      var k2 = $('input[name=wt]').val();
      var k3 = $('input[name=b_top_px]').val() * 1 + $('input[name=pr_top_px]').val() * 1;
      var k4 = $('input[name=b_left_px]').val() * 1 + $('input[name=pr_left_px]').val() * 1;
      $('#glav_img').attr('src', CURRENT_DOMEN + 'img/full/' + k1 + '/' + k2 + '/' + k3 + '/' + k4 + '.html');
}


function captca() {
     $("#captcha").attr("src", "captch.php");
}

function count_tovar2() {
     var pice = $("input[name=pr_price]").val().split(',').join('.') * 1;
     var count = $("input[name=count_tovar]").val() * 1;
     pice = pice * count;
     pice = pice.toFixed(2);
     pice = pice.split('.').join(',');
     $("#price_tovar").html(pice);
}

function isValidEmail (email, strict)
{
 if ( !strict )
 {
     email = email.replace(/^\s+|\s+$/g, '');
 }
 return (/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test(email);
}

function select_base()
{

     var checked =  $('input[name=basics_model\\[\\]]:checked');
     var checked2 = checked.length;
     var checked3 = new Array();
     var i=0;

     for(i = 0; i < checked2; i++)
     {
           checked3[i] = checked[i].value;
     }
     checked = checked3.join('|');
     var tovar =  $('input[name=pr_id]').val();
     $.ajax({
           url: CURRENT_DOMEN + 'ajax.html',
           type: "POST",
           dataType : "html",
           cache: false,
           data: ({checked : checked, tovar:tovar}),
           beforeSend : function(){
               $('#basics').html('Идет загрузка');
           },
           erorre: function(){
               $('#basics').html('Ошибка, попробуйте еще');
           },
           success: function (data) {
              $('#basics').html(data);
           }
    });
}

function fason_vibor (idf, pr_id)
{

     $.ajax({
           url: CURRENT_DOMEN + 'ajax.html',
           type: "POST",
           dataType : "html",
           cache: false,
           data: ({fason_vibor : 1, idf:idf, pr_id:pr_id}),
           beforeSend : function(){
               $('.product-img-list').html('Идет загрузка');
           },
           erorre: function()
           {
               alert('Ошибка, попробуйте еще');
           },
           success: function (data)
           {
                data = data.split('||');
                if(data[0] == 5)
                {
                    alert(data[1]);
                }
                if(data[0] == 1 && data[1].length > 1 && data[2].length > 1 && data[3].length > 1)
                {
                    $('.product-img-list').html(data[1]);
                    $('.prodsize').html(data[3]);

                    $('#price_tovar').html(data[2]);
                    $("input[name=pr_price]").val(data[2]);
                    $("input[name=count_tovar]").val(1);


                    ph_click(data[4], data[7], data[5], data[6], data[2]);
                    //$("input[name=bs_id]").val(idf);

                }
           }
    });

}

function in_car()
{

        var counsgood = $("input[name=count_tovar]").val().split(',').join('.') * 1;
        var pricegood = $("input[name=pr_price]").val().split(',').join('.') * 1;
        var fullprice = counsgood * pricegood;
        fullprice = fullprice.toFixed(2);
        var osnova =  $("input[name=bs_id]").val();
        var tovarid =  $("input[name=pr_id]").val();
        var wtmark =  $('input[name=wt]').val();
        var razmer =  $('input[name=prodsize]:checked').val();
        if(razmer === undefined)
        {
            alert("Выберите размер!");
            return false;
        }
        var tjoins = "/%/";
        var hjoins = "||";

        var coclm = tovarid + tjoins + counsgood + tjoins + pricegood + tjoins + fullprice + tjoins + osnova + tjoins + wtmark + tjoins + razmer;
        var coocky_t = $.cookie("coocky_t");
        var qq = 0;
        var lel = '';
        if(coocky_t != null)
        {
            coocky_t = coocky_t.split(hjoins);
            for (var i = 0; i < coocky_t.length; i++)
            {
                 lel =  coocky_t[i].split(tjoins);
                 if(lel[0] == tovarid && lel[4] == osnova && lel[6] == razmer)
                 {
                     coocky_t[i] = coclm;
                     qq++;
                 }
            }
        }
        if(qq == 0 && coocky_t != null)
        {
             coocky_t[coocky_t.length] = coclm;
        }
        if(qq == 0 && coocky_t == null)
        {
            coocky_t = [coclm];
        }

        $.cookie("coocky_t", coocky_t.join(hjoins), {expires: 30, path: '/'});
        alert("Товар добавлен в корзину ");
        car_up();
}

function in_car_inone()
{

        var counsgood = $("input[name=count_tovar]").val().split(',').join('.') * 1;
        var pricegood = $("input[name=pr_price]").val().split(',').join('.') * 1;
        var fullprice = counsgood * pricegood;
        fullprice = fullprice.toFixed(2);
        var osnova =  $("input[name=bs_id]").val();

        var tovarid =  $("input[name=pr_id]").val();
        var wtmark =  $('input[name=wt]').val();
        var razmer =  $('input[name=prodsize]:checked').val();
        if(razmer === undefined)
        {
            alert("Выберите размер!");
            return false;
        }
        var tjoins = "/%/";
        var hjoins = "||";
        var coclm = tovarid + tjoins + counsgood + tjoins + pricegood + tjoins + fullprice + tjoins + osnova + tjoins + wtmark + tjoins + razmer;
        return  coclm;
}

function car_up()
{
    var lengv = ['товаров', 'товар', 'товара', 'товара', 'товара', 'товаров'];

    var coocky_t = $.cookie("coocky_t");
    var tjoins = "/%/";
    var hjoins = "||";
    if(coocky_t != null)
    {
        coocky_t = coocky_t.split(hjoins);
        var cc = 0;
        var cc2 = 0;
        for (var i = 0; i < coocky_t.length; i++)
        {
             lel =  coocky_t[i].split(tjoins);
             cc +=  lel[1] * 1;
             cc2 +=  (lel[3] * 1) * (lel[1] * 1);
        }
        $('#tovrcount').html(coocky_t.length);
        $('#tovarsumm').html(cc2);
        if(cc < 6)
        {
             $('#lengv').html(lengv[cc]);
        }
        else
        {
             $('#lengv').html(lengv[5]);
        }
    }
    else
    {
        $('#tovrcount').html(0);
        $('#tovarsumm').html(0);
    }
}

function tova_null()
{
    if(confirm("Вы точно хотите очистить корзину?"))
    {
        var lengv = ['товаров', 'товар', 'товара', 'товара', 'товара', 'товаров'];

        $.cookie("coocky_t", '', {expires: -1, path: "/"});
        $('#tovrcount').html(0);
        $('#tovarsumm').html(0);
        $('#lengv').html(lengv[0]);
        $('.carintovar').html("<p style=\"text-align: center\">Нет товаров в корзине</p>");
    }
}

function oformit(texttitle, tipeins)
{
    var top = true;

    if(tipeins == 1)
    {

        dandajax('');
        $("#doalforoformit").dialog({
            width: 500,
            height: 600,
            resizable: false,
            draggable: true,
            modal : true,
            title: texttitle,
            overlay: {
             backgroundColor: '#000',
             opacity: 0.5
           },
        });
    }
    else
    {
        if(top = in_car_inone())
        {
            dandajax(top);
            $("#doalforoformit").dialog({
                width: 500,
                height: 600,
                resizable: false,
                draggable: true,
                modal : true,
                title: texttitle,
                overlay: {
                 backgroundColor: '#000',
                 opacity: 0.5
               },
            });
        }
    }

}

function dandajax(dates)
{

        $.ajax({
               url: CURRENT_DOMEN + '/ajax.html',
               type: "POST",
               dataType : "html",
               cache: false,
               data: ({formzakaz : 1, dates:dates}),
               beforeSend : function(){
                   $("#doalforoformit").html('Идет загрузка');
               },
               erorre: function()
               {
                   $("#doalforoformit").html('Ошибка, попробуйте еще');
               },
               success: function (data)
               {
                   $("#doalforoformit").html(data);

               }
        });

}

function dclosform()
{
     $("#doalforoformit").html('');
     $("#doalforoformit").dialog('close');
}

function ajax_form_send()
{
     if(ajax_form_send_control() == true)
     {
        var toopt = $('input[name=noborznach]').val().length;
        $.ajax({
               url: CURRENT_DOMEN + '/ajax.html',
               type: "POST",
               dataType : "html",
               cache: false,
               data: $('#doalforoformitform').serialize(),
               beforeSend : function(){
                   $("#doalforoformit").html('Идет обработка данных');
               },
               erorre: function()
               {
                   $("#doalforoformit").html('Ошибка, попробуйте еще');
               },
               success: function (data)
               {
                   $("#doalforoformit").html(data);

                    //w.yaCounter12274444.hit(null, "Заказ на сайте");
                    yaCounter12274444.hit('http://futboland.com.ua/ajax.html', "Заказ на сайте");

                   car_up();
                   if(toopt < 2)
                   {
                        $('.carintovar').html("<p style=\"text-align: center\">Нет товаров в корзине</p>");
                   }
               }
        });
     }
}

function ajax_form_send_control()
{
    if($('input[name=u_name]').val().length < 1 ||
    $('input[name=u_soname]').val().length < 1 ||
    $('input[name=u_phone]').val().length < 1 ||
    $('input[name=u_adress]').val().length < 1 ||
    $('input[name=u_city]').val().length < 1 ||
    $('select[name=u_country]').val().length < 1)
    {
         alert("Не заполненны все обязательные поля!");
         return false;
    }

    if($('input[name=payment]:checked').val() === undefined)
    {
        alert("Не выбран способ оплаты!");
         return false;
    }
    if($('input[name=dostavkainajax]:checked').val() === undefined)
    {
        alert("Не выбран способ доставки!");
         return false;
    }

    return true;
}

function goreturnpass()
{
        $.ajax({
               url: CURRENT_DOMEN + 'ajax.html',
               type: "POST",
               dataType : "html",
               cache: false,
               data: ({form_r_pass: 1}),
               beforeSend : function(){
                   $("#show_version").html('Загрузка...');
               },
               erorre: function()
               {
                   $("#show_version").html('Ошибка, попробуйте еще');
               },
               success: function (data)
               {
                   $("#show_version").html(data);
               }
        });
    $("#show_version").dialog({
    modal: true,
    show: 'slide',
    hide: 'slide',
    title: 'Восстановить пароль',
    width: 500,
    height: 300,
    buttons: {
	      "Закрыть": function() {
               $("#show_version").dialog("close");
	      }},
    });

}

function emailgopass()
{
    var  emailgopass =  $("input[name=emailgopass]").val();
    if(emailgopass.length > 1)
    {
        $.ajax({
               url: CURRENT_DOMEN + 'ajax.html',
               type: "POST",
               dataType : "html",
               cache: false,
               data: ({ emailgopass: emailgopass }),
               beforeSend : function(){
                   $("#show_version").html('Обработка...');
               },
               erorre: function()
               {
                   $("#show_version").html('Ошибка, попробуйте еще');
               },
               success: function (data)
               {
                   $("#show_version").html(data);
               }
        });
    }
    else
    {
         alert("Нужно ввести e-mail");
    }
}