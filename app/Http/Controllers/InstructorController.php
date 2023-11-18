<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class InstructorController extends Controller
{
  public function InstructorDashboard()
  {
    return view('instructor.index');
  } // End Method 

  public function InstructorLogout(Request $request)
  {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('instructor/login');
  } // End Method 

  public function InstructorLogin()
  {
    return view('instructor.instructor_login');
  } // End Method 
}
