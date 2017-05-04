<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_users_are_displayed()
    {
        $this->browse(function (Browser $browser) {
            $users = factory(\SQLgreyGUI\Models\User::class, 20)->create();

            $browser->loginAs($this->getUser())
                ->visit('#/admin/users')
                ->waitUntilMissing('#loader-modal')
                ->screenshot('users')
                ->assertSee($this->getUser()->getUsername())
                ->assertSee($this->getUser()->getEmail());

            foreach ($users as $record) {
                $browser->assertSee($record->getUsername())
                    ->assertSee($record->getEmail());
            }
        });
    }
}
