<?php

namespace SQLgreyGUI\Api\v1\Controllers;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Validation\Rule;
use SQLgreyGUI\Api\v1\Exceptions\ValidationException;
use SQLgreyGUI\Api\v1\Transformers\UserTransformer;
use SQLgreyGUI\Repositories\UserRepositoryInterface as Users;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * User repository.
     *
     * @var Users
     */
    protected $users;

    /**
     * constructor.
     *
     * @param Users $users
     */
    public function __construct(Users $users)
    {
        parent::__construct();

        $this->users = $users;
    }

    /**
     * Get details about authenticated user.
     *
     * @param AuthManager $authManager
     *
     * @return \Illuminate\Http\Response
     */
    public function me(AuthManager $authManager)
    {
        $user = $authManager->guard()->user();

        return $this->respondItem($user, new UserTransformer());
    }

    /**
     * Update authenticated user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuthManager $authManager)
    {
        $user = $authManager->guard()->user();

        $this->validate($request, [
            'username' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->getKey()),
            ],
        ]);

        $user->setUsername($request->input('username'));
        $user->setEmail($request->input('email'));

        $user = $this->users->update($user);

        return $this->respondItem($user, new UserTransformer());
    }

    /**
     * Update password for authenticated user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws ValidationException
     */
    public function password(Request $request, AuthManager $authManager, Hasher $hasher)
    {
        $user = $authManager->guard()->user();

        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if (!$hasher->check($request->input('old_password'), $user->getAuthPassword())) {
            throw new ValidationException([
                'old_password' => 'Old password is incorrect',
            ]);
        }

        $user->setPassword($request->input('password'));

        $user = $this->users->update($user);

        return $this->respondItem($user, new UserTransformer());
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    /*public function store(Request $request)
    {
        $input = $request->input();

        $new_user = $this->users->instance($input);

        if (@$input['enabled'] == 'yes') {
            $input['enabled'] = true;
            $new_user->setEnabled(true);
        } else {
            $input['enabled'] = false;
            $new_user->setEnabled(false);
        }

        $message = 'User '.$new_user->getUsername().' ('.$new_user->getEmail().') was created.';

        if (!@$input['password'] && !@$input['password_confirmation']) {
            // Generate a random password
            $random_password = str_random(8);

            $input['password'] = $random_password;
            $input['password_confirmation'] = $random_password;

            $message .= '<br />Password: '.$random_password;
        }

        $new_user->setPassword($input['password']);

        $validator = Validator::make($input, User::$rules['store']);

        // @TODO: refactor
        if (!$validator->passes()) {
            \Input::flashExcept('password', 'password_confirmation');

            return $this->create()
                ->withErrors($validator);
        }

        $this->users->store($new_user);

        return alert('success', $message);
    }*/

    /*
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    /*public function update(Request $req, $id)
    {
        $user = $this->users->findById($id);

        $input = $req->input();

        if (@$input['enabled'] == 'yes') {
            $input['enabled'] = true;
            $user->setEnabled(true);
        } else {
            $input['enabled'] = false;
            $user->setEnabled(false);
        }

        $user->setUsername($input['username']);
        $user->setEmail($input['email']);

        $message = 'User '.$user->getUsername().' ('.$user->getEmail().') has been updated.';

        if (!@$input['password'] && !@$input['password_confirmation']) {
            unset($input['password']);
            unset($input['password_confirmation']);
        }

        $rules = User::$rules['update'];
        $rules['username'] .= $id;

        $validator = Validator::make($input, $rules);

        if (!$validator->passes()) {
            \Input::flashExcept('password', 'password_confirmation');

            return $this->edit($id)
                ->withErrors($validator);
        }

        if (@$input['password'] && @$input['password_confirmation']) {
            $user->setPassword($input['password']);

            $message .= '<br />Password has been changed.';
        }

        $this->users->update($user);

        return alert('success', $message);
    }*/

    /*
     * Delete multiple users.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function deleteUsers(Request $req)
    {
        $delete_ids = $req->input('userids', []);

        // Prevent the logged in user from deleting his own record
        // (thank you Stack Overflow! http://stackoverflow.com/a/7225113)
        if (($key = array_search($this->user->getKey(), $delete_ids)) !== false) {
            unset($delete_ids[$key]);
        }

        $num_deletes = 0;

        foreach ($delete_ids as $key => $val) {
            $delete_user = $this->users->findById($val);

            if ($this->users->destroy($delete_user)) {
                ++$num_deletes;
            }
        }

        return redact('_self@index')
            ->withSuccess('Deleted Users: '.$num_deletes);
    }*/
}
