<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RiskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            's_submitted_by' => ['nullable', 'string'],
            's_organization_id' => ['required', 'integer'], // Là integer theo schema
            's_huppened_on' => ['required', 'date', 'before_or_equal:today'], // Không cho phép ngày tương lai
            's_location' => ['required', 'string', 'max:200'],
            's_details' => ['nullable', 'string'],
            'images' => ['nullable'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Ảnh tối đa 2MB
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['message' => $validator->errors()], 422)
        );
    }
}
