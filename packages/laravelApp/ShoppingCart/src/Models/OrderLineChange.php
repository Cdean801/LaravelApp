<?php

namespace laravelApp\ShoppingCart\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLineChange extends Model
{
    public function order_line()
    {
      return $this->belongsTo('App\OrderLine');
    }
}
