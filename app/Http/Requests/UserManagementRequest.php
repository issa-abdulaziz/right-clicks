<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;

class UserManagementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($this->user ?? 0)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user ?? 0)],
            'password' => [Rule::requiredIf($this->method() === "POST"), 'string', new Password, 'confirmed'],
            'department_id' => 'required|exists:departments,id',
        ];
    }
}
