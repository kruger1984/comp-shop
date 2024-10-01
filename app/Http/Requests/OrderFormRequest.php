<?php

namespace App\Http\Requests;

use Domain\Order\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class OrderFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customer.first_name' => ['required'],
            'customer.last_name'  => ['required'],
            'customer.email'      => ['required', 'email:dns'],
            'customer.phone'      => ['required', new PhoneRule()],
            'customer.city'           => ['required_if:delivery_type_id,2'],
            'customer.address'        => ['required_if:delivery_type_id,2'],
            'create_account'      => ['bool'],
            'password'            => request()->boolean('create_account')
                ? ['required', 'confirmed', Password::defaults()]
                : ['sometimes'],
            'delivery_type_id'    => ['required', 'exists:delivery_types,id'],
            'payment_method_id'   => ['required', 'exists:payment_methods,id']
        ];
    }

    public function messages()
    {
        return [
            'customer.city.required_if'     => 'Поле город обязательно при выборе доставки на адрес.',
            'customer.address.required_if'  => 'Поле адрес обязательно при выборе доставки на адрес.',
        ];
    }
}
