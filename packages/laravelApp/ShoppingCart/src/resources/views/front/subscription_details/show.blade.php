@extends('welcome')
@section('title')
SaneCart - Checkout
@endsection
@section('content')
@include('../front/partials/sidenav')
<link href="{{ asset('css/front/subscription_details/show.css') }}" rel="stylesheet" type="text/css"/>
<div class="container div-container">
  <div class="section">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="row">
          @if (Auth::user()->hasRole(CUSTOMER))
          <div class="col-md-6">
            <h2 class="heading-style text-left">
              Subscription # {{$userSubscriptionDetails->id}}
            </h2>
          </div>
          @else
          <div class="col-md-6">
            <h2 class="heading-style text-left">
              Subscription # {{$userSubscriptionDetails->id}}
            </h2>
          </div>
          <div class="col-md-6 text-right">
            <h2 class="heading-style text-right">
              User # {{$userSubscriptionDetails['user']->id}}
            </h2>
          </div>
          @endif
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <table class="table table-responsive" style="font-size:22px;">
              <thead>
                <tr>
                  <h3><th class="text-left">Paid Status</th></h3>
                  <th class="text-right price font-weight-bold" style="text-transform:capitalize">{{$userSubscriptionDetails->status}}</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th scope="row">Period Start Date:</th>
                  <td class="price font-weight-bold"><b>
                    <span class="">{{$userSubscriptionDetails->start_date}}</span>
                  </b>
                </td>
              </tr>
              <tr>
                <th scope="row">Period End Date:</th>
                <td class="price font-weight-bold"><b>
                  <span class="">{{$userSubscriptionDetails->end_date}}</span></b>
                </td>
              </tr>
              <tr>
                <th scope="row">Amount:</th>
                <td class="price font-weight-bold"><b>
                  <span class="">$ {{$userSubscriptionDetails->amount}}</span>
                </b>
              </td>
            </tr>
            <tr>
              <th scope="row">Card Number:</th>
              <td class="price font-weight-bold"><b>
                <span class="">{{'XXXX XXXX XXXX '.$userCardInfo->last4}}</span>
              </b>
            </td>
          </tr>
          <tr>
            <th scope="row">Brand :</th>
            <td class="price font-weight-bold"><b>
              <span class="">{{$userCardInfo->brand}}</span>
            </b>
          </td>
        </tr>
        <tr>
          <th scope="row">Paid Date:</th>
          <td class="price font-weight-bold"><b>
            <span class="">{{ Carbon\Carbon::parse($userSubscriptionDetails->created_at)->format('F, d Y')}} </span>
          </b>
        </td>
      </tr>
       <tr>
          <th scope="row">Active Status:</th>
          <td class="price font-weight-bold"><b>
            @if($userSubscriptionDetails->active === 1)
            <span class="">Active</span>
            @else
             <span class="">Cancelled</span>
             @endif
          </b>
        </td>
      </tr>
    </tfoot>
  </table>
  <button type="button" class="btn text-center btn-danger">
    @if (Auth::user()->hasRole(CUSTOMER))
    <a href="{{ route('user_subscription.index',['permission' => encrypt(PERMISSION_USER_SUBSCRIPTION_LIST)])}}" class="cancel-a-link-style-for-category" style="color:#ffffff !important;">CANCEL</a>
    @else
    <a href="{{ route('subscriptions.admin_index',['permission' => encrypt(PERMISSION_USER_SUBSCRIPTION_LIST)])}}" class="cancel-a-link-style-for-category" style="color:#ffffff !important;">CANCEL</a>
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
@endsection
