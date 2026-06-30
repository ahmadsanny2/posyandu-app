<?php

namespace App\Http\Controllers;

use App\Models\PregnantWoman;
use App\Models\User;
use App\Http\Requests\StorePregnantWomanRequest;
use App\Http\Requests\UpdatePregnantWomanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PregnantWomanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PregnantWoman::query();

        if ($request->user()->isParent()) {
            $query->where('user_id', $request->user()->id);
        } else {
            if ($request->has('search') && $request->search != '') {
                $query->where('name', 'like', '%' . $request->search . '%');
            }
            if ($request->has('parent_id') && $request->parent_id != '') {
                $query->where('user_id', $request->parent_id);
            }
        }

        $pregnantWomen = $query->with('user')->latest()->paginate(10)->withQueryString();
        $parents = User::where('role', 'parent')->get();

        return view('pregnant-women.index', compact('pregnantWomen', 'parents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', PregnantWoman::class);

        $parents = User::where('role', 'parent')->get();
        return view('pregnant-women.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePregnantWomanRequest $request)
    {
        Gate::authorize('create', PregnantWoman::class);

        $validated = $request->validated();

        if ($request->user()->isParent()) {
            $validated['user_id'] = $request->user()->id;
        }

        PregnantWoman::create($validated);

        return redirect()->route('pregnant-women.index')->with('success', 'Data ibu hamil berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PregnantWoman $pregnantWoman)
    {
        Gate::authorize('view', $pregnantWoman);

        $records = $pregnantWoman->records()->with('schedule')->orderBy('created_at', 'asc')->get();

        return view('pregnant-women.show', compact('pregnantWoman', 'records'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PregnantWoman $pregnantWoman)
    {
        Gate::authorize('update', $pregnantWoman);

        $parents = User::where('role', 'parent')->get();
        return view('pregnant-women.edit', compact('pregnantWoman', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePregnantWomanRequest $request, PregnantWoman $pregnantWoman)
    {
        $validated = $request->validated();

        if ($request->user()->isParent()) {
            $validated['user_id'] = $request->user()->id;
        }

        $pregnantWoman->update($validated);

        return redirect()->route('pregnant-women.index')->with('success', 'Data ibu hamil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PregnantWoman $pregnantWoman)
    {
        Gate::authorize('delete', $pregnantWoman);

        $pregnantWoman->delete();

        return redirect()->route('pregnant-women.index')->with('success', 'Data ibu hamil berhasil dihapus.');
    }
}
