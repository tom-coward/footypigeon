<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Validation\Rule;

class AccountSettingsController extends Controller
{
    /**
     * Display the Account Settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account-settings');
    }

    /**
     * Update the logged-in user's DB record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validate form inputs
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore(Auth::user()->id, 'id'),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(Auth::user()->id, 'id'),
            ],
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        return back()->with('status', 'Your account details have been successfully updated.');
    }

    /**
     * Logout the user and redirect them to password reset page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        Auth::logout();

        return redirect(route('password.reset'));
    }
}
