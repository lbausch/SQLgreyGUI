<?php

namespace SQLgreyGUI\Http\Controllers;

class AboutController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('about.index');
    }
}
