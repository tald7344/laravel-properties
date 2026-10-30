<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PropertySearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'neighborhood' => ['nullable', 'string', 'max:100'],
            'purpose' => ['nullable', 'in:rent,sale'],
            'city' => ['nullable', 'string', 'max:50'],
            'category' => ['nullable', 'in:residential,commercial'],
            'min_price' => ['nullable', 'numeric', 'min:0', 'max:999999999999.99'],
            'max_price' => ['nullable', 'numeric', 'min:0', 'max:999999999999.99'],
            'min_area' => ['nullable', 'integer', 'min:0', 'max:4294967295'],
            'max_area' => ['nullable', 'integer', 'min:0', 'max:4294967295'],
            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:255'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:255'],
            'floor' => ['nullable', 'integer', 'min:0', 'max:255'],
            'furnished' => ['nullable', 'boolean'],
            'reward' => ['nullable', 'boolean'],
            'sort' => ['nullable', 'in:latest,price_low,price_high'],
        ];
    }
}
