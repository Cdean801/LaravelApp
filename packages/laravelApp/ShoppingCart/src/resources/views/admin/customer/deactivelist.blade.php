<!-- BEGIN: Subheader -->
@extends('welcome')
@section('title')
View Customers - Frelii
@endsection

@section('content')
@include('../front/partials/sidenav')
<link href="{{ asset('css/admin/category/category.css') }}" rel="stylesheet" type="text/css"/>
<style>
.row {
  margin-right: 0% !important;
    margin-left: 0% !important;
}
</style>
<div class="container category-list-container-style">
  <div class="section">
    <div class="row">
      <div class="col-md-2">
      </div>
      <div class="col-md-8">
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
        <h1 class="list-category-heading-color">All Deactivated Customers</h1>
        <div class="table-responsive">
          <table class="table table-bordered text-center" id="customers-table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email Id</th>
                <th>Phone Number</th>
                <th>Action</th>
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
  $('#customers-table').DataTable({
    processing: true,
    serverSide: true,
    ajax:{
      "url": "/customer/deactivated-datatable",
      "dataType": "json",
      "type": "POST",
      "data":{ _token: "{{csrf_token()}}",permission:"{{encrypt(CUSTOMER_DEACTIVE_PERMISSION)}}"},
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
      {data: 'name', name: 'name'},
      {data: 'email', name: 'email'},
      {data: 'phone', name: 'phone'},
      {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
  });
});</script>
@endpush
