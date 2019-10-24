@extends('welcome')
@section('title')
Add Category - Frelii
@endsection

@section('content')
{{-- @include('../front/partials/sidenav') --}}
<link href="{{ asset('css/admin/category/category.css') }}" rel="stylesheet" type="text/css"/>
<style>
.row {
  margin-right: 0% !important;
    margin-left: 0% !important;
}
</style>
<div class="category-list-container-style">
    <div class="section">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2 class="list-category-heading-color">
                            Add New Category
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
                        <div class="row">
                            <form>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="rating">Category Type</label>
                                        <select class="form-control accordion" name="category" data-toggle="tooltip" title="Please select a Category type."  id="categoryType" required>
                                            <option value="" disabled selected>Select a category type</option>
                                            <option id='main' value="main" data-toggle="collapse" href="#mainCategory"aria-expanded="true" data-target="#mainCategory" data-parent="#categoryType">Main Category</option>
                                            <option id='sub' value="sub" data-toggle="collapse" href="#subCategory" aria-expanded="true" data-target="#subCategory" data-parent="#categoryType">Sub Category</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="mainCategory" class="collapse"  data-parent="#categoryType" aria-labelledby="main">
                            <form class="" method="POST" action="{{ route('categories.store') }}" id="categoryForm" name="categoryForm" enctype="multipart/form-data" data-toggle="validator">
                                {{ csrf_field() }}
                                <div class="row" >
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label for="name">Main Category<span class="required-color-for-category">*</span></label>
                                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required autofocus>
                                            <div class="help-block with-errors"></div>
                                            @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong class="validation-message">{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                  {{-- <input type="hidden" value="{{encrypt(CATEGORY_CREATE_PERMISSION)}}" name="permission"> --}}
                                  <div class="row">
                                <div class="form-group col-md-12" id="addBtnShow">
                                    <button  type="submit" class="btn cancel-button-style-for-category cancel-a-link-style-for-category btnSubmit">CREATE</button>
                                </div>
                              </div>
                            </form>
                        </div>
                        <div id="subCategory"  class="collapse" data-parent="#categoryType" aria-labelledby="sub">
                            <form class="" method="POST" action="{{ route('categories.store') }}" id="categoryForm2" name="categoryForm2" enctype="multipart/form-data" data-toggle="validator">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label for="rating">Main Category<span class="required-color-for-category">*</span></label>
                                            <select class="form-control " name="selectCategory" id="selectCategory" data-toggle="tooltip" title="Select a main category" required>
                                                <option value="" disabled selected>Select a main category</option>
                                                @foreach($categories as $cat)
                                                <option id="categoryId" value="{{$cat->id}}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors"></d iv>
                                                @if ($errors->has('selectCategory'))
                                                <span class="help-block">
                                                    <strong class="validation-message">{{ $errors->first('selectCategory') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label for="name">Sub Category<span class="required-color-for-category">*</span></label>
                                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" maxlength="255" data-toggle="tooltip" title="Use upto 255 characters." data-placement="bottom" required autofocus>
                                            <div class="help-block with-errors"></div>
                                            @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong class="validation-message">{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{-- <input type="hidden" value="{{encrypt(CATEGORY_CREATE_PERMISSION)}}" name="permission"> --}}
                                <div class="row">
                                <div class="form-group col-md-12" id="addBtnShow" >
                                    <button type="submit" id="btnSubmit" class="btn cancel-button-style-for-category cancel-a-link-style-for-category">CREATE</button>
                                </div>
                              </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>
@endsection
