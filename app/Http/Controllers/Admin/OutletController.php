<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOutletRequest;
use App\Http\Requests\UpdateOutletRequest;
use App\Models\Outlet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $outlets = Outlet::with(['users', 'orders', 'productStocks'])
            ->when(request('search'), function ($q, $v) {
                $q->where(function ($query) use($v) {
                    $query->where('name', 'LIKE', "%$v%")
                        ->orWhere('address', 'LIKE', "%$v%");
                }); 
            })
            ->when(filled(request('is_active')), function ($q) {
                $q->where('is_active', request('is_active'));
            })
            ->paginate(5);
        return view('admin.outlets.index', compact('outlets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.outlets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOutletRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                Outlet::create([
                    'name' => $request->validated('name'),
                    'code' => $request->validated('code'),
                    'address' => $request->validated('address'),
                    'phone' => $request->validated('phone'),
                    'is_active' => $request->validated('is_active') ?? true
                ]);
            });
            return redirect()->route('admin.outlets.index')->with('success', 'Outlet created successfully');
        } catch (\Exception $error) {
            return redirect()->back()->withErrors(['error' => $error->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Outlet $outlet): View
    {
        return view('admin.outlets.edit', compact('outlet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOutletRequest $request, Outlet $outlet): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $outlet) {
                $outlet->update([
                    'name' => $request->validated('name'),
                    'code' => $request->validated('code'),
                    'address' => $request->validated('address'),
                    'phone' => $request->validated('phone'),
                    'is_active' => $request->validated('is_active') ?? true
                ]);
            });
            return redirect()->route('admin.outlets.index')->with('success', 'Outlet updated successfully');
        } catch (\Exception $error) {
            return redirect()->back()->withErrors(['error' => $error->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outlet $outlet): RedirectResponse
    {
        try {
            $outlet->delete();
            return redirect()->route('admin.outlets.index')->with('success', 'Outlet deleted succesfully');
        } catch (\Exception $error) {
            return redirect()->back()->withErrors(['error' => $error->getMessage()]);
        }
    }

    public function toggleStatus(Outlet $outlet): RedirectResponse{
        $outlet->update([
            'is_active' => !$outlet->is_active
        ]);
        return back();
    }
}
