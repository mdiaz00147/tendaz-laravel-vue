
<div class="middle-header">
    <div class="container">
        <div class="main-header">
            <div class="row">
                <div class="col-md-2">
                    <a href="{{url('/')}}" style="text-decoration: none">
                        @if($shop->logo)
                            <img style="max-height: 100px" class="logo replace-2x img-responsive" src="{{ asset("logos/$shop->id/$shop->logo") }}"
                                 alt="Logo de la tienda {{ $shop->name_store }}" />
                        @else
                            <h1>{{ $shop->name }}</h1>
                        @endif
                    </a>
                </div>
                <!-- Search Form -->
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 cart-btn">
                    <form action="{{ url('/products') }}" method="get" style="margin-bottom: 5px">
                        <div class="input-group">
                            <input type="text" class="form-control input-search" name="search" value="" maxlength="128" placeholder="Buscar producto..."/>
	                            <span class="input-group-btn">
	                                <button class="btn btn-default no-border-left" type="submit" style="height: 34px; background-color: #2196F3">
                                        <i class="fa fa-search" style="color: white"></i></button>
	                            </span>
                        </div>
                    </form>
                </div>
                <!-- End Search Form -->
                @if(!Request::is('cart/buy'))
                <div class="col-sm-4 col-md-3 cart-btn"  ng-controller="cartGlobalController" ng-cloak="">
                    <button type="button" class="hidden-xs hidden-sm btn btn-default dropdown-toggle" id="dropdown-cart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="fa fa-shopping-cart"></i> Carrito de compras : <% carts.original_qty %> item(s) <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-cart">

                        <div class="media" ng-repeat="cart in carts.products.data" ng-cloak="">
                            <div class="media-left">
                                <img class="media-object" ng-src="<% cart.images.data[0].url %>" width="50" alt="product">
                            </div>
                            <div class="media-body">
                                <a href="#"><% cart.name %></a>
                                <div>$<% cart.price | number:2 %> x <% cart.quantity %></div>
                            </div>
                            <div class="media-right"><a href="#" ng-click="destroy(cartId , cart )" ><i class="fa fa-trash-o"></i></a></div>
                        </div>

                        <div class="subtotal-cart">Subtotal: <span>$ <% carts.original_total | number:2 %></span></div>
                        <div class="text-center chart-checkout-btn">
                            <div class="btn-group" role="group" aria-label="View Cart and Checkout Button">
                                <a href="{{url('cart/buy')}}">
                                <button class="btn btn-default btn-sm" type="button"><i class="fa fa-shopping-cart"></i> Ver el carrito</button>
                                </a>
                                <a href="{{url('checkout')}}">
                                <button class="btn btn-default btn-sm" type="button"><i class="fa fa-check"></i> Ir checkout</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-sm-12 col-md-2">
                    <img class="pull-right hidden-xs hidden-sm" src="{{asset('administrator/image/servientrega-banner.png')}}" style="margin: 10px 20px" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
