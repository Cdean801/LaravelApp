<!-- BEGIN: Subheader -->
@extends('welcome')
@section('title')
View Orders - Frelii
@endsection

@section('content')
@include('../front/partials/sidenav')
<link href="{{ asset('css/front/subscription_details/index.css') }}" rel="stylesheet" type="text/css"/>
<div class="subscription-details-container-style">
  <div class="section">
    <div class="row">
      <div class="col-md-2">
      </div>
      <div class="col-md-8" style ="width:auto;">
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
        <h1 class="subscription-details-heading-color">View My Subscriptions</h1>
        <div class="table-responsive">
          <table class="table table-bordered text-center" id="orders-table">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Subscription No.</th>
                <th class="text-center">Period Start Date</th>
                <th class="text-center">Period End Date</th>
                <th class="text-center">Amount($)</th>
                <th class="text-center">Paid Status</th>
                <th class="text-center">Subscription Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <div class="col-md-2">
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
  $('#orders-table').DataTable({
    processing: true,
    serverSide: true,
    ajax:{
      "url": "/user_subscription/datatable",
      "dataType": "json",
      "type": "POST",
      "data":{ _token: "{{csrf_token()}}",permission:"{{encrypt(PERMISSION_USER_SUBSCRIPTION_LIST)}}"},
      "dataSrc": function (data) {
        url = '{{ Config::get('production_env.server_url')}}401';
        if(data.code==='401'){
          window.location.href=url;
        }else{
          return data.data;
        }
      }
    },
    columns: [
      {data: 'DT_Row_Index', orderable: false, searchable: false},
      {data: 'id', name: 'id'},
      {data: 'start_date', name: 'start_date'},
      {data: 'end_date', name: 'end_date'},
      {data: 'amount', name: 'amount'},
      {data: 'status', name: 'status'},
      {data: 'active', name: 'active'},
      {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
  });
});</script>
@endpush
