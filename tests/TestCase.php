<?php

use Illuminate\Contracts\Auth\Authenticatable;
use SQLgreyGUI\Repositories\UserRepositoryInterface as Users;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Admin.
     *
     * @var \SQLgreyGUI\Models\User
     */
    protected $acting_as_admin;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Acting as admin.
     *
     * @param Authenticatable|null $admin
     *
     * @return $this
     */
    protected function actingAsAdmin(Authenticatable $admin = null)
    {
        if (is_null($admin)) {
            $admin = $this->acting_as_admin;
        }

        if (is_null($admin)) {
            $admin = app(Users::class)->findById(1);
            $this->acting_as_admin = $admin;
        }

        return $this->actingAs($admin);
    }
}
