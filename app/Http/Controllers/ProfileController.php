<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
            'telephone' => 'required|string|max:20',
        ]);

        // Update user with validated data
        $user = $request->user();
        $user->fill($validatedData);
        $user->save();

        return Redirect::route('profile.show')->with('status', 'Profile updated successfully');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        // Validate the password fields
        $request->validate([
            'current_password' => ['required', 'current_password'], // Make sure the current password is correct
            'password' => ['required', 'confirmed', 'min:8'], // New password and confirmation should match
        ]);

        $user = $request->user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->pwd)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        // Update the password if the current password matches
        $user->pwd = Hash::make($request->password);
        $user->save();

        return Redirect::route('profile.show')->with('status', 'Mot de passe mis à jour avec succès');
    }

    /**
     * Display the profile page.
     */
    public function show(): View
    {
        $user = Auth::user();
        return view('parent.profile', compact('user'));
    }
}
