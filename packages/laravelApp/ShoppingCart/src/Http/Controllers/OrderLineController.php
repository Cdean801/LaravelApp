<?php

namespace App\Http\Controllers;

use App\OrderLine;
use App\OrderLineChange;
use Illuminate\Http\Request;

class OrderLineController extends Controller
{

    public function admin_edit($id)
    {
      $order_line = OrderLine::find($id);
      $order = $order_line->order()->first();
      $product = $order_line->product()->first();
      return view('admin.order_line.edit', ['order_line' => $order_line, 'order' => $order,
                                            'product' => $product]);
    }

    public function admin_update(Request $request)
    {
      $order_line = OrderLine::find($request->id);

      if($request->quantity == $order_line->quantity)
      {
        flash('There are no changes to quantity.')->success();
        return redirect()->route('orders.admin_edit', ['id' => $order_line->order_id]);
      } else {
        $order_line_change = new OrderLineChange();
        $order_line_change->initial_quantity = $order_line->quantity;
        $order_line_change->final_quantity = $request->quantity;
        $order_line_change->reason = $request->reason;

        $order_line->quantity = $request->quantity;
        $order_line->save();

        $order_line->order_line_changes()->save($order_line_change);
        flash('Order Line was successfully updated.')->success();
        return redirect()->route('orders.admin_edit', ['id' => $order_line->order_id]);
      }






    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\OrderLine  $orderLine
     * @return \Illuminate\Http\Response
     */
    public function show(OrderLine $orderLine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderLine  $orderLine
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderLine $orderLine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderLine  $orderLine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderLine $orderLine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderLine  $orderLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderLine $orderLine)
    {
        //
    }
}
