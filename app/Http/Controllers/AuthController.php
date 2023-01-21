<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function barcode(Request $request) // 
    {
        $credentials = $request->validate([ // Walidacja danych ( Weryfacja )
            'barcode' => ['required', 'string'],
        ]);

        $user = User::where("barcode", $credentials["barcode"])->first(); // Eloquent ORM 

        if ($user) { 
            Auth::loginUsingId($user->id);  // logowanie 

            return redirect()->intended('list'); 
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email'); 
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)  //
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
