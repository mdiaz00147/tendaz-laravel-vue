@section('title')
MaxI Bot
@stop
@extends('layouts.administrator')
@section('css')

@stop
@section('content')
<div class="page-header page-header-block">
	<div class="page-header-section">
		<h4 class="title">
			<img class="page-header-section-icon" src="{{asset('administrator/image/icons/icons-base/roboto.png')}}">&nbsp; Robot Maxi  
		</h4>
	</div>
	<div class="page-header-section">
		<div class="toolbar">
			<ol class="breadcrumb breadcrumb-transparent nm">
				<li><a href="{{url('admin')}}" style="color: darkgrey;">Inicio</a></li>
				<li><a href="#" style="color: darkgrey;">Marketing</a></li>
				<li class="active" style="color: orange;">Robot Maxi</li>
			</ol>
		</div>
	</div>
</div>
<div class="row">
<div class="col-md-6 col-md-12">
<div class="panel panel-default">
	<div class="panel-heading" style="background-color: #f26522">
		<h4 class="title text-center" style="color: white;">Configuracion MaxiBoot</h4>
	</div>
	<div class="panel-body">
		<form action="{{url('admin/marketing/robot')}}" name="maxi_config" method="POST" role="form">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="form-group">
				<div class="row">
					<div class="clearfix"></div>
					<div style="margin-bottom: 10px !important;"></div>
					<div class="col-sm-1">
						<div style="margin-bottom: 10px !important;"></div>
						<p style="margin-left: 25px !important;margin-top: 35px !important;" class="hidden-sm hidden-xs">
							<i class="fa fa-caret-right fa-2x" aria-hidden="true" style="color:  #F97600;"></i>
						</p>
					</div>
					<div class="col-md-10">
						<p class="text-left">
							Selecciona las <strong>CATEGORIAS</strong> para lista negra.
						</p>
						<div class="col-md-12">
							<select name="categories[]" class="select2" id="category" multiple="1" style='width: 100%'>
								@foreach($categories as $category)
									<option value="{{$category->id}}">{{$category->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12"><hr></div>
			<div class="form-group">
				<div class="row">
					<div class="clearfix"></div>
					<div style="margin-bottom: 10px; !important;"></div>
					<div class="col-sm-1">
						<div style="margin-bottom: 10px !important;"></div>
						<p style="margin-left: 25px !important;margin-top: 55px !important;" class="hidden-sm hidden-xs">
							<i class="fa fa-caret-right fa-2x" aria-hidden="true" style="color:  #F97600;"></i>
						</p>
					</div>
					<div class="col-sm-10">
						<p align="left" style="font-size: 14px;"><strong></strong> <strong>CUPON</strong> de descuento que quieres enviar mediante correo a tus clientes.</p>
						<select class="form-control" id="cupons" name="coupon">
							@foreach($coupons as $coupon)
								<option value="{{$coupon->id}}">{{$coupon->code}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-12"><hr></div>
			<!-- FIN 2 -->
			<div class="form-group">
				<div class="row">
					<div class="clearfix"></div>
					<div style="margin-bottom: 10px;"></div>
					<div class="col-sm-1">
						<p style="margin-left: 25px !important;margin-top: 35px !important;" class="hidden-sm hidden-xs">
							<i class="fa fa-caret-right fa-2x" aria-hidden="true" style="color:  #F97600;"></i>
						</p>
					</div>
					<div class="col-sm-10">
						<p align="left" style="font-size: 14px;">Selecciona las <strong>PRODUCTOS</strong> para lista negra.</p>
						<select name="products_black[]" id="products" multiple="multiple">
								@foreach($products as $product)
									<option value="{{$product->id}}" id="{{$product->id}}">{{$product->name}}</option>
								@endforeach
							</select>
					</div>
				</div>
			</div>
			<!--FIN 3-->
			<div class="text-center">
				<button type="submit" class="btn btn-primary" style="border-radius: 0px !important;"> Realizar Cambios</button>
			</div>
		</form>
	</div>
</div>
</div>
<div class="col-md-6 col-sm-12">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="col-md-12">
			<img style="margin-top: 10px !important;" class="img-responsive" src="{{asset('administrator/image/emailmarketingmobile.jpg')}}">
			</div>
			<div class="col-md-12">
				<blockquote class="blockquote-reverse">
					<p>Te recomendamos realizar una buena configuraci&oacute;n
						para que MaxiBoot, sea mas efectivo</p>
					<footer>tendaz.com <cite title="Source Title">Administrador</cite></footer>
				</blockquote>
				<div class="text-center">
					<button type="button" class="btn btn-default" style="border-radius: 0px !important;">Desactivar</button>
					<button type="submit" class="btn btn-primary" style="border-radius: 0px !important;">Activar</button>
				</div>
			</div>
			<div class="col-md-12" style="height: 20px"></div>
		</div>
	</div>
</div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('components/admin/js/flat-ui.js') }}" ></script>

<script type="text/javascript">
	$('#category').select2({
		placeholder: 'Selecciona las Categorias'
	}).select2(
		'val',[
		@foreach($categories as $cate)
			@if($cate->blacklist==1)
				{{$cate->id}},
			@endif
		@endforeach
		]
	);
</script>
<script type="text/javascript">
	$('select[id="products"]').select2({
		placeholder: 'Selecciona los productos'
	}).select2('val',[
	@foreach($products as $product)
			@if($product->blacklist==1)
				{{$product->id}},
			@endif
	@endforeach
	]
	);
</script>

@endsection
