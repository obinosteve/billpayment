<?php

namespace App\Http\Requests;


class RegistrationRequest extends BaseRequest
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
            'firstName' => ['required', 'string'],
            'lastName' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phoneNumber' => ['required', 'numeric', 'unique:users,phone', 'regex:/^(?:070|080|081|090|091)\d{8}$/'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.confirmed' => 'The password confirmation field does not match with the password',
            'email.unique' => 'The provided email address already exist',
            'phone.unique' => 'The provided phone number already exist',
            'phone.regex' => 'The phone number must be a valid Nigerian phone number starting with 070, 080, 081, 090, or 091 and contain 11 digits.',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge(['password_confirmation' => $this->passwordConfirmation]);
    }
}
