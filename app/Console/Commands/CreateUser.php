<?php

namespace SQLgreyGUI\Console\Commands;

use Illuminate\Console\Command;
use SQLgreyGUI\Repositories\UserRepositoryInterface;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sqlgreygui:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Users.
     *
     * @var UserRepositoryInterface
     */
    protected $users;

    /**
     * Create a new command instance.
     */
    public function __construct(UserRepositoryInterface $users)
    {
        parent::__construct();

        $this->users = $users;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $username = $this->ask('Please enter the username');
        $email = $this->ask('Please enter the email address');

        $password = $this->secret('Please enter the password');
        $password_confirmation = $this->secret('Please confirm the password');

        if ($password !== $password_confirmation) {
            $this->error('Passwords do not match');

            return;
        }

        $user = $this->users->instance([
            'username' => $username,
            'email' => $email,
        ]);

        $user->setPassword($password);
        $user->setEnabled(true);

        $this->users->store($user);

        $this->info('User was created');
    }
}
