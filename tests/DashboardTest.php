<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardTest extends TestCase
{
    use DatabaseTransactions;

    protected $connectionsToTransact = [
        'sqlite_sqlgrey',
    ];

    public function test_dashboard_is_displayed()
    {
        $greylist = factory(\SQLgreyGUI\Models\Greylist::class, 9)->create();
        $whitelist_emails = factory(\SQLgreyGUI\Models\AwlEmail::class, 7)->create();
        $whitelist_domains = factory(\SQLgreyGUI\Models\AwlDomain::class, 12)->create();
        $optout_emails = factory(\SQLgreyGUI\Models\OptOutEmail::class, 3)->create();
        $optout_domains = factory(\SQLgreyGUI\Models\OptOutDomain::class, 5)->create();
        $optin_emails = factory(\SQLgreyGUI\Models\OptInEmail::class, 15)->create();
        $optin_domains = factory(\SQLgreyGUI\Models\OptInDomain::class, 17)->create();

        $this->actingAsAdmin()
            ->visit(action('DashboardController@index'))
            ->see('Dashboard')

            // Greylist
            ->see('Greylisted hosts and domains')
            ->see($greylist->count())
            ->see(action('GreylistController@index'))

            // Whitelist
            ->see('Auto-Whitelisted eMails / Domains')
            ->see($whitelist_emails->count())
            ->see($whitelist_domains->count())
            ->see(action('WhitelistController@showEmails'))
            ->see(action('WhitelistController@showDomains'))

            // Opt-out eMails / Domains
            ->see('Opt-out eMails / Domains')
            ->see($optout_emails->count())
            ->see($optout_domains->count())
            ->see(action('OptOutController@showEmails'))
            ->see(action('OptOutController@showDomains'))

            ->see('Opt-in eMails / Domains')
            ->see($optin_emails->count())
            ->see($optin_domains->count())
            ->see(action('OptInController@showEmails'))
            ->see(action('OptInController@showDomains'))

            ->assertViewHasAll([
                'dashboard' => [
                    'greylist' => $greylist->count(),
                    'awl_emails' => $whitelist_emails->count(),
                    'awl_domains' => $whitelist_domains->count(),
                    'optout_emails' => $optout_emails->count(),
                    'optout_domains' => $optout_domains->count(),
                    'optin_emails' => $optin_emails->count(),
                    'optin_domains' => $optin_domains->count(),
                ],
            ]);
    }
}
