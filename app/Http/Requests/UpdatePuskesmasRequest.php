<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePuskesmasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $puskesmasId = $this->route('puskesmas')?->id;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $puskesmasId,
            'password' => 'nullable|string|min:8',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama Puskesmas wajib diisi.',
            'name.string' => 'Nama Puskesmas harus berupa teks.',
            'name.max' => 'Nama Puskesmas maksimal 255 karakter.',
            'email.required' => 'Email Puskesmas wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ];
    }
}
