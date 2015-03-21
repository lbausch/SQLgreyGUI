<?php

namespace SQLgreyGUI\Http\Controllers;

use Assets,
    Input,
    Redirect,
    Validator,
    View;

class OptController extends Controller
{

    /**
     * template folder
     * 
     * @var string
     */
    protected $template_folder;

    /**
     * domain repository
     * 
     * @var OptDomainRepositoryInterface
     */
    protected $domain_repo;

    /**
     * email repository
     * 
     * @var OptEmailRepositoryInterface
     */
    protected $email_repo;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        Assets::add('dataTables');
    }

    /**
     * show emails
     *
     * @return Response
     */
    public function showEmails()
    {
        $emails = $this->email_repo->findAll();

        return View::make($this->template_folder . '.emails')
                        ->with('emails', $emails);
    }

    /**
     * add email
     * 
     * @return Response
     */
    public function addEmail()
    {
        $input = array(
            'email' => Input::get('email'),
        );

        $new_email = $this->email_repo->instance($input);

        $validator = Validator::make($input, $new_email->rules);

        if ($validator->passes()) {
            $this->email_repo->store($new_email);

            return Redirect::action($this->getAction('showEmails'))
                            ->withSuccess($new_email->getEmail() . ' has been added');
        }

        return Redirect::action($this->getAction('showEmails'))
                        ->withInput()
                        ->withErrors($validator);
    }

    /**
     * show domains
     *
     * @return Response
     */
    public function showDomains()
    {
        $domains = $this->domain_repo->findAll();

        return View::make($this->template_folder . '.domains')
                        ->with('domains', $domains);
    }

    /**
     * add domain
     * 
     * @return Response
     */
    public function addDomain()
    {
        $input = array(
            'domain' => Input::get('domain'),
        );

        $new_domain = $this->domain_repo->instance($input);

        $validator = Validator::make($input, $new_domain->rules);

        if ($validator->passes()) {
            $this->domain_repo->store($new_domain);

            return Redirect::action($this->getAction('showDomains'))
                            ->withSuccess($new_domain->getDomain() . ' has been added');
        }

        return Redirect::action($this->getAction('showDomains'))
                        ->withInput()
                        ->withErrors($validator);
    }

}
