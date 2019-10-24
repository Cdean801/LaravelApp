@extends('welcome')
@section('title')
SaneCart - Checkout
@endsection
@section('content')

<!-- container -->
<div class="container" style="padding-top:100px;">
  <div class="section">
    <!-- BEGIN: Subheader -->
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="section-title">
          <h3 class="title">Checkout</h3>
        </div>
        <div>
          {!! Form::open(['action' => 'CartController@finalCheckout',  'class' => 'checkout-form', 'id' => 'time_slot_create_form']) !!}
          <div class="row">
            <div class="col-md-6">
              <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                  <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                      <span class="m-portlet__head-icon m--hide">
                        <i class="la la-gear"></i>
                      </span>
                      <h3 class="m-portlet__head-text">
                        1. Payment Info
                      </h3>
                    </div>
                  </div>
                </div>
                <!--begin::Form-->
                <div class="m-portlet__body">
                  <div id="card-errors"></div>

                  <div class="form-group">
                    <label for="name">Name on Card</label>
                    <input type="text" class="form-control" id="name">
                  </div>

                  <div class="form-group">
                    <label for="name">Card Number</label>
                    <span type="number" id="card-number" class="form-control">
                      <!-- Stripe Card Element -->
                    </span>
                  </div>
                  <div class="form-group">
                    <label for="name">CVC Number</label>
                    <span id="card-cvc" class="form-control">
                      <!-- Stripe Card Element -->
                    </span>
                  </div>
                  <div class="form-group">
                    <label for="name">Expiration</label>
                    <span id="card-exp" class="form-control">
                      <!-- Stripe Card Element -->
                    </span>
                  </div>
                  <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                      <div class="row">
                        <div class="col">
                          <button type="submit" class="primary-btn" id="payment-submit">
                            Submit
                          </button> &nbsp
                          <img src={!! '/img/powered_by_stripe1.png'!!} >
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
                <!--end::Form-->
              </div>
            </div>
          </div>
          {!! Form::close() !!}

          <div class="m-subheader" style="padding-top:50px;">
            <div class="d-flex align-items-center">
              <div class="mr-auto">
                <h2>
                  Review your items.
                </h2>
              </div>
              <div>
              </div>
            </div>
          </div>

          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Item Name</th>
                <th scope="col">Item Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total Price</th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $product)
              <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{ $product['item']['name'] }}</td>
                <td>{{ $product['item_price'] }}</td>
                <td>{{ $product['qty']}}</td>
                <td>${{ $product['total_price'] }}</td>
              </tr>
              @endforeach
              <tr>
                <th scope="row"></th>
                <td><h4>Total</h4></td>
                <td></td>
                <td></td>
                <td><h4>${{ $total }}</h4></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>
  @endsection
  @push('scripts')
  <script>
  $(document).ready(function(){

    // Create a Stripe client
    var stripe = Stripe('pk_test_oz07oozPGa0mggSZYPq8Od1I');

    // Create an instance of Elements
    var elements = stripe.elements();

    // Try to match bootstrap 4 styling
    var style = {
      base: {
        'lineHeight': '1.35',
        'fontSize': '1.11rem',
        'color': '#495057',
        'fontFamily': 'apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif'
      }
    };

    // Card number
    var card = elements.create('cardNumber', {
      'placeholder': '',
      'style': style
    });
    card.mount('#card-number');

    // CVC
    var cvc = elements.create('cardCvc', {
      'placeholder': '',
      'style': style
    });
    cvc.mount('#card-cvc');

    // Card expiry
    var exp = elements.create('cardExpiry', {
      'placeholder': '',
      'style': style
    });
    exp.mount('#card-exp');

    // Submit
    $('#payment-submit').on('click', function(e){
      e.preventDefault();
      var cardData = {
        'name': $('#name').val()
      };
      stripe.createToken(card, cardData).then(function(result) {
        if(result.error && result.error.message){
          $("#card-errors").html("");
          $( "#card-errors" ).append( "<div class=\"alert alert-danger\" role=\"alert\">" +
          "<strong>Oh snap!</strong> " + result.error.message + "</div>");

        }else{
          // Insert the token ID into the form so it gets submitted to the server
          var form = document.getElementById('time_slot_create_form');
          var hiddenInput = document.createElement('input');
          hiddenInput.setAttribute('type', 'hidden');
          hiddenInput.setAttribute('name', 'stripeToken');
          hiddenInput.setAttribute('value', result.token.id );
          form.appendChild(hiddenInput);
          // Submit the form
          form.submit();
        }
      });
    });

  });

  // $("select[name='location_id']").change(function(){
  //   var location_id = $(this).val();
  //   var token = $("input[name='_token']").val();
  //   $.ajax({
  //     url: "<?php echo route('selectDate') ?>",
  //     method: 'GET',
  //     data: {location_id:location_id, _token:token},
  //     success: function(data) {
  //       $("select[name='pickup_date'").html('');
  //       $("select[name='pickup_date'").html(data.options);
  //     }
  //   });
  // });
  // $("select[name='pickup_date']").change(function(){
  //   var pickup_date = $(this).val();
  //   var token = $("input[name='_token']").val();
  //   var location_id1 = $("select[name='location_id']").val();
  //   $.ajax({
  //     url: "<?php echo route('selectSlot') ?>",
  //     method: 'GET',
  //     data: {pickup_date:pickup_date, location_id:location_id1, _token:token},
  //     success: function(data) {
  //       $("select[name='slot_id'").html('');
  //       $("select[name='slot_id'").html(data.options);
  //     }
  //   });
  // });
</script>
@endpush
