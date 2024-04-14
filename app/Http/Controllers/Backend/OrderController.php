<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Course;
use App\Models\Course_goal;
use App\Models\CourseSection;
use App\Models\CourseLecture;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Order;

use InterventionImage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
  public function AdminPendingOrder()
  {

    $payment = Payment::where('status', 'pending')
      ->orderBy('id', 'DESC')->get();

    return view(
      'admin.backend.orders.pending_orders',
      compact('payment')
    );
  } // End Method 

  public function AdminOrderDetails($payment_id)
  {

    $payment = Payment::where('id', $payment_id)->first();

    $orderItem = Order::where('payment_id', $payment_id)
      ->orderBy('id', 'DESC')->get();

    return view(
      'admin.backend.orders.admin_order_details',
      compact('payment', 'orderItem')
    );
  } // End Method 

  public function PendingToConfirm($payment_id)
  {

    // updateでステータスを変更
    Payment::find($payment_id)->update(['status' => 'confirm']);

    $notification = array(
      'message' => 'Order Confrim Successfully',
      'alert-type' => 'success'
    );
    return redirect()->route('admin.confirm.order')->with($notification);
  } // End Method 

  public function AdminConfirmOrder()
  {

    $payment = Payment::where('status', 'confirm')
      ->orderBy('id', 'DESC')->get();

    return view(
      'admin.backend.orders.confirm_orders',
      compact('payment')
    );
  } // End Method 

  public function InstructorAllOrder()
  {

    $id = Auth::user()->id;

    // $orderItem = Order::where('instructor_id', $id)
    //   ->orderBy('id', 'desc')->get();

    // ★カートから複数courseの注文があった際、
    // 一行にまとめる記述★
    $latestOrderItem = Order::where('instructor_id', $id)
      ->select('payment_id', \DB::raw('MAX(id) as max_id'))
      ->groupBy('payment_id');

    $orderItem = Order::joinSub($latestOrderItem, 'latest_order', function ($join) {
      $join->on('orders.id', '=', 'latest_order.max_id');
    })->orderBy('latest_order.max_id', 'DESC')->get();

    return view(
      'instructor.orders.all_orders',
      compact('orderItem')
    );
  } // End Method 

  public function InstructorOrderDetails($payment_id)
  {

    $payment = Payment::where('id', $payment_id)->first();

    $orderItem = Order::where('payment_id', $payment_id)
      ->orderBy('id', 'DESC')->get();

    return view(
      'instructor.orders.instructor_order_details',
      compact('payment', 'orderItem')
    );
  } // End Method 

  public function InstructorOrderInvoice($payment_id)
  {

    $payment = Payment::where('id', $payment_id)->first();

    $orderItem = Order::where('payment_id', $payment_id)
      ->orderBy('id', 'DESC')->get();

    $pdf = Pdf::loadView('instructor.orders.order_pdf', compact('payment', 'orderItem'))
      ->setPaper('a4')->setOption([
        'tempDir' => public_path(),
        'chroot' => public_path(),
      ]);
    return $pdf->download('invoice.pdf');
  } // End Method 

  public function MyCourse()
  {
    $id = Auth::user()->id;

    $latestOrders = Order::where('user_id', $id)
      ->select('course_id', \DB::raw('MAX(id) as max_id'))->groupBy('course_id');

    $mycoruse = Order::joinSub($latestOrders, 'latest_order', function ($join) {
      $join->on('orders.id', '=', 'latest_order.max_id');
    })->orderBy('latest_order.max_id', 'DESC')->get();

    return view(
      'frontend.mycourse.my_all_course',
      compact('mycoruse')
    );
  } // End Method 
}
