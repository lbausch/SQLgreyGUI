<?php

use Bausch\Repositories\GreylistRepositoryInterface;

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
     * @param \Bausch\Repositories\GreylistRepositoryInterface $repo
     */
    public function __construct(GreylistRepositoryInterface $repo) {
        parent::__construct();
        
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
