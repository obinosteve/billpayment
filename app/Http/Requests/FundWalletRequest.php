<?php

namespace App\Http\Requests;

class FundWalletRequest extends BaseRequest
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
            'amount' => ['required', 'numeric', 'min:5']
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Please enter an amount greater than 5',
            'amount.numeric' => 'Invalid amount provided.',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge(['amount' => str_replace(',', '', $this->amount)]);
    }
}
