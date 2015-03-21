<?php

namespace SQLgreyGUI\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{

    use DispatchesCommands,
        ValidatesRequests;

    /**
     * the user id
     * 
     * @var int
     */
    protected $userid;

    /**
     * User
     * 
     * @var \SQLgreyGUI\Models\User
     */
    protected $user;

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        if (\Auth::check()) {
            $this->user = \Auth::User();

            $this->userid = $this->user->getId();

            // pass the user object to all views
            view()->share('user', $this->user);
        }
    }

    /**
     * parse provided entries
     * 
     * @return array
     */
    protected function parseEntries($input_identifier, $repository)
    {
        $items_tmp = Request::input($input_identifier, array());

        $items = array();

        $repository = app($repository);

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
        $controller = explode('\\', strtok(\Route::currentRouteAction(), '@'));

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
        return Request::ajax();
    }

}
