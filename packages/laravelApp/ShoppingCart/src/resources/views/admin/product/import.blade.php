@extends('welcome')
@section('title')
    SaneCart - Admin - Products
@endsection


@section('content')
<!-- BEGIN: Subheader -->
<div class="container">
  <div class="section">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <h2 class="m-portlet__head-text">
                Products
              </h2>
            </div>
          </div>
        </div>

<!--begin::Form-->
{!! Form::open(['action' => 'ProductController@import', 'files' => true,  'class' => 'm-form m-form--state m-form--fit m-form--label-align-right', 'id' => 'product_import_form']) !!}
<div class="m-portlet__body">
  <div class="form-group m-form__group row">
    <label class="col-form-label col-lg-3 col-sm-12">
      Upload File
    </label>
    <div class="col-lg-4 col-md-9 col-sm-12">
      {!! Form::file('imported-file', ['class' => 'form-control m-input']) !!}
    </div>
  </div>
  <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space"></div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
  <div class="m-form__actions m-form__actions">
    <div class="row">
      <div class="col-lg-9 ml-lg-auto">
        <button type="submit" class="primary-btn">
          Submit
        </button>
      </div>
    </div>
  </div>
</div>
<!--end::Form-->

{!! Form::close() !!}

</div>
</div>
@endsection
