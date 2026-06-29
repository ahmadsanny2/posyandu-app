<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreElderlyRequest extends FormRequest
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
            'birth_date' => 'required|date|before_or_equal:today',
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
            'name.required' => 'Nama lansia wajib diisi.',
            'name.string' => 'Nama lansia harus berupa teks.',
            'name.max' => 'Nama lansia maksimal 255 karakter.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Tanggal lahir harus berupa format tanggal yang valid.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
            'medical_history.string' => 'Riwayat penyakit harus berupa teks.',
            'user_id.exists' => 'Akun orang tua tidak terdaftar di sistem.',
        ];
    }
}
