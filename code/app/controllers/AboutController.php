<?php

class AboutController extends \BaseController {

    /**
     * index
     *
     * @return Response
     */
    public function index() {
        return View::make('about.index');
    }

}
