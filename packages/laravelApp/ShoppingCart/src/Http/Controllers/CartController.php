<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCheckoutOrder;
use Session;
use App\Cart;
use App\TimeSlot;
use App\PickupLocation;
use App\Address;
use DB;
use Log;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\OrderLine;
use App\Product;
use App\UserCardInfo;
use Payeezy_Client;
use Payeezy_CreditCard;
use Payeezy_Transaction;
use Payeezy_Token;
use Payeezy_Error;
use App\Controllers\PayeezyDirectAPI;

class CartController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
  }


  /**
  * @author : ### ###.
  * Created on : ####
  *
  * Method name: index
  * This method is used to show cart details.
  *
  * @return cart-view.
  * @exception throw if any error occur when get cart details.
  */
  public function index()
  {
    Log::info('User::CartController::index::Start');
    $result = DB::transaction(function () {
      try {
        if (!Session::has('cart')) {
          Log::info('User::CartController::index::End');
          return view('front.shop.empty_cart', ['products' => null]);
        }
        $tax = 0;
        $pre_total = 0;
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $products = $cart->items;
        if(null!=$products && ''!=$products){
          foreach($products as $product)
          {
            $pre_total = $pre_total + ($product['item_price'] * $product['qty']);
            $tax = $tax + ($product['item_price'] * $product['qty'] * ($product['item']['tax'] /100)) ;
          }
          Log::info('User::CartController::index::End');
          return view('front.shop.cart', ['products' => $products, 'total_price'
          => $pre_total, 'tax' => $tax]);
        }
        else{
          Log::info('User::CartController::index::End');
          return view('front.shop.empty_cart', ['products' => null]);
        }
      }
      catch (Exception $ex) {
        Log::warning('Admin::CartController::index::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author ####
  * Created on : ####
  *
  * Method name: addProductToCart
  * This method is used to add product in cart.
  *
  * @return message,status,data if any.
  * @exception throw if any error occur when add product in cart.
  */
  public function addProductToCart(Request $request, $id) {
    Log::info('User::CartController::addProductToCart::Start');
    $result = DB::transaction(function () use ($request, $id) {
      try {
        if(null != $request && '' != $request && null != $id && '' != $id) {
          $product = Product::find($id);
          if(null!=$product && ''!=$product){
            $input = $request->all();
            if($product->in_stock_quantity > 0)  {
              $oldCart = Session::has('cart') ? Session::get('cart') : null;
              $cart = new Cart($oldCart);
              if(($cart->items) && array_key_exists($product->id, $cart->items)){
                if (($product->in_stock_quantity) > ($cart->items[$product->id]['qty'] + 1)){
                  $cart->add($product, $product->id);
                  Session::put('cart', $cart);
                  flash($product->name . ' has been added to cart.')->success();
                  Log::info('User::CartController::addProductToCart::End');
                  return response()->json(['status' => 200]);
                } else {
                  $oldCart = Session::has('cart') ? Session::get('cart') : null;
                  $cart = new Cart($oldCart);
                  flash($product->name . ' can not be added to cart because enough quantity is not in stock.')->error();
                  Log::info('User::CartController::addProductToCart::'.$product->name . ' can not be added to cart because enough quantity is not in stock.');
                  return response()->json(['status' => 422,'msg' =>  $product->name .'can not be added to cart because enough quantity is not in stock.']);
                }
              }
              $cart->add($product, $product->id);
              Session::put('cart', $cart);
              flash($product->name . ' has been added to cart.')->success();
              Log::info('User::CartController::addProductToCart::End');
              return response()->json(['status' => 200,'msg' => $product->name . ' has been added to cart.']);
            } else {
              $oldCart = Session::has('cart') ? Session::get('cart') : null;
              $cart = new Cart($oldCart);
              flash($product->name . ' can not be added to cart because enough quantity is not in stock.')->error();
              Log::info('User::CartController::addProductToCart::'.$product->name . ' can not be added to cart because enough quantity is not in stock.');
              return response()->json(['status' => 422,'msg' =>  $product->name .'can not be added to cart because enough quantity is not in stock.']);
            }
          }else{
            flash(PRO_NOT_FOUND)->error();
            Log::info('User::CartController::addProductToCart::'.PRO_NOT_FOUND);
            return response()->json(['status' => 422,'msg' => PRO_NOT_FOUND]);
          }
        }
        else{
          flash(INPUT_REQUEST_NULL_RESPONSE)->error();
          Log::info('User::CartController::addProductToCart::'.INPUT_REQUEST_NULL_RESPONSE);
          return response()->json(['status' => 422,'msg' => INPUT_REQUEST_NULL_RESPONSE]);
        }
      } catch (Exception $ex) {
        Log::info('Admin::CartController::index::');
        throw new Exception($ex);
      }
    });

    return $result;
  }

  /**
  * @author ####
  * Created on : ####
  *
  * Method name: removeFromCart
  * This method is used to remove from cart.
  *
  * @return message.
  * @exception throw if any error occur when remove product from cart.
  */
  public function removeFromCart(Request $request, $id)
  {
    Log::info('User::addProductToCart::removeFromCart::Start');
    $result = DB::transaction(function () use ($request, $id) {
      try {
        if(null != $request && '' != $request && null != $id && '' != $id) {
          $product = Product::find($id);
          if(null!=$product && ''!=$product){
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            $cart->remove($product, $product->id);
            Session::put('cart', $cart);
            flash($product->name . ' has been removed to cart.')->success();
            Log::info('User::addProductToCart::removeFromCart::End');
            return redirect()->back();
          }else{
            flash(PRO_NOT_FOUND)->error();
            Log::info('User::addProductToCart::removeFromCart::'.PRO_NOT_FOUND);
            return redirect()->back();
          }
        }
      }
      catch (Exception $ex) {
        Log::warning('User::CartController::removeFromCart::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author ####
  * Created on : ####
  *
  * Method name: getAddToCartWithInputAjax
  * This method is used for change qty of product in cart.
  *
  * @return message,status.
  * @exception throw if any error occur when change qty of product in cart.
  */
  public function getAddToCartWithInputAjax(Request $request, $id)
  {
    Log::info('User::CartController::getAddToCartWithInputAjax::Start');
    $result = DB::transaction(function () use ($request, $id) {
      try {
        if(null != $request && '' != $request && null != $id && '' != $id) {
          if($request->ajax()){
            $quantity = (int)$request['quantity'];
            $product = Product::find($id);
            if(null == $product || '' == $product){
              Log::info('User::CartController::getAddToCartWithInputAjax::'.NOT_ENOUGH_QTY_TO_ADD_CART_ERR);
              return response()->json(['status' => 10,'msg' => NOT_ENOUGH_QTY_TO_ADD_CART_ERR]);
            }
            if($product->in_stock_quantity > 0) {
              $oldCart = Session::has('cart') ? Session::get('cart') : null;
              $cart = new Cart($oldCart);
              if(null != $oldCart && '' != $oldCart){
                if(($cart->items) && array_key_exists($product->id, $cart->items)){
                  if (($product->in_stock_quantity) >= $quantity){
                    $cart->totalQty = ($cart->totalQty - $cart->items[$product->id]['qty']) + $quantity -1;
                    $cart->add($product, $product->id);
                    $cart->items[$product->id]['qty'] = $quantity;
                    $cart->items[$product->id]['total_price'] = $quantity * $cart->items[$product->id]['item_price'] ;
                    $total= 0;
                    foreach ($cart->items as $key => $value) {
                      $total = $total + ($value['qty']*$value['item_price']);
                    }
                    $cart->totalPrice = $total;
                    Session::put('cart', $cart);
                    flash($product->name . ADD_TO_CART_QUANTITY)->success();
                    Log::info('User::CartController::getAddToCartWithInputAjax::End');
                    return response()->json(['status' => 200,'msg' => ADD_TO_CART_QUANTITY]);
                  } else {
                    $oldCart = Session::has('cart') ? Session::get('cart') : null;
                    $cart = new Cart($oldCart);
                    if(null != $oldCart && '' != $oldCart){
                      $remainingQty = $product->in_stock_quantity - $cart->items[$product->id]['qty'];
                      if($remainingQty == 0) {
                        flash(SOLD_OUT_PRO_TO_ADD_CART_ERR)->error();
                        Log::info('User::CartController::getAddToCartWithInputAjax::'.ADD_TO_CART_QUANTITY);
                        return response()->json(['status' => 10,'msg' => ADD_TO_CART_QUANTITY]);
                      } else {
                        $remainingQty = $product->in_stock_quantity;
                        flash(NOT_ENOUGH_QTY_TO_ADD_CART_ERR. $remainingQty . '.')->error();
                        Log::info('User::CartController::getAddToCartWithInputAjax::'.NOT_ENOUGH_QTY_TO_ADD_CART_ERR .$remainingQty);
                        return response()->json(['status' => 10,'msg' => NOT_ENOUGH_QTY_TO_ADD_CART_ERR]);
                      }
                    }else{
                      flash(NOT_ENOUGH_QTY_TO_ADD_CART_ERR. $product->in_stock_quantity . '.')->error();
                      Log::info('User::CartController::getAddToCartWithInputAjax::'.NOT_ENOUGH_QTY_TO_ADD_CART_ERR . $product->in_stock_quantity);
                      return response()->json(['status' => 10,'msg' => NOT_ENOUGH_QTY_TO_ADD_CART_ERR]);
                    }
                  }
                }
              }
            } else {
              $oldCart = Session::has('cart') ? Session::get('cart') : null;
              $cart = new Cart($oldCart);
              flash($product->name . ADD_TO_CART_QUANTITY_ERROR)->error();
              Log::info('User::CartController::getAddToCartWithInputAjax::'.$product->name .ADD_TO_CART_QUANTITY_ERROR);
              return response()->json(['status' => 10,'msg' => ADD_TO_CART_QUANTITY_ERROR]);
            }
          }
        }
      }
      catch (Exception $ex) {
        Log::info('Admin::CartController::getAddToCartWithInputAjax::');
        throw new Exception($ex);
      }
    });
    return $result;
  }


  /**
  * @author : ### ###.
  * Created on : ####
  *
  * Method name: checkout
  * This method is used to show checkout details.
  *
  * @return checkout-view with address and card details.
  * @exception throw if any error occur when get checkout details.
  */
  public function checkout(Request $request){
    Log::info('user::CartController::checkout::START');
    $result = DB::transaction(function () use($request){
      try {
        $oldCart = Session::get('cart');
        if(null != $oldCart && '' != $oldCart ) {
          if (!Session::has('cart') || ($oldCart->totalQty<1)) {
            Log::info('user::CartController::checkout::'.USER_CHECKOUT_EMPTY_CART_ERROR);
            return view('front.shop.empty_cart', ['products' => null]);
          }
          $cart = new Cart($oldCart);
          $products = $cart->items;
          if(null != $products && '' != $products && count($products) > 0) {
            $total = $cart->totalPrice;
            $card_info = UserCardInfo::where('user_id',Auth::user()->id)->get();
            $useAddress['billing'] = Address::where('user_id',Auth::user()->id)->orderBy('is_primary', 'desc')->get();
            $useAddress['shipping'] = Address::where('user_id',Auth::user()->id)->orderBy('is_primary', 'desc')->get();
            // var_dump($cart);
            // exit;
            return view('front.shop.user_checkout', ['total' => $total, 'products' => $products,'cards'=>$card_info,'address'=>$useAddress]);
          }else{
            Log::info('user::CartController::checkout::'.USER_CHECKOUT_EMPTY_SESSION_ERROR);
            return view('front.shop.empty_cart', ['products' => null]);
          }
        }
        else{
          Log::info('user::CartController::checkout::'.USER_CHECKOUT_EMPTY_SESSION_ERROR);
          return view('front.shop.empty_cart', ['products' => null]);
        }
      } catch (Exception $ex) {
        Log::info('user::CartController::checkout::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author : ### ###.
  * Created on : ####
  *
  * Method name: finalCheckout
  * This method is used to place order and checkout.
  *
  * @param {int} billing_address_id - The billing address id of the user.
  * @param {int} shipping_address_id - The shipping address id of the user.
  * @param {boolean} terms_conditions - The terms conditions which user have to accept.
  * @param {varchar} card_holder_name - The card holder name of user.
  * @param {number} card_number - The card number of user.
  * @param {varchar} expiration_date - The expiration date of card.
  * @param {int} csv - The csv number of card.
  * @param {int} checkout_card - The id of existing card if selected for checkout.
  *
  * @return order-view,Response code,message.
  * @exception throw if any error occur when checkout.
  */
  public function finalCheckout(Request $request)
  {
    Log::info('user::CartController::finalCheckout::START');
    $result = DB::transaction(function () use($request){
      try{
        $client = new Payeezy_Client();
        $client->setApiKey("JQDENhx7oEbg9vl1mAv5lu1AEGpXPhMX");
        $client->setApiSecret("4a9de24bd9a19c850c91a10527d3c43b9ec7ad8e8cc35110bbf9b94f833b8856");
        $client->setMerchantToken('fdoa-a8917f80977c371f6d1c0d312fd570fb6d8a08982c13d69e');
        $client->setUrl("https://api.payeezy.com/v1/transactions");
        // var_dump($client);
        // exit;
        $input =  $request ->all();
        if(null != $input && '' != $input ){
          $user = Auth::user();
          $oldCart = Session::get('cart');
          if(null != $oldCart && '' != $oldCart ){
            $cart = new Cart($oldCart);
            if(null!=$cart && ''!=$cart){
              $items = $cart->items;
              if(null!=$items && ''!=$items && count($items)>0){
                $noProdFound = 0;
                $total= 0;
                foreach($items as $item){
                  $product = Product::find($item['item']->id);
                  if(null != $product && '' != $product){
                    if($item['qty'] > $product['in_stock_quantity']){
                      $message = $product['name'].' '.USER_ORDER_PRODUCT_STOCK_ERROR;
                      Log::info('user::CartController::finalCheckout::' .$message);
                      return Redirect::back()->withErrors([$message])->withInput($request ->all());
                    }else{
                      $total = $total + ($item['qty'] * $item['item_price']);
                    }
                  }else{
                    $noProdFound=1;
                    break;
                  }
                }

                if(is_float($total)){
                  $totalArray = explode('.', $total);
                  // var_dump($totalArray);
                  // exit;
                  $nonFloatTotal = str_replace('.', '', $total);
                  if(isset($totalArray[1])){
                    $count = strlen($totalArray[1]);
                    if($count === 1){
                      $apiTotal = $nonFloatTotal ."0";
                    }else if($count === 2){
                      $apiTotal = $nonFloatTotal;
                    }
                  }else{
                  $apiTotal = $nonFloatTotal ."00";
                }
                  //var_dump($count);
                }else{
                  $apiTotal = $total ."00";
                }
                //var_dump($apiTotal);
                // exit;
                if($noProdFound==1){
                  Log::info('user::CartController::finalCheckout::' .USER_CHECKOUT_EMPTY_CART_ERROR);
                  return Redirect::back()->withErrors([USER_CHECKOUT_EMPTY_CART_ERROR])->withInput($request ->all());
                }
                $input['user_id'] = $user['id'];
                $existingUserAddress = Address::where('user_id' ,$user['id'] )->get();
                if(null!=$existingUserAddress && ''!=$existingUserAddress && count($existingUserAddress)>0){
                  if (!array_key_exists('billing_address_id', $input)) {
                    Log::info('user::CartController::finalCheckout::' .USER_CHECKOUT_EMPTY_BILLING_ADDRESS);
                    return Redirect::back()->withErrors([USER_CHECKOUT_EMPTY_BILLING_ADDRESS])->withInput($request ->all());
                  }else{
                    $existingShippingAddress = Address::find($input['billing_address_id']);
                    if(null == $existingShippingAddress || '' == $existingShippingAddress){
                      Log::info('user::CartController::finalCheckout::' .USER_CHECKOUT_NOT_VALID_BILLING_ADDRESS);
                      return Redirect::back()->withErrors([USER_CHECKOUT_NOT_VALID_BILLING_ADDRESS])->withInput($request ->all());
                    }else{
                      $data['billing_address_id'] = $input['billing_address_id'];
                    }
                  }
                  if (!array_key_exists('shipping_address_id', $input)) {
                    Log::info('user::CartController::finalCheckout::' .USER_CHECKOUT_EMPTY_SHIPPING_ADDRESS);
                    return Redirect::back()->withErrors([USER_CHECKOUT_EMPTY_SHIPPING_ADDRESS])->withInput($request ->all());
                  }else{
                    $existingShippingAddress = Address::find($input['shipping_address_id']);
                    if(null == $existingShippingAddress || '' == $existingShippingAddress){
                      Log::info('user::CartController::finalCheckout::' .USER_CHECKOUT_NOT_VALID_SHIPPING_ADDRESS);
                      return Redirect::back()->withErrors([USER_CHECKOUT_NOT_VALID_SHIPPING_ADDRESS])->withInput($request ->all());
                    }
                    else{
                      $data['shipping_address_id'] = $input['shipping_address_id'];
                    }
                  }
                }else{
                  Log::info('user::CartController::finalCheckout::' .USER_CHECKOUT_EMPTY_ADDRESS);
                  return Redirect::back()->withErrors([USER_CHECKOUT_EMPTY_ADDRESS])->withInput($request ->all());
                }
                $data['user_id'] = $user['id'];
                $data['payment_method'] = ORDER_PAYMENT_METHOD;
                // var_dump($input);
                // exit;
                $data['terms_conditions'] = $input['terms'];
                $data['amount'] = $total;
                $validation = Order::validateCreateOrder($data);
                if ($validation != null && $validation != '' && $validation->fails()) {
                  $commaSeparated = $validation->messages()->all();
                  $message = implode("\n", $commaSeparated);
                  Log::warning('user::CartController::finalCheckout::' . $message);
                  return Redirect::back()->withErrors([$message])->withInput($request ->all());
                }
                $input['card_number'] = str_replace(' ', '', $input['card_number']);
                $apiKey = config('production_env.froogal_it_api_key');
                $username = config('production_env.froogal_it_user_name');
                $allExistingCard = UserCardInfo::where('user_id',$user['id'])->get();
                if(null!=$allExistingCard && ''!=$allExistingCard && count($allExistingCard)>0 && array_key_exists('checkout_card', $input) && null!=$input['checkout_card'] && ''!=$input['checkout_card']){
                  $cardDetails = UserCardInfo::find($input['checkout_card']);
                  if(null!=$cardDetails && ''!=$cardDetails){
                    if(null==$cardDetails['token'] || ''==$cardDetails['token']){
                      Log::warning('user::CartController::finalCheckout::' . USER_CHECKOUT_CRAD_NOT_USED_ERROR);
                      return Redirect::back()->withErrors([USER_CHECKOUT_CRAD_NOT_USED_ERROR])->withInput($request ->all());
                    }
                    $token=$cardDetails['token'];
                    // var_dump($total);
                    // exit;
                    $authorize_card_transaction = new Payeezy_Token($client);
                    $resCard = $authorize_card_transaction->purchase(
                      [
                        "merchant_ref" => "Frelii",
                        "method" => "token",
                        "amount" => $apiTotal,
                        "currency_code" => "USD",
                        "token" => array(
                          "token_type" => "FDToken",
                          "token_data" => array(
                            "type" => $cardDetails['brand'],
                            "value" => $cardDetails['token'],
                            "cardholder_name" => $cardDetails['card_holder_name'],
                            "exp_date" => $cardDetails['expiration'],
                          ),
                          //"ta_token"=> "VV7Z",
                        )
                      ]
                    );
                    var_dump($resCard);
                    exit;
                    if(null == $resCard || '' == $resCard){
                      Log::warning('user::CartController::finalCheckout::' . USER_CHECKOUT_SAVE_CARD_ERROR);
                      return Redirect::back()->withErrors([USER_CHECKOUT_SAVE_CARD_ERROR])->withInput($request ->all());
                    }
                    $resultCard =  json_decode(json_encode($resCard),true);
                    if(null == $resultCard || '' == $resultCard){
                      Log::warning('user::CartController::finalCheckout::' . USER_CHECKOUT_SAVE_CARD_ERROR);
                      return Redirect::back()->withErrors([USER_CHECKOUT_SAVE_CARD_ERROR])->withInput($request ->all());
                    }

                    if (array_key_exists('Status', $resultCard) && $resultCard['Status'] == 'error') {
                      if(array_key_exists('code', $resultCard)){
                        if($resultCard['code'] == PAYMENT_API_ERROR_CODE_702){
                          $resultCard['Message'] = PAYMENT_API_ERROR_CODE_702_MESSAGE;
                        }
                        else if($resultCard['code'] == PAYMENT_API_ERROR_CODE_701){
                          $resultCard['Message'] = PAYMENT_API_ERROR_CODE_701_MESSAGE;
                        }
                        else if($resultCard['code'] == PAYMENT_API_ERROR_CODE_7){
                          $resultCard['Message'] = PAYMENT_API_ERROR_CODE_7_MESSAGE;
                        }
                        else if($resultCard['code'] == PAYMENT_API_ERROR_CODE_19){
                          $resultCard['Message'] = PAYMENT_API_ERROR_CODE_19_MESSAGE;
                        }
                        else if($resultCard['code'] == PAYMENT_API_ERROR_CODE_23){
                          $resultCard['Message'] = PAYMENT_API_ERROR_CODE_23_MESSAGE;
                        }
                        else if($resultCard['code'] == PAYMENT_API_ERROR_CODE_14){
                          $resultCard['Message'] = PAYMENT_API_ERROR_CODE_14_MESSAGE;
                        }
                        else{
                          Log::error('Admin::CustomerController::store::' . $resultCard['code']);
                        }
                      }
                      if($resultCard['Message'] == 'Invalid API key' ){
                        $resultCard['Message'] = TRANSACTION_ERROR;
                      }
                      Log::error('Admin::CustomerController::store::' . $resultCard['Message']);
                      return Redirect::back()->withErrors([$resultCard['Message']])->withInput($request ->all());
                    }else if (array_key_exists('validation_status', $resultCard) && $resultCard['validation_status'] == 'success' ) {
                      $data['user_card_info_id'] = $input['checkout_card'];
                      $data['auth_number'] = $resultCard['transaction_tag'];
                      $data['invoice_number'] = $resultCard['transaction_id'];
                      $data['amount'] = $total;
                      $data['paid'] = 1;
                    }else{
                      Log::warning('user::CartController::finalCheckout::' . USER_CHECKOUT_CRAD_NOT_FOUND_ERROR);
                      return Redirect::back()->withErrors([USER_CHECKOUT_CRAD_NOT_FOUND_ERROR])->withInput($request ->all());
                    }
                  }
                }
                else if(array_key_exists('new-card-update', $input) && $input['new-card-update']==1 && array_key_exists('save_this_card', $input) && $input['save_this_card']==1){
                  /* Add Card To Vault Start*/
                  $last4Digit = substr($input['card_number'],-4);
                  $alredyExistCard=UserCardInfo::where('user_id',$user['id'])->where('last4',$last4Digit)->first();
                  if(null != $alredyExistCard || '' != $alredyExistCard){
                    Log::warning('user::CartController::finalCheckout::' . USER_CHECKOUT_ALREADY_EXIST_CARD);
                    return Redirect::back()->withErrors([USER_CHECKOUT_ALREADY_EXIST_CARD])->withInput($request ->all());
                  }
                  $input['expiration'] = str_replace('/','',$input['expiration']);
                  // var_dump($apiTotal);
                  // exit;
                  $authorize_card_transaction = new Payeezy_CreditCard($client);
                  $authorize_response = $authorize_card_transaction->authorize(
                    [
                      "merchant_ref" => "Frelii",
                      "amount" => $apiTotal,
                      "currency_code" => "USD",
                      "credit_card" => array(
                        "type" => $request['card_type'],
                        "cardholder_name" => $input['card_name'],
                        "card_number" => $input['card_number'],
                        "exp_date" => str_replace('/', '', $input['expiration']),
                        "cvv" => $input['csv']
                      ),
                    ]
                  );
                  $resultAddCard = (array) json_decode(json_encode($authorize_response),true);
                  if(null == $resultAddCard || '' == $resultAddCard){
                    Log::warning('user::CartController::finalCheckout::' . USER_CHECKOUT_SAVE_CARD_ERROR);
                    return Redirect::back()->withErrors([USER_CHECKOUT_SAVE_CARD_ERROR])->withInput($request ->all());
                  }
                  if (array_key_exists('Status', $resultAddCard) && $resultAddCard['Status'] == 'error') {
                    if(array_key_exists('code', $resultAddCard)){
                      if($resultAddCard['code'] == PAYMENT_API_ERROR_CODE_702){
                        $resultAddCard['Message'] = PAYMENT_API_ERROR_CODE_702_MESSAGE;
                      }
                      else if($resultAddCard['code'] == PAYMENT_API_ERROR_CODE_701){
                        $resultAddCard['Message'] = PAYMENT_API_ERROR_CODE_701_MESSAGE;
                      }
                      else if($resultAddCard['code'] == PAYMENT_API_ERROR_CODE_7){
                        $resultAddCard['Message'] = PAYMENT_API_ERROR_CODE_7_MESSAGE;
                      }
                      else if($resultAddCard['code'] == PAYMENT_API_ERROR_CODE_19){
                        $resultAddCard['Message'] = PAYMENT_API_ERROR_CODE_19_MESSAGE;
                      }
                      else if($resultAddCard['code'] == PAYMENT_API_ERROR_CODE_23){
                        $resultAddCard['Message'] = PAYMENT_API_ERROR_CODE_23_MESSAGE;
                      }
                      else if($resultAddCard['code'] == PAYMENT_API_ERROR_CODE_14){
                        $resultAddCard['Message'] = PAYMENT_API_ERROR_CODE_14_MESSAGE;
                      }
                      else{
                        Log::error('Admin::CustomerController::store::' . $resultAddCard['code']);
                      }
                    }
                    if($resultAddCard['Message'] == 'Invalid API key' ){
                      $resultAddCard['Message'] = TRANSACTION_ERROR;
                    }
                    Log::error('Admin::CustomerController::store::' . $resultAddCard['Message']);
                    return Redirect::back()->withErrors([$resultAddCard['Message']])->withInput($request ->all());
                  }
                  /* Add Card To Vault End*/
                  if (array_key_exists('validation_status', $resultAddCard) && $resultAddCard['validation_status'] == 'success' ) {
                    /* Perform card vault transaction start*/
                    $capture_card_transaction = new Payeezy_CreditCard($client);
                    $capture_response = $capture_card_transaction->capture(
                      $authorize_response->transaction_id,
                      array(
                        "amount" => $apiTotal,
                        "transaction_tag" => $resultAddCard['transaction_tag'],
                        "merchant_ref" => "Frelii",
                        "currency_code" => "USD",
                      )
                    );
                    if(null == $capture_response || '' == $capture_response){
                      Log::warning('user::CartController::finalCheckout::' . USER_CHECKOUT_SAVE_CARD_ERROR);
                      return Redirect::back()->withErrors([USER_CHECKOUT_SAVE_CARD_ERROR])->withInput($request ->all());
                    }
                    $result2 = (array) json_decode(json_encode($capture_response),true);
                    if(null == $result2 || '' == $result2){
                      Log::warning('user::CartController::finalCheckout::' . USER_CHECKOUT_SAVE_CARD_ERROR);
                      return Redirect::back()->withErrors([USER_CHECKOUT_SAVE_CARD_ERROR])->withInput($request ->all());
                    }
                    if (array_key_exists('Status', $result2) && $result2['Status'] == 'error') {
                      if(array_key_exists('code', $resultAddCard)){

                        if($resultAddCard['code'] == PAYMENT_API_ERROR_CODE_702){
                          $resultAddCard['Message'] = PAYMENT_API_ERROR_CODE_702_MESSAGE;
                        }
                        else if($resultAddCard['code'] == PAYMENT_API_ERROR_CODE_701){
                          $resultAddCard['Message'] = PAYMENT_API_ERROR_CODE_701_MESSAGE;
                        }
                        else if($resultAddCard['code'] == PAYMENT_API_ERROR_CODE_7){
                          $resultAddCard['Message'] = PAYMENT_API_ERROR_CODE_7_MESSAGE;
                        }
                        else if($resultAddCard['code'] == PAYMENT_API_ERROR_CODE_19){
                          $resultAddCard['Message'] = PAYMENT_API_ERROR_CODE_19_MESSAGE;
                        }
                        else if($resultAddCard['code'] == PAYMENT_API_ERROR_CODE_23){
                          $resultAddCard['Message'] = PAYMENT_API_ERROR_CODE_23_MESSAGE;
                        }
                        else if($resultAddCard['code'] == PAYMENT_API_ERROR_CODE_14){
                          $resultAddCard['Message'] = PAYMENT_API_ERROR_CODE_14_MESSAGE;
                        }
                        else{
                          Log::error('Admin::CustomerController::store::' . $resultAddCard['code']);
                        }
                      }
                      if($resultAddCard['Message'] == 'Invalid API key' ){
                        $resultAddCard['Message'] = TRANSACTION_ERROR;
                      }
                      Log::error('Admin::CustomerController::store::' . $result2['Message']);
                      return Redirect::back()->withErrors([$result2['Message']])->withInput($request ->all());
                    }
                    /* Perform card vault transaction end*/
                    if (array_key_exists('validation_status', $result2) && $result2['validation_status'] == 'success' ) {
                      $cardData['last4'] = $resultAddCard['card']['card_number'];;
                      $cardData['brand'] = $resultAddCard['card']['type'];
                      $cardData['card_holder_name'] = $resultAddCard['card']['cardholder_name'];
                      $cardData['user_id'] = $user['id'];
                      $cardData['trans_id'] = $resultAddCard['transaction_id'];
                      $cardData['token'] = $resultAddCard['token']['token_data']['value'];
                      $cardData['expiration'] = $resultAddCard['card']['exp_date'];
                      $cardData['csv'] = $request['csv'];
                      $primary = UserCardInfo::where('user_id',$user['id'])->where('is_primary',1)->first();
                      if(null == $primary || '' == $primary){
                        if(!array_key_exists('save_card_primary', $input)){
                          Log::warning('user::CartController::finalCheckout::' . USER_CHECKOUT_ATLEAST_ONE_CARD_PRIMARY);
                          return Redirect::back()->withErrors([USER_CHECKOUT_ATLEAST_ONE_CARD_PRIMARY])->withInput($request ->all());
                        }else if($input['save_card_primary'] == 0){
                          Log::warning('user::CartController::finalCheckout::' . USER_CHECKOUT_ATLEAST_ONE_CARD_PRIMARY);
                          return Redirect::back()->withErrors([USER_CHECKOUT_ATLEAST_ONE_CARD_PRIMARY])->withInput($request ->all());
                        }
                      }
                      if(array_key_exists('save_card_primary', $input) && $input['save_card_primary'] == 1){
                        if(null!=$primary && ''!=$primary){
                          $update = UserCardInfo::where('id',$primary['id'])->update(['is_primary'=>0]);
                          if(null!=$update && ''!=$update){
                            $cardData['is_primary'] = 1;
                          }else{
                            $cardData['is_primary'] = 0;
                          }
                        }else{
                          $cardData['is_primary'] = 1;
                        }
                      }
                      $validation = UserCardInfo::validateCreateCard($cardData);
                      if ($validation != null && $validation != '' && $validation->fails()) {
                        $commaSeparated = $validation->messages()->all();
                        $message = implode("\n", $commaSeparated);
                        Log::warning('user::CartController::finalCheckout::CreateCard' . $message);
                        return Redirect::back()->withErrors([$message])->withInput($request ->all());
                      }
                      $card = UserCardInfo::create($cardData);
                      if(null != $card && '' != $card){
                        $data['last4'] = $resultAddCard['card']['card_number'];
                        $data['brand'] = $resultAddCard['card']['type'];
                        $data['card_holder_name'] = $resultAddCard['card']['cardholder_name'];
                        $data['invoice_number'] = $resultAddCard['transaction_tag'];
                        $data['auth_number'] = $resultAddCard['transaction_id'];
                        $data['amount'] = $total;
                        $data['paid'] = 1;
                      }else {
                        Log::info('user::CartController::finalCheckout::' .USER_CHECKOUT_SAVE_CARD_ERROR);
                        return Redirect::back()->withErrors([USER_CHECKOUT_SAVE_CARD_ERROR])->withInput($request->all());
                      }
                    }else {
                      Log::info('user::CartController::finalCheckout::' .USER_CHECKOUT_SAVE_CARD_ERROR);
                      return Redirect::back()->withErrors([USER_CHECKOUT_SAVE_CARD_ERROR])->withInput($request->all());
                    }
                  }
                  else {
                    Log::info('user::CartController::finalCheckout::' .USER_CHECKOUT_ERROR);
                    return Redirect::back()->withErrors([USER_CHECKOUT_ERROR])->withInput($request->all());
                  }
                }else{
                  if(!array_key_exists('card_name',$input) || !array_key_exists('card_number',$input) || !array_key_exists('expiration',$input)|| !array_key_exists('csv',$input)){
                    Log::warning('user::CartController::finalCheckout::' .USER_CHECKOUT_EMPTY_INPUT_ERROR );
                    return Redirect::back()->withErrors([USER_CHECKOUT_EMPTY_INPUT_ERROR])->withInput($request->all());
                  }

                  $authorize_card_transaction = new Payeezy_CreditCard($client);
                  $authorize_response = $authorize_card_transaction->purchase(
                    [
                      "merchant_ref" => "Frelii",
                      "amount" => $apiTotal,
                      "currency_code" => "USD",
                      "credit_card" => array(
                        "type" => $request['card_type'],
                        "cardholder_name" => $input['card_name'],
                        "card_number" => $input['card_number'],
                        "exp_date" => str_replace('/', '', $input['expiration']),
                        "cvv" => $input['csv']
                      ),
                    ]
                  );


                  $result = (array) json_decode(json_encode($authorize_response),true);
                  if(null == $result || '' == $result){
                    Log::warning('user::CartController::finalCheckout::' . USER_CHECKOUT_ERROR);
                    return Redirect::back()->withErrors([USER_CHECKOUT_ERROR])->withInput($request->all());
                  }
                  if (array_key_exists('Status', $result) && $result['Status'] == 'error') {
                    if(array_key_exists('code', $result)){
                      if($result['code'] == PAYMENT_API_ERROR_CODE_702){
                        $result['Message'] = PAYMENT_API_ERROR_CODE_702_MESSAGE;
                      }
                      else if($result['code'] == PAYMENT_API_ERROR_CODE_701){
                        $result['Message'] = PAYMENT_API_ERROR_CODE_701_MESSAGE;
                      }
                      else if($result['code'] == PAYMENT_API_ERROR_CODE_7){
                        $result['Message'] = PAYMENT_API_ERROR_CODE_7_MESSAGE;
                      }
                      else if($result['code'] == PAYMENT_API_ERROR_CODE_19){
                        $result['Message'] = PAYMENT_API_ERROR_CODE_19_MESSAGE;
                      }
                      else if($result['code'] == PAYMENT_API_ERROR_CODE_23){
                        $result['Message'] = PAYMENT_API_ERROR_CODE_23_MESSAGE;
                      }
                      else if($result['code'] == PAYMENT_API_ERROR_CODE_14){
                        $result['Message'] = PAYMENT_API_ERROR_CODE_14_MESSAGE;
                      }
                      else if($result['code'] == 24){
                        $result['Message'] = PAYMENT_API_ERROR_CODE_702_MESSAGE;
                      }
                      else{
                        Log::error('Admin::CustomerController::store::' . $result['code']);
                      }
                    }
                    if($result['Message'] == 'Invalid API key' ){
                      $result['Message'] = TRANSACTION_ERROR;
                    }
                    Log::error('Admin::CustomerController::store::' . $result['Message']);
                    return Redirect::back()->withErrors([$result['Message']])->withInput($request->all());
                  }
                  if (array_key_exists('validation_status', $result) && $result['validation_status'] == 'success' ) {
                    $data['last4'] = $result['card']['card_number'];
                    $data['brand'] = $result['card']['type'];
                    $data['card_holder_name'] = $result['card']['cardholder_name'];
                    $data['invoice_number'] = $result['transaction_tag'];
                    $data['auth_number'] = $result['transaction_id'];
                    $data['amount'] = $total;
                    $data['paid'] = 1;
                  }
                  else {
                    Log::info('user::CartController::finalCheckout::' .USER_CHECKOUT_ERROR);
                    return Redirect::back()->withErrors([USER_CHECKOUT_ERROR])->withInput($request->all());
                  }
                }

                $order = Order::create($data);
                if(null == $order || '' == $order){
                  Log::warning('user::CartController::finalCheckout::' . USER_CHECKOUT_ERROR);
                  return Redirect::back()->withErrors([USER_CHECKOUT_ERROR])->withInput($request ->all());
                }
                foreach($items as $item){
                  $orderitem['order_id'] = $order->id;
                  $orderitem['product_id'] = $item['item']->id;
                  $orderitem['quantity'] = $item['qty'];
                  $orderitem['item_price'] = $item['item_price'];
                  $orderitemCreated = OrderLine::create($orderitem);
                  if(null!=$orderitemCreated && ''!=$orderitemCreated){
                    $prod = Product::find($orderitemCreated['product_id']);
                    if(null != $prod && '' != $prod){
                      $instock = $prod['in_stock_quantity'] - $orderitemCreated['quantity'];
                      $updateProd = Product::where('id',$orderitemCreated['product_id'])->update(['in_stock_quantity'=>$instock]);
                    }
                  }
                }
                Session::forget('cart');
                Log::info('user::CartController::finalCheckout::End');
                return redirect()->route('orders.show', ['id' => $order->id]);
              }else {
                Log::info('user::CartController::finalCheckout::' .USER_CHECKOUT_EMPTY_CART_ERROR);
                return Redirect::back()->withErrors([USER_CHECKOUT_EMPTY_CART_ERROR])->withInput($request->all());
              }
            }
          }
          else {
            Log::info('user::CartController::finalCheckout::' .USER_CHECKOUT_EMPTY_CART_ERROR);
            return Redirect::back()->withErrors([USER_CHECKOUT_EMPTY_CART_ERROR])->withInput($request->all());
          }
        }
        else {
          Log::info('user::CartController::finalCheckout::' .INPUT_REQUEST_NULL_RESPONSE);
          return Redirect::back()->withErrors([USER_CHECKOUT_EMPTY_INPUT_ERROR])->withInput($request->all());
        }
      } catch (Exception $ex) {
        Log::info('Admin::OrderController::complete_order::' .$ex);
        throw new Exception($ex);
      }
    });
    return $result;
  }


  /**
  * @author : ### ###.
  * Created on : ####
  *
  * Method name: getAddToCartWithInput
  * This method is used change qty of product in cart or add product with qty in cart.
  *
  * @param {int} quantity - The quantity of product.
  *
  * @return order-view,Response code,message.
  * @exception throw if any error occur when checkout.
  */
  public function getAddToCartWithInput(Request $request, $id)
  {
    Log::info('User::CartController::getAddToCartWithInput::Start');
    $result = DB::transaction(function () use ($request, $id) {
      try {
        if(null != $request && '' != $request && null != $id && '' != $id) {
          $quantity = (int)$request['quantity'];
          $product = Product::find($id);
          if($product->in_stock_quantity > 0) {
            // If Product stock is > 1 then we need to compare it against qty in cart
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            //Check if item is already in cart
            if(($cart->items) && array_key_exists($product->id, $cart->items)){
              //Get how much qty of that item is in cart
              if (($product->in_stock_quantity) > ($cart->items[$product->id]['qty'] + $quantity)){
                $cart->totalQty = $cart->totalQty+$quantity-1;
                $cart->add($product, $product->id);
                $cart->items[$product->id]['qty'] = $cart->items[$product->id]['qty'] + $quantity-1;
                Session::put('cart', $cart);
                flash($product->name . ADD_TO_CART_QUANTITY)->success();
                Log::info('User::CartController::getAddToCartWithInput::' .$product->name . ADD_TO_CART_QUANTITY);
                return redirect()->back();
              } else {
                $oldCart = Session::has('cart') ? Session::get('cart') : null;
                $cart = new Cart($oldCart);
                $remainingQty = $product->in_stock_quantity-$cart->items[$product->id]['qty'];
                if($remainingQty == 0) {
                  flash(SOLD_OUT_PRO_TO_ADD_CART_ERR)->error();
                  Log::info('User::CartController::getAddToCartWithInput::' . SOLD_OUT_PRO_TO_ADD_CART_ERR);
                } else {
                  $remainingQty = $remainingQty -1;
                  flash(NOT_ENOUGH_QTY_TO_ADD_CART_ERR. $remainingQty . '.')->error();
                  Log::info('User::CartController::getAddToCartWithInput::' . NOT_ENOUGH_QTY_TO_ADD_CART_ERR .$remainingQty);
                }
                return redirect()->back();
              }
            }
            else {
              $cart->add($product, $product->id);
              // if (($product->in_stock_quantity) >= ($cart->items[$product->id]['qty'] + $quantity)){
              if ($product->in_stock_quantity > $quantity){
                $cart->totalQty =  $cart->totalQty+$quantity-2;
                $cart->add($product, $product->id);
                $cart->items[$product->id]['qty'] = $cart->items[$product->id]['qty'] + $quantity-2 ;
                Session::put('cart', $cart);
                flash($product->name . ADD_TO_CART_QUANTITY)->success();
                Log::info('User::CartController::getAddToCartWithInput::' . $product->name . ADD_TO_CART_QUANTITY);
                return redirect()->back();
              }
              else {
                $oldCart = Session::has('cart') ? Session::get('cart') : null;
                $cart = new Cart($oldCart);
                $product->in_stock_quantity = $product->in_stock_quantity - 1;
                flash(NOT_ENOUGH_QTY_TO_ADD_CART_ERR. $product->in_stock_quantity . '.')->error();
                Log::info('User::CartController::getAddToCartWithInput::' . NOT_ENOUGH_QTY_TO_ADD_CART_ERR. $product->in_stock_quantity);
                return redirect()->back();
              }
            }
          } else {
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            flash($product->name . ADD_TO_CART_QUANTITY_ERROR)->error();
            Log::info('User::CartController::getAddToCartWithInput::' . $product->name . ADD_TO_CART_QUANTITY_ERROR);
            return redirect()->back();
          }
        }
      }
      catch (Exception $ex) {
        Log::info('User::CartController::getAddToCartWithInput::End ');
        throw new Exception($ex);
      }
    });
    return $result;
  }


  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id and $request
  * @return \Illuminate\Http\Response
  */
  public function getAddToCart(Request $request, $id)
  {
    $product = Product::find($id);
    if($product->in_stock_quantity > 1)
    {
      // If Product stock is > 1 then we need to compare it against qty in cart
      $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $cart = new Cart($oldCart);
      //Check if item is already in cart
      if(($cart->items) && array_key_exists($product->id, $cart->items)){
        //Get how much qty of that item is in cart
        if (($product->in_stock_quantity) > ($cart->items[$product->id]['qty'] + 1)){
          $cart->add($product, $product->id);
          Session::put('cart', $cart);
          flash($product->name . ' has been added to cart.')->success();
          return redirect()->back();
        } else {
          $oldCart = Session::has('cart') ? Session::get('cart') : null;
          $cart = new Cart($oldCart);
          flash($product->name . ' can not be added to cart because enough quantity is not in stock.')->error();
          return redirect()->back();
        }
      }

      $cart->add($product, $product->id);
      Session::put('cart', $cart);
      flash($product->name . ' has been added to cart.')->success();
      return redirect()->back();
    } else {
      $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $cart = new Cart($oldCart);
      flash($product->name . ' can not be added to cart because enough quantity is not in stock.')->error();
      return redirect()->back();
    }
  }

  public function getMinusFromCart(Request $request, $id)
  {
    Log::info('User::addProductToCart::getMinusFromCart::Start');
    $result = DB::transaction(function () use ($request, $id) {
      try {
        if(null != $request && '' != $request && null != $id && '' != $id) {
          $product = Product::find($id);
          if(null!=$product && ''!=$product){
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            if(null!=$oldCart && ''!=$oldCart){
              $cart = new Cart($oldCart);
              $oldQuantity =$cart->items[$product->id]['qty'];
              $totalQty = $oldCart->totalQty;
              $cart->minus($product, $product->id);
              Session::put('cart', $cart);
              flash($product->name .MINUS_FROM_CART_QUANTITY)->success();
              $newQuantity = $oldQuantity - 1;
              if($newQuantity == 0 && $totalQty==0){
                return view('front.shop.empty_cart', ['products' => null]);
              }else{
                return redirect()->back();
              }
            }
            else{
              return redirect()->back();
            }
          }else{
            return redirect()->back();
          }
        }
      }
      catch (Exception $ex) {
        Log::info('User::CartController::getMinusFromCart::End ');
        throw new Exception($ex);
      }
    });
    return $result;
  }

}
