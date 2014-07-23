<?php

class OptController extends \BaseController {

    public function __construct() {
        parent::__construct();
        
        Assets::add('dataTable');
    }

}
