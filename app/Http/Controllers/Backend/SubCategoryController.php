<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
  public function AllSubCategory()
  {

    $subcategory = SubCategory::latest()->get();

    return view(
      'admin.backend.subcategory.all_subcategory',
      compact('subcategory')
    );
  } // End Method 

  public function AddSubCategory()
  {
    $category = Category::latest()->get();

    return view(
      'admin.backend.subcategory.add_subcategory',
      compact('category')
    );
  } // End Method 

  public function StoreSubCategory(Request $request)
  {

    SubCategory::insert([
      'category_id' => $request->category_id,
      'subcategory_name' => $request->subcategory_name,
      'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
    ]);

    $notification = array(
      'message' => 'SubCategory Inserted Successfully',
      'alert-type' => 'success'
    );
    return redirect()->route('all.subcategory')->with($notification);
  } // End Method 

  public function EditSubCategory($id)
  {

    $category = Category::latest()->get();
    $subcategory = SubCategory::find($id);

    return view(
      'admin.backend.subcategory.edit_subcategory',
      compact('category', 'subcategory')
    );
  } // End Method


  public function UpdateSubCategory(Request $request)
  {

    $subcat_id = $request->id;

    SubCategory::find($subcat_id)->update([
      'category_id' => $request->category_id,
      'subcategory_name' => $request->subcategory_name,
      'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),

    ]);

    $notification = array(
      'message' => 'SubCategory Updated Successfully',
      'alert-type' => 'success'
    );
    return redirect()->route('all.subcategory')->with($notification);
  } // End Method 

  public function DeleteSubCategory($id)
  {

    SubCategory::find($id)->delete();

    $notification = array(
      'message' => 'SubCategory Deleted Successfully',
      'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);
  } // End Method 
}
