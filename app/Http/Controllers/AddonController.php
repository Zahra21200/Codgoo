<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddonRequest;
use App\Http\Resources\AddonResource;
use App\Repositories\AddonRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddonController extends BaseController
{
    private $repository;

    public function __construct(AddonRepositoryInterface $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'name' => 'required|string|max:255',
            'icon' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->toArray()], 422);
        }

        if ($request->hasFile('icon')) {
            // تخزين الملف في مجلد product_media داخل storage/app/public
            $filePath = $request->file('icon')->store('product_media', 'public');
        } else {
            // إذا لم يتم رفع أي ملف
            return response()->json(['message' => 'No file uploaded.'], 400);
        }

        // إضافة المسار المحدث للملف إلى البيانات
        $validatedData = $validator->validated(); // استخدمنا `validated()` للحصول على البيانات الموثقة
        $validatedData['icon'] = $filePath;

        // إنشاء السجل باستخدام الـ repository
        $productMedia = $this->repository->create($validatedData);

        // إرجاع استجابة باستخدام Resource
        return new AddonResource($productMedia);
    }

    public function update(Request $request, $id)
{
    // Find the addon by ID
    $addon = $this->repository->find($id);

    if (!$addon) {
        return response()->json(['message' => 'Addon not found.'], 404);
    }

    // Validate the request data using AddonRequest's rules
    $validator = Validator::make($request->all(), (new \App\Http\Requests\AddonRequest())->rules());

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()->toArray()], 422);
    }

    $validatedData = $validator->validated();

    // Handle file upload if an icon is provided
    if ($request->hasFile('icon')) {
        // Delete the existing file if it exists
        if ($addon->icon && file_exists(storage_path('app/public/' . $addon->icon))) {
            unlink(storage_path('app/public/' . $addon->icon));
        }

        // Store the new file and update the validated data
        $filePath = $request->file('icon')->store('product_media', 'public');
        $validatedData['icon'] = $filePath;
    }

    // Pass the validated data to the repository's update method
    $updatedAddon = $this->repository->update($id, $validatedData);

    // Return the updated resource
    return new AddonResource($updatedAddon);
}


    
    

}
