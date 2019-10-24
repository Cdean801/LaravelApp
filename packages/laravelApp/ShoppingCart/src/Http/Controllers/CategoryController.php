<?php

namespace laravelApp\ShoppingCart\Http\Controllers;


use laravelApp\ShoppingCart\Models\Category;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Log;
use DB;
use laravelApp\ShoppingCart\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;


/**
 * @author : ####
 * Created on : ####
 *
 * Class name: CategoryController
 * Create a class for CategoryController controller.
 */
class CategoryController extends Controller {

  /**
   * @author : ####.
   * Date: ####
   *
   * Method name: index
   * This method is used for view all categories.
   *
   * @return  category list,Response code,message.
   * @exception throw if any error occur when getting category's list.
   */
    public function index(Category $model) {
        // Log::info('Admin::CategoryController::index::Start');
        // $result = DB::transaction(function () {
        //             try {
        //                 Log::info('Admin::CategoryController::index::End');
        //                 return view('shoppingcart::shoppingcart::admin.category.index');
        //             } catch (Exception $ex) {
        //                 Log::info('Admin::CategoryController::index::');
        //                 throw new Exception($ex);
        //             }
        //         });
        // return $result;
        return view('shoppingcart::admin.category.index', ['categorys' => $model->paginate(15)]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData() {
        Log::info('Admin::CategoryController::anyData::Start');
        $result = DB::transaction(function () {
                    try {
                        $categories = Category::where('parent_id', null)->select(['id', 'name']);
                        if(null != $categories || '' != $categories) {
                          return Datatables::of($categories)
                            ->addIndexColumn()
                                          ->addColumn('action', function ($category) {
                                              Log::info('Admin::CategoryController::anyData::End');
                                              return '<a href="/categories/edit/' . $category->id .'/'.encrypt(CATEGORY_EDIT_PERMISSION).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                                          })->make(true);
                        } else {
                          Log::info('Admin::RecipeController::create::' . ADMIN_LIST_CATEGORY_ERROR);
                          return view('shoppingcart::admin.recipe.list')->withErrors([ADMIN_LIST_CATEGORY_ERROR]);
                        }
                    } catch (Exception $ex) {
                        Log::info('Admin::CategoryController::anyData::');
                        throw new Exception($ex);
                    }
                });
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // $category = New Category;
        // $categories = $category::where('parent_id' , null)->select('id','name')->get();
        // return view('shoppingcart::admin.category.create', ['category' => $category, 'categories' => $categories]);
        Log::info('Admin::CategoryController::create::Start');
        $result = DB::transaction(function () {
                    try {
                        $category = New Category;
                        $categories = $category::where('parent_id', null)->select('id', 'name')->get();
                        Log::info('Admin::CategoryController::create::End');
                        return view('shoppingcart::admin.category.create', ['category' => $category, 'categories' => $categories]);
                    } catch (Exception $ex) {
                        Log::info('Admin::CategoryController::create::');
                        throw new Exception($ex);
                    }
                });
        return $result;
    }

    /**
     * @author : ####.
     * Date: ####
     *
     * Method name: store
     * This method is used for create category.
     *
     * @param  {varchar}  name -  name.
     * @param  {varchar} category type - category type.
     * @param  {varchar} patent_id - parent id.
     * @return  Response code,message.
     * @exception throw if any error occur when creating category.
     */
    public function store(Request $request) {
        // $request->validate([
        //     'name' => 'required',
        //     'active' => 'required',
        // ]);
        // $category = Category::create($request->all());
        // return redirect()->route('categories.index')
        //                 ->with('success','Category created successfully');

        Log::info('Admin::CategoryController::store::Start');
        $result = DB::transaction(function () use ($request) {
                    try {
                        $input = $request->all();
                        if (null != $input && "" != $input) {
                            $validation = Category::validateCategory($input);
                            if ($validation != null && $validation != "" && $validation->fails()) {
                                $breakline = $validation->messages()->all();
                                $message = implode(",", $breakline);
                                Log::warning('Admin::CategoryController::store::' . $message);
                                $error['message'] = $message;
                                return response()->json($error);
                            }
                            $data['name'] = $input['name'];
                            if (isset($input['selectCategory'])) {
                                $data['parent_id'] = $input['selectCategory'];
                            }
                            $res = Category::create($data);
                            if ($res != null && $res != "") {
                                //flash(CATEGORY_CREATE_SUCCESS)->success();
                                Log::info('Admin::CategoryController::store::END');
                                return redirect('Category/success-create');
                            } else {
                                Log::info('Admin::CategoryController::store::' . CREATE_CATEGORY_ERROR);
                                return Redirect::back()->withErrors([CREATE_CATEGORY_ERROR]);
                            }
                        } else {
                            Log::info('Admin::CategoryController::store::' . INPUT_REQUEST_NULL_RESPONSE);
                            return Redirect::back()->withErrors([INPUT_REQUEST_NULL_RESPONSE]);
                        }
                    } catch (Exception $ex) {
                        Log::info('Admin::CategoryController::store::');
                        throw new Exception($ex);
                    }
                });
        return $result;
    }

    /**
     * @author : ####
     * Date: ####
     *
     * Method name: edit
     * This method is used for show the detail of category.
     *
     * @param  {integer} id-category id.
     * @return  details of the category,Response code,message.
     * @exception throw if any error occur when getting the details of the category.
     */
    public function edit($id) {
        // $category = Category::find($id);
        //  Log::info($category);
        // return view('shoppingcart::admin.category.edit',compact('category'));

        Log::info('Admin::CategoryController::edit::Start');
        $result = DB::transaction(function () use($id) {
                    try {
                        $category = Category::where('parent_id', null)->find($id);
                        $categories = Category::where('parent_id', $id)->select('id', 'name')->get();
                        return view('shoppingcart::admin.category.edit', ['category' => $category, 'categories' => $categories]);
                    } catch (Exception $ex) {
                        Log::info('Admin::CategoryController::edit::');
                        throw new Exception($ex);
                    }
                });
        return $result;
    }

    /**
     * @author : ####.
     * Date: ####
     *
     * Method name: update
     * This method is used for update main category.
     *
     * @param  {varchar}  name -  name.
     * @param {int} id - id
     * @return  Response code,message.
     * @exception throw if any error occur when creating category.
     */
    public function update(Request $request, $id) {
        // $request->validate([
        //     'name' => 'required',
        //     'active' => 'required',
        // ]);
        // Category::find($id)->update($request->all());
        // return redirect()->route('categories.index')
        //                   ->with('success','Categorytem updated successfully');

        Log::info('Admin::CategoryController::update::Start');
        $result = DB::transaction(function () use ($request, $id) {
                    try {
                        if (is_null($id) || empty($id)) {
                            Log::info('Admin::CategoryController::edit::' . ADMIN_UPDATE_CATEGORY_ERROR);
                            return Redirect::back()->withErrors([ADMIN_UPDATE_CATEGORY_ERROR]);
                        }
                        $input = $request->all();
                        if (null != $input && "" != $input) {
                            $validation = Category::validateUpdateCategory($input);
                            if ($validation != null && $validation != "" && $validation->fails()) {
                                $breakline = $validation->messages()->all();
                                $message = implode(",", $breakline);
                                Log::warning('Admin::CategoryController::update::' . $message);
                                $error['message'] = $message;
                                return response()->json($error);
                            }
                            $data['name'] = $input['name'];
                            $res = Category::find($id)->update($data);
                            if ($res != null && $res != "") {
                                flash(CATEGORY_UPDATE_SUCCESS)->success();
                                Log::info('Admin::CategoryController::update::END');
                                return response()->json(['msg' => CATEGORY_UPDATE_SUCCESS, 'code' => 200]);
                            } else {
                                flash(ADMIN_UPDATE_CATEGORY_ERROR)->error();
                                Log::info('Admin::CategoryController::update::' . ADMIN_UPDATE_CATEGORY_ERROR);
                                return response()->json(['msg' => ADMIN_UPDATE_CATEGORY_ERROR, 'code' => 422]);
                            }
                        } else {
                            flash(ADMIN_UPDATE_CATEGORY_ERROR)->error();
                            Log::info('Admin::CategoryController::update::' . INPUT_REQUEST_NULL_RESPONSE);
                            return response()->json(['msg' => INPUT_REQUEST_NULL_RESPONSE, 'code' => 422]);
                        }
                    } catch (Exception $ex) {
                        Log::info('Admin::CategoryController::store::');
                        throw new Exception($ex);
                    }
                });
        return $result;
    }

    /**
     * @author : ####.
     * Date: ####
     *
     * Method name: updateSubCategory
     * This method is used for update sub category.
     *
     * @param  {varchar}  name -  name.
     * @param {int} id - id
     * @return  Response code,message.
     * @exception throw if any error occur when creating category.
     */
    public function updateSubCategory(Request $request, $id) {
        Log::info('Admin::CategoryController::update::Start');
        $result = DB::transaction(function () use ($request, $id) {
                    try {
                        if (is_null($id) || empty($id)) {
                            Log::info('Admin::RecipeController::edit::' . ADMIN_UPDATE_CATEGORY_ERROR);
                            return Redirect::back()->withErrors([ADMIN_UPDATE_CATEGORY_ERROR]);
                        }
                        $input = $request->all();
                        if (null != $input && "" != $input) {
                            $validation = Category::validateUpdateCategory($input);
                            if ($validation != null && $validation != "" && $validation->fails()) {
                                $breakline = $validation->messages()->all();
                                $message = implode(",", $breakline);
                                Log::warning('Admin::CategoryController::update::' . $message);
                                $error['message'] = $message;
                                return response()->json(['msg' => $message, 'code' => 422]);
                            }
                            $data['name'] = $input['name'];
                            $res = Category::find($id)->update($data);
                            if ($res != null && $res != "") {
                                flash(CATEGORY_UPDATE_SUCCESS)->success();
                                Log::info('Admin::CategoryController::update::END');
                                return response()->json(['msg' => CATEGORY_UPDATE_SUCCESS, 'code' => 200]);
                            } else {
                                flash(ADMIN_UPDATE_CATEGORY_ERROR)->error();
                                Log::info('Admin::CategoryController::update::' . ADMIN_UPDATE_CATEGORY_ERROR);
                                return response()->json(['msg' => ADMIN_UPDATE_CATEGORY_ERROR, 'code' => 422]);
                            }
                        } else {
                            flash(ADMIN_UPDATE_CATEGORY_ERROR)->error();
                            Log::info('Admin::CategoryController::update::' . INPUT_REQUEST_NULL_RESPONSE);
                            return response()->json(['msg' => INPUT_REQUEST_NULL_RESPONSE, 'code' => 422]);
                        }
                    } catch (Exception $ex) {
                        Log::info('Admin::CategoryController::store::');
                        throw new Exception($ex);
                    }
                });
        return $result;
    }

    /**
     * @author : ####.
     * Date: ####
     *
     * Method name: destroy
     * This method is used for delete the main category and also sub category.
     *
     * @param  {integer} id- category's id.
     * @return Response code,message.
     * @exception throw if any error occur when deactivate the category.
     */
    public function destroy($id) {
        Log::info('Admin::CategoryController::destroy::Start');
        $result = DB::transaction(function () use ($id) {
                    try {
                        if (null != $id && '' != $id) {
                            $productData = Product::where('category_id', $id)->select('category_id')->first();
                            if (null == $productData || '' == $productData) {
                                $subCategory = Category::where('parent_id', $id)->select('id')->get();
                                $totalSubCategory = $subCategory->count();
                                if ($totalSubCategory == 0) {
                                        $delete = Category::find($id)->delete();
                                        if (null != $delete && '' != $delete) {
                                            flash(CATEGORY_DELETE_SUCCESS)->success();
                                            Log::info('Admin::CategoryController::destroy::End');
                                            return response()->json(['msg' => CATEGORY_DELETE_SUCCESS, 'code' => 200]);
                                        } else {
                                            flash(ADMIN_DELETE_CATEGORY_ERROR)->error();
                                            Log::info('Admin::CategoryController::destroy::' . ADMIN_DELETE_CATEGORY_ERROR);
                                            return response()->json(['msg' => ADMIN_DELETE_CATEGORY_ERROR, 'code' => 422]);
                                        }
                                } else {
                                  foreach ($subCategory as $value) {
                                      $subId = $value['id'];
                                      $productDataForSub = Product::where('category_id', $subId)->select('category_id')->first();
                                  }
                                    if (null == $productDataForSub || '' == $productDataForSub) {
                                      foreach ($subCategory as $value) {
                                          $subId = $value['id'];
                                          $delete = Category::where('id', $subId)->delete();
                                      }
                                      $delete = Category::find($id)->delete();
                                      if (null != $delete && '' != $delete) {
                                          flash(CATEGORY_DELETE_SUCCESS)->success();
                                          Log::info('Admin::CategoryController::destroy::End');
                                          return response()->json(['msg' => CATEGORY_DELETE_SUCCESS, 'code' => 200]);
                                      } else {
                                          flash(ADMIN_DELETE_CATEGORY_ERROR)->error();
                                          Log::info('Admin::CategoryController::destroy::' . ADMIN_DELETE_CATEGORY_ERROR);
                                          return response()->json(['msg' => ADMIN_DELETE_CATEGORY_ERROR, 'code' => 422]);
                                      }
                                    } else {
                                      flash(ADMIN_DELETE_CATEGORY_ERROR_WHILE_PRODUCT_ADDED)->error();
                                      Log::info('Admin::CategoryController::destroy::' . ADMIN_DELETE_CATEGORY_ERROR);
                                      return response()->json(['msg' => ADMIN_DELETE_CATEGORY_ERROR, 'code' => 422]);
                                    }
                                }
                            } else {
                                flash(ADMIN_DELETE_CATEGORY_ERROR_WHILE_PRODUCT_ADDED)->error();
                                Log::info('Admin::CategoryController::destroy::' . ADMIN_DELETE_CATEGORY_ERROR);
                                return response()->json(['msg' => ADMIN_DELETE_CATEGORY_ERROR, 'code' => 422]);
                            }
                        } else {
                            flash(ADMIN_DELETE_CATEGORY_ERROR)->error();
                            Log::info('Admin::CategoryController::destroy::' . INPUT_REQUEST_NULL_RESPONSE);
                            return response()->json(['msg' => ADMIN_DELETE_RECIPE_ERROR, 'code' => 422]);
                        }
                    } catch (Exception $ex) {
                        Log::info('Admin::CategoryController::deleteSubCategory::');
                        throw new Exception($ex);
                    }
                });
        return $result;
    }

    /**
     * @author : ####.
     * Date: ####
     *
     * Method name: deleteSubCategory
     * This method is used for delete the sub category.
     *
     * @param  {integer} id- category's id.
     * @return Response code,message.
     * @exception throw if any error occur when deactivate the category.
     */
    public function deleteSubCategory($id) {
        Log::info('Admin::CategoryController::deleteSubCategory::Start');
        $result = DB::transaction(function () use ($id) {
                    try {
                        if (null != $id && '' != $id) {
                            $productData = Product::where('category_id', $id)->select('category_id')->first();
                            if (null == $productData || '' == $productData) {
                                $delete = Category::find($id)->delete();
                                if (null != $delete && '' != $delete) {
                                    flash(CATEGORY_DELETE_SUCCESS)->success();
                                    Log::info('Admin::CategoryController::deleteSubCategory::End ::::');
                                    return response()->json(['msg' => CATEGORY_DELETE_SUCCESS, 'code' => 200]);
                                } else {
                                    flash(ADMIN_DELETE_CATEGORY_ERROR)->error();
                                    Log::info('Admin::CategoryController::deleteSubCategory::' . ADMIN_DELETE_CATEGORY_ERROR);
                                    return response()->json(['msg' => ADMIN_DELETE_CATEGORY_ERROR, 'code' => 422]);
                                }
                            } else {
                                flash(ADMIN_DELETE_CATEGORY_ERROR_WHILE_PRODUCT_ADDED)->error();
                                Log::info('Admin::CategoryController::deleteSubCategory::' . ADMIN_DELETE_CATEGORY_ERROR);
                                return response()->json(['msg' => ADMIN_DELETE_CATEGORY_ERROR, 'code' => 422]);
                            }
                        } else {
                            flash(ADMIN_DELETE_CATEGORY_ERROR)->error();
                            Log::info('Admin::CategoryController::deleteSubCategory::' . INPUT_REQUEST_NULL_RESPONSE);
                            return response()->json(['msg' => ADMIN_DELETE_RECIPE_ERROR, 'code' => 422]);
                        }
                    } catch (Exception $ex) {
                        Log::info('Admin::CategoryController::deleteSubCategory::');
                        throw new Exception($ex);
                    }
                });
        return $result;
    }
}
