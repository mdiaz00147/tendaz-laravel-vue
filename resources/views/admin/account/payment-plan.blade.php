@extends('layouts.administrator')
@section('title')
    Pagar Plan
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('administrator/css/custom_tendaz.css') }}">
@stop
@section('content')
    <div class="page-header page-header-block">
        <div class="page-header-section">
            <h4 class="title semibold"><i class="fa fa-money"></i>&nbsp;Pagar mi plan</h4>
        </div>
        <div class="page-header-section">
            <div class="toolbar">
                <ol class="breadcrumb breadcrumb-transparent nm">
                    <li>
                        <a href="{{url('admin/home')}}" style="color: grey;">Mi cuenta</a>
                    </li>
                    <li class="tendaz">Pagar mi plan</li>
                </ol>
            </div>
        </div>
    </div>

    @include('admin.partials.message')
    <div class="row checkout">
        <p style="margin-left: 15px">
            {{-- <span class="label label-warning">Tu tienda esta vencida {{ str_replace('termino' , '' , \Carbon\Carbon::parse(Auth::client()->get()->originalSubscription->first()->trial_ends_at)->diffForHumans()) }}</span>--}}
        </p>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading tendaz-panel-heading">
                    <h3 class="panel-title">Detalle del pago</h3>
                </div>
                <div class="panel-body">
                    <p class="text-left">
                        Plan:
                        <strong>{{ $plan->plan->name }}</strong>
                    </p>
                    <a href="{{ url('/admin/account/plans') }}" class="a-tendaz">Cambiar plan</a>
                    <hr>
                    <h4 class="text-left">Valor: <strong class="tendaz">$ {{ $plan->getPrice() }} USD</strong></h4>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading tendaz-panel-heading">
                    <h3 class="panel-title">Selecciona un medio de pago y un per&iacute;odo</h3>
                </div>
                <div class="panel panel-body">
                    <div id="choose-method" class="step choose-method">
                        <div>
                            @include('admin.partials.account.payment.tab-payment')
                            <div class="tab-content responsive hidden-xs hidden-sm">
                                <div role="tabpanel" class="tab-pane active" id="cc">
                                    <div class="panel panel-default cc panel-method">

                                        @include('admin.partials.account.payment.cc-payment')

                                    </div>
                                </div>
                                <div role="tabpanel" id="transfer" class="tab-pane">
                                    <div class="panel panel-default transfer panel-method">

                                        {{-- @include('admin.partials.account.payment.transfer-payment') --}}

                                    </div>
                                </div>
                                <div role="tabpanel" id="ticket" class="tab-pane">
                                    <div class="panel panel-default ticket panel-method">

                                        {{--@include('admin.partials.account.payment.ticket-payment')--}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')

    <script src="{{asset('administrator/js/payform.js')}}"></script>
    <script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.2.0/vue-resource.js"></script>

    <script>
        $(document).on('ready' , function () {
            var price = $(".choose-period").find(".selection").data('price');
            $('#enviar').html('Pagar ' + price + ' USD');

            $(".choose-period").find(".selection").click(function () {
                var $this = $(this);

                var $panel = $this.closest('.panel-method');
                var uuid = $this.data('uuid');
                var installments = $this.data('installments');
                var value = $this.data('price');

                $panel.find(".selection").removeClass('selected');
                $this.addClass('selected');

                $panel.find("input.input_uuid").val(uuid);
                $panel.find("input.input_installments").val(installments);

                $panel.addClass('method-selected');

                $('#enviar').html('Pagar ' + value + ' USD');

                $apps_monthly = $('#apps').find('.monthly');
                if ($panel.find(':selected').hasClass('selected')) {
                    $apps_monthly.hide();
                } else {
                    $apps_monthly.show();
                }

                return false;
            });
            disabledButton()

            /*validateform('#name');
            validateform('#email');
            validateform('#city');
            validateform('#country');
            validateform('#state');
            validateform('#zipCode');
            validateform('#addrLine1');
            */
            $('#card').payform('formatCardNumber');
            $('#expiry').payform('formatCardExpiry');


            $('#card').keyup(function () {
                var val =  $(this).val();

                if ($.payform.validateCardNumber(val)){
                    $(this).parent().addClass('has-success').removeClass('has-error');
                    $(this).parent().find('span.glyphicon-remove').addClass('hidden');
                    $(this).parent().find('span.glyphicon-ok').removeClass('hidden');
                }else{
                    $(this).parent().addClass('has-error');
                    $(this).parent().find('span.glyphicon-remove').removeClass('hidden');
                    $(this).parent().find('span.glyphicon-ok').addClass('hidden');
                }

                if ($.payform.parseCardType( val ) != null) {
                    $('#type-card').html("<strong>" + $.payform.parseCardType( val ) + "</strong>")
                }
                disabledButton();
            });

            $('#expiry').keyup(function () {
                var val =  $(this).val().split('/');
                var month = val[0];
                var year = val[1];
                if ($.payform.validateCardExpiry(month , year)){
                    $(this).parent().addClass('has-success').removeClass('has-error');
                    $(this).parent().find('span.glyphicon-remove').addClass('hidden');
                    $(this).parent().find('span.glyphicon-ok').removeClass('hidden');
                }else{
                    $(this).parent().addClass('has-error');
                    $(this).parent().find('span.glyphicon-remove').removeClass('hidden');
                    $(this).parent().find('span.glyphicon-ok').addClass('hidden');
                }
                disabledButton();
            });

            $('#cvc').keyup(function () {
                var val =  $(this).val();
                if ($.payform.validateCardCVC(val)){
                    $(this).parent().addClass('has-success').removeClass('has-error');
                    $(this).parent().find('span.glyphicon-remove').addClass('hidden');
                    $(this).parent().find('span.glyphicon-ok').removeClass('hidden');
                }else{
                    $(this).parent().addClass('has-error');
                    $(this).parent().find('span.glyphicon-remove').removeClass('hidden');
                    $(this).parent().find('span.glyphicon-ok').addClass('hidden');
                }
                disabledButton();
            });

            $('#name').keyup(function () {
                var val =  $(this).val();
                validateform(this);

            });
            $('#email').keyup(function () {
                var val =  $(this).val();
                validateform(this);

            });

            $('#city').keyup(function () {
                var val =  $(this).val();
                validateform(this);

            });

            $('#country').keyup(function () {
                var val =  $(this).val();
                validateform(this);

            });

            $('#state').keyup(function () {
                validateform(this);
            });

            $('#zipCode').keyup(function () {
                validateform(this);
            });

            $('#addrLine1').keyup(function () {
                validateform(this);
            });


        });

        function validateform(val) {
            var value =  $(val).val();

            if (value != ''){
                $(val).parent().addClass('has-success').removeClass('has-error');
                $(val).parent().find('span.glyphicon-remove').addClass('hidden');
                $(val).parent().find('span.glyphicon-ok').removeClass('hidden');
            }else{
                $(val).parent().addClass('has-error');
                $(val).parent().find('span.glyphicon-remove').removeClass('hidden');
                $(val).parent().find('span.glyphicon-ok').addClass('hidden');
            }
            disabledButton();
        }

        function disabledButton() {
            if ($.payform.validateCardCVC($('#cvc').val())
                && $.payform.validateCardExpiry( $('#expiry').val().split('/')[0] , $('#expiry').val().split('/')[1])
                && $.payform.validateCardNumber(  $('#card').val() )
                && ($('#state').val() != '')
                && ($('#name').val() != '')
                && ($('#country').val() != '')
                && ($('#zipCode').val() != '')
                && ($('#email').val() != ''))
            {
                $('#enviar').attr('disabled' , false);
            }else{
                $('#enviar').attr('disabled' , true);
            }
        }

        var successCallback = function(data) {
            var myForm = document.getElementById('formCardPayment');
            //alert(data.response.token.token);
            myForm.token.value = data.response.token.token;
            //console.log(myForm.token.value);
            myForm.submit();
        };

        var errorCallback = function(data) {
            if (data.errorCode === 200) {
            } else {
                alert(data.errorMsg);
            }
        };

        var tokenRequest = function() {
            var args = {
                sellerId: "{{ env('SELLER_ID_TWO') }}",
                publishableKey: "{{ env('PUBLIC_KEY_TWO') }}",
                ccNo: $("#card").val(),
                cvv: $("#cvc").val(),
                expMonth: $("#expiry").val().split('/')[0].trim(),
                expYear: $("#expiry").val().split('/')[1].trim()
                /*ccNo: '4000000000000002',
                cvv: '123',
                expMonth: '02',
                expYear:'20'*/
            };
            console.log(args);
            TCO.requestToken(successCallback, errorCallback, args);
        };

        $(function() {

            TCO.loadPubKey( @if (env('SANBOX_TWO',false)) 'sandbox' @else 'production' @endif );
            $("#enviar").click(function(e) {
                $("#enviar").button('loading');
                tokenRequest();
                return false;
            });
        });

    </script>

@stop
