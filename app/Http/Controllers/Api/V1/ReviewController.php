<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use App\Http\Resources\V1\ReviewResource;
use App\Enums\ReviewModerationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        // التأكد من أن العميل هو صاحب الطلب، وأن الطلب مكتمل فعلياً ليتمكن من التقييم
        if ($order->customer_id !== $request->user()->id || $order->status->value !== 'completed') {
            return response()->json(['message' => 'يمكنك فقط تقييم طلباتك المكتملة.'], 403);
        }

        // منع التقييم المكرر لنفس الطلب
        if ($order->review()->exists()) {
            return response()->json(['message' => 'لقد قمت بتقييم هذا الطلب مسبقاً.'], 422);
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $review = Review::create([
            'order_id' => $order->id,
            'customer_id' => $request->user()->id,
            'artisan_profile_id' => $order->artisan_profile_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'moderation_status' => ReviewModerationStatus::Visible->value, // مرئي تلقائياً حسب الـ Enum عندك
        ]);

        return response()->json([
            'message' => 'شكراً لك، تم تسجيل تقييمك بنجاح.',
            'review' => new ReviewResource($review)
        ], 201);
    }
}
