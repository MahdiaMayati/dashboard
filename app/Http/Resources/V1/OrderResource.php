<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status, // سيعود بقيمة الـ Enum النصية تلقائياً
            'scheduled_at' => $this->scheduled_at?->toIso8601String(),
            'location' => [
                'address' => $this->address,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'completion_notes' => $this->completion_notes,
            'cancelled_reason' => $this->cancelled_reason,
            'disputed_reason' => $this->disputed_reason,
            'completed_at' => $this->completed_at?->toIso8601String(),
            'created_at' => $this->created_at->toIso8601String(),

            // العلاقات المترابطة
            'category' => new ServiceCategoryResource($this->whenLoaded('serviceCategory')),
            'attachments' => OrderAttachmentResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
