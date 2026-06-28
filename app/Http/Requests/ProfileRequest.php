<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        'name'        => ['required', 'string', 'max:20'],
        'postal_code' => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
        'address'     => ['required', 'string', 'max:255'],
        'building'    => ['nullable', 'string', 'max:255'],
        'img_url'     => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
    ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'お名前を入力してください',
            'name.max'              => 'お名前は20文字以内で入力してください',
            'postal_code.required'  => '郵便番号を入力してください',
            'postal_code.regex'     => '郵便番号はハイフンありの8文字で入力してください',
            'address.required'      => '住所を入力してください',
            'address.max'           => '住所は255文字以内で入力してください',
            'img_url.image'         => '画像ファイルを選択してください',
            'img_url.mimes'         => '画像はjpegまたはpng形式でアップロードしてください',
            'img_url.max'           => '画像は2MB以内でアップロードしてください',
        ];
    }
}
