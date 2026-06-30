<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StorePuskesmasRequest;
use App\Http\Requests\UpdatePuskesmasRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PuskesmasUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'puskesmas');

        // Search by name or email
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $puskesmasUsers = $query->latest()->paginate(10)->withQueryString();

        return view('puskesmas.index', compact('puskesmasUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('puskesmas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePuskesmasRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'puskesmas';

        User::create($validated);

        return redirect()->route('puskesmas.index')->with('success', 'Akun Puskesmas berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $puskesmas)
    {
        return view('puskesmas.edit', ['puskesmas' => $puskesmas]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePuskesmasRequest $request, User $puskesmas)
    {
        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $puskesmas->update($validated);

        return redirect()->route('puskesmas.index')->with('success', 'Data Puskesmas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $puskesmas)
    {
        if ($puskesmas->id === auth()->id()) {
            return redirect()->route('puskesmas.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $puskesmas->delete();

        return redirect()->route('puskesmas.index')->with('success', 'Akun Puskesmas berhasil dihapus.');
    }
}
