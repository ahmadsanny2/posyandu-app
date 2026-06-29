<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreKaderRequest;
use App\Http\Requests\UpdateKaderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'kader');

        // Search by name or email
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $kaders = $query->latest()->paginate(10)->withQueryString();

        return view('kaders.index', compact('kaders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kaders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKaderRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'kader';

        User::create($validated);

        return redirect()->route('kaders.index')->with('success', 'Akun Kader berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $kader)
    {
        return view('kaders.edit', compact('kader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKaderRequest $request, User $kader)
    {
        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $kader->update($validated);

        return redirect()->route('kaders.index')->with('success', 'Data Kader berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $kader)
    {
        if ($kader->id === auth()->id()) {
            return redirect()->route('kaders.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $kader->delete();

        return redirect()->route('kaders.index')->with('success', 'Akun Kader berhasil dihapus.');
    }
}
