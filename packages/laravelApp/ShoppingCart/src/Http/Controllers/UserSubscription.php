<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\UsersProfile;
use Illuminate\Http\Request;
use App\UserSubscriptionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Datatables;
use Log;
use DB;
use App\UserCardInfo;

class UserSubscription extends Controller {

  /**
  * @author : ####
  * Created on : ####
  *
  * Method name: index
  * This method is used to show User Subscription list view.
  *
  * @return  view for User Subscription list.
  * @exception throw if any error occur when getting User Subscription list.
  */
  public function index() {
    Log::info('User::UserSubscription::index::Start');
    $result = DB::transaction(function () {
      try {
        Log::info('User::UserSubscription::index::End');
        return view('front.subscription_details.index');
      } catch (Exception $ex) {
        Log::info('User::UserSubscription::index::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author : ####
  * Created on : ####
  *
  * Process datatables ajax request for User Subscription list.
  *
  * @return \Illuminate\Http\JsonResponse
  */
  public function users_data() {
    Log::info('UserSubscription::users_data::START');
    $result = DB::transaction(function () {
      try{
        $user = Auth::user();
        $userSubscriptionDetail = UserSubscriptionDetail::where('user_id',$user['id'])->get();
        if(null != $userSubscriptionDetail && '' != $userSubscriptionDetail) {
          return Datatables::of($userSubscriptionDetail)
          ->addIndexColumn()
          ->addColumn(
            'status',
            function ($subscriptions) {
              if($subscriptions['status'] == 'error'){
                return $subscriptions['status'] = 'fail';
              }else{
                return $subscriptions['status'] = $subscriptions['status'];
              }
            })
          ->addColumn(
            'start_date',
            function ($userSubscriptionDetail) {
              return date("F, d Y", strtotime($userSubscriptionDetail['start_date']));;
            })
            ->addColumn(
              'end_date',
              function ($userSubscriptionDetail) {
                return date("F, d Y", strtotime($userSubscriptionDetail['end_date']));;
              })
            ->addColumn(
              'active',
              function ($userSubscriptionDetail) {
                if ($userSubscriptionDetail['active'] == 1) {
                  return $userSubscriptionDetail['active'] = 'Active';
                } else {
                  return $userSubscriptionDetail['active'] = 'Cancelled';
                }
                return $userSubscriptionDetail['active'];
              }
            )
          ->addColumn('action', function ($userSubscriptionDetail) {
            return  '<a href="/user_subscription/view/'.$userSubscriptionDetail->id.'/'.encrypt(PERMISSION_USER_SUBSCRIPTION_VIEW). '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>
              <a href="/cancel_subscription/' . $userSubscriptionDetail->id . '/' . encrypt(PERMISSION_USER_SUBSCRIPTION_VIEW) . '" class="btn btn-xs btn-danger"><i class="fa fa-ban"></i> Cancel</a>';
        })->make(true);
        } else {
          Log::info('User::UserSubscription::users_data::' . ADMIN_LIST_PLAYLIST_ERROR);
          flash(ADMIN_LIST_PLAYLIST_ERROR)->error();
          return Redirect::back();
        }
      } catch (Exception $ex) {
        Log::error('User::UserSubscription::users_data::');
        throw new Exception($ex);
      }
    });
    return $result;
  }

  /**
  * @author : ####
  * Created on : ####
  *
  * Show the details of User Subscription specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show(Request $order)
  {
    Log::info('User::UserSubscription::show::Start');
    $result = DB::transaction(function () use($order){
      try {
        if(null!=$order && ''!=$order){
          $userSubscriptionDetails=UserSubscriptionDetail::with('user')->where('id',$order->id)->first();
          $userCardInfo=UserCardInfo::where('id',$userSubscriptionDetails['user_card_info_id'])->first();
          if(null!=$userSubscriptionDetails && ''!=$userSubscriptionDetails && null!=$userCardInfo && ''!=$userCardInfo){
            if($userSubscriptionDetails['status']=="error"){
              $userSubscriptionDetails['status']="fail";
            }
            $userSubscriptionDetails['start_date']=date("F, d Y", strtotime($userSubscriptionDetails['start_date']));
            $userSubscriptionDetails['end_date']=date("F, d Y", strtotime($userSubscriptionDetails['end_date']));
            Log::info('User::UserSubscription::show::End');
            return view('front.subscription_details.show', ['userSubscriptionDetails' => $userSubscriptionDetails,'userCardInfo'=>$userCardInfo]);
          }else{
            Log::warning('User::OrderController::show::' .ORDER_SHOW_ERROR );
            return Redirect::back()->withErrors([ORDER_SHOW_ERROR]);
          }
        }else{
          Log::warning('User::UserSubscription::show::' .ORDER_SHOW_ERROR );
          return Redirect::back()->withErrors([ORDER_SHOW_ERROR]);
        }
      } catch (Exception $ex) {
        Log::info('User::UserSubscription::show::');
        throw new Exception($ex);
      }
    });
    return $result;
  }
  public function cancelSubscription($id){
    $result = DB::transaction(function () use ($id) {
      $user = Auth::user();
      $canceledSub = UserSubscriptionDetail::where([
        ['user_id', '=', $user->id],
        ['id', '=', $id]
      ])->update(['active' => 0]);
      if($canceledSub != null && $canceledSub != ''){
        flash('Successfully Cancelled Subscription.')->success();
        return back();
      }else{
        return Redirect::back()->withErrors(['No Subscription Found']);
      }
    });
    return $result;
  }
}
