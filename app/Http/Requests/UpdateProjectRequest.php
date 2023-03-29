<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Helpers
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
            'title' => 'required|max:98',
            'type_id' => 'nullable|exists:types,id',
            'name_repo' => [
                'required',
                Rule::unique('projects')->ignore($this->project->id),
                'max:98'
            ],
            'link_repo' => 'required|max:255',
            'description' => 'nullable|max:4096',
            'featured_image' => 'nullable|image|max:2048',
            'delete_featured_image' => 'nullable',
            'technologies' => 'nullable|array|exists:technologies,id',

        ];
    }
}
