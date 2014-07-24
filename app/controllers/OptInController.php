<?php

use Bausch\Repositories\OptInDomainRepositoryInterface;
use Bausch\Repositories\OptInEmailRepositoryInterface;

class OptInController extends \OptController {

    /**
     * Constructor
     *
     * @param Bausch\Repositories\OptInDomainRepositoryInterface $domain_repo
     * @param Bausch\Repositories\OptInEmailRepositoryInterface $email_repo
     */
    public function __construct(OptInDomainRepositoryInterface $domain_repo, OptInEmailRepositoryInterface $email_repo) {
        parent::__construct();

        $this->domain_repo = $domain_repo;
        $this->email_repo = $email_repo;

        $this->template_folder = 'optin';
    }

    /**
     * delete emails
     * 
     * @return Respone
     */
    public function deleteEmails() {
        $items = $this->parseEntries('emails', 'Bausch\Repositories\OptInEmailRepositoryInterface');

        $message = array();

        foreach ($items as $key => $val) {
            $this->email_repo->destroy($val);

            $message[] = '<li>' . $val->getEmail() . '</li>';
        }

        return Redirect::action('OptInController@showEmails')
                        ->with('success', 'deleted the following entries:<ul>' . implode(PHP_EOL, $message) . '</ul>');
    }

    /**
     * delete domains
     * 
     * @return Respone
     */
    public function deleteDomains() {
        $items = $this->parseEntries('domains', 'Bausch\Repositories\OptInDomainRepositoryInterface');

        $message = array();

        foreach ($items as $key => $val) {
            $this->domain_repo->destroy($val);

            $message[] = '<li>' . $val->getDomain() . '</li>';
        }

        return Redirect::action('OptInController@showDomains')
                        ->with('success', 'deleted the following entries:<ul>' . implode(PHP_EOL, $message) . '</ul>');
    }

}
