<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon' => $this->icon,
            'sort_order' => $this->sort_order,
            // نُظهر الحرفيين التابعين للقسم فقط إذا تم جلبهم (Lazy Loading Protection)
            'artisans' => ArtisanProfileResource::collection($this->whenLoaded('artisanProfiles')),
        ];
    }
}
