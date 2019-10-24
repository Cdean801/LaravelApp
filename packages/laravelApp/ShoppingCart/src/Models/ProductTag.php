<?php

namespace laravelApp\ShoppingCart\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
  // public function location()
  //   {
  //       return $this->belongsTo('App\PickupLocation', 'pickup_location_id');
  //   }

  // public function orders()
  // {
  //     return $this->hasMany('App\Order');
  // }

  protected $fillable = [
      'product_id', 'name',
  ];
}
