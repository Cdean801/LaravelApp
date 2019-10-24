<?php

namespace laravelApp\ShoppingCart\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserSubscriptionDetail extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id', 'user_card_info_id', 'start_date', 'end_date', 'amount', 'status', 'message', 'invoice_number','auth_number', 'active'
  ];

  public function user() {
    return $this->belongsTo('App\User', 'user_id');
  }

}
