<?php

class OptoutController extends \BaseController {

    /**
     * show emails
     *
     * @return Response
     */
    public function showEmails() {
        return View::make('optout.emails');
    }

    /**
     * show domains
     *
     * @return Response
     */
    public function showDomains() {
        return View::make('optout.domains');
    }

}
