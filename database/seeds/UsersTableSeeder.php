<?php

use Illuminate\Database\Seeder;
use SQLgreyGUI\Repositories\UserRepositoryInterface;

class UsersTableSeeder extends Seeder
{
    /**
     * Users.
     *
     * @var \SQLgreyGUI\Repositories\UserRepositoryInterface
     */
    protected $users;

    /**
     * Constructor.
     *
     * @param UserRepositoryInterface $users
     */
    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    public function run()
    {
        $user = $this->users->instance();

        $user->setUsername('admin');
        $user->setPassword('joh316');
        $user->setEmail('root@localhost.tld');
        $user->setEnabled(true);

        // Save the new user
        $this->users->store($user);
    }
}
