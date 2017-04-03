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
     * @param Request     $request
     * @param AuthManager $authManager
     *
     * @return \Illuminate\Http\Response
     */
    public function updateMe(Request $request, AuthManager $authManager)
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

    /**
     * Get all Users.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $users = $this->users->findAll();

        return $this->respondCollection($users, new UserTransformer());
    }

    /**
     * Add new User.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'enabled' => 'required|boolean',
            'password' => 'required|min:6|confirmed',
        ]);

        $new_user = $this->users->instance($request->input());
        $new_user->setPassword($request->input('password'));

        $this->users->store($new_user);

        return $this->respondSuccess();
    }

    /**
     * Update User.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->users->findById($id);

        $this->validate($request, [
            'username' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->getId(), 'id'),
            ],
            'enabled' => 'required|boolean',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $this->users->fill($user, $request->input());

        if ($request->input('password')) {
            $user->setPassword($request->input('password'));
        }

        $this->users->update($user);

        return $this->respondSuccess();
    }

    /**
     * Delete multiple Users.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, AuthManager $authManager)
    {
        $user = $authManager->guard()->user();

        $delete_ids = collect($request->input('userids', []));

        // Prevent the logged in user from deleting his own record
        if ($delete_ids->contains($user->getId())) {
            $delete_ids = $delete_ids->reject(function ($id) use ($user) {
                return $id === $user->getId();
            });
        }

        foreach ($delete_ids as $id) {
            $delete_user = $this->users->findById($id);

            $this->users->destroy($delete_user);
        }

        return $this->respondSuccess();
    }
}
