<?php

use Bausch\Repositories\AwlEmailRepositoryInterface;
use Bausch\Repositories\AwlDomainRepositoryInterface;
use Bausch\Models\AwlEmail as Email;
use Bausch\Models\AwlDomain as Domain;

class WhitelistController extends \BaseController {

    /**
     * email repository
     * 
     * @var AwlEmailRepositoryInterface
     */
    private $email_repo;

    /**
     * domain repository
     * 
     * @var AwlDomainRepositoryInterface
     */
    private $domain_repo;

    /**
     * Constructor
     * 
     * @param \Bausch\Repositories\AwlEmailRepositoryInterface $email_repo
     * @param \Bausch\Repositories\AwlDomainRepositoryInterface $domain_repo
     */
    public function __construct(AwlEmailRepositoryInterface $email_repo, AwlDomainRepositoryInterface $domain_repo) {
        parent::__construct();

        $this->email_repo = $email_repo;
        $this->domain_repo = $domain_repo;

        Assets::add('dataTable');
    }

    /**
     * show emails
     *
     * @return Response
     */
    public function showEmails() {
        $emails = $this->email_repo->findAll();

        return View::make('whitelist.emails')
                        ->with('whitelist_emails', $emails);
    }

    /**
     * add email
     * 
     * @return Response
     */
    public function addEmail() {
        $input = Input::all();

        $validator = Validator::make($input, Email::$rules);

        if ($validator->passes()) {
            $new_email = $this->email_repo->instance($input);

            $this->email_repo->store($new_email);

            return Redirect::action('WhitelistController@showEmails')
                            ->withSuccess($new_email->getSenderName() . '@' . $new_email->getSenderDomain() . ' from ' . $new_email->getSource() . ' added');
        }

        return Redirect::action('WhitelistController@showEmails')
                        ->withInput($input)
                        ->withErrors($validator);
    }

    /**
     * delete emails
     * 
     * @return Response
     */
    public function deleteEmails() {
        $items = $this->parseEntries('whitelist_emails', 'Bausch\Repositories\AwlEmailRepositoryInterface');

        $message = array();

        foreach ($items as $key => $val) {
            $this->email_repo->destroy($val);

            $message[] = '<li>' . $val->getSenderName() . '@' . $val->getSenderDomain() . ' from ' . $val->getSource() . '</li>';
        }

        return Redirect::action('WhitelistController@showEmails')
                        ->with('success', 'deleted the following entries:<ul>' . implode(PHP_EOL, $message) . '</ul>');
    }

    /**
     * show domains
     *
     * @return Response
     */
    public function showDomains() {
        $domains = $this->domain_repo->findAll();

        return View::make('whitelist.domains')
                        ->with('whitelist_domains', $domains);
    }

    /**
     * add domain
     * 
     * @return Response
     */
    public function addDomain() {
        $input = Input::all();

        $validator = Validator::make($input, Domain::$rules);

        if ($validator->passes()) {
            $new_domain = $this->domain_repo->instance($input);

            $this->domain_repo->store($new_domain);

            return Redirect::action('WhitelistController@showDomains')
                            ->withSuccess($new_domain->getSenderDomain() . ' from ' . $new_domain->getSource() . ' added');
        }

        return Redirect::action('WhitelistController@showDomains')
                        ->withInput($input)
                        ->withErrors($validator);
    }

    /**
     * delete domains
     * 
     * @return Response
     */
    public function deleteDomains() {
        $items = $this->parseEntries('whitelist_domains', 'Bausch\Repositories\AwlDomainRepositoryInterface');

        $message = array();

        foreach ($items as $key => $val) {
            $this->domain_repo->destroy($val);

            $message[] = '<li>' . $val->getSenderDomain() . ' from ' . $val->getSource() . '</li>';
        }

        return Redirect::action('WhitelistController@showDomains')
                        ->with('success', 'deleted the following entries:<ul>' . implode(PHP_EOL, $message) . '</ul>');
    }

}
