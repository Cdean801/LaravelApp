@extends('welcome')
@section('title')
View Products - Frelii
@endsection


@section('content')
@if(Auth::user())
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.1.3/circle-progress.min.js"></script>

<link href="{{ asset('css/front/health_genomics/genomics.css') }}" rel="stylesheet">
<link href="{{ asset('css/front/product/description.css') }}" rel="stylesheet">

<div class="top-margin">
  <div class="section description-padding">
    <div class="row">
      <div class="row" id="prod">
        <div class="row image-div">
          <div class="centered col">
            <div class="row text-center description-top-margin">
              <p class="description-font">Special Discounts</p>
              <p class="health-font"><strong>Health Collection </strong><span class="description-color">2018</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row product-top-margin">
      <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6 flash-top-margin">
        @include('flash::message')
      </div>
      <div class="col-md-3"></div>
      </div>
      <div class="col-md-3"></div>
      <div class="col-md-2 responsive-img">
        @if(null!=$product['image'] && ''!=$product['image'])
        <a href="#">
          <img  src="{{$product['image']}}" class="img-width" name="image-preview" onerror="">
        </a>
        @else
        <a href="#"><img src="/image_placeholder.png" name="image-preview" class="img-width"></a>
        @endif
      </div>
      <div class="col-md-4 responsive-product">
        <h1 class="product_title entry-title">{{$product['name']}}</h1>
        <p class="product-price-font"><span class="woocommerce-Price-amount amount"><span class="description-green-color">$</span>{{$product['price']}}</span></p>
        <div>
          <p>{{$product['description']}}</p>
        </div>
        <div class="sku-top-margin">
          <form method="POST" action="{{route('add_to.cart_input',['id'=> $product['id'] ])}}" enctype="multipart/form-data" data-toggle="validator">
            {{ csrf_field() }}
          <div class="row">
          <div class="quantity form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
            <input type="number" class="form-control m-input center-block input-style" data-toggle="tooltip" title="Use digit more than 0." data-placement="" id="quantity" class="qty " step="1" min="1" max="" name="quantity" value="1" size="4" pattern="[0-9]*" inputmode="numeric" required onblur="validateName()">
            <!-- <div class="help-block with-errors" id="quantity1"></div> -->
          </div>
          <div class="cart-btn">
          <button type="submit" class="btn-color btn btn-round add-to-cart-button">
            <span class="glyphicon glyphicon-shopping-cart"></span>
            Add to Cart
          </button>
        </div>
        <div class="help-block with-errors" id="quantity1"></div>
        @if ($errors->has('quantity'))
        <span class="help-block">
          <strong class="validation-message">{{ $errors->first('quantity') }}</strong>
        </span>
        @endif
      </div>
        </form>
        </div>
        <div class="sku-top-margin">
          <span class="sku-color">SKU: <span class="sku-color">{{$product['sku']}}</span></span><br>
          <span class="posted_in sku-color">CATEGORIES:
            @if($category)
            <a class="sku-color" href="#" rel="tag">{{$category['name']}}</a>
            @endif
          </span><br>
        </div>
      </div>
      <div class="col-md-3">
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')

<script type="text/javascript">
function defaultImage(img)
{
  img.src = "{{url('/img/food.png')}}";
}
var images = [
  "https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2017/10/23033630/girlonrock.jpg",
  "https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2016/07/23034027/newworkout.jpg",
]

var imageHead = document.getElementById("prod");
var i = 0;

setInterval(function() {
  imageHead.style.backgroundImage = "url(" + images[i] + ")";
  i = i + 1;
  if (i == images.length) {
    i =  0;
  }
}, 5000);

function validateName(){
  var quantity = $("#quantity").val();
  var elem = document.getElementById("quantity");
  var pattern = elem.getAttribute("pattern");
  var re = new RegExp(pattern);

  var regex = /^[0-9]*$/;
    if(regex.test(quantity) == false){
      $("#quantity1").html("");
        $( "#quantity1" ).append('<ul class="list-unstyled" style="color:red;"><li>' + 'Enter valid quantity.'+'</li></ul>');
        return false;
    }
    if(quantity==0){
      $("#quantity1").html("");
        $( "#quantity1" ).append('<ul class="list-unstyled" style="color:red;"><li>' + 'Quantity must be more than 0.'+'</li></ul>');
        return false;
    }
    if(quantity==null || quantity==""){
      $("#quantity1").html("");
        $( "#quantity1" ).append('<ul class="list-unstyled" style="color:red;"><li>' + 'Field is required.'+'</li></ul>');
        return false;
    }

    $("#quantity1").html("");
}
</script>

@endpush
