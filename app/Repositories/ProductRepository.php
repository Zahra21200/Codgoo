<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Attachment;
use App\Repositories\Common\CommonRepository;
use Illuminate\Http\Request;
use App\Repositories\ProductRepositoryInterface;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;

class ProductRepository extends CommonRepository implements ProductRepositoryInterface
{
    protected const REQUEST = ProductRequest::class;
    protected const RESOURCE = ProductResource::class;

    public function model(): string
    {
        return Product::class;
    }
}

// class ProductRepository implements ProductRepositoryInterface
// {
//     public function getAll()
//     {
//         return Product::get();
//     }

//     public function getById($id)
//     {
//         return Product::findOrFail($id);
//     }

//     public function create(Request $request)
//     {
//         $product = Product::create($request->only(['name', 'description', 'price', 'note']));

//         // if ($request->hasFile('attachments')) {
//         //     foreach ($request->file('attachments') as $file) {
//         //         $path = $file->store('attachments', 'public');
//         //         $product->attachments()->create([
//         //             'file_path' => $path,
//         //             'file_name' => $file->getClientOriginalName(),
//         //             'file_type' => $file->getClientMimeType(),
//         //         ]);
//         //     }
//         // }

//         return $product;
//     }

//     public function update($id, Request $request)
//     {
//         $product = Product::findOrFail($id);
//         $product->update($request->only(['name', 'description', 'price', 'note']));

//         if ($request->hasFile('attachments')) {
//             foreach ($request->file('attachments') as $file) {
//                 $path = $file->store('attachments', 'public');
//                 $product->attachments()->create([
//                     'file_path' => $path,
//                     'file_name' => $file->getClientOriginalName(),
//                     'file_type' => $file->getClientMimeType(),
//                 ]);
//             }
//         }

//         return $product;
//     }

//     public function delete($id)
//     {
//         $product = Product::findOrFail($id);
//         $product->delete();
//         return $product;
//     }
// }
