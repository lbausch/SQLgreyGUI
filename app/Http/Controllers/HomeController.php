<?php

namespace SQLgreyGUI\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Home sweet home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
