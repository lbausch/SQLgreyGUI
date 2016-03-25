<?php

namespace SQLgreyGUI\Http\Controllers;

class AboutController extends Controller
{
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
