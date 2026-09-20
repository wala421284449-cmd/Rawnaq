<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Notifications\LoginNotification;

class AuthController extends Controller
{
    public function showLogin()
    {
        return response()->view('cms.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'البريد الالكتروني مطلوب',
            'email.email'       => 'صيغة الايميل الالكتروني خاطئة',
            'password.required' => 'كلمة المرور مطلوبة',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if ($user->status === 'inactive') {
                // تسجيل تحذير أمني لمحاولة دخول لحساب معطل
                Log::warning('متجر رونق: محاولة تسجيل دخول لحساب معطل', [
                    'email' => $request->email,
                    'ip'    => $request->ip(),
                ]);

                return response()->json([
                    'icon'  => 'error',
                    'title' => 'حسابك معطل حاليا',
                ], 403);
            }

            if ($user->isCustomer()) {
                Auth::guard('customer')->login($user, $request->filled('remember'));
            } elseif ($user->isOwner()) {
                Auth::guard('owner')->login($user, $request->filled('remember'));
            } else {
                Auth::guard('admin')->login($user, $request->filled('remember'));
            }

            $request->session()->regenerate();

            // ==========================================
            // إرسال إشعار تسجيل الدخول بالبريد الإلكتروني
            // ==========================================
            $user->notify(new LoginNotification());


            // تسجيل حدث نجاح تسجيل الدخول (INFO Level)
            Log::info('متجر رونق: تم تسجيل الدخول بنجاح', [
                'user_id' => $user->id,
                'email'   => $user->email,
                'ip'      => $request->ip(),
            ]);

            return response()->json([
                'icon'     => 'success',
                'title'    => 'تم تسجيل الدخول بنجاح',
                'redirect' => url('/cms/admin'),
            ], 200);
        }

        // ==========================================
        // المرحلة الثانية: تسجيل محاولة الاختراق / الدخول الفاشلة (WARNING)
        // ==========================================
        Log::warning('متجر رونق: محاولة تسجيل دخول فاشلة (بيانات غير صحيحة)', [
            'email' => $request->email,
            'ip'    => $request->ip(),
        ]);

        return response()->json([
            'icon'  => 'error',
            'title' => 'البريد الالكتروني او كلمة المرور غير صحيحة',
        ], 400);
    }

    public function logout(Request $request)
    {
        $email = null;
        if (Auth::guard('admin')->check()) {
            $email = Auth::guard('admin')->user()->email;
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('customer')->check()) {
            $email = Auth::guard('customer')->user()->email;
            Auth::guard('customer')->logout();
        } elseif (Auth::guard('owner')->check()) {
            $email = Auth::guard('owner')->user()->email;
            Auth::guard('owner')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('متجر رونق: تم تسجيل الخروج بنجاح', [
            'email' => $email,
            'ip'    => $request->ip(),
        ]);

        return redirect()->route('login');
    }
}
