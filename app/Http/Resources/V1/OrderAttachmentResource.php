<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderAttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      return [
            'id' => $this->id,
            'original_name' => $this->original_name,
            'url' => $this->url, // يستدعي الـ Accessor المكتوب في الموديل لديك تلقائياً
        ];
    }
}
