<?php

namespace Tendaz\Models\Products;

use Tendaz\Models\Cart\Cart;
use Tendaz\Models\Order\Order;
use Tendaz\Models\Images\Image;
use Illuminate\Database\Eloquent\Model;
use Tendaz\Traits\UuidAndShopTrait;
use Tendaz\Traits\WhereShopTrait;

class Variant extends Model
{
    use  UuidAndShopTrait;
    
    protected $table = 'variants';
    
    protected $fillable = [
        'sku' , 'uuid' , 'price' , 'promotional_price' , 'weight' , 'stock' , 'show' , 'price_declared' , 'product_id'
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function mepaItem()
    {
        return [
            "title" => $this->product->name,
            "description" => $this->product->description,
            "quantity"  => $this->pivot->quantity,
            "unit_price" => $this->originalPrice,
            "picture_url" => $this->product->mainImage()
        ];
    }

    public  static  function RelationProduct(Product $product)
    {
        return static::whereHas('product'  , function($query) use ($product){
            return $query->whereHas('categories' , function($q) use ($product){
                    $q->whereInCategoryId($product);
            })->whereNotIn('id' , [$product->id]);
        })->get();
    }

    /**
     * RELATHIONSHIP
     */

    public function cart()
    {
        return $this->belongsToMany(Cart::class , 'cart_products');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productWithTrashed()
    {
        return $this->product()->withTrashed();
    }
    
    public function information()
    {
        return $this->hasOne(Sellable::class);
    }
    
    public function values()
    {
        return $this->belongsToMany(OptionValue::class ,'option_value_variant' , 'variant_id' , 'option_value_id' );
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    
    public function orders()
    {
        return $this->belongsToMany(Order::class , 'order_item')->withPivot('quantity');
    }
    
    public function optionValueVariant()
    {
        return $this->hasMany(OptionValueVariant::class);
    }

    public function optionValue()
    {
        return $this->belongsToMany(OptionValue::class , 'option_value_variant');
    } 
    
    public function getOptionOneAttribute()
    {
        return  isset($this->values[0])  ? $this->values[0]->option->name : '';
    }
    
    public function getOptionTwoAttribute()
    {
        return  isset($this->values[1])  ? $this->values[1]->option->name : '';
    }
    
    public function getOptionThreeAttribute()
    {
        return  isset($this->values[2])  ? $this->values[2]->option->name : '';
    }
    
    public function getValueOneAttribute()
    {
        return  isset($this->values[0])  ? $this->values[0]->name : '';
    }
    
    public function getValueTwoAttribute()
    {
        return  isset($this->values[1])  ? $this->values[1]->name : '';
    }
    
    public function getValueThreeAttribute()
    {
        return  isset($this->values[2])  ? $this->values[2]->name : '';
    }


    public function setPriceAttribute($value){

        if(!empty($value)){
            $this->attributes['price'] = $value < 0 || !is_numeric($value) ? 0 : $value;
        }else{
            $this->attributes['price'] = 0;
        }
    }

    public function setPriceDeclaredAttribute($value)
    {
        if(!empty($value)){
            $this->attributes['price_declared'] = (int) $value;
        }else{
            $this->attributes['price_declared'] = $this->attributes['price'] ? $this->attributes['price'] : 0;
        }
    }

    public function setPromotionalPriceAttribute($value){
        if(!empty($value)){
            $this->attributes['promotional_price'] = $value < 0 || !is_numeric($value) ? 0 : $value;
        }else{
            $this->attributes['promotional_price'] = 0;
        }
    }

    public function setStockAttribute($value){
        if($value >= 0  && is_numeric($value)){
            $this->attributes['stock'] = $value < 0 || !is_numeric($value) ? 0 : $value;
        }else{
            $this->attributes['stock'] = -1;
        }
    }

    public function setWeightAttribute($value){
        if(!empty($value)){
            $this->attributes['weight'] = $value < 0 || !is_numeric($value) ? 0 : $value;
        }else{
            $this->attributes['weight'] = 0;
        }
    }

    public function getStockAttribute()
    {
        return $this->attributes['stock'] < 0 ? 'unlimited' : $this->attributes['stock'];
    }

    public function getOriginalPriceAttribute()
    {
        return (int)  $this->product->collection->promotion ? $this->attributes['promotional_price'] : $this->attributes['price'];
    }

    public function getPriceAttribute()
    {
        return (int) $this->attributes['price'];
    }

    public function getPromotionalPriceAttribute()
    {
        return (int) $this->attributes['promotional_price'];
    }
    
    public function best_seller()
    {
        return $this->orders->sum(function ($order){
            return $order->pivot->quantity;
        });
    }

    public function subtotal()
    {
        return ($this->productWithTrashed->collection->promotion ? $this->promotional_price   : $this->price) *  $this->pivot->quantity;
    }
}
