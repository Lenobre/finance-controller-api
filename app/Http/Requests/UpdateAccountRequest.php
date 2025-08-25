<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends BaseRequest
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
                Rule::unique('accounts')->ignore($this->route('uuid'), 'uuid'),
            ],
            'description' => 'nullable|string|max:255',
            'balance' => 'required|numeric|decimal:0,2|min:0',
            'uuid' => [
                'required',
                'uuid',
                Rule::exists('accounts', 'uuid'),
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
