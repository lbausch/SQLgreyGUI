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
     * @return \Illuminate\Http\Response
     */
    public function addEmail(Request $req)
    {
        $new_email = $this->emails->instance($req->input());

        $this->validate($req, $new_email->rules);

        $this->emails->store($new_email);

        return redirect(action($this->getAction('showEmails')))
            ->withSuccess($new_email->getEmail().' has been added');
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
     * @return \Illuminate\Http\Response
     */
    public function addDomain(Request $req)
    {
        $new_domain = $this->domains->instance($req->input());

        $this->validate($req, $new_domain->rules);

        $this->domains->store($new_domain);

        return redirect(action($this->getAction('showDomains')))
            ->withSuccess($new_domain->getDomain().' has been added');
    }
}
