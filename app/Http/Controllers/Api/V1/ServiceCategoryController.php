<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Http\Resources\V1\ServiceCategoryResource;

class ServiceCategoryController extends Controller
{
    // جلب كل الأقسام النشطة مرتبة
    public function index()
    {
        $categories = ServiceCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return ServiceCategoryResource::collection($categories);
    }

    // جلب قسم واحد محدد مع الحرفيين التابعين له والذين تمت الموافقة عليهم ونشطين
    public function show($slug)
    {
        $category = ServiceCategory::where('slug', $slug)
            ->where('is_active', true)
            ->with(['artisanProfiles' => function($query) {
                $query->where('approval_status', 'approved') // بناءً على الـ Enum لديك
                      ->where('is_available', true);
            }, 'artisanProfiles.user'])
            ->firstOrFail();

        return new ServiceCategoryResource($category);
    }
}
