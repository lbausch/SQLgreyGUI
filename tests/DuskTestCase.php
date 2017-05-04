<?php

namespace Tests;

use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * User.
     *
     * @var \SQLgreyGUI\Models\User
     */
    protected $user;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()
        );
    }

    /**
     * Get User.
     *
     * @return \SQLgreyGUI\Models\User
     */
    protected function getUser()
    {
        if (!$this->user) {
            $this->user = factory(\SQLgreyGUI\Models\User::class)->create([
                'username' => 'admin',
                'email' => 'admin@localhost.local',
            ]);
        }

        return $this->user;
    }
}
