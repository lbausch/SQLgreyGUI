<?php

class OptinController extends \BaseController {

    /**
     * show emails
     *
     * @return Response
     */
    public function showEmails() {
        return View::make('optin.emails');
    }

    /**
     * show domains
     *
     * @return Response
     */
    public function showDomains() {
        return View::make('optin.domains');
    }

}
