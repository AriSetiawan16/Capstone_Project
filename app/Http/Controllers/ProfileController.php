<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        return view('profile.index');
    }

    /**
     * Display the user's profile form for editing.
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Store new photo
            $photoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $photoPath;
        }

        // Update user data
        $user->update($validated);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete user profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada foto untuk dihapus.'
        ], 400);
    }
}
