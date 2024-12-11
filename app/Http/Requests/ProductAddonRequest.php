<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAddonRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'addon_id' => 'required|exists:addons,id',
        ];
    }
}
