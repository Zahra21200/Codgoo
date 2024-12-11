<?php

namespace App\Repositories\Common;

use App\Helpers\ResponseHelper;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;

class CommonRepository
{
    protected const RESOURCE = JsonResource::class;
    protected const REQUEST = Request::class;
    protected $model;


    // protected function getModel(): Model
    // {
    //     return $this->model;
    // }

    public function __construct()
    {

        $this->model = $this->model();

    }
    protected function getModel(): Model
    {
        if (is_string($this->model)) {
            $this->model = app($this->model());
        }

        return $this->model;
    }

    public function model()
    {
        throw new \RuntimeException("Model method not implemented in repository.");
    }

    public function getFilters()
    {
       return [];
    //    return ['grantee' => 'supervising',
    //             'id' => 10];
    }

    public function getRelations()
    {
    //    return ['serviceGrantees' , 'serviceGrantees.service'];

    return [];
    }


    public function getSort()
    {

        // return [ 'order'=> 'desc' , 'sort'=> 'created_at' ];
        return [
            ['sort' => 'created_at', 'order' => 'desc'],
        ];

    }


    public function getPaginat()
    {
        return ['paginat' => false , 'number' => 0];
    }


    public function index(Request $request)
    {
        $query = $this->getModel()
            ->with($this->getRelations())
            ->where($this->getFilters());
    
        // Apply sorting
        foreach ($this->getSort() as $sort) {
            $query->orderBy($sort['sort'], $sort['order']);
        }
    
        $perPage = $request->input('per_page', 10);  // Default to 10
        $paginated = $query->paginate($perPage)->appends($request->query());
    
        // Customize the pagination response
        $customPagination = [
            'data'     => $paginated->items(),
            'from'     => $paginated->firstItem(),
            'per_page' => $paginated->perPage(),
            'to'       => $paginated->lastItem(),
            'total'    => $paginated->total(),
            'count'    =>$paginated->count(),
        ];
    
        return ResponseHelper::success($customPagination, __('messages.list_success'));
    }
    


    public function store(Request $request)
    {
        DB::beginTransaction();
            $requestClass = static::REQUEST;
            $customeRequest = app($requestClass);
            $customeRequest->replace($request->all());
            $validatedData = $customeRequest->validated();

            $model = $this->getModel()->create($validatedData);

        DB::commit();



            return ResponseHelper::success(new (static::RESOURCE)($model), __('messages.add_success') , 201);

    }



    public function update(int $id, Request $request)
{
    $model = $this->getModel()->find($id);

    if (!$model) {
        return response()->json([
            'status' => false,
            'message' => __('messages.not_found'),
        ], 404);
    }

    // Use the specific request class to validate and extract data
    $requestClass = static::REQUEST;
    $customRequest = app($requestClass);
    $customRequest->replace($request->all());
    $validatedData = $customRequest->validated();

    $model->update($validatedData);

    return ResponseHelper::success(new (static::RESOURCE)($model), __('messages.update_success'));
}






    public function delete(int $id): bool
    {
        $model = $this->getModel()->find($id);
        if (!$model) {
            response()->json([
                'status' => false,
                'message' => __('messages.not_found'),
            ], 404)->send();
            return false;
        }

        $model->delete();

        response()->json([
            'message' => __('messages.delete_success'),
            'success' => true,
        ], 200)->send();

        return true;


//         if(!$model){
//             return ResponseHelper::error( __('messages.not_found'),[] , 404);
//         }
//          $model->delete();
//         return ResponseHelper::success( null , __('messages.delete_success') , 200);
    }






    public function show(int $id, array $relations = [])
    {
        $model = $this->getModel()->with($relations)->find($id);
        if(!$model){
            return response()->json([
                'status' => false,
                'message' =>  __('messages.not_found'),
            ]);
        }


        return response()->json([
            'message' => null,
            'success' => true,
            new (static::RESOURCE)($model)
        ], 200);
    }
    // public function show(int $id, array $relations = []): JsonResource
    // {
    //     $model = $this->getModel()->with($relations)->find($id);
    
    //     if (!$model) {
    //         abort(404, __('messages.not_found')); // Use Laravel's abort function to return a JSON response for APIs
    //     }
    
    //     $resourceClass = static::RESOURCE;
    //     return new $resourceClass($model);
    // }
    
    




    protected function respond($data, bool $success = true)
    {
        return response()->json([
            'status' => $success,
            'data' => $data,
        ]);
    }
}
