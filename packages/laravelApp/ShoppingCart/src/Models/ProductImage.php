<?php

namespace laravelApp\ShoppingCart\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{



  protected $fillable = [
      'path', 'alt_text', 'name',
  ];
}
