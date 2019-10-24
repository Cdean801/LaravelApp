@extends('welcome')
@section('title')
    SaneCart - Home
@endsection
@section('content')
<!-- BEGIN: Subheader -->

<div class="container">
  <div class="order-summary clearfix">
    <div class="section-title">
      <h3 class="title">Search results for {{$search_term}}.</h3>
    </div>

<!-- END: Subheader -->
<div class="row">
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

          <h2 class="product-name"><a href="{{ route('products.show', ['id' => $product->id])}}">{{$product->brand->name}} {{$product->name}} {{$product->size}}{{$product->size_unit}}</a></h2>
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
<h3>{{ $products->links() }}</h3>

@endsection
