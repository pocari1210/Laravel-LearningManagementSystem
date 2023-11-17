<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
  public function AdminDashboard()
  {
    return view('admin.index');
  } // End Method 

  public function AdminLogout(Request $request)
  {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/admin/login');
  } // End Method 

  public function AdminLogin()
  {
    return view('admin.admin_login');
  } // End Method 

  public function AdminProfile()
  {

    // LoginしているUserのid情報を取得
    $id = Auth::user()->id;

    // Userモデルのレコードを取得
    $profileData = User::find($id);

    return view(
      'admin.admin_profile_view',
      compact('profileData')
    );
  } // End Method

  public function AdminProfileStore(Request $request)
  {

    // LoginしているUserのid情報を取得
    $id = Auth::user()->id;

    // Userモデルのレコードを指定
    $data = User::find($id);

    // formからわたってきたデータを受け取る
    $data->name = $request->name;
    $data->username = $request->username;
    $data->email = $request->email;
    $data->phone = $request->phone;
    $data->address = $request->address;

    // 画像の変更が含まれた場合の処理
    if ($request->file('photo')) {
      $file = $request->file('photo');

      // @unlinkで、登録されている画像のpathを指定し、削除を行う
      @unlink(public_path('strage/upload/admin_images/' . $data->photo));
      $filename = date('YmdHi') . $file->getClientOriginalName();
      $file->move(public_path('storage/upload/admin_images'), $filename);
      $data['photo'] = $filename;
    }

    // 保存処理を行う
    $data->save();

    $notification = array(
      'message' => 'Admin Profile Updated Successfully',
      'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);
  } // End Method  
}
