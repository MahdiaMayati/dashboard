<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ArtisanProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArtisanProfileController extends Controller
{
    // الحصول على الملف الشخصي للحرفي الحالي المسجل دخوله
    public function me(Request $request)
    {
        $artisanProfile = $request->user()->artisanProfile;

        if (!$artisanProfile) {
            return response()->json(['message' => 'هذا الحساب ليس لديه ملف حرفي.'], 404);
        }

        return new ArtisanProfileResource($artisanProfile->load('serviceCategories'));
    }

    // تحديث البيانات الحية (تحديث الموقع، وتوافر الحرفي لاستقبال الطلبات)
    public function updateStatus(Request $request)
    {
        $artisanProfile = $request->user()->artisanProfile;

        if (!$artisanProfile) {
            return response()->json(['message' => 'الوصول مرفوض.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'is_available' => 'boolean',
            'is_accepting_orders' => 'boolean',
            'latitude' => 'numeric|between:-90,90',
            'longitude' => 'numeric|between:-180,180',
            'address' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $artisanProfile->update($request->only([
            'is_available', 'is_accepting_orders', 'latitude', 'longitude', 'address'
        ]));

        return response()->json([
            'message' => 'تم تحديث الحالة والموقع بنجاح',
            'profile' => new ArtisanProfileResource($artisanProfile)
        ]);
    }
}
