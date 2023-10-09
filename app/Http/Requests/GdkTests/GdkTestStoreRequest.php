<?php

namespace App\Http\Requests\GdkTests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GdkTestStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contragent_id'                       => 'required|exists:contragents,id',
            'act_no'                              => ['required', Rule::unique('gdk_tests', 'act_no')->whereNull('deleted_at')],
            'date'                                => 'required|date',
            'measurements'                        => 'required|array',
            'measurements.*.id'                   => 'exists:gdk_measurements:id',
            'measurements.*.value'                => 'required|numeric|nullable',
            'measurements.*.proposed_coefficient' => 'required|numeric|nullable',
            'measurements.*.real_coefficient'     => 'required|numeric|nullable',
        ];
    }
}
