<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TenantController extends Controller
{
    /**
     * Display provider view
     */
    public function index(): View
    {
        $tenants = Tenant::orderBy('name')->get();
        return view('tenant.index', compact('tenants'));
    }

    /**
     * Display the user's profile form.
     */
    public function create(): View
    {
        return view('tenant.create');
    }

    /**
     * Display the user's profile form.
     */
    public function store(Request $request): RedirectResponse 
    {
        $tenant = new Tenant();
        $tenant->uuid = Str::uuid()->toString();
        $tenant->name = $request->name;
        $tenant->domain = $request->domain;
        $tenant->is_locked = $request->has('is_locked') ? true : false;
        $tenant->save();

        return Redirect::route('tenants')->with('status', 'provider-created');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Tenant $tenant): View
    {
        return view('tenant.edit', [
            'tenant' => $tenant
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, Tenant $tenant): RedirectResponse
    {
        try 
        {
            $tenant->name = $request->name;
            $tenant->domain = $request->domain;
            $tenant->is_locked = $request->has('is_locked') ? true : false;
            $tenant->update();
        }
        catch(\Exception $e)
        {
            return Redirect::route('tenants')->with('status', 'error');
        }

        return Redirect::route('tenants')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Tenant $tenant): RedirectResponse
    {
        $tenant->delete();
        return Redirect::route('tenants')->with('status', 'profile-deleted');
    }
}
