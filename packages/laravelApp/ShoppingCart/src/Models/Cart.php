<?php

namespace laravelApp\ShoppingCart\Models;
use Log;

class Cart
{
  public $items;
  public $totalQty = 0;
  public $totalPrice = 0;

  public function __construct($oldCart)
  {
    if ($oldCart) {
      $this->items = $oldCart->items;
      $this->totalQty = $oldCart->totalQty;
      $this->totalPrice = $oldCart->totalPrice;
    }
  }

  public function add($item, $id){
    $storedItem = ['qty' => 0, 'item_price' => $item->price, 'total_price' => $item->price, 'item' => $item];
    if ($this->items){
      if (array_key_exists($id, $this->items)) {
        $storedItem = $this->items[$id];
      }
    }
    $storedItem['qty']++;
    $storedItem['total_price'] = $item->price * $storedItem['qty'];
    $this->items[$id] = $storedItem;
    $this->totalQty++;
    $this->totalPrice += $item->price;
  }

  public function minus($item, $id){
    $storedItem = ['qty' => 0, 'item_price' => $item->price, 'total_price' => $item->price, 'item' => $item];
    if ($this->items){
      if (array_key_exists($id, $this->items)) {
        $storedItem = $this->items[$id];
      }
    }
    $storedItem['qty']--;
    $storedItem['total_price'] = $item->price * $storedItem['qty'];
    if($storedItem['qty'] == 0)
    {
      unset($this->items[$id]);
    } else {
      $this->items[$id] = $storedItem;
    }
    $this->totalQty--;
    $this->totalPrice -= $item->price;
  }

  public function remove($item, $id){
    $this->totalQty = $this->totalQty - $this->items[$id]['qty'];
    $this->totalPrice = $this->totalPrice - $this->items[$id]['total_price'];
    unset($this->items[$id]);
    $this->totalQty;
  }
}
