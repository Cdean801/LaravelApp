<!-- BEGIN: Subheader -->
@extends('welcome')
@section('title')
View Orders - Frelii
@endsection

@section('content')
@include('../front/partials/sidenav')
<link href="{{ asset('css/admin/exercise_video/exercise_video.css') }}" rel="stylesheet" type="text/css"/>
<style>
.row {
  margin-right: 0% !important;
  margin-left: 0% !important;
}
@media only screen and (max-width: 768px) {
.responsive-container-style{
  padding-top: 100px;
}
}
</style>
<div class="exercise-video-container-style responsive-container-style">
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
        <h1 class="exercise-video-heading-color">View All Orders</h1>
        <div class="table-responsive">
          <table class="table table-bordered text-center" id="orders-table">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Order Id</th>
                <th class="text-center">User</th>
                <th class="text-center">Date</th>
                <th class="text-center">Status</th>
                <th class="text-center">Total($)</th>
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
$(document).ready(function() {
  $('#orders-table').DataTable({
    processing: true,
    serverSide: true,
    ajax:{
      "url": "/orders/datatable",
      "dataType": "json",
      "type": "POST",
      "data":{ _token: "{{csrf_token()}}",permission:"{{encrypt(ORDER_LIST_PERMISSION)}}"},
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
      {data: 'date', name: 'date'},
    //   {data: 'date', name: 'date',type : 'date',render: function (value) {
    //     if (value === null) return "";
    //     return window.moment(value).format('MMMM, D YYYY');
    //   }
    // },
    {data: 'status', name: 'status'},
    {data: 'amount', name: 'amount'},
    {data: 'action', name: 'action', orderable: false, searchable: false}
  ]
  // ,"order": [[ 3, "asc" ]]
});
});</script>
@endpush
