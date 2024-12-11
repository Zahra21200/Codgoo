<?php

namespace App\Repositories;

use App\Models\Addon;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Common\CommonRepository;
use Illuminate\Http\Request;
use App\Repositories\AddonRepositoryInterface;
use App\Http\Requests\AddonRequest;
use App\Http\Resources\AddonResource;

class AddonRepository extends CommonRepository implements AddonRepositoryInterface
{
    protected const REQUEST = AddonRequest::class;
    protected const RESOURCE = AddonResource::class;

    public function model(): string
    {
        return Addon::class;
    }

    public function create(array $data)
    {
        // Handle any custom logic before creation if needed (like file upload)
        return Addon::create($data);
    }
    
    public function find(int $id)
    {
        // Find the addon by its ID
        return $this->getModel()->find($id);
    }
    

}