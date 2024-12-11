<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductMediaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
           'product_id' => 'required|exists:products,id',  // Ensure the product exists
            'file_path' => 'required|string',  // Ensure the file path is provided
            'type' => 'required|string',  // Ensure type is provided 
        ];
    }
}

