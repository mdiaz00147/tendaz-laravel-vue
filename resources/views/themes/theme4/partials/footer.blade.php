<footer class="fill-bg layout-1">
	<div class="container inset-bottom-60">
		<div class="row" >
			<div class="col-xl-3 visible-xl">
				<div class="footer-logo hidden-xs">
					@if($shop->path)
						<img class="logo replace-2x img-responsive" src="{{ asset("logos/$shop->id/$shop->path") }}"  alt="Logo de la tienda {{ $shop->name_store }}" />
					@else
						<h4 class="text-left  title-under  mobile-collapse__title">{{ $shop->name_store }}</h4>
					@endif
				</div>
				<div class="box-about">
					<div class="mobile-collapse">
						<h4 class="mobile-collapse__title visible-xs">SOBRE NOSOTROS</h4>
						<div class="mobile-collapse__content">
							<address class="box-address">
								<span class="icon icon-home {{ $shop->address_contact ? '' : 'hidden' }}"></span>{{ $shop->address_contact }}<br>
								<span class="icon icon-call {{ $shop->phone_country ? '' : 'hidden' }}"></span> <b class="color-dark {{ $shop->phone_country ? '' : 'hidden' }}">+{{ ($shop->phone_country).' '.$shop->phone_number }} </b><br>
								<span class="icon icon-markunread {{ $shop->email_contact ? '' : 'hidden' }}"></span> <a class="color" href="mailto:{{ $shop->email_contact }}">{{ $shop->email_contact }}</a>
							</address>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="mobile-collapse">
					<h4 class="text-left  title-under  mobile-collapse__title">INFORMACION</h4>
					<div class="v-links-list mobile-collapse__content">
						<ul>
							<li><a href="{{ url('/') }}">Inicio</a></li>
							<li><a href="{{ url('/cart/buy') }}">Carrito</a></li>
							<li><a href="{{ url('products') }}">Productos</a></li>
							<li><a href="{{url('contact')}}">Contactenos</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="mobile-collapse">
					<h4 class="text-left  title-under  mobile-collapse__title">MAS INFORMACI&Oacute;N</h4>
					<div class="v-links-list mobile-collapse__content" >
						<ul>
							@if(!$shop->store->address_1 == '')
							<li><strong>Email:</strong> <span> {{$shop->store->address_1}}</span></li>
							@endif
							@if(!$shop->store->number_phone == '')
							<li><strong>Telefono: </strong><span> {{$shop->store->number_phone}}</span></li>
							@endif
							@if(!$shop->store->address_2 == '')
							<li><strong>Direcci&oacute;n: </strong><span> {{$shop->store->address_2}}</span></li>
							@endif
							@if(!$shop->store->conditions == '')
							<li><a href="#" data-toggle="modal" data-target="#modalConditions">Terminos  y condiciones</a></li>
							@endif
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="mobile-collapse">
					<h4 class="text-left  title-under  mobile-collapse__title">MI CUENTA</h4>
					<div class="v-links-list mobile-collapse__content">
						<ul>
							<li><a href="#" data-toggle="modal" data-target="#modalRegisterForm">Registrate</a></li>
							<li><a href="#" data-toggle="modal" data-target="#modalLoginForm" >Inicio sesion</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="divider divider--lg visible-md visible-sm"></div>
			<div class="col-md-5" ng-controller="customerStoreController">
				<div class="subscribe-box">
					<div class="mobile-collapse">
						<h4 class="text-left  title-under  mobile-collapse__title">NOTICIAS</h4>
						<div class="mobile-collapse__content">
							<form class="form-inline" name="userForm" ng-submit="sendSubscriber(userForm.$valid)" ng-show="!letter.news" novalidate>
								<input class="subscribe-form__input" type="email"  name="subscribe" ng-model="letter.email" required>
								<button type="submit" class="btn btn--ys btn--xl">SUSCRIBIRSE</button>
							</form>
							<div class="contact-ok alert alert-success text-center-xs" ng-show="letter.news">
								<i class="fa fa-check-circle fa-2x d-inline pull-left m-half-right m-none-xs m-quarter-bottom-xs"></i>
								<p>Se inscribi&oacute; al newsletter correctamente.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="divider divider--md"></div>
				<div class="social-links social-links--large social-links-layout-02">
					<ul>
						@if(!$shop->store->facebook == '')
							<li><a class="icon fa fa-facebook" href="{{url('https://'.$shop->store->facebook)}}"></a></li>
						@endif
						@if(!$shop->store->twitter == '')
							<li><a class="icon fa fa-twitter" href="{{url('https://'.$shop->store->twitter)}}"></a></li>
						@endif
						@if(!$shop->store->google_plus == '')
							<li><a class="icon fa fa-google-plus" href="{{url('https://'.$shop->store->google_plus)}}"></a></li>
						@endif
						@if(!$shop->store->instagram == '')
							<li><a class="icon fa fa-instagram" href="{{url('https://'.$shop->store->instagram)}}"></a></li>
						@endif
						@if(!$shop->store->blog == '')
							<li><a class="icon fa fa-twitc+h" href="{{url('https://'.$shop->store->blog)}}"></a></li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="divider divider-md visible-sm"></div>
	<div class="container footer-copyright">
		<div class="row">
			<div class="col-lg-12">
				<img src="{{asset('administrator/image/servientrega-footer.gif')}}" alt="" height="20px">
				&copy; 2017 .Todos lo derechos reservados.
			</div>
		</div>
	</div>
	<a href="#" class="btn btn--ys btn--full visible-xs" id="backToTop">Back to top <span class="icon icon-expand_less"></span></a>
</footer>