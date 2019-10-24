@extends('welcome')
@section('title')
    SaneCart - Home
@endsection
<!-- SlidesJS Required: -->
@section('content')
<div class="container">
  <div class="section">

<div class="col-md-12">
  <div class="order-summary clearfix">
    <div class="section-title">
      <h3 class="title">Checkout Step 1 of 3</h3>
    </div>
  </div>
</div>
<div class="col-md-12">
  <p>
    Please select how would you like to have your order. For home delivery select, Home delivery ($3.99/delivery). For
    pickup please select Convinient Pickup. There are no delivery charge for Convinient Pickup option.
  <p>
</div>
{!! Form::open(['action' => 'CartController@finalCheckout',  'class' => 'checkout-form', 'id' => 'time_slot_create_form']) !!}
<div class="row">
  <div class="col-md-6">
    <div class="m-portlet m-portlet--tab">

      <!--begin::Form-->
        <div class="m-portlet__body">

          <div class="form-group m-form__group">
            <label for="exampleSelect1">
              Select Order Method
            </label>
                <div class="col-lg-4 col-md-9 col-sm-12">
                  {!! Form::select('option', ['Home Delivery', 'Convinient Pickup'], ['class' => 'form-control m-input']) !!}
                </div>
          </div>


          <div class="col-lg-4 col-md-9 col-sm-12">
            <button type="submit" class="primary-btn" id="payment-submit">
              Next
            </button> &nbsp
          </div>
          </div>
        </div>
      <!--end::Form-->
    </div>
  </div>

</div>
{!! Form::close() !!}
</div>
</div>
@endsection
