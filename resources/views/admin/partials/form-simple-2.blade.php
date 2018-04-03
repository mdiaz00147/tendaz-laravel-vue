
{{-- {!! Form::open(['url' => "admin/products?client_secret=$shop->uuid&client_id=$shop->id" ,
'method' => 'POST' , 'class' => 'dropzone' ,'id' => 'my-dropzone' , 'files' => true]) !!} --}}


<div id="app-vue-simple">

    <form action="{{ url('admin/products?client_secret=$shop->uuid&client_id=$shop->id') }}" id="my-dropzone-avanzado" method="POST" role="form">
        <div class="media border-dotted">
          <div class="row">
            <span class="media-body box">
              <div class="col-md-9 col-simple">
                <div class="form-group">
                  <div class="row">

                    <label class="control-label" style="font-size: 1.2em; color: black">Nombre del producto
                    <small style="color: darkgray">(Obligatorio)</small></label>
                    <input type="text" v-model="product_new.name" name="name" class="form-control" placeholder="Ejemplo: Zapato de cuero">
                  </div>
                </div>
              </div>
            </span>
          </div>
        </div>

        <div class="media border-dotted">
            <span class="media-body box">
                <div class="row">
                    <div class="col-md-9 col-simple">
                        <label class="control-label" style="font-size: 1.2em; color: black;">Imagenes
                            <small style="color: darkgray">(Opcional)</small>
                        </label>
                        <br>
                        <div v-for="image in product_new.variant.images" class="col-md-3 text-center" >
                          <img :src="image" class="img-responsive img-thumbnail" style="height: 220px;"/>

                          <button @click="removeImage(image)" style="margin: 15px;" class="btn-primary btn">Remover imagen</button>

                        </div>
                        <div class="col-md-3">
                          <div class="panel panel-default" style="height: 220px;">
                              <div class="panel-body text-center" >
                                  <input type="file" id="file" class="hide" @change="onFileChange">
                                    <label for="file" style="cursor: pointer;">
                                        <h1 style="font-size: 80px !important; color: #F26522; margin: 20px;"><i class="ico-cloud-upload2"></i></h1>
                                        <h4>Agregar imagen</h4>
                                    </label>
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
            </span>
        </div>
        <div class="media border-dotted">
            <div class="row">
              <span class="media-body box">
                <div class="col-md-12 col-simple">
                  <div class="form-group" >
                    <div class="row">

                      <label class="control-label" style="font-size: 1.2em; color: black;">Dimensiones
                      <small style="color: darkgray">(Es importante completar tus dimensiones para calcular el valor del envio)</small>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group" >
                  <div class="row">
                    <div class="col-md-12  col-simple">
                      <div class="col-md-3">
                          <div class="input-group">
                              <label class="col-md-6 control-label" id="label-precio">
                                Largo
                              </label>
                              <span class="input-group-addon">
                                Cm.
                              </span>
                              <input type="number" v-model="product_new.large" id="price" name="large" class="form-control" placeholder="1.0 CM">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="input-group">
                              <label class="col-md-6 control-label" id="peso">
                                Alto
                              </label>
                              <span class="input-group-addon">
                                Cm
                              </span>
                              <input type="number"  id="kilo"  v-model="product_new.height" name="height" class="form-control" data-parsley-type="digits" placeholder="1.0 CM">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="input-group">
                              <label class="col-md-6 control-label" id="label-stock">
                                Ancho
                              </label>
                              <span class="input-group-addon">
                                Cm
                              </span>
                              <input type="number" id="stock" v-model="product_new.width" name="width" class="form-control" data-parsley-type="number" placeholder="1.0 CM">
                          </div>
                      </div>
                    </div>

                  </div>
                </div>
              </span>
            </div>
        </div>
        <div class="media border-dotted">
          <div class="row">
            <span class="media-body box">
              <div class="col-md-12  col-simple">
                <div class="form-group" >
                  <div class="row">

                    <div class="col-md-3">
                        <div class="input-group">
                            <label class="col-md-6 control-label" id="label-precio">
                              Precio
                            </label>
                            <span class="input-group-addon">
                              $
                            </span>
                            <input type="number" v-model="product_new.variant.price" id="price" name="price" class="form-control" placeholder="$12000">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <label class="col-md-6 control-label" id="peso">
                              Peso
                            </label>
                            <span class="input-group-addon">
                              Kg.
                            </span>
                            <input type="number" v-model="product_new.variant.weight" id="kilo"  name="weight" class="form-control" data-parsley-type="digits" placeholder="1.0 Kg">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <label class="col-md-6 control-label" id="label-stock">
                              Stock
                            </label>
                            <span class="input-group-addon">
                              #
                            </span>
                            <input type="number" id="stock" v-model="product_new.variant.stock" name="stock" class="form-control" data-parsley-type="number" placeholder="12">
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </span>
          </div>
        </div>
        <div class="media border-dotted">
            <div class="row" style="background-color: #F7F7F7;border-radius: 10px;padding: 25px;">
              <span class="">
                <div class="col-md-12 col-simple">
                  <div class="form-group" >
                    <div class="row">

                      <label class="control-label" style="font-size: 1.2em; color: black;">Categorias
                      <small style="color: darkgray">(Añade de las categorias que ya tiene asignadas)</small>
                      </label>
                      <br>
                      <div class="form-group">
                        <label class="control-label" style=" color: darkslategray">Añadir categorias <span data-loading-text="<i class='fa fa-spinner fa-spin'></i> " id="add-category" ></span></label><br>

                        <a data-loading-text="<i class='fa fa-spinner fa-spin'></i> procesando" v-on:click="removeCategory(category)" v-bind:id="'remove-category-'+category.id" style="margin-right: 4px; cursor: pointer;" class="btn btn-default" v-for="category in product_new.categories" >@{{ category.name }} <i class='fa fa-remove'></i></a>
                        <div role="presentation" class="dropdown" style="display: inline-block;">
                          <a href="#" v-if="categoriesAdd.length != 0" class="dropdown-toggle btn-default btn" id="drop6" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                            <span class="glyphicon glyphicon-plus"></span> Agregar categoria <span class="caret"></span>
                          </a>
                          <a href="#" v-else class="btn-default btn" role="button">
                            Sin categorias que agregar
                          </a>
                          <ul v-if="categoriesAdd.length != 0"   class="dropdown-menu" id="menu3" aria-labelledby="drop6">
                              <li v-for="category in categoriesAdd">
                                  <a v-on:click="addCategory(category)" style="cursor: pointer;">@{{ category.name }}</a>
                              </li>
                          </ul>
                        </div>
                        <br>
                      </div>

                    </div>
                  </div>
                </div>

              </span>
            </div>
        </div>


        <div class="media border-dotted">
            <div class="row">
              <span class="media-body box">
                <div class="col-sm-9 col-simple">
                  <div class="form-group">
                    <div class="row">

                        <label class="control-label" style="font-size: 1.2em; color: black;">Descripcion
                            <small style="color: darkgray">(Menciona todas las caracteristicas de tu producto)</small>
                        </label>
                        <br>

                         <textarea  class="form-control" name="description2" id="simple-description2" data-parsley-type="alphanum">
                         </textarea>
                    </div>
                </div>
                </div>
             </span>
            </div>
        </div>
        <div class="row" style="padding: 2.5%">
            <div class="col-md-4 " style="margin-left: 13%">
                {{--<button type="submit" id="submit" class="pull-left btn  btn-primary" ><i class="fa fa-check"></i> Crear Producto</button>--}}
                <button type="button" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Agregando producto..." id="btn-store-product" v-on:click="storeProduct()">Crear Producto</button>
            </div>
            <div class="col-md-5" style="margin-left: -1.5%">
                <a href="{{ url('admin/products') }}" class="pull-right btn  btn-default"><i class="fa fa-times"></i> Cancelar</a>
            </div>
            <div class="col-md-4">
                <div class="help-block-create  with-errors hidden" id="name"></div>
            </div>
        </div>
        <div class="indicator hide" id="loading"><img style="
              position: absolute;
              z-index: 999;
              left: 37%;
              top: 35%;
             opacity: 0.5" src="{{ asset('administrator/image/loading/cloud_loading.gif') }}" alt="">
        </div>
    </form>
    <!-- form store-->
    <div class="modal fade" id="modal-success-product">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Producto agregado correctamente</h4>
                </div>
                <div class="modal-body">
                    Puede agregar mas atributos al producto yendo a opciones avanzadas, o puede seguir agregando productos.
                </div>
                <div class="modal-footer">
                    <a href="{{asset('admin/products')}}" class="btn btn-primary">Ver Mis Productos</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Seguir agregando</button>
                    <a v-bind:href="edit_url" class="btn btn-primary">Opciones avanzadas</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{--{!! Form::close() !!}--}}
