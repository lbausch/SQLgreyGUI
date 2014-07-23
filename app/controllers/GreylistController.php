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

    /**
     * delete entries
     * 
     * @return Response
     */
    public function delete() {
        $items = $this->parseEntries();

        foreach ($items as $key => $val) {
            $this->repo->destroy($val);
        }

        return Redirect::action('GreylistController@index')->withSuccess('');
    }

    /**
     * move entries
     * 
     * @return Response
     */
    public function move() {
        $items = $this->parseEntries();

        $whitelist = App::make('Bausch\Repositories\AwlEmailRepositoryInterface');

        foreach ($items as $key => $val) {
            
            // convert Greylist to AwlEmail
            $email = $whitelist->instance(array(
                'sender_name' => $val->getSenderName(),
                'sender_domain' => $val->getSenderDomain(),
                'src' => $val->getSource(),
                'first_seen' => $val->getFirstSeen(),
                'last_seen' => $val->getFirstSeen(),
            ));

            DB::transaction(function() use (&$val, &$email, &$whitelist) {
                // delete from Greylist
                $this->repo->destroy($val);

                // insert into whitelist
                $whitelist->store($email);
            });
        }

        return Redirect::action('GreylistController@index');
    }

    /**
     * parse provided entries
     * 
     * @return array
     */
    private function parseEntries() {
        $items_tmp = Input::get('greylist', array());

        $items = array();

        foreach ($items_tmp as $key => $val) {
            $identifier = explode(Config::get('sqlgreygui.separator'), base64_decode($val, $strict = true));

            if (count($identifier) !== 5) {
                continue;
            }

            $items[] = $this->repo->instance(array(
                'sender_name' => $identifier[0],
                'sender_domain' => $identifier[1],
                'src' => $identifier[2],
                'rcpt' => $identifier[3],
                'first_seen' => $identifier[4],
            ));
        }

        return $items;
    }

}
