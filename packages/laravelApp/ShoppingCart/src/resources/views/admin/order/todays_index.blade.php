@extends('welcome')
@section('title')
    SaneCart - Admin - Orders
@endsection


@section('content')
<!-- BEGIN: Subheader -->
<div class="container">
  <div class="section">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <h2 class="m-portlet__head-text">
                Today's Order
              </h2>
            </div>
          </div>
        </div>
<!-- END: Subheader -->
    <table class="table table-bordered" id="todays_orders_table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Delivery Date</th>
                <th>Delivery Time</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
<h1></h1>
</div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#todays_orders_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('orders.admin_todays_index_data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'slot_date', name: 'slot_date' },
            { data: 'slot', name: 'slot' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
@endpush
