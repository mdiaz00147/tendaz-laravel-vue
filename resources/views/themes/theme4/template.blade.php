<!DOCTYPE html>
<html ng-app="app">
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="Tienda online gratis por 15 dias tendaz.com " />
		<meta name="description" content="Tienda virtual creada en tendaz.com">
		<meta name="author" content="tendaz.com">
		<link rel="icon" type="image/png" href="{{asset('logos/'.$shop->id.'/'.$shop->logo)}}" />
		<title>Tienda online de {{ $shop->name }}</title>
	<!--Css-->
		{!! Theme::css('themes_tendaz/tema4/external/slick/slick.css') !!}
		{!! Theme::css('themes_tendaz/tema4/external/slick/slick-theme.css') !!}
		{!! Theme::css('themes_tendaz/tema4/external/magnific-popup/magnific-popup.css') !!}
		{!! Theme::css('themes_tendaz/tema4/external/nouislider/nouislider.css') !!}
	    {!! Theme::css('themes_tendaz/tema4/external/bootstrap-select/bootstrap-select.css') !!}
		{!! Theme::css('themes_tendaz/tema4/external/rs-plugin/css/settings.css') !!}
	    {!! Theme::css('themes_tendaz/tema4/css/style.css') !!}
	    {!! Theme::css('themes_tendaz/tema4/font/style.css') !!}
		<link rel="stylesheet" href="{{asset('components/css/toastr.min.css')}}">
	
	<script>
		var BASEURL = "{{ App::environment('local') ? 'http://'.env('APP_API_URL').env('APP_API_PORT') : 'https://'.env('APP_API_URL').env('APP_API_PORT') }}";
		var store = "{{ $shop->id }}";
		var client_id = "{{ $shop->id }}";
		var client_secret = "{{ $shop->uuid }}";
		var category = "{{ isset($category)	 ? $category : ''}}";
		var slug = "{{ isset($slug) ? $slug : ''}}";
        var uuid = "{{ isset($uuid) ? $uuid : ''}}";
		
	</script>
	<style>
		.modal-content{
			min-height: 450px;
		}
		a:hover{
			cursor: pointer;
		}
		.megamenu > li:hover .deleteHover span {
			color: black;
		}
		.megamenu >  li > a:hover  span {
			color: #1fc0a0 !important;
		}
		#header.header-layout-03 .link-inline ul li{
			display: block !important;
			margin-right: 0 !important;

		}
		#header.header-layout-03 .link-inline ul{
			padding-bottom: 0 !important;
		}
		[ng\:cloak], [ng-cloak], .ng-cloak {
			display: none !important;
		}
		.alert > ul {
			margin-bottom: 0;
			margin-left: -20px;
		}
	</style>
		@yield('css')
	<!--Fin-->

</head>
<body style="{{ auth('admins')->check() ? 'margin-top:32px' : 'margin-top:32px' }}">
	@include(Theme::current()->viewsPath.'.partials.nav-movile')
	@include(Theme::current()->viewsPath.'.partials.header')
		<div id="pageContent">
			@yield('content')
		</div>
		@include(Theme::current()->viewsPath.'.partials.modal_login')
		@include(Theme::current()->viewsPath.'.partials.restore_password')
		@include(Theme::current()->viewsPath.'.partials.modal_register')
		@include(Theme::current()->viewsPath.'.partials.footer')

	<!--Script-->
	<script src="{{asset('bower_components/angular/angular.js') }}"></script>
	<script src="{{asset('components/js/jquery-2.1.1.min.js')}}"></script>
	<script src="{{asset('themes_tendaz/default/js/validator.js')}}"></script>
	<script src="{{asset('components/js/toastr.min.js')}}"></script>
	<script src="{{asset('themes_tendaz/tema4/external/bootstrap/bootstrap.min.js') }}"></script>
	<script src="{{asset('themes_tendaz/tema4/external/countdown/jquery.plugin.min.js') }}"></script>
	<script src="{{asset('themes_tendaz/tema4/external/countdown/jquery.countdown.min.js') }}"></script>
	<script src="{{asset('themes_tendaz/tema4/external/instafeed/instafeed.min.js') }}"></script>
	<script src="{{asset('themes_tendaz/tema4/external/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{asset('themes_tendaz/tema4/external/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
	<script src="{{asset('themes_tendaz/tema4/external/colorbox/jquery.colorbox-min.js') }}"></script>
	<script src="{{asset('themes_tendaz/tema4/external/nouislider/nouislider.min.js') }}"></script>
	<script src="{{ asset('themes_tendaz/tema4/external/elevatezoom/jquery.elevatezoom.js') }}"></script>
	<script src="{{asset('themes_tendaz/tema4/js/custom.js') }}"></script>
 	<script src="{{asset('bower_components/angular-route/angular-route.min.js') }}"></script>
	<script src="{{asset('bower_components/angular-cookies/angular-cookies.min.js') }}"></script>
	<script src="{{asset('components/js/underscore-min.js') }}"></script>
	<script src="{{asset('Angular/app.js') }}"></script>
	<script src="{{asset('themes_tendaz/tema4/external/slick/slick.min.js') }}"></script>
	<script src="{{asset('components/js/slick.js') }}"></script>

	<!-- AngularScripts -->
	@include('themes.angularScripts')

	<script type="text/ng-template" id="tpl.html" >
		<div id="megaMenuCarousel1" class="product"  ng-class="{ ' sold-out' : product.stock == 0 , ' product--zoom' : !product.promotion && !product.feature} ">
			<div class="product__inside">
				<div class="product__inside__image">
					<a href="{{ url('/') }}<% '/detail/' + product.slug %>">
							<img ng-src="<% product.images.data[0].url %>" alt="" ng-show="product.images.data"  >
						<img ng-src="<% BASEURL + '/administrator/image/noImage.png' %>" ng-hide="product.images.data" >
					</a>
					<div class="product__label--sold-out" ng-show="product.stock == 0">
                        <span>
                            Sin<br>
                            Stock
                        </span>
					</div>
				</div>
				<div class="product__label product__label--left product__label--sale" ng-if="product.special_price">
              <span>Sale<br>
                  <% product.promotion_price_percent | number:0 %>%
              </span>
				</div>
				<div class="product__inside__name">
					<h2><a href="<%'/detail/' + product.slug %>"><% product.name %></a></h2>
				</div>
				<div class="product__inside__price price-box" ng-if="product.special_price">
					$<% product.special_price | currency:"":0 %>
                <span class="price-box__old" >
                      $<% product.price | currency:"":0 %>
                </span>
				</div>
				<div class="product__label product__label--right product__label--new" ng-if="product.new"> <span>Nuevo</span> </div>
				<div class="product__inside__price price-box" ng-if="!product.special_price">
					$<% product.price | currency:"":0%>
				</div>
				<div class="product__inside__hover">
					<div class="product__inside__info">
						<div class="product__inside__info__btns">
							<a href="#" class="btn btn--ys btn--xl" ng-hide="product.stock == 0" ng-click="add(cartId , product)">
								<span class="icon icon-shopping_basket"></span> Agregar
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>

	@yield('script')
	<!--- iframe -->
	@include('globalPartials.iframeAdmin')
	@include('themes.theme4.partials.conditions')
	<script>
		$(document).on('ready' , function () {
			$('.register').click(function () {
				$(this).attr('disabled' , true);
				$(this).find('span').hide();
				$(this).find('i').removeClass('hidden');
				$('#form-register').submit();
			});
			$('.login').click(function () {
				$(this).attr('disabled' , true);
				$(this).find('.fa-arrow-right').hide();
				$(this).find('.fa-spinner').removeClass('hidden');
				$('#form-login').submit();
			});
		});

	</script>
	<script>
		$(document).ready(function() {
			listingModeToggle();

				productCarousel($('.banner-slider'),1,1,1,1,1);
				productCarousel($('#carouselNew'),3,2,2,2,1);
				productCarousel($('#carouselSale'),3,2,2,2,1);
				productCarousel($('#carouselFeatured'),6,4,3,2,1);
				productCarousel($('#megaMenuCarousel1'),1,1,1,1,1);
				mobileOnlyCarousel();
			$('li').on('mouseover','.deleteHover', function () {
				$(this).parent().removeClass('hover');
			});
			$(document).scroll(function() {
				var y = $(this).scrollTop();
				if (y > 200) {
					$('.name-text').hide();
				} else {
					$('.name-text').fadeIn();
				}
			});
			$(document).on('ready' , function () {
				var y = $(this).scrollTop();
				if (y > 200) {
					$('.name-text').hide();
				} else {
					$('.name-text').fadeIn();
				}
			});
			 });
</script>
<!--Fin-->
</body>
</html>