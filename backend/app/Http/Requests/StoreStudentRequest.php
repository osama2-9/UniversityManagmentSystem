<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'first_name' => 'required|max:225',
            'last_name' => 'required|max:225',
            'email' => 'required|email|unique:students',
            'phone' => 'required|string',
            'gender' => 'required|in:male,female',
            'college' => 'required|string|max:255',
            'date_of_birth' => 'required',
            'studant_address' => 'required|string|max:500',
        ];
    }
}
