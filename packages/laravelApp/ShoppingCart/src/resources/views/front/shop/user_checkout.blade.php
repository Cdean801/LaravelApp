@extends('welcome')
@section('title')
Checkout - Frelii
@endsection

@section('content')
@include('../front/partials/sidenav')
<script>
/*  get all county for dropdown */
$.ajax({
  type: 'GET',
  url: '/getCountry',
  success: function (data) {
    var selectedCountry=$('p[name="selectedCountry"]').text();
    $('select[name="country"]').empty();
    $.each(data, function (key, value) {
      if(key == selectedCountry){
        $('select[name="country"]').append('<option value="' + key + '" selected>' + value + '</option>');
        var parm = {'country': key}
        var param = JSON.stringify(parm);
        /*  get all state according to country for dropdown */
        $.ajax({
          url: '/getState',
          type: 'GET',
          data: parm,
          success: function (data) {
            if ('State not found' == data) {
              $('select[name="state"]').empty();
              $('#state').append('<option value="N.A">N.A</option>');
              $('#state').selectpicker('refresh');
            }else {
              var selectedState=$('p[name="selectedState"]').text();
              $('select[name="state"]').empty();
              var res = data.state;
              $.each(res, function (key, value) {
                if(value == selectedState){
                  $('#state').append('<option value="' + value + '" selected>' + value + '</option>');
                }else{
                  $('#state').append('<option value="' + value + '">' + value + '</option>');
                }
                $('#state').selectpicker('refresh');
              });
            }
          },
          error: function () {
            console.log("State not found");
          }
        });
        /* END */
      }else{
        $('select[name="country"]').append('<option value="' + key + '">' + value + '</option>');
      }
    });
  }
});
/* END */

$(document).ready(function () {
  /* show tooltip for input  */
  $('[data-toggle="tooltip"]').tooltip();

  /*  showing active tab after sucess or error */
  $('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
    // console.log("on show tab");
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });
  var activeTab = localStorage.getItem('activeTab');
  if(activeTab){
    $('#myTab a[href="' + activeTab + '"]').tab('show');
  }
  /* END */

  /* show next or previous tab on button click */
  $('.btnNext').click(function(){
    // console.log("next button click");
    $('.nav-pills > .active').next('li').find('a').trigger('click');
  });

  $('.btnPrevious').click(function(){
    // console.log("btn Previous click");
    $('.nav-pills > .active').prev('li').find('a').trigger('click');
  });
  /* END */

  /*  dropdown state according to country */
  $('select[name="country"]').on('change', function () {
    var countryID = $(this).val();
    var parm = {'country': countryID}
    var param = JSON.stringify(parm);
    if (countryID) {
      $.ajax({
        url: '/getState',
        type: 'GET',
        data: parm,
        success: function (data) {
          if ('State not found' == data) {
            $('select[name="state"]').empty();
            $('#state').append('<option value="N.A">N.A</option>');
            $('#state').selectpicker('refresh');
          }else {
            $('select[name="state"]').empty();
            var res = data.state;
            $.each(res, function (key, value) {
              $('#state').append('<option value="' + value + '">' + value + '</option>');
              $('#state').selectpicker('refresh');
            });
          }
        },
        error: function () {
          console.log("State not found");
        }
      });
    } else {
      $('select[name="state"]').empty();
    }
  });
  /* END*/
});
</script>

<link href="{{ asset('css/front/shop/checkout.css') }}" rel="stylesheet">
<div class="section profile-first-section">
  <div class="container">
    <!-- BEGIN: Subheader -->
    <div class="row responsive-style">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <h1 class="checkout-heading-color">Checkout</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        @include('flash::message')
        <form class="" role="form" method="POST" action="{{ route('finalCheckout') }}" id="checkoutForm" data-toggle="validator">
          <!-- <div class="panel panel-default"> -->
          <div class="panel panel-default panel-style">
            <div class="panel-body">
              <!-- Nav tabs -->
              <ul class="nav nav-pills" id="myTab">
                <li class="active"><a data-toggle="pill" href="#adress"class="text-uppercase">Address</a></li>
                <li id="membershipTab"><a data-toggle="pill" href="#membership" class="text-uppercase">Order Items</a></li>
                <li id="paymentTab"><a data-toggle="pill" href="#payment" class="text-uppercase">Set up your payment</a></li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <!-- Personal Details tab -->
                <div role="tabpanel" class="tab-pane active" id="adress">
                  <hr>
                  <div>
                    <h3>Address details</h3>
                  </div>
                  <hr>
                  {{ csrf_field() }}
                  <div>
                    <!-- <div class="panel panel-default" id="billingAddressDiv"> -->
                    <!-- <div class="panel-body"> -->
                    @if(count($address['billing'])>0)
                    <div class="row">
                      <div class="col-md-6">
                        <h3>Billing Address</h3>
                        @foreach($address['billing'] as $add)
                        <div class="panel panel-default">
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group checkbox">
                                  <label>
                                    <input type="radio" name="billing_address_id" class="form-check-input" id="billingAddress{{ $add->id }}" value="{{ $add->id }}" {{ ( $add->is_primary == 1 ) ? 'checked' : '' }} required>
                                    <b>Address {{$loop->iteration}} @if(null!=$add->address_title && ''!=$add->address_title) ({{$add->address_title}}) @endif</b>
                                  </label>
                                  <div class="help-block with-errors"></div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12 address-div">
                                {{$add->first_name}} {{$add->last_name}},
                                {{$add->address1}},
                                @if($add->address2!=null && $add->address2 != '')
                                {{$add->address2}},
                                @endif
                                {{$add->country}},
                                {{$add->town_city}},
                                {{$add->state}},
                                {{$add->zip}},
                                {{$add->phone}},
                                {{$add->email}}.
                              </div>
                            </div>
                          </div>
                        </div>
                        @endforeach
                      </div>
                      <div class="col-md-6">
                        <h3>Shipping Address</h3>
                        @foreach($address['shipping'] as $add)
                        <div class="panel panel-default">
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group checkbox">
                                  <label>
                                    <input type="radio" name="shipping_address_id" class="form-check-input" id="shippingAddress{{ $add->id }}" value="{{ $add->id }}" {{ ($add->is_primary == 1) ? 'checked' : '' }} required>
                                    <b>Address {{$loop->iteration}} @if(null!=$add->address_title && ''!=$add->address_title) ({{$add->address_title}}) @endif</b>
                                  </label>
                                  <div class="help-block with-errors"></div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12 address-div">
                                {{$add->first_name}} {{$add->last_name}},
                                {{$add->address1}},
                                @if($add->address2!=null && $add->address2 != '')
                                {{$add->address2}},
                                @endif
                                {{$add->country}},
                                {{$add->town_city}},
                                {{$add->state}},
                                {{$add->zip}},
                                {{$add->phone}},
                                {{$add->email}}.
                              </div>
                            </div>
                          </div>
                        </div>
                        @endforeach
                      </div>
                    </div>
                    @else
                    <div class="row">
                      <div class="col-md-6 form-group text-left responsive-text-center">
                        <a type="button" class="btn btn-default button-style white-color btnNext" href="{{ route('user-address.create',['permission' => encrypt(ADDRESS_CREATE_PERMISSION)]) }}">ADD NEW ADDRESS</a>
                      </div>
                    </div>
                    @endif
                  </div>
                  <div class="row">
                    <div  class="col-md-6 form-group text-left responsive-text-center">
                      <span>
                        <a type="button" class="btn btn-default button-style white-color btnNext responsive-button-style" href="{{ url('cart') }}" onclick='clearLocalStorage();'>Go to Cart</a>
                      </span>
                      @if(count($address['billing'])!=0)
                      <span>
                        <a type="button" class="btn btn-default button-style white-color btnNext" href="{{ route('user-address.create',['permission' => encrypt(ADDRESS_CREATE_PERMISSION)]) }}">ADD NEW ADDRESS</a>
                      </span>
                      @endif
                    </div>
                    <div class="col-md-6 form-group text-right responsive-text-center">
                      <button type="button" class="btn btn-default button-style white-color btnNext" id="addressNextBtn">NEXT</button>
                    </div>
                  </div>
                  <!-- </form> -->
                </div>
                <!-- END -->

                <!-- Adress Details tab -->
                <div role="tabpanel" class="tab-pane" id="membership">
                  <!-- <form class="" method="POST" action="{{ route('update_profile') }}" id="profileAdressForm" data-toggle="validator"> -->
                  <hr>
                  <div class="row">
                    <div class="col-md-6">
                      <h3>Your order</h3>
                      <table class="shopping-cart-table table">
                        <thead>
                          <th>Product</th>
                          <th class="text-right">Total</th>
                        </thead>
                        <tbody>
                          @foreach($products as $key=>$value)
                          <tr>
                            <td>{{$value['item']['name']}} <b><i class="fa fa-times"></i> {{ $value['qty']}}</b></td>
                            <td class="green-color text-right">{{number_format($value['total_price'],2)}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Subtotal</th>
                            <td class="sub-total green-color text-right"><b>${{ number_format($total, 2) }}</b></td>
                          </tr>
                          <tr>
                            <th class="order-total">Total</th>
                            <td class="total green-color text-right"><b>${{ number_format($total, 2) }}</b></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <div class="col-md-6"></div>
                  </div>
                  <div class="text-right">
                    <div class="col-md-6 form-group text-left responsive-text-center">
                      <a type="button" class="btn btn-default button-style white-color btnNext" href="{{ url('cart') }}" onclick='clearLocalStorage();'>Go to Cart</a>
                      <button type="button" class="btn btn-default button-style white-color btnPrevious">Previous</button>
                    </div>
                    <div class="col-md-6 form-group text-right responsive-text-center">
                      <button type="button" class="btn btn-default button-style white-color btnNext">NEXT</button>
                    </div>
                  </div>
                </div>
                <!-- END -->

                <!-- Password Details tab -->
                <div role="tabpanel" class="tab-pane" id="payment">
                  <hr>
                  <div class="row">
                    <div class="col-md-8">
                      @if(count($cards)>0)
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          Select Existing Card
                        </div>
                        <input type="hidden" value="1" name="card-exist" id="cardExist">
                        <div class="panel-body">
                          @foreach($cards as $card)
                          <div class="panel panel-default">
                            <div class="panel-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group checkbox">
                                    <label>
                                      <input type="radio" name="checkout_card" class="form-check-input" id="checkoutCard" value="{{ $card->id }}"  {{ (old('checkout_card')== $card->id ) ? 'checked':'' }}>
                                      <b>Card {{$loop->iteration}}</b></label>
                                    </label>
                                    <div class="help-block with-errors"></div>
                                  </div>
                                </div>
                              </div>
                              <table class="table text-center">
                                <tr class="credit-card-table-row">
                                  <td><h3 class="credit-card-table-col">{{$card['brand']}}</h3></td>
                                </tr>
                                <tr class="credit-card-table-row">
                                  <td><h3 class="credit-card-table-col">XXXX XXXX XXXX {{$card['last4']}}</h3></td>
                                </tr>
                              </table>
                            </div>
                          </div>
                          @endforeach
                          <div class="row new-card-div">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="enter-new-card" id="newCard" value="{{ old('enter-new-card') }}" {{ (old('enter-new-card')== 1) ? 'checked':'' }}>
                                <b class="new-card-label-font">Do you want to use another card?</b></label>
                              </label>
                              <div class="help-block with-errors"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endif
                      <div class="panel panel-default" id="paymentDiv">
                        <div class="panel-body">
                          <div id="accordion">
                            <div class="panel panel-default" >
                              <div class="panel-heading panel-color">
                                <h4 class="panel-title">
                                  <label for='r11' class="credit-card-brand-label">
                                    <!-- <input type='radio' id='r11' name='occupation' value='Working' />&nbsp; Credit Card -->
                                    <!--<input type='radio' id='r11' name='occupation' value='Working' required data-toggle="collapse" data-parent="#accordion" href="#collapseOne" />&nbsp; Credit Card-->
                                    <img src="https://frelii.com/wp-content/plugins/woocommerce-gateway-paypal-powered-by-braintree/lib/skyverge/woocommerce/payment-gateway/assets/images/card-visa.svg" alt="visa" class="sv-wc-payment-gateway-icon wc-braintree-credit-card-payment-gateway-icon credit-card-brand-img" width="40" height="25">
                                    <img src="https://frelii.com/wp-content/plugins/woocommerce-gateway-paypal-powered-by-braintree/lib/skyverge/woocommerce/payment-gateway/assets/images/card-mastercard.svg" alt="mastercard" class="sv-wc-payment-gateway-icon wc-braintree-credit-card-payment-gateway-icon credit-card-brand-img" width="40" height="25">
                                    <img src="https://frelii.com/wp-content/plugins/woocommerce-gateway-paypal-powered-by-braintree/lib/skyverge/woocommerce/payment-gateway/assets/images/card-amex.svg" alt="amex" class="sv-wc-payment-gateway-icon wc-braintree-credit-card-payment-gateway-icon credit-card-brand-img" width="40" height="25">
                                    <img src="https://frelii.com/wp-content/plugins/woocommerce-gateway-paypal-powered-by-braintree/lib/skyverge/woocommerce/payment-gateway/assets/images/card-discover.svg" alt="discover" class="sv-wc-payment-gateway-icon wc-braintree-credit-card-payment-gateway-icon credit-card-brand-img" width="40" height="25">
                                    <img src="https://frelii.com/wp-content/plugins/woocommerce-gateway-paypal-powered-by-braintree/lib/skyverge/woocommerce/payment-gateway/assets/images/card-dinersclub.svg" alt="dinersclub" class="sv-wc-payment-gateway-icon wc-braintree-credit-card-payment-gateway-icon credit-card-brand-img" width="40" height="25">
                                    <img src="https://frelii.com/wp-content/plugins/woocommerce-gateway-paypal-powered-by-braintree/lib/skyverge/woocommerce/payment-gateway/assets/images/card-maestro.svg" alt="maestro" class="sv-wc-payment-gateway-icon wc-braintree-credit-card-payment-gateway-icon credit-card-brand-img" width="40" height="25">
                                    <img src="https://frelii.com/wp-content/plugins/woocommerce-gateway-paypal-powered-by-braintree/lib/skyverge/woocommerce/payment-gateway/assets/images/card-jcb.svg" alt="jcb" class="sv-wc-payment-gateway-icon wc-braintree-credit-card-payment-gateway-icon credit-card-brand-img" width="40" height="25">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"></a>
                                  </label>
                                </h4>
                              </div>
                              <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body credit-card">
                                  <div class="row">
                                    <div class="col-md-12 form-group{{ $errors->has('card_name') ? ' has-error' : '' }}">
                                      <label for="card_name" >Card Holder Name <span class="required">*</span></label>
                                      <input placeholder="abc xyz" id="cardName" type="string" class="form-control" name="card_name" value="{{ old('card_name') }}" maxlength="191">
                                      <div class="help-block with-errors"></div>
                                      @if ($errors->has('card_name'))
                                      <span class="help-block">
                                        <strong>{{ $errors->first('card_name') }}</strong>
                                      </span>
                                      @endif
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12 form-group{{ $errors->has('card_number') ? ' has-error' : '' }}">
                                      <label for="card_number" >Card Number <span class="required">*</span></label>
                                      <input  placeholder="••••••••••••••••" id="card_number" type="card_number" class="form-control" name="card_number" value="{{ old('card_number') }}" data-minlength="16" maxlength="16" data-minlength-error="Card number must be 16 digits">
                                      <div class="help-block with-errors"></div>
                                      @if ($errors->has('card_number'))
                                      <span class="help-block">
                                        <strong>{{ $errors->first('card_number') }}</strong>
                                      </span>
                                      @endif
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6 form-group{{ $errors->has('expiration') ? ' has-error' : '' }}">
                                      <label for="expiration" >Expiration(MM/YY) <span class="required">*</span></label>
                                      <input id="expiration" minlength="5" maxlength="5" placeholder="MM/YY"  type="text" class="form-control" name="expiration" value="{{ old('expiration') }}">
                                      <div class="help-block with-errors"></div>
                                      @if ($errors->has('expiration'))
                                      <span class="help-block">
                                        <strong>{{ $errors->first('expiration') }}</strong>
                                      </span>
                                      @endif
                                    </div>

                                    <script type="text/javascript">
                                    $( document ).ready(function() {
                                      $('#expiration').bind('keyup','keydown', function(event) {
                                        var inputLength = event.target.value.length;
                                        if (event.keyCode != 8){
                                          if(inputLength === 2 ){
                                            var thisVal = event.target.value;
                                            thisVal += '/';
                                            $(event.target).val(thisVal);
                                          }
                                        }
                                      })
                                    });
                                    </script>
                                    <div class="col-md-6 form-group{{ $errors->has('csv') ? ' has-error' : '' }}">
                                      <label for="csv" >Card Security Code <span class="required">*</span></label>
                                      <input minlength="3" maxlength="4" placeholder="CSV" id="csv" type="text" class="form-control" name="csv" value="{{ old('csv') }}">
                                      <div class="help-block with-errors"></div>
                                      @if ($errors->has('csv'))
                                      <span class="help-block">
                                        <strong>{{ $errors->first('csv') }}</strong>
                                      </span>
                                      @endif
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12 form-group">
                                      <div class="checkbox">
                                        <label>
                                          <input type="checkbox" id="saveCard" name="save_card" value="{{ old('save_card') }}" {{ (old('save_card') == 1) ? 'checked':'' }}>
                                          <b>Securely Save to Account?</b>
                                        </label>
                                        <div class="help-block with-errors"></div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row" id="primaryCardDiv">
                                    <div class="col-md-12 form-group">
                                      <div class="checkbox">
                                        <label>
                                          <input type="checkbox" id="primaryCard" name="primary_card" value="{{ old('primary_card') }}" {{ (old('primary_card') == 1) ? 'checked':'' }}>
                                          <b>Is this a primary card?</b>
                                        </label>
                                        <div class="help-block with-errors"></div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- <div class="panel panel-default">
                            <div class="panel-heading panel-color">
                            <h4 class=panel-title>
                            <label for='r12' style='width: 100%;'>
                            <input type='radio' id='r12' name='occupation' value='Not-Working' data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" />&nbsp; PayPal
                            <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png" alt="PayPal">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"></a>
                          </label>
                        </h4>
                      </div>
                    </div> -->


                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-9 form-group">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="terms" name="terms" required>
                      <b class="terms-conditions">I’ve read and accept the <a href="{{url('/conditions')}}" target="_self" itemprop="url" class="link-button-style" role="button">terms & conditions </b><span class="required">*</span>
                    </label>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
                <!-- <div class="col-md-3 form-group text-right">
                <button type="submit" class="btn btn-default button-style white-color">Place order</button>
              </div> -->
            </div>
          </div>
          <div class="col-md-4"></div>
        </div>
        <div class="row">
          <div class="col-md-6 form-group text-left responsive-text-center">
            <a type="button" class="btn btn-default button-style white-color btnNext" href="{{ url('cart') }}" onclick='clearLocalStorage();'>Go to Cart</a>
            <button type="button" class="btn btn-default button-style white-color btnPrevious">Previous</button>
          </div>
          <div class="col-md-6 form-group text-right responsive-text-center">
            <button type="submit" class="btn btn-default button-style white-color" id="placeOrder">Place order</button>
          </div>
        </div>
      </div>
      <!-- END -->

    </div>
  </div>
</div>
</form>
</div>
<div class="col-md-2"></div>
</div>
</div>
</div>
<script>
$( document ).ready(function() {
  $( "input[type='checkbox']" ).click(function(){
    $(this).val(this.checked ? 1 : 0);
  });
  var oldShippingAddress = '{{old("shipping_address_id")}}';
  if(null != oldShippingAddress && '' != oldShippingAddress){
    $( "input[name='shipping_address_id']" ).prop( "checked", false);
    $('#shippingAddress'+oldShippingAddress).prop("checked", true);
  }
  var oldBillingAddress = '{{old("billing_address_id")}}';
  if(null != oldBillingAddress && '' != oldBillingAddress){
    $( "input[name=billing_address_id]" ).prop( "checked", false);
    $('#billingAddress'+oldBillingAddress).prop("checked", true);
  }
  if($('#saveCard').val() == 1){
    $('#primaryCardDiv').show();
    if($('#primaryCard').val()==1){
      $('#checkoutForm').append('<input type="hidden" id="saveCardPrimart" name="save_card_primary" value="1" />');
    }else{
      $('#checkoutForm').append('<input type="hidden" id="saveCardPrimart" name="save_card_primary" value="0" />');
    }
    $('#checkoutForm').append('<input type="hidden" id="saveThisCard" name="save_this_card" value="1" />');
  }else{
    $('#primaryCardDiv').hide();
    $('#checkoutForm').append('<input type="hidden" id="saveThisCard" name="save_this_card" value="0" />');
  }
  var form = document.getElementById('checkoutForm');
  var cardexist = $('#cardExist').val();
  if(!cardexist){
    $('#paymentDiv').show();
    $('#checkoutForm').append('<input type="hidden" id="newCardUpdate" name="new-card-update" value="1" />');
    addPaymentValidation();
  }else if ($('#newCard').val() == 1) {
    $('#paymentDiv').show();
    $('#checkoutForm').append('<input type="hidden" id="newCardUpdate" name="new-card-update" value="1" />');
    addPaymentValidation();
  }else{
    $('#paymentDiv').hide();
    $('#checkoutForm').append('<input type="hidden" id="saveThisCard" name="save_this_card" value="0" />');
    removePaymentValidation();
  }
  $('input[type=radio][name=checkout_card]').change(function() {
    if (this.checked) {
      $( "input[name='enter-new-card']" ).prop( "checked", false);
      $('#checkoutForm').append('<input type="hidden" id="newCardUpdate" name="new-card-update" value="0" />');
      $('#paymentDiv').hide();
      removePaymentValidation();
    }
  });
  $('input[type=checkbox][name="enter-new-card"]').change(function() {
    if (this.checked) {
      $( "input[name='checkout_card']" ).prop( "checked", false );
      $('#checkoutForm').append('<input type="hidden" id="newCardUpdate" name="new-card-update" value="1" />');
      // console.log("cardexist",cardexist);
      $('#paymentDiv').show();
      addPaymentValidation();
    }else{
      $('#checkoutForm').append('<input type="hidden" id="newCardUpdate" name="new-card-update" value="0" />');
      // console.log("cardexist",cardexist);
      $('#paymentDiv').hide();
      removePaymentValidation();
    }
  });
  $('#terms').click(function(){
    if (this.checked) {
      $('#checkoutForm').append('<input type="hidden" id="termsConditions" name="terms_conditions" value="1" />');
    }else{
      $('#checkoutForm').append('<input type="hidden" id="termsConditions" name="terms_conditions" value="0" />');
    }
  });

  $('#saveCard').click(function() {
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('id', 'saveThisCard');
    hiddenInput.setAttribute('name', 'save_this_card');
    if ($(this).is(':checked'))
    {
      hiddenInput.setAttribute('value', '1');
      $('#primaryCardDiv').show();
      // $('#checkoutForm').append('<input type="hidden" id="saveThisCard" name="save_this_card" value="1" />');
    }else{
      hiddenInput.setAttribute('value', '0');
      $('#primaryCardDiv').hide();
      $( "input[id='primaryCard']" ).prop( "checked", false );
      $('#checkoutForm').append('<input type="hidden" id="saveCardPrimart" name="save_card_primary" value="0" />');
      // $('#checkoutForm').append('<input type="hidden" id="saveThisCard" name="save_this_card" value="0" />');
    }
    form.appendChild(hiddenInput);
  });

  $('#primaryCard').click(function() {
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('id', 'saveCardPrimart');
    hiddenInput.setAttribute('name', 'save_card_primary');
    if ($(this).is(':checked'))
    {
      hiddenInput.setAttribute('value', '1');
    }else{
      hiddenInput.setAttribute('value', '0');
    }
    form.appendChild(hiddenInput);
  });
  var countAddress = '{{count($address["billing"])}}';
  if(countAddress!=0){
    if($("input:radio[name='shipping_address_id']").is(":checked") && $("input:radio[name='billing_address_id']").is(":checked")) {
      enableTab();
    }else{
      disabledTab();
    }
  }else {
    disabledTab();
  }
  $('input[type=radio][name=shipping_address_id]').change(function() {
    if($("input:radio[name='shipping_address_id']").is(":checked") && $("input:radio[name='billing_address_id']").is(":checked")) {
      enableTab();
    }else{
      disabledTab();
    }
  });
  $('input[type=radio][name=billing_address_id]').change(function() {
    if($("input:radio[name='shipping_address_id']").is(":checked") && $("input:radio[name='billing_address_id']").is(":checked")) {
      enableTab();
    }else{
      disabledTab();
    }
  });
});
function disabledTab(){
  $("#addressNextBtn").attr("disabled", true);
  $('#placeOrder').attr("disabled", true);
  $('#membershipTab').addClass('disabled').css('pointer-events', 'none');
  $('#paymentTab').addClass('disabled').css('pointer-events', 'none');
}
function enableTab(){
  $('#addressNextBtn').attr("disabled", false);
  $('#placeOrder').attr("disabled", false);
  $('#membershipTab').removeClass('disabled').css('pointer-events', 'all');
  $('#paymentTab').removeClass('disabled').css('pointer-events', 'all');
}

function addPaymentValidation(){
  $('#cardName').attr('required', true);
  $('#card_number').attr('required', true);
  $('#expiration').attr('required', true);
  $('#csv').attr('required', true);
  $('input[type=radio][name="checkout_card"]').attr('required', false);
}
function removePaymentValidation(){
  $('#cardName').attr('required', false);
  $('#card_number').attr('required', false);
  $('#expiration').attr('required', false);
  $('#csv').attr('required', false);
  $('input[type=radio][name="checkout_card"]').attr('required', true);
}
function clearLocalStorage(){
  localStorage.removeItem('activeTab');
}
function GetCardType(number){
    // visa
    var re = new RegExp("^4");
    if (number.match(re) != null){
    $('#checkoutForm').append('<input type="hidden" id="CardType" name="card_type" value="Visa" />');
       // return "Visa";
    }
    // Mastercard
    // Updated for Mastercard 2017 BINs expansion
     if (/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/.test(number)){
      $('#checkoutForm').append('<input type="hidden" id="CardType" name="card_type" value="Mastercard" />');
        //return "Mastercard";
     }
//
    // AMEX
    re = new RegExp("^3[47]");
    if (number.match(re) != null){
    $('#checkoutForm').append('<input type="hidden" id="CardType" name="card_type" value="American Express" />');
       // return "AMEX";
    }
    // Discover
    re = new RegExp("^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)");
    if (number.match(re) != null){
    $('#checkoutForm').append('<input type="hidden" id="CardType" name="card_type" value="Discover" />');
    }
       // return "Discover";

    // Diners
    re = new RegExp("^36");
    if (number.match(re) != null){
    $('#checkoutForm').append('<input type="hidden" id="CardType" name="card_type" value="Diners Club" />');
        //return "Diners";
    }
    // JCB
    re = new RegExp("^35(2[89]|[3-8][0-9])");
    if (number.match(re) != null){
     $('#checkoutForm').append('<input type="hidden" id="CardType" name="card_type" value="JCB" />');
       // return "JCB";
    }
    // Visa Electron
    re = new RegExp("^(4026|417500|4508|4844|491(3|7))");
    if (number.match(re) != null){
    $('#checkoutForm').append('<input type="hidden" id="CardType" name="card_type" value="Visa" />');
       // return "Visa Electron";
    }
    return false;
}
//setup for cc type
var typingTimer;                //timer identifier
var doneTypingInterval = 3000;  //time in ms, 5 second for example
var $input = $('#card_number');

//on keyup, start the countdown
$input.on('keyup', function () {
  clearTimeout(typingTimer);
  typingTimer = setTimeout(doneTyping, doneTypingInterval);
});

//on keydown, clear the countdown
$input.on('keydown', function () {
  clearTimeout(typingTimer);
});

//user is "finished typing," do something
function doneTyping () {
  console.log($input.val());
  this.GetCardType($input.val());
}
</script>
@endsection
