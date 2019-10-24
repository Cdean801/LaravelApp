@extends('welcome')
@section('title')
Edit Recipe - Frelii
@endsection

@section('content')
@include('../front/partials/sidenav')
<link href="{{ asset('css/admin/category/category.css') }}" rel="stylesheet" type="text/css"/>
<style>
.row {
  margin-right: 0% !important;
    margin-left: 0% !important;
}
</style>
<div class="container" style="margin-top:8%;">
    <div class="section">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2 class="heading-style">
                            Edit A Category
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
                        @include('flash::message')
                        <hr>
                        <div class="row" id="mainCategory">
                                <div class="col-md-6 div-aligin-for-category">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name">Main Category<span class="required-color-for-category">*</span></label>
                                        <input id="name" type="text" class="text-field-style-for-category" name="name" value="{{$category->name}}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required autofocus>
                                        <div class="help-block with-errors"></div>
                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong class="validation-message">{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding-top:15px;">
                                      <div class="form-group">
                                          <button class="btn cancel-button-style-for-category cancel-a-link-style-for-category updateMainCategory" value="{{ $category->id }}">Update</button>
                                          <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-message="Are you sure you want to delete this category ?">Delete </button>
                                      </div>
                                </div>
                        </div>
                        <!-- Modal Dialog -->
                            <div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Delete Category Parmanently</h4>
                                  </div>
                                  <div class="modal-body">
                                    <p>Are you sure you want to delete all categorty?</p><p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger deleteMainCategory" value="{{ $category->id }}" id="confirm">Delete</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div>
                            @foreach($categories as $cat)
                            <div class="row"  id="delete{{ $cat->id}}" >
                                <div class="col-md-6   div-aligin-for-category">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="subName">Sub Category<span class="required-color-for-category">*</span></label>
                                        <input id="{{ $cat->id }}" type="text" class="text-field-style-for-category" value="{{ $cat->name }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required autofocus>
                                        <div class="help-block with-errors"></div>
                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong class="validation-message">{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                  <div class="col-md-6" style="padding-top:15px;">
                                      <div class="form-group">
                                          <button class="btn cancel-button-style-for-category cancel-a-link-style-for-category updateCategory updateButtonShow" value="{{ $cat->id }}" id='{{ $cat->id }}'>Update</button>
                                          <button class="btn btn-danger deleteCategory" value="{{ $cat->id }}" id='{{ $cat->id }}' name="id">Delete</button>
                                      </div>
                                  </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="row">
                          <div class="col-md-12">

                        <button type="button" class="btn text-center btn-danger">
                          <a href="{{ route('categories.index',['permission' => encrypt(CATEGORY_LIST_PERMISSION)]) }}" class="cancel-a-link-style-for-category">CANCEL</a>
                        </div>
                        </button>
                    </div>
                      </div>
                    </div>
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
    $(".updateCategory").click(function() {
        var inputId = $(this).val();
        var inputName = $('#' + inputId).val();
        var token = $('input[name="_token"]').val();
        var dd = {name: inputName, _token: token, inputId,permission:"{{encrypt(CATEGORY_EDIT_PERMISSION)}}"};
        $.ajax({
            type: "PUT",
            url: "/sub-categories/update/" + inputId,
            dataType: "JSON",
            data: dd,
            "dataSrc": function (data) {
                url = '{{ Config::get('production_env.server_url')}}401';
                if(data.code==='401'){
                window.location.href=url;
            }else{
                return data.data;
            }
          },
            success: function(response) {
                if (response.code === 200) {
                  location.reload();
                } else {
                    location.reload();
                }
            },
            error: function(response) {
             }
        });
    });
    $(".updateMainCategory").click(function() {
        var inputId = $(this).val();
        var inputName = $('#name').val();
        var token = $('input[name="_token"]').val();
        var data = {name: inputName, _token: token, inputId,permission:"{{encrypt(CATEGORY_EDIT_PERMISSION)}}"};
        var url = '{{route('categories.index',['permission' => encrypt(CATEGORY_LIST_PERMISSION)])}}';
        $.ajax({
            type: "PUT",
            url: "/categories/" + inputId,
            dataType: "JSON",
            data: data,
            "dataSrc": function (data) {
                url2 = '{{ Config::get('production_env.server_url')}}401';
                if(data.code==='401'){
                window.location.href=url2;
            }else{
                return data.data;
            }
          },
            success: function(response) {
              if(response.code == 200) {
                setTimeout(function() {
                    document.location.href = url;
                }, 500);
              } else {
                location.reload();
              }
            },
            error: function(response) {
             }
        });
    });
    $('.deleteMainCategory').click(function() {
        var del_id = $(this).val();
        var token = $('input[name="_token"]').val();
        var indexUrl = '{{route('categories.index',['permission' => encrypt(CATEGORY_LIST_PERMISSION)])}}';
          $.ajax({
              url: "/categories/delete/" + del_id,
              type: 'DELETE',
              dataType: "JSON",
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: {
                  "id": del_id,
                  "_method": 'DELETE',
                  "_token": token,
                  permission:"{{encrypt(CATEGORY_EDIT_PERMISSION)}}"
              },
              "dataSrc": function (data) {
                  url2 = '{{ Config::get('production_env.server_url')}}401';
                  if(data.code==='401'){
                  window.location.href=url2;
              }else{
                  return data.data;
              }
            },
              success: function(response) {
                if(response.code == 200) {
                  setTimeout(function() {
                      document.location.href = indexUrl;
                  }, 500);
                } else {
                  location.reload();
                }
              },
              error: function(response) {
               }
          });
    });
    $('.deleteCategory').click(function() {
        var del_id = $(this).val();
        var token = $('input[name="_token"]').val();
        $.ajax({
            url: "/sub-categories/delete/" + del_id,
            type: 'DELETE',
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "id": del_id,
                "_method": 'DELETE',
                "_token": token,
                permission:"{{encrypt(CATEGORY_EDIT_PERMISSION)}}"
            },
            "dataSrc": function (data) {
                url2 = '{{ Config::get('production_env.server_url')}}401';
                if(data.code==='401'){
                window.location.href=url2;
            }else{
                return data.data;
            }
          },
              success: function(response) {
                  if (response.code == 200) {
                      $('#'+'delete' + del_id).remove();
                      location.reload();
                  } else {
                    location.reload();
                  }
              },
            error: function(response) {
            }
        });
    });
</script>
@endpush
