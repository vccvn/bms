<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

use Validator;

class CheckoutRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        Validator::extend('phone_number', function($attr, $value){
            return preg_match('/^(\+84|0)+[0-9]{9,10}$/si', $value);
        });
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|phone_number',
            'address' => 'required|max:191',
            'note' => 'max:500',
        ];
    }
}
