<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreToddlerMeasurementRequest extends FormRequest
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
            'toddler_id' => 'required|exists:toddlers,id',
            'schedule_id' => 'required|exists:schedules,id',
            'weight_kg' => 'required|numeric|min:0.5|max:100',
            'height_cm' => 'required|numeric|min:20|max:200',
            'head_circumference_cm' => 'required|numeric|min:10|max:100',
            'immunization_type' => 'nullable|string|max:255',
            'action_notes' => 'nullable|string',
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
            'toddler_id.required' => 'Balita wajib dipilih.',
            'toddler_id.exists' => 'Balita tidak terdaftar di sistem.',
            'schedule_id.required' => 'Jadwal kegiatan wajib dipilih.',
            'schedule_id.exists' => 'Jadwal kegiatan tidak terdaftar di sistem.',
            'weight_kg.required' => 'Berat badan wajib diisi.',
            'weight_kg.numeric' => 'Berat badan harus berupa angka.',
            'weight_kg.min' => 'Berat badan minimal 0.5 kg.',
            'weight_kg.max' => 'Berat badan maksimal 100 kg.',
            'height_cm.required' => 'Tinggi badan wajib diisi.',
            'height_cm.numeric' => 'Tinggi badan harus berupa angka.',
            'height_cm.min' => 'Tinggi badan minimal 20 cm.',
            'height_cm.max' => 'Tinggi badan maksimal 200 cm.',
            'head_circumference_cm.required' => 'Lingkar kepala wajib diisi.',
            'head_circumference_cm.numeric' => 'Lingkar kepala harus berupa angka.',
            'head_circumference_cm.min' => 'Lingkar kepala minimal 10 cm.',
            'head_circumference_cm.max' => 'Lingkar kepala maksimal 100 cm.',
            'immunization_type.max' => 'Tipe imunisasi maksimal 255 karakter.',
        ];
    }
}
