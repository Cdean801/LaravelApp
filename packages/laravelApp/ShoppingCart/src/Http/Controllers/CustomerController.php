<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;
use App\User;
use CountryState;
use App\ExcludeTag;
use App\UsersProfile;
use App\Role;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Input;
use Excel;

/**
* @author : ####
* Created on : ####
*
* Class name: CustomerController
* Create a class for CustomerController controller.
*/
class CustomerController extends Controller
{
  /**
  * Enforce middleware.
  */
  public function __construct()
  {
    // $this->middleware(['only' => ['getCountry', 'create', 'store', 'edit', 'delete','anyData','update']]);
  }

  /**
  * @author : ####.
  * Date: ####
  *
  * Method name: getCountry
  * This method is used for get all countries to create customer.
  *
  * @return  customer list,Response code,message.
  * @exception throw if any error occur when getting countries.
  */
  public function getCountry() {
    Log::info('Admin::CustomerController::getCountry::START');
    $result = DB::transaction(function() {
      try {
        $countries = CountryState::getCountries();
        $excludeTag = ExcludeTag::select('id', 'name')->get();
        if ($countries == null || $countries == '') {
          Log::error('Admin::CustomerController::getCountry::' . ACC_COUNTRY_LIST_EMPTY);
          return Response()->json(ACC_COUNTRY_LIST_EMPTY);
        } else {
          Log::info('Admin::CustomerController::getCountry::End');
          return view('admin.customer.create' ,['countries' => $countries, 'excludeTag'=>$excludeTag]);
        }
      } catch(Exception $ex) {
        Log::error('Admin::CustomerController::getCountry::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author : ####.
  * Date: ####
  *
  * Method name: index
  * This method is used to view list of customer.
  *
  * @return  customer list,Response code,message.
  * @exception throw if any error occur while calling view of customer view.
  */
  public function index() {
    Log::info('Admin::CustomerController::index::Start');
    $result = DB::transaction(function () {
      try {
        Log::info('Admin::CustomerController::index::End');
        return view('admin.customer.list');
      } catch (Exception $ex) {
        Log::info('Admin::CustomerController::index::');
        throw new Exception($ex);
      }
    });
    return $result;
  }
  /**
  * @author : ####.
  * Date: ####
  *
  * Method name: anyData
  * This method is used to get data to view all customer.
  *
  * @return  customer list,Response code,message.
  * @exception throw if any error occur while getting customer data.
  */
  public function anyData() {
    Log::info('Admin::CustomerController::anyData::Start');
    $result = DB::transaction(function () {
      try {
        $user = User::with('role')->whereHas('role',function($q) {
          $q->where('name', 'customer');
          })->select('id','email','phone')->selectRaw("CONCAT(first_name, ' ', last_name) as name")->orderby('created_at','desc')->get();
        if(null != $user && '' != $user) {
            // $permission = encrypt('customer-list');
          return Datatables::of($user)
          ->addIndexColumn()
          ->addColumn('action', function ($user) {
            Log::info('Admin::CustomerController::anyData::End');
            return '<a href="/customer/edit/' . $user->id .'/'.encrypt(CUSTOMER_EDIT_PERMISSION).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
            <a href="/customer/delete/' . $user->id .'/'.encrypt(CUSTOMER_DELETE_PERMISSION).'" class="btn btn-xs btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>';
          })->make(true);
        } else {
          Log::info('Admin::CustomerController::anyData::' . ADMIN_LIST_EXCLUDE_TAG_ERROR);
          return view('admin.customer.list')->withErrors([ADMIN_LIST_EXCLUDE_TAG_ERROR]);
        }
      } catch (Exception $ex) {
        Log::info('Admin::CustomerController::anyData::');
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
  * This method is used to create a customer.
  *
  * @param  {varchar}  first_name - First Name.
  * @param  {varchar}  last_name - Last Name.
  * @param  {varchar}  company - Company .
  * @param  {int}  country_code -  Country code.
  * @param  {int}  phone - Phone .
  * @param  {varchar}  email - Email ID .
  * @param  {varchar}  address1 -  Address Line 1.
  * @param  {varchar}  address2-  Address Line 2(nullable).
  * @param  {varchar}  town_city - City Name.
  * @param  {varchar}  country -  Country Code.
  * @param  {varchar}  state -  State Code.
  * @param  {varchar}  zipcode -  Zip Code.
  * @param  {varchar}  password -  Password.
  * @param  {varchar}  health_first_name - First Name for Health Goal.
  * @param  {int}  weight -  Weight.
  * @param  {varchar}  health_email - Email ID for Health Goal.
  * @param  {varchar}  sex - Gender .
  * @param  {tinyint}  feet - Hight in Feet.
  * @param  {tinyint}  inches - Hight in inches.
  * @param  {int}  age - Age.
  * @param  {varchar}  how_active- How Active you are?.
  * @param  {int}  exclude_tag_id-  Exclude Tag id (foreign key).
  * @param  {varchar}  work_out_level-  Work Out Level.
  * @return  customer list,Response code,message.
  * @exception throw if any error occur when creating customer.
  */
  public function store(Request $request) {
    Log::info('Admin::CustomerController::store::START');
    $result = DB::transaction(function() use ($request) {
      try {
        $input = $request->all();
        $permission = encrypt(CUSTOMER_LIST_PERMISSION);
        if(null != $input && '' != $input) {
          $input['password'] = $input['new_password'];
          $validation = User::validateCustomer($input)->validate();
          if ($validation != null && $validation != "" && $validation->fails()) {
            $breakline = $validation->messages()->all();
            $message = implode(",", $breakline);
            Log::warning('Admin::CategoryController::store::' . $message);
            $error['message'] = $message;
            return $validation;
          }
          $userData['first_name'] = $input['first_name'];
          $userData['last_name'] = $input['last_name'];
          $userData['company'] = $input['company'];
          $userData['country_code'] = $input['country_code'];
          $userData['phone'] = '+' . $input['country_code'] . '-' . $input['phone'];
          $userData['email'] = $input['email'];
          $userData['address1'] = $input['address1'];
          $userData['address2'] = $input['address2'];
          $userData['town_city'] = $input['town_city'];
          $userData['country'] = $input['country'];
          $userData['state'] = $input['state'];
          $userData['zip'] = $input['zipcode'];
          $userData['password'] = bcrypt($input['password']);
          $createUser = User::create($userData);
          if(null != $createUser && '' != $createUser) {
            $role_id = Role::where('name', 'customer')->select('id')->first();
            $createUser->roles()->attach($role_id);
              // $userProfileData['user_id'] = $createUser['id'];
              // $userProfileData['first_name'] = $input['health_first_name'];
              // $userProfileData['weight'] = $input['weight'];
              // $userProfileData['email'] = $input['health_email'];
              // $userProfileData['sex'] = $input['sex'];
              // $userProfileData['height_feet'] = $input['feet'];
              // $userProfileData['height_inches'] = $input['inches'];
              // $userProfileData['age'] = $input['age'];
              // $userProfileData['how_active'] = $input['how_active'];
              // $userProfileData['exclude_tag_id'] = $input['exclude_tag_id'];
              // $userProfileData['work_out_level'] = $input['work_out_level'];
              // $createUserProfile = UsersProfile::create($userProfileData);
              // if(null != $createUserProfile && '' != $createUserProfile) {
                // $data['user_profile_completed'] = 1;
                // $userProfileCompleted = User::where('id', $createUserProfile['user_id'])->update($data);
                // if(null != $userProfileCompleted && '' != $userProfileCompleted) {
                  Log::info('Admin::CustomerController::store::End');
                  flash(ADMIN_CREATE_CUSTOMER_SUCCESS)->success();
                    return redirect('Customer/success-create');
                // } else {
                //   Log::info('Admin::CustomerController::store::');
                //   flash(ADMIN_CREATE_CUSTOMER_ERROR)->error();
                //   return Redirect::back();
                // }
              } else {
                Log::info('Admin::CustomerController::store::');
                flash(ADMIN_CREATE_CUSTOMER_ERROR)->error();
                return Redirect::back();
              }
          }else {
            Log::info('Admin::CustomerController::store::');
            flash(ADMIN_CREATE_CUSTOMER_ERROR)->error();
            return Redirect::back();
          }
      } catch(Exception $ex) {
        Log::error('Admin::CustomerController::store::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author : ####.
  * Date: ####
  *
  * Method name: edit
  * This method is used to pass customer data for edit.
  * @param {int} id - customer id
  * @return  customer list,Response code,message.
  * @exception throw if any error occur while getting customer data.
  */
  public function edit($id) {
    Log::info('Admin::CustomerController::edit::Start');
    $result = DB::transaction(function () use ($id){
      try {
        if(null != $id && '' != $id) {
          $userData = User::with(array('usersProfile' =>function($q) {
            $q->select('first_name', 'user_id', 'email', 'weight', 'height_feet', 'height_inches', 'sex', 'age', 'how_active', 'exclude_tag_id', 'work_out_level');
            }))->select('id', 'first_name', 'last_name', 'phone', 'email', 'phone', 'company', 'address1', 'address2', 'town_city', 'state', 'zip', 'country')->find($id);
            if (strpos($userData->phone, '-') !== FALSE) {
              $removePlus = substr($userData->phone, 1);
              $separateCountryCodeAndPhone = explode("-", $removePlus);
              $userData->country_code = $separateCountryCodeAndPhone[0];
              $userData->phone = $separateCountryCodeAndPhone[1];
            } else {
              $userData->country_code = "";
            }
            $userProfileExist = 0;
            $excludeTag = ExcludeTag::select('id', 'name')->get();
            if(null != $userData['usersProfile'] && '' != $userData['usersProfile']) {
              $userProfileExist = 1;
              return view('admin.customer.edit', ['userData' => $userData, 'excludeTag'=> $excludeTag, 'userProfileExist'=>$userProfileExist]);
            } else {
              return view('admin.customer.edit', ['userData' => $userData, 'excludeTag'=> $excludeTag, 'userProfileExist'=>$userProfileExist]);
            }

          } else {
            Log::info('Admin::CustomerController::createUser::'.ADMIN_INPUT_ID_NULL);
            flash(ADMIN_GET_CUSTOMER_DATA_ERROR)->error();
            return Redirect::back();
          }
        } catch (Exception $ex) {
          Log::info('Admin::CustomerController::anyData::');
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
    * This method is used to update a customer.
    *
    * @param  {varchar}  first_name - First Name.
    * @param  {varchar}  last_name - Last Name.
    * @param  {varchar}  company - Company .
    * @param  {int}  country_code -  Country code.
    * @param  {int}  phone - Phone .
    * @param  {varchar}  email - Email ID .
    * @param  {varchar}  address1 -  Address Line 1.
    * @param  {varchar}  address2-  Address Line 2(nullable).
    * @param  {varchar}  town_city - City Name.
    * @param  {varchar}  country -  Country Code.
    * @param  {varchar}  state -  State Code.
    * @param  {varchar}  zipcode -  Zip Code.
    * @param  {varchar}  password -  Password.
    * @param  {varchar}  health_first_name - First Name for Health Goal.
    * @param  {int}  weight -  Weight.
    * @param  {varchar}  health_email - Email ID for Health Goal.
    * @param  {varchar}  sex - Gender .
    * @param  {tinyint}  feet - Hight in Feet.
    * @param  {tinyint}  inches - Hight in inches.
    * @param  {int}  age - Age.
    * @param  {varchar}  how_active- How Active you are?.
    * @param  {int}  exclude_tag_id-  Exclude Tag id (foreign key).
    * @param  {varchar}  work_out_level-  Work Out Level.
    * @return  customer list,Response code,message.
    * @exception throw if any error occur when updating customer.
    */
    public function update(Request $request, $id) {
      Log::info('Admin::CustomerController::edit::Start');
      $result = DB::transaction(function () use ($id,$request){
        try {
          if(null != $id && '' != $id) {
            $input = $request->all();
              $permission = encrypt(CUSTOMER_LIST_PERMISSION);
            $healthGoal = $input['healthGoalExist'];
            if(null != $input && '' != $input) {
              $validation = User::validateUpdateCustomer($input,$id,$healthGoal)->validate();
              if ($validation != null && $validation != "" && $validation->fails()) {
                $breakline = $validation->messages()->all();
                $message = implode(",", $breakline);
                Log::warning('Admin::CategoryController::store::' . $message);
                $error['message'] = $message;
                return $validation;
              }
              $userData['first_name'] = $input['first_name'];
              $userData['last_name'] = $input['last_name'];
              $userData['company'] = $input['company'];
              $userData['phone'] = '+' . $input['country_code'] . '-' . $input['phone'];
              $userData['email'] = $input['email'];
              $userData['address1'] = $input['address1'];
              $userData['address2'] = $input['address2'];
              $userData['town_city'] = $input['town_city'];
              $userData['country'] = $input['country'];
              $userData['state'] = $input['state'];
              $userData['zip'] = $input['zip'];
              $updateUserData = User::where('id',$id)->update($userData);
              if(null != $updateUserData && '' != $updateUserData) {
                if($healthGoal == 0) {
                  $userProfileData['first_name'] = $input['health_first_name'];
                  $userProfileData['weight'] = $input['weight'];
                  $userProfileData['email'] = $input['health_email'];
                  $userProfileData['sex'] = $input['sex'];
                  $userProfileData['height_feet'] = $input['feet'];
                  $userProfileData['height_inches'] = $input['inches'];
                  $userProfileData['age'] = $input['age'];
                  $userProfileData['how_active'] = $input['how_active'];
                  $userProfileData['exclude_tag_id'] = $input['exclude_tag_id'];
                  $userProfileData['work_out_level'] = $input['work_out_level'];
                  $updateUserProfile = UsersProfile::where('user_id',$id)->update($userProfileData);
                  if(null != $updateUserProfile && '' != $updateUserProfile) {
                    Log::info('Admin::CustomerController::store::End');
                    flash(ADMIN_UPDATE_CUSTOMER_SUCCESS)->success();
                    return redirect('/customer/list/'.$permission);
                  } else {
                    Log::info('Admin::CustomerController::store::');
                    flash(ADMIN_UPDATE_CUSTOMER_ERROR)->error();
                    return Redirect::back();
                  }
                } else {
                  Log::info('Admin::CustomerController::store::End');
                  flash(ADMIN_UPDATE_CUSTOMER_SUCCESS)->success();
                return redirect('/customer/list/'.$permission);
                }
              } else {
                Log::info('Admin::CustomerController::store::');
                flash(ADMIN_UPDATE_CUSTOMER_ERROR)->error();
                return Redirect::back();
              }
            } else {
              Log::info('Admin::CustomerController::store::'.INPUT_REQUEST_NULL_RESPONSE);
              flash(ADMIN_UPDATE_CUSTOMER_ERROR)->error();
              return Redirect::back();
            }
          } else {
            Log::info('Admin::CustomerController::store::'.ADMIN_INPUT_ID_NULL);
            flash(ADMIN_UPDATE_CUSTOMER_ERROR)->error();
            return Redirect::back();
          }
        } catch (Exception $ex) {
          Log::info('Admin::CustomerController::anyData::');
          throw new Exception($ex);
        }
      });
      return $result;
    }
    /**
     * @author : ####.
     * Date: ####
     *
     * Method name: delete
     * This method is used for delete the customer.
     *
     * @param  {integer} id- customer's id.
     * @return Response code,message.
     * @exception throw if any error occur when delete the customer.
     */
    public function delete($id) {
      Log::info('Admin::CustomerController::delete::Start');
      $result = DB::transaction(function() use ($id) {
        try {
          if(null != $id && '' != $id) {
            $getUserProfile = UsersProfile::where('user_id',$id)->first();
            if(count($getUserProfile)>0) {
              // $deleteUserProfile = UsersProfile::where('user_id',$id)->delete();
              // if(null != $deleteUserProfile && '' != $deleteUserProfile) {
                $role_id = Role::where('name', 'customer')->select('id')->first();
                $user = User::find($id);
                // $detachRole = $user->roles()->detach($role_id);
                // if(null != $detachRole && '' != $detachRole) {
                  $deleteUserData = User::where('id',$id)->delete();
                  if(null != $deleteUserData && '' != $deleteUserData) {
                    Log::info('Admin::CustomerController::delete::End');
                    flash(ADMIN_DELETE_CUSTOMER_SUCCESS)->success();
                    return Redirect::back();
                  } else {
                    Log::info('Admin::CustomerController::delete::');
                    flash(ADMIN_DELETE_CUSTOMER_ERROR)->error();
                    return Redirect::back();
                  }
                // }else {
                //   Log::info('Admin::CustomerController::delete::');
                //   flash(ADMIN_DELETE_CUSTOMER_ERROR)->error();
                //   return Redirect::back();
                // }
              // } else {
              //   Log::info('Admin::CustomerController::delete::');
              //   flash(ADMIN_DELETE_CUSTOMER_ERROR)->error();
              //   return Redirect::back();
              // }
            } else {
              $role_id = Role::where('name', 'customer')->select('id')->first();
              $user = User::find($id);
              $detachRole = $user->roles()->detach($role_id);
              if(null != $detachRole && '' != $detachRole) {
                $deleteUserData = User::where('id',$id)->delete();
                if(null != $deleteUserData && '' != $deleteUserData) {
                  Log::info('Admin::CustomerController::delete::End');
                  flash(ADMIN_DELETE_CUSTOMER_SUCCESS)->success();
                  return Redirect::back();
                } else {
                  Log::info('Admin::CustomerController::delete::');
                  flash(ADMIN_DELETE_CUSTOMER_ERROR)->error();
                  return Redirect::back();
                }
              }else {
                Log::info('Admin::CustomerController::delete::');
                flash(ADMIN_DELETE_CUSTOMER_ERROR)->error();
                return Redirect::back();
              }
            }

          }else {
            Log::info('Admin::CustomerController::delete::'.ADMIN_INPUT_ID_NULL);
            flash(ADMIN_DELETE_CUSTOMER_ERROR)->error();
            return Redirect::back();
          }
        } catch (Exception $ex) {
          Log::info('Admin::CustomerController::delete::');
          throw new Exception($ex);
        }
      });
      return $result;
    }


    /**
    * @author : ####
    * Created on : ####
    *
    * Method name: export_customer
    * This method is used for export_customer in excel file.
    *
    * @exception throw if any error occur.
    */

    public function export_customer()
    {
      Log::info('Admin::CustomerController::export_customer::START');
      $result = DB::transaction(function (){
        try {
          $data = User::whereHas('role', function ($query) {
            $query->where('name', 'customer');
          })->get();
          log::info($data);
          if(null != $data && ''!= $data){
            return Excel::selectSheetsByIndex(0)->create('export_customer', function($excel) use ($data) {
              $excel->sheet('mySheet', function($sheet) use ($data)
              {
                $exportData=array();
                foreach($data as $a){
                  $customerData['First Name'] = $a['first_name'];
                  $customerData['Last Name'] = $a['last_name'];
                  $customerData['Email'] = $a['email'];
                  $customerData['Phone'] = $a['phone'];
                  if($a['company']==null){
                    $customerData['Company']='N.A';
                  }else{
                    $customerData['Company'] = $a['company'];
                  }
                  $customerData['Address1'] = $a['address1'];
                  if($a['address2']==null){
                    $customerData['Address2']='N.A';
                  }else{
                    $customerData['Address2'] = $a['address2'];
                  }
                  $customerData['Town City'] = $a['town_city'];
                  $customerData['Country'] = $a['country'];
                  $customerData['State'] = $a['state'];
                  $customerData['ZIP'] = $a['zip'];
                  if($a['subscription_day']==null){
                    $customerData['Subscription Day']='00';
                  }else{
                    $customerData['Subscription Day'] = $a['subscription_day'];
                  }
                  if($a['subscription_type']==null){
                    $customerData['Subscription Type']='N.A';
                  }else{
                    $customerData['Subscription Type'] = $a['subscription_type'];
                  }
                  // $customerData['SKU'] = $a['verified'];
                  if($a['user_profile_completed']==1){
                    $customerData['User Profile Completed']='Yes';
                  }else{
                    $customerData['User Profile Completed']='No';
                  }
                  array_push($exportData,$customerData);
                }
                $sheet->fromArray($exportData);
              });
            })->download('xlsx');
          }else{
            Log::info('Admin::CustomerController::export_customer::'. ADMIN_CUSTOMER_EXPORT_ERROR);
            flash(ADMIN_CUSTOMER_EXPORT_ERROR)->error();
            return redirect()->back();
          }
        } catch (Exception $ex) {
          Log::info('Admin::CustomerController::export_customer::');
          throw new Exception($ex);
        }
      });
      return $result;
    }

    /**
    * @author : ####.
    * Date: ####
    *
    * Method name: deactiveCustomer
    * This method is used to get data to view all deactivate Customer.
    *
    * @return  Customer list,Response code,message.
    * @exception throw if any error occur while getting deactivated Customer data.
    */
    public function deactiveCustomer()
    {
          Log::info('Admin::CustomerController::deactiveCustomer::Start');
          $result = DB::transaction(function () {
            try {
              $users = User::with('role')->whereHas('role',function($q) {
                $q->where('name', 'customer');
              })->onlyTrashed()->select('id','email','phone')->selectRaw("CONCAT(first_name, ' ', last_name) as name")->orderby('created_at','desc')->get();
              if(null != $users && '' != $users) {
                return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($user) {
                  return '<a href="/customer/reactive/' . $user->id .'/'.encrypt(CUSTOMER_REACTIVE_PERMISSION). '"class="btn btn-xs btn-primary"><i class="fa fa-check"></i>Reactive</a>';
                })->make(true);
              } else {
                Log::info('Admin::CustomerController::users_data::' . ADMIN_LIST_CUSTOMER_ERROR);
                flash(ADMIN_LIST_CUSTOMER_ERROR)->error();
                return Redirect::back();
              }

            } catch (Exception $ex) {
              Log::info('Admin::CustomerController::deactiveCustomer::ERROR');
              throw new Exception($ex);
            }
          });
          return $result;
    }

    /**
     * @author : ####.
     * Date: ####
     *
     * Method name: reactive
     * This method is used for reactive the Customer.
     *
     * @param  {integer} id- Customer's id.
     * @return Response code,message.
     * @exception throw if any error occur when reactive the Customer.
     */

    public function reactive($id) {
      Log::info('Admin::CustomerController::reactive::Start');
      $result = DB::transaction(function () use ($id) {
        try {
          if (null != $id && '' != $id) {
           $restore = User::where('id', $id)->restore();
            if (null != $restore && '' != $restore) {
              flash(ADMIN_RESTORE_CUSTOMER_SUCCESS)->success();
              Log::info('Admin::CustomerController::reactive::End');
              return redirect('/customer/deactivelist/'.encrypt(CUSTOMER_DEACTIVE_PERMISSION));
            } else {
              Log::info('Admin::CustomerController::reactive::' . ADMIN_RESTORE_CUSTOMER_ERROR);
              return Redirect::back()->withErrors([ADMIN_RESTORE_CUSTOMER_ERROR]);
            }
          } else {
            Log::info('Admin::CustomerController::reactive::' . ADMIN_INPUT_ID_NULL);
            return Redirect::back()->withErrors([ADMIN_INPUT_ID_NULL]);
          }
        } catch (Exception $ex) {
          Log::info('Admin::CustomerController::reactive::');
          throw new Exception($ex);
        }
      });
      return $result;
    }

    public function deactiveList($permission) {
      return view('admin.customer.deactivelist');
    }
  }
