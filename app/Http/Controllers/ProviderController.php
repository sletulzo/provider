<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Provider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProviderController extends Controller
{
    /**
     * Display provider view
     */
    public function index(): View
    {
        $providers = Provider::orderBy('name')->get();
        return view('provider.index', compact('providers'));
    }

    /**
     * Display the user's profile form.
     */
    public function create(Request $request): View
    {
        return view('provider.create');
    }

    /**
     * Display the user's profile form.
     */
    public function store(Request $request): RedirectResponse 
    {
        $provider = new Provider();
        $provider->name = $request->name;
        $provider->email = $request->email;
        $provider->phone = $request->phone;
        $provider->comment = $request->comment;
        $provider->email_content = $request->email_content;
        $provider->save();

        return Redirect::route('providers')->with('status', 'provider-created');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Provider $provider): View
    {
        return view('provider.edit', [
            'provider' => $provider
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, Provider $provider): RedirectResponse
    {
        $provider->name = $request->name;
        $provider->email = $request->email;
        $provider->phone = $request->phone;
        $provider->comment = $request->comment;
        $provider->email_content = $request->email_content;
        $provider->update();

        return Redirect::route('providers')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Provider $provider): RedirectResponse
    {
        $provider->delete();
        return Redirect::route('providers')->with('status', 'profile-deleted');
    }
}
