<?php

if (!function_exists('listEmails')) {
    // List Emails
    function listEmails($emails, $target)
    {
        return view('macros.list_emails')
            ->with('emails', $emails)
            ->with('targetController', $target);
    }
}

if (!function_exists('listDomains')) {
    // List Domains
    function listDomains($domains, $target)
    {
        return view('macros.list_domains')
            ->with('domains', $domains)
            ->with('targetController', $target);
    }
}

if (!function_exists('cval')) {
    // this basically generates a base64-json-representation of a model
    function cval($model)
    {
        return base64_encode($model->toJson());
    }
}
