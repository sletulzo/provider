<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Concerns\AuthorizesProviderClients;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
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
    use AuthorizesProviderClients;

    public function index(): View
    {
        $customerType = UserType::customer();

        $users = User::query()
            ->where('tenant_id', Auth::user()->tenant_id)
            ->where('is_only_order', true)
            ->when($customerType, fn ($query) => $query->where('user_type_id', $customerType->id))
            ->orderBy('name')
            ->get();

        return view('section-provider.user.index', compact('users'));
    }

    public function create(Request $request): View
    {
        return view('section-provider.user.create');
    }

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

        return Redirect::route('provider.users')->with('success', 'Client créé avec succès.');
    }

    public function edit(User $user): View
    {
        $this->ensureProviderClient($user);

        return view('section-provider.user.edit', [
            'user' => $user,
        ]);
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $this->ensureProviderClient($user);

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->update();
        } catch (\Exception $e) {
            return Redirect::route('provider.users')->with('error', 'Erreur dans la mise à jour');
        }

        return Redirect::route('provider.users')->with('success', 'Mise à jour réussie');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->ensureProviderClient($user);

        $user->delete();

        return Redirect::route('provider.users')->with('success', 'Suppression effectuée');
    }
}
