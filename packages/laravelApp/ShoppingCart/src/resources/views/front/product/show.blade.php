@extends('welcome')
@section('title')
    SaneCart - {{$product->name}}
@endsection

@section('content')
<div class="section">
  <!-- container -->
  <div class="container">
    <!-- row -->
    <div class="row">
      <!--  Product Details -->
      <div class="product product-details clearfix">
        <div class="col-md-6">
          <div id="product-main-view">
            @if (count($images)>1)
              @foreach ($images as $key=>$image)
                <div class="product-view">
                  <img src={!! '/storage/product_images/' . $product->id . '/' . $image->path !!}   >
                </div>
              @endforeach
            @endif
            @if (count($images)===1)
                <div class="product-view">
                  <img src={!! '/storage/product_images/' . $product->id . '/' . $images->first()->path !!} />
                </div>
            @endif
            @if (count($images)<1)
                <div class="product-view">
                  <img src={!! '/image_placeholder.png' !!} height="400" width="200" />
                </div>
            @endif

          </div>
          <div id="product-view">
            @if (count($images)>1)
              @foreach ($images as $key=>$image)
                <div class="product-view">
                  <img src={!! '/storage/product_images/' . $product->id . '/' . $image->path !!}   >
                </div>
              @endforeach
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="product-body">

            <h2 class="product-name">{{$product->name}}</h2>
            <h3 class="product-price">${{$product->sale_price}} <!-- <del class="product-old-price">${{$product->regular_price}}</del> --></h3>
            <!-- <div>
             <div class="product-rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o empty"></i>
              </div>
              <a href="#">3 Review(s) / Add Review</a>
            </div> -->
            <p><strong>Availability:</strong>
              @if($product->in_stock_quantity > 1)
                In Stock
               @else
                Out of Stock
               @endif
              </p>
            <p></p>


            <div class="product-btns">
            <a href="{{ route('add_to.cart', ['id' => $product->id])}}">
              <button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
            </a>
            </div>
          </div>
        </div>


      </div>
      <!-- /Product Details -->
    </div>
    <!-- /row -->
  </div>
  <!-- /container -->
</div>
<!-- /section -->

<!-- section -->
<div class="section">
  <!-- container -->
  <div class="container">
    <!-- row -->
    <div class="row">
      <!-- section title -->
      <div class="col-md-12">
        <div class="section-title">
          <h2 class="title">Picked For You</h2>
        </div>
      </div>
      <!-- section title -->

      @foreach ($products as $product)
        <!-- Product Single -->
        <div class="col-md-3 col-sm-6 col-xs-6">
          <div class="product product-single">
            <div class="product-thumb">
              <!-- <button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button> -->
              @if (isset($product->featured_images[0]))
                <img src={!! '/storage/product_images/' . $product->id . '/' . $product->featured_images[0]->path !!} height="250" width="250">
              @else
                <img src={!! '/image_placeholder.png'!!} height="250" width="250">
              @endif
            </div>
            <div class="product-body">
              <h3 class="product-price">${{$product->sale_price}}</h3>

              <h2 class="product-name"><a href="{{ route('products.show', ['id' => $product->id])}}">{{$product->name}}</a></h2>
              <div class="product-btns">
                <!--  <button class="main-btn icon-btn"><i class="fa fa-heart"></i></button> -->
                <!-- <button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button> -->
                <a href="{{ route('add_to.cart', ['id' => $product->id])}}">
                  <button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
                </a>
              </div>
            </div>
          </div>
        </div>
      @endforeach

    </div>
    <!-- /row -->
  </div>
  <!-- /container -->
</div>
<!-- /section -->
@endsection
@push('scripts')

@endpush
