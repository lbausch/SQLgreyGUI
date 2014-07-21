<?php

class WhitelistedController extends \BaseController {

    /**
     * show emails
     *
     * @return Response
     */
    public function showEmails() {
        return View::make('whitelisted.emails');
    }

    /**
     * show domains
     *
     * @return Response
     */
    public function showDomains() {
        return View::make('whitelisted.domains');
    }

}
