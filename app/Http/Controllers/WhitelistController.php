<?php

namespace SQLgreyGUI\Http\Controllers;

use Illuminate\Http\Request;
use SQLgreyGUI\Repositories\AwlEmailRepositoryInterface as Emails;
use SQLgreyGUI\Repositories\AwlDomainRepositoryInterface as Domains;
use SQLgreyGUI\Models\AwlEmail as Email;
use SQLgreyGUI\Models\AwlDomain as Domain;

class WhitelistController extends Controller
{

    /**
     * email repository
     * 
     * @var Emails
     */
    private $emails;

    /**
     * domain repository
     * 
     * @var Domains
     */
    private $domains;

    /**
     * Constructor
     * 
     * @param Emails $emails
     * @param Domains $domains
     */
    public function __construct(Emails $emails, Domains $domains)
    {
        parent::__construct();

        $this->emails = $emails;
        $this->domains = $domains;
    }

    /**
     * show emails
     *
     * @return Response
     */
    public function showEmails()
    {
        $emails = $this->emails->findAll();

        return view('whitelist.emails')
                        ->with('whitelist_emails', $emails);
    }

    /**
     * add email
     * 
     * @return Response
     */
    public function addEmail(Request $req)
    {
        $this->validate($req, Email::$rules);

        $new_email = $this->emails->instance($req->input());

        $this->emails->store($new_email);

        return redirect(action('WhitelistController@showEmails'))
                        ->withSuccess($new_email->getSenderName() . '@' . $new_email->getSenderDomain() . ' from ' . $new_email->getSource() . ' added');
    }

    /**
     * delete emails
     * 
     * @return Response
     */
    public function deleteEmails()
    {
        $items = $this->parseEntries('whitelist_emails', 'SQLgreyGUI\Repositories\AwlEmailRepositoryInterface');

        $message = [];

        foreach ($items as $key => $val) {
            $this->emails->destroy($val);

            $message[] = '<li>' . $val->getSenderName() . '@' . $val->getSenderDomain() . ' from ' . $val->getSource() . '</li>';
        }

        return redirect(action('WhitelistController@showEmails'))
                        ->withSuccess('deleted the following entries:<ul>' . implode(PHP_EOL, $message) . '</ul>');
    }

    /**
     * show domains
     *
     * @return Response
     */
    public function showDomains()
    {
        $domains = $this->domains->findAll();

        return view('whitelist.domains')
                        ->with('whitelist_domains', $domains);
    }

    /**
     * add domain
     * 
     * @return Response
     */
    public function addDomain(Request $req)
    {
        $this->validate($req, Domain::$rules);

        $new_domain = $this->domains->instance($req->input());

        $this->domains->store($new_domain);

        return redirect(action('WhitelistController@showDomains'))
                        ->withSuccess($new_domain->getSenderDomain() . ' from ' . $new_domain->getSource() . ' added');
    }

    /**
     * delete domains
     * 
     * @return Response
     */
    public function deleteDomains()
    {
        $items = $this->parseEntries('whitelist_domains', 'SQLgreyGUI\Repositories\AwlDomainRepositoryInterface');

        $message = [];

        foreach ($items as $key => $val) {
            $this->domains->destroy($val);

            $message[] = '<li>' . $val->getSenderDomain() . ' from ' . $val->getSource() . '</li>';
        }

        return redirect(action('WhitelistController@showDomains'))
                        ->withSuccess('deleted the following entries:<ul>' . implode(PHP_EOL, $message) . '</ul>');
    }

}
