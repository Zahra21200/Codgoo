<?php

namespace App\Repositories;

use App\Models\ProductAddons;
use App\Repositories\Common\CommonRepository;
use App\Repositories\ProductAddonRepositoryInterface;
use App\Http\Resources\ProductAddonResource;
use App\Http\Requests\ProductAddonRequest;

class ProductAddonRepository extends CommonRepository implements ProductAddonRepositoryInterface
{
    protected const RESOURCE = ProductAddonResource::class;
    protected const REQUEST = ProductAddonRequest::class;

    public function model(): string
    {
        return ProductAddons::class;
    }
}
