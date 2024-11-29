<?php

namespace App\Http\Requests;

class PurchaseAirtimeRequest extends BaseRequest
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
            'amount' => ['required', 'numeric', 'min:1'],
            'phoneNumber' => ['required', 'numeric', 'unique:users,phone', 'regex:/^(?:070|080|081|090|091)\d{8}$/'],
            'providerId' => ['required', 'numeric', 'exists:network_providers,id']
        ];
    }

    public function messages(): array
    {
        return [
            'providerId.required' => 'No network provider selected',
            'providerId.exists' => 'The selected network provider does not exist',
            'phoneNumber.required' => 'No phone number provided',
            'phoneNumber.regex' => 'Phone number must be a valid number eg. 08067690774',
            'amount.required' => 'No amount provided',
        ];
    }
}
