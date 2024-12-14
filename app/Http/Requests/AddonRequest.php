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
        $rules = [
            'icon' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
        ];
    
        if ($this->isMethod('post')) {
            $rules['name'] = 'required|string|max:255';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['name'] = 'sometimes|required|string|max:255'; // Optional for updates
        }
    
        return $rules;
    }
    
}
