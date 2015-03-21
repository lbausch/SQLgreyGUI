<?php

namespace SQLgreyGUI\Http\Controllers;

use Illuminate\Http\Request;

class OptController extends Controller
{

    /**
     * view directory
     * 
     * @var string
     */
    protected $view_directory;

    /**
     * domain repository
     * 
     * @var OptDomainRepositoryInterface
     */
    protected $domains;

    /**
     * email repository
     * 
     * @var OptEmailRepositoryInterface
     */
    protected $emails;

    /**
     * show emails
     *
     * @return Response
     */
    public function showEmails()
    {
        $emails = $this->emails->findAll();

        return view($this->view_directory . '.emails')
                        ->with('emails', $emails);
    }

    /**
     * add email
     * 
     * @return Response
     */
    public function addEmail(Request $req)
    {
        $new_email = $this->emails->instance($req->input());

        $this->validate($req, $new_email->rules);

        $this->emails->store($new_email);

        return redirect(action($this->getAction('showEmails')))
                        ->withSuccess($new_email->getEmail() . ' has been added');
    }

    /**
     * show domains
     *
     * @return Response
     */
    public function showDomains()
    {
        $domains = $this->domains->findAll();

        return view($this->view_directory . '.domains')
                        ->with('domains', $domains);
    }

    /**
     * add domain
     * 
     * @return Response
     */
    public function addDomain(Request $req)
    {
        $new_domain = $this->domains->instance($req->input());

        $this->validate($req, $new_domain->rules);

        $this->domains->store($new_domain);

        return redirect(action($this->getAction('showDomains')))
                        ->withSuccess($new_domain->getDomain() . ' has been added');
    }

}
