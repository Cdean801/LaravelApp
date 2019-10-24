@extends('welcome')
@section('title')
Add Product - Frelii
@endsection

@section('content')
{{-- @include('../front/partials/sidenav') --}}
<link href="{{ asset('css/admin/product/product.css') }}" rel="stylesheet">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/2.0.4/js/Jcrop.min.js"></script> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/2.0.4/css/Jcrop.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/2.0.4/css/Jcrop.min.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="container product-container">
  <div class="section">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-body">
            <h2 class="heading-style">
              Add New Product
            </h2>
            @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            {{-- @include('flash::message') --}}
            <hr>

            <form id="productForm" class="" method="POST" action="{{ route('product.create') }}" id="productForm" enctype="multipart/form-data" data-toggle="validator">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="title">Name<span class="required">*</span></label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required autofocus>
                    <div class="help-block with-errors"></div>
                    @if ($errors->has('name'))
                    <span class="help-block">
                      <strong class="validation-message">{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                  </div>
                  <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="description">Description<span class="required">*</span></label>
                    <textarea class="form-control" rows="7" id="description" name="description" value="{{ old('description') }}" maxlength="5000" data-toggle="tooltip" title="Use upto 5000 characters." data-placement="bottom" required>{{ old('description') }}</textarea>
                    <span id="remainingCount"></span>
                    <div class="help-block with-errors"></div>
                    @if ($errors->has('description'))
                    <span class="help-block">
                      <strong class="validation-message">{{ $errors->first('description') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 text-center preview-img-div">
                  <div class="form-group">
                    <label for="title">Upload Image</label>
                  </div>
                  <!-- <label for="description" class="col-md-6 text-center">Image Upload</label> -->
                  <!-- <div class="col-md-12"> -->
                  <!-- Modal -->

                  <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Upload Image</h4>
                        </div>
                        <div class="modal-body">
                          <input type="file" class="form-control" name="image" id="new_image" accept="image/*">
                          <input type="hidden" name="imgX1" id="imgX1" />
                          <input type="hidden" name="imgY1" id="imgY1" />
                          <input type="hidden" name="imgWidth" id="imgWidth" />
                          <input type="hidden" name="imgHeight" id="imgHeight" />
                          <input type="hidden" class="jay" name="imgCropped" id="imgCropped" />
                          <!-- <img src="" id="recipe-img-tag-new" name="image-preview" class="image-style"/> -->
                          <img src="" id="product-img-inside-model" name="image-preview" class="image-style"/>
                          <div class="text-center" style="padding:1%;">
                            <button align="center" type="button" id="btnCrop" value="Crop" class="btn crop-btn " data-dismiss="modal">crop</button>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default close-btn" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <canvas hidden  id="canvas" height="1" width="1"></canvas>
                  <!-- <img id="recipe-img-tag-news" width="200px"  name="image-preview" class="image-style" src="/default_image.jpg"> -->
                  <img id="product-img-inside-form" width="200px"  name="image-preview" class="image-style" src="/default_image.jpg">
                  <div>
                    <button id="model_btn" type="button" class="btn btn-camera btn-lg" data-toggle="modal" data-target="#myModal"><i class="fas fa-camera-retro"></i></button>
                    <button class="btn btn-camera btn-lg" id="current-img-remove" onclick="myFunction()" type="button" class="btn btn-lg "><i class="fas fa-trash-alt"></i></button>
                  </div>
                </div>
              </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
        <label for="title">Price<span class="required">*</span></label>
        <input id="price" type="number" step="any" min="0.01" onchange="setTwoNumberDecimal(this)" class="form-control" name="price" value="{{ old('price') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required autofocus>
        <div class="help-block with-errors"></div>
        @if ($errors->has('price'))
        <span class="help-block">
          <strong class="validation-message">{{ $errors->first('price') }}</strong>
        </span>
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group{{ $errors->has('in_stock_quantity') ? ' has-error' : '' }}">
        <label for="title">Instock Quantity<span class="required">*</span></label>
        <input class="form-control" type="number" name="in_stock_quantity"  value="{{ old('in_stock_quantity')}}" required  max="999999999" min="1">
        <div class="help-block with-errors"></div>
        @if ($errors->has('in_stock_quantity'))
        <span class="help-block">
          <strong class="validation-message">{{ $errors->first('in_stock_quantity') }}</strong>
        </span>
        @endif
      </div>
    </div>

</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
      <label for="title">URL</label>
      <input id="url" type="url"  maxlength="255" class="form-control" name="url" value="{{ old('url') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" data-pattern-error="Url code must be number." autofocus>
      <div class="help-block with-errors"></div>
      @if ($errors->has('url'))
      <span class="help-block">
        <strong class="validation-message">{{ $errors->first('url') }}</strong>
      </span>
      @endif
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
      <label for="title">SKU<span class="required">*</span></label>
      <input id="sku" type="text" maxlength="191" class="form-control" name="sku" value="{{ old('sku') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required autofocus>
      <div class="help-block with-errors"></div>
      @if ($errors->has('sku'))
      <span class="help-block">
        <strong class="validation-message">{{ $errors->first('sku') }}</strong>
      </span>
      @endif
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('stock_status') ? ' has-error' : '' }}">
      <label for="title">Stock Status<span class="required">*</span></label>
      <select name="stock_status" class="selectpicker" data-width="100%" required>
        <option value="">select</option>
        <option value="Y" @if (old('stock_status') == 'Y') selected="selected" @endif>Yes</option>
        <option value="N" @if (old('stock_status') == 'N') selected="selected" @endif>No</option>
      </select>
      <div class="help-block with-errors"></div>
      @if ($errors->has('stock_status'))
      <span class="help-block">
        <strong class="validation-message">{{ $errors->first('stock_status') }}</strong>
      </span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('shipping_weight') ? ' has-error' : '' }}">
      <label for="title">Shipping Weight<span class="required">*</span></label>
      <input id="shipping_weight" type="number" min="0.01" step="any" onchange="setTwoNumberDecimal(this)" class="form-control" name="shipping_weight" value="{{ old('shipping_weight') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required autofocus>
      <div class="help-block with-errors"></div>
      @if ($errors->has('shipping_weight'))
      <span class="help-block">
        <strong class="validation-message">{{ $errors->first('shipping_weight') }}</strong>
      </span>
      @endif
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="form-group{{ $errors->has('shipping_length') ? ' has-error' : '' }}">
      <label for="title">Shipping Length<span class="required">*</span></label>
      <input id="shipping_length" type="number" min="0.01" step="any" onchange="setTwoNumberDecimal(this)" class="form-control" name="shipping_length" value="{{ old('shipping_length') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required autofocus>
      <div class="help-block with-errors"></div>
      @if ($errors->has('shipping_length'))
      <span class="help-block">
        <strong class="validation-message">{{ $errors->first('shipping_length') }}</strong>
      </span>
      @endif
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group{{ $errors->has('shipping_width') ? ' has-error' : '' }}">
      <label for="title">Shipping Width<span class="required">*</span></label>
      <input id="shipping_width" type="number" min="0.01" step="any" onchange="setTwoNumberDecimal(this)" class="form-control" name="shipping_width" value="{{ old('shipping_width') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required autofocus>
      <div class="help-block with-errors"></div>
      @if ($errors->has('shipping_width'))
      <span class="help-block">
        <strong class="validation-message">{{ $errors->first('shipping_width') }}</strong>
      </span>
      @endif
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group{{ $errors->has('shipping_height') ? ' has-error' : '' }}">
      <label for="title">Shipping Height<span class="required">*</span></label>
      <input id="shipping_height" type="number" min="0.01" step="any" onchange="setTwoNumberDecimal(this)" class="form-control" name="shipping_height" value="{{ old('shipping_height') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required autofocus>
      <div class="help-block with-errors"></div>
      @if ($errors->has('shipping_height'))
      <span class="help-block">
        <strong class="validation-message">{{ $errors->first('shipping_height') }}</strong>
      </span>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-md-6" class="form-group{{ $errors->has('main_category') ? ' has-error' : '' }}">
      <label for="main_category">Main Category<span class="required">*</span></label><br>
      <select name="main_category" class="selectpicker" data-live-search="true" data-width="100%" required>
        <option value="">select</option>
        @if(isset($categories))
        @foreach ($categories as $key =>$category)
        <option name="selectedCategory" value="{{$category->id}}" @if(old('main_category') == $category->id) {{ 'selected' }} @endif >{{$category->name}}</option>
        @endforeach
        @endif
      </select>
      <div class="help-block with-errors"></div>
      @if ($errors->has('main_category'))
      <span class="help-block">
        <strong class="validation-message" >{{ $errors->first('main_category') }}</strong>
      </span>
      @endif
    </div>

    <div class="col-md-6" id="subCategoryDropdown" class="form-group{{ $errors->has('sub_category') ? ' has-error' : '' }}">
      <label for="state" > Sub Category </label><br>
      <select id="sub_category" name="sub_category" class="selectpicker" data-live-search="true" data-width="100%">
      </select>
      <div class="help-block with-errors"></div>
      @if ($errors->has('sub_category'))
      <span class="help-block">
        <strong class="validation-message">{{ $errors->first('sub_category') }}</strong>
      </span>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
      {{-- <label>Select Tags <span style="color: #7e8081;font-size: 13px;font-weight: 500;"> (Multiple select)</span></label>
      <select name="tag_id[]" id="multipleselect1" class="form-control form-control-md selectpicker" data-live-search="true" multiple data-required-error="Role field is required.">
        @foreach ($producttags as $tag)
        <option class="text-capitalize" value="{{$tag->name}}" >{{$tag->name}}</option>
        @endforeach
      </select> --}}
      <div style="color:red">
        <div class="help-block with-errors"></div>
        @if ($errors->has('category_id'))
        <span class="help-block">
          <strong class="validation-message" >{{ $errors->first('category_id') }}</strong>
        </span>
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
        <label for="title">Add New Tag <span style="color: #7e8081;font-size: 13px;font-weight: 500;">(comma separated ex. tag1,tag2,tag3)</span></label>
        <input id="new_tags" type="text" maxlength="191" pattern="(?:\w*,\w+)+\w*$" class="form-control" name="new_tags" value="{{ old('new_tags') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom"  autofocus>
        <div class="help-block with-errors"></div>
        @if ($errors->has('new_tags'))
        <span class="help-block">
          <strong class="validation-message">{{ $errors->first('new_tags') }}</strong>
        </span>
        @endif
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="form-group col-md-12">
    <button id="btnssssSubmit" type="submit" class="btn btn-default button-style white-color text-center">CREATE</button>
  </div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')

<script type="text/javascript">


function setTwoNumberDecimal(el) {
  el.value = parseFloat(el.value).toFixed(2);
};
$(document).ready(function () {
  $('select[name="main_category"]').on('change', function () {

    var categoryID = $(this).val();
    var parm = {'main_category': categoryID}
    if (categoryID) {
      $.ajax({
        url: '/product/getSub/"{{encrypt('product-create')}}"',
        type: 'GET',
        data: parm,
        success: function (data) {
          if ('Sub category not found' == data) {
            $('select[name="sub_category"]').empty();
            // $('#sub_category').append('<option value="N.A">N.A</option>');
            $('#sub_category').selectpicker('refresh');
          } else {
            $('select[name="sub_category"]').empty();
            var res = data.sub;
            $('#sub_category').append('<option value="">select</option>');
            $.each(res, function (key, value) {
              $('#sub_category').append('<option value="' + value.id + '">' + value.name + '</option>');
              $('#sub_category').selectpicker('refresh');
            });
          }
        },
        error: function () {
          console.log("Sub category not found");
        }
      });
    } else {
      $('select[name="sub_category"]').empty();
    }
  });
  $(function () {

    /* display remaining count below textarea*/
    var text_max = 5000;
    $('#remainingCount').css('visibility', "hidden");
    // $('#remainingCountRecipe').css('visibility', "hidden");
    $('#description').keyup(function() {
      var text_length = $('#description').val().length;
      if(null!= text_length && ''!= text_length){
        var text_remaining = text_max - text_length;
        $('#remainingCount').css('visibility', "visible");
        document.getElementById('remainingCount').innerText = text_remaining + ' characters remaining of 5000 characters';
      }else{
        $('#remainingCount').css('visibility', "hidden");
      }
    });

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#product-img-tag').attr('src', e.target.result);
          $('#remove').css('visibility', "visible");
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#remove").click(function () {
      $('#product-img-tag').attr('src', "");
      $('input[name="image"]').val("");
      $('#remove').css('visibility', "hidden");
    });
    $("#image").change(function () {
      readURL(this);
    });
  });
});
</script>
<!-- Image upload code START  -->
<script type="text/javascript">
function forEachElement(selector, fn) {
    var elements = document.querySelectorAll(selector);
    for (var i = 0; i < elements.length; i++)
    fn(elements[i], i);
}

forEachElement('select', function(el, i){
    // Capitalise this element
    el.style.textTransform = 'capitalize';

    // When options are changed
    el.addEventListener('input', function(){
        // Get selected option
        var selected = el.options[el.selectedIndex],
        // Get text of selected option
        selectedText = selected.text;

        // Make it uppercase
        selectedText = selectedText.toUpperCase();

        // Change the text of the selected option
        selected.innerText = selectedText;

    });

    // Then, trigger 'change' of dropdown to make initial option, uppercase
});
var x = document.getElementById("current-img-remove");
if(null!=x){
  x.style.display = "none";
}
$(function () {
  $('#close').click(function(){
    $('#btnCrop').hide();
    $("#current-img-remove").hide();
    var vals= $('input[name="new_image"]').val('');
    var src = $('#product-img-inside-form').attr('src','');
    var new_image = $("#new_image").val('');
    $('input[name="imgX1"]').val("");
    $('input[name="imgY1"]').val("");
    $('input[name="imgWidth"]').val("");
    $('input[name="imgHeight"]').val("");
    JcropAPI = $('#product-img-inside-model').data('Jcrop');
    if (JcropAPI != null) {
      JcropAPI.destroy();
      $("#current-img-remove").hide();
    }
  });
  /* outside click of model */
  $('#myModal').on('hidden.bs.modal', function () {
    JcropAPI = $('#product-img-inside-model').data('Jcrop');
    if (JcropAPI != null) {
      JcropAPI.destroy();
      $("#current-img-remove").hide();
      $("#new_image").val('');
    }
  })
  /* close button of model */
  $('#close').click(function(){
    $('#btnCrop').hide();
    $("#current-img-remove").hide();
    var vals= $('input[name="new_image"]').val('');
    var src = $('#product-img-inside-form').attr('src','');
    var new_image = $("#new_image").val('');
    $('input[name="imgX1"]').val("");
    $('input[name="imgY1"]').val("");
    $('input[name="imgWidth"]').val("");
    $('input[name="imgHeight"]').val("");
    JcropAPI = $('#product-img-inside-model').data('Jcrop');
    if (JcropAPI != null) {
      JcropAPI.destroy();
      $("#current-img-remove").hide();
    }
  });
  /* load image on model */
  $('#new_image').change(function () {
    var reader = new FileReader();
    reader.onload = function (e) {
      JcropAPI = $('#product-img-inside-model').data('Jcrop');
      if (JcropAPI != null) {
        JcropAPI.destroy();
      }
      $("#canvas").val('');
      $('#btnCrop').hide();

      $('input[name="new_image"]').val("");
      $('input[name="imgX1"]').val("");
      $('input[name="imgY1"]').val("");
      $('input[name="imgWidth"]').val("");
      $('input[name="imgHeight"]').val("");

      $('#product-img-inside-model').attr('src', "");
      $('#product-img-inside-model').attr("src","");
      $('#product-img-inside-form').attr("src",'/default_image.jpg');

      $('#product-img-inside-model').show();
      $('#product-img-inside-model').attr("src", e.target.result);
      $('#product-img-inside-model').Jcrop({
        onChange: SetCoordinates,
        onSelect: SetCoordinates,
        setSelect:   [ 100, 100, 100, 100 ],
        aspectRatio:1,
      });
    }
    reader.readAsDataURL($(this)[0].files[0]);
  });
  /* Crop button on model */
  $('#btnCrop').click(function () {
    var x1 = $('#imgX1').val();
    var y1 = $('#imgY1').val();
    var width = $('#imgWidth').val();
    var height = $('#imgHeight').val();
    var canvas = $("#canvas")[0];
    var context = canvas.getContext('2d');
    var img = new Image();
    img.onload = function () {
      $('#btnCrop').hide();

      $('input[name="new_image"]').val("");
      $('input[name="imgX1"]').val("");
      $('input[name="imgY1"]').val("");
      $('input[name="imgWidth"]').val("");
      $('input[name="imgHeight"]').val("");

      $('#product-img-inside-model').attr('src', "");
      JcropAPI = $('#product-img-inside-model').data('Jcrop');
      JcropAPI.destroy();

      canvas.height = height;
      canvas.width = width;
      context.drawImage(img, x1, y1, width, height, 0, 0, width, height);
      /* After Cropped base64 of image */
      $('#imgCropped').val(canvas.toDataURL());
      var dataURL = canvas.toDataURL();
      $('#product-img-inside-form').attr("src",dataURL);
    };

    img.src = $('#product-img-inside-model').attr("src");
    $('input[name="imgX1"]').val("");
    $('input[name="imgY1"]').val("");
    $('input[name="imgWidth"]').val("");
    $('input[name="imgHeight"]').val("");
    $('#product-img-inside-model').attr('src', "");
  });
});
/* Image Crop Coordinates on model */
function SetCoordinates(c) {
  $('#imgX1').val(c.x);
  $('#imgY1').val(c.y);
  $('#imgWidth').val(c.w);
  $('#imgHeight').val(c.h);
  $('#btnCrop').show();
};
$( "#model_btn" ).click('shown', function(){
  $('#btnCrop').hide();
  $('input[name="new_image"]').val("");
  $('input[name="imgX1"]').val("");
  $('input[name="imgY1"]').val("");
  $('input[name="imgWidth"]').val("");
  $('input[name="imgHeight"]').val("");
  $('#product-img-inside-model').attr('src', "");
  JcropAPI = $('#product-img-inside-model').data('Jcrop');
  if (JcropAPI != null) {
    JcropAPI.destroy();
  }
});
/* Image Change on model */
$('#new_image').change(function () {
  var src = $('#recipe-img-tag').attr('src');
  var x = document.getElementById("current-img-remove");
  x.style.display = "inline-block";
});
/* Delete button on form for Image Upload */
function myFunction() {
  var src = $('#product-img-inside-form').attr('src','/default_image.jpg');
  $("#new_image").val('');
  var x = document.getElementById("current-img-remove");
  x.style.display = "none";
}
</script>

<!-- Image upload code END  -->
@endpush
