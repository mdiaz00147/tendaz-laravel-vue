@extends(Theme::current()->viewsPath.'.template')
	@section('css')
		@stop
	@section('content')
			<div class="content"  ng-controller="UserController">
				<div class="container">
					<div class="row">
					<div style="margin-top: 50px;"></div>
					<div class="clearfix"></div>
						<div class="col-md-4 col-md-offset-4">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="text-center">
										<h3 class="panel-title">Perfil</h3>
									</div>
								</div>
								<div class="panel-content">
									<div class="panel-body">
										<div class="row">
										<div class="col-md-3 col-lg-3 hidden" align="center">
											<img src='http://placehold.it/120x150' classs='img-responsive'>
											<br>
										</div>

										<div class="col-md-12 col-lg-12">
											<table class="table table-user-information">
											<tbody>
											<tr>
												<th>Nombre</th>
												<td><% user.personal_info.first_name %> <% user.personal_info.last_name %></td>
											</tr>
											<tr>
												<th>Telefono</th>
												<td><% user.personal_info.phone %></td>
											</tr>
											<tr>
												<th>Email</th>
												<td><% user.email %></td>
											</tr>
											<tr>
												<th>Direcci&oacute;n</th>
												<td><% user.personal_info.identification %></td>
											</tr>
											</tbody>
											</table>
											<div class="text-center"  style="height: 52px">
												<button  data-target="#modalActualizar" data-toggle="modal" type="button"
														 class="btn btn-primary"><i class="fa fa-edit"></i> Editar Datos de perfil</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

						<div class="col-md-12 col-lg-12" ng-controller="AddressController">
							@include(Theme::current()->viewsPath.'.partials.edit-dir')
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="text-center">
										<h3 class="panel-title">Direcciones</h3>
									</div>
								</div>
								<div class="panel-content">
									<div class="panel-body">
										<table class="table table-responsive">
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
												<a class="btn btn-xs" ng-click="main( $index)" ng-class=" address.isPrimary ? 'btn-primary' : 'btn-default'" href="">
													<i class="fa" ng-class=" address.isPrimary ? 'fa-eye' : 'fa-eye-slash'"></i>
												</a>
											</td>
											<td class="text-center">
												<button type="button" data-target="#modalAddress" data-toggle="modal" class="btn btn-warning btn-xs" ng-click="edit( $index)"><i class="fa fa-edit
													"></i></button>
											</td>
										</tr>
										</tbody>
										</table>
										<div class="col-md-12">
											<hr>
											Al seleccionar ( <i class="fa fa-eye"></i> ) dejaras esta direcci&oacute;n como direccion principal.
										</div>
										<div class="col-md-12">
											<div class="pull-right"><br>
											<button  ng-click="created()" data-target="#modalAddress" type="button" class="btn btn-primary" data-toggle="modal">
												<i class="fa fa-plus"></i> Agregar Nueva Direccion
											</button>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					<!--Modal para editar Datos-->
					<div id="modalActualizar" class="modal fade" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									@include('admin.partials.message')
									<button type="button" class="close" data-dismiss="modal" aira-label="Close"><span aira-hidden="true">&times;</span></button>
									<h4 class="modal-title">Editar datos del Perfil</h4>
								</div>
								<div class="modal-body">
									<form name="profileForm" accept-charset="utf-8" autocomplete="off" role="form" class="form-horizontal"
										  ng-submit="doUpdateProfile(profileForm)" novalidate>
										<div class="alert alert-danger" ng-repeat="error in errors" ng-show="errors" class="error"><% error %></div>
									<div class="row">
										<div class="col-md-12">
											<div class="col-xs-6">
												<label>Nombres</label>
												<input type="text" class="form-control" name="name"  ng-model="user.personal_info.first_name">
											</div>
											<div class="col-xs-6">
												<label>Apellidos</label>
												<input type="text" class="form-control"  name="last_name" ng-model="user.personal_info.last_name">
											</div>
											<div class="col-xs-6">
												<label>Telefono</label>
												<input type="text" class="form-control" name="phone"  ng-model="user.personal_info.phone">
											</div>
											<div class="col-xs-6">
												<label>Idnetificaci&oacute;n</label>
												<input type="text" class="form-control" name="phone"  ng-model="user.personal_info.identification">
											</div>
											<div class="col-xs-6 hidden">
											<style type="text/css">
												input[type="file"]{
													display: none;
												}
												.custom-file-upload{
													border: 1px solid #ccc;
													display: inline-block;
													padding: 6px  12px;
													cursor: pointer;
												}
											</style>
											<div class="clearfix"></div>
											<div style="margin-top: 2px;"></div>
											<label>Imagen de Perfil</label>
											<div class="form-group">
												<label for="file-upload" class="custom-file-upload">
    											<i class="fa fa-upload"></i> Carga foto de Perfil
											</label>
												<input id="file-upload" type="file"/>
											</div>
										</div>
										</div>
										<div class="col-md-12">
											<div class="modal-footer" style="margin-top: 30px">
												<div class="text-center">
													<button type="submit" class="btn btn-primary updateProfile"> <i class="fa fa-edit"></i> Guardar Cambios</button>
													<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
												</div>
											</div>
										</div>
									</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!--Fin-->

				</div>
				<div style="margin-bottom: 100px;"></div>
			</div>
		</div>
	@endsection
@section('scripts')
@stop
