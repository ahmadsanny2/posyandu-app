<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show the form for editing the system settings.
     */
    public function edit()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Admin.');
        }

        $setting = Setting::firstOrCreate([]);

        return view('settings.edit', compact('setting'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Admin.');
        }

        $validated = $request->validate([
            'posyandu_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'leader_name' => 'nullable|string|max:255',
        ], [
            'posyandu_name.required' => 'Nama Posyandu wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $setting = Setting::firstOrCreate([]);
        $setting->update($validated);

        return redirect()->back()->with('success', 'Konfigurasi Posyandu berhasil diperbarui.');
    }
}
