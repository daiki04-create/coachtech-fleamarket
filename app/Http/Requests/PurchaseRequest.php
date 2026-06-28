<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
        'payment_method' => ['required', 'string'],
        'stripeToken'    => ['required_if:payment_method,card'],
        'post_code'      => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
        'address'        => ['required', 'string', 'max:255'],
        'building'       => ['nullable', 'string', 'max:255'],
    ];
    }

    public function messages(): array
    {
    return [
        'payment_method.required' => '決済方法を選択してください',
        'post_code.required'      => '郵便番号を入力してください',
        'post_code.regex'         => '郵便番号はハイフンありの8文字で入力してください',
        'address.required'        => '住所を入力してください',
    ];
    }
}
