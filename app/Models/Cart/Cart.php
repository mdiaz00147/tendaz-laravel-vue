<?php

namespace Tendaz\Models\Cart;

use Illuminate\Database\Eloquent\Model;
use Tendaz\Models\Coupon\Coupon;
use Tendaz\Models\Customer;
use Tendaz\Models\Order\Order;
use Tendaz\Models\Products\Variant;
use Tendaz\Models\Store\Shop;
use Tendaz\Traits\UuidAndShopTrait;
use Tendaz\Traits\WhereShopTrait;
use Webpatser\Uuid\Uuid;

class Cart extends Model
{
    use WhereShopTrait ,  UuidAndShopTrait;

    protected $table = 'carts';
    protected $fillable = ['secure_key' , 'status' , 'shop_id' , 'customer_id', 'address_shipping_id' , 'address_invoice_id'];
        
    
    public function InShoppingCarts()
    {
        return $this->hasMany(InShoppingCart::class , 'cart_products');
    }
    
    public function products()
    {
        return $this->belongsToMany(Variant::class , 'cart_products' , 'cart_id' , 'item_id')
            ->withPivot('quantity')->with('product');
    }
    
    public function order()
    {
        return $this->hasOne(Order::class);
    }
     public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getRouteKeyName()
    {
        return 'secure_key';
    }

    public function productsSize()
    {
        return $this->products()->count();
    } 

    public function totalProducts(){
        return (int) $this->products->sum( function($product){
            if($product->product->collection->promotion){
                return $product->promotional_price * $product->pivot->quantity;
            }else{
                return $product->price * $product->pivot->quantity;
            }
        } );
    }

    public function totalDiscount()
    {
        return $this->order->total_discount * -1;
    }

    public function totalShipping(){
        return (int) $this->order->total_shipping;
    }

    public function total(){
        return (float) $this->order->total;
    }
    
    public function weight(){
        return (float) $this->products->sum(function($product){
                return $product->weight * $product->pivot->quantity ;
        });
    }

    public static function createOrAssignUser(Cart $cart , Customer $user)
    {
        if(isset($cart->id))
            self::AssignUser($cart , $user);
        else
            self::createWithOutSession($user->shop->id , $user);
    }

    public static function AssignUser($cart , $user)
    {
        if (!$cart['customer_id'])
        {
            $cart->update([
                'customer_id' => $user['id']
            ]);

            $cart->order()->update([
                'customer_id' => $user['id']
            ]);

        }
        else if($cart['customer_id'] != $user['id'])
            self::createWithOutSession($user->shop->id , $user);
    }


    public static function findOrCreateBySessionID($shoppingCartId , $shop_id)
    {
        if($shoppingCartId)
            return  self::findBySession($shoppingCartId);
        else
            return  self::createWithOutSession($shop_id);
    }

    public static function findBySession($shopping_cart_id)
    {
        return static::findBySecureKey($shopping_cart_id)->first();
    }

    public static function findBySecureKey($secure_key)
    {
        return static::where('secure_key' , $secure_key);
    }

    public static function createWithOutSession($shop_id , $user = null)
    {
        if(!isset($user) || !$user->hasPendingCart()){
            return static::create([
                'status'        => 'open',
                'secure_key'    => Uuid::generate(4)->string,
                'shop_id'       => $shop_id,
                'customer_id'   => $user['id']
            ]);
        }

    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function closed()
    {
        $this->status = 'closed';
        $this->save();
    }
}
