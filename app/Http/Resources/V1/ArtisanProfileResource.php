<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtisanProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'specialty_title' => $this->specialty_title,
            'bio' => $this->bio,
            'location' => [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'address' => $this->address,
            ],
            'profile_image' => $this->profile_image_path ? url('storage/' . $this->profile_image_path) : null,
            'is_available' => $this->is_available,
            'is_accepting_orders' => $this->is_accepting_orders,
            'average_rating' => $this->average_rating ?? 0.0,
            'completed_orders_count' => $this->completed_orders_count,
            // جلب بيانات الحساب الأساسية للحرفي من جدول الـ Users
            'user_info' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ],
            'categories' => ServiceCategoryResource::collection($this->whenLoaded('serviceCategories')),
        ];
    }
}
