<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends BaseRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($this->route('uuid'), 'uuid'),
            ],
            'description' => 'nullable|string|max:255',
            'parent_id' => 'nullable|integer',

            'uuid' => [
                'required',
                'uuid',
                Rule::exists('categories', 'uuid'),
            ],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->route('uuid')) {
            $this->merge([
                'uuid' => $this->route('uuid'),
            ]);
        }
    }
}
