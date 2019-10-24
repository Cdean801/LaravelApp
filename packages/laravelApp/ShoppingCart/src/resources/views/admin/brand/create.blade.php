@extends('welcome')
@section('title')
    SaneCart - Admin - Create Brand
@endsection

@section('content')

<div class="container">
  <div class="section">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <h2 class="m-portlet__head-text">
                Add new Brand
              </h2>
            </div>
          </div>
        </div>

    <!--begin::Form-->
    {!! Form::model($brand, ['action' => 'BrandController@store', 'files' => true,  'class' => 'm-form m-form--state m-form--fit m-form--label-align-right', 'id' => 'brand_create_form']) !!}
      @include('/admin/brand/form')
    {!! Form::close() !!}
</div>
</div>
@endsection
