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
        $items = $this->parseEntries('greylist', 'Bausch\Repositories\GreylistRepositoryInterface');

        $message = array();

        foreach ($items as $key => $val) {
            $this->repo->destroy($val);

            $message[] = '<li>' . $val->getSenderName() . '@' . $val->getSenderDomain() . ' from ' . $val->getSource() . ' for ' . $val->getRecipient() . '</li>';
        }

        return Redirect::action('GreylistController@index')
                        ->with('success', 'deleted the following entries:<ul>' . implode(PHP_EOL, $message) . '</ul>');
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

}
