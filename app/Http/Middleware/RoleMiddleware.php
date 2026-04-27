<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        //Auth::user(): lấy user đã đăng nhập và lưu trong session
        //Auth::user()->role: kiểm tra giá trị của thuộc tính role có nằm trong giá trị của tham số $roles
        if(!in_array(Auth::user()->role, $roles))
            {
                //Nếu không nằm trong role cho phép=> điều hướng về trang abort với mã lỗi 403
                abort(403,'Bạn không có quyền truy cập');
            }
        return $next($request);
    }
}
