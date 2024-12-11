<?php
// app/Http/Resources/ProductResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'note' => $this->note,
            // 'attachments' => $this->attachments->map(function ($attachment) {
            //     return [
            //         'file_path' => asset('storage/' . $attachment->file_path),
            //         'file_name' => $attachment->file_name,
            //         'file_type' => $attachment->file_type,
            //     ];
            // }),
        ];
    }
}
