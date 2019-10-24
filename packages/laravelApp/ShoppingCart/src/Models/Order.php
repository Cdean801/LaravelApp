<?php

namespace laravelApp\ShoppingCart\Models;


use Illuminate\Database\Eloquent\Model;
use Validator;
use Log;

class Order extends Model
{
  protected $fillable = [
    'user_id','card_holder_name','last4', 'brand', 'invoice_number', 'auth_number', 'amount', 'billing_address_id','user_card_info_id','paid','terms_conditions','payment_method','shipping_address_id','created_at'
  ];

  protected $dates = [
    'created_at', 'updated_at'
  ];

  public function order_lines() {
    return $this->hasMany('App\OrderLine');
  }

  public function slot() {
    return $this->belongsTo('App\TimeSlot', 'time_slot_id');
  }

  public function user() {
    return $this->belongsTo('App\User', 'user_id')->withTrashed();
  }

  /**
  * @author : ### ###.
  *
  * Method name: validateCardDetails
  * Define for validate use card data for place order.
  *
  * @param  {array} data - The data is array of User
  * @return  array object of validate use card data.
  */
  public static function validateCardDetails($data) {
    Log::info($data);
    $rule = array(
      'card_name' => 'required|string|max:255',
      'card_number' => 'required|numeric|size:16',
      'expiration' => 'required|date_format:mm/yy',
      'csv'=>'required|numeric|size:3'
    );
    $messages = array(
      'required' => ':attribute field is required.',
      'min' => ':attribute must be at least :min.',
      'max' => ':attribute must be less than :max characters.',
      'regex' => ':attribute is allowed only numeric data.',
      'phone.max' => ':attribute must be less than :max digits.',
      'csv.max' => ':attribute must :max digits.',
      'csv.min' => ':attribute must :min digits.',
      'card_number.max' => ':attribute must :max digits.',
      'card_number.min' => ':attribute must :min digits.',
      'email' => ':attribute must be a valid email address.',
      'numeric'  => ':attribute must be a number.',
      'size' => ':attribute must be :size.',
      'date_format'  => ':attribute does not match the format :format.',
    );
    $data = Validator::make($data, $rule, $messages);
    $data->setAttributeNames(array(
      'card_name'=>ucfirst('card name'),
      'card_number'=>ucfirst('card number'),
      'expiration' => ucfirst('expiration'),
      'csv' => ucfirst('csv')
    ));
    return $data;
  }


  /**
  * @author : ### ###.
  *
  * Method name: validateCreateOrder
  * Define for validate billing address data for place order.
  *
  * @param  {array} data - The data is array of User
  * @return  array object of validate billing address data
  */
  public static function validateCreateOrder($data) {
    Log::info($data);
    $rule = array(
      'user_id' => 'required',
      'shipping_address_id' => 'required',
      'billing_address_id' => 'required',
      'terms_conditions'=>'required',
      'amount'=>'required|numeric|min:0.01'
    );
    $messages = array(
      'required' => ':attribute field is required.',
      'min' => ':attribute must be at least :min.',
      'numeric'  => ':attribute must be a number.',
    );
    $data = Validator::make($data, $rule, $messages);
    $data->setAttributeNames(array(
      'user_id'=>ucfirst('user'),
      'shipping_address_id'=>ucfirst('shipping address'),
      'billing_address_id' => ucfirst('billing address'),
      'terms_conditions' => ucfirst('terms conditions'),
      'amount' => ucfirst('amount')
    ));
    return $data;
  }

  public static function reportValidate($data){
    $rule = array(
      'from_date' => 'required',
      'to_date'=> 'required',
    );
    $messages = array(
        'required' => ':attribute field is required.',
        'max' => ':attribute may not be greater than :max.',
        'regex' => ':attribute format is invalid.',
    );
    $data = Validator::make($data, $rule, $messages);
    $data->setAttributeNames(array(
        'from_date' => ucfirst('from date'),
        'to_date' => ucfirst('to date'),
    ));
    return $data;
  }
}
