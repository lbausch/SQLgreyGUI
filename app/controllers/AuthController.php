<?php

class AuthController extends \BaseController {

    /**
     * Constructor 
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * show login form
     *
     * @return Response
     */
    public function showLogin() {
        return View::make('auth.login');
    }

    public function login() {
        // Get all the inputs
        $userdata = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        );

        // Declare the rules for the form validation.
        $rules = array(
            'username' => 'required',
            'password' => 'required'
        );


        $remember = (Input::get('rememberme') == 'yes') ? true : false;

        // Validate the inputs.
        $validator = Validator::make($userdata, $rules);

        // Check if the form validates with success.
        if ($validator->passes()) {

            // Try to log the user in.
            if (Auth::attempt($userdata, $remember)) {
                // Redirect to dashboard
                return Redirect::intended('/')->with('success', 'You have logged in successfully');
            } else {
                // Redirect to the login page.
                return Redirect::action('AuthController@showLogin')->withErrors(array('general' => 'Username/ Password invalid'))->withInput(Input::except('password'));
            }
        }

        // Something went wrong.
        return Redirect::action('AuthController@showLogin')->withErrors($validator)->withInput(Input::except('password'));
    }

    /**
     * logout
     *
     * @return Response
     */
    public function logout() {
        Auth::logout();

        // Redirect to homepage
        return Redirect::to('/')->with('success', 'You are logged out');
    }

}
