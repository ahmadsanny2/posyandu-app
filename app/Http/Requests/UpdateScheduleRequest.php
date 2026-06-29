<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'target_type' => 'required|in:toddler,pregnant_woman,elderly',
            'scheduled_at' => 'required|date',
            'location' => 'required|string|max:255',
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
            'title.required' => 'Nama kegiatan wajib diisi.',
            'title.string' => 'Nama kegiatan harus berupa teks.',
            'title.max' => 'Nama kegiatan maksimal 255 karakter.',
            'target_type.required' => 'Tipe sasaran wajib dipilih.',
            'target_type.in' => 'Tipe sasaran harus berupa balita (toddler), ibu hamil (pregnant_woman), atau lansia (elderly).',
            'scheduled_at.required' => 'Tanggal & Waktu kegiatan wajib diisi.',
            'scheduled_at.date' => 'Tanggal & Waktu harus berupa format tanggal-waktu yang valid.',
            'location.required' => 'Lokasi kegiatan wajib diisi.',
            'location.string' => 'Lokasi kegiatan harus berupa teks.',
            'location.max' => 'Lokasi kegiatan maksimal 255 karakter.',
        ];
    }
}
