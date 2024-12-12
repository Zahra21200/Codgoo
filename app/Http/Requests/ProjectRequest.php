<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set to true or add your logic for authorization
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'created_by_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $type = request()->input('created_by_type');
                    if ($type === 'Admin' && !\App\Models\Admin::where('id', $value)->exists()) {
                        $fail('The selected admin does not exist.');
                    } elseif ($type === 'Client' && !\App\Models\Client::where('id', $value)->exists()) {
                        $fail('The selected client does not exist.');
                    }
                },
            ],
            'created_by_type' => 'required|string|in:Admin,Client',
        ];
    }
}
