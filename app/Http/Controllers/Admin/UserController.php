<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('viewAny', User::class);
        $users = User::query()
            ->when(request('search'), fn($q, $v) => $q->where('name', 'LIKE', "%$v%")->orWhere('email', 'LIKE', "%$v%"))
            ->when(
                request('role'),
                fn($q, $v) => $q->whereHas('roles', fn($r) => $r->where('name', $v))
            )
            ->with('roles')
            ->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('create', User::class);
        $outlets = Outlet::all();
        return view('admin.users.create', compact('outlets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        Gate::authorize('create', User::class);
        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->validated('name'),
                    'password' => Hash::make($request->validated('password')),
                    'email' => $request->validated('email'),
                    'outlet_id' => $request->validated('outlet_id') ?? null,
                ]);

                $user->assignRole($request->validated('role'));
            });

            return redirect()->route('admin.users.index')->with('success', 'User created successfully');
        } catch (\Exception $error) {
            return redirect()->back()->withErrors(['error' => $error->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        Gate::authorize('update', $user);
        $outlets = Outlet::all();
        return view('admin.users.edit', compact('user', 'outlets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('update', $user);
        try {
            DB::transaction(function () use ($request, $user) {
                $user->update([
                    'name' => $request->validated('name'),
                    'password' => $request->validated('password') ? Hash::make($request->validated('password')) : $user->password,
                    'email' => $request->validated('email'),
                    'outlet_id' => $request->validated('outlet_id') ?? null,
                ]);
                $user->syncRoles($request->validated('role'));
            });

            return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
        } catch (\Exception $error) {
            return redirect()->back()->withErrors(['error' => $error->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete', $user);
        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
        } catch (\Exception $error) {
            return redirect()->back()->withErrors(['error' => $error->getMessage()]);
        }
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);
        return back();
    }
}
