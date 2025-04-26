<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CanInputHiyariFromPc
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Kiểm tra user đã đăng nhập
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'error' => 'Unauthorized: Invalid or missing token.'
            ], 401);
        }

        // Kiểm tra xem m_user_type có tồn tại không
        if (!$user->m_user_type) {
            return response()->json([
                'status' => 'error',
                'error' => 'User type not found for this user.'
            ], 403);
        }

        // Kiểm tra quyền can_input_hiyari_from_pc
        if (!$user->m_user_type->can_input_hiyari_from_pc) {
            return response()->json([
                'status' => 'error',
                'error' => 'この機能を利用する権限がありません。' // "Bạn không có quyền sử dụng chức năng này."
            ], 403);
        }

        return $next($request);
    }
}
