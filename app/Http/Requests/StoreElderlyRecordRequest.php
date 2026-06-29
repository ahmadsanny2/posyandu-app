<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreElderlyRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin() || $this->user()->isKader();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'elderly_id' => 'required|exists:elderlies,id',
            'schedule_id' => 'required|exists:schedules,id',
            'weight_kg' => 'nullable|numeric|min:20|max:200',
            'blood_pressure' => 'required|string|regex:/^\d{2,3}\/\d{2,3}$/',
            'blood_sugar' => 'nullable|integer|min:20|max:600',
            'cholesterol' => 'nullable|integer|min:50|max:500',
            'uric_acid' => 'nullable|numeric|min:1|max:25',
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
            'elderly_id.required' => 'Lansia wajib dipilih.',
            'elderly_id.exists' => 'Lansia tidak terdaftar di sistem.',
            'schedule_id.required' => 'Jadwal kegiatan wajib dipilih.',
            'schedule_id.exists' => 'Jadwal kegiatan tidak terdaftar di sistem.',
            'blood_pressure.required' => 'Tekanan darah wajib diisi.',
            'blood_pressure.regex' => 'Format tekanan darah tidak valid (contoh: 120/80).',
            'blood_sugar.integer' => 'Gula darah harus berupa angka.',
            'cholesterol.integer' => 'Kolesterol harus berupa angka.',
            'uric_acid.numeric' => 'Asam urat harus berupa angka desimal/bulat.',
        ];
    }
}
