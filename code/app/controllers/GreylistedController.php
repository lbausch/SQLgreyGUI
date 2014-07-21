<?php

use Bausch\Repositories\ConnectRepositoryInterface;

class GreylistedController extends \BaseController {

    /**
     * Repository
     * 
     * @var ConnectRepositoryInterface
     */
    private $repo;

    /**
     * Constructor 
     * 
     * @param \Bausch\Repositories\ConnectRepositoryInterface $repo
     */
    public function __construct(ConnectRepositoryInterface $repo) {
        $this->repo = $repo;
        
        Assets::add('dataTables.bootstrap.css');
        Assets::add('jquery.dataTables.js');
        Assets::add('dataTables.bootstrap.js');
    }

    /**
     * index
     *
     * @return Response
     */
    public function index() {
        $data = $this->repo->findAll();

        return View::make('greylisted.index')
                        ->with('greylisted', $data);
    }

}
