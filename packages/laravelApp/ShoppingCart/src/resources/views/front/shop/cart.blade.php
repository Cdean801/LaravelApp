@extends('welcome')
@section('title')
SaneCart - Cart
@endsection
@section('content')
@if (Auth::user())
@include('../front/partials/sidenav')
@endif
<link href="{{ asset('css/front/shop/cart.css') }}" rel="stylesheet">
<div class="container" id="main-content">
  <div class="section">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <h1 class="cart-heading-color">Cart</h1>
      @include('flash::message')
      <form class="gap-y" data-toggle="validator" method="GET" action="/checkout" id="cart_from">
        <div class="order-summary clearfix">
          <!-- <div class="section-title">
          <h3 class="title">Your Cart</h3>
        </div> -->
        <div class="table-responsive">
          <table class="shopping-cart-table table">
            <thead>
              <tr>
                <th class="text-center"></th>
                <th></th>
                <th><b>Product</b></th>
                <th class="text-center"><b>Price</b></th>
                <th class="text-center"><b>Quantity</b></th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $product)
              @php
              $p = $product['item']
              @endphp
              <tr>
                <td class="text-center align-middle">
                  <a class="item-remove" href="{{ route('remove_from.cart', ['id' => $p->id])}}">
                    <!-- <button class="main-btn icon-btn" style="border:none !important"> -->
                    <i class="fa fa-close remove-button-style"></i>
                    <!-- </button> -->
                  </a>
                </td>
                @if ($p->image != '' && $p->image != null)
                <td class="align-middle"><img src="{{config('production_env.s3_bucket_product_image_url')}}{{$p->image}}" width="80px" height="80px" onerror="defaultImage(this);"></td>
                @else
                <td class="align-middle"><img src={!! '/image_placeholder.png'!!} width="80px" height="80px"></td>
                @endif
                <td class="text-left align-middle">
                  <a href="#" class="product-name-style">{{$product['item']['name']}}</a>
                </td>
                <td class="price text-center align-middle price-primary-color">
                  ${{$product['item_price']}}
                  <br>
                  <!-- <small>Tax: {{$product['item']['tax']}}%</small> -->
                </td>
                <td class="qty text-center align-middle">
                  <!-- <a href="/minus-from-cart/{{$product['item']['id']}}"><button class="main-btn icon-btn"><i class="fa fa-minus"></i></button></a> &nbsp <strong>{{$product['qty']}}</strong>&nbsp  &nbsp<a href="/add-to-cart/{{$product['item']['id']}}"><button class="main-btn icon-btn"><i class="fa fa-plus"></i></button></a> -->
                  <select class="form-control-sm qty-dropdown-style hidden-qty-dropdown" name="qtyDropdown{{$product['item']['id']}}" id="dropdownQty{{$product['item']['id']}}" onchange="selectedQuantity({{$product['item']['id']}})">
                    <option value="1" {{ $product['qty'] == '1' ? 'selected="selected"' : '' }}>1</option>
                    <option value="2" {{ $product['qty'] == '2' ? 'selected="selected"' : '' }}>2</option>
                    <option value="3" {{ $product['qty'] == '3' ? 'selected="selected"' : '' }}>3</option>
                    <option value="4" {{ $product['qty'] == '4' ? 'selected="selected"' : '' }}>4</option>
                    <option value="5" {{ $product['qty'] == '5' ? 'selected="selected"' : '' }}>5</option>
                    <option value="6" {{ $product['qty'] == '6' ? 'selected="selected"' : '' }}>6</option>
                    <option value="7" {{ $product['qty'] == '7' ? 'selected="selected"' : '' }}>7</option>
                    <option value="8" {{ $product['qty'] == '8' ? 'selected="selected"' : '' }}>8</option>
                    <option value="9" {{ $product['qty'] == '9' ? 'selected="selected"' : '' }}>9</option>
                    <option value="10" {{ $product['qty'] == '10' ? 'selected="selected"' : '' }}>10+</option>
                  </select>
                  <div>
                    <div class="row responsive-textbox" style="text-align: center;">
                      <div class="col-md-4 qty-textbox-div" ></div>
                      <div class="col-md-4 qty-textbox-div">
                        <input class="form-control form-control-md hidden-class qty-textbox-style responsive-qtybox" name="qtybox{{$product['item']['id']}}" id="boxQty{{$product['item']['id']}}" value="{{$product['qty']}}" min="1" max="99999" onkeyup="validateQty({{$product['item']['id']}})" maxlength="5" type="number" pattern="[0-9]*" inputmode="numeric">
                      </div>
                      <div class="col-md-4 qty-textbox-div"></div>
                    </div>
                    <!-- <div class="row responsive-textbox" style="text-align: center;" id="qtyError{{$product['item']['id']}}"></div> -->
                    <div style="text-align: center;padding-top: 5px;">
                      <button class="btn btn-xs btn-primary hidden-update-button" type="button" name="updateQty{{$product['item']['id']}}" id="qtyUpdate{{$product['item']['id']}}" onclick="updateQuantity({{$product['item']['id']}})">update</button>
                    </div>
                  </div>
                </td>
                <td class="align-middle price-primary-color">
                  ${{number_format($product['item_price'] * $product['qty'],2)}}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-md-7"></div>
          <div class="col-md-5">
            <h4>Cart Totals</h4>
            <table class="shopping-cart-table table" style="border:1px solid black;border-collapse: unset;">
              <tbody>
                <tr>
                  <th>Subtotal</th>
                  <td class="sub-total price-primary-color">${{ number_format($total_price, 2) }}</td>
                  <td colspan="5" class="empty"></td>
                </tr>
                <tr>
                  <th class="order-total">Total</th>
                  <td class="total price-primary-color"><b>${{ number_format($total_price + $tax, 2) }}</b></td>
                  <td colspan="5" class="empty"></td>
                </tr>
              </tbody>
            </table>
            <button class="btn btn-block white-color" type="submit" id="proceed-button" onclick="clearLocalStorage();">Proceed to Checkout</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-2"></div>
</div>
</div>
<script>
$(document).ready(function() {

  var alterClass = function() {
    var ww = document.body.clientWidth;
    if (ww < 1400) {
      $('.qty-textbox-div').removeClass('col-md-4');
    } else if (ww >= 1400) {
      $('.qty-textbox-div').addClass('col-md-4');
    };
  };
  $(window).resize(function(){
    alterClass();
  });
  alterClass();
  var count = '{{count($products)}}';
  $(".hidden-update-button").hide();
  <?php foreach ($products as $key => $value):if($value['qty'] > 9){ ?>
    $('select[name="qtyDropdown{{$value['item']['id']}}"]').hide();
    $('input[name="qtybox{{$value['item']['id']}}"]').show();
    $('button[id="qtyUpdate{{$value['item']['id']}}"]').show();
    <?php }else{ ?>
      $('select[name="qtyDropdown{{$value['item']['id']}}"]').show();
      $('input[name="qtybox{{$value['item']['id']}}"]').hide();
      <?php } endforeach; ?>
    });

    function selectedQuantity(id){
      var quantity = $('#dropdownQty'+id).val();
      if(quantity < 10){
        data = {quantity:quantity, _token: "{{csrf_token()}}"};
        $.ajax({
          type: "post",
          url: "/add_to_cart_input_ajax/" + id,
          dataType: "json",
          data:data,
          success: function (response) {
            if(response['status'] == 200) {
              window.location.reload();
              window.location.hash = '#main-content';
            } else {
              window.location.reload();
              window.location.hash = '#main-content';
            }
          }
        });
      }else{
        $('#dropdownQty'+id).hide();
        $('#boxQty'+id).show();
        $('#boxQty'+id).focus();
        $('#qtyUpdate'+id).show();
      }
    }
    function validateQty(pId){
      var qty = document.getElementById('boxQty'+pId).value;
      if(qty != null && qty != '' && qty != undefined){
        if(qty < 1){
          $('#qtyError'+pId).html('');
          $('#qtyError'+pId).append( '<span><strong>' + 'Quantity must be at least 1.' + '</strong></span>');
          $('#qtyUpdate'+pId).hide();
          $('#proceed-button').attr("disabled","disabled");
          return false;
        }else if (qty > 9999) {
          $('#qtyError'+pId).html('');
          $('#qtyError'+pId).append( '<span><strong>' + 'Quantity may not be greater than 9999.' + '</strong></span>');
          $('#qtyUpdate'+pId).hide();
          $('#proceed-button').attr("disabled","disabled");
          return false;
        } else{
          $('#qtyError'+pId).html('');
          $('#qtyUpdate'+pId).show();
          $('#proceed-button').removeAttr("disabled");
          return true;
        }
      }else{
        $('#qtyError'+pId).html('');
        $('#qtyError'+pId).append( '<span><strong>' + 'Please fill in this field.' + '</strong></span>');
        $('#qtyUpdate'+pId).hide();
        $('#proceed-button').attr("disabled","disabled");
        return false;
      }
    }
    function updateQuantity(productId){
      var validate = validateQty(productId);
      if(validate == true){
        data = {quantity:$('#boxQty'+productId).val(), _token: "{{csrf_token()}}"};
        $.ajax({
          type: "post",
          url: "/add_to_cart_input_ajax/" + productId,
          dataType: "json",
          data:data,
          success: function (response) {
            if(response['status'] == 200) {
              $('#boxQty'+productId).focusout();
              window.location.reload();
              window.location.hash = '#main-content';
            } else {
              $('#boxQty'+productId).focusout();
              window.location.reload();
              window.location.hash = '#main-content';
            }
          }
        });
      }
    }
    function defaultImage(img)
    {
      img.src = "{{url('/img/food.png')}}";
    }
    function clearLocalStorage(){
      localStorage.removeItem('activeTab');
    }
    function restrictMinus(e) {
      var inputKeyCode = e.keyCode ? e.keyCode : e.which;

      if (inputKeyCode != null) {
        if (inputKeyCode < 49 || inputKeyCode > 57) e.preventDefault();
      }
    }
    </script>
    @endsection
