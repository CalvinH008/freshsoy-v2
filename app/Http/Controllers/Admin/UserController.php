<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
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
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
        } catch (\Exception $error) {
            return redirect()->back()->withErrors(['error' => $error->getMessage()]);
        }
    }
}
