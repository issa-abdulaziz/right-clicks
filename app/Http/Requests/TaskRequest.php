<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('tasks')->ignore($this->task ?? 0)],
            'description' => 'required|string|max:255',
            'status' => 'required|in:pended,completed,cancelled,in_progress,canceled',
            'users' => 'required|array',
            'users.*' => 'required|exists:users,id',
        ];
    }

    public function attributes()
    {
        return [
            'users.*' => 'User',
        ];
    }
}
