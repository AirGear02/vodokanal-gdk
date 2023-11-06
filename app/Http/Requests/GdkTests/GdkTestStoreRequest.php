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
            'act_no'                              => ['required', Rule::unique('gdk_tests', 'act_no')->whereNull('deleted_at')],
            'penalty_amount'                      => 'required|nullable|min:0',
            'tariff'                              => 'required|nullable|min:0',
            'applied_coefficient'                 => 'required|min:0',
            'water_usage'                         => 'required|min:0',
            'date'                                => 'required|date',
            'measurements'                        => 'required|array',
            'measurements.*.id'                   => 'required|exists:gdk_measurements,id',
            'measurements.*.value'                => 'nullable|numeric',
            'measurements.*.proposed_coefficient' => 'nullable|numeric|nullable',
            'measurements.*.real_coefficient'     => 'nullable|numeric|nullable',
        ];
    }
}
