@extends('welcome')
@section('title')
    SaneCart - Admin - Products
@endsection


@section('content')
@include('../front/partials/sidenav')
<!-- BEGIN: Subheader -->
<div class="container">
  <div class="section">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <h2 class="m-portlet__head-text">
                Products
              </h2>
            </div>
          </div>
        </div>
      <table class="table table-bordered" id="products-table">
          <thead>
              <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>SKU</th>
                  <th>Sale Price</th>
                  <th>Regular Price</th>
                  <th>Actions</th>
              </tr>
          </thead>
      </table>
    <h1></h1>
    <a href="products/create" class="primary-btn">Add New Product</a>
    <a href="products/display_import" class="primary-btn">Import Products</a>

    <a href="categories" class="primary-btn">Categories</a>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('products.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'sku', name: 'sku' },
            { data: 'sale_price', name: 'sale_price' },
            { data: 'regular_price', name: 'regular_price' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
@endpush
