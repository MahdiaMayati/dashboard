<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Enums\SupportTicketStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupportTicketController extends Controller
{
    // إنشاء تذكرة دعم جديدة
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'related_order_id' => 'nullable|exists:orders,id',
            'priority' => 'nullable|string|in:low,medium,high',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ticket = SupportTicket::create([
            'user_id' => $request->user()->id,
            'related_order_id' => $request->related_order_id,
            'subject' => $request->subject,
            'status' => SupportTicketStatus::Open->value, // القيمة الافتراضية من الـ Enum الخاص بك
            'priority' => $request->priority ?? 'medium',
            'opened_by_role' => $request->user()->role,
        ]);

        return response()->json([
            'message' => 'تم فتح تذكرة الدعم الفني بنجاح، سيقوم الفريق بالتواصل معك.',
            'ticket' => $ticket
        ], 201);
    }
}
