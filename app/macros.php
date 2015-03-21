<?php

use Collective\Html\HtmlBuilder as Html;

Html::macro('alert', function($type = 'info', $message) {
    if (!in_array($type, array('success', 'info', 'warning', 'danger'))) {
        return false;
    }

    return View::make('macros.alert-' . $type)
                    ->with('message', $message);
});

// get the css class for navigation items
Html::macro('navClass', function($items) {
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
Html::macro('listEmails', function($emails, $target) {
    return View::make('macros.list_emails')
                    ->with('emails', $emails)
                    ->with('targetController', $target);
});

// list domains
Html::macro('listDomains', function($domains, $target) {
    return View::make('macros.list_domains')
                    ->with('domains', $domains)
                    ->with('targetController', $target);
});

// this basically generates a base64-json-representation of a model
Html::macro('cval', function($model) {
    return base64_encode($model->toJson());
});
