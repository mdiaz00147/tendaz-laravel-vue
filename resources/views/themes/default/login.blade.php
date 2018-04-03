@extends('themes.default.template')
    @section('css')
    <style type="text/css">
        .btn span.fa {  opacity: 0;  }
        .btn.active span.fa {  opacity: 1;  }
    </style>

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
           @stop
    @section('content')
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 login-register-form">
                            <div class="title"><span>Crea tu cuenta</span></div>
                            <div class="row">
                                <form ng-submit="doRegister(registerForm)" name="registerForm" role="form" data-toggle="validator">
                                    <div class="form-group col-sm-3"  ng-class="{'has-error has-feedback' : registerFormR.RegisterName.$invalid && formSubmited }">
                                        <label for="nameInput">Nombre</label>
                                        <input type="text" ng-model="registerFormR.RegisterName" class="form-control" id="nameInput" placeholder="Nombre" value="{{ old('name') }}" name="name" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-3" ng-class="{'has-error has-feedback' : registerForm.RegisterLastName.$invalid && formSubmited }">
                                        <label for="nameInput">Apellido</label>
                                        <input type="text"  ng-model="registerFormR.RegisterLastName" class="form-control" id="nameInput" placeholder="Apellido" value="{{ old('last_name') }}" name="last_name" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6" ng-class="{'has-error has-feedback' : registerForm.RegisterMail.$invalid && formSubmited }">
                                        <label for="emailInput">Email</label>
                                        <input type="email" ng-model="registerFormR.RegisterMail" class="form-control" id="emailInput" placeholder="Email" value="{{ old('email') }}" name="email" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="passwordInput">Contrase&ntilde;a</label>
                                        <input type="password" ng-model="registerFormR.RegisterPassword" class="form-control" id="inputPassword" name="password" placeholder="Contrase&ntilde;a" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="passwordConfirmInput">Confirmar Contrase&ntilde;a</label>
                                        <input type="password" ng-model="registerFormR.RegisterPasswordConfirm" class="form-control"  name="password_confirmation" data-match-error="Upz, Contrase&ntilde;as no son iguales"
                                               id="inputPasswordConfirm" data-match="#inputPassword" placeholder="Repetir Contrase&ntilde;a" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <div class=""  data-toggle="buttons">
                                            <label class="btn btn-default btn-xs">
                                                <input type="checkbox"  autocomplete="off" style="zoom: 2.0;" required>
                                                <span class="fa fa-check" style="color: darkblue;"></span>
                                            </label> &nbsp; <a data-toggle="modal" data-target="#modalConditions" >Acepto Terminos y Condiciones.</a>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <div class=""  data-toggle="buttons">
                                            <label class="btn btn-default btn-xs active">
                                                <input type="checkbox"  autocomplete="off" style="zoom: 2.0;">
                                                <span class="fa fa-check" style="color: darkblue;"></span>
                                            </label> &nbsp; Acepto Envios de Correos.
                                        </div>
                                    </div>
                                        
                                    <div class="col-xs-12">
                                        <button type="submit" class="btn btn-sm"><i class="fa fa-long-arrow-right"></i> Registrate</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="title"><span>Ya te encuentras registrado ?</span></div>
                            <form name="loginForm" ng-submit="doLogin(loginForm)" role="form" data-toggle="validator">
                                <p ng-repeat="error in erroreslogin" ng-show="errores" class="error-login">Correo o contrase&ntilde;a incorrecta!</p>
                                <div class="form-group">
                                    <label for="emailInputLogin">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" ng-model="formLog.loginMail" id="email" placeholder="Email" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="passwordInputLogin">Contrase&ntilde;a</label>
                                    <input type="password" class="form-control" name="password" ng-model="formLog.loginPassword" id="password" placeholder="Contrase&ntilde;a" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                 
                                <div class=""  data-toggle="buttons">
                                    <label class="btn btn-default btn-xs">
                                        <input type="checkbox"  autocomplete="off" style="zoom: 2.0;">
                                        <span class="fa fa-check" style="color: darkblue;"></span>
                                    </label> &nbsp; Recordarme
                                </div>
                                <br>
                                <button type="submit" class="btn btn-sm"><i class="fa fa-long-arrow-right"></i> Iniciar Sesion</button>
                                <p><a data-toggle="modal" data-target="#modalRestorePassword">Olvidaste la Contase&ntilde;a?</a></p>
                            </form>
                            <div style="margin-bottom: 30px;"></div>
                            <div style="margin-bottom: 30px;"></div>
                            <div class="col-md-12 hidden">
                                @if(count($socials) == 2)
                                <div class="title"><span>Iniciar con</span></div>
                                @endif
                                @foreach($socials as $social)
                                    @if(!empty($social->provider == "facebook"))
                                        @if(!empty($social->app_id) && !empty($social->app_secret))
                                            <div class="text-center col-md-6">
                                                <a href="{{ url('auth/facebook') }}" class="btn btn-primary btn-md sb-facebook" style="cursor: pointer">
                                                    <i class="fa fa-facebook"></i> Facebook
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                    @if(!empty($social->provider == "google"))
                                        @if(!empty($social->app_id) && !empty($social->app_secret))
                                        <div class="text-center col-md-6">
                                            <a href="{{ url('auth/google') }}" class="sb-twitter" style="cursor: pointer">
                                                <button type="button" class="btn btn-danger btn-md"><i class="fa fa-google-plus"></i> Google Plus</button>
                                            </a>
                                        </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @include('themes.default.password.email')
           @endsection
    @section('script')
           @stop