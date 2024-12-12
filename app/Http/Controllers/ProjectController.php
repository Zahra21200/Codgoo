<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Http\Request;

class ProjectController extends BaseController
{
    private $repository;

    public function __construct(ProjectRepositoryInterface $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }


    public function store(Request $request)
{
    // Determine the user type from the authenticated user or request
    $user = auth()->user(); // Assuming you are using Laravel's default auth
    $type = $user instanceof \App\Models\Admin ? 'Admin' : 'Client';

    // Create the project with the inferred creator
    $project = Project::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'created_by_id' => $user->id,
        'created_by_type' => $type,
    ]);

    return response()->json($project, 201);
}

}
