<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreParentUserRequest;
use App\Http\Requests\UpdateParentUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParentUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'parent');

        // Search by name or email
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $parents = $query->latest()->paginate(10)->withQueryString();

        return view('parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('parents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParentUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'parent';

        User::create($validated);

        return redirect()->route('parents.index')->with('success', 'Akun Orang Tua berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $parent)
    {
        return view('parents.edit', compact('parent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParentUserRequest $request, User $parent)
    {
        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $parent->update($validated);

        return redirect()->route('parents.index')->with('success', 'Data Orang Tua berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $parent)
    {
        $parent->delete();

        return redirect()->route('parents.index')->with('success', 'Akun Orang Tua berhasil dihapus.');
    }
}
