<?php

namespace SQLgreyGUI\Http\Controllers;

use Illuminate\Http\Request;
use SQLgreyGUI\Repositories\UserRepositoryInterface as Users;
use SQLgreyGUI\Models\User as User;

class UserController extends Controller
{

    /**
     * user repository
     * 
     * @var Users
     */
    private $users;

    /**
     * constructor
     * 
     * @param Users $users
     */
    public function __construct(Users $users)
    {
        parent::__construct();

        $this->users = $users;
    }

    /**
     * draw the users table
     * 
     * @return Respone
     */
    public function getTable()
    {
        $users = $this->users->findAll();

        return view('user.table')
                        ->with('users', $users);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('user.index')
                        ->with('users_table', $this->getTable());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('user.form')
                        ->with('form', [
                            'action' => 'UserController@store',
                            'method' => 'POST',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $req)
    {
        $input = $req->input();

        $new_user = $this->users->instance($input);

        if (@$input['enabled'] == 'yes') {
            $input['enabled'] = true;
            $new_user->setEnabled(true);
        } else {
            $input['enabled'] = false;
            $new_user->setEnabled(false);
        }

        $message = 'User ' . $new_user->getUsername() . ' (' . $new_user->getEmail() . ') was created.';

        if (!@$input['password'] && !@$input['password_confirmation']) {
            // generate a random password
            $random_password = str_random(8);

            $input['password'] = $random_password;
            $input['password_confirmation'] = $random_password;

            $message .= '<br />Password: ' . $random_password;
        }

        $new_user->setPassword($input['password']);

        $validator = \Validator::make($input, User::$rules['store']);

        if (!$validator->passes()) {
            \Input::flashExcept('password', 'password_confirmation');

            return $this->create()
                            ->withErrors($validator);
        }


        $this->users->store($new_user);

        return \Html::alert('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = $this->users->findById($id);

        if ($this->isAjax()) {
            return view('user.form')
                            ->with('form', [
                                'action' => ['UserController@update', $id],
                                'method' => 'PUT',
                            ])
                            ->with('userdata', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $req, $id)
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

        $message = 'User ' . $user->getUsername() . ' (' . $user->getEmail() . ') has been updated.';

        if (!@$input['password'] && !@$input['password_confirmation']) {
            unset($input['password']);
            unset($input['password_confirmation']);
        }

        $rules = User::$rules['update'];
        $rules['username'] .= $id;

        $validator = \Validator::make($input, $rules);

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

        return \Html::alert('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * delete multiple users
     * 
     * @return Response
     */
    public function deleteUsers(Request $req)
    {
        $delete_ids = $req->input('userids', []);

        // prevent the logged in user from deleting his own record
        // (thank you Stack Overflow! http://stackoverflow.com/a/7225113)
        if (($key = array_search($this->userid, $delete_ids)) !== false) {
            unset($delete_ids[$key]);
        }

        $num_deletes = 0;

        foreach ($delete_ids as $key => $val) {
            $delete_user = $this->users->findById($val);

            if ($this->users->destroy($delete_user)) {
                $num_deletes++;
            }
        }

        return redirect(action($this->getAction('index')))
                        ->withSuccess('Deleted Users: ' . $num_deletes);
    }

}
