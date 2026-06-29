<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePregnantWomanRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'pregnancy_age_weeks' => 'required|integer|min:1|max:44',
            'estimated_delivery_date' => 'required|date|after_or_equal:today',
            'address' => 'nullable|string',
            'medical_history' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama ibu hamil wajib diisi.',
            'name.string' => 'Nama ibu hamil harus berupa teks.',
            'name.max' => 'Nama ibu hamil maksimal 255 karakter.',
            'pregnancy_age_weeks.required' => 'Usia kandungan wajib diisi.',
            'pregnancy_age_weeks.integer' => 'Usia kandungan harus berupa angka.',
            'pregnancy_age_weeks.min' => 'Usia kandungan minimal 1 minggu.',
            'pregnancy_age_weeks.max' => 'Usia kandungan maksimal 44 minggu.',
            'estimated_delivery_date.required' => 'Hari Perkiraan Lahir (HPL) wajib diisi.',
            'estimated_delivery_date.date' => 'HPL harus berupa format tanggal yang valid.',
            'estimated_delivery_date.after_or_equal' => 'HPL tidak boleh sebelum hari ini.',
            'user_id.exists' => 'Akun orang tua tidak terdaftar di sistem.',
        ];
    }
}
