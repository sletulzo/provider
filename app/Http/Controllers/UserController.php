<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display provider view
     */
    public function index(): View
    {
        $users = User::orderBy('name')->get();
        return view('user.index', compact('users'));
    }

    /**
     * Display the user's profile form.
     */
    public function create(Request $request): View
    {
        $tenants = Tenant::orderBy('name')->get();
        return view('user.create', compact('tenants'));
    }

    /**
     * Display the user's profile form.
     */
    public function store(UserStoreRequest $request): RedirectResponse 
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->tenant_id = $request->tenant_id;
        $user->password = Hash::make(Str::random(24));
        $user->save();

        return Redirect::route('users')->with('status', 'provider-created');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(User $user): View
    {
        $tenants = Tenant::orderBy('name')->get();

        return view('user.edit', [
            'user' => $user,
            'tenants' => $tenants
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        try 
        {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->tenant_id = $request->tenant_id;
            $user->update();
        }
        catch(\Exception $e)
        {
            return Redirect::route('users')->with('status', 'error');
        }

        return Redirect::route('users')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return Redirect::route('users')->with('status', 'profile-deleted');
    }
}
