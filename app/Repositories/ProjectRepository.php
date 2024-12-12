<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Common\CommonRepository;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
class ProjectRepository extends CommonRepository implements ProjectRepositoryInterface
{
    protected const RESOURCE = ProjectResource::class;
    protected const REQUEST = ProjectRequest::class;

    public function model(): string
    {
        return Project::class;
    }
}
