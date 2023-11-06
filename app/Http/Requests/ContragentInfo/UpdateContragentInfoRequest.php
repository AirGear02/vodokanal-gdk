<?php

namespace App\Http\Requests\ContragentInfo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContragentInfoRequest extends FormRequest
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
            'avg_water_usage'                  => 'nullable|numeric|min:0',
            'date'                             => 'nullable|date',
            'comment_1'                        => 'nullable|string',
            'coefficient'                      => 'nullable|numeric',
            'gdk_exceeding_letter_date'        => 'nullable|date',
            'invoice_issuance_date'            => 'nullable|date',
            'invoice_due_date'                 => 'nullable|date',
            'penalty_amount'                   => 'nullable|numeric|min:0',
            'penalty_comment'                  => 'nullable|string',
            'application_increasing_coef_date' => 'nullable|date',
            'applied_coefficient'              => 'nullable|numeric|min:0',
            'disconnection_notification_date'  => 'nullable|date',
            'disconnection_date'               => 'nullable|date',
            'is_disconnected'                  => 'nullable|boolean',
            'comment_2'                        => 'nullable|string',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->has('is_disconnected')) {
            $this->merge(['is_disconnected' => $this->boolean('is_disconnected')]);
        }
    }
}
