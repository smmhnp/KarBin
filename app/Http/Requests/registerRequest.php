<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class registerRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'nickname' => 'required|string|max:255|unique:users,nickname',
            'role' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'firstname.required' => 'نام کوچک را وارد کنید.',
            'firstname.string' => 'نام کوچک باید متنی باشد.',
            'firstname.max' => 'نام کوچک نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

            'lastname.required' => 'نام خانوادگی را وارد کنید.',
            'lastname.string' => 'نام خانوادگی باید متنی باشد.',
            'lastname.max' => 'نام خانوادگی نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

            'nickname.required' => 'نام مستعار را وارد کنید.',
            'nickname.string' => 'نام مستعار باید متنی باشد.',
            'nickname.max' => 'نام مستعار نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',
            'nickname.unique' => 'نام مستعار قبلاً استفاده شده است.',

            'role.required' => 'نقش را وارد کنید.',
            'role.string' => 'نقش باید متنی باشد.',
            'role.max' => 'نقش نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

            'unit.required' => 'واحد را وارد کنید.',
            'unit.string' => 'واحد باید متنی باشد.',
            'unit.max' => 'واحد نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',

            'email.required' => 'ایمیل را وارد کنید.',
            'email.email' => 'فرمت ایمیل صحیح نیست.',
            'email.max' => 'ایمیل نمی‌تواند بیش از ۲۵۵ کاراکتر باشد.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',

            'password.required' => 'رمز عبور را وارد کنید.',
            'password.confirmed' => 'تأیید رمز عبور با رمز عبور مطابقت ندارد.',
            'password.min' => 'رمز عبور باید حداقل ۶ کاراکتر باشد.',
        ];
    }
}
