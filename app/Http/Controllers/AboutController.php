<?php

namespace SQLgreyGUI\Http\Controllers;

class AboutController extends Controller
{

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * index
     *
     * @return Response
     */
    public function index()
    {
        return view('about.index');
    }

}
