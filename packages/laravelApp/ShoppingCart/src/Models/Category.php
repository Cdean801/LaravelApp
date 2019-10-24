<?php

namespace laravelApp\ShoppingCart\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Category extends Model
{

  public function products() {
    return $this->belongsToMany('App\Product', 'product_category',
      'category_id', 'product_id')
      ->withTimestamps();
  }

  protected $fillable = [
    'name', 'active' , 'parent_id'
  ];
  /**
  * @author : ### ###.
  *
  * Method name: validateCategory
  * Define for validate recipe category for category create.
  *
  * @param  {array} data - The data is array of User
  * @return  array object of validate category data
  */
  public static function validateCategory($data) {
    $rule = array(
      'name' => 'required|string|max:255'
    );
    $messages = array(
      'required' => ':attribute field is required.',
      'max' => ':attribute must be less than than :max characters.'
    );
    $data = Validator::make($data, $rule, $messages);
    $data->setAttributeNames(array(
      'name'=>ucfirst('name')
    ));
    return $data;
  }
  /**
  * @author : ### ###.
  *
  * Method name: validateUpdateCategory
  * Define for validate recipe category for category update.
  *
  * @param  {array} data - The data is array of User
  * @return  array object of validate category data
  */
  public static function validateUpdateCategory($data) {
    $rule = array(
      'name' => 'required|string|max:255'
    );
    $messages = array(
      'required' => ':attribute field is required.',
      'max' => ':attribute must be less than than :max characters.'
    );
    $data = Validator::make($data, $rule, $messages);
    $data->setAttributeNames(array(
      'name'=>ucfirst('name')
    ));
    return $data;
  }
}
