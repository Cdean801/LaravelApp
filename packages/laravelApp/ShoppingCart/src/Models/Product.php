<?php

namespace laravelApp\ShoppingCart\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Validator;
use DB;
use Log;

class Product extends Model
{
  // use Searchable;

  /**
  * Get the index name for the model.
  *
  * @return string
  */
  // public function searchableAs()
  // {
  //     return 'products_index';
  // }

  public function toSearchableArray()
  {
    $this->categories;

    $product = $this->toArray();
    $product['brand'] = $this->brand->name;

    return $product;
  }

  public function images() {
    return $this->hasMany('App\ProductImage');
  }

  public function brand() {
    return $this->belongsTo('App\Brand');
  }

  public function featured_images() {
    return $this->images()->where('featured', '=', 1);
  }

  public function categories() {
    return $this->belongsToMany('App\Category', 'product_category',
    'product_id', 'category_id')
    ->withTimestamps();
  }

  public function order_lines()
  {
    return $this->hasMany('App\OrderLine');
  }

  public function tags()
  {
    return $this->hasMany('App\ProductTag');
  }

  public function scopePerishable($query) {
    $filter = function ($q) {
      $q->where('active', 1)->where('name', 'Produce')
      ->orWhere('name', 'Dairy')
      ->orWhere('name', 'Frozen Appetizers')
      ->orWhere('name', 'Frozen Breads')
      ->orWhere('name', 'Frozen Entree')
      ->orWhere('name', 'Frozen Desserts');
    };
    return $query->whereHas('categories', $filter)->with(['categories' => $filter]);
  }

  protected $fillable = [
    'name', 'description', 'sku', 'active', 'sale_price', 'price',
    'in_stock_quantity', 'featured', 'brand_id', 'tax', 'size', 'size_unit',
    'reward_points','image','url','stock_status','shipping_weight','shipping_length','shipping_width','shipping_height','category_id'
  ];


  public static function validateProductData($data){
    $rule = array(
      'name' => 'required|string|max:255',
      'description' => 'required|max:5000',
      'image' => 'image|max:2000',
      'price' => 'required|numeric|min:0.01',
      'in_stock_quantity' => 'required|min:1|max:999999999',
      'url' =>  'max:255',
      'sku' =>  'required|max:255|unique:products',
      'stock_status' =>  'required',
      'shipping_weight' =>  'required|numeric|min:0.01',
      'shipping_length' =>  'required|numeric|min:0.01',
      'shipping_width' => 'required|numeric|min:0.01',
      'shipping_height' =>  'required|numeric|min:0.01',
      'main_category'=>'required',
    );
    $messages = array(
      'required' => ':attribute field is required.',
      'max' => ':attribute must be less than :max characters.',
      'min' => ':attribute must be at least  :min.',
      'date_format' => ':attribute does not match the format.',
      'integer'  => ':attribute must be an integer.',
      'after' => 'The :attribute must be a greater than :date.',
      'image.max'  => ':attribute may not be greater than :max kilobytes.',
    );
    $data = Validator::make($data, $rule, $messages);
    $data->setAttributeNames(array(
      'name'=>ucfirst('PRODUCT_NAME'),
      'description'=>ucfirst('PRODUCT_DESCRIPTION'),
      'image' => ucfirst('PRODUCT_IMAGE'),
      'in_stock_quantity' => ucfirst('PRODUCT_IN_STOCK_QTY'),
      'price' => ucfirst('PRODUCT_PRICE'),
      'url' => ucfirst('PRODUCT_URL'),
      'sku' => ucfirst('PRODUCT_SKU'),
      'stock_status' => ucfirst('PRODUCT_STOCK_STATUS'),
      'shipping_weight' => ucfirst('PRODUCT_SHIPPING_WEIGHT'),
      'shipping_length' => ucfirst('PRODUCT_SHIPPING_LENGTH'),
      'shipping_width' => ucfirst('PRODUCT_SHIPPING_WIDTH'),
      'shipping_height' => ucfirst('PRODUCT_SHIPPING_HEIGHT'),
      'main_category' => ucfirst('PRODUCT_MAIN_CATEGORY'),
    ));
    return $data;
  }
  public static function validateUpdateProductData($data){
    $rule = array(
      'name' => 'required|string|max:255',
      'description' => 'required|max:5000',
      'image' => 'image|max:2000',
      'price' => 'required|numeric|min:0.01',
      'in_stock_quantity' => 'required|min:1|max:999999999',
      'url' =>  'max:255',
      'sku' =>  'required|max:255',
      'stock_status' =>  'required',
      'shipping_weight' =>  'required|numeric|min:0.01',
      'shipping_length' =>  'required|numeric|min:0.01',
      'shipping_width' => 'required|numeric|min:0.01',
      'shipping_height' =>  'required|numeric|min:0.01',
      'main_category'=>'required',
    );
    $messages = array(
      'required' => ':attribute field is required.',
      'max' => ':attribute must be less than :max characters.',
      'min' => ':attribute must be at least  :min.',
      'date_format' => ':attribute does not match the format.',
      'integer'  => ':attribute must be an integer.',
      'after' => 'The :attribute must be a greater than :date.',
      'image.max'  => ':attribute may not be greater than :max kilobytes.',
    );
    $data = Validator::make($data, $rule, $messages);
    $data->setAttributeNames(array(
      'name'=>ucfirst(PRODUCT_NAME),
      'description'=>ucfirst(PRODUCT_DESCRIPTION),
      'image' => ucfirst(PRODUCT_IMAGE),
      'in_stock_quantity' => ucfirst(PRODUCT_IN_STOCK_QTY),
      'price' => ucfirst(PRODUCT_PRICE),
      'url' => ucfirst(PRODUCT_URL),
      'sku' => ucfirst(PRODUCT_SKU),
      'stock_status' => ucfirst(PRODUCT_STOCK_STATUS),
      'shipping_weight' => ucfirst(PRODUCT_SHIPPING_WEIGHT),
      'shipping_length' => ucfirst(PRODUCT_SHIPPING_LENGTH),
      'shipping_width' => ucfirst(PRODUCT_SHIPPING_WIDTH),
      'shipping_height' => ucfirst(PRODUCT_SHIPPING_HEIGHT),
    ));
    return $data;
  }


}
