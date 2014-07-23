<?php

class OptController extends \BaseController {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        Assets::add('dataTable');
    }

}
