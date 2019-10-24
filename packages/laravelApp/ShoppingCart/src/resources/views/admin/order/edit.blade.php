@extends('welcome')
@section('title')
    SaneCart - Admin - Edit Order
@endsection

@section('content')
      <div class="container">
        <div class="section">
              <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                  <div class="m-portlet__head-title">
                    <h2 class="m-portlet__head-text">
                      Order # {{$order->id}}
                    </h2>
                  </div>
                </div>
              </div>
			<div class="m-portlet__body">
        Thank You for placing Order with us. Here are the details of your order.
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Item Name</th>
              <th scope="col">Item Price</th>
              <th scope="col">Quantity</th>
              <th scope="col">Total Price</th>
              <th scope="col">Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order_lines as $line)
              <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{ $line->product->name }}</td>
                <td>{{ $line->item_price }}</td>
                <td>{{ $line->quantity }}</td>
                <td>${{ $line->item_price * $line->quantity }}</td>
                <td>
                  @if($order->paid == false)
                  <a href="{{ '/admin_orderline/' . $line->id . '/edit' }}" class="btn btn-xs btn-primary">Edit</a>
                  @endif
                </td>
              </tr>
            @endforeach
            <tr>
              <th scope="row"></th>
              <td><h4>Total</h4></td>
              <td></td>
              <td></td>
              <td><h4>${{ $total }}</h4></td>
            </tr>
            <tr>
              <th scope="row"></th>
              <td>
                @if($order->paid == false)
                  <h4><a href="{{ '/admin/complete_order/' . $order->id }}" class="primary-btn">Deliver Order</a></h4>
                @else
                  <h3>Order is paid in full.</h3>
                @endif
              </td>
              <td></td>
              <td></td>
              <td></td>

            </tr>
          </tbody>
        </table>
			</div>


    <div class="m-portlet m-portlet--mobile">
    			<div class="m-portlet__head">
    				<div class="m-portlet__head-caption">
    					<div class="m-portlet__head-title">
    						<h2 class="m-portlet__head-text">
    							Pick Up Info
    						</h2>
    					</div>
    				</div>
    			</div>
    			<div class="m-portlet__body">
            <h6>Pick Up Date: {{$time_slot->slot_date}}</h6>
            <h6>Pickup Location: {{ $location->name }}, {{$location->address1}},
              {{$location->city}}, {{$location->state}}, {{$location->zip}} </h6>
            <h6>Slot Time: {{$time_slot->slot}}</h6>
          </div>
        </div>
<a href="/admin/todays_orders" class="primary-btn"> View Today's Orders</a>
<a href="/admin_orders" class="primary-btn"> View All Orders</a>


</div>
</div>


@endsection
