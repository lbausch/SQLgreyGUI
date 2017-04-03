<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DashboardTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_dashboard_is_displayed()
    {
        $this->browse(function (Browser $browser) {
            $greylist = factory(\SQLgreyGUI\Models\Greylist::class, 9)->create();
            $whitelist_emails = factory(\SQLgreyGUI\Models\AwlEmail::class, 7)->create();
            $whitelist_domains = factory(\SQLgreyGUI\Models\AwlDomain::class, 12)->create();
            $optout_emails = factory(\SQLgreyGUI\Models\OptOutEmail::class, 3)->create();
            $optout_domains = factory(\SQLgreyGUI\Models\OptOutDomain::class, 5)->create();
            $optin_emails = factory(\SQLgreyGUI\Models\OptInEmail::class, 15)->create();
            $optin_domains = factory(\SQLgreyGUI\Models\OptInDomain::class, 17)->create();

            $browser->loginAs($this->getUser())
                 ->visit('/')
                ->waitForText($greylist->count())
                ->screenshot('dashboard')
                ->assertSee('Dashboard')

                // Greylist
                ->assertsee('Greylist')
                ->assertSee($greylist->count())
                ->assertSeeLink('View Details')
                ->assertSourceHas('#/greylist')

                // Whitelist
                ->assertSee('Auto-Whitelist')
                ->assertSee($whitelist_emails->count())
                ->assertSee($whitelist_domains->count())
                ->assertSeeLink('View Emails')
                ->assertSourceHas('#/whitelist/emails')
                ->assertSeeLink('View Domains')
                ->assertSourceHas('#/whitelist/domains')

                // Opt-Out Emails / Domains
                ->assertSee('Opt-Out')
                ->assertSee($optout_emails->count())
                ->assertSee($optout_domains->count())
                ->assertSeeLink('View Emails')
                ->assertSourceHas('#/optout/emails')
                ->assertSeeLink('View Domains')
                ->assertSourceHas('#/optout/domains')

                // Opt-Out Emails / Domains
                ->assertSee('Opt-In')
                ->assertSee($optin_emails->count())
                ->assertSee($optin_domains->count())
                ->assertSeeLink('View Emails')
                ->assertSourceHas('#/optin/emails')
                ->assertSeeLink('View Domains')
                ->assertSourceHas('#/optin/domains');
        });
    }
}
