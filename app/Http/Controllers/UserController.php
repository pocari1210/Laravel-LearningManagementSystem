<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function Index()
  {
    return view('frontend.index');
  } // End Method 

  public function UserProfile()
  {
    $id = Auth::user()->id;
    $profileData = User::find($id);

    return view(
      'frontend.dashboard.edit_profile',
      compact('profileData')
    );
  } // End Method 

  public function UserProfileUpdate(Request $request)
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
      @unlink(public_path('storage/upload/user_images/' . $data->photo));
      $filename = date('YmdHi') . $file->getClientOriginalName();
      $file->move(public_path('storage/upload/user_images'), $filename);
      $data['photo'] = $filename;
    }

    // 保存処理を行う
    $data->save();

    $notification = array(
      'message' => 'User Profile Updated Successfully',
      'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
  } // End Method 

  public function UserLogout(Request $request)
  {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
  } // End Method 

  public function UserChangePassword()
  {
    return view('frontend.dashboard.change_password');
  } // End Method 
}
