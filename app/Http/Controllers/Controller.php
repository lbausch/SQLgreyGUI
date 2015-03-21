<?php

namespace SQLgreyGUI\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Auth,
    App,
    Input,
    Route,
    View;

abstract class Controller extends BaseController
{

    /**
     * the user id
     * 
     * @var int
     */
    protected $userid = 0;

    use DispatchesCommands,
        ValidatesRequests;

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        if (Auth::User() && Auth::User()->getId()) {
            $this->userid = Auth::User()->getId();

            // pass the user object to all views
            View::share('user', Auth::User());
        }
    }

    /**
     * parse provided entries
     * 
     * @return array
     */
    protected function parseEntries($input_identifier, $repository)
    {
        $items_tmp = Input::get($input_identifier, array());

        $items = array();

        $repository = App::make($repository);

        foreach ($items_tmp as $key => $val) {
            $model = json_decode(base64_decode($val, $strict = true), $assoc = true);

            $items[] = $repository->instance($model);
        }

        return $items;
    }

    /**
     * get name of the current controller
     * 
     * @return string
     */
    protected function getController()
    {
        $controller = explode('\\', strtok(Route::currentRouteAction(), '@'));

        return end($controller);
    }

    /**
     * get action
     * 
     * @param string $action
     * 
     * @return string
     */
    public function getAction($action)
    {
        return $this->getController() . '@' . $action;
    }

    /**
     * is ajax request
     * 
     * @return boolean
     */
    protected function isAjax()
    {
        if (Request::ajax()) {
            return true;
        }

        return false;
    }

}
