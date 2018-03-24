<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;
use SQLgreyGUI\Models\User;

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
        $options = (new ChromeOptions())->addArguments([
            '--disable-gpu',
            '--headless',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
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
            User::truncate();

            $this->user = factory(\SQLgreyGUI\Models\User::class)->create([
                'username' => 'admin',
                'email' => 'admin@localhost.local',
            ]);
        }

        return $this->user;
    }
}
