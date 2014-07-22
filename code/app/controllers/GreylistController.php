<?php

use Bausch\Repositories\ConnectRepositoryInterface;

class GreylistController extends \BaseController {

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
        
        Assets::add('dataTable');
    }

    /**
     * index
     *
     * @return Response
     */
    public function index() {
        $data = $this->repo->findAll();

        return View::make('greylist.index')
                        ->with('greylist', $data);
    }

}
