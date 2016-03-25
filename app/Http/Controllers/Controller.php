<?php

namespace SQLgreyGUI\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends \Bausch\LaravelCornerstone\Http\Controllers\CornerstoneController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Parse provided entries.
     *
     * @return array
     */
    protected function parseEntries($input_identifier, $repository)
    {
        $items_tmp = request()->input($input_identifier, []);

        $items = [];

        $repository = app($repository);

        foreach ($items_tmp as $key => $val) {
            $model = json_decode(base64_decode($val, $strict = true), $assoc = true);

            $items[] = $repository->instance($model);
        }

        return $items;
    }

    /**
     * Is ajax request?
     *
     * @return bool
     */
    protected function isAjax()
    {
        return request()->ajax();
    }
}
