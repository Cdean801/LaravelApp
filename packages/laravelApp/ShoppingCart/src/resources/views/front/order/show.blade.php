@extends('welcome')
@section('title')
Order Details - Frelii
@endsection
@section('content')
@include('../front/partials/sidenav')
<style media="screen">

.ainvert{
  color: #686c6e !important;
  transition: 0.3s color !important;
}
.ainvert:hover, .ainvert:focus{
  color: var(--frelii-color) !important;
  text-decoration: none !important;
  outline: none !important;
}
.price{
  color: var(--frelii-color) !important;
  text-align: right !important;
}

.padding-5{
  padding: 5px !important;
}

.margin-12{
  margin: 12px !important;
}
.padding-12{
  padding : 12px !important;
}
</style>

<div class="container" style="margin-top:8%;">
  <div class="section">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12 margin-12">
            <h2 class="heading-style">
              <span>
                Order Details
              </span>
            </h2>

            @if (!Auth::user()->hasRole(CUSTOMER))
            <hr>
            <h3 style="color:#686c6e">
              {{$order->user->first_name}} {{$order->user->last_name}}&nbsp<span style="font-size:15px;">({{$order->user->email}})</span>
              @endif
            </h3>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body padding-12" >
            <p class="text-center " style="font-size:22px;">
              Order #<mark>{{$order->id}}</mark> was placed on <mark>{{Carbon\Carbon::parse($order->created_at)->toFormattedDateString()
              }}</mark> and is currently @if($order->paid == 1) <mark>Paid.</mark> @else <mark>Failed.</mark>@endif
            </p>
            <hr>
            @if (Auth::user()->hasRole(CUSTOMER))

            @else

            @endif
            <table class="table table-responsive" style="font-size:22px;">
              <thead>
                <tr>
                  <h3><th class="text-left">Product</th></h3>
                  <th class="text-right">Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach($orderlines as $line)
                <tr>
                  <td>
                    <a class="ainvert" href="{{route('product_discription',['id'=> $line->product->id ])}}" >{{ $line->product->name }} </a>
                    <strong class="">× {{ $line->quantity }}</strong>
                  </td>
                  <td class="price">
                    <span class="">$</span>
                    {{ number_format($line->item_price,2) }}
                  </td>
                </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th scope="row">Subtotal:</th>
                  <td class="price">
                    <span class="">$</span><b>
                      {{ number_format($total,2) }}</b>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">Payment method:</th>
                    <td class="price font-weight-bold">
                      <!-- {{$order->brand}} -->
                      @if($order->payment_method == 'CC') Credit Card @else N.A. @endif
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">Total:</th>
                    <td class="price font-weight-bold"><b>
                      <span class="">$</span>
                      {{ number_format($total,2) }}</b>
                    </td>
                  </tr>
                </tfoot>
              </table>


              <div class="row" style="font-size:22px;color:black">
                @if(null!=$billing && ''!=$billing)
                <div class="col-md-6">
                  <div class="panel panel-default margin-12">
                    <div class="panel-body padding-12">
                      <p class="text-center" >
                        Billing address
                      </p>
                      <hr>
                      <address style="padding-left:10px;">
                        {{$billing['first_name']}} {{$billing['last_name']}}<br>
                        {{$billing['address1']}} <br>
                        @if(null!=$billing['address2'] && ''!=$billing['address2'])
                        {{$billing['address2']}}<br>
                        @endif
                        {{$billing['town_city']}}, {{$billing['state']}}, {{$billing['country']}}, {{$billing['zip']}}<br>
                        <i class="fa fa-phone"></i> {{$billing['phone']}}<br>
                        <i class="fa fa-envelope-o" aria-hidden="true" style="word-wrap: break-word;"></i> {{$billing['email']}}<br>
                      </address>
                    </div>
                  </div>
                </div>
                @endif

                @if(null!=$shipping && ''!=$shipping)
                <div class="col-md-6">
                  <div class="panel panel-default margin-12">
                    <div class="panel-body padding-12">
                      <p class="text-center " style="font-size:22px;">
                        Shipping address
                      </p>
                      <hr>
                      <address style="padding-left:10px;">
                        {{$shipping['first_name']}} {{$shipping['last_name']}}<br>
                        {{$shipping['address1']}}<br>
                        @if(null!=$shipping['address2'] && ''!=$shipping['address2'])
                        {{$shipping['address2']}}<br>
                        @endif
                        {{$shipping['town_city']}}, {{$shipping['state']}}, {{$shipping['country']}}, {{$shipping['zip']}}<br>
                        <i class="fa fa-phone"></i> {{$shipping['phone']}}<br>
                        <i class="fa fa-envelope-o" aria-hidden="true" style="word-wrap: break-word;"></i> {{$shipping['email']}}<br>
                      </address>
                    </div>
                  </div>
                </div>
                @endif
              </div>
              <button type="button" class="btn text-center btn-danger">
                @if (Auth::user()->hasRole(CUSTOMER))
                <a href="{{ route('orders.user_index',['permission' => encrypt(ORDER_LIST_PERMISSION)])}}" class="cancel-a-link-style-for-category" style="color:#ffffff !important;">CANCEL</a>
                @else
                <a href="{{ route('orders.admin_index',['permission' => encrypt(ORDER_LIST_PERMISSION)])}}" class="cancel-a-link-style-for-category" style="color:#ffffff !important;">CANCEL</a>
                @endif
              </div>
            </button>

          </div>

        </div>
      </div>
    </div>
    <div class="col-md-3">
    </div>
  </div>
</div>
</div>
<script>
function defaultImage(img)
{
  img.src = "{{url('/img/food.png')}}";
}
</script>
@endsection
