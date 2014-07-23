<?php

class BaseController extends Controller {

    /**
     * the user id
     * 
     * @var int
     */
    protected $userid = 0;

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct() {
        if (Auth::User() && Auth::User()->getId()) {
            $this->userid = Auth::User()->getId();

            // pass the user object to all views
            View::share('user', Auth::User());
        }
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

}
