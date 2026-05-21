<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserRole; // تأكد من المسار الصحيح للـ Enum في مشروعك
use App\Enums\AccountStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // 1. تسجيل الدخول (Login) للجميع
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required', // لتحديد نوع الجهاز المتصل (مثلاً: iPhone)
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'بيانات الاعتماد غير صحيحة.'], 401);
        }

        // التحقق من حالة الحساب بناءً على جدولك الجديد
        if ($user->account_status === 'blocked' || $user->account_status === 'suspended') {
            return response()->json(['message' => 'هذا الحساب معطل أو محظور حالياً.'], 403);
        }

        // توليد التوكن الخاص بالـ API
        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
            ]
        ], 200);
    }

    // 2. تسجيل حساب عميل جديد (Register Customer)
    public function registerCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:32',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer', // القيمة الافتراضية للعميل
            'account_status' => 'active',
        ]);

        $token = $user->createToken('customer_token')->plainTextToken;

        return response()->json([
            'message' => 'تم إنشاء حساب العميل بنجاح',
            'token' => $token,
            'user' => $user
        ], 201);
    }

    // 3. تسجيل الخروج وإلغاء التوكن (Logout)
    public function logout(Request $request)
    {
        // حذف التوكن الحالي الذي تم استخدامه في الطلب
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'تم تسجيل الخروج بنجاح'], 200);
    }
}
