<div class="row"  align="center">
    <table class="table-responsive table-product-no-variante">
        <tbody>
            <div class="form-group" >
                <tr>
                    <td>
                        <label class="col-md-6 control-label" id="label-precio">Precio</label>
                    </td>
                    <td>
                        <div class="input-group">
                        <span class="input-group-addon">$</span>
                            {!! Form::text('price',isset($product)? $product->price : null ,['class'=>'form-control','id'=>'price','style'=>'height: 30px;']) !!}
                        </div>
                    </td>
                    
                </tr>
                <tr>
                    <td><label class="col-md-12 control-label" id="label-stock">Precio Promocional</label></td>
                    <td>
                        <div class="input-group">
                        <span class="input-group-addon">$</span>
                            {!! Form::text('promotional_price',isset($product)? $product->promotional_price : null ,['class'=>'form-control','id'=>'price','style'=>"height: 30px; text-align: center" ]) !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label class="col-md-6 control-label" id="peso">Peso</label></td>
                    <td>
                    <div class="input-group ">
                        <span class="input-group-addon">Kg.</span>
                        {!! Form::text('weight',isset($product)? $product->weight : null ,['class'=>'form-control','id'=>'kilo']) !!}
                        
                    </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="col-md-6 control-label" id="label-stock">Stock</label>
                    </td>
                    <td>
                        <div class="input-group">
                            {!! Form::text('stock',isset($product)? $product->stock : null ,['class'=>'form-control','id'=>'stock']) !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="col-md-6 control-label" id="label-stock">SKU</label>
                    </td>
                    <td>
                        <div class="input-group">
                            {!! Form::text('sku',isset($product)? $product->sku : null ,['class'=>'form-control','id'=>'price','style'=>"height: 30px; text-align: center" ]) !!}
                        </div>
                    </td>
                </tr>
                
            </div>
        </tbody>
        
    </table>
</div>