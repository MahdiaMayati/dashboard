<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Resources\V1\OrderResource;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Enums\UserRole;

class OrderController extends Controller
{

    public function index(Request $request)
{
    $user = $request->user();
    $query = Order::with(['serviceCategory', 'attachments']);

    // استخدام الـ Enum مباشرة للمقارنة بشكل صحيح ومعتمد
    if ($user->role === UserRole::Customer) {
        $query->where('customer_id', $user->id);

    } elseif ($user->role === UserRole::Artisan) {
        $query->where('artisan_profile_id', $user->artisanProfile?->id);

    } else {
        return response()->json(['message' => 'غير مسموح لهذا الدور باستعراض الطلبات الحالية.'], 403);
    }

    $orders = $query->latest()->paginate(15);
    return OrderResource::collection($orders);
}

    // 2. إنشاء طلب جديد من قبل العميل
    public function store(Request $request)
    {
       if ($request->user()->role !== UserRole::Customer) {
        return response()->json(['message' => 'العملاء فقط يمكنهم إنشاء الطلبات.'], 403);
    }

        $validator = Validator::make($request->all(), [
            'service_category_id' => 'required|exists:service_categories,id',
            'title' => 'nullable|string|max:255',
            'description' => 'required|string',
            'scheduled_at' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096' // حد أقصى 4 ميجا لكل ملف
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // إنشاء الطلب (الموديل بفضل الـ Booted Method لديك سيقوم بتسجيل الـ Log الأول تلقائياً)
        $order = Order::create([
            'customer_id' => $request->user()->id,
            'service_category_id' => $request->service_category_id,
            'status' => OrderStatus::Pending->value, // القيمة الافتراضية للطلب الجديد
            'title' => $request->title,
            'description' => $request->description,
            'scheduled_at' => $request->scheduled_at,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // التعامل مع رفع الملفات المرفقة إن وجدت
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('orders/attachments', 'public');
                $order->attachments()->create([
                    'disk' => 'public',
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return response()->json([
            'message' => 'تم إنشاء طلب الخدمة بنجاح والتطبيق بانتظار الموافقة.',
            'order' => new OrderResource($order->load(['serviceCategory', 'attachments']))
        ], 201);
    }

    // 3. عرض تفاصيل طلب محدد
    public function show(Request $request, Order $order)
    {
        // حماية الطلب بحيث لا يراه إلا العميل صاحب الطلب أو الحرفي المسند إليه
        $user = $request->user();
        if ($user->role === UserRole::Customer && $order->customer_id !== $user->id) {
        return response()->json(['message' => 'غير مصرح لك برؤية هذا الطلب.'], 403);
    }
        if ($user->role === 'artisan' && $order->artisan_profile_id !== $user->artisanProfile?->id) {
            return response()->json(['message' => 'هذا الطلب غير مسند إليك.'], 403);
        }

        return new OrderResource($order->load(['serviceCategory', 'attachments']));
    }

    // 4. تحديث حالة الطلب من قبل الحرفي (قبول، بدء العمل، إلغاء)
    public function updateStatus(Request $request, Order $order)
    {
        $user = $request->user();
       if ($user->role === UserRole::Customer && $order->customer_id !== $user->id) {
        return response()->json(['message' => 'غير مصرح لك برؤية هذا الطلب.'], 403);
    }

        $validator = Validator::make($request->all(), [
            'status' => 'required|string', // يجب تمرير القيمة النصية للـ Enum مثل 'completed' أو 'cancelled'
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // تحديث الموديل (تحديث الحقل سيطلق الـ Event المكتوب عندك في كود الموديل ليسجل التغير تلقائياً في الـ Logs)
        $order->status = $request->status;

        if ($request->status === 'completed') {
            $order->completed_at = now();
            $order->completion_notes = $request->note;
        }

        $order->save();

        return response()->json([
            'message' => 'تم تحديث حالة الطلب بنجاح وسجلت في سجل العمليات.',
            'order' => new OrderResource($order)
        ]);
    }
}
