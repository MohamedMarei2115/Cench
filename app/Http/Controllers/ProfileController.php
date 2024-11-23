<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
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
        return view('profile.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        if(strlen($request->password)> 1){
            $request->validate([
                'password' => [
                    'sometimes',
                    function ($attribute, $value, $fail) {
                        if (strlen($value) < 6 || strlen($value) > 50) {
                            $fail('The ' . $attribute . ' must be between 6 and 50 characters.');
                        }
                    }
                ],
            ]);
            if(User::where('id',Auth::user()->id)->update([
                'username' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ])){
                return redirect()->back()->with('success', 'The data has been saved successfully');
            }

        }else{
            if(User::where('id',Auth::user()->id)->update([
                'username' => $request->name,
                'email' => $request->email,
            ])){
                return redirect()->back()->with('success', 'The data has been saved successfully');
            }
        }

        return redirect()->back()->with('error', 'An error occurred, try again');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
