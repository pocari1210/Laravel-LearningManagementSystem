<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\User;

class Role
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next, $role): Response
  {

    // ★Userのログイン状況(Active/Inactive)★
    if (Auth::check()) {
      $expireTime = Carbon::now()->addSeconds(30);

      // Cacheデータを新規追加または上書きする
      Cache::put('user-is-online' . Auth::user()->id, true, $expireTime);

      User::where('id', Auth::user()->id)
        ->update(['last_seen' => Carbon::now()]);
    }

    // 遷移されてきたアカウントのroleを初期値にしている
    $userRole = $request->user()->role;

    // roleが一致していない場合、各$userRoleのdashboardページにリダイレクトされる
    if ($userRole === 'user' && $role !== 'user') {
      return redirect('dashboard');
    } elseif ($userRole === 'admin' && $role === 'user') {
      return redirect('/admin/dashboard');
    } elseif ($userRole === 'instructor' && $role === 'user') {
      return redirect('/instructor/dashboard');
    } elseif ($userRole === 'admin' && $role === 'instructor') {
      return redirect('/admin/dashboard');
    } elseif ($userRole === 'instructor' && $role === 'admin') {
      return redirect('/instructor/dashboard');
    }

    return $next($request);
  }
}
