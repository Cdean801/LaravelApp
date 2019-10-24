<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\OrderLine;
use App\TimeSlot;
use App\Address;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Log;

class OrderController extends Controller
{


  public function admin_todays_index_data()
  {
    $orders = DB::table('orders')
    ->join('time_slots', 'time_slots.id', '=', 'orders.time_slot_id')
    ->where('time_slots.slot_date', Carbon::today()->toDateString())
    ->select('orders.*', 'time_slots.slot_date', 'time_slots.slot')
    ->get();
    return Datatables::of($orders)->addColumn('action', function ($order) {
      return '<a href="/admin_orders/'.$order->id.'/edit" class="btn btn-xs btn-primary">View</a>';
    })->make(true);
  }

  public function admin_todays_orders()
  {
    return view('admin.order.todays_index');
  }

  public function adminIndexData()
  {
    Log::info('Admin::OrderController::adminIndexData::START');
    $result = DB::transaction(function (){
      try {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return Datatables::of($orders)
        ->addIndexColumn()
        ->addColumn(
          'user_name',
          function ($orders) {
            return $orders['user_name'] = $orders['user']['first_name'].' '.$orders['user']['last_name'];
          })
          ->addColumn(
            'status',
            function ($orders) {
              if($orders['paid'] == 0){
                return $orders['paid'] = 'Unpaid';
              }else{
                return $orders['paid'] = 'Paid';
              }
            })
            ->addColumn(
              'date',
              function ($orders) {
                return Carbon::parse($orders['created_at'])->format("m-d-Y");
                // return date_format($orders['created_at'],"F, d Y");
                // return $orders['created_at'];
              })
              ->addColumn('action', function ($order) {
                return '<a href="/orders/'.$order->id.'" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>';
              })
              ->make(true);
            } catch (Exception $ex) {
              Log::info('Admin::OrderController::adminIndexData::');
              throw new Exception($ex);
            }
          });
          return $result;
        }


        public function myOrderData()
        {
          Log::info('Admin::OrderController::adminIndexData::START');
          $result = DB::transaction(function (){
            try {
              $user = Auth::user();
              $orders = Order::where('user_id',$user['id'])->orderBy('created_at', 'desc')->get();
              return Datatables::of($orders)
              ->addIndexColumn()
              ->addColumn(
                'status',
                function ($orders) {
                  if($orders['paid'] == 0){
                    return $orders['paid'] = 'Unpaid';
                  }else{
                    return $orders['paid'] = 'Paid';
                  }
                })
                ->addColumn(
                  'date',
                  function ($orders) {
                    return Carbon::parse($orders['created_at'])->format("m-d-Y");
                    // return date_format($orders['created_at'],"F, d Y");
                    // return $orders['created_at'];
                  })
                  ->addColumn('action', function ($order) {
                    return '<a href="/orders/'.$order->id.'" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>';
                  })->make(true);
                } catch (Exception $ex) {
                  Log::info('Admin::OrderController::adminIndexData::');
                  throw new Exception($ex);
                }
              });
              return $result;
            }
            public function adminIndex()
            {
              Log::info('Admin::OrderController::adminIndex::START');
              $result = DB::transaction(function (){
                try {
                  Log::info('Admin::OrderController::adminIndex::END');
                  return view('admin.order.index');
                } catch (Exception $ex) {
                  Log::info('Admin::OrderController::adminIndex::');
                  throw new Exception($ex);
                }
              });
              return $result;
            }


            public function userIndex()
            {
              Log::info('Admin::OrderController::userIndex::START');
              $result = DB::transaction(function (){
                try {
                  Log::info('Admin::OrderController::userIndex::END');
                  return view('front.order.index');
                } catch (Exception $ex) {
                  Log::info('Admin::OrderController::userIndex::');
                  throw new Exception($ex);
                }
              });
              return $result;
            }

            public function admin_edit($id)
            {
              $order = Order::find($id);
              $order_lines = $order->order_lines()->get();
              $time_slot = TimeSlot::where('id', $order->time_slot_id)->first();
              $location = $time_slot->location()->first();
              $total = 0;
              foreach($order_lines as $line){
                $total = $total + ($line->quantity * $line->item_price);
              }
              return view('admin.order.edit', ['order' => $order,
              'order_lines' => $order_lines, 'total' => $total,
              'time_slot' => $time_slot, 'location' => $location]);
            }


            /**
            *
            * Method to Process order
            * This will execute when delivery driver will give goods to customer.
            *
            */
            public function complete_order($id)
            {
              $order = Order::find($id);
              if($order->paid == true){

                return Redirect::back()->withErrors(['This order is already completed.']);

              } else {
                $total = 0;
                $items = $order->order_lines()->get();
                $stripeToken = $order->payment_reference;

                $pre_total = 0;
                $tax = 0;

                foreach ($items as $item)
                {
                  $total = $total + ($item->quantity * $item->item_price);
                  $tax = $tax + ($item->quantity * $item->item_price * ($item->tax /100)) ;
                }

                $finalTotal = $tax + $total;

                // charge stripe
                try {
                  \Stripe\Stripe::setApiKey("sk_test_Lfhuo9qWXbGz1DcexHTC9yuz");
                  $charge = \Stripe\Charge::create(array(
                    "amount" => ($finalTotal*100),
                    "currency" => "usd",
                    "description" => "Charge for " . $order->id,
                    "source" => $stripeToken,
                  ));
                } catch (\Stripe\Error\ApiConnection $e) {
                  // Network problem, perhaps try again.
                  return Redirect::back()->withErrors(['Sorry, Network is having trouble. Please try again later.']);
                } catch (\Stripe\Error\InvalidRequest $e) {
                  // You screwed up in your programming. Shouldn't happen!
                  return Redirect::back()->withErrors(['Sorry. One of our programmer forgot to drink their caffein.']);
                } catch (\Stripe\Error\Api $e) {
                  // Stripe's servers are down!
                  return Redirect::back()->withErrors(['Sorry our payment processor is down at the moment.']);
                } catch (\Stripe\Error\Card $e) {
                  // Card was declined.
                  return Redirect::back()->withErrors(['Your card is declined. Please try with a different card.']);
                }
                $order->paid = true;
                $order->save();

                flash('Order successfully processed.')->success();
                return redirect()->route('orders.admin_edit', ['id' => $order->id]);
              }

            }

            /**
            * Display a listing of the resource.
            *
            * @return \Illuminate\Http\Response
            */
            public function index()
            {
              $user = Auth::user();
              $orders = Order::with('slot')->where('user_id', $user->id)->get();
              //  return $orders;
              return view('front.order.index', ['orders' => $orders->sortByDesc('id')]);
            }

            /**
            * Show the form for creating a new resource.
            *
            * @return \Illuminate\Http\Response
            */
            public function create()
            {
              //
            }

            /**
            * Store a newly created resource in storage.
            *
            * @param  \Illuminate\Http\Request  $request
            * @return \Illuminate\Http\Response
            */
            public function store(Request $request)
            {
              //
            }

            /**
            * Display the specified resource.
            *
            * @param  \App\Order  $order
            * @return \Illuminate\Http\Response
            */
            public function show(Order $order)
            {
              Log::info('user::OrderController::show::Start');
              $result = DB::transaction(function () use($order){
                try {
                  if(null!=$order && ''!=$order){
                    $orderlines = OrderLine::where('order_id', $order->id)->with('product')->get();
                    if(null!=$orderlines && ''!=$orderlines){
                      $total = 0;
                      foreach($orderlines as $line){
                        $total = $total + ($line->quantity * $line->item_price);
                      }
                      $billing =Address::withTrashed()->find($order['billing_address_id']);
                      $shipping =Address::withTrashed()->find($order['shipping_address_id']);
                      Log::info('user::OrderController::show::End');
                      return view('front.order.show', ['order' => $order,
                      'orderlines' => $orderlines,'billing'=>$billing,'shipping'=>$shipping ,'total' => $total]);
                    }else{
                      Log::warning('user::OrderController::show::' .ORDER_SHOW_ERROR );
                      return Redirect::back()->withErrors([ORDER_SHOW_ERROR]);
                    }
                  }else{
                    Log::warning('user::OrderController::show::' .ORDER_SHOW_ERROR );
                    return Redirect::back()->withErrors([ORDER_SHOW_ERROR]);
                  }
                } catch (Exception $ex) {
                  Log::info('user::OrderController::show::');
                  throw new Exception($ex);
                }
              });
              return $result;
            }

            /**
            * Show the form for editing the specified resource.
            *
            * @param  \App\Order  $order
            * @return \Illuminate\Http\Response
            */
            public function edit(Order $order)
            {
              //
            }

            /**
            * Update the specified resource in storage.
            *
            * @param  \Illuminate\Http\Request  $request
            * @param  \App\Order  $order
            * @return \Illuminate\Http\Response
            */
            public function update(Request $request, Order $order)
            {
              //
            }

            /**
            * Remove the specified resource from storage.
            *
            * @param  \App\Order  $order
            * @return \Illuminate\Http\Response
            */
            public function destroy(Order $order)
            {
              //
            }
          }
