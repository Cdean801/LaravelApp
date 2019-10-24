<?php

namespace laravelApp\ShoppingCart\Models;


use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
  protected $fillable = [
    'order_id','product_id','quantity', 'item_price'
  ];
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

  public function scopePerishable($query)
  {
    $filter = function ($q) {
      $q->perishable();
    };
    return $query->whereHas('product', $filter)->with(['product' => $filter]);
  }

  public function order()
  {
    return $this->belongsTo('App\Order');
  }

  public function order_line_changes()
  {
    return $this->hasMany('App\OrderLineChange');
  }
}
