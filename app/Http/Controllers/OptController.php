<?php

namespace SQLgreyGUI\Http\Controllers;

use Illuminate\Http\Request;

class OptController extends Controller
{
    /**
     * View directory.
     *
     * @var string
     */
    protected $view_directory;

    /**
     * Domain repository.
     *
     * @var OptDomainRepositoryInterface
     */
    protected $domains;

    /**
     * Email repository.
     *
     * @var OptEmailRepositoryInterface
     */
    protected $emails;

    /**
     * Show emails.
     *
     * @return \Illuminate\Http\Response
     */
    public function showEmails()
    {
        $emails = $this->emails->findAll();

        return view($this->view_directory.'.emails')
            ->with('emails', $emails);
    }

    /**
     * Add email.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function addEmail(Request $request)
    {
        $email = $this->emails->instance($request->input());

        $this->validate($request, $email->rules);

        if ($this->emails->findByEmail($email->getEmail())) {
            return redact('_self@showEmails')
                ->withWarning($email->getEmail().' is already present');
        }

        $this->emails->store($email);

        return redact('_self@showEmails')
            ->withSuccess($email->getEmail().' has been added');
    }

    /**
     * Show domains.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDomains()
    {
        $domains = $this->domains->findAll();

        return view($this->view_directory.'.domains')
            ->with('domains', $domains);
    }

    /**
     * Add domain.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function addDomain(Request $request)
    {
        $domain = $this->domains->instance($request->input());

        $this->validate($request, $domain->rules);

        if ($this->domains->findByDomain($domain->getDomain())) {
            return redact('_self@showDomains')
                ->withWarning($domain->getDomain().' is already present');
        }

        $this->domains->store($domain);

        return redact('_self@showDomains')
            ->withSuccess($domain->getDomain().' has been added');
    }
}
