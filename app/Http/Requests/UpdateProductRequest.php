<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image' => ['sometimes', 'nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'variants' => 'nullable|array',
            'variants.*.size' => 'required_with:variants|string',
            'variants.*.price' => 'required_with:variants|numeric',
        ];
    }
}
