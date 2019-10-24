@extends('welcome')
@section('title')
    SaneCart - Admin - Brands
@endsection


@section('content')
<!-- BEGIN: Subheader -->
<div class="container">
  <div class="section">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <h2 class="m-portlet__head-text">
                Brands
              </h2>
            </div>
          </div>
        </div>
<!-- END: Subheader -->
    <table class="table table-bordered" id="brands-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
<h1></h1>
<a href="brands/create" class="primary-btn">Add New Brand</a>
</div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#brands-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('brands.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'active', name: 'active' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
@endpush
