<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Course;
use App\Models\Course_goal;
use App\Models\CourseSection;
use App\Models\CourseLecture;

use InterventionImage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
  public function AddToCart(Request $request, $id)
  {

    $course = Course::find($id);

    // コースがカート内にあるか確認を行う

    /*****************************************************************
     * 
     * Cart::search
     * 
     * カート内を検索し、既にカートに追加済みのコースがあるか判定をしている
     * 
     ******************************************************************/
    $cartItem = Cart::search(function ($cartItem, $rowId) use ($id) {
      return $cartItem->id === $id;
    });

    if ($cartItem->isNotEmpty()) {
      return response()->json(['error' => 'Course is already in your cart']);
    }

    // discount_priceがNullだった場合の処理
    if ($course->discount_price == NULL) {

      Cart::add([
        'id' => $id,
        'name' => $request->course_name,
        'qty' => 1,
        'price' => $course->selling_price,
        'weight' => 1,
        'options' => [
          'image' => $course->course_image,
          'slug' => $request->course_name_slug,
          'instructor' => $request->instructor,
        ],
      ]);
    } else {

      Cart::add([
        'id' => $id,
        'name' => $request->course_name,
        'qty' => 1,
        'price' => $course->discount_price,
        'weight' => 1,
        'options' => [
          'image' => $course->course_image,
          'slug' => $request->course_name_slug,
          'instructor' => $request->instructor,
        ],
      ]);
    }

    return response()->json([
      'success' => 'Successfully Added on Your Cart'
    ]);
  } // End Method 

  public function CartData()
  {

    // Collection形式でカートの中身をすべて取得
    $carts = Cart::content();

    // 商品合計額 + 税額の計算を取得
    $cartTotal = Cart::total();

    // 商品合計数の計算を取得
    $cartQty = Cart::count();

    return response()->json(array(
      'carts' => $carts,
      'cartTotal' => $cartTotal,
      'cartQty' => $cartQty,
    ));
  } // End Method 


  public function AddMiniCart()
  {

    $carts = Cart::content();
    $cartTotal = Cart::total();
    $cartQty = Cart::count();

    return response()->json(array(
      'carts' => $carts,
      'cartTotal' => $cartTotal,
      'cartQty' => $cartQty,
    ));
  } // End Method 

  public function RemoveMiniCart($rowId)
  {

    Cart::remove($rowId);

    return response()->json([
      'success' => 'Course Remove From Cart'
    ]);
  } // End Method 

  public function MyCart()
  {
    return view('frontend.mycart.view_mycart');
  } // End Method 

  public function GetCartCourse()
  {

    $carts = Cart::content();
    $cartTotal = Cart::total();
    $cartQty = Cart::count();

    return response()->json(array(
      'carts' => $carts,
      'cartTotal' => $cartTotal,
      'cartQty' => $cartQty,
    ));
  } // End Method 

  public function CartRemove($rowId)
  {

    Cart::remove($rowId);

    return response()->json([
      'success' => 'Course Remove From Cart'
    ]);
  } // End Method 

  public function CouponApply(Request $request)
  {
  } // End Method 
}
