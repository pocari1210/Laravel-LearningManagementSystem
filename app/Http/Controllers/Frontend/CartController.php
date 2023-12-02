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
  } // End Method 
}
