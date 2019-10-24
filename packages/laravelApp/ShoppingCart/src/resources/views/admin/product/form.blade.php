    <div class="m-portlet__body">
      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Name
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
          {!! Form::text('name', $product->name, ['class' => 'form-control m-input']) !!}
        </div>
      </div>
      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Description
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
          {!! Form::textarea('description', $product->description, ['class' => 'form-control m-input', 'placeholder' => 'Please enter description.']) !!}
        </div>
      </div>
      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          SKU
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
          {!! Form::text('sku', $product->sku, ['class' => 'form-control m-input']) !!}
        </div>
      </div>

      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Size (ex. 2.2)
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
          {!! Form::text('size', $product->size, ['class' => 'form-control m-input']) !!}
        </div>
      </div>

      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Size Unit (ex. LB)
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
          {!! Form::text('size_unit', $product->size_unit, ['class' => 'form-control m-input']) !!}
        </div>
      </div>

      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          In Stock Quantity
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            {!! Form::number('in_stock_quantity', $product->in_stock_quantity, ['class' => 'form-control m-input', 'placeholder' => 'Enter in stock quantity.']) !!}

        </div>
      </div>

      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Regular Price
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            {!! Form::number('regular_price', $product->regular_price, ['class' => 'form-control m-input', 'step'=>'any']) !!}
        </div>
      </div>

      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Sale Price
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            {!! Form::number('sale_price', $product->sale_price, ['class' => 'form-control m-input', 'step'=>'any']) !!}
        </div>
      </div>

      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Reward Points
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            {!! Form::number('reward_points', $product->reward_points, ['class' => 'form-control m-input', 'step'=>'any']) !!}
        </div>
      </div>

      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Tax %
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            {!! Form::number('tax', $product->tax, ['class' => 'form-control m-input', 'step'=>'any']) !!}
        </div>
      </div>

      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Featured Product?
        </label>
        <div class="col-lg-1 col-md-1 col-sm-1">
          {!! Form::checkbox('featured', true, false, ['class' => 'form-control m-input']) !!}
        </div>
      </div>


      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Active
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            {!! Form::select('active', array('1' => 'Yes', '0' => 'No'), $product->active, ['class' => 'form-control m-input']) !!}

        </div>
      </div>

      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Brand
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
          <select name="brand_id" class="form-control">
              @if (!isset($product_brand))
                <option value="" selected disabled style="display:none">Select a Brand</option>
              @endif

              @foreach ($brands as $brand)
              @if ($product->brand_id === $brand->id)
                <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
              @else
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
              @endif

              @endforeach
          </select>
        </div>
      </div>

      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Category
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
          <select name="category_id" class="form-control">
              <option value="" selected disabled style="display:none">Add a Category</option>
              @foreach ($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
          </select>
        </div>
      </div>

      @if (isset($product_categories))
      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Already Added Category
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
              @foreach ($product_categories as $category)
                <a  href="{{ URL::route('products.remove_category', ['product_id' => $product->id, 'category_id' => $category->id]) }}">
                  <button type="button" class="secondary-btn">
															{{$category->name}}
									</button>
                </a>
              @endforeach
        </div>
      </div>
      @endif

      <h3 align="center">Upload Image</h3>
      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          File
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
          {!! Form::file('image', ['class' => 'form-control m-input']) !!}
        </div>
      </div>
      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Alt Text
        </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
          {!! Form::text('alt_text', '', ['class' => 'form-control m-input']) !!}
        </div>
      </div>
      <div class="form-group m-form__group row">
        <label class="col-form-label col-lg-3 col-sm-12">
          Featured Image
        </label>
        <div class="col-lg-1 col-md-1 col-sm-1">
          {!! Form::checkbox('featured_image', true, false, ['class' => 'form-control m-input']) !!}
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
  <h3 formnovalidate=""align="center"> Existing Images </h3>
    <div class="row">
      @foreach ($images as $image)
      <div class="col-xl-3">
        <!--begin:: Widgets/Blog-->
        <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height ">
          <div class="m-portlet__head m-portlet__head--fit">
            <div class="m-portlet__head-caption">

            </div>
          </div>
          <div class="m-portlet__body">
            <div class="m-widget19">
              <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides" style="min-height-: 286px">
                <img src={!! '/storage/product_images/' . $product->id . '/' . $image->path !!} height="300" width="300">
                <div class="m-widget19__shadow"></div>
              </div>

              <div class="m-widget19__action">
                <button type="button" class="secondary-btn">
                  Remove
                </button><br>
                @unless(!$image->featured)
                          <h4>Featured</h4>
                          @endunless
              </div>
            </div>
          </div>
        </div>
        <!--end:: Widgets/Blog-->
      </div>
      @endforeach


    </div>
