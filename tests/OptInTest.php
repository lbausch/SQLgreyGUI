<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class OptInTest extends TestCase
{
    use DatabaseTransactions;

    protected $connectionsToTransact = [
        'sqlite_sqlgrey',
    ];

    public function test_emails_are_displayed()
    {
        $emails = factory(\SQLgreyGUI\Models\OptInEmail::class, 7)->create();

        $this->actingAsAdmin()
            ->visit(action('OptInController@showEmails'));

        foreach ($emails as $email) {
            $this->see($email->getEmail())
                ->see(cval($email));
        }
    }

    public function test_add_email()
    {
        $this->actingAsAdmin()
            ->visit(action('OptInController@showEmails'))
            ->type('foo@bar.baz', 'email')
            ->press('save')
            ->see('foo@bar.baz has been added')
            ->seeInDatabase('optin_email', [
                'email' => 'foo@bar.baz',
            ], 'sqlite_sqlgrey');
    }

    public function test_delete_email()
    {
        $email = factory(\SQLgreyGUI\Models\OptInEmail::class)->create();

        $this->actingAsAdmin()
            ->visit(action('OptInController@showEmails'))
            ->submitForm('delete selected', [
                'emails' => [
                    cval($email),
                ],
            ])
            ->see('deleted the following entries:')
            ->notSeeInDatabase('optin_email', [
                'email' => $email->getEmail(),
            ], 'sqlite_sqlgrey');
    }

    public function test_domains_are_displayed()
    {
        $domains = factory(\SQLgreyGUI\Models\OptInDomain::class, 7)->create();

        $this->actingAsAdmin()
            ->visit(action('OptInController@showDomains'));

        foreach ($domains as $domain) {
            $this->see($domain->getDomain())
                ->see(cval($domain));
        }
    }

    public function test_add_domain()
    {
        $this->actingAsAdmin()
            ->visit(action('OptInController@showDomains'))
            ->type('bar.baz', 'domain')
            ->press('save')
            ->see('bar.baz has been added')
            ->seeInDatabase('optin_domain', [
                'domain' => 'bar.baz',
            ], 'sqlite_sqlgrey');
    }

    public function test_delete_domain()
    {
        $domain = factory(\SQLgreyGUI\Models\OptInDomain::class)->create();

        $this->actingAsAdmin()
            ->visit(action('OptInController@showDomains'))
            ->submitForm('delete selected', [
                'domains' => [
                    cval($domain),
                ],
            ])
            ->see('deleted the following entries:')
            ->notSeeInDatabase('optin_domain', [
                'domain' => $domain->getDomain(),
            ], 'sqlite_sqlgrey');
    }
}
