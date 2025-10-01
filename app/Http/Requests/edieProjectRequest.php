<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PhpParser\Builder\Function_;
use Psy\CodeCleaner\FunctionContextPass;

class edieProjectRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'undertaking' => 'required',
            'deadline' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'لطفاً عنوان تسک را وارد کنید.',
            'title.max' => 'عنوان تسک نباید بیشتر از ۲۵۵ کاراکتر باشد.',
            'undertaking.required' => 'لطفاً مسئولیت را وارد کنید.',
            'deadline.required' => 'لطفاً تاریخ انقضا را وارد کنید.',
            'deadline.date' => 'لطفاً تاریخ را به صورت صحیح وارد کنید.',
        ];
    }
}
