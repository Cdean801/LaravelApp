<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Order;
use Yajra\Datatables\Datatables;
use Excel;
use PDF;
use Log;
use DB;
use App\User;
use Redirect;
use Carbon\Carbon;

class ReportController extends Controller
{
  public function index()
  {
    return view('admin.report.index');
  }
  /**
  * @author : ####.
  * Date: ####
  *
  * Method name: salesReportIndex
  * This method is used for view of sales report.
  *
  * @return  view of sales report,Response code,message.
  * @exception throw if any error occur when getting report view.
  */
  public function salesReportIndex()
  {
    $getOrder['getOrder'] = 0;
    return view('admin.report.sales_report')->with($getOrder);
  }
  /**
  * @author : ####.
  * Date: ####
  *
  * Method name: salesReport
  * This method is used for get sales report.
  *
  *@param  {date} from_date - From date.
  *@param  {date} to_date - To date.
  * @return  data of sales report,Response code,message.
  * @exception throw if any error occur when getting data of sales report.
  */
  public function salesReport(Request $request)
  {
    Log::info('Admin::ReportController::salesReport::START');
    $result = DB::transaction(function() use ($request) {
      try {
        $input = $request->all();

        if(null == $input || '' == $input) {
          Log::info('Admin::ReportController::salesReport::');
          flash(ADMIN_CREATE_CUSTOMER_ERROR)->error();
          return Redirect::back();
        }
        $validation = Order::reportValidate($input)->validate();
        if ($validation != null && $validation != "" && $validation->fails()) {
          return $validation;
        }
        $getOrder=Order::with(['order_lines'=>function($qs){
          $qs->select(['id','order_id','product_id','item_price','quantity', DB::raw('SUM(quantity*item_price) As total_sale_price')]);
          $qs->groupBy('order_id');
        }])->whereBetween('created_at',[$input['from_date'],$input['to_date']])->orderBy('id', 'DESC')->get();
        $order=[];

        foreach($getOrder as $k=>$line){
          $order[$k]['id']=$line['id'];
          $order[$k]['amount']=$line['amount'];
          $order[$k]['payment_method']=$line['payment_method'];
          $order[$k]['user_id'] = User::where('id',$line['user_id'])->withTrashed()->selectRaw("CONCAT(first_name, ' ', last_name) as name")->first();
          $order[$k]['user_name'] = $order[$k]['user_id']->name;
          if($line['payment_method']=='CC'){
            $order[$k]['payment_method'] = 'Credit Card';
          }else{
            $order[$k]['payment_method'] = 'Debit Card';
          }
          if($line['paid']==1){
            $order[$k]['paid'] = 'Paid';
          }else{
            $order[$k]['paid'] = 'Unpaid';
          }
          $order[$k]['created_at']=Carbon::parse($line['created_at'])->format("m-d-Y H:i:s");
        }
        if(null != $getOrder && '' != $getOrder) {
          return Datatables::of($order)
          ->addIndexColumn()
          ->make(true);
        }
        else {
          Log::info('Admin::ReportController::salesReport::' . ADMIN_LIST_EXCLUDE_TAG_ERROR);
          return view('admin.report.sales_report')->withErrors([ADMIN_LIST_EXCLUDE_TAG_ERROR]);
        }
      } catch(Exception $ex) {
        Log::error('Admin::ReportController::salesReport::');
        throw new Exception($ex);
      }
    });
    return $result;
  }
  /*
  * ==============================
  * PRODUCTS WITHOUT IMAGES REPORT
  * ==============================
  */


  public function products_without_images_data()
  {
    $products = Product::has('images', '<', 1)->where('active', 1);

    return Datatables::of($products)->make(true);
  }

  public function products_without_images()
  {
    return view('admin.report.products_without_images');
  }

  public function products_without_images_to_xls()
  {
    $data = Product::has('images', '<', 1)->where('active', 1)->get();

    return Excel::create('sanecart_prdcts_wo_imgs', function($excel) use ($data) {
      $excel->sheet('mySheet', function($sheet) use ($data)
      {
        $sheet->fromArray($data);
      });
    })->download('xlsx');
  }

  /*
  * ==============================
  * PRODUCTS WITHOUT CATEGORY REPORT
  * ==============================
  */

  public function products_without_category_data()
  {
    $products = Product::has('categories', '<', 1)->where('active', 1);

    return Datatables::of($products)->addColumn('action', function ($product) {
      return '<a href="/products/'.$product->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
    })->make(true);
  }

  public function products_without_category()
  {
    return view('admin.report.products_without_category');
  }

  public function products_without_category_to_xls()
  {
    $data = Product::has('categories', '<', 1)->where('active', 1)->get();

    return Excel::create('sanecart_prdcts_wo_category', function($excel) use ($data) {
      $excel->sheet('mySheet', function($sheet) use ($data)
      {
        $sheet->fromArray($data);
      });
    })->download('xlsx');
  }

  /*
  * ====================================
  * PRODUCTS FROM PERISHABLE CATEGORIES
  * ====================================
  */

  public function products_perishable_data()
  {
    $products = Product::whereHas('categories', function ($query) {
      $query->where('name', 'Produce')
      ->orWhere('name', 'Dairy')
      ->orWhere('name', 'Frozen Appetizers')
      ->orWhere('name', 'Frozen Breads')
      ->orWhere('name', 'Frozen Entree')
      ->orWhere('name', 'Frozen Desserts');
    })->where('active', 1)->get();

    return Datatables::of($products)->make(true);
  }

  public function products_perishable()
  {
    return view('admin.report.products_perishable');
  }

  public function products_perishable_to_xls()
  {
    $data = Product::whereHas('categories', function ($query) {
      $query->where('name', 'Produce')
      ->orWhere('name', 'Dairy')
      ->orWhere('name', 'Frozen Appetizers')
      ->orWhere('name', 'Frozen Breads')
      ->orWhere('name', 'Frozen Entree')
      ->orWhere('name', 'Frozen Desserts');
    })->where('active', 1)->get();



    return Excel::create('sanecart_perishable', function($excel) use ($data) {
      $excel->sheet('mySheet', function($sheet) use ($data)
      {
        $sheet->fromArray($data);
      });
    })->download('xlsx');
  }

  /*
  * ====================================
  * ORDERS WITH PERISHABLE
  * ====================================
  */

  public function orders_perishable()
  {
    $ldate = date("F jS, Y", strtotime(date('Y-m-d')));
    $orders = Order::whereHas('slot', function($query) {
      $query->where('slot_date', date('Y-m-d'));
    })->get();
    $pdf = PDF::loadView('admin.report.perishable_orders_with_items', compact('orders', 'ldate'));
    return $pdf->download('htmltopdfview');

    //    return view('admin.report.perishable_orders_with_items', compact('orders', 'ldate'));
  }


}
