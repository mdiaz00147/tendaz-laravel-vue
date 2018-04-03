@extends(Theme::current()->viewsPath.'.template')
	@section('css')
		@stop
	@section('content')
		<div class="container" ng-controller="UserController">
				<div class="row">
					<div class="col-md-12" style="height: 100px"></div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 toppad col-md-offset-3" >
					<div class="noo-about-right">
						<div class="noo-line">
							<span class="line-one">
								<span></span>
								<span></span>
							</span>
							<span class="line-two">
								<span></span>
								<span></span>
							</span>
						</div>
						<div class="noo-button-creative">
							<a href="#">
								<span class="first"></span>
								<span class="second"></span>
								Perfil
								<span class="three"></span>
								<span class="four"></span>
							</a>
						</div>
						<div style="margin-top: 30px;"></div>
						<div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-3 col-lg-3 hidden" align="center"> <img class="img-responsive" src="http://placehold.it/120x150">
										<br>
										<button type="button" class="btn btn-default btn-xs"><i class="fa fa-camera"></i>Cambiar imagen</button>
									</div>
									<div class="col-md-12 col-lg-12 text-center">
										<div class="col-md-6"><strong>Nombre</strong></div>
										<div class="col-md-6"><% user.personal_info.first_name %> <% user.personal_info.last_name %><hr></div>
										<div class="col-md-6"><strong>Email</strong></div>
										<div class="col-md-6"><% user.email %><hr></div>
										<div class="col-md-6"><strong>Telefono</strong></div>
										<div class="col-md-6"><% user.personal_info.phone %><hr></div>
										<div class="col-md-6"><strong>Identificaci&oacute;n</strong></div>
										<div class="col-md-6"><% user.personal_info.identification %><hr></div>
										<div class="col-md-12">
											<a href="#" class="btn btn-primary" style="border-radius: 0" data-toggle="modal" data-target="#modalActualizar">
												<i class="fa fa-edit"></i> Actualizar Datos</a>
											<hr>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad" ng-controller="AddressController">
						@include(Theme::current()->viewsPath.'.partials.edit-dir')
						<div class="noo-about-right">
								<div class="noo-line">
									<span class="line-one">
										<span></span>
										<span></span>
									</span>
									<span class="line-two">
										<span></span>
										<span></span>
									</span>
								</div>
								<div class="noo-button-creative">
									<a href="#">
										<span class="first"></span>
										<span class="second"></span>
										Direcciones
										<span class="three"></span>
										<span class="four"></span>
									</a>
								</div>
							<div>
							<div class="panel-body">
								<div class="row">
								<div class="col-md-12">
									<table class="table table-hover table-responsive">
											<tbody>
											<tr>
												<th>Direccion</th>
												<th>Complemento</th>
												<th>Estado</th>
												<th class="text-center">Principal</th>
												<th class="text-center">Acciones</th>
											</tr>
											<tr ng-repeat="address in addresses">
												<td><% address.street %></td>
												<td>
													<% address.street %>
												</td>
												<td>
													<p align="justify">
														<% address.state.name %> - <% address.city.name %>
													</p>
												</td>
												<td class="text-center">
													<a class="btn btn-xs"ng-click="main( $index)"  ng-class=" address.isPrimary ? 'btn-primary' : 'btn-default'" href="">
														<i class="fa" ng-class=" address.isPrimary ? 'fa-eye' : 'fa-eye-slash'"></i>
													</a>
												</td>
												<td class="text-center">
													<button type="button" data-target="#modalAddress" data-toggle="modal" class="btn btn-warning btn-xs" ng-click="edit( $index)">
														<i class="fa fa-edit"></i></button>
												</td>
											</tr>
											</tbody>
										</table>
									</div>
										<div class="col-md-12">
											Al seleccionar ( <i class="fa fa-eye"></i> ) dejaras esta direcci&oacute;n como direccion principal.
										</div>
											<div class="col-md-12">
												<div class="text-center"><br>
												<button ng-click="created()" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddress"><i class="fa fa-plus"></i> Agregar Direccion</button>
											</div>
											<div style="margin-bottom: 30px;"></div>
										</div>

								</div>

							</div>
							</div>
						</div>
						</div>

			<div style="margin-bottom: 125px;"></div>


			<!--Modal para modificar datos del perfil-->
				<div id="modalActualizar" class="modal fade" tabindex="-1" role="dialog" style="margin-top: 100px">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aira-hidden="		true">&times;</span></button>
								<h4 class="modal-title">Editar Perfil</h4>
							</div>
							<div class="modal-body">
								<!--Fomulario-->
								<form name="profileForm" accept-charset="utf-8" autocomplete="off" role="form" class="form-horizontal"
									  ng-submit="doUpdateProfile(profileForm)" novalidate>
									<div class="alert alert-danger" ng-repeat="error in errors" ng-show="errors" class="error"><% error %></div>
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-12">
											<div class="form-group">
												<label>Nombres</label>
												<input type="text" name="name" class="form-control" ng-model="user.personal_info.first_name">
											</div>
											<div class="form-group">
												<label>Apellidos</label>
												<input type="text" name="last_name" class="form-control" ng-model="user.personal_info.last_name">
											</div>
											<div class="form-group">
												<label>Telefono</label>
												<input type="text" name="phone" class="form-control" ng-model="user.personal_info.phone">
											</div>
											<div class="form-group">
												<label>Idnetificaci&oacute;n</label>
												<input type="text" name="phone" class="form-control" ng-model="user.personal_info.identification">
											</div>
											<hr>
											<div clas="modal-footer">
												<div class="text-center">
													<button type="submit" class="btn btn-primary updateProfile">Actualizar datos</button>
												</div>
											</div>
											</div>
										</div>
									</div>
								</form>
								<!--Fin-->
							</div>
						</div>
					</div>
				</div>
			<!--Fin-->

			</div>
	</div>
		@endsection
	@section('script')
		@stop
