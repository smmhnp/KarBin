<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class taskRequest extends FormRequest
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
            'title_id' => 'required',
            'project_name' => 'required|string|max:255',
            'content' => 'required|string',
            'undertaking' => 'required|string|max:255',
            'preference' => 'required|string|max:255',
            'deadline' => 'required|date',
            'status' => 'required|string|max:255',
            'attachment' => 'nullable|file|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'title_id.required' => 'لطفاً عنوان تسک را وارد کنید.',
            'content.required' => 'لطفاً توضیحات تسک را وارد کنید.',
            'undertaking.required' => 'لطفاً مسئولیت را وارد کنید.',
            'preference.required' => 'لطفاً ترجیحات را وارد کنید.',
            'deadline.required' => 'لطفاً تاریخ انقضا را وارد کنید.',
            'deadline.date' => 'لطفاً تاریخ را به صورت صحیح وارد کنید.',
            'status.required' => 'لطفاً وضعیت تسک را وارد کنید.',
            'attachment.file' => 'فایل آپلودی باید یک فایل معتبر باشد.',
            'attachment.max' => 'حجم فایل نباید بیشتر از ۵ مگابایت باشد.',
        ];
    }
}
