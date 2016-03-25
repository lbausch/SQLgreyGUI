<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_users_are_displayed()
    {
        $this->actingAsAdmin()
            ->visit(action('UserController@index'))
            ->see($this->acting_as_admin->username)
            ->see($this->acting_as_admin->email);
    }

    public function test_add_user()
    {
        $this->actingAsAdmin()
            ->post(action('UserController@store'), [
                'username' => 'foobar',
                'email' => 'foo@bar.baz',
                'enabled' => 'yes',
                'password' => 'secret',
                'password_confirmation' => 'secret',
            ])
            ->seeInDatabase('users', [
                'username' => 'foobar',
                'email' => 'foo@bar.baz',
                'enabled' => true,
            ]);
    }

    public function test_delete_user()
    {
        $user = factory(\SQLgreyGUI\Models\User::class)->create();

        $this->actingAsAdmin()
            ->visit(action('UserController@index'))
            ->submitForm('delete selected', [
                'userids' => [
                    0 => false,
                    1 => $user->getKey(),
                ],
            ])
            ->see('Deleted Users: 1')
            ->notSeeInDatabase('users', [
                'userid' => $user->getKey(),
            ]);
    }
}
