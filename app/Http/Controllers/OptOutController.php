<?php

namespace SQLgreyGUI\Http\Controllers;

use SQLgreyGUI\Repositories\OptOutDomainRepositoryInterface;
use SQLgreyGUI\Repositories\OptOutEmailRepositoryInterface;
use Redirect;

class OptOutController extends OptController
{

    /**
     * Constructor
     *
     * @param OptOutDomainRepositoryInterface $domain_repo
     * @param OptOutEmailRepositoryInterface $email_repo
     */
    public function __construct(OptOutDomainRepositoryInterface $domain_repo, OptOutEmailRepositoryInterface $email_repo)
    {
        parent::__construct();

        $this->domain_repo = $domain_repo;
        $this->email_repo = $email_repo;

        $this->template_folder = 'optout';
    }

    /**
     * delete emails
     * 
     * @return Respone
     */
    public function deleteEmails()
    {
        $items = $this->parseEntries('emails', 'SQLgreyGUI\Repositories\OptOutEmailRepositoryInterface');

        $message = array();

        foreach ($items as $key => $val) {
            $this->email_repo->destroy($val);

            $message[] = '<li>' . $val->getEmail() . '</li>';
        }

        return Redirect::action('OptOutController@showEmails')
                        ->with('success', 'deleted the following entries:<ul>' . implode(PHP_EOL, $message) . '</ul>');
    }

    /**
     * delete domains
     * 
     * @return Respone
     */
    public function deleteDomains()
    {
        $items = $this->parseEntries('domains', 'SQLgreyGUI\Repositories\OptOutDomainRepositoryInterface');

        $message = array();

        foreach ($items as $key => $val) {
            $this->domain_repo->destroy($val);

            $message[] = '<li>' . $val->getDomain() . '</li>';
        }

        return Redirect::action('OptOutController@showDomains')
                        ->with('success', 'deleted the following entries:<ul>' . implode(PHP_EOL, $message) . '</ul>');
    }

}
