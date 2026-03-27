<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. إذا لم يكن المستخدم مسجل الدخول (Guest)
        if (!Auth::check()) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Veuillez vous connecter. Vous ne pouvez مس مكنش تدخل بلا Login.',
                'status' => 401
            ], 401);
        }

        $user = Auth::user();

        // 2. التحقق من الـ Role
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. إذا كان الـ Role خطأ
        return response()->json([
            'error' => 'Forbidden',
            'message' => "Accès interdit. Votre rôle (" . $user->role . ") n'est pas autorisé.",
            'status' => 403
        ], 403);
    }
}