@extends('welcome')
@section('title')
Empty Cart -Frelii
@endsection
@section('content')
@if(Auth::user())
@include('../front/partials/sidenav')
@endif
<!-- BEGIN: Subheader -->
<style media="screen">
  .freicolor{
    color: var(--frelii-color) !important;
  }
</style>
<div class="container" style="padding-top:150px;text-align: center;">
  <div class="section">
    <div class="m-subheader ">
      <div class="d-flex align-items-center">
        <div class="mr-auto">
          <h1 class="freicolor">
            Cart
          </h1>
        </div>
        <div>
        </div>
      </div>
    </div>

    <h3 style="padding-top:15px; !important">There are no items in the cart.</h3>
  </div>
</div>

@endsection
