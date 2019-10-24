<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CountryState;
use Carbon\Carbon;
use Log;
use DB;
use App\UserCardInfo;
use App\Address;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\VerifyUser;
use Mail;
use App\Events\UserRegistered;
use App\Mail\VerifyMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Exception;
use App\Role;
use App\ExcludeTag;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Auth\Events\Registered;
use Payeezy_Client;
use Payeezy_CreditCard;
use Payeezy_Transaction;
use Payeezy_Token;
use Payeezy_Error;
use App\UserSubscriptionDetail;

class UpgradeMembershipController extends Controller
{
    //
    public function index(){
        Log::info('User::RegisterController::showRegistrationForm::Start');
        $result = DB::transaction(function () {
            try {
                $products = array(
                    'PaidMembership' =>array(
                        'qty' => 1,
                        'item_price' => 9.00,
                        'total_price' => 9,
                        'item' => array(
                            'name' => 'Frelii Premium Membership'
                        ),
                    ),
                );
                $total = "9.00";
                $card_info = UserCardInfo::where('user_id',Auth::user()->id)->get();
                $useAddress['billing'] = Address::where('user_id',Auth::user()->id)->orderBy('is_primary', 'desc')->get();
                $useAddress['shipping'] = Address::where('user_id',Auth::user()->id)->orderBy('is_primary', 'desc')->get();
                return view('auth.userUpgrade', ['total' => $total, 'products' => $products,'cards'=>$card_info,'address'=>$useAddress]);
            } catch (Exception $ex) {
                Log::error('User::RegisterController::create::');
                throw new Exception($ex);
            }
        });
        return $result;
    }
    public function upgradeMemStoreAddress(Request $request)
    {
        Log::info('User::UpgradeMembershipController::upgradeMemStoreAddress::Start');
        $result = DB::transaction(function () use ($request) {
            try {
                $input = $request->all();
                if (null != $input && '' != $input) {
                    $user = Auth::User();
                    $input['user_id'] = $user['id'];
                    $validation = Address::validateCreateBillingAddress($input);
                    if ($validation != null && $validation != '' && $validation->fails()) {
                        $commaSeparated = $validation->messages()->all();
                        $message = implode("\n", $commaSeparated);
                        Log::warning('user::UpgradeMembershipController::upgradeMemStoreAddress::' . $message);
                        return Redirect::back()->withErrors([$message])->withInput($request->all());
                    }
                    $addressData['first_name'] = $input['first_name'];
                    $addressData['last_name'] = $input['last_name'];
                    $addressData['country'] = $input['country'];
                    $addressData['address1'] = $input['address1'];
                    $addressData['address2'] = $input['address2'];
                    $addressData['town_city'] = $input['town_city'];
                    $addressData['state'] = $input['state'];
                    $addressData['zip'] = $input['zip'];
                    $addressData['phone'] = '+' . $input['country_code'] . '-' . $input['phone'];
                    $addressData['email'] = $input['email'];
                    $addressData['address_title'] = $input['address_title'];
                    $addressData['user_id'] = $input['user_id'];
                    if (array_key_exists('is_address_primary', $input) && $input['is_address_primary'] == 1) {
                        $addressData['is_primary'] = 1;
                        $existPrimary = Address::where('user_id', $user['id'])->where('is_primary', 1)->get();
                        if (null != $existPrimary && '' != $existPrimary && count($existPrimary) > 0) {
                            $update = Address::where('user_id', $user['id'])->update(['is_primary' => 0]);
                            if (null == $update || '' == $update) {
                                Log::info('user::UpgradeMembershipController::upgradeMemStoreAddress::' . USER_CREATE_ADDRESS_ERROR);
                                return Redirect::back()->withErrors([USER_CREATE_ADDRESS_ERROR])->withInput($request->all());
                            }
                        }
                    } else {
                        $addressData['is_primary'] = 0;
                    }
                    $createdAddress = Address::create($addressData);
                    if (null == $createdAddress || '' == $createdAddress) {
                        Log::info('user::UpgradeMembershipController::upgradeMemStoreAddress::' . USER_CREATE_ADDRESS_ERROR);
                        return Redirect::back()->withErrors([USER_CREATE_ADDRESS_ERROR])->withInput($request->all());
                    }
                    flash(USER_CREATE_ADDRESS_SUCESS)->success();
                    Log::info('user::UpgradeMembershipController::upgradeMemStoreAddress::' . USER_CREATE_ADDRESS_SUCESS);
                    return redirect()->action('UpgradeMembershipController@index');
                } else {
                    Log::info('user::UpgradeMembershipController::upgradeMemStoreAddress::' . INPUT_REQUEST_NULL_RESPONSE);
                    return Redirect::back()->withErrors([INPUT_REQUEST_NULL_RESPONSE])->withInput($request->all());
                }
            } catch (Exception $ex) {
                Log::error('User::UpgradeMembershipController::upgradeMemStoreAddress::');
                throw new Exception($ex);
            }
        });
        return $result;
    }
    public function upgradeMembership(Request $request){
        //test card 4012000033330026 Visa
        //4005519200000004 Visa
        // 5424180279791732 Master
        Log::info('User::RegisterController::create::Start');
        $result = DB::transaction(function () use ($request) {
            $user = Auth::user();
            $permission = encrypt(PERMISSION_UPLOAD23_AND_ME);
            $client =   new Payeezy_Client();
            $client->setApiKey("JQDENhx7oEbg9vl1mAv5lu1AEGpXPhMX");
            $client->setApiSecret("4a9de24bd9a19c850c91a10527d3c43b9ec7ad8e8cc35110bbf9b94f833b8856");
            $client->setMerchantToken('fdoa-a8917f80977c371f6d1c0d312fd570fb6d8a08982c13d69e');
            $client->setUrl("https://api-cert.payeezy.com/v1/transactions");
            if(isset($request["checkout_card"])){
                $cardInfo = UserCardInfo::where('id', $request['checkout_card'])->get()->toArray();

                $authorize_card_transaction = new Payeezy_Token($client);
                $authorize_response = $authorize_card_transaction->purchase(
                    [
                        "merchant_ref" => "Frelii",
                        "method" => "token",
                        "amount" => "900",
                        "currency_code" => "USD",
                        "token" => array(
                            "token_type" => "FDToken",
                            "token_data" => array(
                                "type" => $cardInfo[0]['brand'],
                                "value" => $cardInfo[0]['token'],
                                "cardholder_name" => $cardInfo[0]['card_holder_name'],
                                "exp_date" => $cardInfo[0]['expiration']
                            )
                        )
                    ]
                );
                if(!isset($authorize_response->Error) && $authorize_response->transaction_status === "approved"){
                    $startDate = Carbon::now()->format('d');
                    $startmonth = Carbon::now()->format('m');
                    $startyear = Carbon::now()->format('Y');
                    $endmonth = Carbon::now()->addMonth()->format('m');
                    $endyear = Carbon::now()->format('Y');
                    $periodStartDate = Carbon::createFromDate($startyear, $startmonth, $startDate)->format('Y-m-d');
                    $periodEndDate = Carbon::createFromDate($endyear, $endmonth, $startDate)->format('Y-m-d');
                    $user->subscription_type = 'MONTHLY';
                    $user->subscription_day = $startDate;
                    $user->save();
                    $role_id = Role::where('name', CUSTOMER)->select('id')->first();
                    $user->roles()->detach();
                    $user->roles()->attach($role_id);
                    $userSubscriptionAlreadyExists = UserSubscriptionDetail::where('user_id', '=', $user->id)->first();
                    if($userSubscriptionAlreadyExists == null && $userSubscriptionAlreadyExists == ''){
                        $user_subscription_details['status'] = $authorize_response->validation_status;
                        $user_subscription_details['auth_number'] = $authorize_response->transaction_tag;
                        $user_subscription_details['invoice_number'] = $authorize_response->transaction_id;
                        $user_subscription_details['user_card_info_id'] = $request['checkout_card'];
                        $user_subscription_details['user_id'] =$user->id;
                        $user_subscription_details['start_date'] = $periodStartDate;
                        $user_subscription_details['end_date'] = $periodEndDate;
                        $user_subscription_details['amount'] = 9.00;
                        $user_subscription_details['message'] = 'payment successfully';
                        $user_subscription_details['active'] = 1;
                        $UserSubscriptionDetailCreated = UserSubscriptionDetail::create($user_subscription_details);
                    }else{

                    }
                    return redirect('23AndMe_upload/' . $permission)->with('status', ' Thank You, You are Now a Premium Member!');
                }else{
                    return Redirect::back()->withErrors($authorize_response->Error->messages);
                }
                //  echo "<pre>";
                //  var_dump($authorize_response);
                //  echo "</pre>";

            }else{
                $authorize_card_transaction = new Payeezy_CreditCard($client);
                $authorize_response = $authorize_card_transaction->authorize(
                  array(
                        "merchant_ref" => "Frelii",
                        "amount" => "900",
                        "currency_code" => "USD",
                        "credit_card" => array(
                            "type" => $request['card_type'],
                            "cardholder_name" => $request['card_name'],
                            "card_number" => $request['card_number'],
                            "exp_date" => str_replace('/', '', $request['expiration']),
                            "cvv" => $request['csv']
                        ),
                    )
                );
                if(!isset($authorize_response->Error) && $request['save_this_card'] != 0){
                    $card_info['last4'] = $authorize_response->card->card_number;
                    $card_info['brand'] = $authorize_response->card->type;
                    $card_info['card_holder_name'] = $authorize_response->card->cardholder_name;
                    $card_info['trans_id'] = $authorize_response->transaction_id;
                    $card_info['user_id'] = $user->id;
                    $card_info['is_primary'] = $request['primary_card'];
                    $card_info['token'] = $authorize_response->token->token_data->value;
                    $card_info['expiration'] = $authorize_response->card->exp_date;
                    $card_info['csv'] = $request['csv'];
                    $card_created = UserCardInfo::create($card_info);
                }elseif(isset($authorize_response->Error)){
                    return Redirect::back()->withErrors($authorize_response->Error->messages);
                }
                // echo "<pre><br>";
                // var_dump($authorize_response);
                // echo "</pre><br>";
                // exit;
                $capture_card_transaction = new Payeezy_CreditCard($client);
                $capture_response = $capture_card_transaction->capture(
                    $authorize_response->transaction_id,
                    array(
                        "amount" => "900",
                        "transaction_tag" => $authorize_response->transaction_tag,
                        "merchant_ref" => "Frelii",
                        "currency_code" => "USD",
                    )
                );
                if (!isset($capture_response->Error) && $capture_response->transaction_status === "approved") {
                    $startDate = Carbon::now()->format('d');
                    $startmonth = Carbon::now()->format('m');
                    $startyear = Carbon::now()->format('Y');
                    $endmonth = Carbon::now()->addMonth()->format('m');
                    $endyear = Carbon::now()->format('Y');
                    $periodStartDate = Carbon::createFromDate($startyear, $startmonth, $startDate)->format('Y-m-d');
                    $periodEndDate = Carbon::createFromDate($endyear, $endmonth, $startDate)->format('Y-m-d');
                    $user->subscription_type = 'MONTHLY';
                    $user->subscription_day = $startDate;
                    $user->save();
                    $role_id = Role::where('name', CUSTOMER)->select('id')->first();
                    $user->roles()->detach();
                    $user->roles()->attach($role_id);
                    $userSubscriptionAlreadyExists = UserSubscriptionDetail::where('user_id', '=', $user->id)->first();
                    if ($userSubscriptionAlreadyExists == null && $userSubscriptionAlreadyExists == '') {
                        $user_subscription_details['status'] = $authorize_response->validation_status;
                        $user_subscription_details['auth_number'] = $authorize_response->transaction_tag;
                        $user_subscription_details['invoice_number'] = $authorize_response->transaction_id;
                        $user_subscription_details['user_card_info_id'] = $request['checkout_card'];
                        $user_subscription_details['user_id'] = $user->id;
                        $user_subscription_details['start_date'] = $periodStartDate;
                        $user_subscription_details['end_date'] = $periodEndDate;
                        $user_subscription_details['amount'] = 9.00;
                        $user_subscription_details['message'] = 'payment successfully';
                        $UserSubscriptionDetailCreated = UserSubscriptionDetail::create($user_subscription_details);
                    }else{

                    }
                    return redirect('23AndMe_upload/' . $permission)->with('status', ' Thank You, You are Now a Premium Member!');
                }
            }

    });
    return $result;
    }
    protected function processCardSaveData($data){


    }

}
