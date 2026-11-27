<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'min:1'],
            'email' => ['email:dns', 'unique:users,email,' . auth()->id()],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ];
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => str(request('email'))
                ->squish()
                ->lower()
                ->value()
        ]);
    }
}
