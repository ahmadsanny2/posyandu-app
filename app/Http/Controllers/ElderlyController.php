<?php

namespace App\Http\Controllers;

use App\Models\Elderly;
use App\Models\User;
use App\Http\Requests\StoreElderlyRequest;
use App\Http\Requests\UpdateElderlyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ElderlyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Elderly::class);

        $query = Elderly::query();

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

        $elderlies = $query->with('user')->latest()->paginate(10)->withQueryString();
        $parents = User::where('role', 'parent')->get();

        return view('elderlies.index', compact('elderlies', 'parents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Elderly::class);

        $parents = User::where('role', 'parent')->get();
        return view('elderlies.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreElderlyRequest $request)
    {
        Gate::authorize('create', Elderly::class);

        $validated = $request->validated();

        if ($request->user()->isParent()) {
            $validated['user_id'] = $request->user()->id;
        }

        Elderly::create($validated);

        return redirect()->route('elderlies.index')->with('success', 'Data lansia berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Elderly $elderly)
    {
        Gate::authorize('view', $elderly);

        $records = $elderly->records()->with('schedule')->orderBy('created_at', 'asc')->get();

        return view('elderlies.show', compact('elderly', 'records'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Elderly $elderly)
    {
        Gate::authorize('update', $elderly);

        $parents = User::where('role', 'parent')->get();
        return view('elderlies.edit', compact('elderly', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateElderlyRequest $request, Elderly $elderly)
    {
        $validated = $request->validated();

        if ($request->user()->isParent()) {
            $validated['user_id'] = $request->user()->id;
        }

        $elderly->update($validated);

        return redirect()->route('elderlies.index')->with('success', 'Data lansia berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Elderly $elderly)
    {
        Gate::authorize('delete', $elderly);

        $elderly->delete();

        return redirect()->route('elderlies.index')->with('success', 'Data lansia berhasil dihapus.');
    }
}
