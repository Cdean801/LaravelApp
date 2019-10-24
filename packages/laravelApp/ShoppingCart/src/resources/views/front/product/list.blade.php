@extends('welcome')
@section('title')
SaneCart - Product List
@endsection
<!-- SlidesJS Required: -->
@section('content')
<style>
.product-price {
  /* color: black !important; */
  line-height: 22px;
  font-size: 1.25em;
  color: #26a675;
  letter-spacing: 1px;
}
/* .checkbox-style {
border:2px solid #ccc;
width:300px;
height: 100px;
overflow-y: scroll;
padding: 5%;
} */
#style-3::-webkit-scrollbar-track
{
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
  border:2px solid #ccc;
  border-radius: 10px;
}

#style-3::-webkit-scrollbar
{
  width: 10px;
  background-color: #F5F5F5;
}

#style-3::-webkit-scrollbar-thumb
{
  border-radius: 10px;
  background-color: #c4c4c4 ;
  /* background-image: -webkit-gradient(linear, left bottom,left top,color-stop(0.44, rgb(122,153,217)),color-stop(0.72, rgb(73,125,189)), color-stop(0.86, rgb(28,58,148))); */
}

.spinner {
  margin: 100px auto 0;
  width: 70px;
  text-align: center;
}

.spinner > div {
  width: 18px;
  height: 18px;
  background-color: white;
  border-radius: 100%;
  display: inline-block;
  -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
  animation: sk-bouncedelay 1.4s infinite ease-in-out both;
}

.spinner .bounce1 {
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}

.spinner .bounce2 {
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
}
@-webkit-keyframes sk-bouncedelay {
  0%, 80%, 100% { -webkit-transform: scale(0) }
  40% { -webkit-transform: scale(1.0) }
}

@keyframes sk-bouncedelay {
  0%, 80%, 100% {
    -webkit-transform: scale(0);
    transform: scale(0);
    } 40% {
      -webkit-transform: scale(1.0);
      transform: scale(1.0);
    }
  }
  .checkbox-lbl {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    /* font-size: 22px; */
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }
  .scrollbar
  {
    /* margin-left: 30px; */
    float: left;
    max-height: 150px;
    /* width: 150px; */
    background: #F5F5F5;
    overflow-y: scroll;
    margin-bottom: 25px;
    padding: 15%;
  }

  .force-overflow
  {
    max-height: 150px;
  }

  /* Hide the browser's default checkbox */
  .checkbox-lbl input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
  }

  /* Create a custom checkbox */
  .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: white;
    border: 1px solid lightgrey;
  }

  /* On mouse-over, add a grey background color */
  .checkbox-lbl:hover input ~ .checkmark {
    /* background-color: #ccc; */
  }

  /* When the checkbox is checked, add a blue background */
  .checkbox-lbl input:checked ~ .checkmark {
    /* background-color: #2196F3; */
  }

  /* Create the checkmark/indicator (hidden when not checked) */
  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
    top: 50%!important;
    left: 6px!important;
    margin-top: -6px!important;
    width: 5px!important;
    height: 10px!important;
    border: solid #50a1ff!important;
    border-width: 0 1px 1px 0!important;
    -webkit-transform: scale(0) rotate(35deg);
    transform: scale(0) rotate(35deg);
  }

  /* Show the checkmark when checked */
  .checkbox-lbl input:checked ~ .checkmark:after {
    display: block;
  }

  /* Style the checkmark/indicator */
  .checkbox-lbl .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }
  .all-filter-div {
    /* background: linear-gradient(135deg, #4481eb 0%, #04befe 100%); */
    text-align: center;
    background-color:var(--common-color)
  }
  /* @media (min-width: 768px) {
  .container {
  max-width: 100% !important;
}
}
@media (min-width: 576px) {
.container {
max-width: 100% !important;
}
} */
.sidebar-title{
  margin-top: 1rem;
  color:white!important;
  font-weight: bold!important;
}
.next-button{
  text-align: center;
  background-color: var(--common-color);
  color:white;
}
.previous-button{
  text-align: center;
  background-color: var(--common-color);
  color:white;
}
/* add to cart btn */
@media (max-width: 991px) and (min-width:767px){
  .add-to-cart-btn{
    width:auto!important;
    letter-spacing: inherit!important;
    padding: 7px 9px 6px 9px!important;
  }
}
.product-name-style{

  font-size: 20px;
  line-height: 26px;
  margin: 0 0 10px;
  padding: 0;
  overflow: hidden;
  /* white-space: nowrap; */
  height: 50px;
  padding-top: 10px;
}
.black-color-style{
  color: #333333 ;
}
.black-color-style:hover{
  color: #26a675;
}
.font-style-for-prod-name {
  font-family: Assistant;
  /* font-size: 1.05469rem !important; */
  font-weight: 500 !important;
  color: #333333;
  /* line-height: 1.5 !important;
  margin-bottom: .5rem !important;
  font-family: Dosis,sans-serif !important;
  letter-spacing: 0.75px !important;
  color: #323d47; */
}
.font-style-for-prod-name:hover{
  color: #26a675;
}
.add-to-cart-button{
  background-color: #26a675;
  border: #26a675;
  color: white;
  border-radius: 0 !important;
}
.add-to-cart-button:hover{
  color: white !important;
  background-color: black !important;
}

/* add to cart btn */
</style>
<!-- Header -->
<!-- /.header -->
<!-- Main Content -->
<link href="{{ asset('css/front/product/list.css') }}" rel="stylesheet">
<main class="main-content">
  <div class="section bg-gray">
    <div class="container header">
      <div class="row image-div">
        <img src="https://s3.amazonaws.com/frelii-s3-bucket/wp-content/uploads/2017/10/23033630/girlonrock.jpg" alt="Nature" style="width:100%;height: 350px;">
        <div class="centered col">
          <div class="row" style="font-size: 5rem">CHECKOUT</div>
        </div>
      </div>
      <div class="row" style="padding-top:50px;">
        <div class="col-md-2 col-xl-2 " id="filterDiv">
        </div>
        <div class="col-md-9 col-xl-9">
          <div class="row">
            <div class="col-md-12">
              <h1>Products</h1>
              <h3>Home / bshop</h3>
              @include('flash::message')
              <hr>
            </div>
          </div>
          <div id="productData"></div>
          <div class="col-md-12" style="padding-top:40px;">
            <nav class="flexbox mt-30 buttons" id="buttons">
              <div class="row">
                <div class="col-md-3">
                  <button class="btn btn-primary" id="previous"><i class="ti-arrow-left fs-9 mr-4"></i> Previous</button>
                </div>
                <div class="col-md-8"></div>
                <div class="col-md-1">
                  <button class="btn btn-primary" id="next">Next<i class="ti-arrow-right fs-9 ml-4"></i></button>
                </div>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
count = 1;
var selectCategory = [];
$(document).ready(function()  {
  data = { page: count, limit: 9, _token: "{{csrf_token()}}"};
  $.ajax({
    type: "POST",
    url: "/getproductListData",
    dataType: "json",
    data: data,
    beforeSend:function() {
      $.blockUI({
        message:  '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>',
        css: {
          backgroundColor:'transparent',
          border:'none',
          // opacity: 1,

        }});
      },
      complete: function() {
        setTimeout(function(){
          $.unblockUI();
        }, 500);
      },
      success: function (response) {
        if(response['status'] == 200) {
          div = '';
          if (response.hasOwnProperty('products')){
            if (response['products'].length > 0){
              for (var i = 0; i < response['products'].length; i++) {
                div += '<div class="col-md-4 text-center" style="padding-top: 70px;"><div class="card border hover-shadow-6 mb-6">';
                if(null != response.products[i]['image'] && '' != response.products[i]['image']) {
                  div += '<a href="#"><img  src="{{config('production_env.s3_bucket_product_image_url')}}'+encodeURIComponent(response['products'][i]['image'])+'" name="image-preview"/ style="height:180px !important; width: auto !important"></a>';
                } else {
                  div += '<a href="#"><img src="/image_placeholder.png" name="image-preview" style="height:180px !important; width: auto !important"></a>';
                }
                div += '<div class="p-6 text-center"><p class="product-name-style" id="productName"><a href="#" class="font-style-for-prod-name">'+response['products'][i]['name']+'</a></p><p class="product-price">$'+response['products'][i]['price']+'</a></p><button type="button" value="'+response['products'][i]['id']+'" class="btn btn-round add-to-cart-button onSelectProduct"><span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart </button>';
                div += '</div></div></div>';
                document.getElementById("next").disabled = false;
              }
              if(response.nextPageData == 0) {
                document.getElementById("next").disabled = true;
              }
              if(count == 1) {
                document.getElementById("previous").disabled = true;
              }
            } else {
              document.getElementById("next").disabled = true;
              document.getElementById("productData").innerHTML = "";
              div += '<div class="col-md-12 text-center" style="padding: 20%;"><h1>No Product Found</h1></div>';
            }
          } else {
            document.getElementById("next").disabled = true;
            document.getElementById("productData").innerHTML = "";
            div += '<div class="col-md-12 text-center" style="padding: 20%;"><h1>No Product Found</h1></div>';
          }

          $(div).appendTo('#productData');

        } else {
          var div = '';
          div += '<div class="col-md-12 text-center" style="padding: 20%;"><h1>No Product Found</h1></div>';
          $(div).appendTo('#productData');
        }
      }, error: function (response) {
      }
    });
  });
  $(".buttons").on("click","#next", function() {
    count = count + 1;
    data = {limit: 9, page: count, _token: "{{csrf_token()}}"};
    document.getElementById("productData").innerHTML = "";
    $([document.documentElement, document.body]).animate({
      scrollTop: $(".header").offset().top
    }, 50);
    changrProductData(data);
  });
  $(".buttons").on("click","#previous", function() {
    if (count >= 1) {
      count = count - 1;
      if(count!=0){
        data = {limit: 9, page: count, _token: "{{csrf_token()}}"};
        document.getElementById("productData").innerHTML = "";
        $([document.documentElement, document.body]).animate({
          scrollTop: $(".header").offset().top
        }, 50);
        changrProductData(data);
      }else{
        document.getElementById("productData").innerHTML = "";
        document.getElementById("previous").disabled = true;
        var div = '';
        div += '<div class="col-md-12 text-center" style="padding: 20%;"><h1>No Product Found</h1></div>';
        $(div).appendTo('#productData');
      }
    } else {
      document.getElementById("productData").innerHTML = "";
      document.getElementById("previous").disabled = true;
      var div = '';
      div += '<div class="col-md-12 text-center" style="padding: 20%;"><h1>No Product Found</h1></div>';
      $(div).appendTo('#productData');
    }
  });
  function changrProductData(data){
    $.ajax({
      type: "post",
      url: "/getproductListData",
      dataType: "json",
      data: data,
      beforeSend:function() {
        $.blockUI({
          message:  '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>',
          css: {
            backgroundColor:'transparent',
            border:'none',
            // opacity: 1,

          }});
        },
        complete: function() {
          setTimeout(function(){
            $.unblockUI();
          }, 500);
        },
        success: function (response) {
          document.getElementById("productData").innerHTML = "";
          if(response['status'] == 200) {
            div = '';
            if (response.hasOwnProperty('products')){
              if (response['products'].length > 0){
                for (var i = 0; i < response['products'].length; i++) {
                  div += '<div class="col-md-4 text-center"style="padding-top: 70px;"><div class="card border hover-shadow-6 mb-6">';
                  var url = '{{ route("products.show", ":id") }}';
                  url = url.replace(':id',+response['products'][i]['id']);
                  if(null != response.products[i]['image'] && '' != response.products[i]['image']) {

                    // s3Url = s3Url.replace(':id',+response['products'][i]['featured_images'][0]['path']);
                    div += '<a href="'+url+'"><img src="{{config('production_env.s3_bucket_product_image_url')}}'+encodeURIComponent(response['products'][i]['image'])+'" name="image-preview"  style="height:auto !important; width: 60% !important" /></a>';
                  } else {
                    div += '<a href="'+url+'"><img src="/image_placeholder.png" name="image-preview" style="height:auto !important; width: 60% !important"></a>';
                  }
                  document.getElementById("next").disabled = false;
                  document.getElementById("previous").disabled = false;
                }
                div += '<div class="p-6 text-center"><p class="product-name-style" id="productName"><a href="'+url+'" class="font-style-for-prod-name">'+response['products'][i]['name']+'</a></p><p class="product-price">$'+response['products'][i]['price']+'</p></a><button type="button" value="'+response['products'][i]['id']+'" class="btn btn-round add-to-cart-button onSelectProduct"><span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart</button>';
                div += '</div></div></div>';
                $(div).appendTo('#productData');
                if(count == 1) {
                  document.getElementById("previous").disabled = true;
                }
                if(response.nextPageData == 0) {
                  document.getElementById("next").disabled = true;
                }
              } else {
                document.getElementById("next").disabled = true;
                document.getElementById("productData").innerHTML = "";
                div += '<div class="col-md-12 text-center" style="padding: 20%;"><h1>No Product Found</h1></div>';
              }
            } else {
              document.getElementById("next").disabled = true;
              document.getElementById("productData").innerHTML = "";
              div += '<div class="col-md-12 text-center" style="padding: 20%;"><h1>No Product Found</h1></div>';
            }
            if(count == 1) {
              document.getElementById("previous").disabled = true;
            }
            if(response.noProduct == 1) {
              document.getElementById("previous").disabled = true;
            }
            if(response.nextPageData == 0) {
              document.getElementById("next").disabled = true;
            }
          } else {
            document.getElementById("next").disabled = true;
            document.getElementById("productData").innerHTML = "";
            if(response['noProductFound']==1){
              document.getElementById("filterDiv").innerHTML = "";
              document.getElementById("buttons").innerHTML = "";
            }
            var div = '';
            div += '<div class="col-md-12 text-center" style="padding: 20%;"><h1>No Product Found</h1></div>';
            $(div).appendTo('#productData');
          }
        }
      })
    }
    $("#productData").on("click",".onSelectProduct", function() {
      var id = $(this).val();
      data = {limit: 9, page: count, _token: "{{csrf_token()}}"};
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
        }
      });
    });
    </script>
    @endsection
