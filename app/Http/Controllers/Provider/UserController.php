<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $users = User::where('id', '!=', Auth::user()->id)
            ->orderBy('name')
            ->get();

        return view('section-provider.user.index', compact('users'));
    }

    /**
     * Display the user's profile form.
     */
    public function create(Request $request): View
    {
        $tenants = Tenant::orderBy('name')->get();
        $userTypes = UserType::orderBy('name')->get();

        return view('section-provider.user.create', compact('tenants', 'userTypes'));
    }

    /**
     * Display the user's profile form.
     */
    public function store(UserStoreRequest $request): RedirectResponse 
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type_id = UserType::customer()->id;
        $user->tenant_id = Auth::user()->tenant_id;
        $user->password = Hash::make(Str::random(24));
        $user->is_only_order = true;
        $user->save();

        return Redirect::route('provider.users')->with('success', 'Modifications enregistrées avec succès !');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(User $user): View
    {
        $tenants = Tenant::orderBy('name')->get();
        $userTypes = UserType::orderBy('name')->get();

        return view('section-provider.user.edit', [
            'user' => $user,
            'tenants' => $tenants,
            'userTypes' => $userTypes
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
            $user->update();
        }
        catch(\Exception $e)
        {
            return Redirect::route('provider.users')->with('error', 'Erreur dans la mise à jour');
        }

        return Redirect::route('provider.users')->with('success', 'Mise à jour réussie');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return Redirect::route('provider.users')->with('success', 'Suppression effectuée');
    }
}
