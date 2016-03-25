<?php

namespace SQLgreyGUI\Http\Controllers;

use Illuminate\Http\Request;
use SQLgreyGUI\Repositories\UserRepositoryInterface as Users;
use Hash;

class SettingController extends Controller
{
    /**
     * Repository.
     *
     * @var Users
     */
    private $users;

    /**
     * Constructor.
     *
     * @param Users $users
     */
    public function __construct(Users $users)
    {
        parent::__construct();

        $this->users = $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setting.index');
    }

    /**
     * Show change password from.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword()
    {
        return view('setting.password');
    }

    /**
     * Change the user password.
     *
     * @return \Illuminate\Http\Response
     */
    public function password(Request $req)
    {
        $rules = [
            'password' => 'required',
            'password_new' => 'required|min:6',
            'password_new_repeat' => 'required|min:6|same:password_new',
        ];

        $this->validate($req, $rules);

        $teh_user = $this->users->findById($this->user->getKey());

        if (Hash::check($req->input('password'), $teh_user->getPassword())) {
            $teh_user->setPassword($req->input('password_new'));
        } else {
            return redirect(action('SettingController@changePassword'))
                ->withErrors(['password' => 'The provided password is not correct']);
        }

        // Update the user
        $teh_user->setPassword($req->input('password_new'));
        $this->users->update($teh_user);

        return redirect(action('SettingController@index'))
            ->withSuccess('Password has been changed');
    }

    /**
     * Show form.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeEmail()
    {
        return view('setting.email');
    }

    /**
     * Change email.
     *
     * @return \Illuminate\Http\Response
     */
    public function email(Request $req)
    {
        $rules = [
            'email' => 'required|email',
        ];

        $this->validate($req, $rules);

        $teh_user = $this->users->findById($this->user->getKey());

        $teh_user->setEmail($req->input('email'));

        $this->users->update($teh_user);

        return redirect(action('SettingController@index'))
            ->withSuccess('eMail has been updated');
    }
}
