<?php

namespace App\Http\Requests\Contragents;

use Illuminate\Foundation\Http\FormRequest;

class StoreContragentsRequest extends FormRequest
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
            'name'        => 'required|string',
            'type_id'     => 'exists:contragent_types,id',
            'edrpou'      => 'digits:8',
            'contract_no' => 'nullable|string|max:16',
        ];
    }
}
