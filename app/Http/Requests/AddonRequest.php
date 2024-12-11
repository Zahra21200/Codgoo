<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddonRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'icon' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
        ];
    }
}
