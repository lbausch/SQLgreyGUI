<?php

class AboutController extends \BaseController {

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * index
     *
     * @return Response
     */
    public function index() {
        return View::make('about.index');
    }

}
