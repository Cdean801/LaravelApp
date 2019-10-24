<?php

namespace laravelApp\ShoppingCart\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Log;

class UserCardInfo extends Model
{
  protected $table = 'user_card_info';
  protected $fillable = [
    'user_id','card_holder_name','last4','brand','trans_id','is_primary', 'expiration', 'token','csv'
  ];


    /**
    * @author : ### ###.
    *
    * Method name: validateCreateBillingAddress
    * Define for validate billing address data for place order.
    *
    * @param  {array} data - The data is array of User
    * @return  array object of validate billing address data
    */
    public static function validateCreateCard($data) {
      // Log::info($data);
      $rule = array(
        'user_id' => 'required|integer',
        'card_holder_name' => 'required|string|max:191',
        'last4' => 'required|size:4',
        'brand'=>'required|string|max:191',
        'trans_id' => 'required|max:191',
        // 'is_primary' => 'required|boolean',
      );
      $messages = array(
        'required' => ':attribute field is required.',
        'min' => ':attribute must be at least :min.',
        'max' => ':attribute must be less than :max characters.',
        'regex' => ':attribute is allowed only numeric data.',
        'email' => ':attribute must be a valid email address.',
        'numeric'  => ':attribute must be a number.',
        'size' => ':attribute must be :size.',
        'date_format'  => ':attribute does not match the format :format.',
        'integer'=> ':attribute must be an integer.',
        'boolean'=> ':attribute field must be true or false.',
      );
      $data = Validator::make($data, $rule, $messages);
      $data->setAttributeNames(array(
        'user_id'=>ucfirst('user id'),
        'card_holder_name'=>ucfirst('card holder name'),
        'last4' => ucfirst('card number'),
        'brand' => ucfirst('brand'),
        'trans_id' => ucfirst('trans id'),
      ));
      return $data;
    }
  }
