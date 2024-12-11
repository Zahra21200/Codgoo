<?php

// // app/Http/Controllers/ProductController.php
// namespace App\Http\Controllers;

// use App\Http\Requests\ProductRequest;
// use App\Http\Resources\ProductResource;
// use App\Repositories\ProductRepositoryInterface;

// class ProductController extends Controller
// {
//     protected $productRepository;

//     public function __construct(ProductRepositoryInterface $productRepository)
//     {
//         $this->productRepository = $productRepository;
//     }

//     public function index()
//     {
//         $products = $this->productRepository->getAll();
//         return ProductResource::collection($products);
//     }

//     public function show($id)
//     {
//         $product = $this->productRepository->getById($id);
//         return new ProductResource($product);
//     }

//     public function store(ProductRequest $request)
//     {
//         $product = $this->productRepository->create($request);
//         return new ProductResource($product);
//     }

//     public function update(ProductRequest $request, $id)
//     {
//         $product = $this->productRepository->update($id, $request);
//         return new ProductResource($product);
//     }

//     public function destroy($id)
//     {
//         $this->productRepository->delete($id);
//         return response()->json(['message' => 'Product deleted successfully.']);
//     }
// }

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepositoryInterface;
class ProductController extends BaseController
{
    private $repository;
    public function __construct(ProductRepositoryInterface $repository)
    {
        parent::__construct($repository);

    }
}
