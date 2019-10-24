<div class="m-portlet__body">

  <div class="form-group m-form__group row">
    <label class="col-form-label col-lg-3 col-sm-12">
      Name
    </label>
    <div class="col-lg-4 col-md-9 col-sm-12">
      {!! Form::text('name', $brand->name, ['class' => 'form-control m-input']) !!}
    </div>
  </div>
  <div class="form-group m-form__group row">
    <label class="col-form-label col-lg-3 col-sm-12">
      Active
    </label>
    <div class="col-lg-4 col-md-9 col-sm-12">
        {!! Form::select('active', array('1' => 'Yes', '0' => 'No'), $brand->active, ['class' => 'form-control m-input']) !!}

    </div>
  </div>
  <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space"></div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
  <div class="m-form__actions m-form__actions">
    <div class="row">
      <div class="col-lg-9 ml-lg-auto">
        <button type="submit" class="primary-btn">
          Submit
        </button>
      </div>
    </div>
  </div>
</div>
<!--end::Form-->
