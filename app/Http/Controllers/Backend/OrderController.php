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
}
