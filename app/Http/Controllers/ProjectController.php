<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
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
        // Validate the incoming request
        $validatedData = $request->validate([
            'product_id' => 'nullable|exists:products,id', // Ensure product exists if provided
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'note' => 'nullable|string|max:1000',
            'status' => 'required|string|in:approved,not_approved,canceled', // Enum validation
        ]);
    
        // Determine the authenticated user and type
        $user = auth()->user(); // Assuming you are using Laravel's default auth
        $type = $user instanceof \App\Models\Admin ? 'Admin' : 'Client';
    
        // Add creator details to the validated data
        $validatedData['created_by_id'] = $user->id;
        $validatedData['created_by_type'] = $type;
    
        // Ensure only Admin can set the price
        if ($type === 'Client' && isset($validatedData['price'])) {
            return response()->json([
                'status' => false,
                'message' => 'Only Admin can set the price.',
            ], 403); // Forbidden
        }
    
        // Create the project
        $project = \App\Models\Project::create($validatedData);
    
        // Return the created project using a resource
        return response()->json(new \App\Http\Resources\ProjectResource($project), 201);
    }
    

}
