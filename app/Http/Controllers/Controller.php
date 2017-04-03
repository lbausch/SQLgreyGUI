<?php

namespace SQLgreyGUI\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Bausch\LaravelCornerstone\Http\Controllers\CornerstoneController as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
