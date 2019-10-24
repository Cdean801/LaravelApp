<?php

namespace laravelApp\ShoppingCart\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use laravelApp\ShoppingCart\Models\Product;
use laravelApp\ShoppingCart\Models\ProductImage;
use laravelApp\ShoppingCart\Models\Category;
use Image;
use Storage;
use Session;
use laravelApp\ShoppingCart\Models\Cart;
use laravelApp\ShoppingCart\Models\Brand;
use Excel;
use Mixpanel;
use Log;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use laravelApp\ShoppingCart\Models\UsersProfile;
use laravelApp\ShoppingCart\Models\ProductTag;

class ProductController extends Controller
{

  /**
  * Enforce middleware.
  */
  public function __construct()
  {
    // $this->middleware('role:admin', ['only' => ['index', 'create', 'store', 'edit', 'delete']]);
  }

  /**
  * @author : ####
  * Created on : ####
  *
  * Method name: index
  * This method is used to show product create view.
  *
  * @return  view with category list for product create.
  * @exception throw if any error occur when getting the category list for product create.
  */
  public function index() {
    Log::info('Admin::ProductController::index::Start');
    $result = DB::transaction(function () {
      try {
        $categories = Category::where('parent_id',NULL)->get();
        //$producttags = ProductTag::groupBy('name')->get();
        if (null == $categories || "" == $categories) {
          Log::warning('Admin::ProductController::index::' . MAIN_CATEGORY_LIST_EMPTY);
          $data['countryError'] = MAIN_CATEGORY_LIST_EMPTY;
          return view('admin.product.create', $data);
        } else {
          Log::info('Admin::ProductController::index::End');
          $data['categories'] = $categories;
         // $data['producttags'] = $producttags;
          return view('shoppingcart::admin.product.create')->with($data);
        }
      } catch (Exception $ex) {
        Log::error('Admin::ProductController::index::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  public function checkSku(Request $request){
    Log::info('Admin::ProductController::checksku::Start');
    $result = DB::transaction(function () use ($request) {
      try {
        $check=Product::where('sku','=',$request['sku'])->first();
        if ($check != null && $check != "" ) {
          Log::info('Admin::ProductController::checksku::End');
          return Redirect::back()->withErrors(['SKU must be unique']);
        } else {
          Log::info('Admin::ProductController::checksku::End');
          return Response()->json('unique SKU ');
        }
      } catch (Exception $ex) {
        Log::info('Admin::ProductController::checksku::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author : ####
  * Created on : ####
  *
  * Method name: checkEditSku
  * This method is used to check product SKU is not same while edit product.
  *
  * @return message.
  * @exception throw if any error occur when checking product SKU is not same while edit product.
  */
  public function checkEditSku(Request $request){
    Log::info('Admin::ProductController::checkEditSku::Start');
    $result = DB::transaction(function () use ($request) {
      try {
        $id=$request['id'];
        $check=Product::where('sku','=',$request['sku'])->where('id','!=',$id)->first();
        if ($check != null && $check != "" ) {
          Log::info('Admin::ProductController::checkEditSku::End');
          return Redirect::back()->withErrors(['SKU must be unique']);
        } else {
          Log::info('Admin::ProductController::checkEditSku::End');
          return Response()->json('unique SKU ');
        }
      } catch (Exception $ex) {
        Log::info('Admin::ProductController::checkEditSku::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author : ####.
  * Date: ####
  *
  * Method name: create
  * This method is used to create a product.
  *
  * @param  {varchar}  name - Name.
  * @param  {varchar}  description - Description
  * @param  {varchar}  image - Image .
  * @param  {int}  price -  Price.
  * @param  {varchar}  in_stock_quantity - In Stock Quantity .
  * @param  {varchar}  url -  URL.
  * @param  {varchar}  sku-  SKU.
  * @param  {varchar}  stock_status - Stock Status.
  * @param  {varchar}  shipping_weight -  Shipping Weight.
  * @param  {varchar}  shipping_length -  Shipping Length.
  * @param  {varchar}  shipping_width -  Shipping Width.
  * @param  {varchar}  shipping_height -  Shipping Height.
  * @param  {varchar}  category_id - Category Id.
  * @return  Response code,message.
  * @exception throw if any error occur when creating product.
  */
  public function create(Request $request){
    Log::info('Admin::ProductController::create::Start');
    $result = DB::transaction(function () use ($request) {
      try {
        $input = $request->all();
        if (null != $input && "" != $input) {
          $validation = Product::validateProductData($input)->validate();
          // if ($validation != null && $validation != "" && $validation->fails()) {
          //   return $validation;
          // }
          if (array_key_exists('image', $input)) {
            if (null != $input['image'] && "" != $input['image']) {
              $filename = md5(uniqid(rand(), true)) . $request->image->getClientOriginalName();
              $filePath = S3_BUCKET_PRODUCT_IMAGE_URL . $filename;
              Storage::disk('s3')->put($filePath, file_get_contents($input['imgCropped']), 'public');
              $input['image'] = $filename;
            }
          } else {
            $input['image'] = '';
          }
          $data['name'] = $input['name'];
          $data['description'] = $input['description'];
          $data['image'] = $input['image'];
          $data['price'] = $input['price'];
          $data['in_stock_quantity'] = $input['in_stock_quantity'];
          $data['url'] = $input['url'];
          $data['sku'] = $input['sku'];
          $data['active'] = 1;

          if (null!=$input['stock_status'] && ''!=$input['stock_status']) {
            if('Y'==$input['stock_status']){
              $data['stock_status'] = 1;
            }else{
              $data['stock_status'] = 0;
            }
          }
          $data['shipping_weight'] = $input['shipping_weight'];
          $data['shipping_length'] = $input['shipping_length'];
          $data['shipping_width'] = $input['shipping_width'];
          $data['shipping_height'] = $input['shipping_height'];
          if (array_key_exists('sub_category', $input)&& null != $input['sub_category'] && "" != $input['sub_category']) {
            $data['category_id'] = $input['sub_category'];
          }else{
            if (array_key_exists('main_category', $input)){
              $data['category_id'] = $input['main_category'];
            }
          }
          $res = Product::create($data);
          if ($res != null && $res != "") {
            $create_tag['product_id']=$res['id'];
            if(array_key_exists('new_tags',$input) && array_key_exists('tag_id',$input)){
              $tags_array = explode(",", rtrim($input['new_tags'], ','));
              $selected_tags_array= $input['tag_id'];
              $merge=array_merge($tags_array,$selected_tags_array);
              $unique= array_unique(array_map( "strtolower", $merge));
              foreach($unique as $value){
                $create_tag['name']=$value;
                $res = ProductTag::create($create_tag);
                if (null != $res && "" != $res) {
                  Log::info('Admin::ProductController::create::Product tag created successfully');
                }
              }
            }else{
              if(array_key_exists('new_tags',$input) && null!=$input['new_tags'] && ''!=$input['new_tags']){
                $tags_array = explode(",", rtrim($input['new_tags'], ','));
                foreach($tags_array as $value){
                  $create_tag['name']=$value;
                  $res = ProductTag::create($create_tag);
                  if (null != $res && "" != $res) {
                    Log::info('Admin::ProductController::create::Product tag created successfully');
                  }
                }
              }
            }
            //flash(ADMIN_CREATE_PRODUCT_SUCCESS)->success();
            Log::info('Admin::ProductController::create::END');
            return redirect('product/list');
          } else {
            Log::info('Admin::ProductController::create::' . ADMIN_CREATE_PRODUCT_ERROR);
            return Redirect::back()->withErrors([ADMIN_CREATE_PRODUCT_ERROR]);
          }
        } else {
          Log::info('Admin::ProductController::create::' . INPUT_REQUEST_NULL_RESPONSE);
          return Redirect::back()->withErrors([ADMIN_CREATE_PRODUCT_ERROR]);
        }
      } catch (Exception $ex) {
        Log::info('Admin::ProductController::create::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author : ####
  * Created on : ####
  *
  * Method name: paginate
  * This method is used to show view of product list.
  *
  * @return view.
  * @exception throw if any error occur while view of product list.
  */
  public function paginate(Product $model) {
    //return view('shoppingcart::admin.product.list');
    return view('shoppingcart::admin.product.list', ['products' => $model->paginate(15)]);

  }

  /**
  * @author : ####
  * Created on : ####
  *
  * Process datatables ajax request.
  *
  * @return \Illuminate\Http\JsonResponse
  */
  public function anyData() {
    Log::info('Admin::ProductController::anyData::Start');
    $result = DB::transaction(function () {
      try {
        $products= Product::all();
        if (null != $products && "" != $products) {
          foreach ($products as &$value) {
            if ($value['description'] == "" || $value['description'] == null) {
              $value['description'] = 'N.A';
            }
            if ($value['url'] == "" || $value['url'] == null) {
              $value['url'] = 'N.A';
            }
            if ($value['stock_status'] == 1 ) {
              $value['stock_status'] = 'Yes';
            }else{
              $value['stock_status'] = 'No';
            }
          }
          Log::info('Admin::ProductController::anyData::End');
          return Datatables::of($products)
          ->addIndexColumn()
          ->addColumn('action', function ($product) {
            return '<a href="/product/edit/' . $product->id.'/'.encrypt(PERMISSION_PRODUCT_EDIT).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
            <a href="/product/delete/' . $product->id.'/'.encrypt(PERMISSION_PRODUCT_DELETE).'" class="btn btn-xs btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>';
          })->make(true);
        } else {
          Log::info('Admin::ProductController::anyData::' . ADMIN_LIST_RECIPE_ERROR);
          return view('admin.recipe.list')->withErrors([ADMIN_LIST_RECIPE_ERROR]);
        }
      } catch (Exception $ex) {
        Log::info('Admin::ProductController::anyData::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author : ####
  * Created on : ####
  *
  * Process Sub Category ajax request.
  *
  * @return \Illuminate\Http\JsonResponse
  */
  public function getSub(Request $request){
    $result = DB::transaction(function () use($request) {
      try {
        Log::info('Admin::ProductController::getSub::start');
        $subCategory= Category::where('parent_id',$request['main_category'])->get();
        Log::info(count($subCategory));
        if ($subCategory != null && $subCategory != '' && count($subCategory)>0) {
          $data['sub'] = $subCategory;
          Log::info('Admin::ProductController::getSub::END');
          return Response()->json($data);
        } else {
          Log::error('Admin::ProductController::getSub::' . 'Sub category not found');
          return Response()->json('Sub category not found');
        }
      } catch (Exception $ex) {
        Log::error('Admin::ProductController::getSub::' . $ex);
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author : ####
  * Created on : ####
  *
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id) {
    Log::info('Admin::ProductController::edit::Start');
    $result = DB::transaction(function () use ($id) {
      try {
        if (null != $id && '' != $id) {
          $product = Product::where('id', '=', $id)->first();
          $subCategory = Category::where('id', '=', $product['category_id'])->where('parent_id','!=',NULL)->select('id','name','parent_id')->first();
          if(null!=$subCategory && ''!=$subCategory){
            $product['main_category']=$subCategory['parent_id'];
            $product['sub_category']=$subCategory['id'];
          }
          $mainCategory = Category::where('id', '=', $product['category_id'])->where('parent_id','=',NULL)->select('id','name')->first();
          if(null!=$mainCategory && ''!=$mainCategory){
            $product['main_category']=$mainCategory['id'];
          }
          $product_tags=ProductTag::GroupBy('name')->get();
          $select_product_tags=ProductTag::where('product_id',$id)->get();
          $select_product_tags = array_pluck($select_product_tags, 'name');
          if(null!=$product_tags && ''!=$product_tags){
            $product['product_tags']=$product_tags;
            $product['select_product_tags']=$select_product_tags;
          }
          if (null != $product && '' != $product) {
            if (null != $product['image'] && '' != $product['image']) {
              $url = config('production_env.s3_bucket_product_image_url') . $product['image'];
              $singleUrl = explode(', ', $url);
              $newUrl = str_replace("1https:", "https:", $singleUrl[0]);
              $product['image_url'] = $newUrl;
            }
            Log::info('Admin::ProductController::edit::End');
            return view('admin.product.edit', ['product' => $product]);
          } else {
            Log::info('Admin::ProductController::edit::' . ADMIN_EDIT_PRODUCT_ERROR);
            return Redirect::back()->withErrors([ADMIN_EDIT_PRODUCT_ERROR]);
          }
        } else {
          Log::info('Admin::ProductController::edit::' . INPUT_REQUEST_NULL_RESPONSE);
          return Redirect::back()->withErrors([ADMIN_EDIT_PRODUCT_ERROR]);
        }
      } catch (Exception $ex) {
        Log::info('Admin::ProductController::edit::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author : ####
  * Created on : ####
  *
  * Process get Main Category ajax request.
  *
  * @return \Illuminate\Http\JsonResponse
  */
  public function getMainCategory() {
    Log::info('Admin::ProductController::getMainCategory::Start');
    $result = DB::transaction(function () {
      try {
        $countries = Category::where('parent_id',NULL)->get();
        if ($countries == null || $countries == '') {
          Log::error('Admin::ProductController::getMainCategory::' . MAIN_CATEGORY_LIST_EMPTY);
          return Response()->json(MAIN_CATEGORY_LIST_EMPTY);
        } else {
          Log::info('Admin::ProductController::getMainCategory::End');
          return Response()->json($countries);
        }
      } catch (Exception $ex) {
        Log::error('Admin::ProductController::getMainCategory::');
        throw new Exception($ex);
      }
    });
    return $result;
  }


  /**
  * @author : ####
  * Created on : ####
  *
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $product = Product::find($id);
    $images = $product->images()->get();
    $products = Product::where('featured', 1)->where('in_stock_quantity', '>', 1)->with('featured_images')->take(8)->get();
    //  return $images;
    return view('front.product.show',compact('product', 'images', 'products'));
  }

  /**
  * @author : ####
  * Created on : ####
  *
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update($id, Request $request) {
    Log::info('Admin::ProductController::update::Start');
    $result = DB::transaction(function () use ($request, $id) {
      try {
        if (is_null($id) || empty($id)) {
          Log::info('Admin::ProductController::update::' . ADMIN_INPUT_ID_NULL);
          return Redirect::back()->withErrors([ADMIN_INPUT_ID_NULL]);
        }
        $input = $request->all();
        if (null != $input && "" != $input) {
          $validation = Product::validateUpdateProductData($input)->validate();
          if ($validation != null && $validation != "" && $validation->fails()) {
            return $validation;
          }

          if (array_key_exists('new_image', $input)) {
            $old_image = Product::select('image')->find($id);

            $path = config('production_env.s3_bucket_product_image_path_url') . $old_image['image'];
            if (Storage::disk('s3')->exists($path)) {
              Storage::disk('s3')->delete($path);
            }
            if (null != $input['new_image'] && "" != $input['new_image']) {
              $filename = md5(uniqid(rand(), true)) . $request->new_image->getClientOriginalName();
              $filePath = config('production_env.s3_bucket_product_image_path_url') . $filename;
              Storage::disk('s3')->put($filePath, file_get_contents($input['imgCropped']), 'public');
              $data['image'] = $filename;
            }
          }
          $data['name'] = $input['name'];
          $data['description'] = $input['description'];
          $data['price'] = $input['price'];
          $data['in_stock_quantity'] = $input['in_stock_quantity'];
          $data['url'] = $input['url'];
          $data['sku'] = $input['sku'];
          $data['active'] = 1;
          if (null!=$input['stock_status'] && ''!=$input['stock_status']) {
            if('Y'==$input['stock_status']){
              $data['stock_status'] = 1;
            }else{
              $data['stock_status'] = 0;
            }
          }
          $data['shipping_weight'] = $input['shipping_weight'];
          $data['shipping_length'] = $input['shipping_length'];
          $data['shipping_width'] = $input['shipping_width'];
          $data['shipping_height'] = $input['shipping_height'];
          if (array_key_exists('sub_category', $input)&& null != $input['sub_category'] && "" != $input['sub_category']) {
            $data['category_id'] = $input['sub_category'];
          }else{
            if (array_key_exists('main_category', $input)){
              $data['category_id'] = $input['main_category'];
            }
          }
          $res = Product::where('id', $id)->update($data);
          if ($res != null && $res != "") {
            $create_tag['product_id']=$id;
            // if(array_key_exists('tag_id',$input)){
            $selected=ProductTag::where('product_id',$id)->get();
            $selected_tags = array_pluck($selected, 'name');
            // $tags_array = explode(",", rtrim($input['new_tags'], ','));
            // $selected_tags_array= $input['tag_id'];
            // $merge=array_merge($tags_array,$selected_tags_array);
            // $unique= array_unique(array_map( "strtolower", $merge));
            // foreach($unique as $value){
            //   // log::info($value);
            //     // log::info($selected_tags);
            //   if(in_array($value, $selected_tags)){
            //
            //   }else{
            //       log::info($value);
            //     $toDelete = ProductTag::where('product_id',$id)->where('name',$value)->first();
            //     if(null==$toDelete && ''==$toDelete){
            //       $deleted = ProductTag::where('product_id',$id)->where('name',$value)->delete();
            //     }
            //   }
            // }
            // }
            if(array_key_exists('new_tags',$input) && array_key_exists('tag_id',$input)){
              $tags_array = explode(",", rtrim($input['new_tags'], ','));
              $tags_array=array_filter($tags_array);
              $selected_tags_array= $input['tag_id'];
              $selected_tags_array=array_filter($selected_tags_array);
              $merge=array_merge($tags_array,$selected_tags_array);
              $unique= array_unique(array_map( "strtolower", $merge));
              foreach($selected_tags as $value){
                if(in_array($value, $unique,true)){
                  Log::info('Admin::ProductController::update::Tag already exists');
                }else{
                  $deleted = ProductTag::where('product_id',$id)->where('name',$value)->delete();
                  if(null!=$deleted && ''!=$deleted){
                    Log::info('Admin::ProductController::update::Tag deleted successfully');
                  }
                }
              }
              foreach($unique as $value){
                if(in_array($value, $selected_tags,true)){
                }else{
                  $create_tag['name']=$value;
                  $res = ProductTag::create($create_tag);
                  if(null!=$res && ''!=null){
                    Log::info('Admin::ProductController::update::Tag created successfully');
                  }
                }
              }
            }elseif(array_key_exists('new_tags',$input) && null!=$input['new_tags'] && ''!=$input['new_tags']){
              $tags_array = explode(",", rtrim($input['new_tags'], ','));
              foreach($tags_array as $value){
                $create_tag['name']=$value;
                $res = ProductTag::create($create_tag);
                if(null!=$res && ''!=null){
                  Log::info('Admin::ProductController::update::Tag created successfully');
                }
              }
            }else{
              if(null!=$selected && ''!=$selected){
                $ids = array_pluck($selected, 'id');
                $all_deleted=ProductTag::whereIn('id', $ids)->delete();
                if(null!=$all_deleted && ''!=$all_deleted){
                  Log::info('Admin::ProductController::update::All tags deleted successfully');
                }
              }
            }
            flash(ADMIN_UPDATE_PRODUCT_SUCCESS)->success();
            Log::info('Admin::ProductController::update::END');
            return redirect()->route('product.list',['permission' => encrypt(PERMISSION_PRODUCT_LIST)]);
          } else {
            Log::info('Admin::ProductController::update::' . ADMIN_UPDATE_PRODUCT_ERROR);
            return Redirect::back()->withErrors([ADMIN_UPDATE_PRODUCT_ERROR]);
          }
        } else {
          Log::info('Admin::ProductController::update::' . INPUT_REQUEST_NULL_RESPONSE);
          return Redirect::back()->withErrors([ADMIN_UPDATE_PRODUCT_ERROR]);
        }
      } catch (Exception $ex) {
        Log::info('Admin::ProductController::update::');
        throw new Exception($ex);
      }
    });
    return $result;
  }


  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  // public function destroy($id)
  // {
  //   //
  // }
  public function destroy($id) {
    Log::info('Admin::ProductController::destroy::Start');
    $result = DB::transaction(function () use ($id) {
      try {
        if (null != $id && '' != $id) {
          $products= Product::with('order_lines')->find($id);
          if(null!=$products['order_lines'] && ''!=$products['order_lines']&&count($products['order_lines'])>0){
            flash(ADMIN_DELETE_PRODUCT_ASSIGN_ORDER)->error();
            Log::info('Admin::ProductController::destroy::'.ADMIN_DELETE_PRODUCT_ASSIGN_ORDER);
            return redirect()->route('product.list',['permission' => encrypt(PERMISSION_PRODUCT_LIST)]);
          }
          $old_image = Product::select('image')->find($id);
          $deleteTags = ProductTag::where('product_id', $id)->delete();
          if(null != $deleteTags && '' != $deleteTags){
            $delete = Product::where('id', $id)->delete();
            if (null != $delete && '' != $delete) {
              if (null != $old_image && "" != $old_image) {
                if (null != $old_image['image'] && "" != $old_image['image']) {
                  $path = S3_BUCKET_PRODUCT_IMAGE_URL . $old_image['image'];
                  if (Storage::disk('s3')->exists($path)) {
                    Storage::disk('s3')->delete($path);
                  }
                }
              }
              flash(ADMIN_DELETE_PRODUCT_SUCCESS)->success();
              Log::info('Admin::ProductController::destroy::End');
              return redirect()->route('product.list',['permission' => encrypt(PERMISSION_PRODUCT_LIST)]);
            } else {
              Log::info('Admin::ProductController::destroy::' . ADMIN_DELETE_PRODUCT_ERROR);
              return Redirect::back()->withErrors([ADMIN_DELETE_PRODUCT_ERROR]);
            }
          }else{
            Log::info('Admin::ProductController::destroy::' . ADMIN_DELETE_PRODUCT_TAGS_ERROR);
            return Redirect::back()->withErrors([ADMIN_DELETE_PRODUCT_TAGS_ERROR]);
          }
        } else {
          Log::info('Admin::ProductController::destroy::' . INPUT_REQUEST_NULL_RESPONSE);
          return Redirect::back()->withErrors([ADMIN_DELETE_PRODUCT_ERROR]);
        }
      } catch (Exception $ex) {
        Log::info('Admin::ProductController::destroy::');
        throw new Exception($ex);
      }
    });
    return $result;
  }


  // public function display_import() {
  //   return view ('admin.product.import');
  // }

  // public function import(Request $request) {
  //
  //   $request->validate([
  //     'imported-file' => 'required',
  //   ]);
  //   if($request->file('imported-file'))
  //   {
  //     $path = $request->file('imported-file')->getRealPath();
  //     $data = Excel::load($path, function($reader) {
  //       $reader->ignoreEmpty();
  //     })->get();
  //     if(!empty($data) && $data->count())
  //     {
  //       $data = $data->toArray();
  //       foreach($data as $product )
  //       {
  //         //If SKU is missing in this row of file skip to next iteration
  //         if ( $product['sku'] == null ) { continue; }
  //         $model = Product::firstOrNew(array('sku' => $product['sku']));
  //         //Create new Product Object and Save it
  //         $model->name = $product['name'];
  //         $model->description = $product['description'];
  //         $model->sku = $product['sku'];
  //         $model->active = $product['active'];
  //         $model->sale_price = $product['sale_price'];
  //         $model->regular_price = $product['sale_price'];
  //         $model->in_stock_quantity = $product['in_stock_quantity'];
  //         $model->featured = $product['featured'];
  //         $model->reward_points = $product['reward_points'];
  //
  //
  //         $brand = Brand::firstOrNew(array('name' => $product['brand']));
  //         $brand->name = $product['brand'];
  //         $brand->active = 1;
  //         $brand->save();
  //
  //         $model->brand_id = $brand->id;
  //         $model->tax = $product['tax'];
  //         $model->size = $product['size'];
  //         $model->size_unit = $product['size_unit'];
  //         $model->save();
  //
  //         $category = Category::firstOrNew(array('name' => $product['category']));
  //         $category->name = $product['category'];
  //         $category->active = 1;
  //         $category->save();
  //
  //         //ADD CATEGORY IF ITN'T ALREADY THERE
  //         if (! $model->categories->contains($category->id)) {
  //           $model->categories()->attach($category);
  //         }
  //         $model->searchable();
  //
  //       }
  //     }
  //     //  Product::insert($dataImported);
  //   }
  //   // return redirect()->route('products.index')
  //   // ->with('success','Product imported successfully');
  // }

  // public function downloadTemplate()
  // {
  //   $data = Product::where('featured', 1)->take(1)->get();
  //   return Excel::create('products_template', function($excel) use ($data) {
  //     $excel->sheet('mySheet', function($sheet) use ($data)
  //     {
  //       $sheet->fromArray($data);
  //     });
  //   })->download('xls');
  // }
  //

  /**
  * @author : ####
  * Created on : ####
  *
  * Get the data of specified product.
  *
  * @param  int  id - product id
  * @return \Illuminate\Http\Response
  */
  public function getproductDiscription(Request $request,$id) {
    Log::info('Admin::ProductController::getproductDiscription::Start');
    $result = DB::transaction(function () use($request,$id){
      try {
        if(null==$id || ''==$id){
          Log::info('Admin::ProductController::getproductDiscription::' . ADMIN_DELETE_PRODUCT_ERROR);
          return Redirect::back()->withErrors([ADMIN_DELETE_PRODUCT_ERROR]);
        }
        $product = Product::where('id',$id)->first();
        $category = Category::where('id',$product['category_id'])->first();
        if(null==$product || ''==$product){
          Log::info('Admin::ProductController::getproductDiscription::' . ADMIN_DELETE_PRODUCT_ERROR);
          return view('401');
        }
        $productImages = explode(", ", $product->image);
        $product->image =$productImages[0];
        $data['product'] = $product;
       //var_dump($product);
       // exit;
        $data['category'] = $category;
        return view('front.product.description', ['product' => $product, 'category' => $category]);//->with($data);
      } catch (Exception $ex) {
        Log::info('Admin::ProductController::getproductDiscription::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  public function getproductListSearchData(Request $request) {
    Log::info('Admin::ProductController::getproductListSearchData::Start');
    $result = DB::transaction(function () use($request){
      try {
        $products = Product::where('in_stock_quantity','>',0);
        $countPro = $products->count();
        $filter = $request->filter;
        if($request->catFilter){
          $catFilter = $request->catFilter;
          $categories = Category::where('parent_id', $catFilter)->get()->pluck('id')->toArray();
          array_push($categories,$catFilter);
          $products = $products->whereIn('category_id',$categories);
        }
        if($request->tagFilter){
          $tagFilter = $request->tagFilter;
          $products = $products->whereHas('tags', function ($query) use($tagFilter){
            $query->where('name', $tagFilter);
          });
        }
        if($request->priceFilter){
          $priceFilter = explode(',', $request->priceFilter);
          $products = $products->whereBetween('price',$priceFilter);
        }
        $products = $products->where('name', 'like', '%' .$request->filter . '%')->paginate(9);
        Log::info('Admin::ProductController::getproductListSearchData::End');
        return view('front.product.product-filter-list', compact('products','filter','countPro'));
      } catch (Exception $ex) {
        Log::info('Admin::ProductController::getproductListSearchData::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  public function getproductListFilterData(Request $request) {
    Log::info('Admin::ProductController::getproductListFilterData::Start');
    $result = DB::transaction(function () use($request){
      try {
        $input = $request->all();
        $products = Product::where('in_stock_quantity','>',0);
        $countPro = $products->count();
        $name="Products";
        $catName= '';
        if(null!=$input && ''!=$input){
          if(!$request->priceFilter && !$request->tagFilter && $request->catFilter){
            $name="Products";
            $filter = '';
            $catFilter = '';
            $tagFilter = '';
            $priceFilter = '';
          }
          if($request->catFilter){
            $catFilter = $request->catFilter;
            $catName = Category::select('name')->find($catFilter);
            if(null!=$catName && ''!=$catName){
              $name = $catName->name;
              $catName = $name;
            }else{
              $name="Products";
            }
            $categories = Category::where('parent_id', $catFilter)->get()->pluck('id')->toArray();
            array_push($categories,$catFilter);
            $products = $products->whereIn('category_id',$categories);
          }else{
            $catFilter = '';
          }
          if($request->tagFilter){
            // $status = 'tag';
            $tagFilter = $request->tagFilter;
            $filter = $request->tagFilter;
            $name = $filter;
            $category = Category::where('parent_id', null)->get();
            $products = $products->whereHas('tags', function ($query) use($name){
              $query->where('name', $name);
            });
          }
          else{
            $tagFilter = '';
          }
          if($request->priceFilter){
            $name="Products";
            $priceFilter = $request->priceFilter;
            $filter = $priceFilter;
            $filter = explode(',', $filter);
            $products = $products->whereBetween('price',$filter);
          }
          else{
            $priceFilter = '';
          }
        }else{
          $name="Products";
          $filter = '';
          $tagFilter = '';
          $priceFilter = '';
          $catFilter = '';
          $catName='';
        }
        $products = $products->paginate(9);
        if(count($products)>0){
          $min = $products->getCollection()->min('price');
          $minRange = floor($min / 10) * 10;
          $max = $products->getCollection()->max('price');
          $maxRange = ceil($max / 10) * 10;
          $priceFilterRange="$minRange,$maxRange";
        }else{
          $priceFilterRange='';
        }
        $category = Category::where('parent_id', null)->get();
        $productTags = ProductTag::select('name')->distinct()->get()->pluck('name');
        //print_r($products->getCollection()->);
       $products->each(function ($item, $key) {
         // var_dump($item['image']);
         if($item["image"] != ""){
            $productImages = explode(", ", $item['image']);
            $item['image'] = $productImages[0];
         }
        });
        $productData = $products->toArray();
        foreach($productData['data'] as  $key => $value){
          //var_dump($value['image']);
          $productImages = explode(", ", $value['image']);
          $productData['data'][$key]['image']= $productImages[0];
        }
        //$products = collect($productData);

        Log::info('Admin::ProductController::getproductListFilterData::End');
        return view('front.product.product-list', compact('products','category','name','filter','productTags','catFilter','tagFilter','priceFilter','countPro','priceFilterRange','catName'));
      } catch (Exception $ex) {
        Log::info('Admin::ProductController::getproductListFilterData::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

}
