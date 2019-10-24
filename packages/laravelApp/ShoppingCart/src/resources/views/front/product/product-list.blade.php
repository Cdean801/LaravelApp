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
          <div class="row text-center">
            <div class="description-top-margin">
            <p class="section-special-discount">Special Discounts</p>
            <p class="section-health-collection"><strong>Health Collection </strong><span class="section-health-year">2019</span></p>
          </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="container"> -->
    <div class="row product-list-row">
      <div class="col-md-1 col-xl-1"></div>
      <div class="col-md-2 col-xl-2" id="filterDiv">
        <form method="get" action="{{ route('product.paginate.search') }}" id="filterForm" name="filterForm" data-toggle="validator">
          <div class="row">
            <div class="col-md-12 form-group{{ $errors->has('filter') ? ' has-error' : '' }}">
              <label for="filter"><h4 class="filter-heading">Search Products</h4></label>
              <input id="filter" type="text" class="form-control" name="filter" placeholder="Search Products..." required maxlength="255">
              @if ($errors->has('filter'))
              <span class="help-block">
                <strong class="validation-message">{{ $errors->first('filter') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <button type="submit" class="btn btn-search" id="search-submit">Search</button>
            </div>
          </div>
        </form>
        <div class="row filter-div-padding">
          <div class="row">
            <div class="col-md-12">
              <h4 class="filter-heading">Product Categories</h4>
            </div>
          </div>
          @if(count($category)>0)
          <div class="row" style="padding-top:20px;">
            <div class="col-md-12">
              <table>
                @foreach($category as $key=>$cat)
                <tr><a href="{{route('product.paginate', ['catFilter' => $cat->id,'priceFilter'=>$priceFilter,'tagFilter'=>$tagFilter])}}" class="category-tag">{{$cat->name}}</a>
                  @if(($key+1)!=count($category))
                  <hr>
                  @endif
                </tr>
                @endforeach
              </table>
            </div>
          </div>
          @else
          <div class="row" style="padding-top:20px;">
            <div class="col-md-12">
              No Category Found
            </div>
          </div>
          @endif
        </div>
        <div class="row filter-div-padding">
          <div class="row">
            <div class="col-md-12">
              <form class="" method="GET" action="{{ route('product.paginate') }}" id="filterPriceForm" name="filterPriceForm" data-toggle="validator">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="priceFilter"><h4 class="filter-heading">Filter By Price</h4></label>
                      <div class="price-display-div">Price: <span id="demo"></span></div>
                      <input id="ex12c" type="text" name="priceFilter" class="form-control"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12">
                    <button  type="submit" class="btn btn-primary filter-price-btn" id="filterPriceSsubmit" >Filter</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
        <div class="row filter-div-padding">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <b>Product Tags</b>
              </div>
            </div>
            @if(count($productTags)>0)
            <div class="row filter-tag-value">
              <div class="col-md-12">
                @foreach($productTags as $key=>$tag)
                @if(null!=$tag && ''!=$tag)
                <a href="{{route('product.paginate', ['tagFilter' =>$tag,'catFilter' => $catFilter,'priceFilter'=>$priceFilter])}}" class="tagcloud">{{$tag}}</a>
                @endif
                @endforeach
              </div>
            </div>
            @else
            <div class="row" style="padding-top:20px;">
              <div class="col-md-12">
                No Tags Found
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
      <div class="col-md-8 col-xl-8">
        <div class="row">
          <div class="col-md-12">
            <h1 style="color:var(--frelii-color) !important;">Products</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-11" style="display:inline-flex;">
            <p id="showCatFilterData" style="padding-right:5px"></p>
            <p id="showTagFilterData" style="padding-right:5px"></p>
            <p id="showPriceFilterData" style="padding-right:5px"></p>
          </div>
        </div>
        <hr>

        <div id="productData">
          <div class="row">
            @include('flash::message')
            <div class="col-md-12">
              @foreach($products as $prod)
              <div class="col-md-4 text-center">
                <div class="card">
                  <div class="product-card-div">


                    @if(null!=$prod['image'] && ''!=$prod['image'])
                    <a href="{{route('product_discription',['id'=> $prod['id'] ])}}">
                      <img  src="{{$prod['image']}}" name="image-preview" onerror="" class="product-img-style">
                    </a>
                    @else
                    <a href="{{route('product_discription',['id'=> $prod['id'] ])}}"><img src="/image_placeholder.png" name="image-preview" class="product-img-style"></a>
                    @endif
                  </div>
                  <div class="p-6 text-center">
                    <p class="product-name-style" id="productName">
                      <a href="{{route('product_discription',['id'=> $prod['id'] ])}}" class="font-style-for-prod-name prod-word-break">{{$prod['name']}}</a>
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
          <div class="row text-center pagination-link pagination-link">
            {{$products->appends(['catFilter'=>$catFilter,'tagFilter'=>$tagFilter,'priceFilter'=>$priceFilter])->links()}}
          </div>
          @if($products->total()==0)
          <div class="row text-center no-pro">
            <h1>No Product Found</h1>
            @if($countPro != 0)
            <a class="btn btn-primary text-uppercase go-back-btn" href="{{ route('product.paginate') }}">Clear Search</a>
            @endif
          </div>
          @endif
        </div>
      </div>
    </div>
    <!-- </div> -->
  </div>
</div>
<script>
$(document).ready(function()  {
  var countPro = '{{$countPro}}';
  if(countPro==0){
    $("input").attr('disabled','disabled');
    $("#filterPriceSsubmit").attr('disabled','disabled');
    $(".tagcloud").addClass('disabled');
    $(".category-tag ").addClass('disabled');
  }else{
    $("input").removeAttr('disabled');
    $("#filterPriceSsubmit").removeAttr('disabled');
    $(".tagcloud").removeClass('disabled');
    $(".category-tag").removeClass('disabled');
  }
  var sliderC = new Slider("#ex12c", { id: "slider12c", min: 0, max:500,range: true });
  var price = '{{$priceFilter}}';
  if(price!=null && price!=''){

    var filter = '{{$priceFilter}}';
    var filterVal=filter.split(",");
    var result = filterVal.map(function (x) {
      return parseInt(x, 10);
    });
    sliderC.setValue(result);
    $('#showPriceFilterData').html("<b>Price Range: </b>" + '$'+result[0]+" - "+'$'+result[1]);
  }else{
    var priceRange = '{{$priceFilterRange}}';
    if(priceRange!=null && priceRange!=''){
      var filter = '{{$priceFilterRange}}';
      var filterVal=filter.split(",");
      var result = filterVal.map(function (x) {
        return parseInt(x, 10);
      });
      sliderC.setValue(result);
    }
  }
  var value = sliderC.getValue();
  var output = document.getElementById("demo");
  output.innerHTML = '<span style="color:#686c6e">$'+value[0]+' - $'+value[1]+'</span>';
  sliderC.on("slide", function(sliderValue) {
    value = sliderValue;
    output.innerHTML = '<span style="color:#686c6e">$'+value[0]+' - $'+value[1]+'</span>';
  });
  var cat = '{{$catFilter}}';
  var catName = '{{$catName}}';
  if(cat!=null && cat != '' && ''!=catName && null !=catName){
    $('#showCatFilterData').html("<b>Catagory: </b>{{$catName}}");
  }
  var tag = '{{$tagFilter}}';
  if(tag!=null && tag != ''){
    $('#showTagFilterData').html("<b>Tag: </b>{{$tagFilter}}");
  }
  var form = document.getElementById("filterPriceForm");
  $('#filterPriceSsubmit').on('click', function(e) {
    e.preventDefault();
    if(cat!=null && cat != ''){
      $('#filterPriceForm').append('<input type="hidden" name="catFilter" value="{{$catFilter}}" />');
    }else{
      $('#filterPriceForm').append('<input type="hidden" name="catFilter" value="" />');
    }
    if(tag!=null && tag != ''){
      $('#filterPriceForm').append('<input type="hidden" name="tagFilter" value="{{$tagFilter}}" />');
    }else{
      $('#filterPriceForm').append('<input type="hidden" name="tagFilter" value="" />');
    }
    form.submit();
  });
  var searchForm  = document.getElementById("filterForm");
  $('#search-submit').on('click', function(e) {
    e.preventDefault();
    var filterText = $('#filter').val();

    if(cat!=null && cat != ''){
      $('#filterForm').append('<input type="hidden" name="catFilter" value="{{$catFilter}}" />');
    }else{
      $('#filterForm').append('<input type="hidden" name="catFilter" value="" />');
    }
    if(tag!=null && tag != ''){
      $('#filterForm').append('<input type="hidden" name="tagFilter" value="{{$tagFilter}}" />');
    }else{
      $('#filterForm').append('<input type="hidden" name="tagFilter" value="" />');
    }
    if(price!=null && price != ''){
      $('#filterForm').append('<input type="hidden" name="priceFilter" value="{{$priceFilter}}" />');
    }else{
      $('#filterForm').append('<input type="hidden" name="priceFilter" value="" />');
    }
    if(filterText!=null && filterText != ''){
      searchForm.submit();
    }

  });

});
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
