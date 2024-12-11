<?php

namespace App\Repositories;
namespace App\Repositories;

use App\Models\ProductMedia;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Common\CommonRepository;
use Illuminate\Http\Request;
use App\Repositories\ProductRepositoryInterface;
use App\Http\Requests\ProductMediaRequest;
use App\Http\Resources\ProductMediaResource;

class ProductMediaRepository extends CommonRepository implements ProductMediaRepositoryInterface
{
    protected const REQUEST = ProductMediaRequest::class;
    protected const RESOURCE = ProductMediaResource::class;

    public function model(): string
    {
        return ProductMedia::class;
    }

    public function create(array $data)
    {
        // Handle any custom logic before creation if needed (like file upload)
        return ProductMedia::create($data);
    }
}