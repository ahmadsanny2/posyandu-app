<?php

namespace App\Http\Controllers;

use App\Models\Toddler;
use App\Models\User;
use App\Http\Requests\StoreToddlerRequest;
use App\Http\Requests\UpdateToddlerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ToddlerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Toddler::class);

        $query = Toddler::query();

        if ($request->user()->isParent()) {
            // Parent only views their own toddlers
            $query->where('user_id', $request->user()->id);
        } else {
            // Admin and Kader can search and filter
            if ($request->has('search') && $request->search != '') {
                $query->where('name', 'like', '%' . $request->search . '%');
            }
            if ($request->has('parent_id') && $request->parent_id != '') {
                $query->where('user_id', $request->parent_id);
            }
        }

        $toddlers = $query->with('user')->latest()->paginate(10)->withQueryString();
        
        // For filter dropdown
        $parents = User::where('role', 'parent')->get();

        return view('toddlers.index', compact('toddlers', 'parents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Gate::authorize('create', Toddler::class);

        $parents = User::where('role', 'parent')->get();
        return view('toddlers.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreToddlerRequest $request)
    {
        Gate::authorize('create', Toddler::class);

        $validated = $request->validated();

        if ($request->user()->isParent()) {
            $validated['user_id'] = $request->user()->id;
        }

        Toddler::create($validated);

        return redirect()->route('toddlers.index')->with('success', 'Data balita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Toddler $toddler)
    {
        Gate::authorize('view', $toddler);

        // Fetch measurements sorted chronologically for graph/timeline
        $measurements = $toddler->measurements()->with('schedule')->orderBy('created_at', 'asc')->get();

        return view('toddlers.show', compact('toddler', 'measurements'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Toddler $toddler)
    {
        Gate::authorize('update', $toddler);

        $parents = User::where('role', 'parent')->get();
        return view('toddlers.edit', compact('toddler', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateToddlerRequest $request, Toddler $toddler)
    {
        $validated = $request->validated();

        if ($request->user()->isParent()) {
            $validated['user_id'] = $request->user()->id;
        }

        $toddler->update($validated);

        return redirect()->route('toddlers.index')->with('success', 'Data balita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toddler $toddler)
    {
        Gate::authorize('delete', $toddler);

        $toddler->delete();

        return redirect()->route('toddlers.index')->with('success', 'Data balita berhasil dihapus.');
    }
}
