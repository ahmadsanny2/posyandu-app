<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePregnancyRecordRequest extends FormRequest
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
            'pregnant_woman_id' => 'required|exists:pregnant_women,id',
            'schedule_id' => 'required|exists:schedules,id',
            'weight_kg' => 'required|numeric|min:30|max:200',
            'blood_pressure' => 'required|string|regex:/^\d{2,3}\/\d{2,3}$/',
            'upper_arm_circumference_cm' => 'required|numeric|min:10|max:60',
            'gestational_age_weeks' => 'required|integer|min:1|max:44',
            'fetal_heart_rate' => 'nullable|integer|min:50|max:220',
            'action_notes' => 'required|string',
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
            'pregnant_woman_id.required' => 'Ibu hamil wajib dipilih.',
            'pregnant_woman_id.exists' => 'Ibu hamil tidak terdaftar di sistem.',
            'schedule_id.required' => 'Jadwal kegiatan wajib dipilih.',
            'schedule_id.exists' => 'Jadwal kegiatan tidak terdaftar di sistem.',
            'weight_kg.required' => 'Berat badan wajib diisi.',
            'weight_kg.numeric' => 'Berat badan harus berupa angka.',
            'weight_kg.min' => 'Berat badan minimal 30 kg.',
            'weight_kg.max' => 'Berat badan maksimal 200 kg.',
            'blood_pressure.required' => 'Tekanan darah wajib diisi.',
            'blood_pressure.regex' => 'Format tekanan darah tidak valid (contoh: 120/80).',
            'upper_arm_circumference_cm.required' => 'Lingkar lengan atas (LILA) wajib diisi.',
            'upper_arm_circumference_cm.numeric' => 'LILA harus berupa angka.',
            'gestational_age_weeks.required' => 'Usia kandungan wajib diisi.',
            'gestational_age_weeks.integer' => 'Usia kandungan harus berupa angka bulat.',
            'fetal_heart_rate.integer' => 'Denyut jantung janin harus berupa angka.',
            'action_notes.required' => 'Catatan pemeriksaan / tindakan wajib diisi.',
        ];
    }
}
