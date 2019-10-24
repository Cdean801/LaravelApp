@extends('welcome')
@section('title')
Product List - Frelii
@endsection
<!-- SlidesJS Required: -->
@section('content')
@if(Auth::user())
@endif
<!-- Header -->
<!-- /.header -->
<!-- Main Content -->
<link href="{{ asset('css/front/product/list.css') }}" rel="stylesheet">
<link href="{{ asset('css/front/health_genomics/genomics.css') }}" rel="stylesheet">
<div class="top-margin main-content">
  <div class="section section-div">
    <div class="row" id="genomics">
      <div class="row image-div">
        <div class="centered col">
          <div class="row text-center section-centered-div">
            <p class="section-special-discount">Special Discounts</p>
            <p class="section-health-collection"><strong>Health Collection </strong><span class="section-health-year">2018</span></p>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="container"> -->
    <div class="row product-list-row">
      <div class="col-md-1 col-xl-1">
      </div>
      <div class="col-md-9 col-xl-9">
        <div class="row">
          <div class="col-md-12">
            <h1>Products</h1>
            <hr>
          </div>
        </div>
        <div class="row">
          <div class="col-md-10">
            <input id="filter" type="hidden" class="form-control" name="filter" value="{{ $filter }}">
            <h2>Search Results: "{{$filter}}"</h2>
          </div>
          <div class="col-md-1 col-xl-1 text-right" style="padding-top:20px;">
            <!-- <div class="row" style="padding-top:15px;"> -->
            <a class="btn btn-primary text-uppercase go-back-btn" href="{{ route('product.paginate') }}">Clear Search</a>
            <!-- </div> -->
          </div>
        </div>
        <div id="productData">
          <div class="row">
            @include('flash::message')
            <div class="col-md-12">
              @foreach($products as $prod)
              <div class="col-md-4 text-center">
                <div class="card">
                  <div style="padding-top:50px;">
                    @if(null!=$prod['image'] && ''!=$prod['image'])
                    <a href="{{route('product_discription',['id'=> $prod['id'] ])}}">
                      <img  src="{{config('production_env.s3_bucket_product_image_url')}}{{$prod['image']}}" name="image-preview" onerror="defaultImage(this);" class="product-img-style">
                    </a>
                    @else
                    <a href="{{route('product_discription',['id'=> $prod['id'] ])}}"><img src="/image_placeholder.png" name="image-preview" class="product-img-style"></a>
                    @endif
                  </div>
                  <div class="p-6 text-center">
                    <p class="product-name-style" id="productName">
                      <a href="{{route('product_discription',['id'=> $prod['id'] ])}}" class="font-style-for-prod-name" style="word-break: break-all;">{{$prod['name']}}</a>
                    </p>
                    <p class="product-price">$ {{$prod['price']}}</p>
                    <button type="button" value="{{$prod['id']}}" class="btn btn-round add-to-cart-button onSelectProduct">
                      <span class="glyphicon glyphicon-shopping-cart"></span>
                      Add to Cart
                    </button>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          <div class="row text-center" style="padding-top:50px;">
            {{$products->appends(['filter' => $filter])->links()}}
          </div>
          @if($products->total()==0)
          <div class="row text-center" style="padding: 20%;">
            <h1>No Product Found</h1>
          </div>
          @endif
        </div>
      </div>
    </div>
    <!-- </div> -->
  </div>
</div>
<script>
function defaultImage(img)
{
  img.src = "{{url('/img/food.png')}}";
}
var images = [
  "https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2017/10/23033630/girlonrock.jpg",
  "https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2016/07/23034027/newworkout.jpg",
]

var imageHead = document.getElementById("genomics");
var i = 0;

setInterval(function() {
  imageHead.style.backgroundImage = "url(" + images[i] + ")";
  i = i + 1;
  if (i == images.length) {
    i =  0;
  }
}, 2500);

$("#productData").on("click",".onSelectProduct", function() {
  var id = $(this).val();
  data = {_token: "{{csrf_token()}}"};
  $.ajax({
    type: "post",
    url: "/add_to_cart/" + id,
    dataType: "json",
    data:data,
    success: function (response) {
      if(response['status'] == 200) {
        window.location.reload();
      } else {
        window.location.reload();
      }
      $([document.documentElement, document.body]).animate({
        scrollTop: $(".main-content").offset().top
      }, 50);
    }
  });
});
</script>
@endsection
