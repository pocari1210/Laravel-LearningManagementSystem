<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

  public function AdminChangePassword()
  {
    $id = Auth::user()->id;
    $profileData = User::find($id);

    return view(
      'admin.admin_change_password',
      compact('profileData')
    );
  } // End Method

  public function AdminPasswordUpdate(Request $request)
  {

    /// Validation 
    $request->validate([
      'old_password' => 'required',
      'new_password' => 'required|confirmed'
    ]);

    // 入力されたold_passwordと登録されているpasswordが一致しないときの処理
    if (!Hash::check($request->old_password, auth::user()->password)) {

      $notification = array(
        'message' => 'Old Password Does not Match!',
        'alert-type' => 'error'
      );
      return back()->with($notification);
    }

    /// Update The new Password 
    User::whereId(auth::user()->id)->update([
      'password' => Hash::make($request->new_password)
    ]);

    $notification = array(
      'message' => 'Password Change Successfully',
      'alert-type' => 'success'
    );
    return back()->with($notification);
  } // End Method  

  public function BecomeInstructor()
  {
    return view('frontend.instructor.reg_instructor');
  } // End Method

  public function InstructorRegister(Request $request)
  {

    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'unique:users'],
    ]);

    User::insert([
      'name' => $request->name,
      'username' => $request->username,
      'email' => $request->email,
      'phone' => $request->phone,
      'address' => $request->address,
      'password' =>  Hash::make($request->password),
      'role' => 'instructor',
      'status' => '0',
    ]);

    $notification = array(
      'message' => 'Instructor Registed Successfully',
      'alert-type' => 'success'
    );
    return redirect()->route('instructor.login')->with($notification);
  } // End Method
}
