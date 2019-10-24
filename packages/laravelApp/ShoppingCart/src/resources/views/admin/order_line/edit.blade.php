@extends('front.welcome')
@section('title')
    SaneCart - Admin - Edit Order
@endsection

@section('content')
<br>
<br>
<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h2 class="m-portlet__head-text">
							Modify Quantity, {{ $product->name }}, from Order {{ $order->id }}
						</h2>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
        {!! Form::model($order_line, ['method' => 'PUT', 'route' => ['order_lines.admin_update', $order_line->id], 'files' => true, 'class' => 'm-form m-form--state m-form--fit m-form--label-align-right', 'id' => 'product_create_form']) !!}
        {!! Form::hidden('id', $order_line->id) !!}
        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12">
            Order Quantity
          </label>
          <div class="col-lg-4 col-md-9 col-sm-12">
              {!! Form::number('quantity', $order_line->quantity, ['class' => 'form-control m-input', 'placeholder' => 'Enter quantity.']) !!}

          </div>
        </div>
        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12">
            Reason for Changing the quantity:
          </label>
          <div class="col-lg-4 col-md-9 col-sm-12">
            {!! Form::select('reason', array('1' => 'Customer does not want it.',
              '2' => 'Item is missing from the order.',
              '3' => 'Other Reason.'), $product->active, ['class' => 'form-control m-input']) !!}

          </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions m-form__actions">
            <div class="row">
              <div class="col-lg-9 ml-lg-auto">
                <button type="submit" class="btn btn-accent">
                  Submit
                </button>
              </div>
            </div>
          </div>
        </div>
        {!! Form::close() !!}

			</div>
		</div>

<a href="{{ '/admin_orders/' . $order->id . '/edit'}}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Back to Order</a>
<h1><br></h1>



@endsection
