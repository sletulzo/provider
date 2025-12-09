<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Provider;
use App\Models\Unity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UnityController extends Controller
{
    /**
     * Display provider view
     */
    public function index(): View
    {
        $unities = Unity::orderBy('name')->get();
        return view('unity.index', compact('unities'));
    }

    /**
     * Display the user's profile form.
     */
    public function create(Request $request): View
    {
        $unities = Unity::orderBy('name')->get();
        return view('unity.create', compact('unities'));
    }

    /**
     * Display the user's profile form.
     */
    public function store(Request $request): RedirectResponse 
    {
        $unity = new Unity();
        $unity->name = $request->name;
        $unity->save();

        return redirect()
            ->route('unities')
            ->with('success', "Création réussie");
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Unity $unity): View
    {
        return view('unity.edit', [
            'unity' => $unity
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, Unity $unity): RedirectResponse
    {
        $unity->name = $request->name;
        $unity->update();

        return Redirect::route('unities')->with('status', 'unity-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Unity $unity): RedirectResponse
    {
        $unity->delete();
        return Redirect::route('unities')->with('status', 'unity-deleted');
    }
}
