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
