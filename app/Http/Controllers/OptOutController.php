<?php

namespace SQLgreyGUI\Http\Controllers;

use SQLgreyGUI\Repositories\OptOutDomainRepositoryInterface as Domains;
use SQLgreyGUI\Repositories\OptOutEmailRepositoryInterface as Emails;

class OptOutController extends OptController
{

    /**
     * Constructor
     *
     * @param Domains $domains
     * @param Emails $emails
     */
    public function __construct(Domains $domains, Emails $emails)
    {
        parent::__construct();

        $this->domains = $domains;
        $this->emails = $emails;

        $this->view_directory = 'optout';
    }

    /**
     * delete emails
     * 
     * @return Respone
     */
    public function deleteEmails()
    {
        $items = $this->parseEntries('emails', 'SQLgreyGUI\Repositories\OptOutEmailRepositoryInterface');

        $message = [];

        foreach ($items as $key => $val) {
            $this->emails->destroy($val);

            $message[] = '<li>' . $val->getEmail() . '</li>';
        }

        return redirect(action('OptOutController@showEmails'))
                        ->withSuccess('deleted the following entries:<ul>' . implode(PHP_EOL, $message) . '</ul>');
    }

    /**
     * delete domains
     * 
     * @return Respone
     */
    public function deleteDomains()
    {
        $items = $this->parseEntries('domains', 'SQLgreyGUI\Repositories\OptOutDomainRepositoryInterface');

        $message = [];

        foreach ($items as $key => $val) {
            $this->domains->destroy($val);

            $message[] = '<li>' . $val->getDomain() . '</li>';
        }

        return redirect(action('OptOutController@showDomains'))
                        ->withSuccess('deleted the following entries:<ul>' . implode(PHP_EOL, $message) . '</ul>');
    }

}
