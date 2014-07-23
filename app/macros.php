<?php

// get the css class for navigation items
HTML::macro('navClass', function($items) {
    if (!is_array($items)) {
        $items = array($items);
    }

    foreach ($items as $item) {
        if (Request::is($item . '/*') XOR Request::is($item)) {
            return "active";
        }

        if ($item == 'dashboard' && Request::is('/')) {
            return 'active';
        }
    }
});

// list emails
HTML::macro('listEmails', function($emails) {
    return View::make('macros.list_emails')
                    ->with('emails', $emails);
});

// list domains
HTML::macro('listDomains', function($domains) {
    return View::make('macros.list_domains')
                    ->with('domains', $domains);
});


// generate identifier
HTML::macro('cvalGreylist', function(\Bausch\Models\Greylist $greylist) {
    $separator = Config::get('sqlgreygui.separator');

    return base64_encode($greylist->getSenderName() . $separator . $greylist->getSenderDomain() . $separator . $greylist->getSource() . $separator . $greylist->getRecipient() . $separator . $greylist->getFirstSeen());
});
