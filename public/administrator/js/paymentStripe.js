$(document).on('ready', function () {
    //si ya esta subscrito a un plan a cual plan es para que lo deje marcado
    //si no pss para que deje el mejor por default

    var plan = $('input[name=plan_now]').val();
    if(plan == undefined)
    {//se marca el ultimo plan de sucription como verdadero
        $('input[name=plans]').last().prop('checked',true);
        //al label que lo contiene se le pone una clase apra que resalte
        $('input[name=plans]').last().parent().parent().parent().addClass('selected');
        //se envia el valor a un input del formulario para saber que plan va pagar
        $('#plan').val($('input[name=plans]').last().val());
        $('.well').last().find('p').css('color' , 'orange');
    }else{
        //se marca el ultimo plan de sucription como verdadero
        $('input[name=plans][value='+ plan + ']').last().prop('checked',true);
        //al label que lo contiene se le pone una clase apra que resalte
        $('input[name=plans][value='+ plan + ']').last().parent().parent().parent().addClass('selected');
        //se envia el valor a un input del formulario para saber que plan va pagar
        $('#plan').val($('input[name=plans][value='+ plan + ']').last().val());
        $('input[name=plans][value='+ plan + ']').parent().parent().parent().find('p').css('color' , 'orange');
    }
    //aqui traducimos los errores lanzados por stripe segun el codigo de error
    var errorMessages = {
        invalid_request_error : "No se pudo encontrar la informaci�n de pago",
        incorrect_number: "El n�mero de la tarjeta es incorrecta.",
        invalid_number: "El n�mero de la tarjeta no es una tarjeta de cr�dito v�lida .",
        invalid_expiry_month: "Mes de vencimiento de la tarjeta no es v�lida .",
        invalid_expiry_year: "A�o de caducidad de la tarjeta no es v�lida .",
        invalid_cvc: "c�digo de seguridad de la tarjeta no es v�lida .",
        expired_card: "La tarjeta ha expirado.",
        incorrect_cvc: "C�digo de seguridad de la tarjeta es incorrecto.",
        incorrect_zip: "The card's zip code failed validation.",
        card_declined: "El c�digo postal de la tarjeta fallado la validaci�n.",
        missing: "No hay ninguna tarjeta de un cliente que est� siendo cargada.",
        processing_error: "Se ha producido un error al procesar la tarjeta.",
        rate_limit:  "Se produjo un error debido a las peticiones que golpean la API demasiado r�pido . Por favor , h�ganos saber si usted est� funcionando constantemente en este error ."
    };
    //si llegase a estar vacio el plan entonces el boton se deshabilita
    if($('#plan').val() == ''){
        $('body').find('button').prop('disabled','disabled');
    }
    //cuando cambia e plan
    $('input[name=plans]').on('change', function () {
        //quita la sellecion del ultimo plan
        $.each($('.well') , function () {
            $(this).removeClass('selected');
            $(this).find('p').css('color' , 'black');
        });
        //y agrega la sellecion a dicho plan al igual que envia el valor al input
        if($(this).is(':checked')){
            $(this).parent().parent().parent().addClass('selected');
            $(this).parent().find('p').css('color' , 'orange');
            $('#plan').val($(this).val());
        }
        if($('#plan').val() == ''){
            $('body').find('button').prop('disabled','disabled');
        }else{
            $('body').find('button').prop('disabled',false);
        }
        //Esta opcion es para cuando quiere cambiar de sucripcion pero de uun mismo plan
        //intercambia los botones
        if(plan != undefined){
            if(plan != $('input[name=plan]').val()){
                $('.swap').removeClass('hidden');
                $('.swap').show();
                $('.cancel').hide();
            }else{
                $('.swap').hide();
                $('.cancel').show();
            }
        }
    });
    //con el plugin validamos los input de numero de tarjeta a�o y cvc
    $(document).on('mousemove' , function(){
        $('.cc-number').payment('formatCardNumber');
        $('.cc-exp').payment('formatCardExpiry');
        $('.cc-cvc').payment('formatCardCVC');
    });

    //funcion que agrega una seleccion al input con error
    $.fn.toggleInputError = function(erred) {
        this.parent('.form-group').toggleClass('has-error', erred);
        this.parent('.form-group').find('input').toggleClass('has-error-background', erred);
        return this;
    };
    var form = $('.payment-form');
    //cuando se levanta la tecla mira quue tipo de tarjeta es y muestra su imagen
    $(form).keyup('.cc-number' , function () {
        var cardType = $.payment.cardType($('.cc-number').val());
        if(cardType != null && cardType != 'forbrugsforeningen') {
            $('.image-card').removeClass('hidden');
            $('.image-card').attr('src' , BASEURL +'/images-card/' + cardType + '.png');
        }else{
            $('.image-card').addClass('hidden');
        }
    });
    //Envia la llave publica a stripe
    document.querySelector("body").addEventListener("keydown",function(e){
        var charCode = e.charCode || e.keyCode || e.which;
        if (charCode == 27){
            return false;
        }
    });
    //funcion para validar el plan o suscripcion al que pertenece el usuario y luego actualizar plan crear suscripcion o cancelar
    $('.swap').on('click' , function(){
        $(this).attr('disabled' , true).text('Cambiando plan .......');
        var id = $('input[name=planSwap]').val();
        var plan = $('input[name=plan]').val();
        window.location.href = BASEURL + '/admin/account/plans/swap' + '/' + id + '/' + plan;
    });
    $('.cancel').on('click' , function(){
        var confirm = window.confirm('Estas seguro de cancelar el plan');
        if(confirm){
            $(this).attr('disabled' , true).text('Cancelando el plan......');
            window.location.href = BASEURL +'/admin/account/plans/cancel';
        }
    });
    Stripe.setPublishableKey(STRIPE_PUBLIC_KEY);
    $('.payment-success').click(function(e) {
        //al dar clck a pgar
        e.preventDefault();
        var form = $('.payment-form');
        var submit = $(this);
        var submitInitialText = submit.text();
        var inputName = form.find('input[name=name]');
        var inputLast = form.find('input[name=last_name]');
        if(inputName == undefined || inputLast == undefined){
            bool = true;
            bool2 = true;
        }else{
            var bool = toogleError(required(inputName.val()) , inputName);
            var bool2 = toogleError(required(inputLast.val()) , inputLast);
        }
        //deshabilita el boton y envia un mensaje
        submit.attr('disabled' , 'disabled').text('Espera un momento ....');
        $('.cancel-payment').attr('disabled' , 'disabled');
        $('dismiss').hide();
        Stripe.card.createToken(form , function(status , response){
            var token ;
            //envia el token a stripe y s tiene error lo traduce y muestra en un div
            if(response.error){
                if(response.error.type == 'card_error' ){
                    $('.payment-errors').text(errorMessages[ response.error.code ]);
                }else{
                    $('.payment-errors').text(errorMessages['invalid_request_error']);
                }
                $('.payment-errors').parent().parent().show();

                submit.removeAttr('disabled');
                $('.cancel-payment').attr('disabled' , false);
                $('.dismiss').show();
                submit.text(submitInitialText);
            }else{
                //si no envia los datos al formulario
                token = response.id;
                form.append($('<input type="hidden" name="token">').val(token));
                if(bool && bool2){
                    form.submit();
                }else{

                    submit.removeAttr('disabled');
                    submit.text(submitInitialText);
                    $('.cancel-payment').attr('disabled' , false);
                }
            }
        });

    });
    $('.payment-with-is-susbcribed').on('click' , function (e) {
        e.preventDefault();
        var form = $('.payment-form');
        var submit = $(this);
        var submitInitialText = submit.text();
        var inputName = form.find('input[name=name]');
        var inputLast = form.find('input[name=last_name]');
        if(inputName == undefined || inputLast == undefined){
            bool = true;
            bool2 = true;
        }else{
            var bool = toogleError(required(inputName.val()) , inputName);
            var bool2 = toogleError(required(inputLast.val()) , inputLast);
        }

        if(bool && bool2){
            $('.preloader_general').removeClass('hidden');
            $('.preloader_image_general').addClass('hidden');
            preload('' , ['Comprando el dominio' , 'Redirigiendo el host' , 'Preparando tu tienda' , 'Terminando Proceso']);
            form.submit();
        }else{
            submit.removeAttr('disabled');
            submit.text(submitInitialText);
            $('.cancel-payment').attr('disabled' , false);
        }
    });

    $('.payment-full').click(function (e) {
        e.preventDefault();
        var form = $('#payment-form-domain');
        var submit = $(this);

        var submitInitialText = submit.text();
        //deshabilita el boton y envia un mensaje
        submit.attr('disabled' , 'disabled').text('Espera un momento ....');
        $('.cancel-payment').attr('disabled' , 'disabled');
        $('dismiss').hide();
        Stripe.card.createToken(form , function(status , response){
            var token ;
            //envia el token a stripe y s tiene error lo traduce y muestra en un div
            if(response.error){
                submit.removeAttr('disabled');
                $('.cancel-payment').attr('disabled' , false);
                $('.dismiss').show();
                submit.text(submitInitialText);
            }else{
                //si no envia los datos al formulario
                token = response.id;
                form.append($('<input type="hidden" name="token">').val(token));
                form.append($('<input type="hidden" name="plan">').val(plan));
                form.submit();
            }
        });
    });
    $('.update-card').click(function(e) {
        //al dar clck a pgar
        e.preventDefault();
        var form = $('.payment-form-update');
        var submit = $(this);
        var submitInitialText = submit.text();
        //deshabilita el boton y envia un mensaje
        submit.attr('disabled' , 'disabled').text('Espera un momento ....');
        $('.cancel-payment').attr('disabled' , 'disabled');
        $('dismiss').hide();
        Stripe.card.createToken(form , function(status , response){
            var token ;
            //envia el token a stripe y s tiene error lo traduce y muestra en un div
            if(response.error){
                if(response.error.type == 'card_error' ){
                    $('.payment-errors').text(errorMessages[ response.error.code ]);
                }else{
                    $('.payment-errors').text(errorMessages['invalid_request_error']);
                }
                $('.payment-errors').parent().parent().show();
                submit.removeAttr('disabled');
                $('.cancel-payment').attr('disabled' , false);
                $('.dismiss').show();
                submit.text(submitInitialText);
            }else{
                //si no envia los datos al formulario
                token = response.id;
                form.append($('<input type="hidden" name="token">').val(token));
                form.submit();
            }
        });
        //pone la clase error si esta mal algun campo de testo
        var cardType = $.payment.cardType($('.cc-number').val());
        $('.cc-number').toggleInputError(!$.payment.validateCardNumber($('.cc-number').val()));
        $('.cc-exp').toggleInputError(!$.payment.validateCardExpiry($('.cc-exp').payment('cardExpiryVal')));
        $('.cc-cvc').toggleInputError(!$.payment.validateCardCVC($('.cc-cvc').val(), cardType));
        if(cardType != null && cardType != 'forbrugsforeningen') {
            $('.image-card').removeClass('hidden');
            $('.image-card').attr('src' , BASEURL +'/images-card/' + cardType + '.png');
        }else{
            $('.image-card').addClass('hidden');
        }
    });
    function toogleError(bool , input){
            input.parent('.form-group').toggleClass('has-error', bool);
            input.toggleClass('has-error-background', bool);
            return !bool;
    }
    function required(val){
        if(val != ''){
            return false;
        }else{
            return true;
        }
    }
    function preload(point , message){
        var horiz = $(document).width()+200;
        var naturalHoriz = $('.preloader_p').width()+67;
        setTimeout(function(){
            if(message[0] == undefined){
                message = ['Comprando el dominio' , 'Redirigiendo el host' , 'Preparando tu tienda' , 'Terminando Proceso'];
            }
            point += '.';
            var pre = $('.preloader_p').html(message[0] + ' ' + point);
            if(point.length == 5){
                pre.animate({left: horiz+'px'});
            }

            if(point.length < 5 ){
                preload(point , message)
            }else{
                var mess = $.grep(message , function (n , i) {
                    return i > 0;
                });
                preload('' , mess)
            }

            if(point.length == 1){
                pre.animate({left: naturalHoriz+'px'});
            }
        }, 2000);
    }
});