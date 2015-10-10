<?php

namespace SQLgreyGUI\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    /**
     * Show login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Login.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $req)
    {
        // Declare the rules for the form validation.
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $remember = ($req->input('rememberme') == 'yes') ? true : false;

        // Validate the inputs.
        $this->validate($req, $rules);

        // Try to log the user in.
        if (Auth::attempt([
            'username' => $req->input('username'),
            'password' => $req->input('password'),
            'enabled' => 1,
        ], $remember)
        ) {

            // Redirect to dashboard
            return redirect()->intended('/')
                ->withSuccess('You have logged in successfully');
        }

        // Redirect to the login page
        return redirect(action('AuthController@showLogin'))
            ->withErrors(['general' => 'Username/ Password invalid'])
            ->withInput($req->except('password'));
    }

    /**
     * logout.
     *
     * @return Response
     */
    public function logout()
    {
        Auth::logout();

        // Redirect to homepage
        return redirect('/')
            ->withSuccess('You are logged out');
    }
}
