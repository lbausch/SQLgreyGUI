<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use SQLgreyGUI\Models\AwlEmail;
use SQLgreyGUI\Models\Greylist;
use Tests\DuskTestCase;

class GreylistTest extends DuskTestCase
{
    public function test_greylist_is_displayed()
    {
        Greylist::truncate();
        AwlEmail::truncate();

        $this->browse(function (Browser $browser) {
            $greylisted = factory(\SQLgreyGUI\Models\Greylist::class, 20)->create();

            $browser->loginAs($this->getUser())
                ->visit('#/greylist')
                ->waitUntilMissing('#loader-modal')
                ->screenshot('greylist')
                ->assertSee('This senders have been greylisted recently')
                ->assertSee('Move To Whitelist')
                ->assertSee('Refresh')
                ->assertSee('Delete')
                ->assertSee('Records: '.$greylisted->count());

            foreach ($greylisted as $record) {
                $browser->assertSee($record->getSenderName())
                    ->assertSee($record->getSenderDomain())
                    ->assertSee($record->getSource())
                    ->assertSee($record->getRecipient())
                    ->assertSee($record->getFirstSeen());
            }
        });
    }

    public function test_entries_can_be_deleted()
    {
        Greylist::truncate();
        AwlEmail::truncate();

        $this->browse(function (Browser $browser) {
            $greylisted = factory(\SQLgreyGUI\Models\Greylist::class, 3)->create();

            $browser->loginAs($this->getUser())
                ->visit('#/greylist')
                ->waitUntilMissing('#loader-modal');

            foreach ($greylisted as $record) {
                $browser->assertSeeIn('.table', $record->getSenderName())
                    ->assertSeeIn('.table', $record->getSenderDomain())
                    ->assertSeeIn('.table', $record->getSource())
                    ->assertSeeIn('.table', $record->getRecipient())
                    ->assertSeeIn('.table', $record->getFirstSeen());
            }

            $elements = $browser->elements('.table tbody td input[type=checkbox]');

            foreach ($elements as $element) {
                $element->click();
                $browser->pause(1000);
            }

            $browser->screenshot('greylist_entries_delete_checked')
                ->pause(2000)
                ->click('.greylist-delete-records')
                ->waitUntilMissing('#loader-modal');

            foreach ($greylisted as $record) {
                $browser->assertDontSeeIn('.table', $record->getSenderName())
                    ->assertDontSeeIn('.table', $record->getSenderDomain())
                    ->assertDontSeeIn('.table', $record->getSource())
                    ->assertDontSeeIn('.table', $record->getRecipient())
                    ->assertDontSeeIn('.table', $record->getFirstSeen());
            }
        });
    }

    public function test_entries_can_be_moved_to_whitelist()
    {
        Greylist::truncate();
        AwlEmail::truncate();

        $this->browse(function (Browser $browser) {
            $greylisted = factory(\SQLgreyGUI\Models\Greylist::class, 5)->create();

            $browser->loginAs($this->getUser())
                ->visit('#/greylist')
                ->waitUntilMissing('#loader-modal');

            foreach ($greylisted as $record) {
                $browser->assertSeeIn('.table', $record->getSenderName())
                    ->assertSeeIn('.table', $record->getSenderDomain())
                    ->assertSeeIn('.table', $record->getSource())
                    ->assertSeeIn('.table', $record->getRecipient())
                    ->assertSeeIn('.table', $record->getFirstSeen());
            }

            $elements = $browser->elements('.table tbody td input[type=checkbox]');

            foreach ($elements as $element) {
                $element->click();
            }

            $browser->click('.greylist-move-records-to-whitelist')
                ->waitUntilMissing('#loader-modal');

            foreach ($greylisted as $record) {
                $browser->assertDontSeeIn('.table', $record->getSenderName())
                    ->assertDontSeeIn('.table', $record->getSenderDomain())
                    ->assertDontSeeIn('.table', $record->getSource())
                    ->assertDontSeeIn('.table', $record->getRecipient())
                    ->assertDontSeeIn('.table', $record->getFirstSeen());
            }

            $browser->visit('#/whitelist/emails')
                ->waitUntilMissing('#loader-modal');

            foreach ($greylisted as $record) {
                $browser->assertSeeIn('.table', $record->getSenderName())
                    ->assertSeeIn('.table', $record->getSenderDomain())
                    ->assertSeeIn('.table', $record->getSource())
                    ->assertSeeIn('.table', $record->getFirstSeen());
            }
        });
    }
}
