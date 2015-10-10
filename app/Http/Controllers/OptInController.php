<?php

namespace SQLgreyGUI\Http\Controllers;

use SQLgreyGUI\Repositories\OptInDomainRepositoryInterface as Domains;
use SQLgreyGUI\Repositories\OptInEmailRepositoryInterface as Emails;

class OptInController extends OptController
{
    /**
     * Constructor.
     *
     * @param Domains $domains
     * @param Emails  $emails
     */
    public function __construct(Domains $domains, Emails $emails)
    {
        parent::__construct();

        $this->domains = $domains;
        $this->emails = $emails;

        $this->view_directory = 'optin';
    }

    /**
     * Delete emails.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteEmails()
    {
        $items = $this->parseEntries('emails', \SQLgreyGUI\Repositories\OptInEmailRepositoryInterface::class);

        $message = [];

        foreach ($items as $key => $val) {
            $this->emails->destroy($val);

            $message[] = '<li>'.$val->getEmail().'</li>';
        }

        return redirect(action('OptInController@showEmails'))
            ->withSuccess('deleted the following entries:<ul>'.implode(PHP_EOL, $message).'</ul>');
    }

    /**
     * Delete domains.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteDomains()
    {
        $items = $this->parseEntries('domains', \SQLgreyGUI\Repositories\OptInDomainRepositoryInterface::class);

        $message = [];

        foreach ($items as $key => $val) {
            $this->domains->destroy($val);

            $message[] = '<li>'.$val->getDomain().'</li>';
        }

        return redirect(action('OptInController@showDomains'))
            ->withSuccess('deleted the following entries:<ul>'.implode(PHP_EOL, $message).'</ul>');
    }
}
