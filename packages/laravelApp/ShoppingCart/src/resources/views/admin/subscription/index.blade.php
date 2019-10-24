@extends('welcome')
@section('title')
View Orders - Frelii
@endsection

@section('content')
@include('../front/partials/sidenav')
<link href="{{ asset('css/admin/subscription/index.css') }}" rel="stylesheet" type="text/css"/>
<div class="exercise-video-container-style" style ="margin-top:10%;">
  <div class="section">
    <div class="row">
      <div class="col-md-2">
      </div>
      <div class="col-md-8">

        <h1 class="exercise-video-heading-color">View All Subscriptions</h1>
        <div class="table-responsive">
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
        @if ($message = Session::get('success'))
          <div class="alert alert-success alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>{{ $message }}</strong>
          </div>
          @endif
          <table class="table table-bordered text-center" id="subscriptions-table">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Subscription Id</th>
                <th class="text-center">User</th>
                <th class="text-center">Start Date</th>
                <th class="text-center">End Date</th>
                <th class="text-center">amount</th>
                <th class="text-center">Status</th>
                <th class="text-center">Message</th>
                <th class="text-center">Invoice No</th>
                <th class="text-center">Auth No</th>
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
  $('#subscriptions-table').DataTable({
    processing: true,
    serverSide: true,
    ajax:{
      "url": "/subscriptions/datatable",
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
      {data: 'user_name', name: 'user_name'},
      {data: 'start_date', name: 'start_date'},
      {data: 'end_date', name: 'end_date'},
      {data: 'amount', name: 'amount'},
      {data: 'status', name: 'status'},
      {data: 'message', name: 'message'},
      {data: 'invoice_number', name: 'invoice_number'},
      {data: 'auth_number', name: 'auth_number'},
      {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
    ,"order": [[ 3, "asc" ]]
  });
});</script>
@endpush
