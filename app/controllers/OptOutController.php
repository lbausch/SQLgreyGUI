<?php

use Bausch\Repositories\OptOutDomainRepositoryInterface;
use Bausch\Repositories\OptOutEmailRepositoryInterface;

class OptOutController extends \OptController {

    /**
     * domain repository
     * 
     * @var OptOutDomainRepositoryInterface
     */
    private $domain_repo;

    /**
     * email repository
     * 
     * @var OptOutEmailRepositoryInterface
     */
    private $email_repo;

    /**
     * Constructor
     *
     * @param OptOutDomainRepositoryInterface $domain_repo
     * @param OptOutEmailRepositoryInterface $email_repo
     */
    public function __construct(OptOutDomainRepositoryInterface $domain_repo, OptOutEmailRepositoryInterface $email_repo) {
        parent::__construct();

        $this->domain_repo = $domain_repo;
        $this->email_repo = $email_repo;
    }

    /**
     * show emails
     *
     * @return Response
     */
    public function showEmails() {
        $emails = $this->email_repo->findAll();

        return View::make('optout.emails')
                        ->with('emails', $emails);
    }

    /**
     * delete emails
     * 
     * @return Respone
     */
    public function deleteEmails() {
        $items = $this->parseEntries('emails', 'Bausch\Repositories\OptOutEmailRepositoryInterface');

        $message = array();

        foreach ($items as $key => $val) {
            $this->email_repo->destroy($val);

            $message[] = '<li>' . $val->getEmail() . '</li>';
        }

        return Redirect::action('OptOutController@showEmails')
                        ->with('success', 'deleted the following entries:<ul>' . implode(PHP_EOL, $message) . '</ul>');
    }

    /**
     * show domains
     *
     * @return Response
     */
    public function showDomains() {
        $domains = $this->domain_repo->findAll();

        return View::make('optout.domains')
                        ->with('domains', $domains);
    }

    /**
     * delete domains
     * 
     * @return Respone
     */
    public function deleteDomains() {
        $items = $this->parseEntries('domains', 'Bausch\Repositories\OptOutDomainRepositoryInterface');

        $message = array();

        foreach ($items as $key => $val) {
            $this->domain_repo->destroy($val);

            $message[] = '<li>' . $val->getDomain() . '</li>';
        }

        return Redirect::action('OptOutController@showDomains')
                        ->with('success', 'deleted the following entries:<ul>' . implode(PHP_EOL, $message) . '</ul>');
    }

}
