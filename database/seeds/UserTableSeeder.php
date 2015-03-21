<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    /**
     * table
     *  
     * @var string
     */
    private $table = 'users';

    /**
     * user repository
     * 
     * @var \Bausch\Repositories\UserRepositoryInterface
     */
    private $repo;

    /**
     * Constructor
     * 
     * @param Bausch\Repositories\UserRepositoryInterface $repo
     */
    public function __construct(SQLgreyGUI\Repositories\UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function run()
    {
        DB::table($this->table)->delete();

        $user = $this->repo->instance();

        $user->setUsername('admin');
        $user->setPassword('joh316');
        $user->setEmail('root@localhost.tld');
        $user->setEnabled(true);

        // save the new user
        $this->repo->store($user);
    }

}
