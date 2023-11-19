<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use InterventionImage;

use App\Models\Category;

class CategoryController extends Controller
{
  public function AllCategory()
  {
    $category = Category::latest()->get();

    return view(
      'admin.backend.category.all_category',
      compact('category')
    );
  } // End Method 

  public function AddCategory()
  {
    return view('admin.backend.category.add_category');
  } // End Method 

  public function StoreCategory(Request $request)
  {

    $image = $request->file('image');
    $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
    InterventionImage::make($image)->resize(370, 246)->save('storage/upload/category/' . $name_gen);
    $save_url = 'storage/upload/category/' . $name_gen;

    Category::insert([
      'category_name' => $request->category_name,
      'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
      'image' => $save_url,

    ]);

    $notification = array(
      'message' => 'Category Inserted Successfully',
      'alert-type' => 'success'
    );
    return redirect()->route('all.category')->with($notification);
  } // End Method 
}
